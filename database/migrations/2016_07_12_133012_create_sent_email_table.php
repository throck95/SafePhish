<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentEmailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sent_email', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('mailing_list_user_id');
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
		Schema::drop('sent_email');
	}

}
