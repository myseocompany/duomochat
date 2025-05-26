<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMetaDataType extends Model{

	protected $table = "master_meta_data_types";

	public function masterMetaData()
	{
		return $this->hasMany(MasterMetaData::class, 'type_id');
	}

	public function customerMetaData()
	{
		return $this->hasMany(CustomerMetaData::class, 'type_id');
	}
}