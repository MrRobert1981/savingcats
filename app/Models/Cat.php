<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $fillable = [
        'sex_id',
        'name',
        'date_of_birth',
        'is_adopted',
        'adoption_date',
        'image_path',
        'owner_id'
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }

}
