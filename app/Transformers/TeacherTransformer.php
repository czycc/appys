<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Teacher;

class TeacherTransformer extends  TransformerAbstract {
    public function transform(Teacher $teacher)
    {
        return [
            'id' => $teacher->id,
            'name' => $teacher->name,
            'video_url' => $teacher->video_url,
            'imgs' => $teacher->imgs
        ];
    }
}