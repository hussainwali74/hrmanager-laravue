<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\User;
use App\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    function index(request $request){
        if(!Auth::check() && $request->path()!="login"){
            return redirect('/login');
        }

        if(!Auth::check() && $request->path()=="login"){
            return view('welcome');
        }

        if($request->path()=='login'){
            if(Auth::user()->userType=='admin'){
                return redirect('/employees');
            }else if(Auth::user()->userType=='employee'){
                return redirect('/');
            }
        }

        if(Auth::check() && $request->path()=='/'){
            if(Auth::user()->userType=='admin'){
                return redirect('/employees');
            }
            if(Auth::user()->userType=='employee'){
                return redirect('/addvacation');
            }
        }

        if(Auth::check() && $request->path()=='employees'){
            if(Auth::user()->userType=='admin'){
                return view('welcome');
            }
        }

        return view('welcome');
    } //end INDEX function

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    function getEmployees(){
        return User::where(['userType'=>'employee'])->orWhere(['userType'=>'admin'])->orderBy('id', 'desc')->get();
    }

    function addEmployee(request $request){
        $this->validate($request, [
            'fullName' => 'required|max:100',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'job_title' => 'required|string',
            'contact' => 'required|numeric',
        ]);
        $password = bcrypt($request->password);
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'job_title' => $request->job_title,
            'contact' => $request->contact,
            'userType'=>$request->type
        ]);
        return $user;
    }

    function editEmployee(request $request){
        // dd($request);
        $this->validate($request, [
            'fullName' => 'required',
            'email' => "bail|required|email|unique:users,email,$request->id",
            'job_title' => 'required',
            'contact' => 'required',
        ]);
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'job_title' => $request->job_title,
            'contact' => $request->contact,
            'userType' => $request->type,
        ];
        if (isset($request->password) && $request->password!="******" && !empty($request->password)) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        $user = User::where('id', $request->id)->update($data);
        return User::all();
    }

    function getSalesForce(request $request, $email){
        $client = new \GuzzleHttp\Client();

        $email = urlencode($email);

        $newresponse = $client->request('GET','https://ioptime-pvt-ltd-dev-ed.my.salesforce.com/services/data/v50.0/query/?q=select+id%2C+Start_date__c%2C+End_date__c%2C+Description%2C+Number_Of_Days__c+from+Case+where+status%3D%27Approved%27+and+contact.email+%3D+%27'.$email.'%27',
            [
                'headers'=>[
                    'Content-Type'=>'application/x-www-form-urlencoded',
                    'Authorization' => 'Bearer 00D6F000001osey!AQ8AQFK.hqSlWIdpg0aHqEp66BBrXjQi3VXTf_mB53lUF01KMxmL1Wl9W9Y_unSBd8eaFuK05a5RX9i8K0IWMVeCVKKaol61'
                ]
            ]

        )->getBody()->getContents();

        return response()->json($newresponse, 200);

    }

    function salesForceResponse(request $request){
        dd($request);
    }

    function deleteEmployee(request $request){
        return User::where('id', $request->id)->delete();
    }

    function getCategory(){
        return Category::orderBy('id', 'desc')->get();
    }

    function adminLogin(request $request){
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required'
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return response()->json(['msg'=>'You are logged in','user'=>Auth::user()]);
        }else{
            return response()->json(['msg'=>'Incorrect Login Details'],401);
        }
    }

    function resetPassword(request $request){
        $this->validate($request, [
            'email'=>'required',
            'oldPassword'=>'required',
            'confirmPassword' => 'required|same:password',
            'password' => 'required|same:password'
        ]);
        if(Auth::Check()){
            $current_password = Auth::User()->password;
            if(Hash::check($request->oldPassword,$current_password)){

                $obj_user = Auth::User();
                $obj_user->password = Hash::make($request->password);
                $obj_user->save();

            return response()->json(['msg'=>'Password reset successful'],200);

                // return $request->password;
            }else{
                $error = array('current-password' => 'Please enter correct current password');
                return response()->json(array('error' => $error), 400);
            }
        }else{
            return redirect()->to('/');
        }
    }

    function getEmployeeVacations(){
        if(Auth::check()){
            $vacations = Auth::user()->vacations()->get();
            return  response()->json($vacations, 200);
        }else{
            return redirect()->to('/');
        }
    }

    function addVacation(request $request){
        $this->validate($request, [
            'name'=>'required',
            'email' => 'bail|required|email',
            'description' => 'required',
            'startDate' => 'required',
            'endDate'=>'required',
        ]);

        if(Auth::check()){
            $user=Auth::user();
            $vacation = new Vacation();
            $vacation->name = $request->name;
            $vacation->email = $request->email;
            $vacation->description = $request->description;
            $vacation->subject = $request->subject;
            $vacation->type = $request->type;
            $vacation->startDate = $request->startDate;
            $vacation->endDate = $request->endDate;
            $vacation->user_id = $user->id;
            $vacation->save();
        }
        $client = new \GuzzleHttp\Client();
        $url = "https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8";
        $finalData = [
            'form_params' => [
                'name' => $request->name,
                'email' => $request->email,
                'description'=>$request->description,
                'subject'=>$request->subject,
                '00N6F00000Ykwb1'=>$request->startDate,
                '00N6F00000Ykwb6'=>$request->endDate,
                'type'=>$request->type,
                'orgid'=>'00D6F000001osey',
                'retURL'=>'',
                'recordType'=>'0126F000001QWEI'
            ]
        ];
        $salesForceResponse = $client->request('POST',$url,  $finalData);
        $code =  $salesForceResponse->getStatusCode();
        if($code==200){
            return response()->json($salesForceResponse,200);
        }else{
            return response()->json('',500);
        }
    }
}