<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::find($id);

        return view('user.edit', compact('user'));
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
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->photo)) {
            File::delete('img/' . $user->photo);
            $imgName = $request->photo->getClientOriginalName() . '-' .  time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('img'), $imgName);
            $user->photo = $imgName;
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
