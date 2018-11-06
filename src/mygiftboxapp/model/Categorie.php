<?php

namespace mygiftboxapp\model;

class Categorie extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Categorie";
	protected $primaryKey = "Id";
	public    $timestamps = false; 

	public function prestation() {
     		return $this->hasMany('\mygiftboxapp\model\Prestation', 'IdCategorie');
	}
}
