<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'body', 'published', 'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title . '-' . Str::random(6));
        });
    }
    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

}
