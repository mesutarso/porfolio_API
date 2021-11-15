<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'url', 'image'];
    public function typeServices()
    {
        return $this->belongsToMany(TypeService::class);
    }
}
