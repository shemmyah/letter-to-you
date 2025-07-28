<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lyric;
use App\Models\Dedication;

class LyricsController extends Controller
{
    public function admin(Request $request)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403);
        }

        $lyrics = Lyric::latest()->get();
        return view('admin', compact('lyrics'));
    }

    public function store(Request $request)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        Lyric::create($request->only(['title', 'body']));

        return back()->with('success', 'Lyric added!');
    }

    public function update(Request $request, $id)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        Lyric::findOrFail($id)->update($request->only(['title', 'body']));

        return back()->with('success', 'Lyric updated!');
    }

    public function show($id)
    {
        $lyrics = Lyric::findOrFail($id);
        $dedications = Dedication::latest()->get();
        return view('results', compact('lyrics', 'dedications'));
    }
}
