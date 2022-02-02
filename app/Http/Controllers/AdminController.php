<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\Assign;
use App\Models\Chairman;
use App\Models\Enrollment;
use App\Models\SchoolProfile;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str as SupportStr;

class AdminController extends Controller
{
    public function dashboard()
    {
    //   return date('m/d/Y');
        $appointies = Appointment::select('fullname', 'address', 'purpose','created_at')
            ->where('set_date', date('m/d/Y'))->limit(5)->orderBy('fullname')->get();
        $data = response()->json(
            Enrollment::select('enrollments.grade_level', DB::raw("COUNT(enrollments.grade_level) as total"))
                ->join('sections', 'enrollments.section_id', 'sections.id')
                ->join('school_years', 'enrollments.school_year_id', 'school_years.id')
                ->where('school_years.status', 1)
                ->where('enrollments.enroll_status', 'Enrolled')
                ->groupBy('enrollments.grade_level')
                ->orderBy('enrollments.grade_level')
                ->get()
        );
        $enrollTotal = Enrollment::join('school_years', 'enrollments.school_year_id', 'school_years.id')
            ->where('school_years.status', 1)
            ->whereIn('enroll_status', ['Pending', 'Enrolled'])->get()->count();
        $studentTotal = Student::get()->count();
        $teacherTotal = Teacher::get()->count();
        $ectionTotal = Section::join('school_years', 'sections.school_year_id', 'school_years.id')
            ->where('school_years.status', 1)
            ->get()
            ->count();
        return view('administrator/dashboard', compact('enrollTotal', 'studentTotal', 'teacherTotal', 'ectionTotal', 'data', 'appointies'));
    }

    public function resetPassword($id,$type){
        $passwordNow=rand(99,1000).'-'.rand(99,1000);
        if ($type==="student") {
            $student = Student::whereId($id)
            ->update([
                'password'=>Hash::make($passwordNow),
                'orig_password'=>Crypt::encrypt($passwordNow),
            ]);
            if ($student) {
                $query = Student::select("orig_password")->whereId($id)->first();
                Helper::myLog('reset','student password',$query->student_firstname);
                return Crypt::decrypt($query->orig_password);
            } else {
                return response()->json(['msg'=>'Sorry student not found']);
            }
            
        } else {
            $teacher = Teacher::whereId($id)
            ->update([
                'password'=>Hash::make($passwordNow),
                'orig_password'=>Crypt::encrypt($passwordNow),
            ]);
            if ($teacher) {
                $query = Teacher::select("orig_password")->whereId($id)->first();
                Helper::myLog('reset','teacher password',$query->teacher_firstname);
                return Crypt::decrypt($query->orig_password);
            } else {
                return response()->json(['msg'=>'Sorry teacher not found']);
            }
        }
    }

    public function announcement()
    {
        return view('administrator/announcement/announcement');
    }

    public function admission()
    {

        return view('administrator/enrollment/admission');
    }

    public function appointment()
    {
        return view('administrator/appointment/appointment');
    }

    public function enrollment()
    {
        return view('administrator/enrollment/enrollment',[
            'yearList'=>SchoolYear::all()
        ]);
    }
    public function teacher()
    {
        // $listId=array();
        $AssignId=Assign::select('teacher_id')->pluck('teacher_id');
        $ChairmanId=Chairman::select('teacher_id')->pluck('teacher_id');
        // return   array_merge((array)$AssignId);
        return view('administrator/masterlist/teacher',compact('AssignId'));
    }
    public function student()
    {
        return view('administrator/masterlist/student');
    }

    public function archive()
    {
        return view('administrator/masterlist/archive');
    }

    public function backrecord()
    {
        return view('administrator/masterlist/backrecord');
    }

    public function profile()
    {
        
        $files = Storage::files("Laravel");
        $fileRetrive=array();
            foreach ($files as $key => $value) {
                $value= str_replace("Laravel/","",$value);
                array_push($fileRetrive,$value);
            }
        $data = SchoolProfile::find(1);
        return view('administrator/management/profile', compact('data','fileRetrive'));
    }
    
    public function backUpDonwload($file_name){
        $file = Storage::disk('public')->get($file_name);
  
         (new Response($file, 200))
              ->header('Content-Type', 'image/jpeg');
        
        return redirect()->back();
    }

    public function backUpRemove($file_name){
        // return ;
        //  $file = Storage::disk('Laravel')->get($file_name);
        $directory=storage_path()."\app\Laravel\'".$file_name;
        $value= str_replace("'","",$directory);
        unlink($value);
    //    return   Storage::deleteDirectory(storage_path('laravel/'.$file_name));
         return redirect()->back();
    }

    public function strandAndTrack()
    {
        return view('administrator/management/strandAndTrack');
    }

    public function section()
    {
        $academicYear = SchoolYear::all();
        $teachers = Teacher::all();
        return view('administrator/management/section', compact('teachers', 'academicYear'));
    }

    public function subject()
    {
        $teachers = Teacher::all();
        return view('administrator/management/subject', compact('teachers'));
    }

    public function schedule()
    {
        $teachers = Teacher::all();
        return view('administrator/management/schedule', compact('teachers'));
    }

    public function assign()
    {
        $teachers = Teacher::all();
        return view('administrator/management/assign', compact('teachers'));
    }

    public function grading(){
        return view('administrator/management/grading');
    }

