<?php

namespace App\Models\Post;

use App\Models\Category\Category;
use App\Models\Tag\Tag;
use App\Models\User;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;   // 2. To add translation methods
    // use SoftDeletes;

    public $translatedAttributes = ['title', 'small_description','content'];
    protected $fillable = ['image', 'user_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }
}
