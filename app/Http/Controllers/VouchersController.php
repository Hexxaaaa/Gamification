<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);

        // Create a new voucher
        $voucher = Voucher::create($request->all());

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
        $voucher = Voucher::with(['userVouchers.user'])->findOrFail($id);
        $redemptions = $voucher->userVouchers()->with('user')->paginate(10);

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
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'code' => 'required|string|unique:vouchers,code,' . $voucher->id,
            'points_required' => 'required|integer|min:0',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Update the voucher with validated data
        $voucher->update($request->all());

        // Log voucher update activity
        activity()
            ->causedBy(Auth::user())
            ->performedOn($voucher)
            ->withProperties(['voucher_id' => $voucher->id, 'updated_fields' => $request->all()])
            ->log('Admin Updated Voucher');

        // Redirect to the vouchers index with a success message
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
}