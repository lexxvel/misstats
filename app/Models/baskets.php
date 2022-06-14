<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class baskets extends Model
{
    use HasFactory;
    protected $primaryKey = "Basket_id";
    protected $fillable = ['Basket_id', 'User_id', 'Item_id', 'Item_Count', 'token'];
}
