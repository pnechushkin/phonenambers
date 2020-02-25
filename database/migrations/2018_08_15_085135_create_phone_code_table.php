<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create( 'phone_code', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('area_code',3)->nullable(false);
		    $table->string('sub_code',3)->nullable(false);
		    $table->string('city')->nullable(false);
		    $table->string('province')->nullable(false);
		    $table->string('country')->nullable()->default('CA');
		    $table->float('lat')->nullable(false);
		    $table->float('long')->nullable(false);
		    $table->string('timezone')->nullable(false);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists( 'phone_code' );
    }
}
