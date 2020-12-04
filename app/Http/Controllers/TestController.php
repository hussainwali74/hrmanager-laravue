<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
      public function welcome(){
          return view('welcome');
      }

      public function test(){
          return 'its working';
      }
}
