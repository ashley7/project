<?php

namespace App\Http\Controllers\Auth;

use AfricasTalking\SDK\AfricasTalking;
use App\Http\Controllers\Controller;
use App\Notifications\UserRegisteredSuccessfully;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $sms;
    protected $username;
    protected $apiKey;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->username = 'abertnamanya'; // use 'sandbox' for development in the test environment
        $this->apiKey = '8e8453f347b95c7965a8ae3559123760b524a68165b50f2e719633a8e2eef745'; // use your sandbox app API key for development in the test environment
        $AT = new AfricasTalking($this->username, $this->apiKey);
        // Get one of the services
        $this->sms = $AT->sms();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $name = explode(" ", $data['name']);
        $gender = '';
        if ($data['gender'] == "other") {
            $gender = $data['other_gender'];
        } else {
            $gender = $data['gender'];
        }
        $user = User::create([
            'surname' => $name[0],
            'othername' => $name[1],
            'gender' => $gender,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->notify(new UserRegisteredSuccessfully($user));

        $role = Role::where('name', 'guest')->pluck('name')->all();
        $user->assignRole($role);
        return $user;
    }

    public function generateCode($limit)
    {
        $code = 0;
        for ($i = 0; $i < $limit; $i++) {$code .= mt_rand(0, 9);}
        return $code;
    }

}
