<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\Servic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicController extends Controller
{
    public function view()
    {
        return Response()->json(['Services' => Help::all()]);
    }
    public function create(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'price'=> 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]
        );

        if($data->fails())
            return Response()->json([
            'status' => false,
            'error_code' => 404,
            'message' => $data->errors()]);


        $service = Help::create([
            'service_id' => $request['id'],
            'name'=> $request['name'],
            'price'=>$request['price'],
            'description' => $request['description'],
        ]);
        return Response()->json([
            'status' => true,
            'error_code' => 200,
            'Doctor'=> $service]);
    }
    public function update(Request $request, $service_id)
    {
        $data = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'price' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ],
        );
        if($data->fails()){
            return Response()->json([
                'status' => false,
                'error_code' => 404,
                'message' => $data->errors()]);}

        $service=Help::find($service_id);
        if(!$service)
                return Response()->json([
                'status' => false,
                'error_code' => 404,
                'error'=>'this service not found.']);
        $service->update($request->all());
            if ($service)
            return Response()->json([
                'status' => true,
                'error_code' => 200,
                'message'=>'service updated sucssufly']);
    }
    public function destroy($id)
    {
        $service = Help::find($id);
        if($service->service_id)
            return Response()->json([
                'status' => false,
                'error_code' => 404,
                'error'=>'this service is not found.']);
        $service->delete();
        return Response()->json([
        'status' => true,
        'error_code' => 200,
        'message'=>'service deleted successfully.']);
    }

}
