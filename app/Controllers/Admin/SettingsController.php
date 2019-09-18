<?php

namespace App\Controllers\Admin;

use Common\Controller;
use App\Models\Setting;

class SettingsController extends Controller
{
    protected function index()
    {
        $settings = Setting::get();

        return view('admin/settings/index', compact('settings'));
    }

    protected function update()
    {

    }

    protected function createSetting()
    {
        return view('admin/settings/create');
    }

    protected function storeSetting()
    {

    }

    protected function destroySetting()
    {

    }
}
