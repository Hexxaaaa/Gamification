<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTasksTableForVideoTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the 'task_type' column
            if (Schema::hasColumn('tasks', 'task_type')) {
                $table->dropColumn('task_type');
            }

            // Add 'video_url' column
            $table->string('video_url')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Re-add the 'task_type' column
            $table->string('task_type')->after('id')->nullable();

            // Drop the 'video_url' column
            if (Schema::hasColumn('tasks', 'video_url')) {
                $table->dropColumn('video_url');
            }
        });
    }
}