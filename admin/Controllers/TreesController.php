<?php

namespace Admin\Controllers;

use Common\Controller;
use Admin\Models\Tree;
use Exception;

class TreesController extends Controller
{
    public function index()
    {
        $this->checkAuth();

        $base_url = base_url();
        $trees = Tree::get();
        $tree = isset($trees[0]) ? $trees[0] : [];

        return view('admin/trees/index', compact('base_url', 'trees', 'tree'));
    }

    public function create()
    {
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/trees/create', compact('base_url'));
    }

    public function edit($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        $tree = Tree::find($id);

        return view('admin/trees/edit', compact('base_url', 'tree'));
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
            Tree::store($data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
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
            Tree::update((int) request('tree_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }

    public function destroy($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        try {
            Tree::destroy((int) $id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }
}
