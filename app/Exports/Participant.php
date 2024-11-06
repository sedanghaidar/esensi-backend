<?php

namespace app\Exports;

use App\Models\Participant as P;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class Participant implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{

    public function __construct($id, $isLimit)
    {
        $this->id = $id;
        $this->isLimit = $isLimit;
    }

    public function map($data): array
    {
        return [
            $data->name,
            $data->jabatan,
            $data->instansi,
        ];
    }

    public function headings(): array
    {
        return [
            'NAMA',
            'JABATAN',
            'INSTANSI',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DMYMINUS,
            // 'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }

    public function collection()
    {
        $participant =  P::where('activity_id', '=', $this->id);
        if ($this->isLimit == 1) {
            $participant = $participant->whereNotNull('scanned_at');
        }
        return $participant->get();
    }
}
