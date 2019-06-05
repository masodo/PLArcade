<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 1.0 (BETA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: JavaScript.php  Function: Javascript Function Repository   Modified: 6/5/2019   By: MaSoDo
?>
<script type='text/javascript'>
function chsize(n){
a=document.getElementsByTagName('object')[0]
b=document.getElementsByTagName('embed')[0]
if (!b) b=new Image()
if (!a) a=new Image()
amount=prompt('Change the '+n+':',eval("a."+n));
if (!amount) amount=eval("a."+n)
eval("a."+n+"=b."+n+"=amount;a."+n+"=b."+n+"=amount;")
return amount
}
function tog(a){
c=document.getElementsByTagName('div')
for(x=0;x<c.length;x++) {
if (c[x].getAttribute('name')!="tog_collect") continue;
n=c[x].style
if (c[x].id!=a) {n.display='none'; continue;}
if (n.display) n.display=''; else n.display='none';
}
}
function nowtime(){
var ct = new Date();
        var hr = ct.getHours();
        var mt = ct.getMinutes();

        var ampm = "AM";

        if (hr >= 12) {
            ampm = "PM";
            hr = hr - 12;
        }
        if (hr == 0) {
            hr = 12;
        }
        if (mt < 10) {
            mt = "0" + mt;
        }

  var result =  document.write("<b>" + hr + ":" + mt + " " + ampm + "</b>");
  return result;
  }
</script>
