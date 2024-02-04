<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Response;

class DownloadOrderInvoiceController extends Controller
{
    public function __invoke(Order $order): Response
    {
        $order->load(['orderItems.product:id,name']);

        $pdf = PDF::loadView('files.invoice', compact('order'))->setPaper('a4');

        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
    }
}
