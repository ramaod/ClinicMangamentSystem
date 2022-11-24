<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function show()
    {
        return Response()->json(['Doctors' => Doctor::all()]);
    }
    public function store(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email'=> 'required|email|max:255',
                'description' => 'string|max:255',
                'specialization' =>'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,jpg,png'
            ]
        );

        if($data->fails())
            return Response()->json([
            'status' => false,
            'error_code' => 404,
            'message' => $data->errors()]);


        $doctor = Doctor::create([
            'doctor_id' => $request['id'],
            'name'=> $request['name'],
            'email'=>$request['email'],
            'description' => $request['description'],
            'image' => $request['image'],
            'specialization' => $request['specialization'],
        ]);

       if ($request->hasFile('image')) {
            // Get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();

            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get extension
            $extension = $request->file('image')->getClientOriginalExtension();

            // Create new filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;

            // Uplaod image
            $path = $request->file('image')->storeAs('public/users/images'.$doctor->id, $filenameToStore);

           // $post->image = URL::asset('storage/users/images/'.$post->id, $filenameToStore);
            $doctor->save();
            // <img src="/storage/users/images/{{$user->id}}">
        }
        return Response()->json([
            'status' => true,
            'error_code' => 200,
            'Doctor'=> $doctor]);
    }
    public function update(Request $request, $doctor_id)
    {
        $data = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'description' => 'string|max:255',
                'specialization' =>'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,jpg,png'
            ],
        );
        if($data->fails()){
            return Response()->json([
                'status' => false,
                'error_code' => 404,
                'message' => $data->errors()]);}

        $doctor=Doctor::find($doctor_id);
        if(!$doctor)
                return Response()->json([
                'status' => false,
                'error_code' => 404,
                'error'=>'this Doctor not found.']);
        $doctor->update($request->all());
            if ($doctor)
            return Response()->json([
                'status' => true,
                'error_code' => 200,
                'message'=>'Doctor updated sucssufly']);
    }
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if($doctor->doctor_id)
            return Response()->json([
                'status' => false,
                'error_code' => 404,
                'error'=>'this Doctor is not found.']);
        $doctor->delete();
        return Response()->json([
        'status' => true,
        'error_code' => 200,
        'message'=>'Doctor deleted successfully.']);
    }

}
