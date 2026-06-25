<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;

class CustomerController extends BaseController
{
    /**
     * Get authenticated user profile
     */
    public function profile(Request $request)
    {
        return $this->sendResponse(new UserResource($request->user()), 'Profile retrieved successfully.');
    }

    /**
     * Get authenticated user appointment history
     */
    public function history()
    {
        $appointments = Appointment::where('user_id', Auth::id())
                                 ->with('service')
                                 ->orderBy('appointment_date', 'desc')
                                 ->get();
        return $this->sendResponse(AppointmentResource::collection($appointments), 'Appointment history retrieved successfully.');
    }
}
