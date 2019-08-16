<?php

namespace Common;

class Controller
{
    public function checkAuth()
    {
        $data = [
            'message' => 'You have to login in order to use the website'
        ];

        if (! is_logged_in()) {
            redirect('/signin', $data);
        }
    }

    public function redirectAdmin()
    {
        if (is_logged_in()) {
            redirect('/admin');
        }
    }
}