<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect,Response;
use Illuminate\Support\Facades\Session;
use App\Models\answer;
use App\Models\finalanswer;
use App\Models\assesmentbooking;
use App\Models\assesments;
use App\Models\assesmentsections;
use App\Models\stureports;
use App\Models\studentassignation;
use App\Models\studentbooking;


class adminlifecontroller extends Controller
{
     public function assindex($id){

          $sesid=session()->get('ADMIN_ID');
         $result['data']=DB::table('studentassignations')
                                    ->join('managers','studentassignations.mid','managers.id')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('categories','studentassignations.classid','categories.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',1)
                                    ->where('studentassignations.aid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','categories.categories','managers.mname')->get();

        for($i=0;$i<count($result['data']);$i++){
            $count=DB::table('studentbookings')->where('assignid',$result['data'][$i]->id)->get();
            $pcount=DB::table('studentbookings')->where('assignid',$result['data'][$i]->id)
                                                 ->where(function($query){
                                                       $query->where('preresult',"=","PASS")
                                                       ->orWhere('manpreapprove',"!=",0);
                                                   })->get();

            $result['data'][$i]->stucount=count($count);
            $result['data'][$i]->pcount=count($pcount);
        }



        $result['train']=$id;
      return view('admin.assignedbatch',$result);
    }
    
     public function assstudents($id){
        $result['data']=DB::table('studentbookings')
                                  ->join('students','studentbookings.sid','students.id')
                                  ->join('trainings','studentbookings.trainingid','trainings.id')
                                  ->where('studentbookings.assignid',$id)
                                  ->select('studentbookings.*','trainings.trainingname','students.sname','students.image')
                                  ->get();
       $result['train']=$id;
      return view('admin.assigned',$result);
    }

     public function attindex($id){

          $sesid=session()->get('ADMIN_ID');
         $result['data']=DB::table('studentassignations')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('categories','studentassignations.classid','categories.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',2)
                                    ->where('studentassignations.aid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','categories.categories')->get();
              for($i=0;$i<count($result['data']);$i++){
            $count=DB::table('studentbookings')->where('assignid',$result['data'][$i]->id)->get();
           
           

            $result['data'][$i]->stucount=count($count);
           
        }
       $result['train']=$id;
      return view('admin.attendedbatch',$result);
    }

      public function attstudents($id){
        $result['data']=DB::table('studentbookings')
                                  ->join('students','studentbookings.sid','students.id')
                                  ->join('trainings','studentbookings.trainingid','trainings.id')
                                  ->where('studentbookings.assignid',$id)
                                  ->select('studentbookings.*','trainings.trainingname','students.sname','students.image')
                                  ->get();
        for($i=0;$i<count($result['data']);$i++){
          $num=DB::table('studentassignmentbookings')->where('sbookingid',$result['data'][$i]->id)->get();
           $comp=0;
          for($m=0;$m<count($num);$m++){
            if($num[$m]->status=="4"){
                $comp++;
            }
          }
          $result['data'][$i]->totassigned=count($num);
          $result['data'][$i]->comassigned=$comp;
        }
       $result['train']=$id;
      return view('admin.attended',$result);
    }

    public function assignments($id){
         $result['data']=DB::table('studentassignmentbookings')
                                  ->join('faculties','studentassignmentbookings.fid','faculties.id')
                                  ->where('sbookingid',$id)->select('studentassignmentbookings.*','faculties.fname')->get();
        return view('admin.studentassignments',$result);

    }


     public function comstudents($id){
        $result['data']=DB::table('studentbookings')
                                  ->join('students','studentbookings.sid','students.id')
                                  ->join('trainings','studentbookings.trainingid','trainings.id')
                                  ->where('studentbookings.assignid',$id)
                                  ->select('studentbookings.*','trainings.trainingname','students.sname','students.image')
                                  ->get();

                     for($i=0;$i<count($result['data']);$i++){
          $num=DB::table('studentassignmentbookings')->where('sbookingid',$result['data'][$i]->id)->get();
           $comp=0;
          for($m=0;$m<count($num);$m++){
            if($num[$m]->status=="4"){
                $comp++;
            }
          }
          $result['data'][$i]->totassigned=count($num);
          $result['data'][$i]->comassigned=$comp;
        }
       $result['train']=$id;
      return view('admin.justcompleted',$result);
    }



     public function comindex($id){
        $sesid=session()->get('ADMIN_ID');
       $result['data']=DB::table('studentassignations')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('categories','studentassignations.classid','categories.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',3)
                                    ->where('studentassignations.aid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','categories.categories')->get();
              for($i=0;$i<count($result['data']);$i++){
            $count=DB::table('studentbookings')->where('assignid',$result['data'][$i]->id)->get();
           
           

            $result['data'][$i]->stucount=count($count);
           
        }
         $result['appdata']=DB::table('studentassignations')
                                    ->join('trainings','studentassignations.trainingid','trainings.id')
                                    ->join('lmssections','studentassignations.sectionid','lmssections.id')
                                    ->join('categories','studentassignations.classid','categories.id')
                                    ->where('studentassignations.trainingtype',$id)
                                    ->where('cyclestatus',4)
                                    ->where('studentassignations.aid',$sesid)
                                    ->select('studentassignations.*','lmssections.section','trainings.trainingname','categories.categories')->get();
              for($i=0;$i<count($result['appdata']);$i++){
            $count=DB::table('studentbookings')->where('assignid',$result['appdata'][$i]->id)->get();
            $result['appdata'][$i]->stucount=count($count); 
        }
       
       
       $result['train']=$id;
      return view('admin.completedbatch',$result);
    }

    public function comapstudents($id){
       $sesid=session()->get('ADMIN_ID');
        $result['appdata']=DB::table('studentbookings')
                                  ->join('students','studentbookings.sid','students.id')
                                  ->join('trainings','studentbookings.trainingid','trainings.id')
                                  ->where('studentbookings.assignid',$id)
                                  ->where('postapprove',1)
                                 ->where('studentbookings.aid',$sesid)
                                  ->select('studentbookings.*','trainings.trainingname','students.sname','students.image')
                                  ->get();
        $result['cid']=$id;
       return view('admin.completed',$result);
    }
  




 

    

}
