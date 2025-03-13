<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\DataAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    protected $analyticsService;

    public function __construct(DataAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index()
    {
        $appointments = Appointment::with(['user', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $appointments
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'specialty' => 'required|string',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $appointment = Appointment::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $appointment
        ], 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json([
            'status' => 'success',
            'data' => $appointment->load(['user', 'doctor'])
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|date|after:today',
            'time' => 'sometimes',
            'status' => 'sometimes|in:scheduled,cancelled,completed',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $appointment->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $appointment
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Appointment deleted successfully'
        ]);
    }

    public function analytics()
    {
        $stats = $this->analyticsService->getAppointmentStats();
        $predictions = $this->analyticsService->getPredictiveAnalytics();

        return response()->json([
            'status' => 'success',
            'data' => [
                'statistics' => $stats,
                'predictions' => $predictions
            ]
        ]);
    }

    public function search(Request $request)
    {
        $query = Appointment::query();

        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('specialty')) {
            $query->where('specialty', $request->specialty);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->with(['user', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $appointments
        ]);
    }
} 