<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFestivalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('festivals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->comment('Название фестиваля');
            $table->text('description')->nullable()->comment('Описание фестиваля');
            $table->date('date_start')->comment('Начала фестиваля');
            $table->date('date_end')->comment('Окончание фестиваля');
            $table->integer('status')->comment('Статус фестиваля');
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
        Schema::dropIfExists('festivals');
    }
}
