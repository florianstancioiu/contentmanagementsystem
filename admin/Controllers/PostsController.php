<?php

namespace Admin\Controllers;

use Common\Controller;
use Admin\Models\Post;
use Exception;

class PostsController extends Controller
{
    public function index()
    {
        $this->checkAuth();

        $base_url = base_url();
        $posts = Post::get();
        $post = isset($posts[0]) ? $posts[0] : [];

        return view('admin/posts/index', compact('base_url', 'posts', 'post'));
    }

    public function create()
    {
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/posts/create', compact('base_url'));
    }

    public function edit($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        $post = Post::find($id);

        return view('admin/posts/edit', compact('base_url', 'post'));
    }

    public function store()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

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

    public function update()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

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

    public function destroy($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        try {
            Post::destroy((int) $id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/posts');
    }
}