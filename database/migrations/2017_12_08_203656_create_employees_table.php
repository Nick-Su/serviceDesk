<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->string('phone_number')->nullable();
            #$table->boolean('priv_add_employee')->nullable();
            #$table->boolean('priv_edit_employee')->nullable();
            #$table->boolean('priv_delete_employee')->nullable();
            $table->string('id_unit')->nullable();
            $table->string('head_unit_id')->nullable();
            $table->string('room')->nullable();
            $table->string('id_company')->nullable();
            $table->integer('id_role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees');
    }
}
