<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{

    protected $fillable = [
        'name',
        'description'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_species');
    }
}
