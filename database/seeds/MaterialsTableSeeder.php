<?php

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);
        $thumbnail = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];
        $cateids = \App\Models\MaterialCategory::all()
            ->pluck('id')
            ->toArray();
        $materials = factory(Material::class)
            ->times(100)
            ->make()
            ->each(function ($material, $index) use ($faker, $thumbnail, $cateids) {
                $material->thumbnail = $faker->randomElement($thumbnail);
                $material->category_id = $faker->randomElement($cateids);
                if ($index % 2 == 0) {
                    $material->media_type = 'video';
                    $material->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/yhm/production/1.mp4';
                } else {
                    $material->media_type = 'audio';
                    $material->media_url = 'https://unitytouch.oss-cn-shanghai.aliyuncs.com/Zzc/Projects/ZhaDaBank/0102121131.mp3';
                }
            });

        Material::insert($materials->toArray());
    }

}

