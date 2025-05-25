<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sex extends Model
{
    use HasFactory;

    protected $table = 'sexes';

    protected $fillable = ['name'];

    public function cats()
    {
        return $this->hasMany(Cat::class);
    }

}

