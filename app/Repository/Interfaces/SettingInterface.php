<?php

namespace App\Repository\Interfaces;

interface SettingInterface
{
    public function index();

    public function update($request, $setting);
}
