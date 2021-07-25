<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->uuid('id')->index();
            $table->string('name')
                ->unique()->comment('Наименования промо кода');

            $table->date('date_start')->nullable()
                ->comment('Дата начала проведения промо кода, null бессрочно');
            $table->date('date_end')->nullable()
                ->comment('Дата начала окончание промо кода, null бессрочно');
            $table->integer('delta_price')
                ->comment('Изменения цены');
            $table->string('delta_type')->default('Scalar')
                ->comment('Тип изменения цены');

            $table->boolean('active')
                ->default(true)
                ->comment('Активность промо кода');

            $table->uuid('festival_id');

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('promo_codes');
    }
}
