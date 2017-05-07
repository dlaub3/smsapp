<?php

namespace Smsapp\Http\Controllers;

use Smsapp\User;
use Smsapp\Group;
use Smsapp\Lib\ISanitize;
use Illuminate\Http\Request;
use Smsapp\Jobs\SendGroupSms;
use Twilio\Security\RequestValidator;

class SmsController extends Controller
{
    public function smsIn(Request $request)
    {
        \Debugbar::disable();

        // Your auth token from twilio.com/user/account
        $token = env('TWILIO_AUTH_TOKEN');

        // The X-Twilio-Signature header - in PHP this should be
        $signature = $_SERVER["HTTP_X_TWILIO_SIGNATURE"];

        // Initialize the validator
        $validator = new RequestValidator($token);

        // The Twilio request URL. You may be able to retrieve this from
        $url = $request->fullUrl();

        // The post variables in the Twilio request. You may be able to use
        //do not user $request->all(); it removes white-space and won't validate.
        $postVars = $_POST;

        if ($validator->validate($signature, $url, $postVars)) {
            $fromTwilio = true;
        } else {
            echo "NOT VALID. It might have been spoofed!";
            die();
        }

        $body = $request->input('Body');
        $phone_number = $request->input('From');

        //Sanitize the input
        $san = new ISanitize();
        $body = $san->filterThis($body);

        //regular expression to remove the first two characters
        //this is the country code, but this app only supports
        //US phone numbers, so it isn't needed.
        $string = $phone_number;
        $pattern = '/^../';
        $replacement = '';
        $phone_number = preg_replace($pattern, $replacement, $string);

        //First extract the group slug from the body.
        $subject = $body;
        $pattern = '/.+?(?=@)/';
        if (preg_match($pattern, $subject, $matches)) {
            $slug = $matches[0];
            //just in case there is white-space
            $slug = trim($slug);
            $slug = strtolower($slug);
        } else {
            return response("<Response>
            <Message>Group Name: Please use the format group-name@your message.</Message>
            </Response>");
        }

        //Second exract the message from the body
        //This should be executed after the above preg_match
        $subject = $body;
        $pattern = '/(?<=\@).*/';
        if (preg_match($pattern, $subject, $matches)) {
            $message = $matches[0];
            //just in case there is white-space
            $message = trim($message);
            if ($message === '') {
                return response("<Response>
              <Message> Message Body: Please use the format group-name@your message.</Message>
              </Response>");
            }
        } else {
            return response("<Response>
            <Message>Please use the format group-name@your message.</Message>
            </Response>");
        }


        //Setup for the queries
        $group = new Group();
        $user = new User();

        //Users may join or leave groups.
        if ($slug === 'leave') {
            //remove the user
            //in this case $message is the slug
            $slug = $message;

            $slug = strtolower($slug);
            //does the group exist?
            if ($group->where('slug', $slug)->exists()) {
                //set the group.
                $group = $group->where('slug', $slug)->first();
            } else {
                //return error response
                return response("<Response>
                <Message>$slug does not exist. You might want to check your spelling.</Message>
                </Response>");
            }

            if ($group->groupUsers()->where('phone_number', $phone_number)->exists()) {
                //set the user
              $removeUser = $group->groupUsers()->where('phone_number', $phone_number)->first();
              //remove the user from the group.
              $removeUser->delete();
              //return success response
              return response("<Response>
                <Message>You have successfully left the group $slug.</Message>
                </Response>");
            } else {
                return response("<Response>
                <Message>You are not part of $slug.</Message>
                </Response>");
            }
        } elseif ($slug === 'join') {
            //Get the userName and slug
            //Extract the $slug  from the $message.
            $subject = $message;
            $pattern = '/.+?(?=@)/';
            if (preg_match($pattern, $subject, $matches)) {
                $slug = $matches[0];
                $slug = trim($slug);
                $slug = strtolower($slug);
            } else {
                $slug = $message;
            }

            //Exract the $userName from the $message
            $subject = $message;
            $pattern = '/(?<=\@).*/';
            if (preg_match($pattern, $subject, $matches)) {
                $userName = $matches[0];
                $userName = trim($userName);
            } else {
                $userName = 'Anonymous';
            }

            //Add the user
            //get the group if it exists if not return error message
            if ($group->where('slug', $slug)->exists()) {
                $group = $group->where('slug', $slug)->first();
            } else {
                return response("<Response>
                  <Message>$slug does not exist. You might want to check the  group spelling.</Message>
                  </Response>");
            }
            //Is the user already part of the group?
            if ($group->groupUsers()->where('phone_number', $phone_number)->exists()) {
                //if the user exists return error response
                  return response("<Response>
                  <Message>You are already part of $slug.</Message>
                  </Response>");
            } else {
                //add the user to the group.
                  $group->groupUsers()->create([
                    'name' => $userName,
                    'phone_number' => $phone_number,
                    'is_sms_activate' => 1,
                ]);
                //return success response
                  return response("<Response>
                <Message>You have been successfully added to $slug </Message>
                </Response>");
            }
        } else {
            if (strlen($message) > 160) {
                //The message is too long
                $messArr = str_split($message, 160);
                $messArr = str_split($messArr[0], 10);
                $resp = $messArr[15];

                return response("<Response>
                <Message>Messages cannot be longer than 160 charaacters. The last valid section of you message is \"$resp\".</Message>
                </Response>");
            }
            //Begin Group Messaging
          if ($user->where('phone_number', $phone_number)->exists()) {
              //get the user
              $user = $user->where('phone_number', $phone_number)->first();
          } else {
              $appUrl = env('APP_URL');
              return response("<Response>
                  <Message>You do not have an account. Please visit $appUrl to sign-up.</Message>
                  </Response>");
          }
          //get the group if it exists.
          if ($user->groups()->where('slug', $slug)->exists()) {
              $group = $user->groups()->where('slug', $slug)->first();
          } else {
              return response("<Response>
                  <Message>You do not have a group named $slug. You might want to check the spelling.</Message>
                  </Response>");
          }

          //get message recipients
          $list = $group->groupUsers()->where('is_admin_approved', 1)->get();
            $list->toJson();
            //Add remove message
            $message = $message . "\n\n Had enough? Text: leave@$group->slug";

            $this->notifyThroughSms($list, $message);

            return response('<Response>
              <Message>Your message has been sent.</Message>
              </Response>');
        }
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
