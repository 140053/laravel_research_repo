<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    //use HasFactory;

    protected $fillable = ['path'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}