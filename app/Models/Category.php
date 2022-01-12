<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
    ];
    public $timestamps = false;

    /**
     * @return BelongsToMany
     */
    public function posts() : BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
