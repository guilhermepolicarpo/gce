<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHasFormColumnToTypesOfTreatmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('types_of_treatments', function (Blueprint $table) {
            $table->boolean('has_form')->default(false)->after('is_the_healing_touch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('types_of_treatments', function (Blueprint $table) {
            $table->dropColumn('has_form');
        });
    }
}
