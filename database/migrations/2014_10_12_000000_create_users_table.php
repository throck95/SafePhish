<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('USR_Id');
			$table->string('USR_Username')->unique();
			$table->string('USR_Email');
			$table->string('USR_FirstName');
			$table->string('USR_LastName');
            $table->string('USR_MiddleInitial')->nullable();
			$table->string('USR_Password',255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}

}
