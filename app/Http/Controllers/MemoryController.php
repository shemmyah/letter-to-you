<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memory;

class MemoryController extends Controller
{
    public function index()
    {
        $photos = Memory::latest()->get();
        return view('gallery', compact('photos'));
    }

    public function admin(Request $request)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403);
        }

        $photos = Memory::latest()->get();
        return view('memory-gallery', compact('photos'));
    }

    public function store(Request $request)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403);
        }

        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $file = $request->file('image');
        $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file));

        Memory::create([
            'base64_image' => $base64,
            'caption' => $request->input('caption'),
        ]);

        return redirect('/admin/gallery?code=mysecret')->with('success', 'Photo uploaded!');
    }

    public function update(Request $request, $id)
    {
        if ($request->query('code') !== 'mysecret') {
            abort(403);
        }

        $photo = Memory::findOrFail($id);

        // Update caption
        $photo->caption = $request->input('caption');

        // If new image uploaded
        if ($request->hasFile('image')) {
            $image = base64_encode(file_get_contents($request->file('image')));
            $photo->base64_image = 'data:' . $request->file('image')->getMimeType() . ';base64,' . $image;
        }

        $photo->save();

        return redirect()->back()->with('success', 'Photo updated successfully!');
    }

}
