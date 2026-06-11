<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    // ─── STATE: Manage District Users ────────────────────────────────────────

    public function stateUsers()
    {
        $users = User::with('districtData')
            ->where('role', 'district')
            ->orderBy('name')
            ->get();

        return view('state.users.index', compact('users'));
    }

    public function stateCreateUser()
    {
        $districts = District::orderBy('district_name')->get();

        return view('state.users.create', compact('districts'));
    }

    public function stateStoreUser(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'district_id' => 'required|exists:district,district_id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'district' => $request->district_id,
            'block'    => null,
            'password' => null,
            'role'     => 'district',
        ]);

        return redirect()->route('state.users.index')
            ->with('success', 'District user created successfully.');
    }

    public function stateEditUser($id)
    {
        $user      = User::where('id', $id)->where('role', 'district')->firstOrFail();
        $districts = District::orderBy('district_name')->get();

        return view('state.users.edit', compact('user', 'districts'));
    }

    public function stateUpdateUser(Request $request, $id)
    {
        $user = User::where('id', $id)->where('role', 'district')->firstOrFail();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'district_id' => 'required|exists:district,district_id',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'district' => $request->district_id,
        ]);

        return redirect()->route('state.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function stateResetPassword($id)
    {
        $user = User::where('id', $id)->where('role', 'district')->firstOrFail();

        // Bypass hashed cast to store raw null
        DB::table('users')->where('id', $user->id)->update(['password' => null]);

        return back()->with('success', 'Password reset. User must set a new password on next login.');
    }

    // ─── DISTRICT: Manage Block Users ────────────────────────────────────────

    public function districtUsers()
    {
        $districtId = auth()->user()->district;

        $users = User::with('blockData')
            ->where('role', 'block')
            ->whereHas('blockData', fn ($q) => $q->where('district_id', $districtId))
            ->orderBy('name')
            ->get();

        return view('district.users.index', compact('users'));
    }

    public function districtCreateUser()
    {
        $districtId = auth()->user()->district;
        $blocks     = Block::where('district_id', $districtId)->orderBy('block_name')->get();

        return view('district.users.create', compact('blocks'));
    }

    public function districtStoreUser(Request $request)
    {
        $districtId = auth()->user()->district;

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'block_id' => 'required|exists:block,block_id',
        ]);

        // Ensure the selected block belongs to this district
        $block = Block::where('block_id', $request->block_id)
                      ->where('district_id', $districtId)
                      ->firstOrFail();

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'district' => $districtId,
            'block'    => $block->block_id,
            'password' => null,
            'role'     => 'block',
        ]);

        return redirect()->route('district.users.index')
            ->with('success', 'Block user created successfully.');
    }

    public function districtEditUser($id)
    {
        $districtId = auth()->user()->district;

        $user = User::where('id', $id)->where('role', 'block')
            ->whereHas('blockData', fn ($q) => $q->where('district_id', $districtId))
            ->firstOrFail();

        $blocks = Block::where('district_id', $districtId)->orderBy('block_name')->get();

        return view('district.users.edit', compact('user', 'blocks'));
    }

    public function districtUpdateUser(Request $request, $id)
    {
        $districtId = auth()->user()->district;

        $user = User::where('id', $id)->where('role', 'block')
            ->whereHas('blockData', fn ($q) => $q->where('district_id', $districtId))
            ->firstOrFail();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'block_id' => 'required|exists:block,block_id',
        ]);

        $block = Block::where('block_id', $request->block_id)
                      ->where('district_id', $districtId)
                      ->firstOrFail();

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'block' => $block->block_id,
        ]);

        return redirect()->route('district.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function districtResetPassword($id)
    {
        $districtId = auth()->user()->district;

        $user = User::where('id', $id)->where('role', 'block')
            ->whereHas('blockData', fn ($q) => $q->where('district_id', $districtId))
            ->firstOrFail();

        DB::table('users')->where('id', $user->id)->update(['password' => null]);

        return back()->with('success', 'Password reset. User must set a new password on next login.');
    }
}
