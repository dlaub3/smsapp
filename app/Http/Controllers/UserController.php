<?php

namespace Smsapp\Http\Controllers;

use Smsapp\User;
use Smsapp\GroupsUser;
use Smsapp\Lib\ISanitize;
use Smsapp\Jobs\SendSmsCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return view('user.profile', compact('user'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
          'name' => 'string|min:2|max:255',
          'phone_number' => 'string|min:10|max:20|unique:users',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();
        //Get the form data
        $name = $request->name;
        $phone_number = $request->phone_number;

        //Sanitize data
        $mrClean = new ISanitize();
        $name = $mrClean->sanitize($name);
        $phone_number = $mrClean->sanitizeNum($phone_number);

        //Perform Update Logic
        if ($phone_number === $user->phone_number && $name === $user->name) {
            //If nothing has changed, do nothing
            return back();
        } elseif ($phone_number === $user->phone_number) {
            //If only the name has changed update the name
            $data = array('name' => $name);
            $this->validator($data)->validate();
            $user->update($data);
            return back();
        } else {
            $data = array('name' => $name, 'phone_number' => $phone_number);
            $this->validator($data)->validate();
            //If the name is new update the name
            if ($name != $user->name) {
                $data = array('name' => $name);
                $user->update($data);
            }
            //Send code to update number
            $this->updateNum($request, $phone_number);
            return redirect('profile/update/verifycode');
        }
    }

    public function verify(Request $request)
    {
        $result = '';
        $user = $request->user();
        return view('sms.admin-verify', compact('result', 'user'));
    }

    /**
     * Sanitize input and send verification code
     *
     * @param Request $request
     * @param mixed $id
     */
    public function updateNum($request, $phone_number)
    {
        //store the phone_number for smsVerify
        $request->session()->put('phone_number', $phone_number);
        $request->session()->save();

        //Setup the verification code
        $rand = random_int(100000, 999999);
        $hash = Hash::make($rand);
        $request->session()->put('pin', $hash);
        $request->session('pin', $hash);
        $request->session()->save();

        dispatch(new SendSmsCode($phone_number, $rand));
    }

    /**
     * Verify code and create group user
     *
     * @param Request $request
     * @param GroupsUser $groupsuser
     */
    public function smsVerify(Request $request)
    {
        $user = $request->user();

        //Does the code verify?
        $sessionHash = $request->session()->get('pin');
        $answer = $request->code;
        if (Hash::check($answer, $sessionHash)) {
            $phone_number = $request->session()->get('phone_number');
            //Update the phone number
            $user->update([
                'phone_number' => $phone_number,
            ]);

            //Update the users number throughout the database
            GroupsUser::where('phone_number', $user->phone_number)->update(['phone_number' => $phone_number]);

            return redirect('profile');
        } else {
            $result = 'The code you entered is invalid.';
            return view('sms.admin-verify', compact('result', 'user'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->user()->delete();
        return redirect('/');
    }
}
