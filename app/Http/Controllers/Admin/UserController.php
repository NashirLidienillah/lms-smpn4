<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Mapel;

class UserController extends Controller {
    public function index() {
        $users = User::orderBy('role', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $validated = $request->validate ([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', // unique biar username tidak kembar
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,guru,siswa'
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect('/admin/users')->with('success', 'Data Pengguna berhasil ditambahkan');
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $rules = [
            'name'=> 'required|string|max:255',
            'role' => 'required|in:admin,guru,siswa'
        ];
        if ($request->username != $user->username) {
            $rules['username'] = 'required|string|max:255|unique:users,username';
        } else {
            $rules['username'] = 'required|string|max:255';
        }
        $validated = $request->validate($rules);

        if ($request->filled('pasword')) {
            $validated['password'] = bcrypt($request->password);
        }
        $user->update($validated);
        return redirect('/admin/users')->with('success', 'Data Pengguna Berhasil Diperbarui');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/admin/users')->with('success', 'Data pengguna berhasil dihapus');
    }
}