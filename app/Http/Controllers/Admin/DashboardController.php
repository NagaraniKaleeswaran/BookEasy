<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalBookings = Appointment::count();
        $todaysBookings = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $upcomingAppointments = Appointment::where('appointment_date', '>=', Carbon::today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
        
        $totalCustomers = User::where('role', 'customer')->count();
        $totalServices = Service::count();
        $totalStaff = Staff::count();

        // Chart Data: Daily Bookings (Last 7 days)
        $dailyBookingsData = [];
        $dailyBookingsLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dailyBookingsLabels[] = $date->format('M d');
            $dailyBookingsData[] = Appointment::whereDate('appointment_date', $date)->count();
        }

        // Chart Data: Monthly Bookings (Last 6 months)
        $monthlyBookingsData = [];
        $monthlyBookingsLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::today()->startOfMonth()->subMonths($i);
            $monthlyBookingsLabels[] = $month->format('M Y');
            $monthlyBookingsData[] = Appointment::whereYear('appointment_date', $month->year)
                ->whereMonth('appointment_date', $month->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalBookings',
            'todaysBookings',
            'upcomingAppointments',
            'totalCustomers',
            'totalServices',
            'totalStaff',
            'dailyBookingsData',
            'dailyBookingsLabels',
            'monthlyBookingsData',
            'monthlyBookingsLabels'
        ));
    }
}
