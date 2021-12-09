<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class NumberExport implements FromCollection,ShouldAutoSize, WithHeadings,WithCustomCsvSettings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $date)
    {
        $this->date = $date;
    }
    public function collection()
    {
        $formatedDate = date("m/d/Y", strtotime(strtr($this->date, '-', '/')));
        $data= Appointment::select('contact_no','fullname','age','address')->where('set_date', strval($formatedDate))->get();
        return $data;
    }
    public function map($data): array
    {
        return [
            $data->contact_no,
            $data->fullname,
            $data->age,
            $data->address,
        ];
    }

    public function headings(): array
    {
        return [
            'Mobile Number',
            'Name',
            'Age',
            'Address'
        ];
    }
    
    public function getCsvSettings(): array
    {
        return [
            'enclosure' => ''
        ];
    }
}
