<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFuelOilTable extends Migration {

	public function up()
	{
		Schema::create('fuel_oil', function(Blueprint $table) {
			$table->increments('id');
            $table->mediumInteger('org_code')->unsigned();
			$table->integer('vehicle_id')->unsigned();
			$table->integer('log_book_id')->unsigned();
			$table->tinyInteger('type')->comment("1 = practol, 2 = digal, 3 = octen");
			$table->mediumInteger('previous_stock')->unsigned();
			$table->mediumInteger('in')->unsigned();
			$table->mediumInteger('out')->unsigned();
			$table->decimal('payment',8,2);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('fuel_oil');
	}
}
