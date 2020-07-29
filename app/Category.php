<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['title', 'slug', 'parent_id', 'published'];
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40)."-". \Carbon\Carbon::now()->format("dmyHis"), "-" );
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }


    public function courses()
    {
        return $this->belongsToMany('App\Course', 'categoryables', 'category_id', 'categoryable_id');
    }
    //
}
