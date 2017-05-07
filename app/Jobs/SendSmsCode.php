<?php

namespace Smsapp\Jobs;

use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    protected $phone_number;

    protected $rand;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone_number, $rand)
    {
        $this->phone_number = $phone_number;
        $this->rand = $rand;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Your Account SID and Auth Token from twilio.com/console
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_NUMBER');
        $client = new Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
        // the number you'd like to send the message to
            $this->phone_number,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilioNumber,
                // the body of the text message you'd like to send
                'body' => 'Your code is: ' . $this->rand,
            )
        );
    }

    /**
     * The job failed to process.
     *
     * @param  Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        //
    }
}
