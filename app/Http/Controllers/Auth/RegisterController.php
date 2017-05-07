<?php

namespace Smsapp\Http\Controllers\Auth;

use Smsapp\User;
use Smsapp\Lib\ISanitize;
use Illuminate\Http\Request;
use Smsapp\Jobs\SendSmsCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Smsapp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/dashboard';

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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|string|min:10|max:20|unique:users',
            'password' => 'required|min:6|max:30|confirmed',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $phone_number = $request->phone_number;

        //Sanitize Input
        $mrClean = new ISanitize();
        $name = $mrClean->sanitize($name);
        $name = $mrClean->sanitize($name);
        $email = $mrClean->sanitize($email);
        $phone_number = $mrClean->sanitizeNum($phone_number);
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        //Setup Array for Validation
        $data = array('name'=>$name, 'email'=>$email, 'phone_number'=>$phone_number, 'password'=>$password, 'password_confirmation'=>$password_confirmation);

        //Validate Array
        $this->validator($data)->validate();

        //Store the sanitized data in the session
        $request->session()->put('name', $name);
        $request->session()->put('email', $email);
        $request->session()->put('phone_number', $phone_number);
        $request->session()->put('password', bcrypt($password));
        $request->session()->save();

        //Create the verification code
        $rand = random_int(100000, 999999);
        $hash = Hash::make($rand);
        $request->session()->put('pin', $hash);
        $request->session('pin', $hash);
        $request->session()->save();

        dispatch(new SendSmsCode($phone_number, $rand));

        //->with('verify', 'verify') allows the view to check for sesison data
        //and prevent access to the form.
        return redirect('verify-registration')->with('verify', 'verify');
    }


    /**
     * Check if the code if correct before creating a User
     *
     * @param Request $request
     */
    public function smsAuth(Request $request)
    {
        //Does the code verify?
        $sessionHash = $request->session()->get('pin');
        $answer = $request->code;
        if (Hash::check($answer, $sessionHash)) {

            //Prevent multiple submissions
            $phone_number = $request->session()->get('phone_number');
            if (User::where('phone_number', $phone_number)->exists()) {
                $errors = ['code' => 'You already have an account.'];
                return back()->withErrors($errors);
            }

            //Create User and login
            event(new Registered($user = $this->create($request)));
            $this->guard()->login($user);
            return $this->registered($request, $user)
                          ?: redirect($this->redirectPath());
        } else {
            $result = 'The code you entered is invalid.';
            return view('auth.verify', compact('result'));
        }
    }


    /**
     * Create the User
     *
     * @param Request $request
     */
    protected function create(Request $request)
    {
        return User::create([
            'name' => $request->session()->get('name'),
            'email' => $request->session()->get('email'),
            'phone_number' => $request->session()->get('phone_number'),
            'password' => $request->session()->get('password'),
        ]);
    }
}
