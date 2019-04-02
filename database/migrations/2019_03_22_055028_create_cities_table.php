<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');

            $table->string('name', 100);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->index('name', 'city_name_index');
        });

        $russiaId = DB::table('countries')->where('country_code', 'RU')->value('id');


        DB::table('cities')->insert([
            ['country_id' => $russiaId, 'name' => 'Smolensk', 'latitude' => 54.782635, 'longitude' => 32.045251],
            ['country_id' => $russiaId, 'name' => 'Saint Petersburg', 'latitude' => 59.939095, 'longitude' => 	30.315868],
            ['country_id' => $russiaId, 'name' => 'Moscow', 'latitude' => 55.753215, 'longitude' => 	37.622504]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
