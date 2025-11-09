<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Profile\ChangePasswordRequest;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile_data = User::where('id', Auth::user()->id)->first();
        return view('admin.profile.myprofile', ['data' => $profile_data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.profile.editprofile', compact('user'));
    }

    public function changePassword(Request $request)
    {
        return view('admin.profile.changepassword');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        if (Hash::check($request->input('old_password'), Auth::user()->password)) {
            $model = User::find(Auth::user()->id);
            $model->password = Hash::make($request->input('password'));
            if ($model->save()) {
                $message = config('params.msg_success') . 'Password Changed !' . config('params.msg_end');
                $request->session()->flash('message', $message);
                Auth::logout();
                return redirect('/login');
            } else {
                $message = config('params.msg_error') . ' something went wrong !' . config('params.msg_end');
                $request->session()->flash('message', $message);
                return redirect()->back();
            }
        } else {
            $message = config('params.msg_error') . ' Invalid Old Password !' . config('params.msg_end');
            $request->session()->flash('message', $message);
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)->first();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'e_phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $url = "";
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/profile', $name);
            $url = asset('/images/profile/' . $name);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'e_phone' => $request->e_phone,
            'address' => $request->address,
            'image' => $url,
        ]);
        return redirect()->route('admin.user.getProfile')->with('success', 'My profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
