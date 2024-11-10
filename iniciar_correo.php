<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $correo = isset($_POST['email']) ? trim($_POST['email'])  : '';
    $contra = isset($_POST['password']) ? trim($_POST['password'])  : '';

    if(empty($correo) || empty($contra)){
        header("Location: login.php");
        exit();
    }

    if(verificar($correo, $contra)){
        session_start();
        $_SESSION['usuario'] = $correo;
        header("Location: index.php");
        exit();
    }else{
        header("Location: login.php");
        exit();
    }
    
} else{
    echo "xd";
}
?>

<?php
    function verificar ($correo, $contra){
        require 'config/config.php';
        $sql = "SELECT password FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows == 1){
            $stmt->bind_result($password);
            $stmt->fetch();
            return password_verify($contra, $password);
        }else{
            return false;
        }
    }
?>