<?php

namespace App\Controllers\Admin;

use Common\File;
use Common\Controller;
use App\Models\Vegetable;
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
        $vegetables = Vegetable::paginate();

        return view('admin/vegetables/index', compact('vegetables'));
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

    // TODO: Validate request either
    // by creating a validate method in the base Controller class (quicker)
    // or by doing the whole dependency container thingy (takes a lot of time)
    protected function store()
    {
        // TODO: update the $data array without having an ugly if statement
        // TODO: unlink existing $image file
        $image_location = File::storeImage('image');

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

        if (is_array($_FILES['image'])) {
            $data[':image'] = $image_location;
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
        // TODO: unlink existing $image file
        $image_location = File::storeImage('image');

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

        if (file_error_ok('image')) {
            $data[':image'] = $image_location;
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
