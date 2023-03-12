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
            'images'=>'required'
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
                $models->images()->attach($request->images);
            }
            DB::commit();

            $res = Product::where('id',$models->id)->with('categories','images');
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

    public function save(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'enable'=>'required',
            'categories'=>'required',
            'images'=>'required'
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
            $models = Product::findOrFail($id);
            $models->name = $request->name;
            $models->description = $request->description;
            $models->enable = $request->enable;

            $models->categories()->sync($request->categories);

            if($request->images){
                $models->images()->sync($request->images);
            }
            DB::commit();

            $res = Product::where('id',$id)->with('categories','images')->first();
            return response()->json([
                'status'=>200,
                'message'=>'Product updated',
                'result'=>$res
            ]); 
        }catch(\Exception $ex){
            DB::rollback();
            return response()->json([
                'status'=>400,
                'message'=>"Failed to update product",
                "errors" => $ex->getMessage()
            ],400);
        }
    }

    public function getById(Request $request,$id)
    {
        $models = Product::where('id',$id)->with('categories','images')->first();
        return response()->json($models);
    }

    public function delete(Request $request,$id)
    {
        $models = Product::findOrFail($id);
        $models->categories()->detach();
        $models->images()->detach();
        
        return response()->json([
            'status'=>200,
            'message'=>'success delete data',
            'result'=>[]
        ]);
    }

    public function index(Request $request)
    {
        $name = $request->get('name',null);
        $category = $request->get('category',null);
        $perpage = $request->get('perpage',10);

        $models = Product::query();

        if($name && $name!=''){
            $models->where('name','like','%'.$name.'%');
        }

        if($category && $category!=''){
            $models->whereHas('categories',function($query) use ($category){
                $query->where('category.id',$category);
            });
        }

        $models = $models->with('categories','images');

        $models = $models->paginate($perpage);

        return response()->json($models);
    }
}
