<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('PRJ_Id');
			$table->string('PRJ_Name');
            $table->string('PRJ_Description')->nullable();
            $table->string('PRJ_ComplexityType');
            $table->string('PRJ_TargetType');
			$table->string('PRJ_Assignee');
			$table->string('PRJ_Status');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}
