<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;

class PaymentController extends Controller
{
public function markAsPaid(Colocation $colocation, Request $request)
{
    $colocation->payments()->create([
        'payer_id' => $request->payer_id,
        'receiver_id' => $request->receiver_id,
        'amount' => $request->amount,
        'paid_at' => now(),
    ]);

    return back()->with('success', 'Paiement marqué comme payé.');
}
}
