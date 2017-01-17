<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_list', function(Blueprint $table)
        {
            $table->increments('MGL_Id');
            $table->string('MGL_Username');
            $table->string('MGL_Email');
            $table->string('MGL_FirstName');
            $table->string('MGL_LastName');
            $table->integer('MGL_Department');
            $table->string('MGL_UniqueURLId',30);
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
        Schema::drop('mailing_list');
    }
}
