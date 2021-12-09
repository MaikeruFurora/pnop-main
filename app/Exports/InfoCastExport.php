<?php

namespace App\Exports;

use App\Models\Enrollment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InfoCastExport implements FromCollection,WithHeadings,WithCustomCsvSettings
{
    public function __construct(String $status, String $curriculum, int $grade_level)
    {
        $this->status = $status;
        $this->curriculum = $curriculum;
        $this->grade_level = $grade_level;
    }

    public function collection()
    {
        return Enrollment::select(
            'students.mother_contact_no',
             DB::raw("CONCAT(student_lastname,' ',student_firstname,' ', student_middlename) AS fullname"),
             'enrollments.tracking_no',
             'students.barangay',
             )
               ->join('students', 'enrollments.student_id', 'students.id')
               ->where('enrollments.grade_level', $this->grade_level)
               ->where('enrollments.school_year_id', Config::get('activeAY')->id)
               ->where('enrollments.curriculum', strtoupper($this->curriculum))
               ->whereNotNull('students.mother_contact_no')
               ->orderBy('enrollments.curriculum','asc')
               ->get();
    }
    public function map($data): array
    {
        return [
            $data->mother_contact_no,
            $data->fullname,
            $data->tracking_no,
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
