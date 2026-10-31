<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->dateTime('starts_at')->index();
            $table->dateTime('ends_at');
            // Same as starts_at while the booking is active, null once cancelled: the unique index stops double-booking
            $table->dateTime('active_slot')->nullable()->unique();
            $table->string('name', 100);
            $table->string('partner_name', 100)->nullable();
            $table->string('email');
            $table->string('phone', 32);
            $table->string('language', 40);
            $table->boolean('partner_joining')->default(true);
            $table->text('notes')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });

        Schema::create('weekly_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('weekday'); // 1 = Monday ... 7 = Sunday
            $table->time('opens_at');
            $table->time('closes_at');
            $table->timestamps();
        });

        Schema::create('blocked_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->string('note')->nullable();
            $table->timestamps();
        });

        // Starting hours, editable in /admin/availability: weekday evenings and weekend mornings
        $now = now();
        DB::table('weekly_hours')->insert(collect(range(1, 7))->map(fn (int $weekday) => [
            'weekday' => $weekday,
            'opens_at' => $weekday <= 5 ? '19:30:00' : '10:00:00',
            'closes_at' => $weekday <= 5 ? '21:30:00' : '12:00:00',
            'created_at' => $now,
            'updated_at' => $now,
        ])->all());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_dates');
        Schema::dropIfExists('weekly_hours');
        Schema::dropIfExists('bookings');
    }
};
