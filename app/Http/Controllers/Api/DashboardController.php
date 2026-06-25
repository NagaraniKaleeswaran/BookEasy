<?php

namespace App\Http\Controllers\Api;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    /**
     * Get statistics for the authenticated user
     */
    public function stats()
    {
        $userId = Auth::id();
        
        $totalBookings = Appointment::where('user_id', $userId)->count();
        $upcomingBookings = Appointment::where('user_id', $userId)
                                       ->whereIn('status', ['pending', 'confirmed'])
                                       ->where('appointment_date', '>=', now()->toDateString())
                                       ->count();
        $totalServices = Service::where('status', 'active')->count();

        return $this->sendResponse([
            'total_bookings' => $totalBookings,
            'upcoming_bookings' => $upcomingBookings,
            'total_services' => $totalServices,
            // 'total_customers' => 0 // This would make more sense for Admin API. For mobile customer, they don't have customers.
        ], 'Dashboard stats retrieved successfully.');
    }
}
