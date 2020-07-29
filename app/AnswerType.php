<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerType extends Model
{
    protected $fillable = ['name', 'displayname', 'task_id', 'max_files', 'max_symbols'];

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
