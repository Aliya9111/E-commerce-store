<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\QuestionResponseMail;
use App\Models\QuestionResponse;
use App\Models\User;
use App\Models\UserQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserQusetionsController extends Controller
{
    public function AllQuestionsLoad(){
        $AllQuestions=UserQuestion::orderBy('status','desc')->get();
        // dd($AllQuestions);
        $data['Questions']=$AllQuestions;
        return view('AdminPages.userQuestions.userQuestions',$data);
    }
    public function SingQuestion(Request $request,$id){
        $UserQustion=UserQuestion::find($id);
        $userInfo=$UserQustion->Users;
        $Responses=$UserQustion->QuestionResponse()->get();
        // dd($userInfo);
        if($UserQustion != null){
            if($UserQustion->status == 'unseen'){
                $UserQustion->update([
                    'status'=>'seen'
                ]);
            }
            $data['userInfo']=$userInfo;
            $data['UserQustion']=$UserQustion;
            $data['Responses']=$Responses;
            return view('AdminPages.userQuestions.QuestionInfo',$data);
        }
        return redirect()->back();
    }
    public function SaveResponse(Request $request,$Questionid,$userId){
        $request->validate([
            'response'=>['required','max:200']
        ]);
        QuestionResponse::Create(
            [
                'user_questions_id'=>$Questionid,
                'response'=>$request->response
                ]
        );
        $user=User::find($userId);
        $question=UserQuestion::where('id',$Questionid)->value('message');
        $response=$request->response;
        $subject="Question Response";
        // dd($address->email);
        Mail::to($user->email)->send(new QuestionResponseMail($subject,$question,$response));
        Session::flash('success','Successfully send the response to client');
        return redirect()->back();
    }
}
