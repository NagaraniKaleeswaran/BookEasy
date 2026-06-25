<?php

namespace App\Http\Controllers\Api;

use App\Models\Appointment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AppointmentResource;
use App\Http\Requests\Api\StoreAppointmentRequest;
use App\Http\Requests\Api\UpdateAppointmentRequest;

class AppointmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())->with('service')->orderBy('appointment_date', 'desc')->get();
        return $this->sendResponse(AppointmentResource::collection($appointments), 'Appointments retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = new Appointment($request->validated());
        $appointment->user_id = Auth::id(); // Ensure ownership
        $appointment->status = 'pending';
        $appointment->save();
        $appointment->load('service');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Appointment Created',
            'description' => "Created appointment for service ID: {$appointment->service_id}",
            'ip_address' => $request->ip()
        ]);

        return $this->sendResponse(new AppointmentResource($appointment), 'Appointment booked successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::where('user_id', Auth::id())->with('service')->find($id);

        if (is_null($appointment)) {
            return $this->sendError('Appointment not found.');
        }

        return $this->sendResponse(new AppointmentResource($appointment), 'Appointment retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, string $id)
    {
        $appointment = Appointment::where('user_id', Auth::id())->find($id);

        if (is_null($appointment)) {
            return $this->sendError('Appointment not found.');
        }

        $appointment->update($request->validated());

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Appointment Updated',
            'description' => "Updated appointment ID: {$appointment->id}",
            'ip_address' => $request->ip()
        ]);

        return $this->sendResponse(new AppointmentResource($appointment), 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $appointment = Appointment::where('user_id', Auth::id())->find($id);

        if (is_null($appointment)) {
            return $this->sendError('Appointment not found.');
        }

        $appointment->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Appointment Cancelled',
            'description' => "Deleted appointment ID: {$id}",
            'ip_address' => $request->ip()
        ]);

        return $this->sendResponse([], 'Appointment deleted successfully.');
    }
}
