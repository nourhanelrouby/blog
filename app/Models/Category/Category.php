<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Category extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;   // 2. To add translation methods
    use SoftDeletes;

    public $translatedAttributes = ['name'];

    protected $fillable = ['image','category_id'];

    public function sub_categories()   // sub_categories
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function parent() // parent
    {
        $this->belongsTo(Category::class, 'category_id', 'id');
    }

}
