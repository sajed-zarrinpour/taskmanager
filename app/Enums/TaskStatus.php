<?php
namespace App\Enums;

enum TaskStatus : string {
    case PENDING = 'pending';
    case INPROGRESS = 'in_progress';
    case DONE='done';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

}