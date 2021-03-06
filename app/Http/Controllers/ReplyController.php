<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'reply' => 'required|max:255'
        ]);

        Reply::create($request->all());

        $url = '/thread' . '/' . $request->thread_id;
        return redirect($url);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $reply = Reply::find($request->id);

        $reply->reply = $request->reply;
        $reply->save();
        return redirect('/thread' . '/' . $request->thread_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $reply
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        $reply = Reply::find($id);

        $reply->delete();

        return redirect('/thread' . '/' . $request->thread_id);
    }
}
