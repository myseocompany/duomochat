<?php

namespace App\Enums;

enum MaritalStatusType: string
{
    case SINGLE = 'soltero/a';
    case MARRIED = 'casado/a';
    case DIVORCED = 'divorciado/a';
    case WIDOWED = 'viudo/a';
    case UNION = 'unión civil';


    public static function options(): array
    {
        return array_map(fn($status) => [
            'label' => ucfirst($status->value),
            'value' => $status->value,
        ], self::cases());
    }
}


