<?php /** @noinspection ALL */


function turndate($date){$date=tod($date);
    return date('F j', strtotime($date));
}

function turndatev($date){$date=tod($date);
    return date('l \a\t g:ia', strtotime($date));
}

function turndate3($date){$date=tod($date);
    return date('g:ia', strtotime($date));
}

function td($topv,$tp){
    $topv=tod($topv);
    $compared_time=new DateTime($topv);
    $actual_time=new DateTime();

    $dayoftheweek=$actual_time->format('N');;
    $dayoftheweekbt=$tp->format('N');
    $monthoftheyear=$actual_time->format('n');
    $monthoftheyearbt=$tp->format('n');

    $dayoftheyear=$actual_time->format('d');
    $dayoftheyearbt=$tp->format('d');

    $weekoftheyear=$actual_time->format('W');
    $weekoftheyearbt=$tp->format('W');
    $weekoftheyearv=$weekoftheyear+1;
    if($weekoftheyearv=='53'){
        $weekoftheyearv=01;
    }

    $year=$tp->format('Y');
    $tdd=$actual_time->diff($compared_time);
    $td=$tdd->format('%R%m'); $suf=" month";
    if($td=='+0' || $td=='-0'){$td=$tdd->format('%R%d'); $suf=' day';}
    if($td=='+0' || $td=='-0'){$td=$tdd->format('%R%H'); $suf=' hour';}
    if($td=='+00' || $td=='-00'){$td=$tdd->format('%R%i'); $suf=' minute';}
    if($td=='+0' || $td=='-0'){$td=$tdd->format('%R%s'); $suf=' second';}
    if($td=='+0' || $td=='-0'){$td='1';}

    $pretd=substr($td,0,1);
    if($pretd=='0'){if(substr($td,0,1)=="0"){$td=substr($td,1);}}

    if($td>1){$suf.='s';}

    if($suf==" day" && $topv>=strtotime("yesterday")){}
    else if($suf==" day"){$suf=' days'; $td=2;}

    if($suf==' second' || $suf==' seconds'){
        return 'a few seconds ago';
    }

    if(strpos($td,'+')!==false){$ago='remains';
        $td=str_replace('+','',$td);
        if($suf==' days' && $td<7){

            if($dayoftheweekbt>=$dayoftheweek){
                $td=$dayoftheyearbt.'{}'.'This week'.'{}'.turndate($topv);
                return $td;
            }
            else{
                $td=$dayoftheyearbt.'{}'.'Next week'.'{}'.turndate($topv);
                return $td;
            }
        }
        else if($suf==' days' && $td<14 && $weekoftheyearbt==$weekoftheyearv){
            $td=$dayoftheyearbt.'{}'.'Next week'.'{}'.turndate($topv);
            return $td;
        }
        else if($suf==' days'){
            $monthoftheyearbtv=$tp->format('F');
            $td=$dayoftheyearbt.'{}'.$monthoftheyearbtv.'{}'.turndate($topv);
            return $td;
        }
        else if($suf==' months' || $suf==' month'){
            $monthoftheyearbtv=$tp->format('F');
            if($monthoftheyear>$monthoftheyearbt){
                $td=$dayoftheyearbt.'{}'.$monthoftheyearbtv.$year.'{}'.turndate($topv);
                return $td;
            }
            else if($monthoftheyear==$monthoftheyearbt && $dayoftheyearbt<$dayoftheyear){
                $td=$dayoftheyearbt.'{}'.$monthoftheyearbtv.$year.'{}'.turndate($topv);
                return $td;
            }
            else{
                $td=$dayoftheyearbt.'{}'.$monthoftheyearbtv.'{}'.turndate($topv);
                return $td;
            }
        }
        else if($suf==' day'){
            $td=$dayoftheyearbt.'{}'.'Tomorrow'.'{}'.turndate($topv);
            return $td;
        }
        else if($suf==' minute' || $suf==' minutes'){

            $td=$dayoftheyearbt.'{}'.'Today'.'{}'.turndate($topv);

            return $td;
        }
        $td=$td.$suf.' remain'.turndate($topv);
    }
    else{$ago='ago';}


    if($td=='1 day ago'){$hrsminsec=turndate3($topv); $td='Yesterday at '.$hrsminsec;}

    return $td;
}

