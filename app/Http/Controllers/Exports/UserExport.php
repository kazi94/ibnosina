<?php
namespace App\Http\Controllers\Exports;

use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use WithColumnFormatting;

class UserExport implements WithColumnFormatting, WithMapping
{
    public function map($user): array
    {
        return [
            $user->id,
            Date::dateTimeToExcel($user->created_at),
            $user->prenom
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
}
