<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member = [
            [
                'nama' => 'Member1',
                'parent_id' => 0,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member2',
                'parent_id' => 0,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member3',
                'parent_id' => 0,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member4',
                'parent_id' => 0,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member5',
                'parent_id' => 1,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member6',
                'parent_id' => 2,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member7',
                'parent_id' => 2,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member8',
                'parent_id' => 3,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member9',
                'parent_id' => 5,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member10',
                'parent_id' => 5,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member11',
                'parent_id' => 5,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member12',
                'parent_id' => 7,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member13',
                'parent_id' => 8,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member14',
                'parent_id' => 13,
                'status' => 'aktif'
            ],
            [
                'nama' => 'Member15',
                'parent_id' => 13,
                'status' => 'aktif'
            ],
        
        ];

        foreach ($member as $mmbr) {
            Member::create($mmbr);
        }
    }
}
