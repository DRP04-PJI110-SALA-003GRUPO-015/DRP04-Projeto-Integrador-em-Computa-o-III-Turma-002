<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataAnalyticsService
{
    public function getAppointmentStats()
    {
        $stats = [
            'total_appointments' => Appointment::count(),
            'monthly_appointments' => $this->getMonthlyAppointments(),
            'popular_specialties' => $this->getPopularSpecialties(),
            'patient_demographics' => $this->getPatientDemographics(),
            'revenue_analysis' => $this->getRevenueAnalysis()
        ];

        return $stats;
    }

    private function getMonthlyAppointments()
    {
        return Appointment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->get();
    }

    private function getPopularSpecialties()
    {
        return Appointment::select(
            'specialty',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('specialty')
        ->orderByDesc('total')
        ->limit(5)
        ->get();
    }

    private function getPatientDemographics()
    {
        return User::select(
            DB::raw('CASE 
                WHEN age < 18 THEN "0-17"
                WHEN age BETWEEN 18 AND 30 THEN "18-30"
                WHEN age BETWEEN 31 AND 50 THEN "31-50"
                ELSE "50+"
            END as age_group'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('age_group')
        ->get();
    }

    private function getRevenueAnalysis()
    {
        return Appointment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(price) as total_revenue')
        )
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->get();
    }

    public function getPredictiveAnalytics()
    {
        return [
            'expected_appointments' => $this->predictNextMonthAppointments(),
            'peak_hours' => $this->analyzePeakHours(),
            'cancellation_probability' => $this->calculateCancellationProbability()
        ];
    }

    private function predictNextMonthAppointments()
    {
        // Implementar modelo de previsão usando dados históricos
        $lastMonth = Appointment::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->count();
        
        $growthRate = 0.1; // Taxa de crescimento estimada
        return round($lastMonth * (1 + $growthRate));
    }

    private function analyzePeakHours()
    {
        return Appointment::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('hour')
        ->orderByDesc('total')
        ->limit(3)
        ->get();
    }

    private function calculateCancellationProbability()
    {
        $total = Appointment::count();
        $cancelled = Appointment::where('status', 'cancelled')->count();
        
        return $total > 0 ? ($cancelled / $total) * 100 : 0;
    }
} 