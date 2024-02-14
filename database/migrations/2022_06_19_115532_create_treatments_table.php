<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable()->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->unsignedBigInteger('treatment_type_id')->index();
            $table->foreign('treatment_type_id')->references('id')->on('types_of_treatments');
            $table->unsignedBigInteger('mentor_id')->nullable()->index();
            $table->foreign('mentor_id')->references('id')->on('mentors');
            $table->datetime('date');
            $table->enum('treatment_mode', ['Presencial', 'A distância']);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('treatments');
    }
}
