<?php

namespace App\Transformers;

use App\Models\Course;
use League\Fractal\TransformerAbstract;
class CourseTransformer extends TransformerAbstract {

    protected $availableIncludes = ['category', 'buynote', 'teacher', 'chapter'];

    public function transform(Course $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'banner' => $post->banner,
            'ori_price' => $post->ori_price,
            'now_price' => $post->now_price,
            'view_count' => (int)$post->view_count,
            'buy_count'=> (int)$post->buy_count,
            'recommend' => (int)$post->recommend,
            'category_id' => $post->category_id,
            'category' => $post->category->name,
            'buynote' => $post->buynote->body,
            'teacher' => $post->teacher()->select(['id', 'name', 'desc'])->first(),
            'tags' => $post->getTags(),
            'crated_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString(),
        ];
    }

    public function includeCategory(Course $post)
    {
        return $this->item($post->category, new CourseCategoryTransformer());
    }

    public function includeTeacher(Course $post)
    {
        return $this->item($post->teacher, new TeacherTransformer());
    }

    public function includeBuynote(Course $post)
    {
        return $this->item($post->buynote, new BuynoteTransformer());
    }

    public function includeChapter(Course $post)
    {
        return $this->collection($post->chapter, new ChapterTransformer(true));
    }
}