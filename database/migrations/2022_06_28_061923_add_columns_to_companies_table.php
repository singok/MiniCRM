<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('provinceid')->after('email');
            $table->unsignedBigInteger('districtid')->after('provinceid');
            $table->unsignedBigInteger('vdcormunicipalityid')->after('districtid');
            $table->foreign('provinceid')->references('id')->on('provinces')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('provinceid');
            $table->dropColumn('districtid');
            $table->dropColumn('vdcormunicipalityid');
        });
    }
};