function td2($topv){
    $topv=tod($topv);
    $compared_time=new DateTime($topv);
    $actual_time=new DateTime();
    $tdd=$actual_time->diff($compared_time);
    $td=$tdd->format('%R%m'); $suf=" month";
    if($td=='+0' || $td=='-0'){$td=$tdd->format('%R%d'); $suf=' day';}
    if($td=='+0' || $td=='-0'){$td=$tdd->format('%R%H'); $suf=' hour';}
    if($td=='+00' || $td=='-00'){$td=$tdd->format('%R%i'); $suf=' minute';}
    if($td=='+0' || $td=='-0'){$td=$tdd->format('%R%s'); $suf=' second';}
    if($td=='+0' || $td=='-0'){$td='1';}

    if(strpos($td,'-')!==false){

        return 'past';
    }
    else{return'';}
}


function td3($topv, $td){
    $topv=tod($topv);
    $actual_time=new DateTime();

    return $td;
}

function retval($val){
    $year=date("Y");
    $yearv=$year+1;
    if($val=='today'){$val=-2;}
    else if($val=='tomorrow'){$val=-1;}
    else if($val=='thisweek'){$val=0;}
    else if($val=='nextweek'){$val=1;}
    else if($val=='january'){$val=2;}
    else if($val=='february'){$val=3;}
    else if($val=='march'){$val=4;}
    else if($val=='april'){$val=5;}
    else if($val=='may'){$val=6;}
    else if($val=='june'){$val=7;}
    else if($val=='july'){$val=8;}
    else if($val=='august'){$val=9;}
    else if($val=='september'){$val=10;}
    else if($val=='october'){$val=11;}
    else if($val=='november'){$val=12;}
    else if($val=='december'){$val=13;}
    else if($val=='january'.$yearv){$val=14;}
    else if($val=='february'.$yearv){$val=15;}
    else if($val=='march'.$yearv){$val=16;}
    else if($val=='april'.$yearv){$val=17;}
    else if($val=='may'.$yearv){$val=18;}
    else if($val=='june'.$yearv){$val=19;}
    else if($val=='july'.$yearv){$val=20;}
    else if($val=='august'.$yearv){$val=21;}
    else if($val=='september'.$yearv){$val=22;}
    else if($val=='october'.$yearv){$val=23;}
    else if($val=='november'.$yearv){$val=24;}
    else if($val=='december'.$yearv){$val=25;}
    return $val;
}

function rettvalv($val){
    if($val=='0'){$val='a';}
    else if($val=='0'){$val='b';}
    else if($val=='1'){$val='c';}
    else if($val=='2'){$val='d';}
    else if($val=='3'){$val='e';}
    else if($val=='4'){$val='f';}
    else if($val=='5'){$val='g';}
    else if($val=='6'){$val='h';}
    else if($val=='7'){$val='i';}
    else if($val=='8'){$val='j';}
    else if($val=='9'){$val='k';}
    else if($val=='10'){$val='l';}
    else if($val=='11'){$val='m';}
    else if($val=='12'){$val='n';}
    else if($val=='13'){$val='o';}
    else if($val=='14'){$val='p';}
    else if($val=='15'){$val='q';}
    else if($val=='16'){$val='r';}
    else if($val=='17'){$val='s';}
    else if($val=='18'){$val='t';}
    else if($val=='19'){$val='u';}
    else if($val=='20'){$val='v';}
    else if($val=='21'){$val='w';}
    else if($val=='22'){$val='x';}
    else if($val=='23'){$val='y';}
    else if($val=='24'){$val='z';}
    return $val;
}




