<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/u/{user:username}', [ProfileController::class, 'index'])
    ->name('profile');

Route::get('/g/{group:slug}', [GroupController::class, 'profile'])
    ->name('group.profile');


Route::get('/group/approve-invitation/{token}', [GroupController::class, 'approveInvitation'])->name('group.approveInvitation');

Route::middleware('auth')->group(function () {
    Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.updateImages');

    Route::post('/group/update-image/{group:slug}', [GroupController::class, 'updateImage'])->name('group.updateImages');

    Route::post('/group/invite/{group:slug}', [GroupController::class, 'inviteUsers'])->name('group.inviteUsers');

    Route::post('/group/join/{group:slug}', [GroupController::class, 'join'])->name('group.join');

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     //posts
     Route::post('/post', [PostController::class, 'store'])->name('post.create');
     Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
     Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
     Route::get('/post/download/{attachment}', [PostController::class, 'downloadAttachment'])->name('post.download');
     Route::post('/post/{post}/reaction', [PostController::class, 'postReaction'])->name('post.reaction');

     //groups
     Route::post('/group', [GroupController::class, 'store'])->name('group.create');
});

require __DIR__.'/auth.php';
