<?php

namespace App\Models;

use App\Traits\ScopeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory,ScopeFilter;

    protected $fillable = [
        'title',
        'path',
    ];

    public $timestamps = false;

    //Get all image comments
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getFilterScopes(): array
    {
        return [
            'id' => [
                'hasParam' => true,
                'scopeMethod' => 'id'
            ],
            'title' => [
                'hasParam' => true,
                'scopeMethod' => 'title'
            ]
        ];
    }
}
