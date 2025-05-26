<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMetaData extends Model
{
    protected $table = "master_meta_datas";
    
    public function children()
    {
        return $this->hasMany(MasterMetaData::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(MasterMetaDataType::class, 'type_id');
    }

    
}
