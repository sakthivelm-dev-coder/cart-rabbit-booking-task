<?php

namespace App\Services;

use App\Models\Availability;
use App\Models\Booking;
use Carbon\Carbon;

class SlotService {
    /**
     * Generate open slots for a user on a date from availability windows minus existing bookings.
     * Returns array of ['start' => 'HH:MM', 'end' => 'HH:MM', 'status' => 'open'|'blocked']
     */
    public function getSlots(int $userId, string $date): array {
        $windows = Availability::where('user_id', $userId)->where('date', $date)->get();
        $bookings = Booking::where('user_id', $userId)->where('date', $date)->get();

        $blockedRanges = $bookings->map(fn($b) => [
            'start' => Carbon::parse($b->start_time),
            'end'   => Carbon::parse($b->end_time),
        ]);

        $slots = [];
        foreach ($windows as $w) {
            $start = Carbon::parse($w->start_time);
            $end   = Carbon::parse($w->end_time);
            $dur   = $w->slot_duration_minutes;

            for ($cursor = $start->copy(); $cursor->lt($end); $cursor->addMinutes($dur)) {
                $slotStart = $cursor->copy();
                $slotEnd   = $cursor->copy()->addMinutes($dur);
                if ($slotEnd->gt($end)) break;

                $overlaps = $blockedRanges->contains(function ($br) use ($slotStart, $slotEnd) {
                    return $br['start']->lt($slotEnd) && $br['end']->gt($slotStart);
                });

                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end'   => $slotEnd->format('H:i'),
                    'status'=> $overlaps ? 'blocked' : 'open'
                ];
            }
        }
        // Sort by start time
        usort($slots, fn($a,$b)=> strcmp($a['start'],$b['start']));
        return $slots;
    }
}
