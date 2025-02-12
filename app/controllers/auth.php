<?php

session_start();
require_once 'app/config/configDB.php';

class Auth
{
    public static function login($usuario, $password)
    {

        if (!isset($_SESSION['intentos'])) {
            $_SESSION['intentos'] = 0;
        }

        if ($_SESSION['intentos'] >= 3) {
            $_SESSION['error'] = "Demasiados intentos fallidos. Reinicie su navegador.";
            header("Location: index.php");
            exit();
        }

        $db = AccesoDatos::getModelo();
        $usuarioDB = $db->getUsuario($usuario);

        if ($usuarioDB && password_verify($password, $usuarioDB['password'])) {

            $_SESSION['usuario'] = $usuarioDB['login'];
            $_SESSION['rol'] = $usuarioDB['rol'];
            $_SESSION['intentos'] = 0;
            header("Location: index.php");
            exit();

        } else {

            $_SESSION['intentos']++;
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";
            header("Location: index.php");
            exit();

        }

    }

}
