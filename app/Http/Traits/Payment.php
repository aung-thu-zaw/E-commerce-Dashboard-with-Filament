<?php

namespace App\Http\Traits;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Payment
{
    public function processOrder(string $paymentMethod, Collection $cartItems, float|int $totalAmount, string $paymentStatus = 'pending'): Order
    {
        return DB::transaction(function () use ($paymentMethod, $cartItems, $totalAmount, $paymentStatus) {
            $order = Order::create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->id(),
                'invoice_no' => 'E-COMMERCE'.mt_rand(100000000, 999999999),
                'product_qty' => $cartItems->sum('qty'),
                'payment_method' => $paymentMethod,
                'purchased_at' => $paymentStatus === 'completed' && $paymentMethod !== 'cash on delivery' ? now() : null,
                'payment_status' => $paymentStatus,
                'total_amount' => $totalAmount,
                'contact_person_name' => session('checkout-information')['contact_name'],
                'contact_phone' => session('checkout-information')['contact_phone'],
                'address' => session('checkout-information')['address'],
                'order_note' => session('checkout-information')['order_note'],
                'delivery_area' => session('checkout-information')['delivery_area'],
                'shipping_method' => session('checkout-information')['shipping_method'],
                'shipping_cost' => session('checkout-information')['shipping_cost'],
                'coupon_type' => session('coupon') ? session('coupon')['type'] : null,
                'coupon_amount' => session('coupon') ? session('coupon')['value'] : null,
                'status' => 'pending',
            ]);

            $cartItems->each(function ($item) use ($order) {
                OrderItem::create([
                       'order_id' => $order->id,
                       'product_id' => $item->product_id,
                       'qty' => $item->qty,
                       'addons' => $item->addons,
                       'unit_price' => $item->unit_price,
                       'total_price' => $item->total_price,
                   ]);

                // Update Product Qty
                $product = Product::findOrFail($item->product_id);

                $product->update(['qty' => $product->qty - $item->qty]);

            });

            // Transaction::create([
            //     'order_id' => $order->id,
            //     'transaction_id' => $transaction_id,
            //     'related_type' => 'order',
            //     'payment_method' => $paymentMethod,
            //     'amount' => $totalAmount,
            // ]);

            if (session('coupon')) {
                session()->forget('coupon');
            }

            $cartItems->each(function ($item) {
                $item->destroy($item->id);
            });

            return $order;
        });
    }

    public function sendNewOrderNotification(): void
    {
        // $admins = User::where('role', 'admin')->get();

        // $admins->each(function ($admin) use ($address, $order) {
        //     Mail::to($admin->email)->queue(new NewOrderPlacedEmail($admin, $address, $order));
        // });

    }
}
