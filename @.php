<?php
include("controlador.php");
Menu::menu_principal($idDaSessao, $idioma, user_img($o_foto,$idDaSessao), $user_sobrenome);
 ?>
<div class="wrapper">

        <?php
        $sk = filter_var(htmlentities($_GET['s']), FILTER_SANITIZE_STRING);
        switch ($sk) {
            case $idioma[509]: ?>
                <div class="header2 header-filter">
                    <div class="container">
                        <div class="row">
                            <?=  Outros::setup($idDaSessao,$user_foto);?>
                            <center>

                                <div class="no-span" style="font-size: 9.5px;">

                                    <span>R E C E N T &nbsp; U P D A T E S</span>
                                </div>

                            </center>
                            <?php
                            include("storial.php");
                            ?>
                        </div>
                    </div>
                </div>

                <div class="main">
                <section id="main-container1">
                    <div class="list-block"  style="margin-top: 7px;width:18%; float: left">
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
                    <aside id='sidebar' >



                <script type="text/javascript">
        $(function(){

            function fetch(elem){
                var username = $('.user_info').data('grpname');
                var grp = $('.user_info').data('grp');
                $.ajax({
                    url: DIR+"/ajaxify/grp_sections/"+elem+".php",
                    method: "GET",
                    cache: false,
                    data: {grp: grp},
                    beforeSend: function(e){
                        $('.hmm > .spinner').fadeIn('fast');
                    },
                    success: function(data){
                        var link = $('.inst_grp_nav');
                        link.removeClass('pro_nav_active');
                        $(".inst_grp_nav[href='"+ elem +"']").addClass('pro_nav_active');
                        $('.hmm > .spinner').fadeOut('fast');
                        $('.hmm').html(data).hide().fadeIn(100);
                        // $('html, body').animate({scrollTop: 380}, "slow");
                    }
                });
            }

            var get = checkGET("ask");

            if (get.has) {
                fetch(get.value);
            } else {
                fetch("grp_posts");
            }

            //Set it Draggable
            $('.pro_crop_tool').draggable({containment: ".crop_img"});

            $('a[href="grp_add_members"]').on('click', function(e){
                e.preventDefault();
                $('.a_m_input > input[type="text"]').focus();
            });

        });
    </script>
                        <table id="sidebartabela">
                            <tr>
                                <td width="50" rowspan="1">
                                    <figure class="foto">
                                        <img src="usuarios/<?php echo $idExtrangeiro  ?>/eu/<?php echo user_img($user_foto,$idExtrangeiro) ?>">
                                    </figure>
                                </td>
                                <td colspan="7">
                                    <a style="margin-left: 10px" href="/"><?=  ucwords(strtolower(trim($user_sobrenome))); ?></a>
                                    <p href="/"><?=  ucwords(strtolower(trim(Outros::nomecortar(Outros::tratarCaracter($nome,2), 22)))); ?></p>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8">
                                    <?= (new mutual)->UserSuggestions($idDaSessao,$idioma) ?>
                                </td>
                            </tr>

                        </table>
                        <footer class="footer-wrapper">
                            <a>

                                <?=  $idioma[492] ?>:&nbsp;<?php $edioma->mostarlink();?>

                            </a>
                        </footer>
                    </aside>
                    <div id="main-article1">
                        <script type="text/javascript">
                            $(document).ready(function () {
                                var track_load = 0; //total loaded record group(s)
                                var loading  = false; //to prevents multipal ajax loads
                                var total_groups = <?php echo (new DAO)->getTotalNumberOfRecordsCount(); ?> //total record group(s)
                                    // Load data on first load...
                                    $.post('controlador.php',{'group_no': track_load}, function(data){
                                        track_load++;
                                        $('.user-post-display-body-main-container').html(data);
                                        $('.animation-load').show();
                                    });

                                // Scroll to load data
                                $(document).scroll('scroll', function () {
                                    if ($(document).scrollTop() >= $('#display_posts').offset().top + $('#display_posts').outerHeight() - document.innerHeight) {
                                        loadData();
                                    }
                                });
                                function loadData()
                                {
                                    if (track_load <= total_groups && loading === false) //there's more data to load
                                    {
                                        loading = true; //prevent further ajax loading
                                        $('.animation-load').html('<svg width="50px" height="50px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><circle cx="50" cy="50" r="40" stroke="#676d76" fill="none" stroke-width="6" stroke-linecap="round"><animate attributeName="stroke-dashoffset" dur="1.5s" repeatCount="indefinite" from="0" to="502"></animate><animate attributeName="stroke-dasharray" dur="1.5s" repeatCount="indefinite" values="150.6 100.4;1 250;150.6 100.4"></animate></circle></svg>');
                                        //load data from the server using a HTTP POST request
                                        $.post('controlador.php',{'group_no': track_load}, function(data){
                                            $(".user-post-display-body-main-container").append(data); //append received data into the element
                                            //hide loading image
                                            $('.animation-load').html('Ver mais...'); //hide loading image once data is received
                                            track_load++; //loaded group increment
                                            loading = false;
                                        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                                            alert(thrownError); //alert with HTTP error
                                            $('.animation-load').hide(); //hide loading image


                                            loading = true;
                                        });
                                    }
                                    if(track_load >= total_groups-1)
                                    {//reached end of the page yet? disable load button
                                        $('.animation-load').html('Não mas post');
                                    }
                                }
                                $(".animation-load").click(function (e) { //user clicks on button
                                    loadData();
                                });
                            });

                        </script>

                        <div id="display_posts " class="user-post-display-body-main-container" >
                            <?php  // echo $dao->getData(0); ?>
                        </div>

                        <?php if ($list_amigos['num']>0):?>
                            <div class="animation-load" ><span><?php echo $idioma[486] ?></span></div>
                        <?php  else: ?>
                            <nav id="fg">

                                <ul>
                                    <li>
                                        <div class="animationLoadinga">
                                            <div id="fourr"></div>
                                            <div id="fivee"></div>
                                            <div id="sixx"></div>
                                            <br><br><br><br><br><br><br>
                                            <div id="containerr">
                                                <div id="onee"></div>
                                                <div id="twoo"></div>
                                                <div id="threee"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="animationLoadingb">
                                            <div id="fourr"></div>
                                            <div id="fivee"></div>
                                            <div id="sixx"></div>
                                            <br><br><br><br><br>
                                            <div id="containerr">
                                                <div id="onee"></div>
                                                <div id="twoo"></div>
                                                <div id="threee"></div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </nav>
                            <br>
                            <div class="animat" ><span><?php echo $idioma[486] ?></span></div>
                        <?php endif;  ?>
                    </div>
                </section>
                <div id="sliderRegular"  hidden></div>
                <div id="sliderDouble"  hidden="hidden"></div>
                </div>
                <?php
                break;
            case 'notifica':
                include("notificacoes.php");
                break;
            default:
                include("pagina/404.php");
                break;
        }
        ?>




    <?php include('footer.php'); ?>

    <script type="text/javascript">

        $().ready(function(){
            // the body of this function is in assets/material-kit.js
            materialKit.initSliders();
            window_width = $(window).width();

            if (window_width >= 592){
                big_image = $('.wrapper > .header2');

                $(window).on('scroll', materialKitDemo.checkScrollForParallax);
            }

        });
    </script>
</div>

</body>


</html>
 





