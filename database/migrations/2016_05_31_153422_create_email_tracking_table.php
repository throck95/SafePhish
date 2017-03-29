<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTrackingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_tracking', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ip_address');
			$table->string('host');
			$table->integer('user_id');
			$table->integer('campaign_id');
			$table->dateTime('timestamp');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_tracking');
	}

}
