<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayrollMail extends Mailable
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

    public function build()
    {
        $address = 'info@hyprops.com';
        $subject = 'Hyprops Info!';
        $name = 'Hyprops';

        return $this->view('Mail_views.payroll_mail')
            ->from($address, $name)/*
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)*/
            ->subject($subject)
            ->with([ 'message' => $this->data ]);
    }
}
