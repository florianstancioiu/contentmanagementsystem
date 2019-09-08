<?php

namespace Admin\Controllers;

use Common\Controller;
use Admin\Models\Tree;
use Common\File;
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

        $picture_location = File::storeImage('picture');

        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':has_fruits' => request('has_fruits'),
            ':has_flowers' => request('has_flowers'),
            ':introduction' => request('introduction'),
            ':description' => request('description'),
            ':fruit_title' => request('fruit_title'),
            ':colour' => request('colour'),
            ':growth_location' => request('growth_location'),
            ':ripe_season' => request('ripe_season'),
            ':average_years' => request('average_years'),
            ':average_height' => request('average_height'),
            ':average_width' => request('average_width'),
            ':user_id' => $_SESSION['user']['id']
        ];

        if (file_error_ok('picture')) {
            $data[':picture'] = $picture_location;
        }

        // TODO: store image file
        // to be continued

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

        $picture_location = File::storeImage('picture');

        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':has_fruits' => request('has_fruits'),
            ':has_flowers' => request('has_flowers'),
            ':introduction' => request('introduction'),
            ':description' => request('description'),
            ':fruit_title' => request('fruit_title'),
            ':colour' => request('colour'),
            ':growth_location' => request('growth_location'),
            ':ripe_season' => request('ripe_season'),
            ':average_years' => request('average_years'),
            ':average_height' => request('average_height'),
            ':average_width' => request('average_width'),
            ':user_id' => $_SESSION['user']['id']
        ];

        if (file_error_ok('picture')) {
            $data[':picture'] = $picture_location;
        }

        // TODO: store image file
        // to be continued

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
