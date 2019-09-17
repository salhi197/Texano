<?php

namespace App\Mail;
use Illuminate\Http\Request;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Texano extends Mailable   
{
    use Queueable, SerializesModels;

    public $demo;
    public function __construct($demo){
        $this->demo=$demo;    
    }
    public function build()
    {
        return $this->view('emails.contact');
    }
    
}

