<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CompanyPostsTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(ChaptersTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);

    }
}
