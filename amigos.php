<?php
include("controlador.php");

(new Menu)->menu_principal($idDaSessao, $idioma, $o_foto, $o_sobrenome);

if (isset($_GET['perfil']) and $_GET['perfil'] == 'CROP') :
    include('php/foto-perfil.php');
endif;
?>


                                <?php include('wged/meuscambas.php'); ?>
