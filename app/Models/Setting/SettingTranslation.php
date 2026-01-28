<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'content', 'address', 'setting_id', 'locale'];

    public $timestamps = false;

}
