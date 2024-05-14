<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }
    public function store(Request $request)
    {
        $setting = Setting::first();

        if ($setting) {
            // Update existing settings
            $setting->update([
                'website_name' => $request->input('website_name'),
                'website_url' => $request->input('website_url'),
                'page_title' => $request->input('title'), // Assuming 'title' field maps to 'page_title' in the database
                'meta_keyword' => $request->input('meta_keyword'),
                'meta_description' => $request->input('meta_description'),
                'address' => $request->input('address'),
                'phone1' => $request->input('phone1'),
                'phone2' => $request->input('phone2'),
                'email1' => $request->input('email1'),
                'email2' => $request->input('email2'),
                'facebook' => $request->input('facebook'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
                'youtube' => $request->input('youtube')
            ]);
            return redirect()->back()->with('message', 'Settings Updated');
        } else {
            // Create new settings
            Setting::create([
                'website_name' => $request->input('website_name'),
                'website_url' => $request->input('website_url'),
                'page_title' => $request->input('title'), // Assuming 'title' field maps to 'page_title' in the database
                'meta_keyword' => $request->input('meta_keyword'),
                'meta_description' => $request->input('meta_description'),
                'address' => $request->input('address'),
                'phone1' => $request->input('phone1'),
                'phone2' => $request->input('phone2'),
                'email1' => $request->input('email1'),
                'email2' => $request->input('email2'),
                'facebook' => $request->input('facebook'),
                'twitter' => $request->input('twitter'),
                'instagram' => $request->input('instagram'),
                'youtube' => $request->input('youtube')
            ]);
            return redirect()->back()->with('message', 'Settings Created');
        }
    }
}
