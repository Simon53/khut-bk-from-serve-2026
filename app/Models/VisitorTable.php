<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorTable extends Model
{
    protected $table = 'visitor_tables';

    protected $fillable = ['ip_address', 'visit_time'];

    public $timestamps = false; // কারণ টেবিলে created_at, updated_at নেই
}