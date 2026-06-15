<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SubscribeQueue implements ShouldQueue
{
    use Queueable;
    protected $details;
    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{

            Mail::send('emails.subscribe', $this->details, function($message)
            {
                $message->from(config('constants.EMAIL.from'), config('constants.BUSINESS.name'));
                $message->subject(config('constants.BUSINESS.name').' - Subscribe Successful');
                $message->to($this->details['to']);
            });
        }
        catch(\Exception $e){
            //print '<pre>'; print_r($e->getMessage()); die;
        }
    }
}
