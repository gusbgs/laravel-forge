<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  /**
* The table associated with the model.
*
* @var string
*/
protected $table = 'roles';

/**
* The attributes that are not mass assignable.
*
* @var array
*/
protected $guarded = [
  'id'
];
}
