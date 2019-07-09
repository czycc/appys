<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\MaterialCategory;

class MaterialCategoryTransformer extends  TransformerAbstract {
    public function transform(MaterialCategory $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }
}