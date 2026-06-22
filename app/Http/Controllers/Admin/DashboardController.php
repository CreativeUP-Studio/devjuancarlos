<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics and profile settings.
     */
    public function index()
    {
        $profile = Profile::first() ?? new Profile();
        
        $stats = [
            'projects_count' => Project::count(),
            'skills_count' => Skill::count(),
            'travels_count' => Travel::count(),
            'messages_count' => Message::count(),
            'unread_messages' => Message::where('is_read', false)->count(),
        ];

        // Fetch recent messages for BI (Bandeja de Entrada)
        $recentMessages = Message::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.profile', compact('profile', 'stats', 'recentMessages'));
    }

    /**
     * Update the profile settings (Header / basic info).
     */
    public function updateProfile(Request $request)
    {
        $profile = Profile::first();
        $isNew = false;
        
        if (!$profile) {
            $profile = new Profile();
            $isNew = true;
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'cv' => ['nullable', 'mimes:pdf,docx,doc', 'max:10240'],
            'hero_bg_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        $data = $request->only([
            'name', 'title', 'bio', 'email', 'phone', 'location', 'github_url', 'linkedin_url'
        ]);

        // Upload CV File
        if ($request->hasFile('cv')) {
            // Delete old CV if it exists
            if ($profile->cv_path && file_exists(public_path($profile->cv_path))) {
                @unlink(public_path($profile->cv_path));
            }

            $cv = $request->file('cv');
            $cvName = 'cv_' . time() . '.' . $cv->getClientOriginalExtension();
            $cv->move(public_path('uploads'), $cvName);
            $data['cv_path'] = 'uploads/' . $cvName;
        }

        // Upload Hero Background Image
        if ($request->hasFile('hero_bg_image')) {
            // Delete old image if it exists
            if ($profile->hero_bg_image && file_exists(public_path($profile->hero_bg_image))) {
                @unlink(public_path($profile->hero_bg_image));
            }

            $heroBgImg = $request->file('hero_bg_image');
            $heroBgName = 'hero_bg_' . time() . '.' . $heroBgImg->getClientOriginalExtension();
            $heroBgImg->move(public_path('uploads'), $heroBgName);
            $data['hero_bg_image'] = 'uploads/' . $heroBgName;
        }

        if ($isNew) {
            Profile::create($data);
        } else {
            $profile->update($data);
        }

        return redirect()->route('admin.dashboard')->with('success', 'La información del Inicio y Header ha sido actualizada.');
    }

    /**
     * Show the biography edit form.
     */
    public function editBiography()
    {
        $profile = Profile::first() ?? new Profile();
        return view('admin.biography', compact('profile'));
    }

    /**
     * Update biography section.
     */
    public function updateBiography(Request $request)
    {
        $profile = Profile::first();
        $isNew = false;
        
        if (!$profile) {
            $profile = new Profile();
            $isNew = true;
        }

        $request->validate([
            'bio_tag' => ['nullable', 'string', 'max:255'],
            'bio_title' => ['nullable', 'string', 'max:255'],
            'bio_description' => ['nullable', 'string'],
            'workspace_title' => ['nullable', 'string', 'max:255'],
            'workspace_desc' => ['nullable', 'string'],
            'tech_title' => ['nullable', 'string', 'max:255'],
            'tech_desc' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'workspace_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'tech_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
        ]);

        $data = $request->only([
            'bio_tag', 'bio_title', 'bio_description',
            'workspace_title', 'workspace_desc', 'tech_title', 'tech_desc'
        ]);

        // Upload Profile Photo (Biography Main Image)
        if ($request->hasFile('photo')) {
            if ($profile->photo_path && file_exists(public_path($profile->photo_path))) {
                @unlink(public_path($profile->photo_path));
            }
            $photo = $request->file('photo');
            $photoName = 'profile_' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads'), $photoName);
            $data['photo_path'] = 'uploads/' . $photoName;
        }

        // Upload Workspace Image
        if ($request->hasFile('workspace_image')) {
            if ($profile->workspace_image && file_exists(public_path($profile->workspace_image))) {
                @unlink(public_path($profile->workspace_image));
            }
            $workspaceImg = $request->file('workspace_image');
            $workspaceName = 'workspace_' . time() . '.' . $workspaceImg->getClientOriginalExtension();
            $workspaceImg->move(public_path('uploads'), $workspaceName);
            $data['workspace_image'] = 'uploads/' . $workspaceName;
        }

        // Upload Tech Image
        if ($request->hasFile('tech_image')) {
            if ($profile->tech_image && file_exists(public_path($profile->tech_image))) {
                @unlink(public_path($profile->tech_image));
            }
            $techImg = $request->file('tech_image');
            $techName = 'tech_' . time() . '.' . $techImg->getClientOriginalExtension();
            $techImg->move(public_path('uploads'), $techName);
            $data['tech_image'] = 'uploads/' . $techName;
        }

        if ($isNew) {
            $data['name'] = $profile->name ?? 'Juan Carlos Chahuayo';
            $data['title'] = $profile->title ?? 'Desarrollador Web';
            $data['bio'] = $profile->bio ?? '';
            Profile::create($data);
        } else {
            $profile->update($data);
        }

        return redirect()->route('admin.biography.edit')->with('success', 'La sección de biografía ha sido actualizada con éxito.');
    }
}