$year=date("Y");
$result= DB::getConn()->prepare('SELECT u.id, u.nome, u.sobrenome, u.foto, u.status=0 FROM usuarios u INNER JOIN amisade b ON (((u.id=b.de) AND (b.para=?)) OR ((u.id=b.para) AND (b.de=?))) AND (b.status=2) ORDER BY RAND() LIMIT 8');
while($ms=$result->fetch(PDO::FETCH_ASSOC)){
    $friend=$ms['id'];
    $result2= DB::getConn()->prepare("SELECT * FROM usuarios WHERE id='$friend'");
    while($ms2=$result2->fetch(PDO::FETCH_ASSOC)){
        $pdate=new DateTime();
        $hpdate=$pdate->format('G');
        $mpdate=$pdate->format('i');
        $mpdate=$mpdate+10;
        $substrd=substr($mpdate,0,1);
        $substrdv=substr($mpdate,1,1);
        if($substrd=='6' || $substrd=='7'){
            $mpdate='0'.$substrdv;
            if($hpdate=='23'){$hpdate=0;}
            else{$hpdate=$hpdate+1;}
        }
        $date=$ms2['dia'].'-'.$ms2['mes'].'-'.$year.' '.$hpdate.':'.$mpdate;
        $date = new DateTime($date);
        $date2=$date->format('Y-m-d g:ia');
        $yearv=$year+1;

        $date3=td2($date2);
        if($date3=='past'){
            $date=$ms2['dia'].'-'.$ms2['mes'].'-'.$yearv.' '.$hpdate.':'.$mpdate;

            $actual_time2=$ms2['dia'].'-'.$ms2['mes'].'-'.$ms2['ano'];

            $actual_time=new DateTime($actual_time2);
            $compared_time=new DateTime($date);

            $tdd=$actual_time->diff($compared_time);
            $td=$tdd->format('%R%Y');

            $date = new DateTime($date);
            $date2=$date->format('Y-m-d g:ia');
        }
        else{

            $datev=$ms2['dia'].'-'.$ms2['mes'].'-'.$year.' '.$hpdate.':'.$mpdate;

            $actual_time2=$ms2['dia'].'-'.$ms2['mes'].'-'.$ms2['ano'];

            $actual_time=new DateTime($actual_time2);
            $compared_time=new DateTime($datev);

            $tdd=$actual_time->diff($compared_time);
            $td=$tdd->format('%R%Y');

        }

        $date2=td($date2);

        $explode=explode('{}',$date2);
        $explode1=$explode[1];
        $explode1=strtolower($explode1);

        $explode1=str_replace(' ','',$explode1);



        if(!isset(${'arri'.$explode1})){
            ${'arri'.$explode1}=array();
            $val=retval($explode1);
//echo $val.'<br>';
            $possiblevalues[$val]=$explode1;
        }
        $explode0=$explode[0];
        if(isset(${'arri'.$explode1}[$explode0])){
            if($cexplodev>0){
                $bvar.=rettvalv($cexplode).rettvalv($cexplodev);
            }
            else{$bvar.=rettvalv($cexplode);}
            if(strlen($bvar)>150){
                $cexplode++;
                if($cexplodev>0){
                    $bvar.=rettvalv($cexplode).rettvalv($cexplodev);
                }
                else{$bvar=rettvalv($cexplode);}
                if($cexplode>23){
                    $cexplode=0;
                    $cexplodev++;
                    if($cexplodev>22){
                        $cexplodev=1;
                    }
                    $bvar=rettvalv($cexplode).rettvalv($cexplodev);
                }
            }
            $explode0=$explode0.$bvar;
        }
        ${'arri'.$explode1}[$explode0]=$explode[2].'<>'.$ms2['id'].'<>'.$td;


    }
}

?>

<?php

