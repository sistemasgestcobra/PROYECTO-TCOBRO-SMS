<?php
$monto=999.10;
$dias=65;
echo "monto: ".$monto." dias: ".$dias."</br>";
echo "comision: ".comi($monto,$dias);

function comi($m,$d){
    if($d>1&&$d<=30){
        $dias=1;
    }else if ($d>30&&$d<=60){
        $dias=2;
    }else if ($d>60&&$d<=90){
        $dias=3;
    }else if ($d>90){
        $dias=4;
    }
    
    if ($m<100){
        switch ($dias) {
            case 1:
                $com=6.38;
                break;
            case 2:
                $com=16.23;
                break;
            case 3:
                $com=23.17;
                break;
            case 4:
                $com=25.56;
                break;
        }
    }else if($m>=100 && $m<200){
        switch ($dias) {
                case 1:
                $com=7.35;
                break;
            case 2:
                $com=16.46;
                break;
            case 3:
                $com=23.85;
                break;
            case 4:
                $com=26.64;
                break;
        }
    }else if($m>=200 && $m<300){
        switch ($dias) {
                case 1:
                $com=7.92;
                break;
            case 2:
                $com=17.83;
                break;
            case 3:
                $com=25.27;
                break;
            case 4:
                $com=29.03;
                break;
        }
    }else if($m>=300 && $m<500){
        switch ($dias) {
                case 1:
                $com=8.32;
                break;
            case 2:
                $com=20.34;
                break;
            case 3:
                $com=27.43;
                break;
            case 4:
                $com=32.72;
                break;
        }
    }else if($m>=500 && $m<1000){
        switch ($dias) {
                case 1:
                $com=8.63;
                break;
            case 2:
                $com=23.99;
                break;
            case 3:
                $com=30.34;
                break;
            case 4:
                $com=37.70;
                break;
        }
    }else if($m>=1000){
        switch ($dias) {
                case 1:
                $com=8.88;
                break;
            case 2:
                $com=28.78;
                break;
            case 3:
                $com=34.01;
                break;
            case 4:
                $com=43.99;
                break;
        }
    }
    return $com;
}

?>