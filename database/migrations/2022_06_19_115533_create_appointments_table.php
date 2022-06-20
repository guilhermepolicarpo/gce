<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable()->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('treatment_type_id')->nullable()->index();
            $table->foreign('treatment_type_id')->references('id')->on('types_of_treatments');
            $table->date('date');
            $table->unsignedBigInteger('treatment_id')->nullable()->index();
            $table->foreign('treatment_id')->references('id')->on('treatments');
            $table->enum('treatment_mode', ['Presencial', 'A distância']);
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
        Schema::dropIfExists('appointments');
    }
}
