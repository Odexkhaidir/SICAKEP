<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Satker;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = (auth()->user()->role == 'admin-provinsi')
            ? User::all()
            : User::where('satker_id', auth()->user()->satker_id)->get();
        return view('user.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role == 'admin-provinsi') {
            $satker = Satker::all();
            $user = User::all();
        } else {
            $satker = Satker::where('id', auth()->user()->satker_id)->get();
            $user = User::where('satker_id', auth()->user()->satker_id)->get();
        }
        return view('user.create', [
            'users' => $user,
            'satkers' => $satker,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->username);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'satker_id' => ['required'],
            'role' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'satker_id' => $request->satker_id,
            'role' => $request->role
        ]);

        return redirect('user')->with('notification', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', [
            "user" => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (auth()->user()->role == 'admin-provinsi') {
            $satker = Satker::all();
        } else {
            $satker = Satker::where('id', auth()->user()->satker_id)->get();
        }
        return view('user.edit', [
            'user' => $user,
            'satkers' => $satker,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'satker_id' => ['required'],
            'role' => ['required'],
        ];

        if ($request->username != $user->username) {
            $rules['username'] = ['required', 'string', 'max:255', 'unique:' . User::class];
        }

        if ($request->email != $user->email) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:' . User::class];
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
            'satker_id' => $request->satker_id,
            'role' => $request->role
        ];

        User::where('id', $user->id)->update($updateData);

        return redirect('user')->with('notification', 'Data berhasil disimpan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('user')->with('notification', 'Data berhasil dihapus!');
    }

    public function resetPassword(User $user)
    {

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $user->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return redirect('user')->with('notification', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
