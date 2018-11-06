<?php

namespace mygiftboxapp\model;

class Box extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Box";
	protected $primaryKey = "Id";
	public    $timestamps = false; 

	public function user() {
       		return $this->belongsTo('\mygiftboxapp\model\User', 'IdUser');
	}
	
	public function composer() {
     		return $this->hasMany('\mygiftboxapp\model\Composer', 'IdBox');
	}
}
