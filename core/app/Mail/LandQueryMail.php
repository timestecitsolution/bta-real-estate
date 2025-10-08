<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\LandQuery;

class LandQueryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $query;

    public function __construct(LandQuery $query)
    {
        $this->query = $query;
    }

    public function build()
    {
        $email = $this->subject('New Land Query Submission')
                     ->view('emails.land_query');

        foreach ($this->query->attachments as $path) {

            $email->attach(base_path('../uploads/land_query/' . $path));

        }

        return $email;
    }
}
