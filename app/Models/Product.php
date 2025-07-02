<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $primaryKey = 'code';

    protected $table = 'cb_products';
}
