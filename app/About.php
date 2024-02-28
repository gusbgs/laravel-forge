<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
  /**
* The table associated with the model.
*
* @var string
*/
protected $table = 'abouts';

/**
* The attributes that are not mass assignable.
*
* @var array
*/
protected $guarded = [
  'id'
];
}
