<?php

namespace App\Http\Controllers\Api;

use App\Models\Appointment;
use App\Models\StaffAvailability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeSlotController extends BaseController
{
    /**
     * Get available slots for a given date and service.
     */
    public function index(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'service_id' => 'required|exists:services,id'
        ]);

        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->format('l');

        // Get all staff availability for this day of week
        $availabilities = StaffAvailability::where('day_of_week', $dayOfWeek)->get();

        if ($availabilities->isEmpty()) {
            return $this->sendResponse([], 'No staff available on this day.');
        }

        // Generate possible 30-minute slots between min start and max end
        $minStart = $availabilities->min('start_time');
        $maxEnd = $availabilities->max('end_time');
        
        $slots = [];
        $current = Carbon::parse($date->format('Y-m-d') . ' ' . $minStart);
        $end = Carbon::parse($date->format('Y-m-d') . ' ' . $maxEnd);

        while ($current < $end) {
            $slots[] = $current->format('H:i');
            $current->addMinutes(30);
        }

        // Get booked slots for the date
        $bookedAppointments = Appointment::whereDate('appointment_date', $date->format('Y-m-d'))
                                         ->whereIn('status', ['pending', 'confirmed'])
                                         ->pluck('appointment_time')
                                         ->map(function ($time) {
                                             return Carbon::parse($time)->format('H:i');
                                         })
                                         ->toArray();

        // Filter out booked slots
        $availableSlots = array_values(array_filter($slots, function($slot) use ($bookedAppointments) {
            return !in_array($slot, $bookedAppointments);
        }));

        return $this->sendResponse($availableSlots, 'Available slots retrieved successfully.');
    }
}
