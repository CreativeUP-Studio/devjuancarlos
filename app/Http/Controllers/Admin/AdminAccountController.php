<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminAccountController extends Controller
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
     * Show the form for editing the admin profile account.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.account', compact('user'));
    }

    /**
     * Update the admin profile account details and avatar.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:51200'],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'El nombre del administrador es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',
            'avatar.max' => 'La foto de perfil no debe superar los 50 MB.',
            'current_password.required_with' => 'Debes ingresar tu contraseña actual para establecer una nueva contraseña.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        // Validate current password if attempting to change password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual ingresada es incorrecta.'])->withInput();
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            $this->deleteFile($user->avatar_path);
            $avatar = $request->file('avatar');
            $avatarName = 'avatar_' . time() . '.' . $avatar->getClientOriginalExtension();
            $storedPath = $avatar->storeAs('uploads/avatars', $avatarName, 'public');
            $user->avatar_path = 'storage/' . $storedPath;
        }

        // Remove Avatar if requested
        if ($request->boolean('delete_avatar')) {
            $this->deleteFile($user->avatar_path);
            $user->avatar_path = null;
        }

        $user->save();

        return redirect()->route('admin.account.edit')->with('success', 'El perfil de administrador se ha actualizado correctamente.');
    }
}
