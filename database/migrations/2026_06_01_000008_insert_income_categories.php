<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('categories')->insert([
            [
                'user_id' => null,
                'name' => 'Salary',
                'type' => 'income',
                'icon' => 'money-bill-wave',
                'color' => '#22c55e',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => null,
                'name' => 'Other Income',
                'type' => 'income',
                'icon' => 'gift',
                'color' => '#f59e0b',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => null,
                'name' => 'Incoming transfer',
                'type' => 'income',
                'icon' => 'arrow-right',
                'color' => '#3b82f6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => null,
                'name' => 'Collect Interest',
                'type' => 'income',
                'icon' => 'percent',
                'color' => '#0f766e',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->whereIn('name', ['Salary', 'Other Income', 'Incoming transfer', 'Collect Interest'])->delete();
    }
};
