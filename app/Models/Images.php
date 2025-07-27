<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Albums;

class Images extends Model
{
    //use HasFactory;

    protected $fillable = ['albums_id', 'image_path', 'caption'];

    public function albums()
    {
        return $this->belongsTo(Albums::class);
    }
}
