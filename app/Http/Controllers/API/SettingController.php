<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingUpdateRequest;
use App\Http\Resources\Setting\SettingListResource;
use App\Models\Setting\Setting;
use App\Repository\Interfaces\SettingInterface;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    private $settingInterface;

    public function __construct(SettingInterface $settingInterface)
    {
        $this->settingInterface = $settingInterface;
    }
    public function index()
    {
        $settings = Setting::first();

        if (empty($settings)) {  
            return successResponse([], 'No Data Found!', 200);
        }

        $settings = new SettingListResource($settings);

        return successResponse($settings, 'Settings retrieved successfully!');
    }


    public function update(SettingUpdateRequest $request)
    {
        $setting = Setting::first();
        $this->settingInterface->update($request, $setting);
        return successResponse([], 'Setting Updated Successfully!', 200);
    }
}
