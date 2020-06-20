<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'email', 'logo_path', 'website'];

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function getLogoPathAttribute($path) {
        return $path ?: 'default.png';
    }
}
