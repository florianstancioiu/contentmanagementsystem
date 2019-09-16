<?php

namespace Client\Controllers;

use Common\Controller;
use Common\Models\Drink;

class DrinksController extends Controller
{
    public function index()
    {
        $search_keyword = request('search_keyword');
        $drinks = Drink
            ::select('title', 'slug')
            ::where('id', '>', 1)
            ::where('title', 'LIKE', "%$search_keyword%")
            ::paginate(1);

        return view('client/drinks/index', compact('drinks'));
    }

    public function show(string $slug)
    {
        $drink = Drink::find($slug);

        return view('client/drinks/show', compact('drink'));
    }
}
