<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelfDestructTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_destruct', function (Blueprint $table) {
            $table->increments('id');
            $table->string('deletable_type', 100);
            $table->string('deletable_id', 50);
            $table->timestamp('ttl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('self_destruct');
    }
}
