<?php

namespace Client\Controllers;

use Common\Controller;

class HomeController extends Controller
{
    public function homepage()
    {
        $user = 'stuff';

        return view('client/common/home', compact('user'));
    }
}
