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
# Section: acpi Place: skin - Administrator Control Panel - Hardened Version -   Modified: 9/6/2025   By: MaSoDo - Updated for new editor system

if (isset($_GET['skinremove'])) {
    vsess();
    $skinToRemove = $_GET['skinremove'];
    
    // Security: validate filename
    if (!preg_match('/^[a-zA-Z0-9_-]+\.css$/', $skinToRemove)) {
        message("Invalid skin filename.");
    } elseif ($skinToRemove == "Default.css") {
        message("You cannot remove the default skin.");
    } else {
        $skinPath = "./skins/" . $skinToRemove;
        if (file_exists($skinPath)) {
            if (@unlink($skinPath)) {
                message("Skin '$skinToRemove' has been deleted successfully.");
            } else {
                message("Failed to delete skin '$skinToRemove'. Check file permissions.");
            }
        } else {
            message("Skin '$skinToRemove' does not exist.");
        }
    }
}

if (isset($_POST['addcssfile'])) {
    vsess();
    $newSkinName = trim($_POST['skincssfilename']);
    
    // Validate filename
    if (empty($newSkinName)) {
        message("Please enter a skin name.");
    } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $newSkinName)) {
        message("Skin name can only contain letters, numbers, underscores, and hyphens.");
    } else {
        $skinPath = "./skins/" . $newSkinName . ".css";
        
        if (file_exists($skinPath)) {
            message("A skin with that name already exists.");
        } else {
            // Create new CSS file with basic template
            $defaultCSS = "/* New skin: " . $newSkinName . ".css */\n" .
                         "/* Created: " . date('Y-m-d H:i:s') . " */\n\n" .
                         "/* Add your CSS styles here */\n";
            
            $fp = fopen($skinPath, "w+");
            if ($fp) {
                fwrite($fp, $defaultCSS);
                fclose($fp);
                message("New skin '$newSkinName.css' has been created successfully.");
            } else {
                message("Failed to create new skin. Check directory permissions.");
            }
        }
    }
}
?>

<div align='center'>
<div class='tableborder'>
    <table width='100%' cellpadding='4' cellspacing='1'>
        <tr>
            <td width='40%' align='center' class='headertableblock'>Skin Name</td>
            <td width='15%' align='center' class='headertableblock'>Delete</td>
            <td width='15%' align='center' class='headertableblock'>Modify</td>
            <td width='15%' align='center' class='headertableblock'>Preview</td>
            <td width='15%' align='center' class='headertableblock'>Size</td>
        </tr>

<?php 
$skinCount = 0;
if ($handle = opendir('./skins/')) {
    $skins = array();
    
    // Read all CSS files
    while (false !== ($file = readdir($handle))) { 
        if ($file != "." && $file != ".." && !is_dir("./skins/$file") && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'css') {
            $skins[] = $file;
        }
    }
    closedir($handle);
    
    // Sort skins alphabetically
    sort($skins);
    
    // Display each skin
    foreach ($skins as $file) {
        $skinCount++;
        $fileSize = filesize("./skins/$file");
        $fileSizeFormatted = ($fileSize < 1024) ? $fileSize . ' bytes' : round($fileSize/1024, 1) . ' KB';
        
        echo "<tr>";
        echo "<td class='arcade1'>" . htmlspecialchars($file, ENT_QUOTES, 'UTF-8') . "</td>";
        
        // Delete link (not for Default.css)
        if ($file == "Default.css") {
            echo "<td class='arcade1' align='center'><span style='color: #999;'>[Protected]</span></td>";
        } else {
            echo "<td class='arcade1' align='center'><a href='index.php?cpiarea=skin&amp;skinremove=" . urlencode($file) . "&amp;akey=" . urlencode($key) . "' onclick=\"return confirm('Are you sure you want to delete this skin?');\"><div align='center' style='color: #ff0000;'>[Delete]</div></a></td>";
        }
        
        // Edit link - UPDATED for new editor system
        echo "<td class='arcade1' align='center'><a href='index.php?cpiarea=editor&amp;skin=" . urlencode($file) . "&amp;akey=" . urlencode($key) . "'>[Edit CSS]</a></td>";
        
        // Preview link
        echo "<td class='arcade1' align='center'><a href='javascript:void(0);' onclick=\"previewSkin('" . addslashes($file) . "');\">[Preview]</a></td>";
        
        // File size
        echo "<td class='arcade1' align='center'>" . $fileSizeFormatted . "</td>";
        
        echo "</tr>";
    }
}

