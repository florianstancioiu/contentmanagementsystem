<?php

namespace Client\Controllers;

use Common\Controller;
use Common\Models\Fruit;

class FruitsController extends Controller
{
    public function index()
    {
        $fruits = Fruit::paginate();
        $search_keyword = request('search_keyword');

        return view('client/fruits/index', compact('fruits'));
    }

    public function show(string $slug)
    {
        $fruit = Fruit::find($slug);

        return view('client/fruits/show', compact('fruit'));
    }
}
