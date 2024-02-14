<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnStatusToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['status']);
            $table->dropColumn(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('status')->nullable()->index();
            $table->foreign('status')->references('id')->on('treatments');
        });

        Schema::table('appointments', function (Blueprint $table) {
            DB::statement('UPDATE appointments SET status = treatment_id');
        });
    }
}
