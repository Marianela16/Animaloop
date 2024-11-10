<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre'])  : '';  
        $correo = isset($_POST['email']) ? trim($_POST['email'])  : '';
        $contra = isset($_POST['password']) ? trim($_POST['password'])  : '';

        if(empty($nombre) || empty($correo) || empty($contra)){
            header("Location: sign-up.php");
            exit();
        }

        if(revisarcorreo($correo)){
            header("Location: sign-up.php");
            exit();
        }
        $resultado = registrar($nombre, $correo, $contra);
        if($resultado){
            header("Location: login.php");
            exit();
        }else{
            echo "no se registro uu";
        }

    } else{
        echo "xd";
    }
?>

<?php

    function revisarcorreo($correo){
        require 'config/config.php';
        $sql = "SELECT id FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    function registrar($nom, $cor, $con){
        require 'config/config.php';
        $pass = password_hash($con, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $nom, $cor, $pass);
        return $stmt->execute();
    }
?>