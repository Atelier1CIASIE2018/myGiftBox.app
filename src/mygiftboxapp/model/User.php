<?php

namespace mygiftboxapp\model;

class User extends \Illuminate\Database\Eloquent\Model{
	protected $table = "User";
	protected $primaryKey = "Id";
	public    $timestamps = false; 

	public function box() {
     		return $this->hasMany('\mygiftboxapp\model\Box', 'IdUser');
	}

}

