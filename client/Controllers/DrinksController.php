<?php

namespace Client\Controllers;

use Common\Controller;
use Common\Models\Drink;

class DrinksController extends Controller
{
    public function index()
    {
        $drinks = Drink::paginate();
        $search_keyword = request('search_keyword');

        return view('client/drinks/index', compact('drinks'));
    }

    public function show(string $slug)
    {
        $drink = Drink::find($slug);

        return view('client/drinks/show', compact('drink'));
    }
}