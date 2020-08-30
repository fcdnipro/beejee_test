<?php 
    $db = new PDO('mysql:host=localhost;dbname=epiz_26627559_mvc_db\', \'epiz_26627559\', \'K7zXQ8Vkcur2O\');
    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
    } else {
        $user = $_POST['username'];
    }
    $query = "SELECT users.email FROM users WHERE users.username = '" 
        . $user . "'";
    $user_id = $db->query($query)->fetchAll();
    if (isset($user_id[0])) {
        $email = $user_id[0]['email'];
    } else {
        $email = '';
    }
    $_POST['email'] = $email;
    echo json_encode($_POST);
?>