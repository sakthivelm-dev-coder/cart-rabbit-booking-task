<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use App\Services\SlotService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AvailabilityController extends Controller {

    public function index(Request $req, SlotService $slots) {
        $validated = $req->validate([
            'userId' => ['required','integer','exists:users,id'],
            'date'   => ['required','date'],
        ]);

        $data = $slots->getSlots($validated['userId'], $validated['date']);
        return response()->json(['slots' => $data]);
    }

    // Basic "admin" endpoint to add/edit availability
    public function store(Request $req) {
        $validated = $req->validate([
            'userId' => ['required','integer','exists:users,id'],
            'date'   => ['required','date'],
            'start_time' => ['required','date_format:H:i'],
            'end_time'   => ['required','date_format:H:i','after:start_time'],
            'slot_duration_minutes' => ['required','integer','between:15,180']
        ]);
        $availability = Availability::create([
            'user_id' => $validated['userId'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'slot_duration_minutes' => $validated['slot_duration_minutes'],
        ]);
        return response()->json(['availability' => $availability], 201);
    }
}
