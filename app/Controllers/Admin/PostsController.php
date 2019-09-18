<?php

namespace App\Controllers\Admin;

use Common\Controller;
use App\Models\Post;
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
        $posts = Post::paginate();

        return view('admin/posts/index', compact('posts'));
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

    // TODO: Validate request either
    // by creating a validate method in the base Controller class (quicker)
    // or by doing the whole dependency container thingy (takes a lot of time)
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
