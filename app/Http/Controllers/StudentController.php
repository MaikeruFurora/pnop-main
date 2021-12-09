<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Helpers\Helper;
use App\Models\Announcement;
use App\Models\BackSubject;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\SchoolProfile;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    use Traits\StudentStatus;

    public function dashboard()
    {
        $post = Announcement::latest()->get();
        $enrolledData = Enrollment::join('students', 'enrollments.student_id', 'students.id')
            ->leftjoin('sections', 'enrollments.section_id', 'sections.id')
            ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
            ->where('school_years.status', 1)
            ->where('students.id', Auth::user()->id)
            ->first();
        return view('student/dashboard', compact('enrolledData','post'));
    }

    public function notificationStudent(){
        return view('student/notification');
    }

    public function store(Request $request)
    {
        if (isset($request->id)) {
            $dataret = Student::findOrFail($request->id);
        }
        return Student::updateOrCreate(['id' => $request->id], [
            'roll_no' => $request->roll_no,
            'student_firstname' => $request->student_firstname,
            'student_middlename' => $request->student_middlename,
            'student_lastname' => $request->student_lastname,
            'date_of_birth' => $request->date_of_birth,
            'student_contact' => $request->student_contact,
            'gender' => $request->gender,
            'region' => $request->region ?? $dataret->region,
            'province' => $request->province ?? $dataret->province,
            'city' => $request->city ?? $dataret->city,
            'barangay' => $request->barangay ?? $dataret->barangay,
            'mother_name' => $request->mother_name,
            'mother_contact_no' => $request->mother_contact_no,
            'father_name' => $request->father_name,
            'father_contact_no' => $request->father_contact_no,
            'guardian_name' => $request->guardian_name,
            'guardian_contact_no' => $request->guardian_contact_no,
            'username' => empty($dataret->username) ? Helper::create_username($request->student_firstname, $request->student_lastname) : $dataret->username,
            'orig_password' => empty($dataret->orig_password) ? Crypt::encrypt("pnhs") : $dataret->orig_password,
            'password' => empty($dataret->password) ? Hash::make("pnhs") : $dataret->password,
            'student_status' => null,
            'completer' => $request->completer,
        ]);
    }

    public function edit(Student $student)
    {
        return response()->json($student);
    }

    public function list()
    {
        $data = array();
        $sqlData = Student::select("*")->whereNotNull('orig_password')->get();
        foreach ($sqlData as $key => $value) {
            $arr = array();
            $arr['id'] = $value->id;
            $arr['roll_no'] = $value->roll_no;
            $arr['student_firstname'] = $value->student_firstname;
            $arr['student_middlename'] = $value->student_middlename;
            $arr['student_lastname'] = $value->student_lastname;
            $arr['student_contact'] = $value->student_contact;
            $arr['gender'] = $value->gender;
            $arr['completer'] = $value->completer;
            $arr['username'] = $value->username;
            $arr['orig_password'] = Crypt::decrypt($value->orig_password);
            $data[] = $arr;
        }
        // return $data;
        return response()->json(['data' => $data]);
    }

    public function destroy(Student $student)
    {
        return $student->delete();
    }

    public function profile()
    {
        return view('student/profile');
    }

    public function grade()
    {
        return view('student/grade');
    }


    public function gradeList($level, $section)
    {
        return response()->json(
            Grade::select(
                "grades.id as gid",
                "grades.first",
                "grades.second",
                "grades.third",
                "grades.fourth",
                "grades.avg",
                "subjects.descriptive_title",
                DB::raw("CONCAT(teachers.teacher_lastname,', ',teachers.teacher_firstname,' ',teachers.teacher_middlename) as fullname")
            )->join('students', 'grades.student_id', 'students.id')
                ->join('subjects', 'grades.subject_id', 'subjects.id')
                ->leftjoin('assigns', 'grades.subject_id', 'assigns.subject_id')
                ->leftjoin('teachers', 'assigns.teacher_id', 'teachers.id')
                ->where('grades.student_id', Auth::user()->id)
                ->where('grades.section_id', $section)
                ->where('assigns.section_id', $section)
                // ->where('assigns.school_year_id',$sy)
                ->get()
        );
    }

    public function levelList()
    {
        return response()->json(
            Enrollment::select('enrollments.grade_level', 'school_years.status', 'sections.section_name', 'enrollments.section_id','enrollments.school_year_id','school_years.from','school_years.to')
                ->join('students', 'enrollments.student_id', 'students.id')
                ->join('sections', 'enrollments.section_id', 'sections.id')
                ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
                ->where('students.id', Auth::user()->id)
                ->groupBy('enrollments.grade_level', 'school_years.status', 'sections.section_name', 'enrollments.section_id','enrollments.school_year_id','school_years.from','school_years.to')
                ->orderBy('school_years.status', 'desc')
                ->get()
        );
    }

    public function enrollment()
    {
        // $dataArr = array();
        // $ifexist = Enrollment::select('enrollments.enroll_status', 'enrollments.action_taken', 'section_name', 'enrollments.grade_level')
        //     ->join('students', 'enrollments.student_id', 'students.id')
        //     ->leftjoin('sections', 'enrollments.section_id', 'sections.id')
        //     ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
        //     ->where('school_years.status', 1)
        //     ->where('students.id', Auth::user()->id)
        //     ->first();
        // if ($ifexist) {
        //     $dataArr['status'] = $ifexist->enroll_status;
        //     $dataArr['action_taken'] = $ifexist->action_taken;
        //     $dataArr['section'] = $ifexist->section_name;
        //     $dataArr['grade_level'] = 'Grade ' . $ifexist->grade_level;
        // } else {
        //     $dataArr['status'] = 'Ongoing';
        //     $dataArr['action_taken'] = 'None';
        // }
        // $eStatus = $this->enrollStatus();

        $dataArr = array();
        $ifexist = Enrollment::select('enrollments.enroll_status', 'enrollments.action_taken', 'section_name', 'enrollments.grade_level','enrollments.curriculum','enrollments.tracking_no')
            ->join('students', 'enrollments.student_id', 'students.id')
            ->leftjoin('sections', 'enrollments.section_id', 'sections.id')
            ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
            ->where('school_years.status', 1)
            ->where('students.id', Auth::user()->id)
            ->first();
        if ($ifexist) {
            $dataArr['status'] = $ifexist->enroll_status;
            $dataArr['action_taken'] = $ifexist->action_taken;
            $dataArr['section'] = $ifexist->section_name;
            $dataArr['curriculum'] = $ifexist->curriculum;
            $dataArr['tracking_no'] = $ifexist->tracking_no;
            $dataArr['grade_level'] = 'Grade ' . $ifexist->grade_level;
        } else {
           $putDataForPreviuosLevel=Enrollment::select('enrollments.created_at','enrollments.enroll_status', 'enrollments.action_taken', 'section_name', 'enrollments.grade_level','enrollments.curriculum')
            ->join('students', 'enrollments.student_id', 'students.id')
            ->leftjoin('sections', 'enrollments.section_id', 'sections.id')
            ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
            // ->where('school_years.status', 1)
            ->where('students.id', Auth::user()->id)
            ->latest()->first();
            $dataArr['curriculum'] = $putDataForPreviuosLevel->curriculum;
            $dataArr['grade_level'] = 'Grade ' . $putDataForPreviuosLevel->grade_level;
            // $dataArr['status'] = $putDataForPreviuosLevel->enroll_status;
            $dataArr['status'] = 'Ongoing';
            $dataArr['action_taken'] = 'None';
        }
        $eStatus = $this->enrollStatus();
        return view('student/enrollment', compact('eStatus', 'dataArr'));
    }
    
    public function checkSubjectBalance(Student $student)
    {
        return Grade::where('student_id', $student->id)->whereNull('avg')->orWhere('avg', '')->get()->count();
    }

    public function selfEnroll(Request $request)
    {
        $countFail =  Grade::select('subjects.id','subjects.grade_level')->join('subjects','grades.subject_id','subjects.id')->where('student_id', $request->id)->where('avg','<',75)->whereNull('remarks')->get();
        $action_taken = $countFail->count() == 0 ? 'Promoted' : ($countFail->count() < 3 ? 'Partialy Promoted' : 'Retained');
        $studInfo = Enrollment::select('section_id','grade_level', 'curriculum','enroll_status')->where('student_id', $request->id)->latest()->first();

        if ($action_taken == 'Retained') { //if student retained in year level means this is backsubject will reset in grade level
            // BackSubject::where('student_id', $request->id)->where('grade_level', $countFail[0]->grade_level)->delete();
            $subjects = Subject::where('grade_level', $countFail[0]->grade_level)->whereIn('subject_for', [$studInfo->curriculum, 'GENERAL'])->get();
            foreach ($subjects as $subject) {
                Grade::where('student_id',$request->id)
                ->where('subject_id',$subject->id)
                ->where('section_id',$studInfo->section_id)
                ->update([
                    'is_retained'=>'Yes'
                ]);
                // ->delete();
            }
        }

        $tracking_no = rand(99, 1000) . '-' . rand(99, 1000);

        $sp = SchoolProfile::find(1);

        switch ($studInfo->enroll_status) {
            case 'Enrolled':
                return Enrollment::create([
                    'student_id' => $request->id,
                    // 'section_id' => $request->section_id,
                    'grade_level' => $countFail->count() >= 3 ? $countFail[0]->grade_level : ($studInfo->grade_level + 1),
                    'school_year_id' => Helper::activeAY()->id,
                    'date_of_enroll' => date("d/m/Y"),
                    'action_taken' => $action_taken,
                    'enroll_status' => 'Pending',
                    'tracking_no' => $tracking_no,
                    'curriculum' => $studInfo->curriculum,
                    'last_school_attended'=>$sp->school_name,
                    'student_type' => ($studInfo->grade_level + 1) <= 10 ? 'JHS' : null,
                    'state' => 'Old',
                ]);
                break;
            case 'Pending':
                    return false;
                break;
            case 'Dropped':
                return Enrollment::create([
                    'student_id' => $request->id,
                    // 'section_id' => $request->section_id,
                    'grade_level' => $studInfo->grade_level,
                    'school_year_id' => Helper::activeAY()->id,
                    'date_of_enroll' => date("d/m/Y"),
                    'action_taken' => $action_taken,
                    'enroll_status' => 'Pending',
                    'tracking_no' => $tracking_no,
                    'curriculum' => $studInfo->curriculum,
                    'last_school_attended'=>$sp->school_name,
                    'student_type' => ($studInfo->grade_level + 1) <= 10 ? 'JHS' : null,
                    'state' => 'Old',
                ]);
                break;
            default:
                    return false;
                break;
        } 
       
    }

    public function viewRecord(Student $student)
    {
        $recordSeven = $this->gradeViewAll($student->id, 7);
        $recordEight = $this->gradeViewAll($student->id, 8);
        $recordNine = $this->gradeViewAll($student->id, 9);
        $recordTen = $this->gradeViewAll($student->id, 10);

        return view('administrator/masterlist/student/record', compact('student', 'recordSeven', 'recordEight', 'recordNine', 'recordTen'));
    }



    public function gradeViewAll($id, $gl)
    {

        //  return $getData = Enrollment::where('student_id',$id)->where('grade_level',$gl)->where('enroll_status','Enrolled')->first();
          $getData = Enrollment::where('student_id',$id)->where('grade_level',$gl)->where('enroll_status','Enrolled')->latest()->first();

        if ($getData) {
            return Grade::select(
                "first",
                'second',
                'third',
                'fourth',
                'sections.section_name',
                'subjects.descriptive_title',
                'subjects.grade_level',
                DB::raw("CONCAT(teachers.teacher_lastname,', ',teachers.teacher_firstname,' ',teachers.teacher_middlename) as fullname")
            )
                ->join("students", "grades.student_id", "students.id")
                ->join('subjects', 'grades.subject_id', 'subjects.id')
                ->join('sections', 'grades.section_id', 'sections.id')
                ->join('teachers', 'sections.teacher_id', 'teachers.id')
                ->where('students.id', $getData->student_id)
                ->where('subjects.grade_level', $getData->grade_level)
                ->where('sections.id', $getData->section_id)
                ->where('grades.is_retained','No')
                ->get();
        }
    }
    public function backsubject()
    {
        return view('student/backsubject');
    }

    public function storeProfileImage(Request $request){
        // $destinationPath = public_path('image/profile');
        // $request->file->move($destinationPath,$name);
        
        
        
        $this->deleteOldImage();
        $image = $request->file('file');
        // $input['imagename'] = time().'.'.$image->extension();
        $name = time().rand(1000,10000).rand(1000,10000).'.'.$request->file->getClientOriginalExtension();
        
        // $filePath = public_path('image/profile');
        
        // $img = Image::make($image->path());
        // $img->resize(110, 110, function ($const) {
        //     $const->aspectRatio();
        // })->save($filePath.'/'.$name);
        $filePath = public_path('image/profile');
        $image->move($filePath, $name);
       return Student::where('id',Auth::user()->id)->update(['profile_image'=>$name]);
    }

    protected function deleteOldImage()
    {
      if (auth()->user()->profile_image){
        return unlink(public_path('image/profile/'.auth()->user()->profile_image));
      }
    }

    public function reportBug()
    {
        return view("student/reportBug");
    }

    public function appointment()
    {
        return view("student/appointment");
    }
}
