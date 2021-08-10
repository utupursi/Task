<?php

namespace App\Repositories;

use App\Http\Request\LoginRequest;

use App\Http\Request\RegisterRequest;
use Illuminate\Http\Request;

interface BlogRepositoryInterface
{
    public function create(array $attributes = []);
    public function addComment(Request $request);

}
