<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('add')->default(false);
            $table->integer('to_org');
            $table->integer('to_user')->nullable();
            $table->integer('from_org');
            $table->integer('from_user');
            $table->decimal('pay',8,2)->default(0);
            $table->integer('state')->default(0);
            $table->integer('month')->default(0);
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
        Schema::dropIfExists('finances');
    }
}
