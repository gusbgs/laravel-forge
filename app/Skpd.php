<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'skpd';

  /**
   * The attributes that are not mass assignable.
   *
   * @var array
   */
  protected $guarded = [
    'id'
  ];

  public function journals()
  {
    return $this->hasMany(Journal::class, 'skpd_id', 'id');
  }
}
