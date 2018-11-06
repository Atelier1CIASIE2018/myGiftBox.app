<?php

namespace mygiftboxapp\model;

class Composer extends \Illuminate\Database\Eloquent\Model{
	protected $table = "Composer";
	protected $primaryKey = "Id";
	public    $timestamps = false; 
	
	public function box() {
       		return $this->belongsTo('\mygiftboxapp\model\Box', 'IdBox');
	}
	public function prestation() {
       		return $this->belongsTo('\mygiftboxapp\model\Prestation', 'IdCatalogue');
	}
   	
}
