<?php session_start();

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/" . $_SESSION["data"]["payment_id"] . "?access_token=APP_USR-8196777983571350-042414-0a4eebcea5beb5ed8db3d88765d539f6-469485398");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$payData = curl_exec($curl);
curl_close($curl);

$payment_data = json_decode($payData);

session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Listo! Tu pago realizado con <?php echo $payment_data->payment_method_id; ?> por $<?php echo $payment_data->transaction_details->total_paid_amount; ?> se realizó correctamente.</p>
    <p>Número de orden del pedido: <?php echo $payment_data->order->id; ?></p>
    <p>ID de pago: <?php echo $payment_data->id; ?></p>
</body>
</html>