<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'cb_categories';
    protected $fillable = ['name', 'slug', 'description'];
}
