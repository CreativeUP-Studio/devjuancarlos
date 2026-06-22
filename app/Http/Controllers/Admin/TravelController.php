<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    /**
     * Display a listing of the travels.
     */
    public function index()
    {
        $travels = Travel::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.travels.index', compact('travels'));
    }

    /**
     * Show the form for creating a new travel.
     */
    public function create()
    {
        return view('admin.travels.create');
    }

    /**
     * Store a newly created travel in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'badge' => ['nullable', 'string', 'max:255'],
            'meta_1_icon' => ['nullable', 'string', 'max:255'],
            'meta_1_text' => ['nullable', 'string', 'max:255'],
            'meta_2_icon' => ['nullable', 'string', 'max:255'],
            'meta_2_text' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'order' => ['required', 'integer'],
        ]);

        $data = $request->only([
            'title', 'description', 'badge', 
            'meta_1_icon', 'meta_1_text', 
            'meta_2_icon', 'meta_2_text', 
            'order'
        ]);

        // Default icons if left empty
        if (empty($data['meta_1_icon'])) {
            $data['meta_1_icon'] = 'fa-solid fa-plane-departure';
        }
        if (empty($data['meta_2_icon'])) {
            $data['meta_2_icon'] = 'fa-solid fa-camera';
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'travel_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/travels'), $imageName);
            $data['image_path'] = 'uploads/travels/' . $imageName;
        }

        Travel::create($data);

        return redirect()->route('admin.travels.index')->with('success', 'El viaje ha sido creado exitosamente.');
    }

    /**
     * Show the form for editing the specified travel.
     */
    public function edit(Travel $travel)
    {
        return view('admin.travels.edit', compact('travel'));
    }

    /**
     * Update the specified travel in storage.
     */
    public function update(Request $request, Travel $travel)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'badge' => ['nullable', 'string', 'max:255'],
            'meta_1_icon' => ['nullable', 'string', 'max:255'],
            'meta_1_text' => ['nullable', 'string', 'max:255'],
            'meta_2_icon' => ['nullable', 'string', 'max:255'],
            'meta_2_text' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'order' => ['required', 'integer'],
        ]);

        $data = $request->only([
            'title', 'description', 'badge', 
            'meta_1_icon', 'meta_1_text', 
            'meta_2_icon', 'meta_2_text', 
            'order'
        ]);

        // Default icons if left empty
        if (empty($data['meta_1_icon'])) {
            $data['meta_1_icon'] = 'fa-solid fa-plane-departure';
        }
        if (empty($data['meta_2_icon'])) {
            $data['meta_2_icon'] = 'fa-solid fa-camera';
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($travel->image_path && file_exists(public_path($travel->image_path))) {
                @unlink(public_path($travel->image_path));
            }

            $image = $request->file('image');
            $imageName = 'travel_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/travels'), $imageName);
            $data['image_path'] = 'uploads/travels/' . $imageName;
        }

        $travel->update($data);

        return redirect()->route('admin.travels.index')->with('success', 'El viaje ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified travel from storage.
     */
    public function destroy(Travel $travel)
    {
        if ($travel->image_path && file_exists(public_path($travel->image_path))) {
            @unlink(public_path($travel->image_path));
        }

        $travel->delete();

        return redirect()->route('admin.travels.index')->with('success', 'El viaje ha sido eliminado exitosamente.');
    }
}
