<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchPaper extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'authors',
        'editors',
        'tm',
        'type',
        'publisher',
        'citation',
        'isbn',
        'abstract',
        'year',
        'department',
        'pdf_path',
        'external_link',
        'keyword',
        'status',
        'restricted',
    ];
    

    protected $casts = [
        'year' => 'integer',
        'status' => 'boolean',
        'restricted' => 'boolean',
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
