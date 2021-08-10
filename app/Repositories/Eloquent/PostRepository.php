<?php

namespace App\Repositories\Eloquent;

use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\PostRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes = [])
    {
        $image = Image::find($attributes['image_id']);
        if (!$image) {
            return response()->json([
                'success' => 'true',
                'message' => 'Image was not found',
            ]);
        }

        $post = $this->model->create([
            'text' => $attributes['text'],
            'image' => $image ? $image->id : null
        ]);
        if ($post) {
            return response()->json([
                'success' => 'true',
                'message' => 'Post was successfully created',
            ]);
        }
        return response()->json([
            'success' => 'false',
            'message' => 'Post was not created',
        ]);

    }

    public function addComment(Request $request)
    {
        $post = $this->model->find($request['post_id']);
        if ($post) {

            $post->comments()->create([
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
            'message' => 'post was not found'
        ]);

    }
}
