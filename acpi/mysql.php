<?php
//-----------------------------------------------------------------------------------/
// Practical-Lightning-Arcade [PLA] 2.0 (BETA) based on PHP-Quick-Arcade 3.0 © Jcink.com
// Tournaments & JS By: SeanJ. - Heavily Modified by PracticalLightning Web Design
// Michael S. DeBurger [DeBurger Photo Image & Design]
//-----------------------------------------------------------------------------------/
// phpQuickArcade v3.0.x © Jcink 2005-2010 quickarcade.jcink.com
// Version: 3.0.23 Final. Released: Sunday, May 02, 2010
//-----------------------------------------------------------------------------------/
// Section: acpi  Place: mysql - Administrator Control Panel
// Original: 7/29/2019 by MaSoDo  |  Claude Updated: 4/2/2026 for PHP 8.x compatibility
//-----------------------------------------------------------------------------------/

// NOTE: This file expects $conn (mysqli connection object), $key, $imgloc,
// and $phpmyadminloc to be defined by the including script, as well as the
// helper functions vsess(), run_iquery(), and message().

{
    $goquery1 = false;
    $goquery2 = false;
    $goquery3 = false;
    $goquery4 = false;

    // -----------------------------------------------------------------------
    // Hall of Fame scores reset
    // -----------------------------------------------------------------------
    if (isset($_POST['HOFwipe']) && $_POST['HOFwipe'] == '1') {
        if (isset($_POST['RESETH']) && $_POST['RESETH'] == 'yes') {
            vsess();
            $goquery1 = run_iquery("UPDATE phpqa_games SET HOF_name = '', HOF_score = '' WHERE HOF_score > 0");
            if ($goquery1) {
                echo '<script>alert(\'Hall of Fame has been RESET\');</script>';
            } else {
                echo '<script>alert(\'Query Failed!\');</script>';
                echo mysqli_error($conn);
            }
        } else {
            echo '<script>alert(\'You Must Check the Confirmation Box to Reset HOF Scores!\');</script>';
        }
    }

    // -----------------------------------------------------------------------
    // Game champion scores reset
    // -----------------------------------------------------------------------
    if (isset($_POST['CHAMPwipe']) && $_POST['CHAMPwipe'] == '1') {
        if (isset($_POST['RESETC']) && $_POST['RESETC'] == 'yes') {
            vsess();
            $goquery2 = run_iquery("UPDATE phpqa_games SET Champion_name = '', Champion_score = 0 WHERE Champion_score != 0");
            if ($goquery2) {
                $goquery3 = run_iquery("TRUNCATE TABLE phpqa_scores");
                if ($goquery3) {
                    $goquery4 = run_iquery("TRUNCATE TABLE phpqa_leaderboard");
                    if ($goquery4) {
                        echo '<script>alert(\'Arcade has been RESET\');</script>';
                    } else {
                        echo '<script>alert(\'Failed to truncate leaderboard table!\');</script>';
                        echo mysqli_error($conn);
                    }
                } else {
                    echo '<script>alert(\'Failed to truncate scores table!\');</script>';
                    echo mysqli_error($conn);
                }
            } else {
                echo '<script>alert(\'Query Failed! Could not reset Champion scores.\');</script>';
                echo mysqli_error($conn);
            }
        } else {
            echo '<script>alert(\'You Must Check the Confirmation Box to Reset Arcade Scores!\');</script>';
        }
    }

    // -----------------------------------------------------------------------
    // Shoutbox wipe
    // -----------------------------------------------------------------------
    if (isset($_POST['dowhat']) && $_POST['dowhat'] == 'WipeShout') {
        vsess();
        if (isset($_POST['WipeShouts']) && $_POST['WipeShouts'] == 'yes') {
            $goquery = run_iquery('TRUNCATE TABLE phpqa_shoutbox');
            if ($goquery) {
                echo '<script>alert(\'Shoutbox Cleared!\');</script>';
            } else {
                echo '<script>alert(\'Query Failed!\');</script>';
                echo mysqli_error($conn);
            }
        } else {
            echo '<script>alert(\'You Must Check the Confirmation Box to Clear Shouts!\');</script>';
        }
    }

    // -----------------------------------------------------------------------
    // Raw query runner
    // -----------------------------------------------------------------------
    if (isset($_POST['querymysql']) && $_POST['querymysql'] == 'Run Query') {
        $thequery = $_POST['thequery'] ?? '';
        vsess();
        $goquery = run_iquery($thequery);
    }

    // phpMyAdmin link
    echo "<a href='" . htmlspecialchars($phpmyadminloc) . "' target='_blank' title='phpMyAdmin database access'>"
       . "<img src='" . htmlspecialchars($imgloc) . "/phpMyAdmin.gif' alt='phpMyAdmin' style='margin-bottom:20px; margin-top:-20px;' /></a>";
?>

<!-- ============================================================ -->
<!-- Raw Query Box                                                 -->
<!-- ============================================================ -->
<div class='tableborder'>
    <table width='100%' cellpadding='5' cellspacing='1'>
        <tr><td class='headertableblock' align='center' colspan='9'><b>Query</b></td></tr>
        <tr><td class='arcade1' align='center'>
            <form action='' method='POST'>
                <input type='hidden' name='akey' value='<?php echo htmlspecialchars($key); ?>'>
                <textarea cols='40' rows='2' wrap='OFF' name='thequery'></textarea><br />
                <input type='submit' name='querymysql' value='Run Query'>
                <br />
                <?php
                if (isset($_POST['querymysql'])) {
                    if (!empty($goquery)) {
                        echo 'Query Executed Successfully';
                    } else {
                        echo 'Query failed. ';
                        echo mysqli_error($conn);
                    }
                }
                ?>
            </form>
        </td></tr>
    </table>
</div>
<br />

<!-- ============================================================ -->
<!-- Database Manager (optimize / repair / check / clear shouts)  -->
<!-- ============================================================ -->
<form action='' method='POST'>
<div class='tableborder'>
    <table width='100%' cellpadding='4' cellspacing='1'>
        <tr><td width='60%' align='center' class='headertableblock' colspan='2'>MySQL Database Manager</td></tr>
        <?php
        $dbs = ['phpqa_accounts', 'phpqa_cats', 'phpqa_games', 'phpqa_leaderboard', 'phpqa_scores', 'phpqa_shoutbox'];
        foreach ($dbs as $v) {
            if ($v === 'phpqa_shoutbox') {
                echo "<tr>"
                   . "<td class='arcade1' align='left'><b>" . htmlspecialchars($v) . "</b>"
                   . " &nbsp; Confirm Here to Clear Shouts: <input type='checkbox' name='WipeShouts' value='yes'></td>"
                   . "<td class='arcade1' align='left' width='1%'><input type='checkbox' name='" . htmlspecialchars($v) . "' value='" . htmlspecialchars($v) . "'></td>"
                   . "</tr>";
            } else {
                echo "<tr>"
                   . "<td class='arcade1' align='left'><b>" . htmlspecialchars($v) . "</b></td>"
                   . "<td class='arcade1' align='left' width='1%'><input type='checkbox' name='" . htmlspecialchars($v) . "' value='" . htmlspecialchars($v) . "'></td>"
                   . "</tr>";
            }
        }
        ?>
        <tr><td class='arcade1' align='center' colspan='2'>
            <b>Action:</b>
            <select size='1' name='dowhat'>
                <option value='optimize'>Optimize</option>
                <option value='repair'>Repair</option>
                <option value='check'>Check</option>
                <option value='dump'>View Dump</option>
                <option value='WipeShout'>Clear Shouts</option>
            </select>
        </td></tr>
        <tr><td class='headertableblock' colspan='2'><div align='center'>
            <input type='submit' name='runsql' value='Run'>
        </div></td></tr>
    </table>
</div>
</form>
<br />

<!-- ============================================================ -->
<!-- Scores Reset                                                  -->
<!-- ============================================================ -->
<div class='tableborder'>
    <table width='100%' cellpadding='5' cellspacing='1'>
        <tr><td class='headertableblock' align='center' colspan='9'><b>Scores Reset</b></td></tr>
        <tr><td class='arcade1' align='center'>
            <form action='' method='POST'>
                Confirm Here to perform this action:
                <input type='checkbox' name='RESETH' value='yes'>
                &nbsp;
                <input type='submit' name='HOF_reset' value='Hall of Fame RESET'>
                <input type='hidden' name='HOFwipe' value='1'>
            </form>
        </td></tr>
        <tr><td class='arcade1' align='center'>
            <form action='' method='POST'>
                Confirm Here to perform this action:
                <input type='checkbox' name='RESETC' value='yes'>
                &nbsp;
                <input type='submit' name='Champ_reset' value='Arcade Scores RESET'>
                <input type='hidden' name='CHAMPwipe' value='1'>
            </form>
        </td></tr>
    </table>
</div>
<br />

<!-- ============================================================ -->
<!-- Full Backup                                                   -->
<!-- ============================================================ -->
<div class='tableborder'>
    <table width='100%' cellpadding='5' cellspacing='1'>
        <tr><td class='headertableblock' align='center' colspan='9'><b>Full Backup</b></td></tr>
        <tr><td class='arcade1' align='center'>
            <form action='' method='POST'>
                <?php
                foreach ($dbs as $v) {
                    echo "<input type='hidden' name='" . htmlspecialchars($v) . "' value='a'>";
                }
                ?>
                <input type='hidden' name='dowhat' value='dump'>
                <input type='submit' value='Generate Complete Database Backup'>
            </form>
        </td></tr>
    </table>
</div>
<br />

<?php
    // -----------------------------------------------------------------------
    // Post-action handlers: dump / optimize / repair / check
    // -----------------------------------------------------------------------
    $dowhat = $_POST['dowhat'] ?? '';

    // --- SQL Dump -----------------------------------------------------------
    if ($dowhat === 'dump' || (isset($_GET['dowhat']) && $_GET['dowhat'] === 'downloaddump')) {
?>
<div class='tableborder'>
    <table width='100%' cellpadding='5' cellspacing='1'>
        <tr><td class='headertableblock' align='center' colspan='9'><b>SQL (dump) Backup</b></td></tr>
        <tr><td class='arcade1' align='center'><br />
            Below is a copy of your arcade table(s) that can be imported onto your host's phpMyAdmin.
            To keep this backup, <b>copy</b> the entire text in the area below into a Notepad file and save it,
            or <a href='?cpiarea=mysql&amp;dowhat=downloaddump'>download</a> it.
<?php
        if (isset($_GET['dowhat']) && $_GET['dowhat'] === 'downloaddump') {
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="phpqa_mysqli_dump.sql"');
            ob_clean();
        } else {
            echo "<textarea cols='100' rows='50' wrap='OFF'>";
        }

        $tables = [];
        $q = run_iquery("SHOW TABLES LIKE 'phpqa_%'");
        while ($s = mysqli_fetch_array($q)) {
            $tables[] = $s[0];
        }

        foreach ($tables as $tbl) {
            $q  = mysqli_fetch_array(run_iquery("SHOW CREATE TABLE `$tbl`"));
            echo "\n\n-- $tbl Table Structure:\n" . $q[1] . ";\n\n";
            $q  = run_iquery("SELECT * FROM `$tbl`");
            echo "-- $tbl Data Dump:\n";
            while ($r = mysqli_fetch_assoc($q)) {
                $cols = implode(', ', array_keys($r));
                $vals = implode("', '", array_map(
                    fn($val) => $val === null ? 'NULL' : mysqli_real_escape_string($conn, $val),
                    array_values($r)
                ));
                echo "INSERT INTO `$tbl` ($cols) VALUES ('$vals');\n";
            }
        }

        if (isset($_GET['dowhat']) && $_GET['dowhat'] === 'downloaddump') {
            exit();
        }
        echo "</textarea>";
?>
        </td></tr>
    </table>
</div>
<br />
<?php
    // --- Optimize -----------------------------------------------------------
    } elseif ($dowhat === 'optimize') {
        foreach ($dbs as $v) {
            if (!empty($_POST[$v])) {
                $optcheck = mysqli_fetch_array(run_iquery("OPTIMIZE TABLE `$v`"));
                if ($optcheck) {
                    message("Table <b>$v</b> optimized. Status: " . htmlspecialchars($optcheck['Msg_text']));
                } else {
                    message("Table <b>$v</b> failed to optimize. Try repairing it.");
                }
            }
        }

    // --- Repair -------------------------------------------------------------
    } elseif ($dowhat === 'repair') {
        foreach ($dbs as $v) {
            if (!empty($_POST[$v])) {
                $optcheck = mysqli_fetch_array(run_iquery("REPAIR TABLE `$v`"));
                if ($optcheck) {
                    message("Table <b>$v</b> repaired. Status: " . htmlspecialchars($optcheck['Msg_text']));
                } else {
                    message("Table <b>$v</b> failed to be repaired.");
                }
            }
        }

    // --- Check --------------------------------------------------------------
    } elseif ($dowhat === 'check') {
        foreach ($dbs as $v) {
            if (!empty($_POST[$v])) {
                $optcheck = mysqli_fetch_array(run_iquery("CHECK TABLE `$v`"));
                if ($optcheck) {
                    message("Table <b>$v</b> checked. Status: " . htmlspecialchars($optcheck['Msg_text']));
                } else {
                    message("Table <b>$v</b> failed to be checked.");
                }
            }
        }
    }

    // -----------------------------------------------------------------------
    // Epoch Converter
    // -----------------------------------------------------------------------
    echo "<div class='tableborder'>"
       . "<table width='100%' cellpadding='5' cellspacing='1'>"
       . "<tr><td class='headertableblock' align='center' colspan='9'>Epoch Converter</td></tr>"
       . "<tr><td class='arcade1' align='center'>"
       . "<iframe src='acpi/epoch.php' width='535' height='180' scrolling='no' title='Epoch Converter'></iframe>"
       . "</td></tr></table></div><br />";
}
?>
