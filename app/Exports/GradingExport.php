<?php

namespace App\Exports;

use App\Helpers\Helper;
use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class GradingExport extends DefaultValueBinder implements  FromView,ShouldAutoSize,WithEvents,WithStyles,WithCustomValueBinder
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use RegistersEventListeners;

    public function __construct(int $section, int $subject)
    {
        $this->section = $section;
        $this->subject = $subject;
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'A') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }
        return parent::bindValue($cell, $value);
    }
 
    public function view(): View
    {
        $data=null;
            $data=Grade::select(
                "sections.section_name",
                "sections.grade_level",
                "students.roll_no",
                "students.id as sid",
                "grades.id as gid",
                "grades.first",
                "grades.second",
                "grades.third",
                "grades.fourth",
                "grades.avg",
                "subjects.descriptive_title",
                DB::raw("CONCAT(students.student_lastname,', ',students.student_firstname,' ',students.student_middlename) as fullname")
            )->join('students', 'grades.student_id', 'students.id')
                ->join('enrollments', 'grades.student_id', 'enrollments.student_id')
                ->join('sections', 'enrollments.section_id', 'sections.id')
                ->join('subjects', 'grades.subject_id', 'subjects.id')
                ->where('enrollments.enroll_status', "Enrolled")
                ->where('enrollments.school_year_id', Helper::activeAY()->id)
                ->where('subjects.id', $this->subject)
                ->where('sections.id', $this->section)
                ->get();
            return view('teacher/partial/gradingExport',compact('data'));
      
        
    }


    public static function afterSheet(AfterSheet $event)
    {
        // Create Style Arrays
        $default_font_style = [
            'font' => [ 'size' => 13]
        ];

        $strikethrough = [
            'font' => ['strikethrough' => true],
        ];

        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();

        // Apply Style Arrays
        $active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);

          $event->sheet->getStyle('A1:G50')->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ]);

            $event->sheet->getDelegate()->getStyle('A4:F4')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('EEEEEE');
      
        
        $event->sheet->getDelegate()->getStyle('C4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true,'size' => 13]],
            2    => ['font' => ['bold' => true,'size' => 13]],
            3    => ['font' => ['bold' => true,'size' => 13]],
            4    => ['font' => ['bold' => true,'size' => 13]],
            5    => ['font' => ['bold' => true,'size' => 13]],

            // Styling a specific cell by coordinate.
            'A1:B1' => ['font' => ['italic' => true]],
            'A2:B2' => ['font' => ['italic' => true]],
            'A3:B3' => ['font' => ['italic' => true]],

            // Styling an entire column.
        //    'C'  => ['font' => ['size' => 14]],
        ];
    }
  

}
