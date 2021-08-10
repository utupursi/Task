<?php

namespace App\Repositories\Eloquent;

use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Models\Image;
use App\Models\User;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ImageRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{

    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes = [])
    {

        $image = $this->model->create([
            'title' => $attributes['title'],
            'path' => $attributes['path'],
        ]);

        if ($image) {
            return response()->json([
                'success' => 'true',
                'message' => 'Image was successfully created',
            ]);
        }
        return response()->json([
            'success' => 'false',
            'message' => 'Image was not created',
        ]);

    }


    public function addComment(Request $request)
    {
        $image = $this->model->find($request['image_id']);
        if ($image) {

            $image->comments()->create([
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
            'message' => 'image was not found'
        ]);

    }

}
