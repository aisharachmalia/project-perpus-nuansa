<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        "menu_nama",
        "menu_parent ",
        "menu_url ",
        "menu_icon",
        "menu_urut",
        "menu_stat"
    ];
}
