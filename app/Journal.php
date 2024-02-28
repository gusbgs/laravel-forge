<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];
    public $timestamps = true;
    protected $fillable = ['evidance', 'description', 'value','created_at','updated_at', 'verify_by', 'verify_at'];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function skpd()
    {
        return $this->belongsTo('App\Skpd');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
