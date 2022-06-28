

<?php


use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;



class CreateVdcormunicipalitiesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('vdcormunicipalities', function (Blueprint $table) {

            $table->id();

            $table->string('municipalityname');

            $table->integer('districtid');

            $table->enum('status', ['Y', 'C','R'])->default('Y');

        });

    }



    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::dropIfExists('vdcormunicipalities');

    }

}

