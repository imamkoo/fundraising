<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('fundraising_phases', function (Blueprint $table) {
        $table->string('photo')->change();
    });
}
public function down()
{
    Schema::table('fundraising_phases', function (Blueprint $table) {
        $table->boolean('photo')->change(); 
    });
}

};
