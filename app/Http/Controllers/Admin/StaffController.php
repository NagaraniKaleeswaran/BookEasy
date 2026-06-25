<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $staff = $query->paginate(10);

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'nullable|string',
            'role' => 'required|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        Staff::create($request->all());

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully.');
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'nullable|string',
            'role' => 'required|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $staff->update($request->all());

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
