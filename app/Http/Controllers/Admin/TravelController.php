<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class TravelController extends Controller
{
    /**
     * Helper to safely delete stored media files (works for direct uploads/ and symlinked storage/)
     */
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
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
            'audio' => ['nullable', 'mimes:mp3,wav,ogg,m4a', 'max:102400'],
            'video' => [$request->media_type === 'video' ? 'required' : 'nullable', 'mimes:mp4,webm,ogg,mov', 'max:2097152'],
            'order' => ['required', 'integer'],
        ];

        $request->validate($rules, [
            'image.required' => 'La imagen de fondo 100vh es obligatoria para guardar el viaje.',
            'video.required' => 'Debes seleccionar y subir un archivo de video cuando el tipo de contenido es Video.',
            'video.max' => 'El archivo de video no debe superar los 2 GB.',
            'image.max' => 'La imagen no debe superar los 100 MB.',
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

        // Handle Background Image Upload via Storage Symlink
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'travel_' . time() . '.' . $image->getClientOriginalExtension();
            $storedPath = $image->storeAs('uploads/travels', $imageName, 'public');
            $data['image_path'] = 'storage/' . $storedPath;
        }

        // Handle Audio Upload via Storage Symlink
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioName = 'audio_' . time() . '.' . $audio->getClientOriginalExtension();
            $storedPath = $audio->storeAs('uploads/audio', $audioName, 'public');
            $data['audio_path'] = 'storage/' . $storedPath;
        }

        // Handle Video Upload via Storage Symlink with Auto H.264 Transcoding
        if ($request->hasFile('video')) {
            $data['video_path'] = $this->processVideoUpload($request->file('video'));
            $data['media_type'] = 'video';
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
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:102400'],
            'audio' => ['nullable', 'mimes:mp3,wav,ogg,m4a', 'max:102400'],
            'video' => [$needVideo ? 'required' : 'nullable', 'mimes:mp4,webm,ogg,mov', 'max:2097152'],
            'order' => ['required', 'integer'],
        ];

        $request->validate($rules, [
            'video.required' => 'Debes subir un archivo de video cuando seleccionas la opción Video.',
            'video.max' => 'El archivo de video no debe superar los 2 GB.',
            'image.max' => 'La imagen no debe superar los 100 MB.',
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
            $this->deleteFile($travel->image_path);
            $data['image_path'] = null;
        }

        if ($request->boolean('delete_video')) {
            $this->deleteFile($travel->video_path);
            $data['video_path'] = null;
            if (isset($data['media_type']) && $data['media_type'] === 'video') {
                $data['media_type'] = 'image';
            }
        }

        if ($request->boolean('delete_audio')) {
            $this->deleteFile($travel->audio_path);
            $data['audio_path'] = null;
        }

        // Handle Background Image Upload
        if ($request->hasFile('image')) {
            $this->deleteFile($travel->image_path);
            $image = $request->file('image');
            $imageName = 'travel_' . time() . '.' . $image->getClientOriginalExtension();
            $storedPath = $image->storeAs('uploads/travels', $imageName, 'public');
            $data['image_path'] = 'storage/' . $storedPath;
        }

        // Handle Audio Upload
        if ($request->hasFile('audio')) {
            $this->deleteFile($travel->audio_path);
            $audio = $request->file('audio');
            $audioName = 'audio_' . time() . '.' . $audio->getClientOriginalExtension();
            $storedPath = $audio->storeAs('uploads/audio', $audioName, 'public');
            $data['audio_path'] = 'storage/' . $storedPath;
        }

        // Handle Video Upload via Storage Symlink with Auto H.264 Transcoding
        if ($request->hasFile('video')) {
            $this->deleteFile($travel->video_path);
            $data['video_path'] = $this->processVideoUpload($request->file('video'));
            $data['media_type'] = 'video';
        }

        $travel->update($data);

        return redirect()->route('admin.travels.index')->with('success', 'El viaje ha sido actualizado exitosamente.');
    }

    /**
     * Transcode uploaded video to H.264 (AVC) MP4 format using FFmpeg if available.
     */
    private function processVideoUpload($requestFile): string
    {
        $originalExt = strtolower($requestFile->getClientOriginalExtension());
        $tempFileName = 'temp_video_' . time() . '_' . uniqid() . '.' . $originalExt;
        $tempPath = $requestFile->storeAs('uploads/videos', $tempFileName, 'public');
        $fullTempPath = storage_path('app/public/' . $tempPath);

        $targetFileName = 'video_' . time() . '_' . uniqid() . '.mp4';
        $targetRelativePath = 'uploads/videos/' . $targetFileName;
        $fullTargetPath = storage_path('app/public/' . $targetRelativePath);

        $ffmpegBinary = $this->getFFmpegBinaryPath();

        // Execute FFmpeg transcoding: H.264 (AVC) + AAC audio + yuv420p pixel format
        $cmd = sprintf(
            '%s -y -i "%s" -c:v libx264 -preset fast -crf 23 -pix_fmt yuv420p -c:a aac -b:a 128k "%s" 2>&1',
            $ffmpegBinary,
            $fullTempPath,
            $fullTargetPath
        );

        exec($cmd, $output, $returnCode);

        if ($returnCode === 0 && file_exists($fullTargetPath) && filesize($fullTargetPath) > 0) {
            if (file_exists($fullTempPath)) {
                @unlink($fullTempPath);
            }
            return 'storage/' . $targetRelativePath;
        }

        // Log output if FFmpeg fails for debugging
        \Illuminate\Support\Facades\Log::error('FFmpeg transcoding failed', [
            'cmd' => $cmd,
            'returnCode' => $returnCode,
            'output' => implode("\n", (array)$output)
        ]);

        // Fallback if transcoding failed or FFmpeg binary is absent
        return 'storage/' . $tempPath;
    }

    /**
     * Resolve path to FFmpeg binary dynamically based on OS and environment.
     */
    private function getFFmpegBinaryPath(): string
    {
        $binDir = storage_path('app/bin');
        if (!file_exists($binDir)) {
            @mkdir($binDir, 0755, true);
        }

        if (str_starts_with(strtoupper(PHP_OS), 'WIN')) {
            $winExe = $binDir . DIRECTORY_SEPARATOR . 'ffmpeg.exe';
            if (file_exists($winExe)) {
                return '"' . $winExe . '"';
            }
            return 'ffmpeg';
        }

        // Linux / Unix environment
        $linuxBin = $binDir . DIRECTORY_SEPARATOR . 'ffmpeg';
        if (file_exists($linuxBin)) {
            @chmod($linuxBin, 0755);
            return '"' . $linuxBin . '"';
        }

        // Check system PATH for ffmpeg (e.g. /usr/bin/ffmpeg on Linux)
        $whichPath = trim((string) @shell_exec('which ffmpeg 2>/dev/null'));
        if (!empty($whichPath)) {
            return '"' . $whichPath . '"';
        }

        return 'ffmpeg';
    }

    /**
     * Remove the specified travel from storage.
     */
    public function destroy(Travel $travel)
    {
        $this->deleteFile($travel->image_path);
        $this->deleteFile($travel->video_path);
        $this->deleteFile($travel->audio_path);

        $travel->delete();

        return redirect()->route('admin.travels.index')->with('success', 'El viaje ha sido eliminado exitosamente.');
    }
}
