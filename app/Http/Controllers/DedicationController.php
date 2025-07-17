<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dedication;

class DedicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403, 'Unauthorized.');
        }

        $dedications = Dedication::latest()->get();
        $editDedication = null;

        if ($request->query('edit')) {
            $editDedication = Dedication::find($request->query('edit'));
        }

        return view('dedicate', compact('dedications', 'editDedication'));
    }

    public function store(Request $request)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'song_title' => 'required',
            'message' => 'required',
            'recipient' => 'required',
        ]);

        Dedication::create($request->all());

        return redirect('/admin/dedicate?code=mysecret')->with('success', 'Dedication sent!');
    }

    public function update(Request $request, $id)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'song_title' => 'required',
            'message' => 'required',
            'recipient' => 'required',
        ]);

        $dedication = Dedication::findOrFail($id);
        $dedication->update($request->all());

        return redirect('/admin/dedicate?code=mysecret')->with('success', 'Dedication updated!');
    }

    public function search(Request $request)
    {
        $recipient = $request->input('recipient') ?? $request->input('to');

        $dedications = [];
        if ($recipient) {
            $dedications = Dedication::whereRaw('LOWER(recipient) = ?', [strtolower(trim($recipient))])->get();
        }

        return view('results', compact('dedications'));
    }
}
