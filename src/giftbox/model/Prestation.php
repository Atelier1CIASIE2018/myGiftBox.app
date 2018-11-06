<?php

namespace giftbox\model;

class Catalogue extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Catalogue";
	protected $primaryKey = "Id";
	public    $timestamps = false; 

	public function categorie() {
       		return $this->belongsTo('\giftbox\model\Categorie', 'IdCategorie');
	}

	public function composer() {
     		return $this->hasMany('\giftbox\model\Composer', 'IdCatalogue');
	}
}