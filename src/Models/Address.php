<?php

namespace Jasester\LaravelChinaAddress\Models;

use Illuminate\Database\Eloquent\Model;
use Jasester\LaravelChinaAddress\AddressTrait;

class Address extends Model{

    use AddressTrait;

    public $timestamps = false;

    protected $primaryKey = 'code';

    protected $fillable = ['code', 'name', 'parent_code'];

    public function getRouteKeyName()
    {
        return 'code';
    }
}
