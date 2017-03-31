<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title'
    ];

    protected $with = [
        'questions'
    ];

    public function questions() {
        return $this->hasMany('App\Question');
    }

    public static function active() {
        return static::where('isActive', true)->first();
    }
}
