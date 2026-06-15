<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'image',
        'level',
        'status',
        'role_id',
        'permission',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        //return $this->hasMany('App\Models\Permission');
        return $this->belongsTo('App\Models\Permission', 'role_id');
    }

    public function sectionCheck($value){
        //print 'a'; die;
        //$sections = json_decode($this->role->section,true);
        // print '<pre>'; print_r($this->role->permission); die;
        $sections = unserialize($this->role->permission);
        //print '<pre>'; print_r($sections); die;
        if (is_array($sections) && in_array($value, $sections)){
            return true;
        }else{
            return false;
        }
    }
}
