<?php

namespace App\Controllers\Client;

use Common\Controller;
use App\DbLayers\Fruit;

class FruitsController extends Controller
{
    public function index()
    {
        $fruits = Fruit::paginate();

        return view('client/fruits/index', compact('fruits'));
    }

    public function show(string $slug)
    {
        $fruit = Fruit::find($slug);

        return view('client/fruits/show', compact('fruit'));
    }
}
