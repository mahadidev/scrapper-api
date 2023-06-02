<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [[
            "name" => "Free Trail",
            "requests_total" => 15,
            "requests_used" => 0,
            "requests_available" => 15,
        ],[
            "name" => "Standard",
            "requests_total" => 50,
            "requests_used" => 0,
            "requests_available" => 50,
        ],[
            "name" => "Dexul",
            "requests_total" => 500,
            "requests_used" => 0,
            "requests_available" => 500,
        ]];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
