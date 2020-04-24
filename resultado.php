<?php session_start();

$_SESSION['data'] = $_POST;

switch ($_POST['payment_status']) {
    case 'approved':
        header('Location: ./pago-aprobado.php');
        break;
    case 'rejected':
            header('Location: ./pago-rechazado.php');
            break;
    case 'in_process':
            header('Location: ./pago-pendiente.php');
                break;
    case 'pending':
        header('Location: ./pago-pendiente.php');
            break;
}

?>