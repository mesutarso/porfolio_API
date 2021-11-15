<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::all();
        if ($skills->isEmpty()) {
            return response()->json(['error' => 'No skills found'], 404);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Skill List",
                "data" => $skills
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:skills|max:255',
            'type' => 'required',
            'icon' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $skill = Skill::create($input);
        return response()->json([
            "success" => true,
            "message" => "Skill created successfully.",
            "data" => $skill
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
        $skill = Skill::find($id);
        if (is_null($skill)) {
            return response()->json(['error' => 'Skill not found'], 404);
        }
        return response()->json([
            "success" => true,
            "message" => "Skill retrieved successfully.",
            "data" => $skill
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:skills|max:255',
            'type' => 'required',
            'icon' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $skill->name = $input['name'];
        $skill->type = $input['type'];
        $skill->icon = $input['icon'];
        $skill->save();
        return response()->json([
            "success" => true,
            "message" => "Skill updated successfully.",
            "data" => $skill
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json([
            "success" => true,
            "message" => "Skill deleted successfully.",
            "data" => $skill
        ]);
    }
}
