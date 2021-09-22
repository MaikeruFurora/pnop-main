<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Student;
use App\Models\Assign;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function dashboard()
    {
        return view('teacher/dashboard');
    }

    public function classMonitor()
    {
        return (Auth::user()->section) ?  view('teacher/classMonitor') : abort(403);
    }
    public function grading()
    {
        return view('teacher/grading');
    }


    public function loadMySection()
    {
        return response()->json(
            Assign::select('sections.section_name', 'sections.id', 'subjects.descriptive_title', 'assigns.subject_id')
                ->join('teachers', 'assigns.teacher_id', 'teachers.id')
                ->join('sections', 'assigns.section_id', 'sections.id')
                ->join('subjects', 'assigns.subject_id', 'subjects.id')
                ->join('school_years', 'assigns.school_year_id', 'school_years.id')
                ->where('school_years.status', 1)
                ->where('teachers.id', Auth::user()->id)
                ->get()
        );
    }
    public function loadMyStudent($section, $subject)
    {
        // insert and protect data duplication
        $toGradeStudentID =  Enrollment::select('student_id')
            ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
            ->whereNotIn(
                'student_id',
                Grade::select('student_id')
                    ->where('subject_id', $subject)
                    ->pluck('student_id')->toArray()
            )->where('enrollments.enroll_status', 'Enrolled')
            ->where('enrollments.section_id', $section)
            ->where('status', 1)
            ->get();

        /**
         * 
         * register the subj of student using load the section when the teacher want to grade
         * 
         */
        if (!empty($toGradeStudentID)) {
            foreach ($toGradeStudentID as $value) {
                $value['student_id'];
                Grade::create([
                    'student_id' => $value['student_id'],
                    'subject_id' => $subject,
                    'section_id' => $section
                ]);
            }
        }
        // sleep(3);
        return response()->json([
            'data' => Grade::select(
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
                ->where('subjects.id', $subject)
                ->where('sections.id', $section)
                ->get()
        ]);
    }

    // administrator Control and Functionalities

    public function list()
    {
        $data = array();
        $sqlData = Teacher::select("*")->get();
        foreach ($sqlData as $key => $value) {
            $arr = array();
            $arr['id'] = $value->id;
            $arr['roll_no'] = $value->roll_no;
            $arr['teacher_firstname'] = $value->teacher_firstname;
            $arr['teacher_middlename'] = $value->teacher_middlename;
            $arr['teacher_lastname'] = $value->teacher_lastname;
            $arr['teacher_gender'] = $value->teacher_gender;
            $arr['username'] = $value->username;
            $arr['orig_password'] = Crypt::decrypt($value->orig_password);
            $data[] = $arr;
        }
        // return $data;
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
        ]);

        if (isset($request->id)) {
            $dataret = Teacher::findOrFail($request->id);
        }
        $dataPass = Helper::create_password(7);
        return Teacher::updateorcreate(['id' => $request->id], [
            'teacher_firstname' => Str::title($request->firstname),
            'teacher_middlename' => Str::title($request->middlename),
            'teacher_lastname' => Str::title($request->lastname),
            'teacher_gender' => $request->gender,
            'roll_no' => empty($dataret->roll_no) ? $request->roll_no : $dataret->roll_no,
            'username' => empty($dataret->username) ? Helper::create_username($request->firstname, $request->lastname) : $dataret->username,
            'orig_password' => empty($dataret->orig_password) ? Crypt::encrypt("pnhs") : $dataret->orig_password,
            'password' => empty($dataret->password) ? Hash::make("pnhs") : $dataret->password,
        ]);
    }

    public function delete($id)
    {
        return Teacher::findOrFail($id)->delete();
    }
    public function edit(Teacher $teacher)
    {
        return response()->json($teacher);
    }

    public function assign()
    {
        $subjects = Subject::where('grade_level', Auth::user()->section->grade_level)
            ->whereIn('subject_for', [Auth::user()->section->class_type, 'GENENRAL'])
            ->get();
        $teachers = Teacher::select('id', DB::raw("CONCAT(teachers.teacher_lastname,', ',teachers.teacher_firstname,' ',teachers.teacher_middlename) as teacher_name"))->get();
        return view('teacher/assign', compact('subjects', 'teachers'));
    }

    public function assignList($section)
    {
        return response()->json(
            Assign::select('assigns.id', 'subjects.descriptive_title', DB::raw("CONCAT(teachers.teacher_lastname,', ',teachers.teacher_firstname,' ',teachers.teacher_middlename) as teacher_name"))
                ->join('subjects', 'assigns.subject_id', 'subjects.id')
                ->join('teachers', 'assigns.teacher_id', 'teachers.id')
                ->where('section_id', $section)
                ->where('school_year_id', Helper::activeAY()->id)
                ->get()
        );
    }

    public function assignStore(Request $request)
    {
        if (isset($request->id)) {
            $isSubjectisExist =  Assign::whereNotIn('id', [$request->id])->where([['section_id', $request->section_id], ['subject_id', $request->subject_id], ['school_year_id', Helper::activeAY()->id]])->exists();
            if (!$isSubjectisExist) {
                return Assign::where('id', $request->id)->update([
                    'grade_level' => $request->grade_level,
                    'school_year_id' => Helper::activeAY()->id,
                    'section_id' => $request->section_id,
                    'subject_id' => $request->subject_id,
                    'teacher_id' => $request->teacher_id,
                ]);
            } else {
                return response()->json(['warning' => "Subject is already exist!"]);
            }
        } else {
            $isSubjectisExist =  Assign::where([['section_id', $request->section_id], ['subject_id', $request->subject_id], ['school_year_id', Helper::activeAY()->id]])->exists();
            if (!$isSubjectisExist) {
                return Assign::create([
                    'grade_level' => $request->grade_level,
                    'school_year_id' => Helper::activeAY()->id,
                    'section_id' => $request->section_id,
                    'subject_id' => $request->subject_id,
                    'teacher_id' => $request->teacher_id,
                ]);
            } else {
                return response()->json(['warning' => "Subject is already exist!"]);
            }
        }
    }

    public function assignDelete(Assign $assign)
    {
        return $assign->delete();
    }

    public function assignEdit(Assign $assign)
    {
        return response()->json($assign);
    }
}
