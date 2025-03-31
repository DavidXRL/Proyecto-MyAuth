<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('posts/index',[
            'posts' => Post::with('user')->latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'message'=> ['required','min:8'],
        // ]);





        //VALIDACIONES
        $dataValidates = $request->validate([
            'message' => ['required', 'min:8', 'max:255'],
        ]);


        // $message = request('message');

        //     // 'message' => $message,
        //     'message'=>$request->get('message'),
        //     'user_id'=>auth()->id(),


        //Genera un registro a través de una relación hasmany
        // primero accediendo al user desde el request, luego al post desde user y finalmente
        // a create desde post, ahora solo pasar los datos
        @dump($dataValidates);
        $request -> user()->posts()->create($dataValidates);
        // ([
        //     'message' => $request->get('message'),
        // ]);
        return to_route('posts.index')-> with('status', __('Post created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        // if(auth()->user()->id != $post->user_id){
        //     abort(403);
        // }
        $this->authorize('update', $post);


        // return view('post/edit', compact('post'));
        return view('posts/edit',[
            'post'=> $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        // if(auth()->user()->id != $post->user_id){
        //     abort(403);
        // }

        $this->authorize('update', $post);

        $dataValidates = $request->validate([
            'message' => ['required', 'min:8', 'max:255'],
        ]);

        $post->update($dataValidates);

        return to_route('posts.index')-> with('status', __('Post updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post ->delete();
        return to_route('posts.index')-> with('status', __('Post deleted successfully!'));
    }
}
