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
			$table->increments('SML_Id');
			$table->integer('SML_UserId');
			$table->string('SML_ProjectId');
			$table->dateTime('SML_Timestamp');
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
