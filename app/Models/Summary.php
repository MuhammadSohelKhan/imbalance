<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Line;

class Summary extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lines()
    {
    	return $this->hasMany(Line::class);
    }

    /**
     * Get all of the operations for the summary.
     */
    public function operations()
    {
        return $this->hasManyThrough(Operation::class, Line::class);
    }
}
