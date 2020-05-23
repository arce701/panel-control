<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'active' => 'bool',
        'last_login_at' => 'datetime',
    ];

    /**
     * @return UserQuery|Builder
     */
    public static function query()
    {
        return parent::query();
    }

    public function newEloquentBuilder($query)
    {
        return new UserQuery($query);
    }

//    public function newQueryFilter()
//    {
//        return new UserFilter();
//    }

    public function team()
    {
        return $this->belongsTo(Team::class)->withDefault();
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill')
            ->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setStateAttribute($value)
    {
        $this->attributes['active'] = $value == 'active';
    }

    public function getStateAttribute()
    {
        if ($this->active !== null) {
            return $this->active ? 'active' : 'inactive';
        }
        return $this->active;
    }

}
