<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'title',
        'text',
        'image',
        'user_id',
        'is_active',
    ];

    public function species()
    {
        return $this->belongsToMany(Species::class, 'post_species');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
