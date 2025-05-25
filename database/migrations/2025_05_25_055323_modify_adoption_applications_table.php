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
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->unsignedBigInteger('status_id')->after('id');
            $table->foreign('status_id')->references('id')->on('adoption_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
            $table->enum('state', ['pending', 'accepted', 'rejected'])->after('id');
        });
    }
};


