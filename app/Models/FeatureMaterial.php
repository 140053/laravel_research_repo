<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureMaterial extends Model
{
    protected $table = 'feature_materials';

    protected $fillable = [
        'name',
        'description',
        'url',
        'file',
        'type',
        'hidden',
        'location',
    ];

    protected $casts = [
        'hidden' => 'boolean',
        'type' => 'string',
        'location' => 'string',
    ];
}
