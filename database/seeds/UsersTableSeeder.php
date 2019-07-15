<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $avatars = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];
        $users = factory(\App\Models\User::class)
            ->times(20)
            ->make()
            ->each(function ($user, $index) use ($faker, $avatars) {
                $user->avatar = $faker->randomElement($avatars);
                $user->bound_id = 0;
                $user->bound_status = 0;
                if ($index > 5) {
                    $user->bound_id = $faker->numberBetween(0, 5);
                    $user->bound_status = $faker->boolean;
                }
            });

        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();
        \App\Models\User::insert($user_array);

        $user = \App\Models\User::find(1);
        $user->nickname = 'czy';
        $user->phone = '13331936826';
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200';
        $user->save();
    }
}
