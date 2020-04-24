<?php
    
    header("HTTP/1.1 200 OK");

    require __DIR__ .  '/vendor/autoload.php';

    MercadoPago\SDK::setAccessToken("APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398");

    $merchant_order = null;

    switch($_GET["topic"]) {
        case "payment":
            $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);

            $file = fopen("payment.txt", "w");
            fwrite($file, 'payment in' . PHP_EOL);
            fwrite($file, 'id:' . $payment->id . PHP_EOL);
            fwrite($file, 'status_detail:' . $payment->status_detail . PHP_EOL);
            fwrite($file, 'total_pay:' . $payment->transaction_details->total_paid_amount . PHP_EOL);
            fwrite($file, 'total_pay:' . date('Y-m-d') . PHP_EOL);
            fclose($file);

            // Gestiones al recibir payment
            break;
        case "merchant_order":
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
            $file = fopen("merchant.txt", "w");
            fwrite($file, 'merchant_order_in' . PHP_EOL);
            fclose($file);

            // Gestiones al recibir merchant_order
            break;

    }

    // Resto de la lógica de negocio

    $paid_amount = 0;
    foreach ($merchant_order->payments as $payment) {
        if ($payment['status'] == 'approved'){
            $paid_amount += $payment['transaction_amount'];
        }
    }

    // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
    if($paid_amount >= $merchant_order->total_amount){
        if (count($merchant_order->shipments)>0) { // The merchant_order has shipments
            if($merchant_order->shipments[0]->status == "ready_to_ship") {
                print_r("Totally paid. Print the label and release your item.");
            }
        } else { // The merchant_order don't has any shipments
            print_r("Totally paid. Release your item.");
        }
    } else {
        print_r("Not paid yet. Do not release your item.");
    }

?>