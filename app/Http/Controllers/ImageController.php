<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Image;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $models = Image::query();

        $page = $request->get('page',1);
        $perpage = $request->get('perpage',10);

        $models = $models->paginate($perpage);
        return response()->json($models);
    }

    public function store(Request $request)
    {       
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'enable'=>'required',
            'file'=>'required|image'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>"Please check your input",
                "errors" => $validator->errors()
            ],400);
        }
    
        $destinationPath = "images";
        $file = $request->file('file');
        $newName = uniqid().'_'.$file->getClientOriginalName();

        
        if($file->move(public_path($destinationPath), $newName)){
            $image = Image::create([
                'name'=>$request->name,
                'file'=>$destinationPath.'/'.$newName,
                'enable'=>$request->enable
            ]);
        }
        return response()->json([
            'status'=>200,
            'message'=>'Image created',
            'result'=>$image
        ]);
    }

    public function save(Request $request, $id)
    {    
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'enable'=>'required',
            'file'=>'image'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'message'=>"Please check your input",
                "errors" => $validator->errors()
            ],400);
        }
        
        $models = Image::findOrFail($id);
        $models->name = $request->name;
        $models->enable = $request->enable;
        $oldFile = $models->file;
        if($request->hasFile('file')){
            $destinationPath = "images";
            $file = $request->file('file');
            $newName = uniqid().'_'.$file->getClientOriginalName();
            
            if($file->move(public_path($destinationPath), $newName)){
                @unlink(public_path().'/'.$oldFile);
                $models->file = $destinationPath.'/'.$newName;
            }
        }
       
        return response()->json([
            'status'=>200,
            'message'=>'Image updated',
            'result'=>$models
        ]);
    }

    public function delete($id)
    {
        $models = Image::findOrFail($id);
        $models->products()->detach();
        if($models->delete()){
            @unlink(public_path().'/'.$models->file);
        }
        return response()->json([
            'status'=>200,
            'message'=>'success delete data',
            'result'=>[]
        ]);
    }

    public function getById($id)
    {
        $models = Image::findOrFail($id);
        return response()->json($models);
    }
}
