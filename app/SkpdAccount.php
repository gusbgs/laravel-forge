<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkpdAccount extends Model
{
  /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'skpd_accounts';
    
    /**
    * The attributes that are not mass assignable.
    *
    * @var array
    */
    protected $guarded = [
      'id'
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Account');
    }
    
    public function skpd()
    {
        return $this->belongsTo('App\Skpd');
    }
}
