<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStatusInUserTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_tasks', function (Blueprint $table) {
            DB::statement("ALTER TABLE `user_tasks` CHANGE `status` `status` ENUM('pending', 'started', 'completed') NOT NULL DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_tasks', function (Blueprint $table) {
            DB::statement("ALTER TABLE `user_tasks` CHANGE `status` `status` ENUM('pending', 'completed') NOT NULL DEFAULT 'pending'");
        });
    }
}