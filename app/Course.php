<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use HasTrixRichText;
class Course extends Model
{
    protected $fillable = ['title', 'slug', 'parent_id', 'published', 'description', 'created_by', 'modified_by'];
    //
    public function categories()
    {
        return $this->morphToMany('App\Category', 'categoryable');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40)."-". \Carbon\Carbon::now()->format("dmyHis"), "-" );
    }

    public function setDescriptionAttribute($value)
    {
        if($value == NULL or !isset($value)) $value = '';
        $this->attributes['description'] = $value;
    }

    public function delete()
    {
        // delete all related photos
        $this->lessons()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }

}
