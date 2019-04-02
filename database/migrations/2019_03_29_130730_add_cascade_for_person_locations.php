<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//use Illuminate\Support\Facades\DB;

class AddCascadeForPersonLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('person_locations', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
            $table->foreign('person_id')
                ->references('id')
                ->on('people')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('person_locations', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
            $table->foreign('person_id')
                ->references('id')
                ->on('people');
        });
    }
}
