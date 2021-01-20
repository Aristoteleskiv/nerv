<?php
include("controlador.php");
(new Menu)->menu_principal($idDaSessao, $idioma, $o_foto, $o_sobrenome);
?>
<?php
$id = $_GET['username'];

$Exists = DB::getConn()->prepare("SELECT * FROM usuarios WHERE id='$id'");
$Exists->execute(array($id));
$saber = $Exists->fetch(PDO::FETCH_ASSOC);


?>
<style type="text/css">
    html{
        font-family: Ubuntu, sans-serif;
        -webkit-animation: fadein 0s;
        -moz-animation: fadein 0s;
        -ms-animation: fadein 0s;
        -o-animation: fadein 0s;
        animation: fadein 0s;
    }

    .imgSmall{
        float:left;
        width:22px;
        height:22px;
        overflow:hidden;
        border-radius:95%;
        background: #FFFFFF;
        border: 1px	solid rgb(255, 255, 255);
        -webkit-box-shadow:inset 0 0 1px rgba(0, 0, 0, 0.51);
        -moz-box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);
        box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);
        margin-top: 9px;
    }
    .imgSmall img{width:100%; height:100%;}

    .imgSma{
        float:left;
        width:35px;
        height:35px;
        overflow:hidden;
        border-radius:95%;
        background: #FFFFFF;
        border: 1px	solid rgb(255, 255, 255);
        -webkit-box-shadow:inset 0 0 1px rgba(0, 0, 0, 0.51);
        -moz-box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);
        box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);

    }
    .imgSma img{width:100%; height:100%;}

    span{text-align: center; font-size: 16px; color: #007fff;}
    h3{text-align: center; font-size: 25px; color: #666;}
    a{color: #007fff; text-decoration: none;}
    div#box{background: #efefef; border-radius: 20px; padding: 3px; overflow: hidden; clear: bottom; margin:10px auto; width: 100%; height: auto}
    div#boxi{
        margin: auto;  width: 100%;
        min-height: 50%;
        height: 62%;
        overflow: hidden;
        padding-bottom: 10px;
        left: 0;
        right: 0;
        bottom: 0;
    }
    textarea.mchat{
        background: #efefef; margin: auto;  width:75%;
        height: auto;
        padding: 8px 10px 0;
        float: left;
        border-radius: 20px;
        font-size: 11pt;
    }

    div#send{ margin: auto; }
    div#send input[name="image"]{width: 30px; height: 35px; border: none; border-radius: 3px; font-size: 16px; background: #007fff; color: #FFF; cursor: pointer;}
    div#send input[name="send"]{width: 35px; height: 35px; border: none; border-radius: 3px; font-size: 16px; background: #007fff; color: #FFF; cursor: pointer;}
</style>
 
<script type="text/javascript">
    $(document).ready(function () {
        var chatt = <?= $id ?>; //total loaded record group(s)
        var track_load = 0; //total loaded record group(s)
        var loading = false; //to prevents multipal ajax loads
        var total_groups = <?php echo (new chat)->getTotalNumberchatCount(); ?> //total record group(s)
            // Load data on first load...
            $.post('controlador.php', {'chatgroup': track_load,'username': chatt}, function (data) {
                track_load++;
                $('.content-blo').html(data);
                $('.loadchat').show();
            });

        function loadData()
        {
            if (track_load <= total_groups && loading === false) //there's more data to load
            {
                loading = true; //prevent further ajax loading
                $('.animation-load').html('<svg width="50px" height="50px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><circle cx="50" cy="50" r="40" stroke="#676d76" fill="none" stroke-width="6" stroke-linecap="round"><animate attributeName="stroke-dashoffset" dur="1.5s" repeatCount="indefinite" from="0" to="502"></animate><animate attributeName="stroke-dasharray" dur="1.5s" repeatCount="indefinite" values="150.6 100.4;1 250;150.6 100.4"></animate></circle></svg>');
                //load data from the server using a HTTP POST request
                $.post('controlador.php', {'chatgroup': track_load,'username': chatt}, function (data) {
                    $(".content-blo").append(data); //append received data into the element
                    //hide loading image
                    $('.loadchat').html('<?php echo '<span>' . $idioma[513] . '</span>' ?>'); //hide loading image once data is received
                    track_load++; //loaded group increment
                    loading = false;
                }).fail(function (xhr, ajaxOptions, thrownError) { //any errors?

                    alert(thrownError); //alert with HTTP error
                    $('.loadchat').hide();//hide loading image

                    loading = true;
                });
            }
            if (track_load >= total_groups - 1)
            {//reached end of the page yet? disable load button
                $('.loadchat').html('<?php echo '<span>' . $idioma[491] . '</span>' ?>');
            }
        }
        $(".loadchat").click(function (e) { //user clicks on button
            loadData();
        });

    });
</script>
<div class="list-block"  style="margin-top: -10px;width:18%; float: left">
    <!-- div class="content-block" style="color: #000;">
                      <center><p class="">Add some friends to receive snaps!</p></center>
                    </div> -->
    <script type="text/javascript">
        $(document).ready(function() {
            var track_load = 0; //total loaded record group(s)
            var loading  = false; //to prevents multipal ajax loads
            var total_am = <?php echo $am->Contamisade(); ?> //total record group(s)
                // Load data on first load...
                $.post('controlador.php',{'group_am': track_load}, function(data){
                    track_load++;
                    $('.user-amigo').append(data);
                    $('.ami-load').show();
                });

            function loadami()
            {
                if (track_load <= total_am) {
                    if (loading === false) {
                        loading = true; //prevent further ajax loading
                        $('.ami-load').html('<div class="animationLoading1"><div id="containere"><div id="one1"></div><div id="two2"></div><div id="three3"></div></div></div>');
                        //load data from the server using a HTTP POST request
                        $.post('controlador.php', {'group_am': track_load}, function (data) {
                            $(".user-amigo").append(data); //append received data into the element
                            //hide loading image
                            $('.ami-load').html('Ver mais amigos...'); //hide loading image once data is received
                            track_load++; //loaded group increment
                            loading = false;
                        }).fail(function (xhr, ajaxOptions, thrownError) { //any errors?

                            alert(thrownError); //alert with HTTP error
                            $('.ami-load').hide(); //hide loading image
                            loading = false;
                        });
                    }
                }
                if(track_load >= total_am -1)
                {//reached end of the page yet? disable load button
                    $('.ami-load').html('Não mas amigos para mostrar');
                }
            }
            $(".ami-load").click(function (e) { //user clicks on button
                loadami();
            });
        });
    </script>
    <ul id="display_posts" style=" max-height:500px; padding-bottom: 5px;  overflow-y:auto; " class="user-amigo" >
    </ul>
    <ul>
        <li class="ami-load" ><span><?php echo $idioma[486] ?></span></li>
    </ul>

</div>
<div class="pages">
    <!-- Page, data-page contains page name-->
    <div data-page="about" class="page">
        <!-- Scrollable page content-->

        <div class="page-content">


            <div class="content-block">
                <table style="margin: auto 25% auto">
                    <tr>
                        <td><div class="imgSma"><img src="usuarios/<?= $saber['id'] ?>/eu/<?=  user_img($saber['foto'],$saber['id']) ?>"/></div></td>
                        <td><span>&nbsp;<?= $saber["nome"] ?></span></td>
                    </tr>
                </table>
            </div>


            <div id="boxi">
                <div class="list-block">
                    <div class="content-blo"></div>
                    <div class="loadchat"  hidden><span><?php echo $idioma[513] ?></span></div>
                    <span id="notbi"></span>
                </div>
            </div>
            <div id="box">
                <div id="send">
                    <label for="mensagem_txt"></label>
                    <textarea dir="auto" onkeyup="textAreaAdjusto(this, 10)" maxlength="1500" id="mensagem_txt" class="mchat" name="mensagem" placeholder="Write a message.."></textarea>
                    <input type="submit"  hidden id="de_txt" value="<?= $idDaSessao ?>">
                    <input type="submit" hidden id="para_txt" value="<?= $id ?>">
                    <a href="image.php?id=<?php echo $id; ?>"><input value="Imagem" type="button" name="image"></a>&nbsp;&nbsp;&nbsp;
                    <input type="submit" class="bio_btn2" onclick="chattex()" value="tá" id="chatenv" />
                </div>
            </div>
        </div>
    </div>

</div>
<footer class="_8Rna9 _3Laht" role="contentinfo"><div class="iseBh " style="max-width: 1000px; clear: both;position: relative; bottom: 0">
        <nav class="uxKLF">
            <ul class="ixdEe">
                <li class="K5OFK">
                    <a class="l93RR" href="" rel="nofollow noopener noreferrer" target="_blank"> Sobre nós</a></li>
                <li class="K5OFK"><a class="l93RR" href="">Suporte</a></li>
                <li class="K5OFK"><a class="l93RR" href="<?= KV7_PATH ?>developer/">API</a></li>
                <li class="K5OFK"><a class="l93RR" href="<?= KV7_PATH ?>about/jobs/">Carreiras</a></li>
                <li class="K5OFK"><a class="l93RR" href="<?= KV7_PATH ?>legal/privacy/">Privacidade</a></li>
                <li class="K5OFK"><a class="l93RR _vfM2" href="<?= KV7_PATH ?>legal/terms/">Termos</a></li>
                <li class="K5OFK"><a class="l93RR" href="https:<?= KV7_PATH ?>explore/locations/">Diretório</a></li>
                <li class="K5OFK"><span class="_3G4x7  l93RR"> <?= $idioma[492];?><select aria-label="Trocar idioma de exibição" class="hztqj"><?php $edioma->idiomas();?></select></span></li>
            </ul>
        </nav>
        <span class="DINPA">© 2019 <?= NOME_SISTEMA;?> inc</span>
    </div>
</footer>