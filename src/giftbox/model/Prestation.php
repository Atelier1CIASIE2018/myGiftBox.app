<?php

namespace giftbox\model;

class Prestation extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Prestation";
	protected $primaryKey = "Id";
	public    $timestamps = false; 

	public function categorie() {
       		return $this->belongsTo('\giftbox\model\Categorie', 'IdCategorie');
	}

	public function composer() {
     		return $this->hasMany('\giftbox\model\Composer', 'IdCatalogue');
	}
}