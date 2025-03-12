<?php
namespace App\Http\Controllers\API;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'email' => 'email|required|exists:users',
            'password' => 'required'
        ],[
            'email.exists' => "This Email is not registered, Please enter valid Email Address"
        ]);

        if ($validator->fails()) {
            return CommonHelper::responseErrorWithData($validator->errors(), "Fill the all required fields", 200);
        }

        $user = User::where('email', request()->email)->first();

        if(!$user){
            return CommonHelper::responseError('Admins User is not register with this email address!', 200);
        }

        if (!Hash::check(request()->password, $user->password)) {
            return CommonHelper::responseError('Email/Password is wrong!', 200);
        }

        /*if ($user->status == 0) {
            return CommonHelper::responseError('Your account is deactivated!', 200);
        }*/

        Auth::login($user);

        $access = $user->createToken('authToken');

        $accessToken = $access->plainTextToken;

        $response = ['user' => $user, 'access_token' => $accessToken];
        return CommonHelper::responseSuccessWithData($response, "Login Successfully");
    }

    public function logout (Request $request)
    {

        $user = $request->user();
        if ($user) {
            $user->tokens()->delete(); // Revoke all tokens
        }
        return CommonHelper::responseSuccess('You have been successfully logged out!', 200);

    }

    public function notLogin(Request $request){
        return CommonHelper::responseError('Unauthorized', 200);
    }

    public function getLoginUserDetails(Request $request){
        if(Auth::check()) {
            //$user_id = $request->user('sanctum')->id;
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            return CommonHelper::responseWithData($user, $user->count(), 200);
        }else{
            return CommonHelper::responseError('Unauthorized', 200);
        }
    }

}
