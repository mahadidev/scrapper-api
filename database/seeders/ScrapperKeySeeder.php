<?php

namespace Database\Seeders;

use App\Models\ScrapperKey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScrapperKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keys = [[
            "type" => "email",
            "key" => "email",
            "range" => 30,
        ],[
            "type" => "email",
            "key" => "contact",
            "range" => 30,
        ],[
            "type" => "email",
            "key" => "get in touch",
            "range" => 30,
        ],[
            "type" => "phone",
            "key" => "phone",
            "range" => 30,
        ],[
            "type" => "phone",
            "key" => "call",
            "range" => 30,
        ],[
            "type" => "phone",
            "key" => "number",
            "range" => 30,
        ]];

        foreach ($keys as $key) {
            ScrapperKey::create($key);
        }
    }
}
