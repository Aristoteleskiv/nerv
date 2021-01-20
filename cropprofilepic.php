<?php include("start.php"); ?>
<?php
include("classes/photo.php");
$rhelper_jsv="";

foreach($_POST as $k=>$v){
${$k}=$v;	
}

$leftv=$left;
$topv=$top;


if($cnb=='2'){
include("classes/resizer.php");

$pathp=pathinfo($img2);
$ext=$pathp['extension'];
$pathp=$pathp['basename'];

$no_path_img2=$pathp;

$pathp=str_replace("mm.".$ext,"",$pathp);

$pathp=$pathp.'th.'.$ext;

$img6="users/$uid/pics/$pathp";


$size=getimagesize($img2);
$width=$size[0];
$height=$size[1];

copy($img2,$img6);

$thumbnail=$pathp; 

include("make50pixelsthumbnail.php"); //la version de 50 x 50 se hizo aqui - se llama thumbnail, la version de 100 x 100 se llama thumbnail_s.ext

$pathp=$thumbnail; 


$img2=$no_path_img2;

$r=mysql_query("SELECT * FROM media WHERE picsm='$img2'");
while($m=mysql_fetch_array($r)){
$img3=$m['pics'];
}

$img4=explode(".",$img3);
$img4=$img4[0]."_s.".$img4[1];

$img3="usuarios/".$uid."/eu/".$img3;
$img4="usuarios/".$uid."/eu/".$img4;

copy($img3,$img4);
$copiedvv=$img4;
$thumbnailv=$copiedvv;

include("add_photos/default_profile_picture_crop.php");

mysql_query("UPDATE options SET lcords='2', tcords='' WHERE id='$uid'");
mysql_query("UPDATE registered SET profilepict='$pathp' WHERE id='$uid'");
}
else{
$f_awidth=$awidth;
$f_aheight=$aheight;

$size=getimagesize("$img2");
$p_wv=$size[0];
$p_hv=$size[1];

function ratio($fv,$sv){
return $fv*100/$sv;
}
function ratior($fv,$sv){
return $fv/100*$sv;
}

echo $owidth.':'.$oheight;

$left=ratio($left,$owidth);
$left=ratior($p_wv,$left);

$top=ratio($top,$oheight);
$top=ratior($p_hv,$top);


if($awidth>$p_wv){
$awidth=ratio($awidth,$owidth);
$awidth=ratior($p_wv,$awidth);
}
else if($owidth<$awidth){
$awidth=$owidth;
}


if($aheight>$p_hv){
$aheight=ratio($aheight,$oheight);
$aheight=ratior($p_hv,$aheight);
}
else if($oheight<$aheight){
$aheight=$oheight;
}





$pathp=pathinfo($img2);
$ext=$pathp['extension'];
$pathp=$pathp['basename'];

$pathp=str_replace(".".$ext,"",$pathp);

$pathp=$pathp.'th.'.$ext;
$img6="usuarios/$uid/eu/$pathp";

copy($img2,$img6);


$copiedvv=$img6;
$photo2 = new Photo(array("name"=>"$copiedvv","tmp_name"=>"$copiedvv"));  
$photo2->doFullCrop($left,$top,$awidth,$aheight);


$p_hv_o=$p_hv;
$p_wv_o=$p_wv;

$img2=str_replace("mm.","a.",$img2); // crop for 100 pixels version

$img7=str_replace("a.","_s.",$img2);

$copiedvv=$img7;

copy($img2,$img7);

$size=getimagesize("$img2");
$p_wv=$size[0];
$p_hv=$size[1];

$left=ratio($left,$owidth);
$left=ratior($p_wv,$left); //el verdadero left equivalente de la foto chiquita a la foto mas grande, a

$top=ratio($top,$oheight); 
$top=ratior($p_hv,$top); //el verdadero top equivalente de la foto chiquita a la foto mas grande, a

$awidth=$awidth*$p_wv/$p_wv_o;

$aheight=$aheight*$p_hv/$p_hv_o;


$photo2 = new Photo(array("name"=>"$copiedvv","tmp_name"=>"$copiedvv"));  
$photo2->doFullCrop($left,$top,$awidth,$aheight); //el crop se hizo para ahora hacer la foto de tama�o en 100 x 100 - cropped de a.jpg

$pathpv=pathinfo($img7);
$extv=$pathpv['extension'];
$pathpv=$pathpv['basename'];

$thumbnail=$pathpv;

if(class_exists("resizer")===false){
include("classes/resizer.php");
}
$image = new resizer(); $image->prepare($img7,$img7); $image->ToHeight(100);	

//aca hacer resize a 100 x 100 - en otro momento, por ahora medio que me chupa un huevo... igual nunca puede ser mucho mas de 250px de ancho o de alto. - echo

$pathp=$pathp; 

mysql_query("UPDATE usuarios SET foto='$pathp' WHERE id='$uid'");
}
?>
<?php include("end.php"); ?>