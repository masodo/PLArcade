<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//UpdatedFunction Block #1
$tquery = run_iquery("select * from `phpqa_accounts`");
while($truser = mysqli_fetch_array($tquery)){
$usegroup = '';
$takename = $truser['name'];
$takepass = $truser['pass'];
$takeemail = $truser['email'];
$takegroup = $truser['group'];
$takeIP = $truser['ipaddress'];

if ($takegroup == 'Member')$usegroup = 3;
if ($takegroup == 'Admin')$usegroup = 1;
if ($takegroup == 'Moderator')$usegroup = 4;
if ($takegroup == 'Affiliate')$usegroup = 5;
$regtime = time();
run_iquery("INSERT INTO PLA_users VALUES('', ".$usegroup.", '".$takename."', '".$takepass."', NULL, '".$takeemail."', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 'English', 'Oxygen', 1, 0, NULL, NULL, '".$regtime."', '".$takeIP."', 0, NULL, NULL, NULL, 0, 0, 0);");
//END UpdatedFunction Block #1
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
echo "<script>alert('DONE!')</script>";
?>
