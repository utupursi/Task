<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Models\Blog;
use App\Models\User;
use App\Models\UserToken;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\BlogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Psy\Util\Json;


class BlogController extends Controller
{
    /**
     * @var BlogRepositoryInterface
     */
    protected $blogRepository;

    /**
     * @param BlogRepositoryInterface $blogRepository
     */
    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->blogRepository->getData($request, ['comments:commentable_id,rate']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $rules = ['title' => 'required|string', 'text' => 'required|string', 'image_id' => 'required'];
        $data = $request->only(['title', 'text', 'image_id']);
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 422);
        }
        return $this->blogRepository->create($data);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addBlogComment(Request $request)
    {
        $rules = ['text' => 'required|string', 'rate' => 'required|numeric|max:5', 'blog_id' => 'required|numeric'];
        $validator = Validator::make($request->only(['text', 'rate', 'blog_id']), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 422);
        }
        return $this->blogRepository->addComment($request);
    }

}
