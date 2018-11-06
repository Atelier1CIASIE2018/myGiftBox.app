<?php

namespace mygiftboxapp\model;

class Catalogue extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Catalogue";
	protected $primaryKey = "Id";
	public    $timestamps = false; 
<<<<<<< HEAD

	public function categorie() {
       		return $this->belongsTo('\mygiftboxapp\model\Categorie', 'IdCategorie');
	}

	public function composer() {
     		return $this->hasMany('\mygiftboxapp\model\Composer', 'IdCatalogue');
	}
=======
>>>>>>> 819c5560521aeed497ab73af9d8c53463ca0b503
}
