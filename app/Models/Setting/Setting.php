<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Setting extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;  // 2. To add translation methods


    public $translatedAttributes = ['name', 'content','address'];
    protected $fillable = ['logo','favicon','facebook',
        'instagram','twitter','linkedin','phone','email'];
}
