<?php

namespace App\Repository;



use App\Models\Setting\Setting;
use App\Repository\Interfaces\SettingInterface;
use Illuminate\Support\Facades\Storage;

class SettingRepository implements SettingInterface
{

    public function index()
    {
        $setting = Setting::first();
        return $setting;
    }

    public function update($request, $setting)
    {

        $validated = $request->validated();
        if ($request->hasFile('logo')) {
            // Delete Old Logo
            if ($setting && $setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $validated['logo'] = $request->file('logo')->store('setting', 'public');
        }
        if ($request->hasFile('favicon')) {
            // Delete Old Favicon
            if ($setting && $setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('setting', 'public');
        }
        if($setting == null){
            $setting = Setting::create($validated);
        }else{
            $setting->update($validated);
        }
        multiLanguageSave($setting, $validated);
    }
}
