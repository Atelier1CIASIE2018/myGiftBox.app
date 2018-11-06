<?php

namespace mygiftboxapp\model;

class Prestation extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Prestation";
	protected $primaryKey = "Id";
	public    $timestamps = false; 

	public function categorie() {
       		return $this->belongsTo('\mygiftboxapp\model\Categorie', 'IdCategorie');
	}

	public function composer() {
     		return $this->hasMany('\mygiftboxapp\model\Composer', 'IdCatalogue');
	}
}
