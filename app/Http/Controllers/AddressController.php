<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('created_at', 'desc')->get();

        return view('customer.addresses.index', compact('addresses'));
    }


    public function create()
    {
        return view('customer.addresses.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'street_address_1' => 'required|string|min:3|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'required|string|min:2|max:100',
            'state' => 'required|string|min:2|max:100',
            'country' => 'required|string|min:2|max:100',
        ]);
        Auth::user()->addresses()->create($validated);

        return redirect()->route('addresses.index')->with('success', 'Address added successfully!');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }


        return view('customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address)
    {

        if ($address->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'street_address_1' => 'required|string|min:3|max:255',
            'street_address_2' => 'nullable|string|max:255',
            'city' => 'required|string|min:2|max:100',
            'state' => 'required|string|min:2|max:100',
            'country' => 'required|string|min:2|max:100',
        ]);

        $address->update($validated);

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully!');
    }


    public function destroy(Address $address)
    {

        if ($address->user_id !== Auth::id()) {
            return abort(403, 'Unauthorized');
        }

        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully!');
    }
}
