<?php

namespace Admin\Controllers;

use Common\Controller;
use Common\Models\User;
use \Exception;

class UsersController extends Controller
{
    protected static $auth_methods = [
        'index',
        'create',
        'edit',
        'store',
        'update',
        'destroy'
    ];

    protected function index()
    {
        $users = User::paginate();

        return view('admin/users/index', compact('users'));
    }

    protected function create()
    {
        return view('admin/users/create');
    }

    protected function edit($id)
    {
        $user = User::find($id);

        return view('admin/users/edit', compact('user'));
    }

    // TODO: Validate request either
    // by creating a validate method in the base Controller class (quicker)
    // or by doing the whole dependency container thingy (takes a lot of time)
    protected function store()
    {
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

    protected function update()
    {
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

    protected function destroy(int $id)
    {
        try {
            User::destroy($id);
        } catch (Exception $exception) {
            dd('Exception message:' . $exception->getMessage());
        }

        redirect('/admin/users');
    }
}
