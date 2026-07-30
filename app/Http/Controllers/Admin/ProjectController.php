<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    private function deleteFile(?string $path): void
    {
        if (!$path) return;
        if (file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
        $relativeStoragePath = str_replace('storage/', '', $path);
        if (Storage::disk('public')->exists($relativeStoragePath)) {
            Storage::disk('public')->delete($relativeStoragePath);
        }
    }

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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
            'order' => ['required', 'integer'],
        ]);

        $data = $request->only(['title', 'description', 'steps', 'features', 'tech_stack', 'project_url', 'github_url', 'order']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'project_' . time() . '.' . $image->getClientOriginalExtension();
            $storedPath = $image->storeAs('uploads/projects', $imageName, 'public');
            $data['image_path'] = 'storage/' . $storedPath;
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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
            'order' => ['required', 'integer'],
        ]);

        $data = $request->only(['title', 'description', 'steps', 'features', 'tech_stack', 'project_url', 'github_url', 'order']);

        if ($request->hasFile('image')) {
            $this->deleteFile($project->image_path);
            $image = $request->file('image');
            $imageName = 'project_' . time() . '.' . $image->getClientOriginalExtension();
            $storedPath = $image->storeAs('uploads/projects', $imageName, 'public');
            $data['image_path'] = 'storage/' . $storedPath;
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'El proyecto ha sido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->deleteFile($project->image_path);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'El proyecto ha sido eliminado exitosamente.');
    }
}
