<?php

namespace Admin\Controllers;

use Common\Controller;
use Admin\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $this->checkAuth();

        $base_url = base_url();
        $posts = Post::get();
        $post = $posts[0];

        return view('admin/posts/index', compact('base_url', 'posts', 'post'));
    }

    public function create()
    {
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/posts/create', compact('base_url'));
    }
}