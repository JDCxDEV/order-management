<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('firstname', 'asc')->paginate(10);

        return view('pages.customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.customers.create");        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        Customer::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'address' => $request->address,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('customers.create')->with('success', 'Customer has been created.');        
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view("pages.customers.show", [
            "customer" => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->only(['firstname', 'lastname', 'address']));
        return redirect()->route('customers.show', $customer->id)->with('success', "{$customer->name()} has been updated.");        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', "{$customer->name()} has been deleted.");
    }

    /**
     * Get all resource from storage.
     */
    public function all()
    {
        $customers = Customer::orderBy('firstname', 'asc')->get();

        return response()->json([
            'customers' => $customers
        ]);
    }
}
