<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
