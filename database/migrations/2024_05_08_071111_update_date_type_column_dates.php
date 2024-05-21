<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new temporal column type date
        Schema::table('dates', function (Blueprint $table) {
            $table->date('new_date')->nullable();
        });
 
        // Updates the dates in the new column
        DB::table('dates')->whereNotNull('date')->update([
            'new_date' => DB::raw("STR_TO_DATE(date, '%d.%m.%Y')"),
        ]);
 
        // Delete the old column and rename the new one
        Schema::table('dates', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->renameColumn('new_date', 'date');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the steps in reverse order
        Schema::table('dates', function (Blueprint $table) {
            $table->string('new_date')->nullable();
        });
 
        DB::table('dates')->whereNotNull('date')->update([
            'new_date' => DB::raw("DATE_FORMAT(date, '%d.%m.%Y')"),
        ]);
 
        Schema::table('dates', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->renameColumn('new_date', 'date');
        });
    }
};