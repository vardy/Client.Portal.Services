<?php

namespace App\Http\Controllers;

use App\Files;
use App\Quotations;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Display page to edit user and resources of user.
    // GET
    public function edit($userID)
    {
        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin','pm']);
        } else {
            return redirect('/login');
        }

        $user = User::find($userID);
        $roles = $user->roles;
        $quotations = $user->quotations;
        $files = $user->files;

        return view('admin.edit_user', [
            'user' => $user,
            'roles' => $roles,
            'quotations' => $quotations,
            'files' => $files
        ]);
    }

    // Edit a user's quote
    // GET
    public function editQuote($userId, $quoteId, Request $request)
    {
        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin','pm']);
        } else {
            return redirect('/login');
        }

        $request->session()->put('from-admin', 'true');
        $request->session()->put('user-was-editing', $userId);

        return view('admin.edit_user_quote', [
            'user' => User::findOrFail($userId),
            'quote' => Quotations::findOrFail($quoteId)
        ]);
    }

    // Edit a user's file
    // GET
    public function editFile($userId, $fileId, Request $request)
    {
        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin','pm']);
        } else {
            return redirect('/login');
        }

        $request->session()->put('from-admin', 'true');
        $request->session()->put('user-was-editing', $userId);

        return view('admin.edit_user_file', [
            'user' => User::findOrFail($userId),
            'file' => Files::findOrFail($fileId)
        ]);
    }

    // Display form to create a new quote for the given user
    // GET
    public function createQuote($userId, Request $request)
    {
        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin','pm']);
        } else {
            return redirect('/login');
        }

        $request->session()->put('from-admin', 'true');
        $request->session()->put('user-was-editing', $userId);

        return view('admin.create_user_quote', [
            'user' => User::findOrFail($userId)
        ]);
    }


    // Display form to create new file for the given user
    // GET
    public function createFile($userId, Request $request)
    {
        if(auth()->user()) {
            auth()->user()->authorizeRoles(['admin','pm']);
        } else {
            return redirect('/login');
        }

        $request->session()->put('from-admin', 'true');
        $request->session()->put('user-was-editing', $userId);

        return view('admin.create_user_file', [
            'user' => User::findOrFail($userId)
        ]);
    }

    public function addRoles($user_id, Request $request) {
        $user = User::findOrFail($user_id);

        if($request->admin_role) {
            $user->roles()->attach(Role::where('name','admin')->first());
        }

        if($request->pm_role) {
            $user->roles()->attach(Role::where('name','pm')->first());
        }

        if($request->user_role) {
            $user->roles()->attach(Role::where('name','user')->first());
        }

        $user->save();

        return redirect()->back()->with([
            'success-message' => 'Successfully updated user\'s roles.'
        ]);
    }

    public function removeRoles($user_id, Request $request) {
        $user = User::findOrFail($user_id);

        if($request->admin_role) {
            $user->roles()->detach(Role::where('name','admin')->first());
        }

        if($request->pm_role) {
            $user->roles()->detach(Role::where('name','pm')->first());
        }

        if($request->user_role) {
            $user->roles()->detach(Role::where('name','user')->first());
        }

        $user->save();

        return redirect()->back()->with([
            'success-message' => 'Successfully updated user\'s roles.'
        ]);
    }
}