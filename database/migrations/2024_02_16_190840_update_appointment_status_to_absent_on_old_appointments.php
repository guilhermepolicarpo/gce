<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAppointmentStatusToAbsentOnOldAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            DB::table('appointments')
            ->where('date', '<', now())
            ->where('status', '=', 'Não atendido')
            ->update(['status' => 'Faltou']);
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
            DB::table('appointments')
            ->where('date', '<', now())
            ->where('status', '=', 'Faltou')
            ->update(['status' => 'Não atendido']);
        });
    }
}
