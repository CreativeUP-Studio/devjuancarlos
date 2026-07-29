<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = \App\Models\Profile::first() ?? new \App\Models\Profile();
        $skills = Skill::orderBy('order')->orderBy('name')->get();
        return view('admin.skills.index', compact('profile', 'skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Backend', 'Frontend', 'Bases de Datos', 'DevOps / Nube', 'Herramientas / Otros'];
        return view('admin.skills.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'proficiency' => ['required', 'integer', 'min:1', 'max:100'],
            'icon_class' => ['nullable', 'string', 'max:255'],
            'order' => ['required', 'integer'],
        ]);

        Skill::create($request->all());

        return redirect()->route('admin.skills.index')->with('success', 'La habilidad técnica ha sido agregada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        $categories = ['Backend', 'Frontend', 'Bases de Datos', 'DevOps / Nube', 'Herramientas / Otros'];
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'proficiency' => ['required', 'integer', 'min:1', 'max:100'],
            'icon_class' => ['nullable', 'string', 'max:255'],
            'order' => ['required', 'integer'],
        ]);

        $skill->update($request->all());

        return redirect()->route('admin.skills.index')->with('success', 'La habilidad técnica ha sido actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'La habilidad técnica ha sido eliminada exitosamente.');
    }

    /**
     * Update the skills section text (UNCP).
     */
    public function updateText(Request $request)
    {
        $request->validate([
            'tech_desc' => ['nullable', 'string'],
            'tech_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
        ]);

        $profile = \App\Models\Profile::first() ?? new \App\Models\Profile();
        $profile->tech_desc = $request->tech_desc;

        // Delete background image if requested
        if ($request->has('delete_tech_image')) {
            if ($profile->tech_image && file_exists(public_path($profile->tech_image))) {
                @unlink(public_path($profile->tech_image));
            }
            $relativeStoragePath = str_replace('storage/', '', $profile->tech_image ?? '');
            if ($relativeStoragePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($relativeStoragePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relativeStoragePath);
            }
            $profile->tech_image = null;
        }

        // Upload new background image via Storage Symlink
        if ($request->hasFile('tech_image')) {
            if ($profile->tech_image && file_exists(public_path($profile->tech_image))) {
                @unlink(public_path($profile->tech_image));
            }
            $relativeStoragePath = str_replace('storage/', '', $profile->tech_image ?? '');
            if ($relativeStoragePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($relativeStoragePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($relativeStoragePath);
            }

            $file = $request->file('tech_image');
            $fileName = 'tech_bg_' . time() . '.' . $file->getClientOriginalExtension();
            $storedPath = $file->storeAs('uploads', $fileName, 'public');
            $profile->tech_image = 'storage/' . $storedPath;
        }

        if (!$profile->exists) {
            $profile->name = 'Juan Carlos Chahuayo Martínez';
            $profile->title = 'Estudiante de Ingeniería de Sistemas';
            $profile->bio = 'Listo para crear y no parar';
        }

        $profile->save();

        return redirect()->route('admin.skills.index')->with('success', 'El texto e imagen de la sección de habilidades han sido actualizados exitosamente.');
    }

    /**
     * Toggle visibility of the technical skill.
     */
    public function toggleVisibility(Skill $skill)
    {
        $skill->is_visible = !$skill->is_visible;
        $skill->save();

        $status = $skill->is_visible ? 'visible' : 'oculta';
        return redirect()->route('admin.skills.index')->with('success', "La tecnología \"{$skill->name}\" ahora está {$status}.");
    }
}
