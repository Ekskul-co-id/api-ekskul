<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\PaymentLog;
use App\Traits\APIResponse;
use App\Traits\FcmResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    use APIResponse, FcmResponse;

    public function midtransHandler(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            return $this->response('Invalid data.', null, 422);
        }

        $signaturKey = $data['signature_key'];

        $orderId = $data['order_id'];

        $statusCode = $data['status_code'];

        $grossAmount = $data['gross_amount'];

        $serverKey = env('IS_PRODUCTION') ? env('MIDTRANS_SERVER_KEY_PROD') : env('MIDTRANS_SERVER_KEY_DEV');

        $mySignaturKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $transactionStatus = $data['transaction_status'];

        $paymentType = $data['payment_type'];

        $fraudStatus = $data['fraud_status'] ?? '';

        if ($signaturKey !== $mySignaturKey) {
            return $this->response('Invalid signature.', null, 422);
        }

        $order = Checkout::with('user', 'course', 'livestream')->where('order_id', $orderId)->first();

        if (empty($order)) {
            return $this->response('Order not found.', null, 404);
        }

        $typeItem = $order->type;

        if ($typeItem == 'course') {
            $name = $order->course->name;

            $image = $order->course->image;
        } elseif ($typeItem == 'livestream') {
            $name = $order->livestream->name;

            $image = $order->livestream->image;
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->update(['status' => 'challenge']);
            } elseif ($fraudStatus == 'accept') {
                $order->update(['status' => 'success']);
            }
        } elseif ($transactionStatus == 'settlement') {
            $title = 'Transaksi berhasil!';

            $body = 'Berhasil membeli '.$typeItem.' '.$name.'.';

            $order->update(['status' => 'success']);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            if ($transactionStatus == 'cancel') {
                $title = 'Pembayaran dibatalkan!';

                $body = 'Pembayaran '.$name.' dibatalkan.';
            } elseif ($transactionStatus == 'deny') {
                $title = 'Pembayaran ditolak!';

                $body = 'Pembayaran '.$name.' ditolak.';
            } elseif ($transactionStatus == 'expire') {
                $title = 'Pembayaran berkahir!';

                $body = 'Waktu pembayaran '.$typeItem.' '.$name.' telah berkahir.';
            }

            $order->update(['status' => 'failure']);
        } elseif ($transactionStatus == 'pending') {
            $body = 'Transaksi pending';

            $order->update(['status' => 'pending']);
        }

        if (!empty($title) && !empty($body)) {
            $response = $this->fcm([$order->user->device_token], $title, $image, $body);
        } else {
            $response = null;
        }

        $result = $response ? $response : '';

        PaymentLog::create([
            'status' => $transactionStatus,
            'checkout_id' => $order->id,
            'payment_type' => $paymentType,
            'raw_response' => $request->getContent(),
            'fcm_response' => $result,
        ]);

        return response()->json([
            'status' => $transactionStatus,
            'data' => $result,
        ], 201);
    }
}
