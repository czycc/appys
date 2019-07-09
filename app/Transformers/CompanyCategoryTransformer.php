<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\CompanyCategory;

class CompanyCategoryTransformer extends  TransformerAbstract {
    public function transform(CompanyCategory $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'parent_id' => $category->parent_id
        ];
    }
}