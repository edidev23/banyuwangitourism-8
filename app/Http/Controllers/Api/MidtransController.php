<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DestinationBooking;
use Midtrans\Notification;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        //CONFIG MIDTRANS
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $notification = new Notification();

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        $booking = DestinationBooking::findorfail($order_id);

        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $booking->status = 'PENDING';
                } else {
                    $booking->status = 'SUCCESS';
                }
            }
        } else if ($status == 'settlement') {
            $booking->status = 'SUCCESS';
        } else if ($status == 'pending') {
            $booking->status = 'PENDING';
        } else if ($status == 'deny') {
            $booking->status = 'CANCELLED';
        } else if ($status == 'expire') {
            $booking->status = 'CANCELLED';
        } else if ($status == 'cancel') {
            $booking->status = 'CANCELLED';
        }

        $booking->save();
    }

    public function success()
    {
        return view('backend.midtrans.success');
    }

    public function unfinish()
    {
        return view('backend.midtrans.unfinish');
    }

    public function error()
    {
        return view('backend.midtrans.error');
    }
}
