<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\userInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserInforController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = userInfo::all();
        return response()->json([
           'data' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email' => 'required|email',
            'image' => 'required',
            'gender' => 'required',
            'skill' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }



        //    check team dir is exists
        if (!Storage::disk('public')->exists('user'))
        {
            Storage::disk('public')->makeDirectory('user');
        }

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/',$filename);
        }

       $user = userInfo::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'gender'=>$request->gender,
            'image'=>$filename,
        ]);
        foreach ( $request->skill as $row){
            $user->skills()->create(['skill'=>$row]);
        }

        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,userInfo $user_info)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'skill' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        if($request->hasFile('image')){
            
            Storage::delete($user_info->image);
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/',$filename);
            $user_info->image = $filename;
        }


        $user_info->name =$request->name;
        $user_info->email =$request->email;
        $user_info->gender =$request->gender;
        $user_info->save();

        $user_info->skills()->forceDelete();
        foreach ( $request->skill as $row){
            $user_info->skills()->create(['skill'=>$row]);
        }

        return response()->json([
            'data' => $user_info
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(userInfo $user_info)
    {
        $user_info->delete();
        return response()->json("Information Delete Successfully");
    }
}
