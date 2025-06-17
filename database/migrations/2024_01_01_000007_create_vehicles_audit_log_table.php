<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVehiclesAuditLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles_audit_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('primary_id')->unsigned();
            $table->mediumInteger('org_code')->unsigned();
            $table->string('registration_number', 20);
            $table->string('model', 50);
            $table->mediumInteger('capacity')->unsigned()->nullable();
            $table->mediumInteger('fuel_type_id')->unsigned();
            $table->text('images')->nullable();
            $table->string('status', 15);
            $table->enum('action', ['create', 'modify']);
            $table->bigInteger('created_by');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles_audit_log');
    }
} 