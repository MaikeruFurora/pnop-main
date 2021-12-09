<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TeacherImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Teacher([
            'roll_no'=>$row[0],
            'teacher_firstname'=>$row[1],
            'teacher_middlename'=>$row[2],
            'teacher_lastname'=>$row[3],
            'teacher_gender'=>$row[4],
            'username'=>Helper::create_username($row[1], $row[2]),
            'orig_password'=>Crypt::encrypt("pnhs"),
            'password'=>Hash::make("pnhs")
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
