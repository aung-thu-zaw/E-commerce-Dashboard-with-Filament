<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order Invoice</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>

<style>
    .font-sans {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
    }
</style>

<body>
    <div class="font-sans bg-gray-50 min-h-screen flex items-center justify-center">
        <div class=" bg-white rounded-md  p-10 smy-10">
            <div id="print-document" class="space-y-5 mb-10">
                <div>
                    <h2 class="font-bold text-md text-gray-700 mb-6">
                        Order Invoice -
                        <span class="text-orange-600 text-xs font-bold">{{ $order->invoice_no }}</span>
                    </h2>

                    <div class="space-y-5 flex items-start justify-between">
                        <div class="space-y-5">

                            <div class="space-y-1 font-bold text-gray-900">
                                <h3 class="text-md mb-1.5 text-gray-800">Delivery Information</h3>
                                <p class="text-xs capitalize">
                                    Name : <span class="text-gray-600">{{ $order->contact_person_name }}</span>
                                </p>

                                <p class="text-xs capitalize">
                                    Email :
                                    <span class="text-gray-600">{{ $order->contact_email }}</span>
                                </p>

                                <p class="text-xs capitalize">
                                    Phone :
                                    <span class="text-gray-600">{{ $order->contact_phone }}</span>
                                </p>

                                <p class="text-xs capitalize">
                                    Address :
                                    <span class="text-gray-600">{{ $order->address }}</span>
                                </p>
                            </div>


                            <div class="space-y-1 font-bold text-gray-900">
                                <h3 class="text-md mb-1.5 text-gray-800">Payment Information</h3>
                                <p class="text-xs capitalize">
                                    Method : <span class="text-gray-600">{{ $order->payment_method }}</span>
                                </p>
                                <p class="text-xs">
                                    Transaction Id :
                                    <span class="text-gray-600">
                                        -
                                        {{-- {{ $order->transaction ? $order->transaction->transaction_id : '-' }} --}}
                                    </span>
                                </p>
                                <p class="text-xs capitalize">
                                    Status :
                                    <span class="text-blue-600">{{ $order->payment_status }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="space-y-1 font-bold text-gray-700 text-right">
                            <h3 class="text-md mb-1.5">Order Date</h3>
                            <p class="text-xs capitalize">{{ $order->created_at }}</p>
                        </div>
                    </div>
                </div>

                <hr />
                <div>
                    <h2 class="font-bold text-md text-gray-700 mb-3">
                        <i class="fa-solid fa-clipboard-list"></i>
                        Order Summary
                    </h2>
                </div>

                <div>
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                                <div class="border rounded-lg overflow-hidden w-full">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-start text-sm font-bold text-gray-700">
                                                    Item
                                                </th>
                                                <th class="px-6 py-3 text-start text-sm font-bold text-gray-700">
                                                    Addons
                                                </th>
                                                <th class="px-6 py-3 text-start text-sm font-bold text-gray-700">
                                                    Price
                                                </th>
                                                <th class="px-6 py-3 text-start text-sm font-bold text-gray-700">
                                                    Qty
                                                </th>
                                                <th class="px-6 py-3 text-start text-sm font-bold text-gray-700">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td class="px-6 py-4 text-[.8rem] text-gray-600 font-semibold">
                                                    {{ $item->product->name }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 text-[.8rem] text-gray-600  font-semibold capitalize">
                                                    <span class="flex flex-wrap">
                                                        @if ($item->addons)
                                                        {{ $item->addons }}
                                                        @else
                                                        -
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-[.8rem] text-gray-600 font-semibold">
                                                    {{ $item->unit_price }}
                                                </td>
                                                <td class="px-6 py-4 text-[.8rem] text-gray-600 font-semibold">
                                                    {{ $item->qty }}
                                                </td>
                                                <td class="px-6 py-4 text-[.8rem] text-gray-600 font-semibold">
                                                    {{ $item->total_price }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="w-full flex flex-col items-end justify-center font-semibold text-gray-500 text-xs space-y-5">
                    <div class="space-y-1 w-full text-right">
                        <p>Subtotal</p>
                        <p class="text-sm font-bold text-gray-700">
                            $ {{ $order->total_amount - $order->shipping_cost }}
                        </p>
                    </div>
                    <div class="space-y-1 w-full text-right">
                        <p>Shipping Fee (+)</p>
                        <p class="text-sm font-bold text-gray-700">
                            $ {{ $order->shipping_cost }}
                        </p>
                    </div>
                    <div class="space-y-1 w-full text-right">
                        <p>Coupon (-)</p>
                        @if ($order->coupon_code && $order->coupon_type)

                        <p class="text-sm font-bold text-gray-700">
                            @if ($order->coupon_type === 'fixed')
                            <span>
                                ${{ $order->coupon_amount }}
                            </span>
                            @endif
                            @if ($order->coupon_type === 'percentage')
                            <span>
                                %{{ $order->coupon_amount }}
                            </span>
                            @endif
                        </p>
                        @else
                        <p class="text-sm font-bold text-gray-700">$ 0</p>
                        @endif
                    </div>
                    <div class="space-y-1 w-full text-right">
                        <p>Total</p>
                        <p class="text-sm font-bold text-gray-700">
                            $ {{ $order->total_amount }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>

</html>