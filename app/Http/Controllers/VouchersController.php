<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\UserVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class VouchersController extends Controller
{
    /**
     * Display a listing of the vouchers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $vouchers = Voucher::paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new voucher.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created voucher in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'points_required' => 'required|integer|min:0',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'background_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_limit' => 'nullable|integer|min:1',
            'expiration_date' => 'nullable|date|after:today',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vouchers', 'public');
        } else {
            $imagePath = null;
        }

        // Create a new voucher
        $voucher = Voucher::create([
            'code' => $request->code,
            'points_required' => $request->points_required,
            'description' => $request->description,
            'status' => $request->status,
            'background_color' => $request->background_color,
            'image' => $imagePath,
            'user_limit' => $request->user_limit,
            'expiration_date' => $request->expiration_date,
        ]);

        // Log voucher creation activity
        activity()
            ->causedBy(Auth::user()) // Assuming the admin is authenticated
            ->performedOn($voucher)
            ->withProperties(['voucher_id' => $voucher->id, 'code' => $voucher->code])
            ->log('Admin Created Voucher');

        // Redirect to the vouchers index with a success message
        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher created successfully.');
    }

    /**
     * Display the specified voucher along with redemption history.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
{
    $voucher = Voucher::findOrFail($id);
    $redemptions = $voucher->userVouchers()
        ->with('user') // Eager load the user relationship
        ->latest()
        ->paginate(10);

    return view('admin.vouchers.show', compact('voucher', 'redemptions'));
}

    /**
     * Show the form for editing the specified voucher.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified voucher in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Voucher $voucher)
    {
        // Validate the incoming request data
        $request->validate([
            'code' => 'required|string|unique:vouchers,code,' . $voucher->id,
            'points_required' => 'required|integer|min:0',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'background_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_limit' => 'nullable|integer|min:1',
            'expiration_date' => 'nullable|date|after:today',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($voucher->image) {
                Storage::disk('public')->delete($voucher->image);
            }
            $imagePath = $request->file('image')->store('vouchers', 'public');
        } else {
            $imagePath = $voucher->image;
        }

        // Update voucher
        $voucher->update([
            'code' => $request->code,
            'points_required' => $request->points_required,
            'description' => $request->description,
            'status' => $request->status,
            'background_color' => $request->background_color,
            'image' => $imagePath,
            'user_limit' => $request->user_limit,
            'expiration_date' => $request->expiration_date,
        ]);

        // Log voucher update activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($voucher)
            ->withProperties(['voucher_id' => $voucher->id, 'code' => $voucher->code])
            ->log('Admin Updated Voucher');

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher updated successfully.');
    }

    /**
     * Remove the specified voucher from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        // Log voucher deletion activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($voucher)
            ->withProperties(['voucher_id' => $id, 'code' => $voucher->code])
            ->log('Admin Deleted Voucher');

        // Redirect to the vouchers index with a success message
        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher deleted successfully.');
    }

    /**
     * Display the redemption history for a specific voucher.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function redemptionHistory($id)
    {
        $voucher = Voucher::findOrFail($id);
        $redemptions = $voucher->userVouchers()->with('user')->paginate(10);

        return view('admin.vouchers.redemption_history', compact('voucher', 'redemptions'));
    }

    public function userIndex()
    {
        $user = Auth::user();
        $vouchers = Voucher::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expiration_date')
                    ->orWhere('expiration_date', '>', now());
            })
            ->get();

        $pointsHistory = UserVoucher::with('voucher')
            ->where('user_id', $user->id)
            ->latest()
            ->take(6)
            ->get();

        return view('user.vouchers.index', compact('user', 'vouchers', 'pointsHistory'));
    }

    public function redeemVoucher($voucherId)
{
    $user = Auth::user();
    $voucher = Voucher::findOrFail($voucherId);

    if ($user->total_points < $voucher->points_required || $voucher->status !== 'active') {
        return redirect()->back()->with('error', 'Voucher cannot be redeemed.');
    }

    $user->total_points -= $voucher->points_required;
    $user->save();

    UserVoucher::create([
        'user_id' => $user->id,
        'voucher_id' => $voucher->id,
        'redeemed_at' => now()
    ]);

    return redirect()->back()->with('success', 'Voucher redeemed successfully.');
}
}