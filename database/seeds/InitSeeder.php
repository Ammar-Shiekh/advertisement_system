<?php

use App\Device;
use App\Role;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed roles
        $roles = ['administrator', 'publisher'];
        foreach($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Seed admin
        Role::where('name', 'administrator')->first()
            ->users()->create([
                'name' => 'Admin',
                'email' => 'admin@system.com',
                'password' => '$2y$10$7FeLPtByNZQtSOyfZcLm7.RttEFyd3luWPzF1uXF9cwgxms.1l2EC',
            ]);

        // Seed devices
        $devices = ['Device 1', 'Device 2', 'Device 3'];
        foreach($devices as $device) {
            Device::create([
                'name' => $device,
                'password' => '$2y$10$7FeLPtByNZQtSOyfZcLm7.RttEFyd3luWPzF1uXF9cwgxms.1l2EC',
            ]);
        }

        // Seed publishers
        $publishers = ['Ahmad', 'Usama', 'Mohammad'];
        $publisher_role = Role::where('name', 'publisher')->first();
        foreach($publishers as $publisher) {
            $publisher_role->users()->create([
                'name' => $publisher,
                'email' => strtolower($publisher).'@system.com',
                'password' => '$2y$10$7FeLPtByNZQtSOyfZcLm7.RttEFyd3luWPzF1uXF9cwgxms.1l2EC',
            ]);
        }
    }
}
