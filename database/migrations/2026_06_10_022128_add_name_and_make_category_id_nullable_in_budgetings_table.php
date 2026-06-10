<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('budgetings', function (Blueprint $table) {
            $table->string('name', 150)->nullable()->after('user_id');
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });

        // Migrate existing records to have a name
        DB::table('budgetings')
            ->join('categories', 'budgetings.category_id', '=', 'categories.id')
            ->update(['budgetings.name' => DB::raw("CONCAT('Budget ', categories.name)")]);

        // Fallback for any records that didn't get named
        DB::table('budgetings')
            ->whereNull('name')
            ->update(['name' => 'Budget Baru']);

        // Now make it not nullable
        Schema::table('budgetings', function (Blueprint $table) {
            $table->string('name', 150)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgetings', function (Blueprint $table) {
            $table->dropColumn('name');
            // Try to revert category_id nullable state. In case of existing nulls, this could fail, so it is safer to keep it nullable or allow it.
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }
};
