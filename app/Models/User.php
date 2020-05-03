<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Admin\Models\Tour;
use Modules\Admin\Models\UserComment;
use Modules\Admin\Models\UserTour;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;


    protected $fillable = [
        'name', 'email', 'password', 'birth_date', 'gender', 'created_at', 'email_verified_at', 'remember_token'
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

    /*
     * Профиль пользователя
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /*
     * Мероприятия этого ведущего
     */
    public function tours()
    {
        return $this->belongsToMany(
            Tour::class,
            'tour_leader',
            'leader_id',
            'tour_id'
        );
    }

    /*
     * Мероприятия с категориями этого ведущего
     */
    public function tours_with_category()
    {
        return $this->belongsToMany(
            Tour::class,
            'tour_leader',
            'leader_id',
            'tour_id'
        )->with('category');
    }

    /**
     * Ведущие этого организатора
     */
    public function leaders()
    {
        return $this->belongsToMany(
            self::class,
            'organizer_leader',
            'organizer_id',
            'leader_id',
            'id',
            'id'
        )->with('profile');
    }

    /*
     * Комментарии об этом пользователе
     */
    public function comments()
    {
        return $this->hasMany(UserComment::class, 'author_id');
    }

    /**
     * Категории туров где есть пользователь
     */
    /*public function tours_with_category(){
        return $this->hasMany(Tour::class)->with('category');
    }*/


    /*
    * Мероприятия этого организатора
    */
    /*public function orginization_tours()
    {
        return $this->belongsToMany(Tour::class);
    }*/
}
