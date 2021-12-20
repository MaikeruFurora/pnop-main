<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Announcement;
use App\Models\Student;
use App\Models\Assign;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\SchoolProfile;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\NotifyUser;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $post = Announcement::latest()->get();
        return view('teacher/dashboard',compact('post'));
    }

    public function classMonitor()
    {
        $infoTeacher =  Section::where('teacher_id',auth()->user()->id)->where('school_year_id',  Helper::activeAY()->id)->first();
        if ($infoTeacher) {
 
            $total = Enrollment::select('sections.section_name', DB::raw('count(if(gender="Female",1,NULL)) as ftotal'), DB::raw('count(if(gender="Male",1,NULL)) as mtotal'))
            ->join('students', 'enrollments.student_id', 'students.id')
            ->join('sections', 'enrollments.section_id', 'sections.id')
            ->where('sections.id', $infoTeacher->id)
            ->where('enrollments.school_year_id', Helper::activeAY()->id)
            ->groupBy('sections.section_name')->first();
            $repeaterF=Enrollment::join('students', 'enrollments.student_id', 'students.id')
                                        ->where('section_id',$infoTeacher->id)
                                        ->where('action_taken','Retained')
                                        ->where('enrollments.school_year_id', Helper::activeAY()->id)
                                        ->where('students.gender','Female')
                                        ->count();
            $repeaterM=Enrollment::join('students', 'enrollments.student_id', 'students.id')
                                        ->where('section_id',$infoTeacher->id)
                                        ->where('action_taken','Retained')
                                        ->where('enrollments.school_year_id', Helper::activeAY()->id)
                                        ->where('students.gender','Male')
                                        ->count();
                        
             $transferIn=Enrollment::select( DB::raw('count(if(gender="Female",1,NULL)) as ftotal'), DB::raw('count(if(gender="Male",1,NULL)) as mtotal'))
            ->join('students', 'enrollments.student_id', 'students.id')
            ->where('enrollments.school_year_id', Helper::activeAY()->id)
            ->where('enrollments.section_id',$infoTeacher->id)
            ->orWhere('action_taken','Promoted')
            ->whereNull('action_taken')
            ->first();
            //  $transferInM=Enrollment::join('students', 'enrollments.student_id', 'students.id')->where('action_taken','Prommoted')->where('students.gender','Male')->where('section_id',auth()->user()->section->id)->count();
            return view('teacher/classMonitor',compact('total','repeaterF','repeaterM','transferIn'));
        } else {
            return redirect()->route('teacher.dashboard');
        }
        
    }
    public function grading()
    {
        return view('teacher/grading',[
            'data'=>SchoolProfile::find(1)
        ]);
    }

    public function profile()
    {
        return view('teacher/profile');
    }

    public function reportCard($id){

        $getData = Enrollment::where('student_id',$id)
                                ->where('school_year_id',  Helper::activeAY()->id)
                                ->where('grade_level',Auth::user()->section->grade_level)
                                ->where('enroll_status','Enrolled')
                                ->first();
            $sy=SchoolYear::where('status',1)->first();
            $data =  Grade::select(
                "first",
                'second',
                'third',
                'fourth',
                'avg',
                'students.roll_no',
                'sections.section_name',
                'subjects.descriptive_title',
                'subjects.grade_level',
                'gender',
                DB::raw("CONCAT(students.student_lastname,', ',students.student_firstname,' ',students.student_middlename) as fullname")
            )
                ->join("students", "grades.student_id", "students.id")
                ->join('subjects', 'grades.subject_id', 'subjects.id')
                ->join('sections', 'grades.section_id', 'sections.id')
                ->join('teachers', 'sections.teacher_id', 'teachers.id')
                ->where('students.id', $getData->student_id)
                ->where('subjects.grade_level', $getData->grade_level)
                ->where('sections.id', $getData->section_id)
                ->get();
        return view('teacher/partial/reportCard',compact('data','sy'));
    }

    public function profileUpdate(Request $request){
        Teacher::whereId(auth()->user()->id)->update([
            'teacher_firstname'=>$request->teacher_firstname,
            'teacher_middlename'=>$request->teacher_middlename,
            'teacher_lastname'=>$request->teacher_lastname,
        ]);
        return redirect()->back();
    }

    public function profileAccount(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required'
        ]);
        if ($request->current_password===Crypt::decrypt(auth()->user()->orig_password)) {
            Teacher::whereId(auth()->user()->id)
            ->update([
                'username'=>$request->username,
                'orig_password'=>Crypt::encrypt($request->password),
                'password'=>Hash::make($request->password)
            ]);
            return redirect()->back()->with('success',"Successfuly update");
        } else {
            return redirect()->back()->with('msg',"Current password didn't match");
        }
        
       
           
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
                ->where('is_retained','No')
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
        Helper::myLog((empty($request->id)?'create':'update'),'teacher',$request->firstname);
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

    public function delete(Teacher $teacher)
    {
        Helper::myLog('archive','teacher',$teacher->teacher_firstname);
        return $teacher->delete();
    }
    public function edit(Teacher $teacher)
    {
        return response()->json($teacher);
    }

    public function assign()
    {
          $infoTeacher =  Section::where('teacher_id',auth()->user()->id)->where('school_year_id',  Helper::activeAY()->id)->first();
        if(auth()->user()->section->where('school_year_id',  Helper::activeAY()->id)->exists()){
            $subjects = Subject::where('grade_level', $infoTeacher->grade_level)
            ->whereIn('subject_for', [$infoTeacher->class_type, 'GENERAL'])
            ->get();
            $teachers = Teacher::select('id', DB::raw("CONCAT(teachers.teacher_lastname,', ',teachers.teacher_firstname,' ',teachers.teacher_middlename) as teacher_name"))->get();
            return view('teacher/assign', compact('subjects', 'teachers','infoTeacher'));
        }else{
            return redirect()->route('teacher.dashboard');
        }
        
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

    public function certificate(){
        return view('teacher/chairman/certificate');
    }

    public function loadMyEnrolledStudent()
    {
        return response()->json([
            'data'=>Enrollment::select('students.roll_no','students.id',
            'sections.section_name', DB::raw("CONCAT(students.student_lastname,', ',students.student_firstname,' ',students.student_middlename) as fullname"))
            ->join('students','enrollments.student_id','students.id')
            ->join('sections','enrollments.section_id','sections.id')
            ->where('enrollments.enroll_status', 'Enrolled')
            ->where('enrollments.grade_level', auth()->user()->chairman_info->grade_level)
            ->where('enrollments.school_year_id', Helper::activeAY()->id)
            ->get()
        ]);
    }

    public function loadMyCertificate(Student $student){
        return view('teacher/chairman/partial/certificateOfEnrollment',[
            'roll_no'=>$student->roll_no,
            'fullname'=>$student->fullname,
            'student_type'=>"Junior High School",
            'grade_level'=>auth()->user()->chairman_info->grade_level,
            'school_year'=>Helper::activeAY()->from.'-'.Helper::activeAY()->to,
            'teacher'=>auth()->user()->fullname
        ]);
    }
}
