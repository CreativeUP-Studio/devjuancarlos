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
            'unread_messages_count' => Message::where('is_read', false)->count(),
        ];

        return view('admin.profile', compact('profile', 'stats'));
    }

    /**
     * Update main profile info and header options.
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
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'hero_bg_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'hero_badge' => ['nullable', 'string', 'max:255'],
            'hero_headline' => ['nullable', 'string', 'max:255'],
            'hero_subheadline' => ['nullable', 'string', 'max:255'],
            'location_tag' => ['nullable', 'string', 'max:255'],
            'status_tag' => ['nullable', 'string', 'max:255'],
            'stat_1_number' => ['nullable', 'string', 'max:50'],
            'stat_1_label' => ['nullable', 'string', 'max:255'],
            'stat_2_number' => ['nullable', 'string', 'max:50'],
            'stat_2_label' => ['nullable', 'string', 'max:255'],
            'stat_3_number' => ['nullable', 'string', 'max:50'],
            'stat_3_label' => ['nullable', 'string', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_github' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
        ]);

        $data = $request->only([
            'name', 'title', 'bio', 
            'hero_badge', 'hero_headline', 'hero_subheadline', 
            'location_tag', 'status_tag',
            'stat_1_number', 'stat_1_label',
            'stat_2_number', 'stat_2_label',
            'stat_3_number', 'stat_3_label',
            'social_linkedin', 'social_github', 'social_instagram', 'social_youtube'
        ]);

        // Upload CV File via Storage Symlink
        if ($request->hasFile('cv')) {
            $this->deleteFile($profile->cv_path);
            $cv = $request->file('cv');
            $cvName = 'cv_' . time() . '.' . $cv->getClientOriginalExtension();
            $storedPath = $cv->storeAs('uploads', $cvName, 'public');
            $data['cv_path'] = 'storage/' . $storedPath;
        }

        // Upload Hero Background Image via Storage Symlink
        if ($request->hasFile('hero_bg_image')) {
            $this->deleteFile($profile->hero_bg_image);
            $heroBgImg = $request->file('hero_bg_image');
            $heroBgName = 'hero_bg_' . time() . '.' . $heroBgImg->getClientOriginalExtension();
            $storedPath = $heroBgImg->storeAs('uploads', $heroBgName, 'public');
            $data['hero_bg_image'] = 'storage/' . $storedPath;
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
            'bio_backgrounds' => ['nullable', 'array'],
            'bio_backgrounds.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'delete_backgrounds' => ['nullable', 'array'],
        ]);

        $data = $request->only([
            'bio_tag', 'bio_title', 'bio_description',
            'workspace_title', 'workspace_desc', 'tech_title', 'tech_desc'
        ]);

        // Manage bio backgrounds (multiple uploads and deletions)
        $currentBackgrounds = $profile->bio_backgrounds ?? [];

        // Delete requested backgrounds
        if ($request->has('delete_backgrounds')) {
            $updatedBackgrounds = [];
            foreach ($currentBackgrounds as $bg) {
                if (in_array($bg, $request->delete_backgrounds)) {
                    $this->deleteFile($bg);
                } else {
                    $updatedBackgrounds[] = $bg;
                }
            }
            $currentBackgrounds = $updatedBackgrounds;
        }

        // Upload new biography backgrounds via Storage Symlink
        if ($request->hasFile('bio_backgrounds')) {
            foreach ($request->file('bio_backgrounds') as $file) {
                $fileName = 'bio_bg_' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $storedPath = $file->storeAs('uploads/bio_backgrounds', $fileName, 'public');
                $currentBackgrounds[] = 'storage/' . $storedPath;
            }
        }

        $data['bio_backgrounds'] = $currentBackgrounds;

        // Upload Profile Photo (Biography Main Image) via Storage Symlink
        if ($request->hasFile('photo')) {
            $this->deleteFile($profile->photo_path);
            $photo = $request->file('photo');
            $photoName = 'profile_' . time() . '.' . $photo->getClientOriginalExtension();
            $storedPath = $photo->storeAs('uploads', $photoName, 'public');
            $data['photo_path'] = 'storage/' . $storedPath;
        }

        // Upload Workspace Image via Storage Symlink
        if ($request->hasFile('workspace_image')) {
            $this->deleteFile($profile->workspace_image);
            $workspaceImg = $request->file('workspace_image');
            $workspaceName = 'workspace_' . time() . '.' . $workspaceImg->getClientOriginalExtension();
            $storedPath = $workspaceImg->storeAs('uploads', $workspaceName, 'public');
            $data['workspace_image'] = 'storage/' . $storedPath;
        }

        // Upload Tech Image via Storage Symlink
        if ($request->hasFile('tech_image')) {
            $this->deleteFile($profile->tech_image);
            $techImg = $request->file('tech_image');
            $techName = 'tech_' . time() . '.' . $techImg->getClientOriginalExtension();
            $storedPath = $techImg->storeAs('uploads', $techName, 'public');
            $data['tech_image'] = 'storage/' . $storedPath;
        }

        if ($isNew) {
            $data['name'] = $profile->name ?? 'Juan Carlos Chahuayo';
            $data['title'] = $profile->title ?? 'Desarrollador Web';
            $data['bio'] = $profile->bio ?? '';
            Profile::create($data);
        } else {
            $profile->update($data);
        }

        return redirect()->back()->with('success', 'La información ha sido actualizada con éxito.');
    }
}
