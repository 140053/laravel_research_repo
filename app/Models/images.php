<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Albums;

class Images extends Model
{
    //use HasFactory;

    protected $fillable = ['album_id', 'image_path'];

    public function albums()
    {
        return $this->belongsTo(Albums::class);
    }
}
