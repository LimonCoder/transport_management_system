<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumInteger('org_code')->unsigned();
            $table->string('registration_number', 20)->unique();
            $table->string('model', 50);
            $table->mediumInteger('capacity')->unsigned()->nullable();
            $table->mediumInteger('fuel_type_id')->unsigned();
            $table->text('images')->nullable();
            $table->string('status', 15);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable();
            $table->integer('version')->default(1);
            
            // Indexes
            $table->index('org_code', 'idx_org_code');
            $table->index('fuel_type_id', 'idx_fuel_type_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
} 