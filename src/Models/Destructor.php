<?php

namespace RobertHucks\SelfDestruct\Models;

use Illuminate\Database\Eloquent\Model;

class Destructor extends Model
{
    protected $table = 'self_destruct';
    protected $fillable = [
        'deletable_type',
        'deletable_id',
        'ttl'
    ];
    public $timestamps = false;
}