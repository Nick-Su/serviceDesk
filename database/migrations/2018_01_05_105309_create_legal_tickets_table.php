<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_tickets', function (Blueprint $table) {
            # technical info
            $table->increments('id');
            $table->integer('id_client');
            $table->string('id_company_to');
            $table->integer('unit_to_id');
            
            # users input info
            $table->integer('id_priority');
            $table->string('subject');
            $table->string('description');
            $table->string('address');

            # technical info for tickets algorithms
            $table->integer('id_status')->nullable();
            $table->integer('id_executor')->nullable();
            $table->boolean('confirmed_by_executor')->nullable();
            $table->boolean('confirmed_by_initiator')->nullable();
            $table->string('id_transaction')->nullable();

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
        Schema::dropIfExists('legal_tickets');
    }
}
