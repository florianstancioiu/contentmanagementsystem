<?php

namespace Admin\Controllers;

use Common\File;
use Common\Controller;
use Common\Models\Vegetable;
use \Exception;

class VegetablesController extends Controller
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
        $vegetables = Vegetable::get();
        $vegetable = isset($vegetables[0]) ? $vegetables[0] : [];

        return view('admin/vegetables/index', compact('vegetables', 'vegetable'));
    }

    protected function create()
    {
        return view('admin/vegetables/create');
    }

    protected function edit(int $id)
    {
        $vegetable = Vegetable::find($id);

        return view('admin/vegetables/edit', compact('vegetable'));
    }

    protected function store()
    {
        // TODO: update the $data array without having an ugly if statement
        // TODO: unlink existing $picture file
        $picture_location = File::storeImage('picture');

        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':has_flowers' => request('has_flowers'),
            ':introduction' => request('introduction'),
            ':description' => request('description'),
            ':colour' => request('colour'),
            ':growth_location' => request('growth_location'),
            ':ripe_season' => request('ripe_season'),
            ':average_years' => request('average_years'),
            ':average_height' => request('average_height'),
            ':average_width' => request('average_width'),
            ':user_id' => $_SESSION['user']['id']
        ];

        if (is_array($_FILES['picture'])) {
            $data[':picture'] = $picture_location;
        }

        try {
            Vegetable::store($data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/vegetables');
    }

    protected function update()
    {
        // TODO: update the $data array without having an ugly if statement
        // TODO: unlink existing $picture file
        $picture_location = File::storeImage('picture');

        $data = [
            ':title' => request('title'),
            ':slug' => request('slug'),
            ':has_flowers' => request('has_flowers'),
            ':introduction' => request('introduction'),
            ':description' => request('description'),
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

        try {
            Vegetable::update((int) request('vegetable_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/vegetables');
    }

    protected function destroy(int $id)
    {
        try {
            Vegetable::destroy($id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/vegetables');
    }
}
