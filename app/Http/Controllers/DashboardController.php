<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $monitorPatients = User::filter(Request::only('search'))->with('recentTemperatureReadings')->where('status' , 'monitor');

        if (Auth::user()->hasRole(['User'])) {
            $monitorPatients->where('id', Auth::id());
        }

        return Inertia::render('Dashboard', [
            'patients' => $monitorPatients->get(),
        ]);
    }
}
