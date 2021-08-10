<?php

namespace App\Repositories\Eloquent;

use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Models\Blog;
use App\Models\Image;
use App\Models\User;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{

    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes = [])
    {
        $image = Image::find($attributes['image_id']);
        if(!$image){
            return response()->json([
                'success' => 'true',
                'message' => 'Image was not found',
            ]);
        }
        $blog = $this->model->create([
            'title' => $attributes['title'],
            'text' => $attributes['text'],
            'image' => $image ? $image->id : null
        ]);

        if ($blog) {
            return response()->json([
                'success' => 'true',
                'message' => 'Blog was successfully created',
            ]);
        }
        return response()->json([
            'success' => 'false',
            'message' => 'Blog was not created',
        ]);

    }

    public function addComment(Request $request)
    {
        $blog = $this->model->find($request['blog_id']);
        if ($blog) {

            $blog->comments()->create([
                'text' => $request['text'],
                'rate' => $request['rate']
            ]);

            return response()->json([
                'success' => 'true',
                'message' => 'comment was successfully added'
            ]);
        }

        return response()->json([
            'success' => 'false',
            'message' => 'blog was not found'
        ]);

    }


}
