<?php

namespace App\Domain\User\Entities;

//use Laravel\Passport\HasApiTokens;
//use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Domain\User\Entities\Traits\Relations\UserRelations;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Domain\Users\Repositories\Contracts\TeamRepository;
use App\Domain\User\Entities\Traits\CustomAttributes\UserAttributes;
use App\Domain\User\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, UserRelations, UserAttributes, HasFactory;

    /**
     * @var array
     */
    public static $logAttributes = ["*"];

    /**
     * The attributes that are going to be logged.
     *
     * @var array
     */
    protected static $logName = 'User';

    /**
     * define belongsTo relations.
     *
     * @var array
     */
    private $belongsTo = [];

    /**
     * define hasMany relations.
     *
     * @var array
     */
    private $hasMany = [];

    /**
     * define belongsToMany relations.
     *
     * @var array
     */
    private $belongsToMany = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activation_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Holds Repository Related to current Model.
     *
     * @var array
     */
    protected $routeRepoBinding = UserRepository::class;
}
