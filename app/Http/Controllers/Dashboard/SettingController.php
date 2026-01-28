<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingUpdateRequest;
use App\Models\Setting\Setting;
use App\Repository\Interfaces\SettingInterface;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $setting;

    public function __construct(SettingInterface $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
        $setting = $this->setting->index();
        $title = 'Settings';
        return view('dashboard.settings.index',
            compact('setting', 'title'));
    }

    public function update(SettingUpdateRequest $request)
    {
        $setting = Setting::first();
        $this->setting->update($request, $setting);
        return redirect()->back()->with('success', 'Setting updated successfully');
    }
}
