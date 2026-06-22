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
        $skills = Skill::orderBy('category')->orderBy('order')->orderBy('name')->get();
        return view('admin.skills.index', compact('skills'));
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
}
