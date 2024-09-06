<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{

    /**
     * Show the profile for a given user.
     */
    public function search(Request $request)
    { 

        $data = Customer::query();
        if($request->has('search')){
            $search = $request->search;
            $data->where('name', 'like', '%'.$search.'%');
        }

        $data = $data->limit(5)->get();
        return response()->json([
           "message" => "Record Get Successfully",
           "data" =>  $data,
        ],200);
    }



    /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    { 
        $per_page = 10;
        $sort_by = 'date';
        $assending = 'asc';
   
        $data = Customer::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('name', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%');
        }

        if($request->has('ascending') && $request->ascending != ''){
            $assending = $request->ascending;
        }

        if($request->has('sort_by') && $request->sort_by != null){
            $sort_by = $request->sort_by;
        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $per_page = $request->per_page;
        }

        switch ($sort_by) {

            case 'title':
                $data->orderBy('name',$assending);
                break;

            case 'date':
                $data->orderBy('created_at',$assending);
                break;

            case 'id':
                $data->orderBy('id',$assending);
                break;        

            default:

               $data->orderBy('created_at',$assending);
            break;
        }


        return response()->json([
            'query' => '',
            "message" => "Get All Record Successfully",
            "data" =>  $data->paginate($per_page),
        ],200);
    }



     /*
     * Show the profile for a given user.
     */
    public function show($id)
    {       
        
        $module = Customer::where('id',$id)->first();
        if($module == null){
             return response()->json(["message" => 'Record Not Found'],500);
        }
        
        return response()->json([
            "message" => 'Record Get Successfully',
            "data" => $module,
        ],200);
    }
    


    /*
     * Show the profile for a given user.
     */
    public function update(Request $request,$id)
    {

        if($id == 0){
            $module = New Customer();    
        }else{
            $module = Customer::where('id',$id)->first();
            if(!$module){
                return response()->json(["message" => "Record Not Found"],403);
            }
        }

        $validations = [
            'name' => ['required','string'],
            'email' => ['required','string','email'],
        ];

        if($id != 0){
            $validations['name'] = ['required','unique:customers,name,'.$id];
            $validations['email'] = ['required','email','unique:customers,email,'.$id];
        }
        
        $validator = Validator::make($request->all(),$validations);
        if($validator->fails()){
            return response()->json([
                "message" => "Validation Failed",
                "data" => ["validations" => $validator->messages()],
            ],403);
        }

        $module->name = $request->name;
        $module->email =  $request->email;
        $module->phone =  $request->phone;
        $module->country = $request->country;
        $module->state =  $request->state;
        $module->city =  $request->city;
        $module->zip_code = $request->zip_code;
        $module->street_address = $request->street_address;
        $module->description = $request->description;
        $module->active = $request->active;
        $module->save();

        //Response
        $message = $id ? 'Record Updated Successfully' : 'Record Created Successfully';
        return response()->json([
            "message" => $message,
            "data" => ['id' => $module->id]
        ],200);
    }



    /*
     * Show the profile for a given user.
     */
    public function destroy($id)
    {
        $module = Customer::find($id);
        if($module == null){
             return response()->json(["message" => 'Record Deleted Successfully'],200);
        }
        
        $module->delete();
        return response()->json([
            "message" => 'Record Deleted Successfully',
            "data" => ['id' => $id]
        ],200);
    }


    
    /*
     * Remove the specified resource from storage.
     */
    public function action(Request $request)
    {
        if($request->has('idz') && $request->has('action') && $request->has('value')){
            
            $idz = explode(',',$request->idz);   
            
            switch ($request->action) {
            
                case 'delete':
                    

                case 'active':

                    $pp = Customer::whereIn('id',$idz)->update(['active' => $request->value]);
                    return response()->json(['message' => "updated"],200);
                    break;
                
                default:
                break;
            }

        }

        return response()->json(['message' => translate('Error Found')],400);
    }



// action

}