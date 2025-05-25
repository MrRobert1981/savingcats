<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cats', function (Blueprint $table) {
            $table->unsignedBigInteger('sex_id')->nullable()->after('id');
        });

        // Actualizar sex_id según sex (male/female)
        DB::table('cats')->where('sex', 'male')->update(['sex_id' => DB::table('sexes')->where('name', 'male')->value('id')]);
        DB::table('cats')->where('sex', 'female')->update(['sex_id' => DB::table('sexes')->where('name', 'female')->value('id')]);

        Schema::table('cats', function (Blueprint $table) {
            $table->foreign('sex_id')->references('id')->on('sexes')->onDelete('restrict');
            $table->dropColumn('sex');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('cats', function (Blueprint $table) {
            $table->dropForeign(['sex_id']);
            $table->dropColumn('sex_id');
            $table->enum('sex', ['male', 'female'])->after('id');
        });
    }
};
