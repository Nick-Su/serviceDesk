<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_company')->nullable();

            $table->integer('employee_init_id')->nullable();
            $table->integer('unit_to_id')->nullable();
            $table->integer('id_executor')->nullable();
            $table->integer('id_priority')->nullable();
            $table->string('subject')->nullable();
            $table->string('description')->nullable();
            $table->integer('id_status')->nullable();
            $table->boolean('confirmed_by_executor')->nullable();
            $table->boolean('confirmed_by_initiator')->nullable();

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
        Schema::dropIfExists('employee_tickets');
    }
}
