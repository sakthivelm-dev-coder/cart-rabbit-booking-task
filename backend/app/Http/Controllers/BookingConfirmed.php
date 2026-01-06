<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmed extends Mailable {

    use Queueable, SerializesModels;

    public function build() {
        $subject = $this->forHost ? 'New booking received' : 'Your booking is confirmed';
        return $this->subject($subject)
            ->view('emails.booking_confirmed')
            ->with(['booking' => $this->booking, 'forHost' => $this->forHost]);
    }
}
