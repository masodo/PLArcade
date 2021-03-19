<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (BETA) based on PHP-Quick-Arcade 3.0 © Jcink.com
//Tournaments & JS By: SeanJ. - Heavily Modified by PracticalLightning Web Design
//Michael S. DeBurger [DeBurger Photo Image & Design]
//-----------------------------------------------------------------------------------/
//  phpQuickArcade v3.0.x © Jcink 2005-2010 quickarcade.jcink.com                        
//
//  Version: 3.0.23 Final. Released: Sunday, May 02, 2010
//-----------------------------------------------------------------------------------/
// Thanks to (Sean) http://seanj.jcink.com 
// for: Tournies, JS, and more
// ---------------------------------------------------------------------------------/
# Section: Functions.php  Function: Some Common Functions   Modified: 1/15/2021   By: MaSoDo

function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}


function rangecheck($a){
if (substr($a,-1)!=".") $a.=".";
$ip=$_SERVER['REMOTE_ADDR'];
return substr($ip,0,strlen($a))==$a;
}
$bannedfile = file($textloc."/banned.txt"); 
foreach($bannedfile as $a_banned_ip) {
if (rangecheck($a_banned_ip)) { 
message("You have been banned from this arcade.");
die();
}
} 

function Beautify($n, $precision = 3) {
    if ($n < 1000000) {
        // Anything less than a Million
        $n_format = number_format($n);
    } else if ($n < 1000000000) {
        // Anything less than a Billion
        $n_format = number_format($n / 1000000, $precision) . ' Million';
    } else if ($n < 1000000000000 ){
        // Anything less than a Trillion
        $n_format = number_format($n / 1000000000, $precision) . ' Billion';
    } else if ($n < 1000000000000000 ) {  
       // Anything less than a Quadrillion   
       $n_format = number_format($n / 1000000000000, $precision) . ' Trillion';
    } else if ($n < 1000000000000000000 ) {    
       // Anything less than a  Quintillion
       $n_format = number_format($n / 1000000000000000, $precision) . ' Quadrillion';
    } else if ($n < 1000000000000000000000 ) {    
       // Anything less than a Sextillion
       $n_format = number_format($n / 1000000000000000000, $precision) . ' Quintillion';
    } else if ($n < 1000000000000000000000000 ) {    
       // Anything less than a Septillion
       $n_format = number_format($n / 1000000000000000000000, $precision) . ' Sextillion';
    } else if ($n < 1000000000000000000000000000 ) {    
       // Anything less than an Octtillion
       $n_format = number_format($n / 1000000000000000000000000, $precision) . ' Septillion';
    } else if ($n < 1000000000000000000000000000000 ) {    
       // Anything less than a Nonillion
       $n_format = number_format($n / 1000000000000000000000000000, $precision) . ' Octillion';
    } else if ($n < 1000000000000000000000000000000000 ) {    
       // Anything less than a Decillion
       $n_format = number_format($n / 1000000000000000000000000000000, $precision) . ' Nonillion';
    } else if ($n < 1000000000000000000000000000000000000 ) {    
       // Anything less than an Undecillion
       $n_format = number_format($n / 1000000000000000000000000000000000, $precision) . ' Decillion';
    } else if ($n < 1000000000000000000000000000000000000000 ) {    
       // Anything less than a Duodecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000, $precision) . ' Undecillion';
    } else if ($n < 1000000000000000000000000000000000000000000 ) {    
       // Anything less than a Tredecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000, $precision) . ' Duodecillion';
    } else if ($n < 1000000000000000000000000000000000000000000000 ) {    
       // Anything less than a Quattuordecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000000, $precision) . ' Tredecillion';
    } else if ($n < 1000000000000000000000000000000000000000000000000 ) {    
       // Anything less than a Quindecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000000000, $precision) . ' Quattuordecillion';
    } else if ($n < 1000000000000000000000000000000000000000000000000000 ) {    
       // Anything less than a Sexdecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000000000000, $precision) . ' Quindecillion';
    } else if ($n < 1000000000000000000000000000000000000000000000000000000 ) {    
       // Anything less than a Septendecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000000000000000, $precision) . ' Sexdecillion';
    } else if ($n < 1000000000000000000000000000000000000000000000000000000000 ) {    
       // Anything less than a Octodecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000000000000000000, $precision) . ' Septendecillion';
    } else if ($n < 1000000000000000000000000000000000000000000000000000000000000 ) {    
       // Anything less than a Novemdecillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000000000000000000000, $precision) . ' Octodecillion';
    } else if ($n < 1000000000000000000000000000000000000000000000000000000000000000 ) {    
       // Anything less than a Vigintillion
       $n_format = number_format($n / 1000000000000000000000000000000000000000000000000000000000000, $precision) . ' Novemdecillion';
    } else if ($n > 9999999999999999999999999999999999999999999999999999999999999999 ) {    
       // Anything over a Novemdecillion
       $n_format = ' Yadda-yadda-illion';
    }
    return $n_format;
}
?>

<script src="http://YourSiteHere.com/ARCADE/ruffle/ruffle.js"></script>

<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript">
<!--
dateFuture = new Date(<?php echo($ResetTime);?>); //(yyyy,mo,dd,hh,mm,se)

function GetCount(){

        dateNow = new Date();                                                                        //grab current date
        amount = dateFuture.getTime() - dateNow.getTime();                //calc milliseconds between dates
        delete dateNow;

        // time is already past
        if(amount < 0){
                document.getElementById('countbox').innerHTML="Now!";
        }
        // date is still good
        else{
                days=0;hours=0;mins=0;secs=0;out="";

                amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs

                days=Math.floor(amount/86400);//days
                amount=amount%86400;

                hours=Math.floor(amount/3600);//hours
                amount=amount%3600;

                mins=Math.floor(amount/60);//minutes
                amount=amount%60;

                secs=Math.floor(amount);//seconds

                if(days != 0){out += days +" day"+((days!=1)?"s":"")+", ";}
                if(days != 0 || hours != 0){out += hours +" hour"+((hours!=1)?"s":"")+", ";}
                if(days != 0 || hours != 0 || mins != 0){out += mins +" minute"+((mins!=1)?"s":"")+", ";}
                out += secs +" seconds";
                document.getElementById('countbox').innerHTML=out;

                setTimeout("GetCount()", 1000);
        }
}


window.onload=function(){GetCount();}//call when everything has loaded


//-->
</script>
