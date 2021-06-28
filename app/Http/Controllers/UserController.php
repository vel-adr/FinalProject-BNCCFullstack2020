<?php

namespace App\Http\Controllers;

use File;
use App\User;
use App\Rules\CheckOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'showThread', 'showComment']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $threads = $user->threads;
        $comments = $user->comments;
        $replies = $user->replies;
        
        return view('user.post', compact('user', 'threads', 'comments', 'replies'));
    }

    public function showThread($id)
    {
        $user = User::find($id);
        $threads = $user->threads;
        $comments = $user->comments;
        $replies = $user->replies;
        
        return view('user.thread', compact('user', 'threads', 'comments', 'replies'));
    }

    public function showComment($id)
    {
        $user = User::find($id);
        $threads = $user->threads;
        $comments = $user->comments;
        $replies = $user->replies;
        
        return view('user.comment', compact('user', 'threads', 'comments', 'replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        if(Auth::id() != $id) {
            return redirect('/user/' . Auth::id());
        }
        else{
            $user = User::find($id);

            return view('user.edit', compact('user'));
        }
    }

    public function editPassword(int $id)
    {
        if(Auth::id() != $id) {
            return redirect('/user/' . Auth::id());
        }
        else{
            $user = User::find($id);

            return view('user.editpass', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = User::find($request->id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'photo' => ['mimes:jpeg,jpg,png,svg,gif', 'max:4096'],
            'cover' => ['mimes:jpeg,jpg,png,svg,gif', 'max:4096'],
        ]);

        if($request->email != $user->email){
            $request->validate([
                'email' => 'unique:users'
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if(isset($request->photo)) {
            if($user->photo != 'avatar-png.png'){
                File::delete('img/' . $user->photo);
            }
            $imgName = $request->photo->getClientOriginalName() . '-' .  time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('img'), $imgName);
            $user->photo = $imgName;
        }

        if(isset($request->cover)) {
            if($user->cover != 'bg.jpg'){
                File::delete('img/' . $user->cover);
            }
            $imgName = $request->cover->getClientOriginalName() . '-' .  time() . '.' . $request->cover->extension();
            $request->cover->move(public_path('img'), $imgName);
            $user->cover = $imgName;
            
        }
        $user->save();

        return redirect('/user/' . $request->id);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'oldpassword' => ['string', 'min:8', new CheckOldPassword],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:oldpassword'],
        ]);

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/user/' . $request->id);
    }
}
