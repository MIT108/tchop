<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pack;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function index()
    {

        $orders = Order::where('status', "pending")->with(['customer'])->get();
        $canceledOrders = Order::where('status', "canceled")->with(['customer'])->get();
        $deliveredOrders = Order::where('status', "delivered")->with(['customer'])->get();
        return view('pages/order/index')
            ->with('orders', $orders)
            ->with('canceledOrders', $canceledOrders)
            ->with('deliveredOrders', $deliveredOrders);
    }

    public function makeOrderApi(Request $request){
        $response = [];
        $code = 0;
        if (count($request->all()) > 0) {
            $packs = Pack::get();
            try {
                //code...
                $order = Order::create([
                    'customer_id' => auth()->user()->id,
                    'totalAmount' => 0,
                    'status' => 'pending'
                ]);
                $total = 0;

                foreach ($packs as $pack) {
                    if($request[$pack->id] != null){
                        OrderItem::create([
                            'order_id' => $order->id,
                            'pack_id' => $pack->id,
                            'amount' => $request[$pack->id]["amount"],
                            'quantity' => $request[$pack->id]["quantity"]
                        ]);
                        $total =$total + $request[$pack->id]["amount"];
                    }
                }

                Order::where('id', $order->id)->update([
                    'totalAmount' => $total,
                ]);

                $response = [
                    'message' => 'successful'
                ];
                $code = 200;



            } catch (\Throwable $th) {
                //throw $th;
                $response = [
                    'error' => $th->getMessage(),
                    'message' => 'Internal server error'
                ];
                $code = 500;
            }
        }else{
            $response = [
                'message' => 'no pack selected'
            ];
            $code = 422;

        }

        return response($response, $code);
    }

    public function viewOrder($id){
        return view('pages/order/view');
    }

    public function updateOrderStatus($value, $id){
        try {
            //code...
            Order::where('id', $id)->update([
                'status' => $value
            ]);
            return redirect()->back()->with('success', "updated successfully");

        } catch (\Throwable $th) {
            //throw $th;
                return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
