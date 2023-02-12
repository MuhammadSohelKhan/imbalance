<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Line;
use App\Models\Stage;

class Operation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function line()
    {
    	return $this->belongsTo(Line::class);
    }

    public function stages()
    {
    	return $this->hasMany(Stage::class);
    }
}
