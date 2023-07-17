<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    use HasFactory;
    protected $table = 'certificates';

    public function users()
    {
        return $this->belongsToMany(User::class, 'certificate_user')->withTimestamps();
    }
}