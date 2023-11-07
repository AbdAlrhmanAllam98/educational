<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes;
    protected $fillable = ['user_name', 'password', 'is_super_admin'];
    protected $hidden = ['password'];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'created_by', 'id');
    }
    public function exams()
    {
        return $this->hasMany(Exam::class, 'created_by', 'id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class, 'created_by', 'id');
    }
    public function homeworks()
    {
        return $this->hasMany(Homework::class, 'created_by', 'id');
    }
    public function codes()
    {
        return $this->hasMany(Code::class, 'created_by', 'id');
    }
}
