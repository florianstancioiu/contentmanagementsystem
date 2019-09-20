<?php

namespace App\Controllers\Admin;

use Common\Controller;
use App\Models\Setting;
use Common\File;

class SettingsController extends Controller
{
    protected static $auth_methods = [
        'index',
        'update',
        'createSetting',
        'storeSetting',
        'destroySetting'
    ];

    protected function index()
    {
        $settings = Setting::get();

        return view('admin/settings/index', compact('settings'));
    }

    // TODO: Figure out why the update works whenever the form wants
    protected function update()
    {
        $settings = request('setting');
        $images = isset($_FILES['setting']) && sizeof($_FILES['setting']) > 0 ? $_FILES['setting'] : [];

        foreach ($settings as $title => $setting) {
            Setting::where('title', '=', $title)
                ::update(['value' => $setting]);
        }

        // Save images on the filesystem
        // TODO: Remove existing file after storing the new one on the filesystem
        foreach ($images['name'] as $title => $value) {
            if (empty($value)) {
                continue;
            }

            // Remove existing image from storage
            $existing_image = Setting::select('value')
                ::where('title', '=', $title)
                ::first();

            // dd($existing_image, (int) is_file($existing_image['value']));

            if (isset($existing_image['value'])) {
                File::remove($existing_image['value']);
            }

            // Store the (new) image on the filesystem
            $image_name = File::storeImage("setting.$title", 'settings');

            Setting::where('title', '=', $title)
                ::update(['value' => $image_name]);
        }

        return redirect('admin/settings');
    }

    protected function createSetting()
    {
        return view('admin/settings/create');
    }

    protected function storeSetting()
    {

    }

    protected function editSetting(string $slug)
    {
        $setting = Setting::find($slug);

        return view('admin/settings/edit', compact('slug'));
    }

    protected function updateSetting(string $slug)
    {

    }

    // TODO: Return a custom Object to be used later on in the flow (optimization)
    protected function destroySetting(string $slug)
    {
        $setting = Setting::where('slug', '=', $slug)::get();

        if ((int) $setting['is_restricted'] === 1) {
            return redirect_with_errors('admin/settings', "The {$setting['display_title']} setting is restricted from deletion");
        }

        try {
            Setting::where('slug', '=', $slug)::delete();
        } catch (\Exception $exception) {
            return redirect_with_errors('admin/settings', $exception->getMessage());
        }

        return redirect('admin/settings');
    }
}
