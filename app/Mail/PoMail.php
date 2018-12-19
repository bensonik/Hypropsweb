<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Utility;

class PoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'info@company.com';
        $subject = 'Purchase Order';
        $name = 'Company Name';
        $company = Utility::companyInfo();
        if(!empty($company)){

            $address = $company->email;
            $subject = $company->name.' Info';
            $name = $company->name;
        }

        $message = $this->view('mail_views.purchase_order');
            $message->from($address, $name);/*
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)*/
            $message->subject($subject);
        if(count($this->data['attachment']) > 0){
            foreach($this->data['attachment'] as $file){
                $message->attach($file);
            }
        }

            $message->with([ 'message' => $this->data ]);
    }
}
