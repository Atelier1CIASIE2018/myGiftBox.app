<?php

namespace giftbox\model;

class Box extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Box";
	protected $primaryKey = "Id";
	public    $timestamps = false; 

	public function user() {
       		return $this->belongsTo('\giftbox\model\User', 'IdUser');
	}
	
	public function composer() {
     		return $this->hasMany('\giftbox\model\Composer', 'IdBox');
	}
}
