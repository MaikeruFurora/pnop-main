<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Assign;
use App\Models\BackSubject;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Notifications\NotifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    public function gradeStudentNow(Request $request)
    {
        if ($request->grade_id === "Nothing") {
            switch ($request->columnIn) {
                case '1st':
                    return Grade::create([
                        'student_id' => intval($request->student_id),
                        'teacher_id' => Auth::user()->id,
                        'subject_id' => intval($request->subject_id),
                        'first' => $request->value
                    ]);
                    break;
                case '2nd':
                    return Grade::create([
                        'student_id' => intval($request->student_id),
                        'teacher_id' => Auth::user()->id,
                        'subject_id' => intval($request->subject_id),
                        'second' => $request->value
                    ]);
                    break;
                case '3rd':
                    return Grade::create([
                        'student_id' => intval($request->student_id),
                        'teacher_id' => Auth::user()->id,
                        'subject_id' => intval($request->subject_id),
                        'third' => $request->value
                    ]);
                    break;
                case '4th':
                    return Grade::create([
                        'student_id' => intval($request->student_id),
                        'teacher_id' => Auth::user()->id,
                        'subject_id' => intval($request->subject_id),
                        'fourth' => $request->value
                    ]);
                    break;
                default:
                    return false;
                    break;
            }
        } else {
           if (Teacher::whereId(auth()->user()->id)->exists()) {
            $this->partialNotify($request->grade_id);
           }
            switch ($request->columnIn) {
                case '1st':
                    return Grade::where('id', $request->grade_id)->update([
                        'first' => $request->value,
                        'avg' => $request->avg
                    ]);
                    break;
                case '2nd':
                    return Grade::where('id', $request->grade_id)->update([
                        'second' => $request->value,
                        'avg' => $request->avg
                    ]);
                    break;
                case '3rd':
                    return Grade::where('id', $request->grade_id)->update([
                        'third' => $request->value,
                        'avg' => $request->avg
                    ]);
                    break;
                case '4th':
                    // return $request->avg;
                    Grade::where('id', $request->grade_id)->update([
                        'fourth' => $request->value,
                        'avg' => $request->avg,
                    ]);


                    // $dataAvg = Grade::select('avg', 'student_id', 'subject_id')->find($request->grade_id);
                    // if ($dataAvg->avg < 75) {
                    //     $enrollGradeLevel = Enrollment::select('grade_level')
                    //         ->join('students', 'enrollments.student_id', 'students.id')
                    //         ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
                    //         ->where('school_years.status', 1)
                    //         ->where('students.id', $dataAvg->student_id)->first();
                    //     // return BackSubject::create([
                    //     //     'student_id' => $dataAvg->student_id,
                    //     //     'subject_id' => $dataAvg->subject_id,
                    //     //     'grade_level' => $enrollGradeLevel->grade_level,
                    //     //     'prev_avg' => $dataAvg->avg,
                    //     // ]);
                    // }
                    break;
                default:
                    return false;
                    break;
            }
        }
    }

    public function partialNotify($id){

        $data1 = Grade::select('subjects.descriptive_title','grades.created_at','student_id')
        ->join('students','grades.student_id','students.id')
        ->join('subjects','grades.subject_id','subjects.id')
        ->where('grades.id',$id)
        ->first();
    
       $data['title']=$data1->descriptive_title;
       $data['bodyMessage']=auth()->user()->fullname . " is posted grade in ".$data1->descriptive_title ?? "Admin" ." is posted grade in ".$data1->descriptive_title;
       $data['type']='grade';
       $data['icon']='fa-check';
       $data['created_at']=$data1->created_at;
       $student=Student::whereId($data1->student_id)->first(); 
       $student->notify(new NotifyUser($data));
    }

    public function searchBySection($grade_level)
    {
        if (empty(Helper::activeAY())) {
            return response()->json(['warning' => 'No Academic Year Active']);
        } else {
            return response()->json(Section::where([['grade_level', $grade_level], ['school_year_id', Helper::activeAY()->id]])->get());
        }
    }

    public function searchBySubject(Section $section)
    {
        if (empty(Helper::activeAY())) {
            return response()->json(['warning' => 'No Academic Year Active']);
        } else {
            // return $section;
                // $data = Assign::select('subject_id')->where('section_id', $section->id)->pluck('subject_id')->toArray();
                return response()->json(Subject::where('grade_level', $section->grade_level)
                    ->whereIn('subject_for', [$section->class_type, 'GENERAL'])
                    // ->whereNotIn('id', $data)
                    ->get());
        }
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
        return response()->json(
           Grade::select(
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
        );
    }
}
