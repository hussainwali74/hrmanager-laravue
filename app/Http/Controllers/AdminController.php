<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            if(Auth::user()->userType=='employees'){
                return redirect('/employees');
            }else{
                return redirect('/vacations');
            }
        }

        if(Auth::check() && $request->path()=='/'){
            if(Auth::user()->userType=='employees'){
                return redirect('/employees');
            }else{
                return redirect('/vacations');
            }
        }

        if(Auth::check() && $request->path()=='employees'){
            if(Auth::user()->userType=='admin'){
                return view('welcome');
            }else{
                return redirect('/vacations');

            }
        }

        if(Auth::check() && $request->path()=='vacations'){
            if(Auth::user()->userType=='employee'){
                return view('welcome');
            }else{
                return redirect('/employees');
            }
        }
        return view('welcome');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
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
            'userType'=>'employee'
        ]);
        return $user;
    }

    function getCategory(){
        return Category::orderBy('id', 'desc')->get();
    }

    function deleteEmployee(request $request){
        return User::where('id', $request->id)->delete();
    }

    function editEmployee(request $request){
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
        ];
        if (isset($request->password) && $request->password!="******" && !empty($request->password)) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }
        $user = User::where('id', $request->id)->update($data);
        return $user;
    }

    function getEmployees(){
        return User::where('userType','employee')->orderBy('id', 'desc')->get();
    }

    function adminLogin(request $request){
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required'
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return response()->json(['msg'=>'You are logged in']);
        }else{
            return response()->json(['msg'=>'Incorrect Login Details'],401);
        }
    }

    function addVacation(request $request){
        // dd($request->all);
        $this->validate($request, [
            'name'=>'required',
            'email' => 'bail|required|email',
            'description' => 'required',
            'startDate' => 'required',
            'endDate'=>'required',
        ]);
        $client = new \GuzzleHttp\Client();
        // dd($request);
        $url = "https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8";
        $request = $client->request('POST',$url,  [
            'form_params' => [
                'name' => "sdsdsdds",
                'email' => "request->email",
                'description'=>"request->aap logu ki term paper",
                'subject'=>'testing22',
                '00N6F00000Ykwb1'=>$request->startDate,
                '00N6F00000Ykwb6'=>$request->endDate,
                'type'=>$request->type,
                'orgid'=>'00D6F000001osey',
                'retURL'=>'',
                'recordType'=>'0126F000001QWEI'
            ]
        ]);
        // $request = $client->post($url,  [
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'description'=>$request->description,
        //     'subject'=>'testing',
        //     '00N6F00000Ykwb1'=>$request->startDate,
        //     '00N6F00000Ykwb6'=>$request->endDate,
        //     'type'=>$request->type,
        //     'orgid'=>'00D6F000001osey',
        //     'retURL'=>'',
        //     'recordType'=>'0126F000001QWEI'
        // ]);
        // $response = $request->send();
        // $code =  $request->getStatusCode();
        dd($request);
        if($code==200){
            return response()->json('',200);
        }else{
            return response()->json('',500);
        }
    }
}