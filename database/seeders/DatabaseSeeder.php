<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Device;
use App\Models\Message;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        /** Message seeder */
        Message::create([
            'name' => 'Auto',
            // 'message' => 'Message Auto...',
            'message' => "*Data di bawah sudah di tambahkan ke database:*
            Nama: {name}
            Gender: {gender}
            Email: {email}
            Alamat: {address}
            No HP : {hp}
            berhasil ditambahkan pada : {created_at}",
            'is_auto' => '1'
        ]);

        /** Device seeder */
        Device::create([
            'phone' => '628xxx....'
        ]);
    }
}
