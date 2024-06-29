<?php

namespace App\Http\Controllers;

use App\Http\Enums\GroupUserRole;
use App\Http\Enums\GroupUserStatus;
use App\Http\Requests\InviteUsersRequest;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\GroupUser;
use App\Notifications\InvitationApproved;
use App\Notifications\InvitationInGroup;
use App\Notifications\RequestApproved;
use App\Notifications\RequestToJoinGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile(Group $group)
    {
        $group->load('currentUserGroup');

        $users = $group->approvedUsers()->orderBy('name')->get();
        $requests = $group->pendingUsers()->orderBy('name')->get();

        return Inertia::render('Group/View', [
            'success' => session('success'),
            'group' => new GroupResource($group),
            'users' => UserResource::collection($users),
            'requests' => UserResource::collection($requests)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $group = Group::create($data);

        $groupUserData = [
            'status' => GroupUserStatus::APPROVED->value,
            'role_group' => GroupUserRole::ADMIN->value,
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'created_by' => Auth::id()
        ];

        GroupUser::create($groupUserData);
        $group->status = $groupUserData['status'];
        $group->role_group = $groupUserData['role_group'];

        return response(new GroupResource($group), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function updateImage(Request $request, Group $group)
    {
        if (!$group->isAdminGroup(Auth::id())) {
            return response("Permission denied", 403);
        }

        $data = $request->validate([
            'cover' => ['nullable', 'image'],
            'thumbnail' => ['nullable', 'image']
        ]);

        $cover = $data['cover'] ?? null;
        $thumbnail = $data['thumbnail'] ?? null;

        $success = '';

        if ($cover) {
            if ($group->cover_path) {
                Storage::disk('public')->delete($group->cover_path);
            }
            $path = $cover->store('group-'.$group->id, 'public');
            $group->update(['cover_path' => $path]);
            $success = 'Cover updated';
        }

        if ($thumbnail) {
            if ($group->thumbnail_path) {
                Storage::disk('public')->delete($group->thumbnail_path);
            }
            $path = $thumbnail->store('group-'.$group->id, 'public');
            $group->update(['thumbnail_path' => $path]);
            $success = 'Thumbnail updated';
        }

        // session('succes', 'Cover Updated');

        return back()->with('success', $success);
    }

    public function inviteUsers(InviteUsersRequest $request, Group $group)
    {
        $data = $request->validated();
        $user = $request->user;
        $groupUser = $request->groupUser;

        if ($groupUser) {
            $groupUser->delete();
        }

        $hours = 24;
        $token = Str::random(255);

        GroupUser::create([
            'status' => GroupUserStatus::PENDING->value,
            'role_group'=> GroupUserRole::USER->value,
            'token' => $token,
            'token_expired' => Carbon::now()->addHours($hours),
            'user_id' => $user->id,
            'group_id' => $group->id,
            'created_by' => Auth::id(),
        ]);

        $user->notify(new InvitationInGroup($group, $hours, $token));

        return back()->with('success', 'User was invited');
    }

    public function approveInvitation (string $token)
    {
        $groupUser = GroupUser::query()
            ->where('token', $token)
            ->first();

        $errorTitle = '';

        if (!$groupUser) {
            $errorTitle = 'The link invalid';
        } else if ($groupUser->token_used || $groupUser->status === GroupUserStatus::APPROVED->value) {
            $errorTitle = 'The link was already used';
        } else if ($groupUser->token_expired < Carbon::now()) {
            $errorTitle = 'The link was expired';
        }

        if ($errorTitle) {
            return \inertia('Error', compact('errorTitle'));
        }

        $groupUser->status = GroupUserStatus::APPROVED->value;
        $groupUser->token_used = Carbon::now();
        $groupUser->save();

        $adminUser = $groupUser->adminUser;

        $adminUser->notify(new InvitationApproved($groupUser->group, $groupUser->user));

        return redirect(route('group.profile', $groupUser->group))
            ->with('success', 'You accepted to join group "'.$groupUser->group->name.'"');
    }

    public function join(Group $group)
    {
        $user = \request()->user();
        $status = GroupUserStatus::APPROVED->value;
        $successMessage = 'You have join group "'.$group->name.'"';

        if (!$group->auto_approval) {
            $status = GroupUserStatus::PENDING->value;
            // send email

            Notification::send($group->adminUsers, new RequestToJoinGroup($group, $user));
            $successMessage = 'Your request join group has been accepted';
        }

        GroupUser::create([
            'status' => $status,
            'role_group'=> GroupUserRole::USER->value,
            'user_id' => $user->id,
            'group_id' => $group->id,
            'created_by' => $user->id,
        ]);

        return back()->with('success', $successMessage);
    }

    public function approveRequest(Request $request, Group $group)
    {
        if (!$group->isAdminGroup(Auth::id())) {
            return response("Permission denied", 403);
        }

        $data = $request->validate([
            'user_id' => ['required'],
            'action' => ['required']
        ]);

        $groupUser = GroupUser::where('user_id', $data['user_id'])
            ->where('group_id', $group->id)
            ->where('status', GroupUserStatus::PENDING->value)
            ->first();

        if ($groupUser) {
            $approved = false;
            if ($data['action'] === 'approve') {
                $approved = true;
                $groupUser->status = GroupUserStatus::APPROVED->value;
            } else {
                $groupUser->status = GroupUserStatus::REJECTED->value;
            }

            $groupUser->save();

            $user = $groupUser->user;
            $user->notify(new RequestApproved($groupUser->group, $user, $approved));

            return back()->with('success', 'User "'.$user->name.'" was '.($approved ? 'approved' : 'rejected'));
        }

        return back();
    }
}
