<?php

namespace App\Models\Tag;

use App\Models\Post\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Tag extends Model implements  TranslatableContract
{
    use HasFactory;
    use Translatable;

    // 2. To add translation methods

    public $translatedAttributes = ['title'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'post_id', 'tag_id');
    }
}
