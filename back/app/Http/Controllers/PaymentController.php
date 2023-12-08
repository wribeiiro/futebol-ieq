<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $monthYear = $request->input('month');

        if ($monthYear) {
            $payment = Payment::with(['player'])->where('month_year', $monthYear)->get();
        } else {
            $payment = Payment::with(['player'])->get();
        }

        return response()->json($payment);
    }

    public function store(Request $request)
    {
        $payment = new Payment([
            'status' => $request->input('status'),
            'amount' => $request->input('amount'),
            'player_id' => $request->input('player_id'),
            'pay_date' => $request->input('pay_date'),
        ]);

        $payment->save();

        return response()->json('payment created!');
    }

    public function show($id)
    {
        $payment = Payment::with(['player'])->find($id);
        return response()->json($payment);
    }

    public function update($id, Request $request)
    {
        $payment = Payment::find($id);

        foreach ($request->all() as $key => $value) {
            $payment->{$key} = $value;
        }

        $payment->update();

        return response()->json('payment updated!');
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();

        return response()->json('payment deleted!');
    }
}
