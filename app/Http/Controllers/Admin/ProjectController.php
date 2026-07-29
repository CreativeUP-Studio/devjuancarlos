<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'steps' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'tech_stack' => ['required', 'string'], // comma-separated values
            'project_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'order' => ['required', 'integer'],
        ]);

        $data = $request->only(['title', 'description', 'steps', 'features', 'tech_stack', 'project_url', 'github_url', 'order']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'project_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/projects'), $imageName);
            $data['image_path'] = 'uploads/projects/' . $imageName;
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'El proyecto ha sido creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'steps' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'tech_stack' => ['required', 'string'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'order' => ['required', 'integer'],
        ]);

        $data = $request->only(['title', 'description', 'steps', 'features', 'tech_stack', 'project_url', 'github_url', 'order']);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($project->image_path && file_exists(public_path($project->image_path))) {
                @unlink(public_path($project->image_path));
            }

            $image = $request->file('image');
            $imageName = 'project_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/projects'), $imageName);
            $data['image_path'] = 'uploads/projects/' . $imageName;
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'El proyecto ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image_path && file_exists(public_path($project->image_path))) {
            @unlink(public_path($project->image_path));
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'El proyecto ha sido eliminado exitosamente.');
    }
}
