<?php

namespace Admin\Controllers;

use Common\Controller;
use Common\Models\Post;
use \Exception;

class PostsController extends Controller
{
    protected static $auth_methods = [
        'index',
        'create',
        'edit',
        'store',
        'update',
        'destroy'
    ];

    protected function index()
    {
        $posts = Post::get();
        $post = isset($posts[0]) ? $posts[0] : [];

        return view('admin/posts/index', compact('posts', 'post'));
    }

    protected function create()
    {
        return view('admin/posts/create');
    }

    protected function edit($id)
    {
        $post = Post::find($id);

        return view('admin/posts/edit', compact('post'));
    }

    protected function store()
    {
        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':lang' => request('lang'),
            ':content' => request('content'),
            ':description' => request('description'),
            ':user_id' => $_SESSION['user']['id']
        ];

        try {
            Post::store($data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/posts');
    }

    protected function update()
    {
        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':lang' => request('lang'),
            ':content' => request('content'),
            ':description' => request('description'),
            ':user_id' => $_SESSION['user']['id']
        ];

        try {
            Post::update((int) request('post_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/posts');
    }

    protected function destroy(int $id)
    {
        try {
            Post::destroy($id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/posts');
    }
}
