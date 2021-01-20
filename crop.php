<?php
include('includes/neutral.php');
(new Menu)->menu_principal($idDaSessao, $idioma, $o_foto, $o_sobrenome);

?>
    <script src="php/js/jquery.min.js"></script>
    <script src="php/js/jquery.Jcrop.js"></script>
    <link rel="stylesheet" href="php/css/demos.css" type="text/css" />
    <link rel="stylesheet" href="php/css/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript" src="php/js/script.js"></script>
<style>
    .fcrop{
        width:100px;
        height:100px;
        overflow:hidden;
        border-radius: 100%;
        margin: 10px auto;
        border: 2px dashed #79c3fa;
    }.fcrop img{
         width:100%;
         height:100%;
     }
    .cropt{
        width:auto;
        height:auto;
        margin: auto;
        border-radius: 5px;
        border: 1px dashed #d2d3d6;
        display: block;
    }
    .cropt img{
        width:auto;
        height:auto;
    }
    #buttoncrop{
        background: #efefef;
        border-radius: 8px;
        border: 1px solid rgba(121, 121, 127, 0.64);
        color: #606060;
        width: 70px;
        padding: 3px;
        margin: auto;
    }
</style>
<script type="text/javascript">
    /**
     * Created by PhpStorm.
     * User: Aristoteles kv
     * Date: 02/12/2017
     * Time: 22:42
     */
    jQuery(function($){
        var jcrop_api, boundx, boundy;
        $('#cropbox').Jcrop({
            aspectRatio: 1,
            onChange: updatePreview,
            onSelect: updatePreview,
            onSelect: updateCoords
        },function(){
            // Usando o API que faz o  get do tamanho real da imagem
            var bounds = this.getBounds();
            boundx = bounds[0];
            boundy = bounds[1];
            // Armazenando o API na variave jcrop_api
            jcrop_api = this;
        });
        function updatePreview(c)
        {
            if (parseInt(c.w) > 0)
            {
                var rx = 100 / c.w;
                var ry = 100 / c.h;

                $('#preview').css({
                    width: Math.round(rx * boundx) + 'px',
                    height: Math.round(ry * boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });
            }
        };
        function updateCoords(c){
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        };

    });
    function checkCoords()
    {
        if (parseInt($('#w').val())) return true;
        alert('Favor seleciona o crop na regiao e pressione o submit.');
        return false;
    };

</script>
<div id="content-crop">
    <div id="cocrop">
        <div class="fcrop">
            <img src="usuarios/<?php echo $idDaSessao  ?>/eu/<?php echo $user_foto ?>" id="preview" alt="Preview" class="jcrop-preview" />
        </div>
        <form name="crop" method="post" enctype="multipart/form-data" action="php/crop.php" onsubmit="return checkCoords();">
            <input type="hidden" name="imagem" value="<?php echo $user_foto ?>" />
            <input type="hidden" name="usuario" value="<?php echo $idDaSessao  ?>" />
            <input type="hidden" name="x" id="x" />
            <input type="hidden" name="y" id="y" />
            <input type="hidden" name="w" id="w" />
            <input type="hidden" name="h" id="h" />
            <input type="submit" id="buttoncrop"  value="salvar" name="salvar" />
        </form>
        <div class="cropt">
            <img  src="usuarios/<?php echo $idDaSessao  ?>/eu/<?php echo $user_foto ?>"  id="cropbox" />
        </div>
    </div>
</div>
