<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function adoptionApplications()
    {
        return $this->hasMany(AdoptionApplication::class, 'status_id');
    }
}
