<?php
//-----------------------------------------------------------------------------------/
//Practical-Lightning-Arcade [PLA] 2.0 (ALPHA) based on PHP-Quick-Arcade 3.0 © Jcink.com
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
# Section: acpi Place: affiliates - Control Panel   Modified: 7/26/2019   By: MaSoDo

if (isset($_GET['act'])&&$_GET['act']=='edit'){
for($i=1;$i<=$_POST['RecNo'];$i++){

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Incompatible Function Block #1
$strSQL = "UPDATE `phpqa_affiliate` SET `url`='".$_POST["url$i"]."', `tag`='".$_POST["tag$i"]."', `img`='".$_POST["file$i"]."', `sort`=".$_POST["sort$i"].", `active` = ".$_POST["active$i"]." WHERE `id`=".$_POST["EdId$i"]." ";
run_query($strSQL);
}
} 
if (isset($_GET['act'])&&$_GET['act']=='add'){
$strSQLadd = "INSERT INTO `phpqa_affiliate` VALUES('', '".$_POST['addFILE']."', '".$_POST['addURL']."', '".$_POST['addTAG']."', '".$_POST['addSORT']."', '".$_POST['addKEY']."', 0, 1);";
run_query($strSQLadd);
}

{
message("Affiliate Manager:");
}
$affiliatedata=run_query("SELECT * FROM `phpqa_affiliate` ORDER BY `sort` ASC"); 
?>

<div class="tableborder"><table width="100%" cellpadding="4" cellspacing="1"><tr><td width="2" align="center" class="headertableblock">Use</td><td width="10%" align="center" class="headertableblock">BANNER</td><td width="20%" align="center" class="headertableblock">URL</td><td width="20%" align="center" class="headertableblock">TAG</td><td width=5% align="center" class="headertableblock">IMAGE FILENAME</td><td width=5% align="center" class="headertableblock">SORT</td><td width="5%" align="center" class="headertableblock">HITS</td><td width="5%" align="center" class="headertableblock">KEY</td></tr>
<form action="?cpiarea=affiliates&act=edit" method="post" name="affiliatable">
<?php
$i = 0;
	while($A=mysql_fetch_array($affiliatedata)){
//END Incompatible Function Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$i = $i + 1; 
?>

<tr>
<td class="arcade1" align="center"><input type="text" style="text-align: left;" name="active<?php echo $i; ?>" value="<?php echo $A['active']; ?>" /></td>
<td class="arcade1" align="center"><a href="<?php echo $A['url']; ?>" title="<?php echo $A['tag']; ?>"><img src="<?php echo($arcurl)?>/<?php echo($bannerloc)?>/<?php echo($A['img'])?>" border="0" width="100" height="20" /></a></td>
<td class="arcade1" align="left"><input type="text" size="52" name="url<?php echo $i; ?>" value="<?php echo $A['url']; ?>"></input></td>
<td class="arcade1"><div align="center"><input type="text" size="52" style="text-align: left;" name="tag<?php echo $i; ?>" value="<?php echo $A['tag']; ?>"></input></td>
<td class="arcade1"><div align="center"><input type="text" size="25" style="text-align: center;" name="file<?php echo $i; ?>" value="<?php echo $A['img']; ?>"></input></td>
<td class="arcade1"><div align="center"><input type="text" size="8" style="text-align: right;" name="sort<?php echo $i; ?>" value="<?php echo $A['sort']; ?>"></input></td>
<td class="arcade1"><div align="center"><?php echo $A['refs']; ?></td>
<td class="arcade1"><div align="center"><b><?php echo $A['key']; ?></b></td>
<input type="hidden" name="EdId<?php echo $i; ?>" value="<?php echo $A['id']; ?>" />
<input type="hidden" name="RecNo" value="<?php echo $i; ?>" />
</tr>
<?php } ?>
<tr><td class="arcade1" align="right" colspan="8"><input type="submit" name="affEdit" value="Save Changes"></td></tr>
</form>
<tr><td class="arcade1" align="right" colspan="8"><hr /></td></tr>
<?php
function rand_string( $length ) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}
?>
<form action="?cpiarea=affiliates&act=add" method="post" name="affiliatable">
<tr>
<td class="arcade1" align="center"><b>Add New &rarr;</b></td>
<td class="arcade1" align="left"><input type="text" size="52" name="addURL" value=""></input></td>
<td class="arcade1"><div align="center"><input type="text" size="52" name="addTAG" value=""></input></td>
<td class="arcade1"><input type="text" size="25" name="addFILE" value=""></input></td>
<td class="arcade1"><div align="center"><input type="text" size="8" name="addSORT" value=""></input></td>
<td class="arcade1"><div align="center"></td>
<td class="arcade1"><input type="text" size="10" name="addKEY" readonly="readonly" style="font-weight: bold; text-align: center;" value="<?php echo rand_string(7); ?>"></input></td>
</tr>
<tr><td class="arcade1" align="right" colspan="7"><input type="submit" name="affAdd" value="Add This Affiliate"></td></tr>
</table></div><br>
</div><br>
