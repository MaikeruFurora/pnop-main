<?php

namespace App\Imports;

use App\Models\Grade;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

use function PHPUnit\Framework\isNull;

class GradingImport implements ToCollection,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(int $section, int $subject)
    {
        $this->section = $section;
        $this->subject = $subject;
    }


    public function collection(Collection $rows)
    {
        $d1=null;
        $d2=null;
        $d3=null;
        $d4=null;
        $d5=null;
             foreach($rows as $row){

           if (!empty($row[0])) {
            $data= Grade::join('students','grades.student_id','students.id')
            ->where('students.roll_no',$row[0])
            ->where('grades.section_id',$this->section)
            ->where('grades.subject_id',$this->subject)
            ->first();
            
             if (!empty($row[2])) {
                 $d1=$row[2];
             }else{
                 $d1=$data->first;
             }
             if (!empty($row[3])) {
                 $d2=$row[3];
             }else{
                 $d2=$data->second;
             }
             if (!empty($row[4])) {
                 $d3=$row[4];
             }else{
                 $d3=$data->third;
             }
             if (!empty($row[5])) {
                 $d4=$row[5];
             }else{
                 $d4=$data->fourth;
             }
             if (!empty($row[6])) {
                 $d5=$row[6];
             }
             
              Grade::join('students','grades.student_id','students.id')
             ->where('students.roll_no',$row[0])
             ->where('grades.section_id',$this->section)
             ->where('grades.subject_id',$this->subject)
             ->update([
                 'grades.first'=>$d1,
                 'grades.second'=>$d2,
                 'grades.third'=>$d3,
                 'grades.fourth'=>$d4,
                 'grades.avg'=>(!empty($d5))? $d5 :((!empty($d1) && !empty($d2) && !empty($d3) && !empty($d4))? round(($d1+$d2+$d3+$d4)/4) : $data->avg)
             ]);
        
        }
       }
    }
    
    public function startRow(): int
    {
        return 6;
    }
}
