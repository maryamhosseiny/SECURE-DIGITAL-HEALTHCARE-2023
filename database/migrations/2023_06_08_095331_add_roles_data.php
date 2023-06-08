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
        \Illuminate\Support\Facades\DB::table('roles')->insert(
            array(
                [
                    'title' => 'doctor',
                    'slug' => \App\Models\Role::SLUG_DOCTOR,
                ],
                [
                    'title' => 'patient',
                    'slug' => \App\Models\Role::SLUG_PATIENT,
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
