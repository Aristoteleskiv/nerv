<?php /** @noinspection PhpUndefinedClassInspection */

use JetBrains\PhpStorm\Pure;

error_reporting(E_ALL);
ini_set('display_errors', 'on');
define('DIR', __DIR__.'ecomue/');
define('DEBUG', 0);
// Path to the chat directory:
define('KV7_PATH', dirname($_SERVER['SCRIPT_FILENAME']).'/');
header('refresh:91');

require(KV7_PATH.'language/servidor.php');
include(KV7_PATH."classes/mas.php");
include(KV7_PATH."classes/DAO.php");
include(KV7_PATH."classes/exlplora.php");
require(KV7_PATH.'classes/Tempo.class.php');
require(KV7_PATH.'classes/hashtag.php');
require(KV7_PATH.'classes/DB.class.php');
require(KV7_PATH.'classes/Login.class.php');
require(KV7_PATH.'classes/Amisade.class.php');
require(KV7_PATH.'classes/noty.php');
require(KV7_PATH.'classes/Recados.class.php');
require(KV7_PATH.'classes/Allbuns.class.php');
require(KV7_PATH.'classes/Notificacoes.class.php');
require(KV7_PATH.'classes/Postagem.php');
require(KV7_PATH.'classes/Estorial.php');
require(KV7_PATH.'classes/Outros.php');
require(KV7_PATH.'classes/Menu.php');
require(KV7_PATH.'classes/Temas.php');
require(KV7_PATH.'classes/seguidor.php');
require(KV7_PATH.'classes/mutual.class.php');
require(KV7_PATH.'classes/lingua.php');
require(KV7_PATH.'classes/chat.php');


$edioma = new lingua();
$edioma->mudarlingua();
$objLogin = new Login;
if(!$objLogin->logado()){
    include('login.php');
    exit();
}

if(isset($_GET['sair'])){
    if(isset($_SESSION['ecomo_uid'])){

        if (!isset($_COOKIE['id'])) {
            setcookie("id", json_encode(array($_SESSION['ecomo_uid'])), time()+30*24*60*60);

        } else if (isset($_COOKIE['id'])) {

            $arr = array();
            $ids = json_decode($_COOKIE['id']);

            foreach ($ids as $value) {
                $arr[] = $value;
            }

            array_push($arr, $_SESSION['ecomo_uid']);
            setcookie("id", json_encode(array_unique($arr)), time()+30*24*60*60);

        }

        // setcookie("id", null, time()-30*24*60*60);

    }
    $objLogin->sair();
    header('Location: ./');
    exit;
}
$idExtrangeiro = (isset($_GET['uid'])) ? (int)$_GET['uid'] : $_SESSION['ecomo_uid'];
$idDaSessao = $_SESSION['ecomo_uid'];

$idExists = DB::getConn()->prepare('SELECT `id` FROM `usuarios` WHERE `id`=?');
$idExists->execute([$idExtrangeiro]);
if($idExists->rowCount()==0){
    $objLogin->sair();
    header('Location: '.KV7_PATH);
    exit;
}
$dados = $objLogin->getDados($idExtrangeiro);
$o = $objLogin->getpessoaligado($idDaSessao);
if(is_null($dados)){
    header('Location: ./');
    exit();
}else{
    extract($dados,EXTR_PREFIX_ALL,'user');
}
if(is_null($o)){
    header('Location: ./');
    exit();
}else{
    extract($o,EXTR_PREFIX_ALL,'o');
}
function user_img($img,$idDaSessao){
    return ($img<>'' AND file_exists('usuarios/'.$idDaSessao.'/eu/'.$img)) ? $img : 'default.gif';
}
function dd($in, $dump = false)
{
    echo '<pre>';
    if ($dump) {
        var_dump($in);
    } else {
        print_r($in);
    }
    echo '</pre>';
    exit;
}
$user_nome = $o["nome"];
$user_snome = $o["snome"];
$o_foto = $o["foto"];
$user_sobrenome = $o["sobrenome"];

$user_nomecompleto = $user_nome.' '.$user_sobrenome.' '.$user_snome;
if ($user_nomecompleto == ''):
    $nome  = $user_nome.' '.$user_sobrenome.' '.$user_snome;

