<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $apiController;

    public function __construct(ApiController $apiController)
    {
        $this->apiController = $apiController;
    }

    public function viewCart()
    {
        $cart = Session::get('cart');
        $subTotal = Session::get('cartSubTotal');
        $currency = restaurant_detail()['restaurantDetail']['currency_symbol'];
        
        return view('pages.cart', compact('cart', 'currency', 'subTotal'));
    }

    public function addToCart(Request $request)
    {
        $productId      = $request->id;
        $productImage   = $request->image;
        $options        = $request->options ?? NULL;
        $optionNames    = $request->optionNames ?? NULL;
        $productInstruction = $request->product_instruction;

        // fetch product detail using api
        $response = $this->apiController->product($productId);
        $productDetail =  collect($response['products'])->first();

        // fetch product sides/options detail for total price
        $optionsPrice = 0;
        if($options){
            $responseOptions = collect($this->apiController->options_detail(array_values($options))['options']);
            $optionsPrice = $responseOptions->sum('price');
        }

        $cart = Session::get('cart', []);

        // Check if product already exists in the cart
        $productExists = false;
        foreach ($cart as &$item) {
            if ($item['productId'] == $productId && $item['options'] == $options) {
                $item['quantity']++;
                $item['rowTotal'] = number_format($item['comboTotal'] * $item['quantity'], 2);
                $productExists = true;
                break;
            }
        }

        $rowId = $productId.time();
        if (!$productExists) {
            $cart[$rowId] = [
                'rowId'         => $rowId,
                'productId'     => $productId,
                'productTitle'  => $productDetail['title'],
                'productImage'  => $productImage,
                'productPrice'  => number_format($productDetail['price'], 2),
                'options'       => $options,
                'optionNames'   => $optionNames,
                'quantity'      => 1,
                'rowTotal'      => number_format($productDetail['price'] + $optionsPrice, 2),
                'comboTotal'    => number_format($productDetail['price'] + $optionsPrice, 2),
                'productInstruction' => $productInstruction
            ];
        }

        // Calculate the subtotal
        $subTotal = 0;
        foreach ($cart as $product) {
            $subTotal += $product['rowTotal'];
        }
        $formattedSubTotal = number_format($subTotal, 2);

        Session::put('cart', $cart);
        Session::put('cartSubTotal', $formattedSubTotal);

        return response()->json(['status' => true, 'message' => 'Product added to cart', 'cart' => $cart]);
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->row_id;
        $quantity = $request->quantity;

        $cart = Session::get('cart', []);

        $rowTotal = 0;
        foreach ($cart as &$item) {
            if ($item['rowId'] == $rowId) {
                $item['quantity'] = $quantity;
                $item['rowTotal'] = number_format($quantity * $item['comboTotal'], 2);
                $rowTotal = $item['rowTotal'];
                break;
            }
        }

        // Calculate the subtotal
        $subTotal = 0;
        foreach ($cart as $product) {
            $subTotal += $product['rowTotal'];
        }

        Session::put('cart', $cart);
        Session::put('cartSubTotal', number_format($subTotal, 2));
        
        return response()->json(['success' => true, 'message' => 'Cart updated successfully', 'rowTotal' => $rowTotal, 'cartSubTotal' => $subTotal]);
    }
    
    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $rowId = $request->id;

        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);

            // Calculate the subtotal
            $subTotal = 0;
            foreach ($cart as $product) {
                $subTotal += $product['rowTotal'];
            }

            Session::put('cart', $cart);
            Session::put('cartSubTotal', $subTotal);

            return response()->json(['message' => 'Success', 'cartSubTotal' => $subTotal], 200);
        }

        return response()->json(['message' => 'error'], 404);
    }

    public function checkoutView()
    {
        $cart = Session::get('cart');

        if($cart){
            $subTotal = Session::get('cartSubTotal');
            $currency = restaurant_detail()['restaurantDetail']['currency_symbol'];

            return view('pages.checkout', compact('cart', 'currency', 'subTotal'));
        }
        else{
            return redirect()->route('cart.view');
        }
    }

    public function destroy()
    {
        Session::flush();
    }
}
