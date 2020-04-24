<?php session_start();

$_SESSION['data'] = $_POST;

switch ($_POST['payment_status']) {
    case 'approved':
        header('Location: ./pago-aprobado');
        break;
    case 'rejected':
            header('Location: ./pago-rechazado');
            break;
    case 'in_process':
            header('Location: ./pago-pendiente');
                break;
    case 'pending':
        header('Location: ./pago-pendiente');
            break;
}

?>