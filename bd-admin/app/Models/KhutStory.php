<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhutStory extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subject', 'details', 'is_active', 'image'];
}
