<?php

namespace giftbox\model;

class Categorie extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Categorie";
	protected $primaryKey = "id";
	public    $timestamps = false; 

	public function prestation() {
     		return $this->hasMany('\giftbox\model\Prestation', 'IdCategorie');
	}
}
