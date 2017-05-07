<?php

namespace Smsapp\Http\Controllers;

use Smsapp\Group;
use Smsapp\Lib\ISanitize;
use Illuminate\Http\Request;
use Smsapp\Jobs\SendGroupSms;
use Smsapp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GroupSmsController extends Controller
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'message' => 'required|string|max:160',
        ]);
    }

    /**
     * Return a list of group users and send message
     *
     * @param Request $request
     * @param Group $group
     */
    public function getGroupList(Request $request, Group $group)
    {
        //authorize sending message to a group
        $this->authorize('crud', $group);

        //Get the form data
        $message = $request->message;

        //Sanitize data
        $mrClean = new ISanitize();
        $message = $mrClean->sanitize($message);

        //Setup data for validation
        $data = array('message' => $message);

        $this->validator($data)->validate();

        //get message recipients
        $list = $group->groupUsers()->where('is_admin_approved', 1)->get();
        $list->toJson();

        //Add remove message
        $message = $message . "\n\n Had enough? Text: leave@$group->slug";
        //send the message
        $this->notifyThroughSms($list, $message);

        //Set success to true for view
        $request->session()->put('success', 1);
        $request->session()->save();

        return redirect("my-groups/send-message/$group->slug/sent");
    }

    /**
     * Process sending the message to the list of users
     *
     * @param mixed $list
     * @param mixed $message
     */
    public function notifyThroughSms($list, $message)
    {
        foreach ($list as $recipient) {
            dispatch(new SendGroupSms($recipient->phone_number, $message));
        }
    }
}
