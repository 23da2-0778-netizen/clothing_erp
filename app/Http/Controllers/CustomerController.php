<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $customers = Customer::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', [
            'customers' => $customers,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:customers,phone', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'email' => ['nullable', 'email', 'max:255', 'unique:customers,email'],
        ], [
            'phone.regex' => 'The phone number format is invalid (only numbers, spaces, dashes, parentheses, and plus sign are allowed).',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    public function show(Customer $customer): View
    {
        $purchaseHistory = $customer->sales()
            ->with('product')
            ->latest('sale_date')
            ->get();

        return view('customers.show', [
            'customer' => $customer,
            'purchaseHistory' => $purchaseHistory,
        ]);
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => [
                'nullable', 
                'string', 
                'max:20', 
                'unique:customers,phone,' . $customer->customer_id . ',customer_id', 
                'regex:/^([0-9\s\-\+\(\)]*)$/'
            ],
            'email' => [
                'nullable', 
                'email', 
                'max:255', 
                'unique:customers,email,' . $customer->customer_id . ',customer_id'
            ],
        ], [
            'phone.regex' => 'The phone number format is invalid (only numbers, spaces, dashes, parentheses, and plus sign are allowed).',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
