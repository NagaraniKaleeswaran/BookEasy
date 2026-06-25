<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffAvailability;
use Illuminate\Http\Request;

class StaffAvailabilityController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffAvailability::with('staff');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('staff', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $availabilities = $query->paginate(15);

        return view('admin.staff_availabilities.index', compact('availabilities'));
    }

    public function destroy(StaffAvailability $staffAvailability)
    {
        $staffAvailability->delete();
        return redirect()->back()->with('success', 'Availability removed.');
    }
}
