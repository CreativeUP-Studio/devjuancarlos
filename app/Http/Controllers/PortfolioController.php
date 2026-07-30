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
        
        // Fetch all travels ordered for cyclic prev/next navigation
        $allTravels = Travel::orderBy('order')->orderBy('created_at', 'desc')->get();
        $previousTravel = null;
        $nextTravel = null;

        if ($allTravels->count() > 1) {
            $currentIndex = $allTravels->search(function($item) use ($travel) {
                return $item->id === $travel->id;
            });

            if ($currentIndex !== false) {
                $prevIndex = ($currentIndex - 1 + $allTravels->count()) % $allTravels->count();
                $nextIndex = ($currentIndex + 1) % $allTravels->count();
                $previousTravel = $allTravels->get($prevIndex);
                $nextTravel = $allTravels->get($nextIndex);
            }
        } else {
            $previousTravel = $travel;
            $nextTravel = $travel;
        }

        $otherTravels = Travel::where('id', '!=', $travel->id)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('travels.show', compact('profile', 'travel', 'previousTravel', 'nextTravel', 'otherTravels'));
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

    /**
     * Stream media file with HTTP 206 Partial Content byte-range support for HTML5 video/audio.
     */
    public function streamMedia(Request $request)
    {
        $path = $request->query('path');
        if (!$path) abort(404);

        // Normalize path
        $relativePath = str_replace('storage/', '', ltrim($path, '/'));
        $fullPath = storage_path('app/public/' . $relativePath);

        if (!file_exists($fullPath)) {
            $fullPath = public_path($path);
        }

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $size = filesize($fullPath);
        $mime = mime_content_type($fullPath) ?: 'video/mp4';
        $file = fopen($fullPath, 'rb');

        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Accept-Ranges' => 'bytes',
        ];

        // Check HTTP Range header
        $httpRange = $request->header('Range') ?? ($_SERVER['HTTP_RANGE'] ?? null);

        if ($httpRange) {
            list($param, $range) = explode('=', $httpRange, 2);
            if (strtolower($param) === 'bytes') {
                list($start, $end) = explode('-', $range);
                $start = intval($start);
                $end = ($end === '') ? ($size - 1) : intval($end);

                if ($start <= $end && $end < $size) {
                    $length = $end - $start + 1;
                    fseek($file, $start);
                    return response()->stream(function() use ($file, $length) {
                        $buffer = 1024 * 64;
                        $bytesLeft = $length;
                        while ($bytesLeft > 0 && !feof($file)) {
                            $bytesToRead = min($buffer, $bytesLeft);
                            echo fread($file, $bytesToRead);
                            flush();
                            $bytesLeft -= $bytesToRead;
                        }
                        fclose($file);
                    }, 206, [
                        'Content-Type' => $mime,
                        'Content-Length' => $length,
                        'Content-Range' => "bytes {$start}-{$end}/{$size}",
                        'Accept-Ranges' => 'bytes',
                    ]);
                }
            }
        }

        return response()->file($fullPath, $headers);
    }
}
