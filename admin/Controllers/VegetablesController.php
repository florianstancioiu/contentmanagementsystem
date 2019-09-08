<?php

namespace Admin\Controllers;

use Common\File;
use Common\Controller;
use Common\Models\Vegetable;
use Exception;

class VegetablesController extends Controller
{
    public function index()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        $vegetables = Vegetable::get();
        $vegetable = isset($vegetables[0]) ? $vegetables[0] : [];

        return view('admin/vegetables/index', compact('base_url', 'vegetables', 'vegetable'));
    }

    public function create()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/vegetables/create', compact('base_url'));
    }

    public function edit($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        $vegetable = Vegetable::find($id);

        return view('admin/vegetables/edit', compact('base_url', 'vegetable'));
    }

    public function store()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

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

    public function update()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

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

        // TODO: unlink existing $picture file

        try {
            Vegetable::update((int) request('vegetable_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/vegetables');
    }

    public function destroy($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        try {
            Vegetable::destroy((int) $id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/vegetables');
    }
}
