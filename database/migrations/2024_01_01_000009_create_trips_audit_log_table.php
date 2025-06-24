<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTripsAuditLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips_audit_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('primary_id')->unsigned();
            $table->mediumInteger('org_code')->unsigned();
            $table->integer('route_id')->unsigned();
            $table->integer('driver_id')->unsigned();
            $table->string('driver_name', 100);
            $table->integer('vehicle_id')->unsigned();
            $table->string('vehicle_registration_number', 50);
            $table->string('start_location', 255);
            $table->string('destination', 255);
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->decimal('distance_km', 10, 2)->nullable();
            $table->string('purpose', 100)->nullable();
            $table->decimal('fuel_cost', 10, 2)->default(0.00);
            $table->decimal('total_cost', 10, 2)->default(0.00);
            $table->tinyInteger('is_locked')->unsigned()->default(0);
            $table->enum('status', ['initiate', 'completed', 'reject'])->default('initiate');
            $table->text('reject_reason')->nullable();
            $table->enum('action', ['create', 'modify']);
            $table->bigInteger('created_by');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->index('primary_id', 'idx_primary_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips_audit_log');
    }
} 