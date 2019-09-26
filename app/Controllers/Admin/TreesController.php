<?php

namespace App\Controllers\Admin;

use Common\File;
use Common\Controller;
use App\DbLayers\Tree;
use \Exception;

class TreesController extends Controller
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
        $trees = Tree::paginate();

        return view('admin/trees/index', compact('trees'));
    }

    protected function create()
    {
        return view('admin/trees/create');
    }

    protected function edit($id)
    {
        $tree = Tree::find($id);

        return view('admin/trees/edit', compact('tree'));
    }

    // TODO: Validate request either
    // by creating a validate method in the base Controller class (quicker)
    // or by doing the whole dependency container thingy (takes a lot of time)
    protected function store()
    {
        $image_location = File::storeImage('image');

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

        if (file_error_ok('image')) {
            $data[':image'] = $image_location;
        }

        try {
            Tree::store($data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }

    protected function update()
    {
        $image_location = File::storeImage('image');

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

        if (file_error_ok('image')) {
            $data[':image'] = $image_location;
        }

        try {
            Tree::update((int) request('tree_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }

    protected function destroy(int $id)
    {
        try {
            Tree::destroy($id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/trees');
    }
}
