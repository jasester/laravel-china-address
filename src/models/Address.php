<?php

namespace Jasester\LaravelChinaAddress;

use Illuminate\Database\Eloquent\Model;

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
