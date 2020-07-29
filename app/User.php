<?php

namespace App;
use App\Category;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'patronym', 'username','email', 'password','created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsToMany('App\Role');

    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function mainCat()
    {
        return $this->categories();
    }

    public function spec()
    {
        return Category::find($this->categories()->first()->parent_id);
    }

    public function categories()
    {
        return $this->morphToMany('App\Category', 'categoryable');
    }

    // public function hasAnyRoles($roles)
    // {
    //     return null !== $this->roles()->whereIn('name', $roles)->first();
    // }
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    public function hasRole($role)
    {
        return null !== $this->role()->where('name', $role)->first();
    }
}
