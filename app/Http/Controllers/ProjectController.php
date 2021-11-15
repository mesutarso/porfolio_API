<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isNull;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::all();
        if ($project->isEmpty()) {
            return response()->json(['error' => 'No project found'], 404);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Skill List",
                "data" => $project
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
            'title' => 'required|unique:skills|max:255',
            'description' => 'required',
            'url' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $project = Project::create($input);
        return response()->json([
            "success" => true,
            "message" => "Project created successfully.",
            "data" => $project
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
        $project = Project::find($id);
        if (is_null($project)) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json([
            "success" => true,
            "message" => "Product Details",
            "data" => $project
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|unique:projects|max:255',
            'description' => 'required',
            'url' => 'required',
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $project->update($input);
        return response()->json([
            "success" => true,
            "message" => "Project updated successfully.",
            "data" => $project
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        if (isNull($project)) {
            return response()->json(['error' => 'Project not found'], 404);
        }
        return response()->json([
            "success" => true,
            "message" => "Project deleted successfully.",
            "data" => $project
        ], 200);
    }
    public function search(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $project = Project::where('title', 'like', '%' . $input['title'] . '%')->get();
        if ($project->isEmpty()) {
            return response()->json(['error' => 'No project found'], 404);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Project List",
                "data" => $project
            ], 200);
        }
    }
}
