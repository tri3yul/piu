<?php

namespace App\Http\Controllers;

use App\Http\Enums\GroupUserRole;
use App\Http\Enums\GroupUserStatus;
use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile(Group $group)
    {
        $group->load('currentUserGroup');

        return Inertia::render('Group/View', [
            'success' => session('success'),
            'group' => new GroupResource($group),
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
}
