<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notas extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'tags', 'due_date', 'image'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
