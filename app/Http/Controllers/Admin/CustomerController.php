<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $appointments = $customer->appointments()->with('service')->orderBy('appointment_date', 'desc')->paginate(5);

        return view('admin.customers.show', compact('customer', 'appointments'));
    }
}
