<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsiteTrackingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('website_tracking', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ip_address');
			$table->string('host');
			$table->string('browser_agent');
			$table->string('req_path');
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
		Schema::drop('website_tracking');
	}

}
