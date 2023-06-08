<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\Hash ;
use \App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $rolePatient = Role::where('slug', Role::SLUG_PATIENT)->first();
        $roleDoctor = Role::where('slug', Role::SLUG_DOCTOR)->first();
        \Illuminate\Support\Facades\DB::table('users')->insert(
            array(
                [
                    'name' => 'Sample Patient',
                    'email' => 'patient@site.com',
                    'password' =>Hash::make('123'),
                    'role_id' =>$rolePatient->id,
                ],
                [
                    'name' => 'Sample Doctor',
                    'email' => 'doctor@site.com',
                    'password' =>Hash::make('123'),
                    'role_id' =>$roleDoctor->id,
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
