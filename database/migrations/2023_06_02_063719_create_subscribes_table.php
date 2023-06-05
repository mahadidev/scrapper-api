<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("requests_total")->default(0);
            $table->string("requests_used")->default(0);
            $table->string("requests_available")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribes');
    }
};