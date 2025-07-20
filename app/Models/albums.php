<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Images;

class Albums extends Model
{
    //use HasFactory;

    protected $fillable = ['name', 'description'];

    public function images()
    {
        return $this->hasMany(Images::class);
    }
}