if ($skinCount == 0) {
    echo "<tr><td colspan='5' class='arcade1' align='center'><em>No CSS files found in skins directory</em></td></tr>";
}
?>
    </table>
</div>
<br>

<!-- Add JavaScript for skin preview -->
<script type="text/javascript">
function previewSkin(skinFile) {
    var links = document.getElementsByTagName("link");
    var found = false;
    
    // Look for existing stylesheet link
    for (var i = 0; i < links.length; i++) {
        if (links[i].rel && links[i].rel.toLowerCase() === "stylesheet") {
            links[i].href = "skins/" + skinFile;
            found = true;
            break;
        }
    }
    
    // If no stylesheet link found, create one
    if (!found) {
        var link = document.createElement("link");
        link.rel = "stylesheet";
        link.type = "text/css";
        link.href = "skins/" + skinFile;
        document.getElementsByTagName("head")[0].appendChild(link);
    }
    
    alert("Preview applied: " + skinFile + "\nRefresh the page to return to the original skin.");
}
</script>

<!-- Create new skin form -->
<div align='center'>
    <div class='tableborder'>
        <table width='100%' cellpadding='5' cellspacing='1'>
            <tr>
                <td class='headertableblock' colspan='2'><b>Create New CSS File</b></td>
            </tr>
            <tr>
                <td width='70%' align='center' class='arcade1'>New CSS File name (without .css extension)</td>
                <td width='30%' align='center' class='arcade1'>Action</td>
            </tr>
            <tr>
                <form method='post' action='?cpiarea=skin'>
                    <input type='hidden' name='akey' value='<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>'>
                    <td class='arcade1' align='center'>
                        <input type='text' name='skincssfilename' maxlength='50' placeholder='Enter skin name' style='width: 200px;'>
                    </td>
                    <td class='arcade1' align='center'>
                        <input type='submit' value='Create Skin' name='addcssfile'>
                    </td>
                </form>
            </tr>
        </table>
    </div>
</div>

<!-- Skin management info -->
<div align='center' style='margin-top: 15px;'>
    <div class='tableborder'>
        <table width='100%' cellpadding='5' cellspacing='1'>
            <tr>
                <td class='headertableblock'><b>Skin Management Tips</b></td>
            </tr>
            <tr>
                <td class='arcade1'>
                    <ul style='text-align: left; margin: 10px 20px;'>
                        <li><strong>Edit:</strong> Click [Edit CSS] to modify skin styles using the secure editor</li>
                        <li><strong>Preview:</strong> Click [Preview] to temporarily apply the skin to this page</li>
                        <li><strong>Delete:</strong> Click [Delete] to permanently remove a skin (Default.css is protected)</li>
                        <li><strong>Create:</strong> Use the form above to create new blank CSS files</li>
                        <li><strong>Security:</strong> All file operations are validated and secured against path traversal</li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
</div>

<br>
</div>
<?php 
?>
<div align=center><?php
if ($handle = opendir('./skins/')) {
   while (false !== ($file = readdir($handle))) { 
       if ($file != "." && $file != "..") {
if (!is_dir("./skins/$file")) {
           echo "<td class=arcade1>$file</td><td class=arcade1><a href='index.php?cpiarea=skin&skinremove=$file&akey=$key'><div align=center>[X]</div></a></td><td class=arcade1 align='center'><a href='index.php?skin=$file&cpiarea=editor'>[Edit CSS]</a></td><td class='arcade1'><a href='javascript:document.getElementsByTagName(\"link\")[0].href=\"skins/$file\";void(0);'>[Preview]</a></td></tr>"; 
}
       } 
   }
   closedir($handle); 
}?></table></div><br>
<div align='center'><div class='tableborder'><table width=100%% cellpadding='5' cellspacing='1'><tr><td class=headertableblock colspan=9><b><font size=-5>Make new CSS File</font></b></td></tr><td width=50%% align=center class=arcade1><font size=-5>New CSS File name (leave out .css)</font></td><td width=10% align=center class=arcade1><font size=-5>Action</font></td></div><tr><td class=arcade1> <form method=post action="?cpiarea=skin"><input type='hidden' name='akey' value='<?php echo $key; ?>'><div align=center><input type=text name=skincssfilename></center> </div></td><td class=arcade1><div align=center><input type='submit' value='Add' name='addcssfile'></div></td></table></div></form><br />
<?php } 


?>
