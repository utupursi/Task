<?php

namespace App\Models;

use App\Traits\ScopeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,ScopeFilter;

    protected $fillable = [
        'text',
        'image'
    ];

    public $timestamps=false;

    //Get all post comments
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
            'text' => [
                'hasParam' => true,
                'scopeMethod' => 'text'
            ]
        ];
    }
}
