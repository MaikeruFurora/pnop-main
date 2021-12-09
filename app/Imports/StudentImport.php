<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
           'roll_no'=>$row[0],
           'student_firstname'=>$row[1],       
           'student_middlename'=>$row[2],       
           'student_lastname'=>$row[3],       
           'date_of_birth'=>$row[4],     
           'student_contact'=>$row[5], 
           'gender'=>$row[6],  
           'region'=>$row[7],
           'province'=>$row[8],       
           'city'=>$row[9],       
           'barangay'=>$row[10],
           'mother_name'=>$row[11],       
           'mother_contact_no'=>$row[12],       
           'father_name'=>$row[13],       
           'father_contact_no'=>$row[14],       
           'guardian_name'=>$row[15],       
           'guardian_contact_no'=>$row[16],       
           'username'=>Helper::create_username($row[1], $row[3]),  
           'orig_password'=>Crypt::encrypt("pnhs"),
           'password'=>Hash::make("pnhs")     
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
