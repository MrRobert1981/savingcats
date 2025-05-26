<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableAddRoleId extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar columna antigua
            $table->dropColumn('role');

            // Crear role_id nullable primero para evitar error
            $table->unsignedBigInteger('role_id')->nullable()->after('id');
        });


        DB::table('users')->update(['role_id' => 2]);
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable(false)->change();

            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');

            $table->string('role')->nullable();
        });
    }
}
