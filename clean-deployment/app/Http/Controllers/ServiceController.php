<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return view('pages.services', compact('services'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // Ensure the service is active
        if (!$service->is_active) {
            abort(404);
        }

        // Get related services from the same category
        $relatedServices = Service::where('is_active', true)
            ->where('id', '!=', $service->id)
            ->where('category', $service->category)
            ->limit(3)
            ->get();

        // Get testimonials for this service
        $serviceTestimonials = $service->testimonials()
            ->where('is_approved', true)
            ->limit(6)
            ->get();

        return view('pages.service-detail', compact('service', 'relatedServices', 'serviceTestimonials'));
    }
}