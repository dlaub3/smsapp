<?php

namespace Smsapp\Http\Controllers;

use Smsapp\Group;
use Smsapp\GroupsUser;
use Smsapp\Lib\ISanitize;
use Illuminate\Http\Request;
use Smsapp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GroupsUserController extends Controller
{

    /**
     * Display the users information for editing
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GroupsUser $groupsUser)
    {
        //You can only edit your users
        $this->authorize('crud', $groupsUser);
        //$backUrl, easily navigate back to the group
        //this is used in the view groups.edit-user
        //$backUrl is set in GroupController show()
        $backUrl = $request->session()->get('backUrl');
        return view('groups.edit-user', compact('groupsUser', 'backUrl'));
    }

    /**
     * Store a new user in the database
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        //You can only add users to your own group
        $this->authorize('crud', $group);

        //Get the form data
        $name = $request->name;
        $phone_number = $request->phone_number;

        //Sanitize data
        $mrClean = new ISanitize();
        $name = $mrClean->sanitize($name);
        $phone_number = $mrClean->sanitizeNum($phone_number);

        //First check if the number has alread been used.
        if ($group->groupUsers()->where('phone_number', $phone_number)->exists()) {
            $errors = ['phone_number' => 'This number is already a member.'];
            return back()->withErrors($errors);
        }

        //Setup data for Validation
        $data = array('name' => $name, 'phone_number' => $phone_number);

        $this->validator($data)->validate();

        //create the user
        $group->groupUsers()->create([
            'name' => $name,
            'phone_number' => $phone_number,
            'is_admin_approved' => 1,
        ]);

        return back();
    }

    /**
     * Update a users information.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Smsapp\GroupUser $groupUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupsUser $groupsUser)
    {
        //You can only edit your users
        $this->authorize('crud', $groupsUser);

        //Get the form data
        $name = $request->name;
        $phone_number = $request->phone_number;

        //Sanitize data
        $mrClean = new ISanitize();
        $name = $mrClean->sanitize($name);
        $phone_number = $mrClean->sanitizeNum($phone_number);

        //First check if the number has alread been used.
        if ($phone_number != $groupsUser->phone_number) {
            $groupId = $groupsUser->group_id;
            $group = new Group();
            $group = $group->where('id', $groupId)->first();

            if ($group->groupUsers()->where('phone_number', $phone_number)->exists()) {
                $errors = ['phone_number' => 'This number is already a member.'];
                return back()->withErrors($errors);
            }
        }

        $data = array('name' => $name, 'phone_number' => $phone_number);
        $this->validator($data)->validate();

        $groupsUser->update($data);

        return back();
    }

    /**
     * Validate store() and update().
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
          'name' => 'required|string|min:2|max:255',
          'phone_number' => 'required|string|min:10|max:20',
      ]);
    }

    /**
     * Approve a user joining a group
     *
     * @param GroupsUser $groupsUser
     */
    public function approve(Request $request, GroupsUser $groupsUser)
    {
        //You can only edit your users
        $this->authorize('crud', $groupsUser);

        //Get the form data
        //This is an array since multple forms are on this page.
        $name = $request->name;
        $phone_number = $request->phone_number;

        //Sanitize data
        $mrClean = new ISanitize();
        $name[$groupsUser->id] = $mrClean->sanitize($name[$groupsUser->id]);
        $phone_number[$groupsUser->id] = $mrClean->sanitizeNum($phone_number[$groupsUser->id]);

        //if the number has changed, check if the new number has alread been used.
        if ($phone_number[$groupsUser->id] != $groupsUser->phone_number) {
            $groupId = $groupsUser->group_id;
            $group = new Group();
            $group = $group->where('id', $groupId)->first();

            if ($group->groupUsers()->where('phone_number', $phone_number[$groupsUser->id])->exists()) {
                $error_placeholder = 'phone_number.' . $groupsUser->id;
                $errors = [$error_placeholder => 'This number is already a member.'];
                return back()->withErrors($errors);
            }
        }

        //validate the input.
        $data = array('name' => $name, 'phone_number' => $phone_number);
        $this->validatorApprove($data)->validate();

        //update changes, and approve the user
        $groupsUser->update([
            'name' => $name[$groupsUser->id],
            'phone_number' => $phone_number[$groupsUser->id],
            'is_admin_approved' => 1,
          ]);

        return back();
    }

    /*
     * Get a validator for an approval request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorApprove(array $data)
    {
        $messages =  [
          'name.*.required' => 'Please enter a user name.',
          'name.*.min' => 'The name must be at least 2 characters.',
          'phone_number.*.required' => 'Please enter a phone number.',
          'phone_number.*.min'  => 'The phone number must be at least 10 digits.',
          ];

        return Validator::make($data, [
          'name.*' => 'required|string|min:2|max:255',
          'phone_number.*' => 'required|string|min:10|max:20',
      ], $messages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Smsapp\GroupUser $groupUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, GroupsUser $groupsUser)
    {
        //Only use can delete you userser
        $this->authorize('crud', $groupsUser);

        $groupsUser->delete();
        $backUrl = $request->session()->get('backUrl');
        return redirect($backUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Smsapp\GroupUser $groupUser
     * @return \Illuminate\Http\Response
     */
    public function destroyAffiliation(Request $request, GroupsUser $groupsUser)
    {
        //But a user can remove himself
        $this->authorize('deleteAffiliation', $groupsUser);
        $groupsUser->delete();

        return back();
    }
}
