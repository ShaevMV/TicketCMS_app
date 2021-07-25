<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeRegistrationFestivalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_registration_festival', function (Blueprint $table) {
            $table->uuid('type_registration_id')->index();
            $table->uuid('festival_id')->index();
            $table->integer('price')->unsigned()->nullable()->comment('Цена типа билета');
            $table->json('params')->nullable()->comment('Параметры проходки');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_registration_festival');
    }
}
