<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    use HasFactory;
    //protected $fillable = ['id', 'Item_Name', 'Item_About', 'Item_Price', 'Item_ImageLink'];
    protected $primaryKey = 'Task_id';
}
