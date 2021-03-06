<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'agreement' => 'required',
            'screen_name' => 'required|string|max:15|regex:/^[a-zA-Z0-9_]+$/|unique:users',
            'name' => 'required|string|max:20',
            'email' => 'sometimes|nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $array = 'abcdefghijkl';
        $rand_alpha = $array[rand(0, strlen($array) - 1)];

        return User::create([
            'screen_name' => $data['screen_name'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'profile_image' => 'monster/monster_' . $rand_alpha,
        ]);
    }

    // アカウント登録成功時にアラートを表示
    protected function registered(Request $request, $user)
    {
        return redirect('/')->with('status', __('messages.nav_regstered', ['screen_name' => $user->screen_name]));
    }
}
