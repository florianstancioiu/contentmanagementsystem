<?php

namespace Client\Controllers;

use Common\Controller;

class FrontendController extends Controller
{
    public function home()
    {
        $user = 'stuff';

        return view('client/common/home', compact('user'));
    }

    public function about()
    {
        $user = 'stuff';

        return view('client/common/about', compact('user'));
    }

    public function showContact()
    {
        $user = 'stuff';

        return view('client/common/contact', compact('user'));
    }

    public function contact()
    {
        // TODO: send email
    }

    public function showLogin()
    {
        $user = 'stuff';

        return view('client/auth/login', compact('user'));
    }

    public function login()
    {
        // TODO: implement post request
    }

    public function showRegister()
    {
        $user = 'stuff';

        return view('client/auth/register', compact('user'));
    }

    public function register()
    {
        // TODO: implement post request
    }
}
