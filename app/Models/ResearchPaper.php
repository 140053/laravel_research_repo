<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchPaper extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'authors',
        'editors',
        'tm',
        'type',
        'publisher',
        'isbn',
        'abstract',
        'year',
        'department',
        'pdf_path',
        'external_link',
    ];
    

    protected $casts = [
        'year' => 'integer',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getTagsStringAttribute(): string
    {
        return $this->tags->pluck('name')->implode(', ');
    }

}
