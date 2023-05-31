<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->createUser('hr', 'Fajar Hamdani HR', 'hr1');

        for ($i = 1; $i <= 10; $i++) {
            $this->createUser('employee', "Karyawan $i", "employee$i");
        }
    }

    private function createUser($role, $name, $username)
    {
        $user = new \App\Models\User();
        $user->role = $role;
        $user->name = $name;
        $user->username = $username;
        $user->password = \Hash::make('12345678');
        $user->save();
    }
}
