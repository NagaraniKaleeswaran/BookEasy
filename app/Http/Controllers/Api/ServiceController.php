<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceResource;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('status', 'active')->get();
        return $this->sendResponse(ServiceResource::collection($services), 'Services retrieved successfully.');
    }
}
