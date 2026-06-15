<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\Contact;
use Mail;

class OrderStatusQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try{
            $email = new Contact();
            //Mail::to($this->details['email'])->send($email);

            Mail::send('emails.order-status', $this->details, function($message)
            {
                $message->from(config('constants.EMAIL.from'), config('constants.BUSINESS.name'));
                $message->subject(config('constants.BUSINESS.name').' - Order '. $this->details['status']);
                $message->to($this->details['to']);
            });
        }
        catch(\Exception $e){
            print '<pre>'; print_r($e->getMessage()); die;
        }


        
    }
}
