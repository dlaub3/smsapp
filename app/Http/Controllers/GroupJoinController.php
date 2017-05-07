<?php

namespace Smsapp\Http\Controllers;

use Smsapp\Group;
use Smsapp\GroupsUser;
use Smsapp\Lib\ISanitize;
use Smsapp\Jobs\SendSmsCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Smsapp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GroupJoinController extends Controller
{

    /**
     * Get the form to join a group
     *
     * @param Group $group
     */
    public function getFrom(Group $group)
    {
        return view('search.form', compact('group'));
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
            'name' => 'required|string|min:3|max:255',
            'phone_number' => 'required|string|min:10|max:20',
        ]);
    }

    /**
     * Sanitize input and send verification code
     *
     * @param Request $request
     * @param mixed $id
     */
    public function sendCode(Request $request, $id)
    {
        //Get the form data
        $name = $request->name;
        $phone_number = $request->phone_number;

        //Sanitize data
        $mrClean = new ISanitize();
        $name = $mrClean->sanitize($name);
        $name = $mrClean->sanitize($name);
        $phone_number = $mrClean->sanitizeNum($phone_number);

        //First check if the number has alread been used.
        $group = new Group();
        $group = $group->find($id);
        if ($group->groupUsers()->where('phone_number', $phone_number)->exists()) {
            $errors = ['phone_number' => 'This number is already a member.'];
            return back()->withErrors($errors);
        }

        //Setup data for Validation
        $data = array('name' => $name, 'phone_number' => $phone_number);

        //Validate data
        $this->validator($data)->validate();

        //Setup the form data in the session
        $request->session()->put('phone_number', $phone_number);
        $request->session()->put('name', $name);
        $request->session()->put('group_id', $id);
        $request->session()->save();

        //Setup the random verification code
        $rand = random_int(100000, 999999);
        $hash = Hash::make($rand);
        $request->session()->put('pin', $hash);
        $request->session('pin', $hash);
        $request->session()->save();

        dispatch(new SendSmsCode($phone_number, $rand));
        $result = '';
        return redirect('join/verifycode');
    }

    /**
     * Verify code and create group user
     *
     * @param Request $request
     * @param GroupsUser $groupsuser
     */
    public function smsVerify(Request $request, GroupsUser $groupsUser)
    {
        //Does the code verify?
        $sessionHash = $request->session()->get('pin');
        $answer = $request->code;
        if (Hash::check($answer, $sessionHash)) {

            //Prevent Multiple Signups using the back Buttons
            $group = Group::find($request->session()->get('group_id'));
            $phone_number = $request->session()->get('phone_number');
            if ($group->groupUsers()->where('phone_number', $phone_number)->exists()) {
                $errors = ['code' => 'You have already joined this group.'];
                return back()->withErrors($errors);
            }

            $groupsUser->create([
                'name' => $request->session()->get('name'),
                'phone_number' => $request->session()->get('phone_number'),
                'group_id' => $request->session()->get('group_id'),
                'is_admin_approved' => 0,
            ]);
            //->with('success', 1) allows the view to check for sesison data
            //and prevent access to the form.
            return redirect('join/success')->with('success', 1);
        } else {
            $result = 'The code you entered is invalid.';
            return view('sms.verify', compact('result'));
        }
    }
}
