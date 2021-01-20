<?php
include("controlador.php");

//$de = password_hash($_GET['u'],PASSWORD_DEFAULT);
//password_needs_rehash($de,PASSWORD_DEFAULT);base64_decode($_GET['u']);$tipo = self::getConn()->query("SELECT * FROM tema_post_inicial WHERE de ");
//$tipo->execute([$idDaSessao, $idDaSessao]);
//$list = $tipo->fetch(PDO::FETCH_ASSOC);

$tipo = DB::getConn()->query("SELECT * FROM chat_us WHERE  `para` ");
$tipo->execute();
$list = $tipo->fetch(PDO::FETCH_ASSOC);

$id =  $list['para'];

$Exists = DB::getConn()->prepare("SELECT * FROM usuarios WHERE id='$id'");
$Exists->execute(array($id));
$saber = $Exists->fetch(PDO::FETCH_ASSOC);


?>
<style type="text/css">
    .m_contacts_table{
        width: 100%;
    }
    .m_contacts_table tr{
        cursor: pointer;
    }
    .m_contacts_table tr:hover{
        background: #f6f6f6;
        color: #000 ;
    }
    .m_contacts_table tr td{
        padding: 8px;
    }
    .m_contacts_table tr td p{
        font-size: 14px;
        margin: 0;
    }
    body{
        overflow: hidden;

    }
    .page-container {
        width: 90%;
        margin: auto;
         height: 100%;
        position: relative;
        background: rgba(255, 243, 238, 0);
        -webkit-transition: all 200ms ease;
        -moz-transition: all 200ms ease;
        -ms-transition: all 200ms ease;
        -o-transition: all 200ms ease;
        transition: all 200ms ease;
    }
    .loadchat{
        padding: 5px;
        max-width: 35%;
        transition: all 01s cubic-bezier(.175, .885, .32, 1.275);
        -moz-transition: 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        -o-transition: 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        -webkit-transition: 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        border-radius:10px;
        margin:-18px auto -10px auto;
        text-align: center;
        background: #ffffff;
        color: #1a1a1a;
        z-index: 999;
        border: 2px rgb(219, 219, 219);
        position: relative;
    }
    table.chatmenstting{
        padding: 7px;
        width: 20%;
        transition: all 01s cubic-bezier(.175, .885, .32, 1.275);
        -moz-transition: 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        -o-transition: 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        -webkit-transition: 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        margin: auto;
        z-index: 999;
        top: 30px;
        text-align: center;
        background: rgba(255, 255, 255, 0.47);
        color: #1a1a1a;
        border: 0 solid rgb(255, 255, 255);
        position: relative;
        -webkit-box-shadow:inset 0 0 2px rgba(0, 0, 0, 0.05);
        -moz-box-shadow:inset 0 0 2px rgba(0, 0, 0, 0.05);
        box-shadow:inset 0 0 2px rgba(0, 0, 0, 0.05);
    }
    .imgSmall{
        float:right;
        width:35px;
        height:35px;
        overflow:hidden;
        border-radius:485px/*sq cime*/ 870px/*dr cima*/ 485px/*dr baixo*/ 870px/*sq baixo*/ /
                 900px/*sq cime*/ 500px/*dr cima*/ 900px/*dr baixo*/ 500px;/*sq baixo*/

        transform: rotate(-13grad);
        background: #FFFFFF;
        border: 2px	solid rgb(242, 244, 247);
        -webkit-box-shadow:inset 0 0 1px rgba(0, 0, 0, 0.51);
        -moz-box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);
        box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);
        margin-top: 9px;
    }
    .imgSmall img{width:100%; height:100%;transform: rotate(13grad);}

    .imgSma{
        float:left;
        width:30px;
        height:30px;
        overflow:hidden;
        border-radius:485px/*sq cime*/ 870px/*dr cima*/ 485px/*dr baixo*/ 870px/*sq baixo*/ /
                 900px/*sq cime*/ 500px/*dr cima*/ 900px/*dr baixo*/ 500px;/*sq baixo*/
        margin-top: 9px;
        transform: rotate(-13grad);
        background: #FFFFFF;
        border: 2px	solid rgb(239, 239, 239);
        -webkit-box-shadow:inset 0 0 1px rgba(0, 0, 0, 0.51);
        -moz-box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);
        box-shadow:inset  0 0 1px rgba(0, 0, 0, 0.51);

    }
    .imgSma img{width:100%; height:100%;transform: rotate(13grad);}

    span{text-align: center; font-size: 12pt; color: #969696;}
    h3{text-align: center; font-size: 25px; color: #666;}
    a{color: #007fff; text-decoration: none;}

    div#box{
        background: url("img/__background.png") no-repeat center;
        background-size: cover;
        border-bottom: 1px solid rgba(221, 221, 221, 0.73);
        overflow: hidden;
        margin: auto;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        position: relative;
        bottom: 0;
        width:100%; height:85%}
    div.blo{
        margin:10px auto;
        position: revert;
        width: 100%;
        overflow-y: auto;
        min-height: 755px;
        max-height: 755px;
        padding-top: 30px;
        padding-right: 11px;
        clear: bottom;
        bottom: 0;
    }
    div#boxi{
        margin: auto;
        position: revert;
        width: 100%;
        overflow-y: auto;
        max-height: 780px;
        padding-bottom: 2px;
        clear: bottom;
        bottom: 0;
    }


    textarea.mchat{
        background: #e8eaed; margin: auto;
        width:88%;
        border: 2px solid #ffffff;
        height: auto;
        padding: 8px 10px 0;
        float: left;
        border-radius: 24px;
        font-size: 11pt;
    }
    input[type="submit"].chut {
        width:35px;
        height: 35px;
        float:right;
        padding:5px;
        margin:10px auto;
        border-radius: 15px;
        color: #3c414b;
        border:none;
        display: flex;
        background:linear-gradient(rgba(221, 225, 230, 0.22) 41%, rgba(198, 198, 198, 0.18)), url('assets/ico/papeli.png') no-repeat center;
        background-size: 70%;
        font-size: 11pt;
    }
    .status{
        position:absolute;
        right:8px;
        top:50%;
        width:12px;
        height:12px;
        margin-top:-6px;
        border-radius:50%;
        background:#666;
    }
    i.chat_img {
        background: url("assets/ico/_u.png") no-repeat center;
        position: relative;
        height: 25px;
        width: 25px;
        padding: 1.4em;

    }
    i.chat_ola{
        background: url("assets/ico/ola.png") no-repeat center;
        position: relative;
        height: 25px;
        width: 25px;
        padding: 1.4em;

    }
    i.chat_webcan{
        background: url("assets/ico/vfot.png") no-repeat center;
        background-size: 88%;
        position: relative;
        height: 25px;
        width: 25px;
        padding: 1.4em;

    }
    i.chat_mas{
        background: url("assets/ico/menupost.png") no-repeat center;
        position: relative;
        height: 25px;
        width: 25px;
        padding: 1.4em;

    }
    i.chat_emoj{
        background: url("assets/ico/Caixa.png") no-repeat center;
        background-size: 78%;
        position: relative;
        height: 27px;
        width: 27px;
        padding: 1.5em;

    }
    .navchat ul{padding-left: 50px}
    .status.off{background:#ccc;}
    .status.on{background:#090;}
    p#ipo{ margin: auto; width: 360px;}
    div#send{ margin: auto; }
    div#send input[name="image"]{width: 30px; height: 35px; border: none; border-radius: 3px; font-size: 16px; background: #007fff; color: #FFF; cursor: pointer;}
     div#send input[name="send"]{width: 35px; height: 35px; border: none; border-radius: 3px; font-size: 16px; background: #007fff; color: #FFF; cursor: pointer;}
</style>
<script>
    function selec_us(chatU, nome){
         var track_load = 0; //total loaded record group(s)
         var loading = false; //to prevents multipal ajax loads
         var total_groups = <?php echo (new chat)->getTotalNumberchatCount(); ?>// //total record group(s)
            $.ajax({
                type:'post',
                url:'controlador.php',
                cache:false,
                data:{'chatgroup': track_load,'chatU': chatU},

                beforeSend: function(){
                    $('.bloo').hide();
                },
                success:function(data){
                    $('.blo').append(data);
                    $('.blo').animate({scrollTop: $('.blo')[0].scrollHeight});
                    $('.loadchat').html('<?php echo '<span>' . $idioma[513] . '</span>' ?>'); //hide loading image once data is received
                    $('.abc').html(
                        '<ul style="padding-left: 50px" class="nav navbar-nav">\n' +
                        '<li class="active"><a href="#"><i class="chat_ola"></i></a></li>\n' +
                        '<li><a href="#"><i class="chat_img"></i></a></li>\n' +
                        '<li><a href="#"><i class="chat_webcan"></i></a></li>\n' +
                        '<li><a href="#"><i class="chat_emoj"></i> Caixa</a></li>\n' +
                        '<li><a href="#"><i class="chat_mas"></i></a></li>\n' +
                        '</ul>'+
                        ' <label id="pagar" for="mensagem_txt"></label>\n'+
                        ' <textarea dir="auto" onkeyup="textAreaAdjusto(this, 250)" maxlength="1500" id="mensagem_txt" class="mchat" name="mensagem" placeholder="Write a message.. '+nome+'"></textarea>\n'+
                        ' <input type="submit" hidden id="de_txt" value="<?= $idDaSessao ?>">\n'+
                        ' <input type="submit" hidden id="para_txt" value="'+chatU+'">\n'+
                        ' <input type="submit"  onclick="chattex()" value=" " id="chatev" class="chut"/>\n'+
                         '</div>'
                    );
                },

                error:function(err){
                    alert(err);
                }

            });
            $.ajax({
                type:'GET',
                url:'api/KV/chatrequest.php',
                cache:       false,
                data:{'req':'chat_selec','selec_us':chatU},
                beforeSend: function(){
                    $('.chatmenstting').hide();
                },
                success:function(data){
                    $('#ipo').append(data);
                },
                error:function(err){
                    alert(err);
                }

            });


            function loadData()
            {
                if (track_load <= total_groups && loading === false) //there's more data to load
                {
                    loading = true; //prevent further ajax loading
                    $('.animation-load').html('<svg width="50px" height="50px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><circle cx="50" cy="50" r="40" stroke="#676d76" fill="none" stroke-width="6" stroke-linecap="round"><animate attributeName="stroke-dashoffset" dur="1.5s" repeatCount="indefinite" from="0" to="502"></animate><animate attributeName="stroke-dasharray" dur="1.5s" repeatCount="indefinite" values="150.6 100.4;1 250;150.6 100.4"></animate></circle></svg>');
                    //load data from the server using a HTTP POST request
                    $.post('controlador.php', {'chatgroup': track_load,'chatU': chatU}, function (data) {
                         $(".blo").append(data); //append received data into the element
                        // //hide loading image
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
                    $('.loadchat').html('<?php echo '<span>' . $idioma[491] . '<svg width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><circle cx="50" cy="50" r="40" stroke="#676d76" fill="none" stroke-width="6" stroke-linecap="round"><animate attributeName="stroke-dashoffset" dur="1.5s" repeatCount="indefinite" from="0" to="502"></animate><animate attributeName="stroke-dasharray" dur="1.5s" repeatCount="indefinite" values="150.6 100.4;1 250;150.6 100.4"></animate></circle></svg></span>' ?>');
                }
            }
            $(".loadchat").click(function (e) { //user clicks on button
                loadData();
            });




    }

    function chattex(){
        const mensagem = document.getElementById("mensagem_txt").value;
        const para = document.getElementById("para_txt").value;
        const de = document.getElementById("de_txt").value;
        $.ajax({
            type:'GET',
            url:'api/KV/chatrequest.php',
            cache: false,
            data:{'req':'chat_code','mensagem_txt':mensagem,'de_txt':de,'para_txt':para},
            beforeSend: function(){
                $('.blo').show();
            },
            success:function(data){
                $('.blo').append(data);
                $('#notbi').html('<p class=\'alertok\'><audio autoplay="autoplay"><source src="media/mp3/bio.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="media/mp3/bio.mp3" /></audio></p>');
            },
            error:function(err){
                alert(err);
            }

        });
    }

    $('#chatev').click(function(){
        chattex();
    });
    $(document).ready(function(){
        $("textarea").bind("input keyup past", function () {
            var maximo = 500;
            var disponivel = maximo - $(this).val().length;
            if (disponivel < 0){
                var texto = $(this).val().substr(0,maximo);
                $(this).val(texto);
                disponivel = 0;
            }
            $(".contagem").text(disponivel);
            $('#circle').css({
                width: disponivel,
            });
        });
    });

</script>
<script>
    $(document).ready(function () {
        $(":text").keyup(function () {
            $("#COMANDA").text('Digintando..');
        }).focus(function () {
            $(this).css("background","#ddd")
            $("#COMANDA").text("Atenção: Ao escrever ou Inserindo dados");
        }).blur(function () {
            $(this).css("background","#fff")
            $("#COMANDA").text("");
        });
    });
</script>
<script>
        function chat(para){
            $.ajax({
                type:'GET',
                url:'/api/KV/chatrequest.php',
                cache:       false,
                data:{'req':'chat_user','para_txt':para},
                beforeSend: function(){
                    $('.para_txt').show();
                },
                success:function(data){
                    if (data) {
                        $('.para_txt').append(data);
                        $('#notbi').html('<p class=\'alertok\'><audio autoplay="autoplay"><source src="media/mp3/bio.mp3" type="audio/mpeg" /><embed hidden="true" autostart="true" loop="false" src="media/mp3/bio.mp3" /></audio></p>');
                    }else{
                        $('.para_txt').html(data);
                    }
                },
                error:function(err){
                    alert(err);
                }

            });
        }

        $('#chat').click(function(){
            chat();
        });
        // on click on any user in contacts do this
        $('#m_contacts').on("click",".mC_userLink",function(){
            $('.mCol2_title').attr("data-user",$(this).attr('data-muid'));
            mUserProfile($(this).attr('data-muid'),"click");
            mFetchMsgs($(this).attr('data-muid'),"click");
        });

    </script>
<script>
    document.addEventListener(`DOMContentLoaded`, function(){
        let icon_not = document.getElementsByClassName('notifs')[0],
            id_user = document.getElementById('id_user'),
            total_chat = document.getElementById('chatsms'),
            chat = document.getElementById('m_contacts_friends');


        /*chat sms*/
        window.setInterval(function(){
            xhr.get('api/requests.php?acao=verificarsms', function(total){
                total_chat.innerHTML = total;
            });
        }, 1000);

        window.setInterval(function(){
            xhr.get('api/KV/chatrequest.php?req=amigos', function(not){
                chat.innerHTML = not;
            });
        }, 1000);


    });
</script>

<body class="framework7-root" style="">
 


            <?php
            (new Menu)->menu_principal($idDaSessao, $idioma, $o_foto, $o_sobrenome);
            ?>


                            <section class="page-container">
                                <div class="list-block"  style="margin-top: 30px;width:22%; float: left">
                                    <p class="mCol2_title" style="border-top: 1px solid #d0d4d8;">friends</p>
                                    <ul id="m_contacts_friends" style=" max-height:670px; padding-bottom: 5px;  overflow-y:hidden; " class="user-amigo" >
                                        <li class="ami-load" ><span><?php echo $idioma[486] ?></span></li>
                                    </ul>
                                </div>
                                <div class="pag">
                                    <div id="box">
                                        <!--        <div id="boxi">-->
                                        <!--            <div id="notbi"></div>-->
                                        <!--        </div>-->

                                        <!--        <div id="ipo"></div>-->
                                        <!--        <table class="chatmenstting" >-->
                                        <!--            <tr>-->
                                        <!--                <td width="35"><div class="imgSma"><img src="usuarios/--><?//= $idDaSessao ?><!--/eu/--><?//=  user_img($user_foto,$idDaSessao) ?><!--"/></div></td>-->
                                        <!--                <td><span>--><?//= $saber["nome"] ?><!--</span>&nbsp;</td>-->
                                        <!--                <td style="border-right:1px solid #DDDDDD"><span><i class="chatcall"></i></span></td>-->
                                        <!--                <td><span><i class="chatcallvideo"></i></span></td>-->
                                        <!--            </tr>-->
                                        <!--        </table>-->
                                        <div class="lo"></div>
                                        <div  class="blo" id="display"></div>
                                    </div>

                                    <div id="send">
                                        <div  class="loadchat" ><span >erere</span></div>

                                        <!--        <label id="pagar" for="mensagem_txt"></label>-->
                                        <!--        <textarea dir="auto" onkeyup="textAreaAdjusto(this, 390)" maxlength="1500" id="mensagem_txt" class="mchat" name="mensagem" placeholder="Write a message.."></textarea>-->
                                        <!--        <input type="submit"  hidden id="de_txt" value="--><?//= $idDaSessao ?><!--">-->
                                        <!--        <input type="submit" hidden id="para_txt" value="--><?//= $uid ?><!--" >-->
                                        <!--        <input type="submit"   onclick="chattex()" value=" " id="chatev" class="chut"/>-->

                                        <div class="abc"></div>
<!--                                        <div class="toolbar" >-->
<!--                                            <div class="toolbar-inner">-->
<!--                                                <a href="#tab1" class="link tab-link" style="margin-top: 13px;">-->
<!--                                                    <img src="images/gotmessages.png" width="32px" height="32px">-->
<!--                                                </a>-->
<!--                                                <a href="#tab2" class="link tab-link" style="line-height: 60px; height: 70px;">-->
<!--                                                    <img src="images/camera_button.png" width="50px" height="50px">-->
<!--                                                </a>-->
<!--                                                <a style="opacity: 0;" href="#tab3" class="link tab-link">-->
<!--                                                    <img src="images/camera_button.png" width="50px" height="50px">-->
<!--                                                </a>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                    </div>
                                </div>



            </section>
<!-- Path to Framework7 Library JS-->
<script type="text/javascript" src="js/framework7.min.js"></script>
<!-- Path to your app js-->
<script type="text/javascript" src="js/my-app.js"></script>

</body>

<script type="text/javascript">
    // on click on any user in contacts do this
    $('#m_contacts').on("click",".mC_userLink",function(){
        $('.mCol2_title').attr("data-user",$(this).attr('data-muid'));
        selec_us($(this).attr('data-muid'),"click");
        mFetchMsgs($(this).attr('data-muid'),"click");
    });

</script>