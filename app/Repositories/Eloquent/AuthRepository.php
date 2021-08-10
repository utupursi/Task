<?php

namespace App\Repositories\Eloquent;

use App\Http\Request\LoginRequest;
use App\Http\Request\RegisterRequest;
use App\Models\User;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
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
        $credentials = [
            'email' => $request->post('email'),
            'password' => $request->post('password'),
        ];


        $user = $this->model->where(['email' => $credentials['email']])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {

            return response()->json([
                'success' => 'false',
                'message' => 'Bad credentials'
            ], 401);
        }
        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json([
            'success' => 'true',
            'message' => 'You are successfully log in',
            'token' => $token
        ]);
    }

    /**
     * Register user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $model = $this->model->create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $model->createToken('user_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'success' => 'true',
            'message' => 'User was successfully created',
        ]);

    }

}
