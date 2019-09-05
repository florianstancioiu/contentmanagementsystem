<?php

namespace Admin\Controllers;

use Common\Controller;
use Admin\Models\User;

class UsersController extends Controller
{
	public function index()
    {
				// TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();
        $users = User::get();
        $user = $users[0];

        return view('admin/users/index', compact('base_url', 'users', 'user'));
    }

    public function create()
    {
				// TODO: Check auth automatically
        $this->checkAuth();

        $base_url = base_url();

        return view('admin/users/create', compact('base_url'));
    }

    public function edit($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();
        $base_url = base_url();
        $user = User::find($id);

        return view('admin/users/edit', compact('base_url', 'user'));
    }

    public function store()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        if (! filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
            throw new Exception('The email input you provided must be valid');
        }

        $data = [
            ':first_name' => request('first_name'),
            ':last_name' => request('last_name'),
            ':email' => request('email'),
            ':password' => password_hash(post('password'), PASSWORD_BCRYPT)
        ];

        try {
            User::store($data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/users');
    }

    public function update()
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        if (! filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
            throw new Exception('The email input you provided must be valid');
        }

        if (! User::emailExistsInDatabase()) {
            throw new Exception("The email doesn't exists in the database");
        }

        $data = [
            ':first_name' => request('first_name'),
            ':last_name' => request('last_name'),
            ':email' => request('email'),
            ':password' => password_hash(post('password'), PASSWORD_BCRYPT)
        ];

        try {
            User::update((int) request('user_id'), $data);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/users');
    }

    public function destroy($id)
    {
        // TODO: Check auth automatically
        $this->checkAuth();

        try {
            User::destroy((int) $id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/users');
    }
}
