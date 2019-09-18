<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ValidateCredentials;
use App\Http\Requests\ValidatePassword;
use App\Models\User;
use App\Http\Controllers\Controller;

class JWTAuthController extends Controller
{
    /**
     * User model.
     *
     * @var User
     */
    private $user;

    /**
     * Create a new AuthController instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->middleware('auth:api', ['except' => ['login']]);

        $this->user = $user;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param ValidateCredentials $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(ValidateCredentials $request)
    {
        
        $credentials = $request->validated();

        if (!$token = auth()->attempt($credentials)) {
            return $this->sendFailedLoginResponse();
        }

        $this->user = auth()->user();

        return $this->sendLoginResponse($token, $this->user);
    }

    /**
     * Update user's password.
     *
     * @param ValidatePassword $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function updatePassword(ValidatePassword $request)
//    {
//        $validated = $request->validated();
//
//        $this->user = auth()->user();
//
//        $credential = [
//            'email' => $this->user->email,
//            'password' => $validated['old_password']
//        ];
//
//        if (auth()->validate($credential)) {
//            $this->user->update([
//                'password' => bcrypt($validated['new_password'])
//            ]);
//
//            return $this->sendUpdatePasswordResponse();
//        } else {
//            return $this->sendFailedLoginResponse();
//        }
//    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'authenticate' => true,
            'message' => 'Successfully Logged Out'
        ], 200);
    }

    /**
     * Send success change password response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendUpdatePasswordResponse()
    {
        return response()->json([
            'message' => 'Successfully Update Password'
        ], 200);
    }

    /**
     * Send success login response.
     *
     * @param string $token
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse($token, User $user)
    {
        return response()->json([
            'authenticate' => true,
            'access_token' => $token,
        ], 200);
    }

    /**
     * Send failed login response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse()
    {
        return response()->json([
            'message' => 'Invalid Credentials'
        ], 401);
    }
}
