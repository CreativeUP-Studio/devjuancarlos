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
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'string', 'max:255'],
            'travel_date' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'content' => ['nullable', 'string'],
            'media_type' => ['required', 'string', 'in:image,video'],
            'badge' => ['nullable', 'string', 'max:255'],
            'meta_1_icon' => ['nullable', 'string', 'max:255'],
            'meta_1_text' => ['nullable', 'string', 'max:255'],
            'meta_2_icon' => ['nullable', 'string', 'max:255'],
            'meta_2_text' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:15360'],
            'audio' => ['nullable', 'mimes:mp3,wav,ogg,m4a', 'max:20480'],
            'video' => [$request->media_type === 'video' ? 'required' : 'nullable', 'mimes:mp4,webm,ogg,mov', 'max:153600'],
            'order' => ['required', 'integer'],
        ];

        $request->validate($rules, [
            'image.required' => 'La imagen de fondo 100vh es obligatoria para guardar el viaje.',
            'video.required' => 'Debes seleccionar y subir un archivo de video cuando el tipo de contenido es Video.',
            'video.max' => 'El archivo de video no debe superar los 150 MB.',
            'image.max' => 'La imagen no debe superar los 15 MB.',
        ]);

        $data = $request->only([
            'title', 'location', 'country', 'year', 'travel_date', 'description', 'content', 
            'media_type', 'badge', 
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

        // Handle Background Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'travel_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/travels'), $imageName);
            $data['image_path'] = 'uploads/travels/' . $imageName;
        }

        // Handle Audio Upload
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioName = 'audio_' . time() . '.' . $audio->getClientOriginalExtension();
            $audio->move(public_path('uploads/audio'), $audioName);
            $data['audio_path'] = 'uploads/audio/' . $audioName;
        }

        // Handle Video Upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = 'video_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads/videos'), $videoName);
            $data['video_path'] = 'uploads/videos/' . $videoName;
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
        $needVideo = ($request->media_type === 'video' && !$travel->video_path);

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'string', 'max:255'],
            'travel_date' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'content' => ['nullable', 'string'],
            'media_type' => ['required', 'string', 'in:image,video'],
            'badge' => ['nullable', 'string', 'max:255'],
            'meta_1_icon' => ['nullable', 'string', 'max:255'],
            'meta_1_text' => ['nullable', 'string', 'max:255'],
            'meta_2_icon' => ['nullable', 'string', 'max:255'],
            'meta_2_text' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:15360'],
            'audio' => ['nullable', 'mimes:mp3,wav,ogg,m4a', 'max:20480'],
            'video' => [$needVideo ? 'required' : 'nullable', 'mimes:mp4,webm,ogg,mov', 'max:153600'],
            'order' => ['required', 'integer'],
        ];

        $request->validate($rules, [
            'video.required' => 'Debes subir un archivo de video cuando seleccionas la opción Video.',
            'video.max' => 'El archivo de video no debe superar los 150 MB.',
            'image.max' => 'La imagen no debe superar los 15 MB.',
        ]);

        $data = $request->only([
            'title', 'location', 'country', 'year', 'travel_date', 'description', 'content', 
            'media_type', 'badge', 
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

        // Handle File Deletions requested by user
        if ($request->boolean('delete_image')) {
            if ($travel->image_path && file_exists(public_path($travel->image_path))) {
                @unlink(public_path($travel->image_path));
            }
            $data['image_path'] = null;
        }

        if ($request->boolean('delete_video')) {
            if ($travel->video_path && file_exists(public_path($travel->video_path))) {
                @unlink(public_path($travel->video_path));
            }
            $data['video_path'] = null;
            if (isset($data['media_type']) && $data['media_type'] === 'video') {
                $data['media_type'] = 'image';
            }
        }

        if ($request->boolean('delete_audio')) {
            if ($travel->audio_path && file_exists(public_path($travel->audio_path))) {
                @unlink(public_path($travel->audio_path));
            }
            $data['audio_path'] = null;
        }

        // Handle Background Image Upload
        if ($request->hasFile('image')) {
            if ($travel->image_path && file_exists(public_path($travel->image_path))) {
                @unlink(public_path($travel->image_path));
            }
            $image = $request->file('image');
            $imageName = 'travel_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/travels'), $imageName);
            $data['image_path'] = 'uploads/travels/' . $imageName;
        }

        // Handle Audio Upload
        if ($request->hasFile('audio')) {
            if ($travel->audio_path && file_exists(public_path($travel->audio_path))) {
                @unlink(public_path($travel->audio_path));
            }
            $audio = $request->file('audio');
            $audioName = 'audio_' . time() . '.' . $audio->getClientOriginalExtension();
            $audio->move(public_path('uploads/audio'), $audioName);
            $data['audio_path'] = 'uploads/audio/' . $audioName;
        }

        // Handle Video Upload
        if ($request->hasFile('video')) {
            if ($travel->video_path && file_exists(public_path($travel->video_path))) {
                @unlink(public_path($travel->video_path));
            }
            $video = $request->file('video');
            $videoName = 'video_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads/videos'), $videoName);
            $data['video_path'] = 'uploads/videos/' . $videoName;
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
