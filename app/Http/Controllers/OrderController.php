<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $is_manager = Auth::user()->is_manager;
        $orders = Order::orderBy('created_at', 'asc');
          
        if(!$is_manager) {
            $orders->where(['created_by' => Auth::user()->id]);
        }
        
        $orders = $orders->paginate(15);
        return view('pages.orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        DB::beginTransaction();
            $order = Order::create([
                'customer_id' => $request->customer,
                'created_by' => $user->id,
            ]);
            foreach($request->items as $item) {
                $order->order_items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        DB::commit();        

        return response()->json([
            'status' => 200,
            'message' => 'Order created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('pages.orders.show', [
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $user = Auth::user();
        if(!$user->is_manager) {
            if($order->created_by == $user->id) {
                $order->delete();                
            } else {
                return redirect()->back();
            }
        } else {
            $order->delete();
        }
        return redirect()->route('orders.index')->with('success', "Order has been deleted.");        
    }
}
