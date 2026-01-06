<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Services\SlotService;
use App\Mail\BookingConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class BookingController extends Controller {

    public function store(Request $req, SlotService $slots) {
        $validated = $req->validate([
            'userId'        => ['required','integer','exists:users,id'],
            'date'          => ['required','date'],
            'start_time'    => ['required','date_format:H:i'],
            'end_time'      => ['required','date_format:H:i','after:start_time'],
            'visitor_name'  => ['required','string','max:100'],
            'visitor_email' => ['required','email','max:150'],
        ]);

        // Transaction + overlap check for double-book prevention
        $booking = DB::transaction(function () use ($validated) {
            $start = Carbon::createFromFormat('H:i', $validated['start_time']);
            $end   = Carbon::createFromFormat('H:i', $validated['end_time']);

            $conflict = Booking::where('user_id', $validated['userId'])
                ->where('date', $validated['date'])
                ->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<', $end->format('H:i'))
                      ->where('end_time',   '>', $start->format('H:i'));
                })->exists();

            if ($conflict) {
                abort(response()->json([
                    'error' => 'Slot already booked or overlaps with an existing booking.'
                ], 409));
            }

            return Booking::create([
                'user_id' => $validated['userId'],
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'visitor_name' => $validated['visitor_name'],
                'visitor_email' => $validated['visitor_email'],
            ]);
        });

        // Email notifications (log driver by default)
        try {
            Mail::to($booking->visitor_email)->send(new BookingConfirmed($booking));
            $host = User::find($booking->user_id);
            if ($host) Mail::to($host->email)->send(new BookingConfirmed($booking, true));
        } catch (\Throwable $e) {
            // Fail silently in demo mode; log channel will capture the mailable
        }

        return response()->json(['booking' => $booking], 201);
    }
}
