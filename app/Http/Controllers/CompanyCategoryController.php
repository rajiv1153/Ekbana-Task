<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\company_category;
use App\Models\company;



class CompanyCategoryController extends Controller
{

    public function index(Request $request)
    {
        if($request->only(['keyword'])){
            $results = company_category::where('title', $request->only(['keyword']))->first();
            if($results){
                return $results;
            }
            return response()->json(['message'=>'Keyword Not Found']);  
        }

        return company_category::orderBy('created_at','DESC')->get();
    }


    public function store(Request $request)
    {
        $category=new company_category;
        $category->id= $request['id'];
        $category->title= $request['title'];
        $category->save();
        return $category;
    }

    public function destroy($id)
    {
        $existingcategory = company_category::find( $id );
        if($existingcategory ){
            $existingcategory->delete();
            return response()->json(['message'=>'Category deleted']);  
        }
       
        return response()->json(['message'=>'Category not Found']);  
    }

    public function show($id)
    {
        $existingcategory = company_category::find( $id );
        if($existingcategory ){
            return $existingcategory;
            $results = company::where('category_id', $id); //find companies with catgegory _id
            return response()->json([$existingcategory,$results]);  

        }
        return response()->json(['message'=>'Category not Found']);  

        
    }

    public function update(Request $request, $id)
    {
        $existingcategory = company_category::find( $id );
        if($existingcategory ){
            $existingcategory->title = $request['title'];
            $existingcategory->save();
            return response()->json(['message'=>'Category Updated']);  
        }
        return response()->json(['message'=>'Category not Found']);  
    }


}
