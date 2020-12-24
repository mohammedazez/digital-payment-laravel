<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;

class Gudangpembelian extends Model
{
    protected $table = 'gudang_pembelianproduks';
    protected $primaryKey = 'id';
    public $timestamps    = false;
}
