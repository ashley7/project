<?php

namespace App\Http\Controllers\Auth;

use App\ApiLog;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Spatie\Permission\Models\Role;
use Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function api_login(Request $request)
    {
        //log login requests
        $request_array = json_encode($_POST);
        ApiLog::create([
            'request' => $request_array,
            'request_header' => $request,
        ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'wrong username or password',
                'success' => false,
            ]);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('crs_token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $user_data = array(
            'id' => $user->id,
            'surname' => $user->surname,
            'othername' => $user->othername,
            'photo' => $user->photo,
            'email' => $user->email,
        );

        $token->save();
        return response()->json([
            'message' => 'Login successfull',
            'success' => true,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'data' => $user_data,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ]);
    }
    public function reset_password(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);
        // check if the user exits
        $find = User::where('email', $request->input('username'))
            ->Orwhere('phone_number', $request->input('username'))->count();
        if ($find <= 0) {
            return response()->json(
                [
                    'message' => 'You have provided wrong credentials!',
                    'success' => false,
                ]
            );
        }
        //send sms with new password
        return response()->json(['message' => 'New password has been sent to your phone number', 'success' => true]);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {

        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);

        // try {
        //     $user = Socialite::driver('google')->user();
        // } catch (\Exception $e) {
        //     return redirect('/login');
        // }
        // // only allow people with @company.com to login
        // if (explode("@", $user->email)[1] !== 'gmail.com') {
        //     return redirect()->to('/');
        // }
        // // check if they're an existing user
        // $existingUser = User::where('email', $user->email)->first();
        // if ($existingUser) {
        //     //update user info
        //     User::where('id', $existingUser->id)->update([
        //         'google_id' => $user->id,
        //         'api_token' => $user->token,
        //         'avatar' => $user->avatar,
        //         'avatar_original' => $user->avatar_original,
        //     ]);
        //     // log them in
        //     auth()->login($existingUser, true);
        // } else {
        //     // create a new user
        //     $newUser = new User;
        //     $newUser->name = $user->name;
        //     $newUser->email = $user->email;
        //     $newUser->google_id = $user->id;
        //     $newUser->avatar = $user->avatar;
        //     $newUser->avatar_original = $user->avatar_original;
        //     $newUser->save();
        //     auth()->login($newUser, true);
        // }
        // return redirect()->to('/home');
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }
        $name = explode(" ", $user->name);

        $password = $this->generateRandomString(6);
        $user = User::create([
            'surname' => $name[0],
            'othername' => $name[1],
            'email' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'password' => Hash::make($password),
        ]);
        $role = Role::where('name', 'guest')->pluck('name')->all();
        $user->assignRole($role);
        return $user;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
