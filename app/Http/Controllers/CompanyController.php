<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\company;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return company::orderBy('created_at','DESC')->get();
    }

    public function store(Request $request)
    {
        $company=new company;
        $company->id= $request['id'];
        $company->title= $request['title'];
        $company->category_id= $request['category_id'];
        $company->description= $request['description'];
        $company->status= $request['status'];

        $image=$request->file('image');
        if($image){
            $image_name=date('dmy_H_s_i');
            $ext= strtolower($image->getClientOriginalExtension());
            $image_full_name=$image_name.'.'.$ext;
            $upload_path='public/media/';
            $image_url= $upload_path.$image_full_name;
            $success=$image->move($upload_path,$image_full_name);
            $company->image=$image_url;           
        }
        $company->save();
        return $company;
    }

    public function show($id)
    {
        $existingcompany = company::find( $id );
        if($existingcompany ){
            return $existingcompany;
        }
        return response()->json(['message'=>'Company not Found']);  

        
    }

    public function update(Request $request, $id)
    {
        $existingcompany = company::find( $id );
        if($existingcompany ){
            $existingcompany->id = $request['id'];
            $existingcompany->title = $request['title'];
            $existingcompany->status = $request['status'];
            if($request['category_id']){
                $existingcompany->category_id = $request['category_id'];

            }
            if($request['description']){
                $existingcompany->description = $request['description'];

            }
            $image=$request->file('image');

            if($image){
                $oldimage=$existingcompany->image;
                unlink($oldimage);
                $image_name=date('dmy_H_s_i');
                $ext= strtolower($image->getClientOriginalExtension());
                $image_full_name=$image_name.'.'.$ext;
                $upload_path='public/media/';
                $image_url= $upload_path.$image_full_name;
                $success=$image->move($upload_path,$image_full_name);
                $existingcompany->image=$image_url;          
            }
            

            $existingcompany->save();
            return response()->json(['message'=>'Company Updated']);  
        }
        return response()->json(['message'=>'Company not Found']);  
    }


    public function destroy($id)
    {
        $existingcompany = company::find( $id );
        if($existingcompany ){
            unlink( $existingcategory->image);
            $existingcategory->delete();
            return response()->json(['message'=>'Company deleted']);  
        }
       
        return response()->json(['message'=>'Company not Found']);  
    }
}
