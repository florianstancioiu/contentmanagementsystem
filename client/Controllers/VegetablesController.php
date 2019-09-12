<?php

namespace Client\Controllers;

use Common\Controller;
use Common\Models\Vegetable;

class VegetablesController extends Controller
{
    public function index()
    {
        $vegetables = Vegetable::paginate();
        $search_keyword = request('search_keyword');

        return view('client/vegetables/index', compact('vegetables'));
    }

    public function show(string $slug)
    {
        $vegetable = Vegetable::find($slug);

        return view('client/vegetables/show', compact('vegetable'));
    }
}
