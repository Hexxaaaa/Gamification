<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTaskStatusEnum extends Migration
{
    public function up()
    {
        // Convert to string first to allow modification
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('status')->change();
        });
        
        // Then convert back to enum with new option
        DB::statement("ALTER TABLE `tasks` MODIFY `status` ENUM('pending', 'active', 'completed', 'expired') DEFAULT 'pending'");
    }

    public function down()
    {
        // Convert back to original enum
        DB::statement("ALTER TABLE `tasks` MODIFY `status` ENUM('pending', 'active', 'completed') DEFAULT 'pending'");
    }
}