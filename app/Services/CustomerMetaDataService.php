<?php

namespace App\Services;

use App\Models\MasterMetaData;
use App\Models\CustomerMetaData;

class CustomerMetaDataService
{

    
public function getFieldsForCustomer($parentId, $customerId)
{
    $fields = MasterMetaData::with(['type', 'children']) // ← importante
        ->where('parent_id', $parentId)
        ->get();

    return $fields->map(function ($field) use ($customerId) {
        $value = CustomerMetaData::where('master_meta_data_id', $field->id)
            ->where('customer_id', $customerId)
            ->value('value');

        $typeName = $field->type->name ?? 'Texto';
        $options = [];

        if (in_array($typeName, ['Select', 'Radio', 'Checkbox'])) {
            $options = $field->children->map(function ($option) use ($value) {
                return (object)[
                    'id' => $option->id,
                    'name' => $option->label,
                    'selected' => $value == $option->id
                ];
            });
        }

        return [
            'label' => $field->label,
            'value' => $value ?? '',
            'type' => $typeName,
            'options' => $options,
            'master_meta_datas_id' => $field->id,
        ];
    });
}

}
