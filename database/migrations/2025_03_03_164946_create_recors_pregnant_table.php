<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recors_pregnant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("recorded_by")->nullable();
            $table->double("weight")->nullable();
            $table->double("height")->nullable();
            $table->double("age_at_pregnancy")->nullable();
            $table->boolean("young_pregnant")->nullable();
            $table->boolean("old_pregnant")->nullable();
            $table->boolean("overlong_pregnant")->nullable();
            $table->boolean("late_pregnant")->nullable();
            $table->boolean("early_pregnant")->nullable();
            $table->boolean("much_child")->nullable();
            $table->boolean("miscarriage")->nullable();
            $table->boolean("vacum_birth")->nullable();
            $table->boolean("retained_placenta")->nullable();
            $table->boolean("tranfused")->nullable();
            $table->boolean("csection")->nullable();
            $table->boolean("anemia")->nullable();
            $table->boolean("malaria")->nullable();
            $table->boolean("tbc")->nullable();
            $table->boolean("hearth_failure")->nullable();
            $table->boolean("std")->nullable();
            $table->boolean("hypertension")->nullable();
            $table->boolean("twin_birth")->nullable();
            $table->boolean("hydranion")->nullable();
            $table->boolean("over_pregnant")->nullable();
            $table->boolean("death_baby")->nullable();
            $table->boolean("breech")->nullable();
            $table->boolean("oblique")->nullable();
            $table->boolean("preeklampsia")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recors_pregnant');
    }
};
