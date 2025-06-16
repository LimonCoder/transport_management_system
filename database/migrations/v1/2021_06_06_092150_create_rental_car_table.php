<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalCarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_car', function (Blueprint $table) {
            $table->Increments('id');
            $table->mediumInteger('org_code')->nullable();
            $table->integer('vehicle_id')->unsigned();
            $table->date('from_date');
            $table->date('to_date');
            $table->mediumInteger('total_day')->nullable();
            $table->decimal('amount',10,2)->unsigned();
            $table->decimal('vat',10,2)->unsigned();
            $table->decimal('income_tax',10,2)->unsigned();
            $table->decimal('total_amount',10,2)->unsigned();
            $table->date('insert_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rental_car');
    }
}
