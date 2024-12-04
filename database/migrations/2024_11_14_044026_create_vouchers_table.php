<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('points_required');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'expired'])->default('active');
            $table->string('image')->nullable(); // Image field for the voucher
            $table->integer('user_limit')->nullable(); // User limit for the voucher
            $table->date('expiration_date')->nullable(); // Expiration date of the voucher
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
        Schema::dropIfExists('vouchers');
    }
}