<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['post_id','locale', 'title','small_description','content'];
    public $timestamps = false;
}
