<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        if ($services->isEmpty()) {
            return response()->json(['error' => 'No services found'], 404);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Services List",
                "data" => $services
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:services|max:255',
            'description' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $services = Service::create($input);
        return response()->json([
            "success" => true,
            "message" => "Services created successfully.",
            "data" => $services
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            return response()->json(['error' => 'Service not found'], 404);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Services Detail",
                "data" => $service
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|unique:services|max:255',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $service->update($input);
        return response()->json([
            "success" => true,
            "message" => "Services updated successfully.",
            "data" => $service
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            return response()->json(['error' => 'Service not found'], 404);
        }
        $service->delete();
        return response()->json([
            "success" => true,
            "message" => "Service deleted successfully."
        ], 202);
    }
}
