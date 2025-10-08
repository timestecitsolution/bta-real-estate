<?php
// app/Mail/BookingQueryMail.php

namespace App\Mail;

use App\Models\BookingQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingQueryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $query;

    public function __construct(BookingQuery $query)
    {
        $this->query = $query;
    }

    public function build()
    {
        return $this->subject('New Booking Query Submitted')
                    ->view('emails.booking_query');
    }
}
