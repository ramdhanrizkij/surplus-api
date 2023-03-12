<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Validator;
use DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'enable'=>'required',
            'categories'=>'required',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>"Please check your input",
                "errors" => $validator->errors()
            ],400);
        }

        DB::beginTransaction();
        try{
            $models = Product::create([
                'name'=>$request->name,
                'description'=>$request->description,
                'enable'=>$request->enable
            ]);
            $models->categories()->attach($request->categories);

            if($request->images){
                $models->imags()->attach($request->images);
            }
            DB::commit();

            return response()->json([
                'status'=>200,
                'message'=>'Product created',
                'result'=>$models
            ]); 
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>400,
                'message'=>"Failed to create product",
                "errors" => $ex->getMessage()
            ],400);
        }
    }
}
