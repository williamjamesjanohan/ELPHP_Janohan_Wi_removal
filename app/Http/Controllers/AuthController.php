<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * Register api.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api.
     */
    public function login(Request $request): JsonResponse
    {

      $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string',
      ]);

      if ($validator->fails()) {
        return $this->sendError('Validation Error.', $validator->errors());
      }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User logged in successfully.');
        }

        return $this->sendError('Invalid credentials.', ['error' => 'Unauthorised']);
    }
    /**
     * Unauthorized redirected to login.
     */
    public function loginRedirected(): JsonResponse
    {
        return $this->sendError('Unauthorized, please login.', ['error' => 'Unauthorised']);
    }

    /**
     * Logout api.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user(); // Get the authenticated user
        $user->tokens()->delete(); // Revoke all tokens for the user

        $response = [
            'success' => true,
            'message' => 'User logged out successfully.',
        ];

        return response()->json($response, 200);
    }
}