else:
    $nome  = $user_nomecompleto;
endif;
$titulo_pagina = $idioma[509];
$titulo_pagina_inicial = $idioma[509];
$estorial = Estorial::getEstorias($idExtrangeiro);
$lista_amisade = Amisade::lista_amisade($idDaSessao);
$list_amigos = Amisade::list_amigos($idExtrangeiro);
$listas = Amisade::seconheces($idExtrangeiro);
$albuns = Albuns::listAlbuns($idExtrangeiro);


function normalTime($time)
{
    $str = strtotime($time);
    return date("d-F", $str);
}



$mas = new mas();
if(isset($_POST["group"])  AND isset($_POST["Usuario"])){
    $group_number = filter_var($_POST["group"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    $idExtrangeiro = filter_var($_POST["Usuario"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    echo mas::getDada($idExtrangeiro,$idioma,$group_number);
}


$dao = new DAO();
if(isset($_POST["group_no"])){
    $group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    echo (new DAO)->getData($idExtrangeiro,$idDaSessao,$idioma,$group_number);
}

$am = new Amisade();
if(isset($_POST["group_am"])){
    $group_n = filter_var($_POST["group_am"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    echo $am->meus_amigos($idExtrangeiro,$idDaSessao,$group_n);
}

$cas = new chat();
if(isset($_POST["chatgroup"]) AND isset($_POST["chatU"])){
    $group_number = filter_var($_POST["chatgroup"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    $id = filter_var($_POST["chatU"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    echo (new chat)->getchatData($id,$idDaSessao,$idioma,$group_number);
}


?>
<!DOCTYPE html>
<html lang="pt-br"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/template.css">
    <link rel="stylesheet" href="assets/css/framework7.ios.css">
    <!-- Path to your custom app styles-->
    <link href="assets/css/material-kit.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/my-app.css">
    <link rel="stylesheet" href="assets/css/p_f.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            font-size: 14px;
            line-height: 1.4;
            width: 100%;
            -webkit-text-size-adjust: 100%;
            background: #fff;
            border-radius: 13px;
            overflow: hidden;
            -webkit-font-smoothing:antialiased;
            border: 2px solid #000000;
        }
        html {
            background-color: #000;
        }

          .-cx-PRIVATE-Page__body__{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column}.-cx-PRIVATE-Page__root__{height:100vh}

        .-cx-PRIVATE-Page__main__{-webkit-box-flex:1;-webkit-flex:1 0 auto;-ms-flex:1 0 auto;flex:1 0 auto}.-cx-PRIVATE-Page__main__{margin-top:137px;position:relative}@media screen and (max-width:990px){.-cx-PRIVATE-Page__main__{display:block;margin-top:0}}.-cx-PRIVATE-NavBar__root__{background-color:#fff;border-bottom:1px solid #efefef;height:77px;position:fixed;top:0;width:100%;z-index:100}.-cx-PRIVATE-NavBar__profilePic__{display:none}.-cx-PRIVATE-NavBar__username__{color:#003569;display:inline!important;float:right;font-weight:400;margin-right:2px;margin-top:12px}.-cx-PRIVATE-NavBar__signIn__{display:inline-block;float:right;margin-right:2px;margin-top:12px}.-cx-PRIVATE-NavBar__signInText__{color:#003569;font-weight:400}.-cx-PRIVATE-NavBar__logo__{background-image:url(/static/images/branding/logoWhiteoutLockup.png/3a62b1a95da3.png);background-size:100%;height:35px;left:16px;position:absolute;text-indent:-9999em;top:6px;width:176px}.-cx-PRIVATE-NavBar__logo__ a{display:block;height:100%;width:100%}@media screen and (-webkit-min-device-pixel-ratio:1.5),screen and (min-resolution:1.5dppx){.-cx-PRIVATE-NavBar__logo__{background-image:url(/static/images/branding/logoWhiteoutLockup@2x.png/43608c988939.png)}}.-cx-PRIVATE-NavBar__logoGroup__{left:16px;position:absolute;top:6px}.-cx-PRIVATE-NavBar__logoGroup__ .-cx-PRIVATE-NavBar__logo__{position:static}.-cx-PRIVATE-NavBar__wrapper__{margin:0 auto;max-width:1026px;padding:0 16px;position:relative}.-cx-PRIVATE-NavBar__topBarActions__,.-cx-PRIVATE-SidebarLayout__content__ li{list-style:none}.-cx-PRIVATE-NavBar__dropdown__,.-cx-PRIVATE-NavBar__topBarLeft__,.-cx-PRIVATE-SidebarLayout__content__ .separator,.-cx-PRIVATE-SidebarLayout__content__ .subtitle{display:none}.-cx-PRIVATE-SidebarLayout__content__{border-right:1px solid #efefef;height:100%;width:220px}.-cx-PRIVATE-SidebarLayout__content__ ul{margin:0;padding:0}@media screen and (max-width:990px){.-cx-PRIVATE-SidebarLayout__content__{margin:0 px;border:0;width:100%}.-cx-PRIVATE-SidebarLayout__content__ ul{display:none}}.-cx-PRIVATE-SidebarLayout__root__{-webkit-box-sizing:border-box;box-sizing:border-box;height:100%;pointer-events:none;position:absolute;width:100%;z-index:1}@media screen and (max-width:990px){.-cx-PRIVATE-SidebarLayout__root__{height:auto;padding-bottom:0;padding-top:78px;position:static}}.-cx-PRIVATE-SidebarLayout__contentWrapper__,.-cx-PRIVATE-SidebarLayout__navWrapper__{-webkit-box-flex:1;-webkit-flex:1 0 auto;-ms-flex:1 0 auto;flex:1 0 auto;margin:0 auto;position:relative;width:992px}@media screen and (min-width:991px){.-cx-PRIVATE-SidebarLayout__navWrapper__{height:100%}}@media screen and (max-width:990px){.-cx-PRIVATE-SidebarLayout__navWrapper__{-webkit-box-sizing:border-box;box-sizing:border-box;display:inline-block;height:auto;min-height:0;padding:0;width:100%}}.-cx-PRIVATE-SidebarLayout__nav__{float:left;height:100%;padding-right:0;pointer-events:initial;width:256px}@media screen and (max-width:990px){.-cx-PRIVATE-SidebarLayout__nav__{float:none;display:block;margin:0!important;background:0 0;border:0;width:100%}}.-cx-PRIVATE-SidebarLayout__contentWrapper__{background-color:#fff;border:1px solid #efefef;-webkit-box-sizing:border-box;box-sizing:border-box;padding:0 16px 20px}@media screen and (min-width:991px){.-cx-PRIVATE-SidebarLayout__contentWrapper__{border:1px solid #efefef;border-radius:3px}}@media screen and (max-width:990px){.-cx-PRIVATE-SidebarLayout__contentWrapper__{width:100%;-webkit-box-sizing:border-box;box-sizing:border-box}.-cx-PRIVATE-SidebarLayout__pageContent__ .-cx-PRIVATE-SidebarLayout__contentWrapper__{padding:0 10px}}.-cx-PRIVATE-SidebarLayout__pageContent__{color:#262626;margin-left:205px;padding:30px 50px}@media screen and (max-width:990px){.-cx-PRIVATE-SidebarLayout__pageContent__{margin-left:0;margin-right:0;padding:20px 0}}.-cx-PRIVATE-SidebarLayout__pageContent__>:first-child{margin-top:0}.-cx-PRIVATE-SidebarLayout__pageContent__ a{color:#003569}.-cx-PRIVATE-SidebarLayout__pageContent__ h1{font-size:32px;font-weight:400;margin-bottom:20px;margin-top:28px}.-cx-PRIVATE-SidebarLayout__pageContent__ h2{font-size:24px;font-weight:400;margin-bottom:12px;margin-top:28px}.-cx-PRIVATE-SidebarLayout__pageContent__ h3{font-weight:600;margin-bottom:12px;margin-top:28px}.-cx-PRIVATE-SidebarLayout__pageContent__ li{padding-left:8px}.-cx-PRIVATE-SidebarLayout__pageContent__ li:not(:first-child){margin-top:8px}.-cx-PRIVATE-SidebarLayout__pageContent__ pre{white-space:pre-wrap}.-cx-PRIVATE-Navigation__header__{color:#999;font-size:16px;font-weight:initial;margin:0;padding:16px;text-transform:uppercase}@media screen and (max-width:990px){.-cx-PRIVATE-Navigation__header__:first-child{display:block}.-cx-PRIVATE-Navigation__header__:not(:first-child){display:none}.-cx-PRIVATE-Navigation__header__ i{float:left;width:22px;height:18px;margin-right:8px;margin-left:10px;background:url(/static/images/glyphs/disclosure-down@2x.png/9ae8409fbb3a.png) no-repeat center;background-size:14px 14px}.-cx-PRIVATE-SidebarLayout__content__.active .-cx-PRIVATE-Navigation__header__ i{-webkit-transform:rotate(180deg);transform:rotate(180deg)}}.-cx-PRIVATE-Navigation__navLink__,.-cx-PRIVATE-Navigation__navLink__:active,.-cx-PRIVATE-Navigation__navLink__:hover,.-cx-PRIVATE-Navigation__navLink__:visited{border-left:2px solid transparent;-webkit-box-sizing:border-box;box-sizing:border-box;color:#262626;font-size:16px;display:block;padding:16px 16px 16px 30px;width:100%}.-cx-PRIVATE-Navigation__navLink__:hover{border-left-color:#dbdbdb}.-cx-PRIVATE-Navigation__active__ .-cx-PRIVATE-Navigation__navLink__{border-left-color:#262626;font-weight:600}
        .-cx-PRIVATE-Footer__root__{font-size:12px;height:77px;}.-cx-PRIVATE-Footer__copyright__{color: #ffffff;display:inline-block;float:right;font-weight:600;margin-top:20px;text-transform:uppercase}  .-cx-PRIVATE-Footer__nav__{display:inline-block}@media screen and (max-width:990px){.-cx-PRIVATE-Footer__copyright__{text-align:center;width:100%}}  .-cx-PRIVATE-Footer__navItems__{margin:20px 0;padding:0;text-align:center}  .-cx-PRIVATE-Footer__navItems__ li{display:inline-block;list-style:none}  .-cx-PRIVATE-Footer__navItems__ li:not(:first-child){margin-left:15px}  .-cx-PRIVATE-Footer__navItems__ a,.-cx-PRIVATE-Footer__navItems__ a:active,.-cx-PRIVATE-Footer__navItems__ a:focus,.-cx-PRIVATE-Footer__navItems__ a:hover,.-cx-PRIVATE-Footer__navItems__ a:visited{color: #ffffff;font-weight:600;text-transform:uppercase}
        .-cx-PRIVATE-Footer__wrapper__{margin-left:auto;margin-right:auto;max-width:1026px;padding:0 20px}.-cx-PRIVATE-ErrorPage__errorContainer__{text-align:center}@media (max-width:990px){.-cx-PRIVATE-ErrorPage__errorContainer__{padding:100px 40px 0}}.-cx-PRIVATE-ErrorPage__errorContainer__ a,.-cx-PRIVATE-ErrorPage__errorContainer__ a:visited{color: #ffffff
                                                                                                                                                                                                                                                             }  .-cx-PRIVATE-Linkshim__followLink__{background-color:#fff;color:#3897f0;border:1px solid #3897f0;border-radius:3px;display:inline-block;-webkit-box-sizing:border-box;box-sizing:border-box;text-align:center;padding:8px;font:inherit;font-weight:700;width:90%}@media (min-width:736px){.-cx-PRIVATE-Linkshim__followLink__{width:10%}}  .-cx-PRIVATE-Linkshim__followLink__:active{opacity:.5}  .-cx-PRIVATE-Linkshim__followLink__:focus{color:#1372cc;border:1px solid #1372cc}  .-cx-PRIVATE-GatedContentPage__userAvatarContainer__{height:70px;text-align:center}  .-cx-PRIVATE-GatedContentPage__userAvatar__{border-radius:50%;height:50%;width:auto}


    </style>

    <script type="text/javascript">
   function perfil(){window.location.href = "<?=  $user_sobrenome  ?>";}
    function home(){window.location.href = "@?s=<?= $idioma[509] ?>";}
    function notifica(){window.location.href = "@?s=notifica";}
    function menssag(){window.location.href = "chato";}
    function Edit(){window.location.href = "Edit?sk=<?= $idioma[493] ?>";}
    </script>

<script type="text/javascript" src="<?= ARQUIVO_JS_HOST4  ?><!--"></script>
    <title>gf</title>
<script type="text/javascript" src="<?= ARQUIVO_JS_HOST3  ?>"></script>
<script type="text/javascript" src="<?= ARQUIVO_JS_HOST5  ?>"></script>
<script type="text/javascript" src="<?= ARQUIVO_JS_HOST  ?>"></script>
<script type="text/javascript" src="<?= ARQUIVO_JQUERY0  ?>"></script>
<script type="application/javascript">
    document.addEventListener(`DOMContentLoaded`, function(){
        let icon_not = document.getElementsByClassName('notifs')[0],
            dp = document.getElementsByClassName('dp')[0],
            btn_not = document.getElementsByClassName('addnot')[0],
            id_user = document.getElementById('id_user'),
            total_not = document.getElementById('ctnots'),
            total_chat = document.getElementById('chatsms'),
            res = document.getElementById('res'),
            chatss = document.getElementById('chatss'),
            getpost = document.getElementById('getpost'),
            ress = document.getElementById('ress');

        icon_not.addEventListener('click', function(e){
            e.stopPropagation();
            dp.style.display = 'block';
            dp.style = 'transition: 1s cubic-bezier(.175, .885, .32, 1.275); display:block;'
        });

        document.addEventListener('click', function(){
            dp.style.display = 'none';
            dp.style = 'transition: 1s cubic-bezier(.175, .885, .32, 1.275); display:none;'
        });


        btn_not.addEventListener('click', function(){
            xhr.get('api/requests.php?acao=addnot&idu='+id_user.value, function(res){
                alert(res);
            });
        });

        window.setInterval(function(){
            xhr.get('api/requests.php?acao=verificar', function(total){
                total_not.innerHTML = total;
            });
        }, 1000);

        window.setInterval(function(){
            xhr.get('api/requests.php?acao=getnots', function(nots){
                res.innerHTML = nots;
            });
        }, 1000);

        window.setInterval(function(){
            xhr.get('api/requests.php?acao=getnotss', function(nots){
                ress.innerHTML = nots;
            });
        }, 1000);

        res.addEventListener('click', function(e){
            var elemento = e.target;

            if(elemento.classList.contains('vis')){
                xhr.get('api/requests.php?acao=vis&idnot='+elemento.id, function(res){
                    myApp.alert(res,'notificação');
                });
            }
        });

        /*chat sms*/
        window.setInterval(function(){
            xhr.get('api/requests.php?acao=verificarsms', function(total){
                total_chat.innerHTML = total;
            });
        }, 1000);
        window.setInterval(function(){
            xhr.get('api/requests.php?acao=getchat', function(nots){
                chatss.innerHTML = nots;
            });
        }, 1000);
        window.setInterval(function(){
            xhr.get('api/requests.php?acao=getpost', function(nots){
                getpost.innerHTML = nots;
            });
        }, 1000);
        chatss.addEventListener('click', function(e){
            var elemento = e.target;

            if(elemento.classList.contains('vischat')){
                xhr.get('api/requests.php?acao=vischat&idnot='+elemento.id, function(chatss){
                    alert('Mensagen');
                });
            }
        });
    });
</script>
<script type="application/javascript">
    document.addEventListener(`DOMContentLoaded`, function(){
        let icon_config = document.getElementsByClassName('config_ico')[0],
            config = document.getElementsByClassName('config')[0];

        icon_config.addEventListener('click', function(e){
            e.stopPropagation();
            config.style.display = 'block';
            config.style = 'transition: 1s cubic-bezier(.175, .885, .32, 1.275); display:block;'
        });

        document.addEventListener('click', function(){
            config.style.display = 'none';
            config.style = 'transition: 1s cubic-bezier(.175, .885, .32, 1.275); display:none;'
        });
    });
</script>

</head>
<body  class="framework7-root">

