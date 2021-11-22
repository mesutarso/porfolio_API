<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        if (isEmpty($contacts)) {
            return response()->json(['message' => 'No contacts found'], 404);
        }
        return response()->json([
            'contacts' => $contacts
        ], 200);
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
        $validator = Validator::ake($input, [
            'civilite' => 'required',
            'noms' => 'required',
            'email' => 'required|email',
            'telephone' => 'required|tel',
            'service' => 'required',
            'contrat' => 'required',
        ])->validate();
        $contact = Contact::create($input);
        return response()->json([
            'message' => 'Contact created successfully',
            'contact' => $contact
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
