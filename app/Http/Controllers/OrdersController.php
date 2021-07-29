<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;

class OrdersController extends Controller
{
    //
    public function order(Request $request){

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|int',
            'quantity' => 'required|int',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()],422);
        }
        $product = Product::where('product_id', $request->product_id)->first();

        if ($product) {
            if ($product->product_qty > $request->quantity) {
                $remaining_qty = $product->product_qty - $request->quantity;
                Product::where('product_id', $request->product_id)
                ->update(['product_qty' => $remaining_qty]);
            } else {
                return response()->json(['message' => 'Failed to order this product due to unavailability of the stock'],400);
            }
        } else {
            return response()->json(['message' => 'Product does not exit'],400);
        }

        return response()->json(['message' => 'You have successfully ordered this product.'],201);
    }
}
