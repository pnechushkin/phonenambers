<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsCalltypeAndDateaddComents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if (Schema::hasTable('coments')) {
		    Schema::table('coments', function (Blueprint $table) {
			    $table->string('colltype')->after('phone');
			    $table->string('name');
			    $table->string('status')->default('new');
			    $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
			    $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
		    });
	    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    if (Schema::hasColumn('calltype', 'created_at', 'updated_at','status','name')) {
		    Schema::table('coments', function (Blueprint $table) {
			    $table->dropColumn(['calltype', 'created_at', 'updated_at','status','name']);
		    });
	    }


    }
}