    public function chairman()
    {
        $teachers = Teacher::all();
        return view('administrator/management/chairman', compact('teachers'));
    }

    public function academicYear()
    {
        return view('administrator/management/academic-year',[
            'year'=>Enrollment::select('school_year_id')->pluck('school_year_id')
        ]);
    }

    public function user()
    {
        return view('administrator/management/adminUser');
    }

    public function activityLog()
    {
        return view('administrator/management/activityLog');
    }

    public function searchByDate($from,$to){

        $data = array();
        if ($from=='null') {
            
            $sqlData = ActivityLog::latest()->get();
            foreach ($sqlData as $key => $value) {
                $arr = array();
                $arr['id'] = ++$key;
                $arr['log'] = $value->log;
                $arr['date'] = $value->created_at->diffForHumans();
                $data[] = $arr;
            }
            return response()->json(
               [ "data"=>$data]
            );
        } else {
            $startDate = date('Y-m-d', strtotime($from));
            $endDate = date('Y-m-d', strtotime($to));
            $sqlData = ActivityLog::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get();
            foreach ($sqlData as $key => $value) {
                $arr = array();
                $arr['id'] = ++$key;
                $arr['log'] = $value->log;
                $arr['date'] = $value->created_at->diffForHumans();
                $data[] = $arr;
            }
            return response()->json(
                ["data"=>$data]
            );
        }
        
       
    }


    public function storeProfile(Request $request)
    {
        $data = $request->validate([
            'school_name' => 'required',
            'school_id_no' => 'required',
            'school_address' => 'required',
            'school_division' => 'required',
            'school_region' => 'required',
            // 'school_logo' => '',
        ]);

        if ($request->hasFile('school_logo')) {
            $this->deleteOldImage();
            $image = $request->file('school_logo');
            $imageName = SupportStr::of($request->school_name)->slug('-').rand(100,1000) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/logo'), $imageName);
            $data["school_logo"] = $imageName;
        } else {
            $resData = SchoolProfile::find($request->id);
            $data["school_logo"] = !empty($resData->school_logo) ? $resData->school_logo : null;
        }

        return SchoolProfile::updateOrCreate(['id' => $request->id], $data);
    }

    public function storeAY(Request $request)
    {

        // $data = SchoolYear::where('to', '>', $request->to)->get()->count();
        // if ($data) {
        //     return true;
        // } else {
        // SchoolYear::where('id', '>', 0)->update(['status' => 0]);
        return SchoolYear::updateOrCreate(['id' => $request->id], $request->all());
        // }
    }

    public function listAY()
    {
        return response()->json(['data' => SchoolYear::orderBy('to', 'asc')->get()]);
    }

    public function changeAY($id)
    {
        SchoolYear::where('id', '>', 0)->update(['status' => 0]);
        return SchoolYear::where('id', $id)->update(['status' => 1]);
    }

    public function deleteAY($id)
    {
        return SchoolYear::where([['status', 0], ['id', $id]])->delete();
    }

    public function editAY(SchoolYear $schoolYear)
    {
        return response()->json($schoolYear);
    }

    // Archive List

    public function archiveList($type)
    {
        switch ($type) {
            case 'student':
                return response()->json(
                    [
                        'data' => Student::select(
                            'id',
                            'roll_no',
                            'gender',
                            'student_lastname',
                            'student_firstname',
                            'student_middlename',
                            DB::raw("CONCAT(student_lastname,', ',student_firstname,' ', student_middlename) AS fullname")
                        )->onlyTrashed()->get()
                    ]
                );
                break;
            case 'teacher':
                return response()->json(
                    [
                        'data' => Teacher::select(
                            'id',
                            'roll_no',
                            'teacher_gender AS gender',
                            DB::raw("CONCAT(teacher_lastname,', ',teacher_firstname,' ', teacher_middlename) AS fullname")
                        )->onlyTrashed()->get()
                    ]
                );
                break;

            default:
                return false;
                break;
        }
    }

    public function archieveForceDelete($type, $id)
    {
        switch ($type) {
            case 'student':
                return Student::where('id', $id)->withTrashed()->first()->forceDelete();
                break;
            case 'teacher':
                return Teacher::where('id', $id)->withTrashed()->first()->forceDelete();
                break;
            default:
                return false;
                break;
        }
    }

    public function archiveRestore($type, $id)
    {
        switch ($type) {
            case 'student':
                Helper::myLog('restore','student');
                return Student::where('id', $id)->withTrashed()->first()->restore();
                break;
            case 'teacher':
                Helper::myLog('restore','teacher');
                return Teacher::where('id', $id)->withTrashed()->first()->restore();
                break;
            default:
                return false;
                break;
        }
    }

    public function gradeStatus(Request $request){
        $data=SchoolProfile::find(1);
        $data->update([
            'grade_status'=>$request->active
        ]);

        return response($request->active);
    }

    protected function deleteOldImage()
    {
        $sprofile = SchoolProfile::find(1);
        if (!empty($sprofile->school_logo)) {
            return unlink(public_path('image/logo/'.$sprofile->school_logo));
        }
      
    }

    public function quarterStatus(Request $request){
        return SchoolProfile::whereId(1)->update([
            'quarter'=>$request->data
        ]);
    }

    public function quarter(){
        $sprofile = SchoolProfile::find(1);
        return response()->json(
            $sprofile->quarter
        );
    }
}
