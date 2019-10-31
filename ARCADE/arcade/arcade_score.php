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
# Section: arcade_score.php  Function: Highscore Collection/Submission for RelaxArcade Games   Modified: 10/31/2019  By: MaSoDo

 if (isset($_GET['do']) == 'newscore') {
  $id=htmlspecialchars($_POST['gname'], ENT_QUOTES);
  $thescore = $_POST['gscore'];

  ?>
<form id="myForm" action="http://deburger.com/ARCADE/index.php?act=Arcade&do=newscore" method="post">
<?php
    foreach ($_POST as $a => $b) {
        echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    }
?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>
<?php   } ?>
