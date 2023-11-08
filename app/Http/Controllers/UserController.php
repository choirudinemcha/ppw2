<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Please login to access the dashboard.',
                ])->onlyInput('email');
        }

        $users = User::get();

        return view('users')->with('userss', $users);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('users/index')->with('success', 'Berhasil hapus data');
    }
}