function recompose($val){
    $year=date("Y");
    $yearv=$year+1;
    if($val=='today'){$val='Today';}
    else if($val=='tomorrow'){$val='Tomorrow';}
    else if($val=='thisweek'){$val='This Week';}
    else if($val=='lthisweek'){$val='Later This Week';}
    else if($val=='nextweek'){$val='Next Week';}
    else if($val=='january'){$val='January';}
    else if($val=='february'){$val='February';}
    else if($val=='march'){$val='March';}
    else if($val=='april'){$val='April';}
    else if($val=='may'){$val='May';}
    else if($val=='june'){$val='June';}
    else if($val=='july'){$val='July';}
    else if($val=='august'){$val='August';}
    else if($val=='september'){$val='September';}
    else if($val=='october'){$val='October';}
    else if($val=='november'){$val='November';}
    else if($val=='december'){$val='December';}
    else if($val=='january'.$yearv){$val='January'.' '.$yearv;}
    else if($val=='february'.$yearv){$val='February'.' '.$yearv;}
    else if($val=='march'.$yearv){$val='March'.' '.$yearv;}
    else if($val=='april'.$yearv){$val='April'.' '.$yearv;}
    else if($val=='may'.$yearv){$val='May'.' '.$yearv;}
    else if($val=='june'.$yearv){$val='June'.' '.$yearv;}
    else if($val=='july'.$yearv){$val='July'.' '.$yearv;}
    else if($val=='august'.$yearv){$val='August'.' '.$yearv;}
    else if($val=='september'.$yearv){$val='September'.' '.$yearv;}
    else if($val=='october'.$yearv){$val='October'.' '.$yearv;}
    else if($val=='november'.$yearv){$val='November'.' '.$yearv;}
    else if($val=='december'.$yearv){$val='December'.' '.$yearv;}
    return $val;
}
ksort($possiblevalues);

foreach($possiblevalues as $key => $value){
    ksort(${'arri'.$value});
}


$ocount=0;
$acount=0;
foreach($possiblevalues as $key => $value){
    $count=0;
    foreach(${'arri'.$value} as $keyv=> $value2){
        $acount++;
        if($acount>$showmcurrent && $acount<=$upto){
            $ocount++;
        }
        ${'arri'.$value.'v'}=$count;
        $count++;

    }

}



    foreach($possiblevalues as $key => $value){
        $count=0;
        $border='1';
        if(isset($finish)){break;}
        foreach(${'arri'.$value} as $keyv=> $value2){
            if(${'arri'.$value.'v'}==$count){$border='0';}
            $count++;
            if($value=='tomorrow' || $value=='today'){$setf='t';}
            if(strpos($contval,'today')!==false || strpos($contval,'tomorrow')!==false){$setf='t';}
            if($pcount>$showmcurrent && $pcount<=$upto){
                if($pcountv>20){$finish='t'; break;}
                if(strpos($contval,$value)===false){
                    if(!isset(${'echo'.$value})){
                        ${'echo'.$value}='';
                        if($value=='thisweek' && isset($setf)){$valuev='Later This Week';}
                        else{$valuev=recompose($value);}
                        $contval.=$value.',';
                        echo '<div style="width:590px;padding:5px;margin:0;background:#f2f2f2;font-weight:bold;font-size:11px;border-top:1px solid #e2e2e2;">'.$valuev.'</div>';
                    }
                }
                $list=explode("<>",$value2);

                $date=$list[0];
                $id=$list[1];
                $yearsold=$list[2];
                $yearsold=str_replace('+','',$yearsold);

                $result= DB::getConn()->prepare("SELECT * FROM usuarios WHERE id='$id'");
                while($ms=$result->fetch(PDO::FETCH_ASSOC)){
                    $uo_pic=$ms['foto'];
                    $uo_fn=$ms['nome'];
                    $uo_un=$ms['sobrenome'];
                    if($uo_un==''){$uo_un=$id;}
                }
                echo '<div style="width:590px;padding:10px 5px;margin:0;background:#ffffff;border-bottom:'.$border.'px solid #e9e9e9;" class="friendslink">
<div style="margin:0;padding:0;display:inline-block;">
<a href="/'.$uo_un.'">
<img src="/'.$id.'/pics/'.$uo_pic.'" style="height:50px;width:50px;">
</a>
</div>
<div style="margin:0;padding:0;display:inline-block;vertical-align:top;padding-top:2px;padding-left:7px;"><a href="/'.$uo_un.'">'.$uo_fn.'</a><div style="margin:0;padding:0;">'.$date.'</div><div style="margin:0;padding:0;color:#808080;">'.$yearsold.' years old</div></div>
</div>';
                $pcountv++;
            }
            $pcount++;

        }



    }



?>