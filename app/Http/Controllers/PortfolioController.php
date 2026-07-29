<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Travel;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display the public portfolio page.
     */
    public function index()
    {
        $profile = Profile::first();
        $projects = Project::orderBy('order')->orderBy('created_at', 'desc')->get();
        $travels = Travel::orderBy('order')->orderBy('created_at', 'desc')->get();
        $skills = Skill::where('is_visible', true)->orderBy('order')->orderBy('name')->get();
        
        // Group skills by category
        $skillsGrouped = $skills->groupBy('category');

        return view('portfolio', compact('profile', 'projects', 'skillsGrouped', 'skills', 'travels'));
    }

    /**
     * Display a specific project details page.
     */
    public function showProject(Project $project)
    {
        $profile = Profile::first();
        $otherProjects = Project::where('id', '!=', $project->id)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('projects.show', compact('profile', 'project', 'otherProjects'));
    }

    /**
     * Display a specific travel details / bitácora page.
     */
    public function showTravel(Travel $travel)
    {
        $profile = Profile::first();
        $otherTravels = Travel::where('id', '!=', $travel->id)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('travels.show', compact('profile', 'travel', 'otherTravels'));
    }

    /**
     * Store a contact message.
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject ?? 'Mensaje de Contacto del Portafolio',
            'content' => $request->content,
            'is_read' => false,
        ]);

        return redirect()->route('portfolio.index')
            ->with('success', '¡Muchas gracias! Tu mensaje ha sido enviado correctamente. Me pondré en contacto contigo pronto.')
            // Add anchor to return directly to contact section
            ->withInput();
    }
}
