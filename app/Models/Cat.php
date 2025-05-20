<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $fillable = [
        'name',
        'date_of_birth',
        'sex',
        'is_adopted',
        'image_path',
        'owner_id',
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
