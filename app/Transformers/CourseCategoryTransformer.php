<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\CourseCategory;

class CourseCategoryTransformer extends  TransformerAbstract {
    public function transform(CourseCategory $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }
}