<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Phpstore\Crud\ImageLib;
use Hash;
use App\Models\Tag;
use App\Models\Account;
use Phpstore\Repository\UserRepository;

class Supplier extends Authenticatable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'supplier';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
