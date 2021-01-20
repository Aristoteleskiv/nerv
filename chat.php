<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_DEPRECATED);
$list_amisades = Nudischat::lista_dos_adicionados($idExtrangeiro);

function nomecortar($name, $limit){
    if (strlen($name) >= $limit) {
        return substr($name, 0, intval($limit)-2)."..";
    } else if(strlen($name) < $limit) {
        return $name;
    }
}

if (isset($_POST['cor']) && isset($_POST['cortexto'])) {
    $cor1 = $_POST['cor'];
    $cortext = $_POST['cortexto'];
    $_POST['cortexto'] = isset($_POST['cortexto']);
    header('Location: perfil.php?id='.$idDaSessao.'');
    $query = DB::getConn()->prepare("UPDATE `e1`.`temas` SET `corfundo` = '$cor1', `cortexto` = '$cortext' WHERE `temas`.`usuario` = '$idDaSessao';");
    $query->execute([$idExtrangeiro,$idDaSessao]);
}
?>



<aside id="users_online">
    <span class="user_online" id="<?php echo $idDaSessao;?>"></span>
    <ul>

        <input type="button" name="de" value="<?php echo $idDaSessao;?>" hidden>
        <button class="button" id="chatio">abrir</button>
        <button class="button" id="chatiu" style="display: none">fechar</button>

    </ul>
    <?php


    $solicitacoes = DB::getConn()->prepare('SELECT * FROM `nudischat` WHERE para=? ANd `status`=0');
    $solicitacoes->execute(array($idDaSessao));

    $dadosamisade = DB::getConn()->prepare("SELECT `nome`,`sobrenome`,`foto` FROM `usuarios` WHERE `id`=? LIMIT 1");

    if($solicitacoes->rowcount()>0){
        $link = '<a href="php/nudischat.php?ach=';
        echo '<ul>';
        /** @noinspection PhpAssignmentInConditionInspection */
        while($resmeuamigo=$solicitacoes->fetch(PDO::FETCH_ASSOC)){

            $dadosamisade->execute(array($resmeuamigo['de']));
            $asdadsoamisade = $dadosamisade->fetch(PDO::FETCH_ASSOC);

            echo '<li><a><div class="imgSmall"><img src="uploads/usuarios/'. user_img($asdadsoamisade['foto']).'"/></div>'.$asdadsoamisade['sobrenome'].' quer conversar </a>'.
                $link.'aceitar|'.$resmeuamigo['id'].'">aceitar</a> '.
                $link.'remover|'.$resmeuamigo['de'].'|'.$idDaSessao.'|'.$resmeuamigo['id'].'">recusar</a></li>';
        }
        echo '</ul>';
    }

    ?><ul>


        <?php

        if ($list_amisades['nu'] > 0) {
            foreach ($list_amisades['dados'] as $row) {
                $foto = ($row['foto'] == '') ? 'uploads/usuarios/ms.gif' : $row['foto'];
                $agora = date('Y-m-d H:i:s');
                $status = 'on';
                $selUsuarios= DB::getConn()->prepare('SELECT u.id, u.nome, u.sobrenome, u.foto, u.limite, u.sexo FROM usuarios u INNER JOIN amisade b ON (((u.id=b.de) AND (b.para=?)) OR ((u.id=b.para) AND (b.de=?))) AND b.status=1');
                $selUsuarios->execute(array($row['id'],$row['id']));
                $a['num'] = $selUsuarios->rowCount();
                $a['dados'] = $selUsuarios->fetchAll();
                $txt = ($idDaSessao<>$idExtrangeiro) ? 'fazendo um  hashtag :) para '.$row['nome'] : 'é como.. ! '.$row['nome'].'';
                $genero = ($row['sexo']=='masculino') ? 'mulher ': 'homem';


                if ($row['status'] == 'off'){


                        ?>
                        <li id="<?php echo $row['id']; ?>">
                            <div class="foff">
                                <div class="imgSmall"><img src="usuarios/<?php echo $row['id'] ?>/eu/<?php echo user_img($foto,$row['id']) ?>"/></div>
                                <a  id="<?php echo $idDaSessao . ':' . $row['id']; ?>"
                                ><?php echo nomecortar(utf8_encode($row['nome']), 9); ?><span style="font-size: 7pt;">&nbsp;&nbsp;<?php echo tempo($row['limite'],$idioma);?></span></a>
                                &nbsp;&nbsp;
                            </div>
                        </li>
                    <?php
                }

                elseif ($row['status'] =='on') {

                        ?>
                        <li id="<?php echo $row['id']; ?>">
                            <div class="imgSmall"><img src="usuarios/<?php echo $row['id'] ?>/eu/<?php echo user_img($foto,$row['id']) ?>"/></div>
                            <a href="#" id="<?php echo $idDaSessao . ':' . $row['id']; ?>"
                               class="comecar"><?php echo nomecortar(utf8_encode($row['nome']), 11); ?></a>
                            &nbsp;&nbsp;<p style="font-size: 7pt;">&nbsp;&nbsp;<?php echo tempo($row['limite'],$idioma);?></p>
                            &nbsp;&nbsp;
                            <span id="<?php echo $row['id']; ?>" class="status <?php echo $status; ?>"></span>
                        </li>
                    <?php
                }
            }
        }

        ?>
    </ul>

</aside>




<aside id="chats">

</aside>
<script type="text/javascript" src="js/functions.js"></script>


<!--<div class="window" id="janela_x">
	<div class="header_window"><a href="#" class="close">X</a> <span class="name">Fulano de tal</span> <span id="5" class="status on"></span></div>
	<div class="body">
		<div class="mensagens">
			<ul>

			</ul>
		</div>
		<div class="send_message" id="3:5">
			<p class="lead emoji-picker-container"><textarea class="msg" rows="3"  name="mensagem" placeholder="Ola!" id="'+id+'"  data-emojiable="true"></textarea></p>
			<label  for="imm" class="adimgchat"></label>
			<input type="file" id="imm" hidden  name="file[]" multiple="true"/>
            <label  for="imm" class="adimgvideo"></label>
            <label  for="imm" class="adimgfile"></label>
            <label  for="imm" class="adimgpdf"></label>
		</div>
	</div>
</div>-->