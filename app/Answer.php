<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['text','task_id', 'user_id', 'answer_type_id', 'mark', 'locked'];

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function answerType()
    {
        return $this->belongsTo('App\AnswerType');
    }

    public function attachments()
    {
        return $this->morphMany(\Yoelpc4\LaravelAttachment\Models\Attachment::class, 'attachable')
        ->where('file_attachment', \App\FileAttachments\AnswerMediaAttachment::getName());
    }

}

