<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Validator;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $models = Category::where('enable',true)->orderBy('created_at','desc')->get();
        return response()->json([
            'status'=>200,
            'message'=>'success',
            'result'=>$models
        ]);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'enable'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>"Please check your input",
                "errors" => $validator->errors()
            ],400);
        }

        Category::create($request->all());
        return response()->json([
            'status'=>200,
            'message'=>'Category Created',
            'result'=>[]
        ]);
    }

    public function save(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'enable'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>"Please check your input",
                "errors" => $validator->errors()
            ],400);
        }
        $models = Category::findOrFail($id);
        $models->name = $request->name;
        $models->enable = $request->enable;
        $models->save();

        return response()->json([
            'status'=>200,
            'message'=>'Category updated',
            'result'=>$models
        ]);
    }

    public function getById($id)
    {
        $models = Category::findOrFail($id);
        return response()->json([
            'status'=>200,
            'message'=>'success get category',
            'result'=>$models
        ]);
    }

    public function delete($id)
    {
        $models = Category::findOrFail($id);
        $models->delete();

        return response()->json([
            'status'=>200,
            'message'=>'success delete category',
            'result'=>[]
        ]);
    }
}
