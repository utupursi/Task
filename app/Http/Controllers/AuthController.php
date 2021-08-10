<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Models\User;
use App\Models\UserToken;
use App\Repositories\AuthRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Psy\Util\Json;


class AuthController extends Controller
{
    /**
     * @var AuthRepositoryInterface
     */
    protected $authRepository;

    /**
     * @param AuthRepositoryInterface $authRepository
     */
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Authenticate login user.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $rules = ['email' => 'required|string', 'password' => 'required|string'];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 422);
        }

        return $this->authRepository->login($request);
    }

    /**
     *  Register user.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */

    public function register(Request $request)
    {
        $rules = ['name' => 'required|string', 'email' => 'required|string|unique:users', 'password' => 'required|string'];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'message' => $validator->messages()], 422);
        }

        return $this->authRepository->register($request);
    }


}
