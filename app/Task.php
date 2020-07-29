<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'lesson_id', 'created_by', 'modified_by', 'sort', 'answer_type_id'];
    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }


    public function answerType()
    {
        return $this->belongsTo('App\AnswerType');
    }

    public function attachments()
    {
        return $this->morphMany(\Yoelpc4\LaravelAttachment\Models\Attachment::class, 'attachable')
        ->where('file_attachment', \App\FileAttachments\TaskMediaAttachment::getName());
    }
}
