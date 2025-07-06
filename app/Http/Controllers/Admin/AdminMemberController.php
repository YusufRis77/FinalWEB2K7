<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Import Model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hashing password

class AdminMemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index()
    {
        // Ambil hanya user dengan role 'member'
        $members = User::where('role', 'member')->orderBy('name', 'asc')->get();
        return view('admin.anggota.index', compact('members'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(int $id)
    {
        $member = User::where('role', 'member')->findOrFail($id); // Pastikan hanya role member
        return view('admin.anggota.edit', compact('member'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, int $id)
    {
        $member = User::where('role', 'member')->findOrFail($id); // Pastikan hanya role member

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->id, // Kecuali email ini sendiri
            'phone_number' => 'nullable|string|max:20',
            'member_id' => 'nullable|string|unique:users,member_id,' . $member->id . '|max:255', // Kecuali member_id ini sendiri
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
        ]);

        $data = $request->only(['name', 'email', 'phone_number', 'member_id']);

        if ($request->filled('password')) { // Jika password diisi, hash password baru
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(int $id)
    {
        $member = User::where('role', 'member')->findOrFail($id); // Pastikan hanya role member
        $member->delete();
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }
}