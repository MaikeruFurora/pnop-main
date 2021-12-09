<?php

namespace App\Exports;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class EnrollmentExport extends DefaultValueBinder implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings
{
    public function __construct(String $status, String $curriculum, int $grade_level)
    {
        $this->status = $status;
        $this->curriculum = $curriculum;
        $this->grade_level = $grade_level;
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'B') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }
        return parent::bindValue($cell, $value);
    }

    public function collection()
    {
        if ($this->status == 'All') {
            $data = Enrollment::select(
             'students.roll_no',
             'students.student_contact',
             'students.mother_contact_no',
             'students.father_contact_no',
             'enrollments.tracking_no',
             'students.guardian_contact_no', DB::raw("CONCAT(student_lastname,', ',student_firstname,' ', student_middlename) AS fullname"))
                ->join('students', 'enrollments.student_id', 'students.id')
                ->where('enrollments.grade_level', $this->grade_level)
                ->where('enrollments.school_year_id', Config::get('activeAY')->id)
                ->where('enrollments.curriculum', strtoupper($this->curriculum))
                ->orderBy('enrollments.curriculum','asc')
                ->get();
        } else {
            $data = Enrollment::select('students.student_contact', 'students.mother_contact_no', 'students.father_contact_no', 'students.guardian_contact_no', DB::raw("CONCAT(student_lastname,', ',student_firstname,' ', student_middlename) AS fullname"))
                ->join('students', 'enrollments.student_id', 'students.id')
                ->where('enrollments.enroll_status', $this->status)
                ->where('enrollments.grade_level', $this->grade_level)
                ->where('enrollments.school_year_id', Config::get('activeAY')->id)
                ->where('enrollments.curriculum', strtoupper($this->curriculum))
                ->orderBy('enrollments.curriculum','asc')
                ->get();
        }
        return $data;
    }

    public function map($data): array
    {
        return [
            $data->tracking_no,
            strval($data->roll_no),
            $data->fullname,
            $data->mother_contact_no,
            $data->father_contact_no,
            $data->guardian_contact_no,
            $data->student_contact,
        ];
    }

    public function headings(): array
    {
        return [
            'ENROLMENT NO.',
            'LRN',
            'STUDENT NAME',
            'MOTHER CONTACT NO',
            'FATHER CONTACT NO',
            'GUARDIAN CONTACT NO',
            'STUDENT CONTACT NO',
        ];
    }
}
