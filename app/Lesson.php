<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
class Lesson extends Model
{
    use HasTrixRichText;
    protected $guarded = [];
    protected $fillable = ['title', 'slug', 'course_id', 'published', 'sort', 'description','created_by', 'modified_by'];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function attachments()
    {
        return $this->morphMany(\Yoelpc4\LaravelAttachment\Models\Attachment::class, 'attachable')
        ->where('file_attachment', \App\FileAttachments\LessonMediaAttachment::getName());
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40)."-". \Carbon\Carbon::now()->format("dmyHis"), "-" );
    }

    public function delete()
    {
        // delete all related photos
        $this->tasks()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }

}
