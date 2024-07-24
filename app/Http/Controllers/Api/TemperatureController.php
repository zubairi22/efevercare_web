<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TemperatureReading;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TemperatureController extends Controller
{
    public function index(): JsonResponse
    {
        $temp = TemperatureReading::where('user_id' , Auth::id())->latest()->first();

        return response()
            ->json([
                'message' => 'Fetch Temperature Berhasil',
                'temp' => $temp
            ]);
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->has('temperature')) {
            $temperatures = $request->input('temperature');
            $readingTime =  $request->input('reading_time');

            if (is_array($temperatures)) {
                $data = [];

                foreach ($temperatures as $temperature) {
                    $data[] = [
                        'temperature' => $temperature,
                        'reading_time' => $readingTime,
                        'user_id' => Auth::id()
                    ];
                }

                TemperatureReading::insert($data);

            } else {

                $data = [
                    'temperature' => $temperatures,
                    'reading_time' => $readingTime,
                    'user_id' => Auth::id()
                ];

                TemperatureReading::create($data);

            }
            return response()
                ->json([
                    'message' => 'Input Temperature Berhasil',
                ]);
        }

        return response()
            ->json([
                'message' => 'Data Vital Sign tidak masuk',
            ], 400);
    }


    public function vitalHistory(): JsonResponse
    {
        $startOfThisMonth = now()->startOfMonth()->format('Y-m-d H:i:s');
        $endOfThisMonth = now()->endOfDay()->format('Y-m-d H:i:s');

        $startOfLastMonth = now()->subMonth()->startOfMonth()->format('Y-m-d H:i:s');
        $endOfLastMonth = now()->subMonth()->endOfMonth()->endOfDay()->format('Y-m-d H:i:s');

        $temperature = TemperatureReading::where('user_id', Auth::id())
            ->where(function ($query) use ($startOfThisMonth, $endOfThisMonth, $startOfLastMonth, $endOfLastMonth) {
                $query->whereBetween('reading_time', [$startOfThisMonth, $endOfThisMonth])
                    ->orWhereBetween('reading_time', [$startOfLastMonth, $endOfLastMonth]);
            })->oldest('reading_time')->get();

        return response()
            ->json([
                'message' => 'Fetch History Temperature Berhasil',
                'temp' => $temperature,
            ]);
    }
}
