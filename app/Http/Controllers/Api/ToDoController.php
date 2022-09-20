<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class ToDoController extends Controller
{
    
public function list(Request $request)
{
    $user = Auth::user();
   $list =  TodoList::where('user_id',$user->id)->latest()->get();

   if(!$list->isEmpty())
   {
    return response()->json([
        'data' => $list,
        'message' => 'Listing',
    ]);
   }else{
    return response()->json([
        'message' => 'List not found!'
    ], 404);
   }
}    

public function add(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
    ]);

    // Return errors if validation error occur.
    if ($validator->fails()) {
        $errors = $validator->errors();
        return response()->json([
            'error' => $errors
        ], 400);
    }else{
    
        $user = Auth::user();


        $toDo = new TodoList();

        $toDo->name = $request->name;
        $toDo->user_id = $user->id;

        if($toDo->save())
        {
            return response()->json([
                'data' => $toDo,
                'message' => 'ToDo Added Sucessfully',
            ]);
        }else{
            return response()->json([
                'message' => 'SomeThing Went Wrong'
            ], 401);
        }

    
     
    }


}


public function statusUpdate(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'todo_id' => 'required',
        'status_id'=>'required||in:0,1'
    ]);

    // Return errors if validation error occur.
    if ($validator->fails()) {
        $errors = $validator->errors();
        return response()->json([
            'error' => $errors
        ], 400);
    }else{
    
        $user = Auth::user();

        $record =   TodoList::where(['id'=>$request->todo_id,'user_id'=>$user->id])->first();

 
        if(!empty($record)){

            $record->status_id = $request->status_id;
            $record->save();
            return response()->json([
                'data' => $record,
                'message' => 'Status updated',
            ]);

        }else{
            return response()->json([
                'message' => 'Invalid record'
            ], 404);
        }

        

    
     
    }


}


public function delete(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'todo_id' => 'required',
    ]);

    // Return errors if validation error occur.
    if ($validator->fails()) {
        $errors = $validator->errors();
        return response()->json([
            'error' => $errors
        ], 400);
    }else{
    
        $user = Auth::user();

        $record =   TodoList::where(['id'=>$request->todo_id,'user_id'=>$user->id])->first();

 
        if(!empty($record)){

            $record->delete();
            return response()->json([
                'data' => $record,
                'message' => 'Record Deleted sucessfully',
            ]);

        }else{
            return response()->json([
                'message' => 'Invalid record'
            ], 404);
        }

        

    
     
    }


}

   

}
