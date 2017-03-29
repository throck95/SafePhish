<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingListUsersGroupsBridgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_list_users_groups_bridge', function (Blueprint $table) {
            $table->integer('mailing_list_user_id');
            $table->integer('group_id');
            $table->primary(['mailing_list_user_id', 'group_id'], 'mailing_list_users_groups_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mailing_list_users_groups_bridge');
    }
}
