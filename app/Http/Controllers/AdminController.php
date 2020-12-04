<?php

namespace App\Http\Controllers;

use App\Category;
use App\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function addTag(Request $request)
    {

        $this->validate($request, [
            'tagName' => 'required'
        ]);

        return Tag::create(
            [
                'tagName' => $request->tagName
            ]
        );

    }

    function editTag(Request $request)
    {

        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required'
        ]);

        return Tag::where('id', $request->id)->update(
            [
                'tagName' => $request->tagName
            ]
        );

    }


    function getTag()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    function deleteTag(request $request)
    {
        return Tag::where('id', $request->id)->delete();
    }

    function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:png,jpg,jpeg',

        ]);
          $imageName=time().'.'.$request->file->extension();
          $request->file->move(public_path('/img'),$imageName);
          return $imageName;

    }
    function deleteImage(Request $request){
            $this->deleteFileFromServer($request->image);
            return 'done';

    }

    function deleteFileFromServer($file){
         $path=public_path().'/img/'.$file;

         if(file_exists($path)){
             @unlink($path);

         }
         return ;
    }


    function addCategory(request $request){

        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);

        return  Category::create(
            [
                'categoryName' => $request->categoryName,
                'iconImage'=>  $request->iconImage
            ]
        );
    }


    function getCategory(){
        return Category::orderBy('id', 'desc')->get();
    }

    function deleteCategory(request $request){
        return Category::where('id', $request->id)->delete();
    }

    function editCategory(request $request){

        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);

        return  Category::where('id',$request->id)->update(
            [
                'categoryName' => $request->categoryName,
                'iconImage'=>  $request->iconImage
            ]
        );
    }




}
