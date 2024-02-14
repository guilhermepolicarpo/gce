<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnToAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['Não atendido', 'Em espera', 'Em atendimento', 'Atendido', 'Faltou'])->default('Não atendido');
        });

        Schema::table('appointments', function (Blueprint $table) {
            DB::table('appointments')->whereNotNull('treatment_id')->update(['status' => 'Atendido']);
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
            $table->dropColumn('status');
        });
    }
}
