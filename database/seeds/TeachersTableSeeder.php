<?php

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeachersTableSeeder extends Seeder
{
    public function run()
    {
        factory(Teacher::class, 10)->create();
    }

}