<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('client_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('city');
            $table->string('address');
            $table->string('phone_number')->nullable();
            $table->string('room')->nullable();

            $table->rememberToken();
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
        Schema::drop('legals');
    }
}
