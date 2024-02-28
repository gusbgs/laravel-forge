<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
  /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'accounts';

    /**
    * The attributes that are not mass assignable.
    *
    * @var array
    */
    protected $guarded = [
      'id'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Account', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Account', 'parent_id', 'id');
    }
    
    public function skpd_accounts()
    {
        return $this->hasMany('App\SkpdAccount');
    }
    
    public function realisasi_this_month()
    {
        return $this->hasMany('App\Journal');
    }
    
    public function realisasi_this_month_after()
    {
        return $this->hasMany('App\Journal')->where('last_year', 0);
    }
    
    public function realisasi_this_month_before()
    {
        return $this->hasMany('App\Journal')->where('last_year', 1);
    }
    
    public function realisasi_until_this_month()
    {
        return $this->hasMany('App\Journal');
    }
    
    public function realisasi_until_this_month_after()
    {
        return $this->hasMany('App\Journal')->where('last_year', 0);
    }
    
    public function realisasi_until_this_month_before()
    {
        return $this->hasMany('App\Journal')->where('last_year', 1);
    }
    
    public function realisasi_until_last_month()
    {
        return $this->hasMany('App\Journal');
    }
    
    public function realisasi_until_last_month_after()
    {
        return $this->hasMany('App\Journal')->where('last_year', 0);
    }
    
    public function realisasi_until_last_month_before()
    {
        return $this->hasMany('App\Journal')->where('last_year', 1);
    }

}
