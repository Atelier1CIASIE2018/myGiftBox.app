<?php

namespace giftbox\model;

class User extends \Illuminate\Database\Eloquent\Model{
	protected $table = "User";
	protected $primaryKey = "id";
	public    $timestamps = false; 

	public function box() {
     		return $this->hasMany('\giftbox\model\Box', 'IdUser');
	}
}

