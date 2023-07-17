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
        if(!Schema::hasColumn('users', 'blood_type'))
            Schema::table('users', function (Blueprint $table) {
                $table->char('blood_type',3);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('users', 'blood_type'))
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('blood_type');
            });
    }
};
