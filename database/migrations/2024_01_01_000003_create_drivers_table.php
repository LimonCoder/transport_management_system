<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unique();
            $table->mediumInteger('org_code')->unsigned();
            $table->string('name', 200);
            $table->string('license_number', 150)->unique()->nullable();
            $table->date('date_of_joining')->nullable();
            $table->string('mobile_number', 15)->unique();
            $table->string('address', 200)->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('license_number');
            $table->index('mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
} 