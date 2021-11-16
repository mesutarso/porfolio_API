<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
        $project = Project::with('services')->get();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'title' => 'required|unique:projects|max:255',
                'description' => 'required',
                'url' => 'required',
                'image' => 'required',
                'service_id' => 'required'
            ]
        )->validate();

        try {
            DB::beginTransaction();
            $project = Project::create(Arr::except($input, ['service_id']));
            $project->services()->sync($input['service_id']);
            $project->save();
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Project created",
                "data" => $project
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => "Project not created",
                "data" => $e->getMessage()
            ], 500);
        }
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
