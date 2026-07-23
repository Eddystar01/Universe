<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('course_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignUuid('lecturer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignUuid('started_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('title');

            $table->date('session_date');

            $table->timestamp('starts_at');

            $table->timestamp('ends_at');

            $table->string('attendance_code')->nullable();

            $table->enum('status', [
                'scheduled',
                'active',
                'ended',
                'cancelled',
            ])->default('scheduled');

            $table->decimal('location_latitude', 10, 7)->nullable();

            $table->decimal('location_longitude', 10, 7)->nullable();

            $table->integer('allowed_radius')->default(100);

            $table->timestamp('ended_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};
