<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Files</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$Dir = "/Users/stuartdaw/.bitnami/stackman/machines/xampp/volumes/root/htdocs/fyp/ViewFiles.php";
$DirEntries = scandir($Dir);
echo "<table border='1' width='100%'>\n";
echo "<tr><th colspan='4'>Directory listing for <strong>" . htmlentities($Dir) . "</strong></th></tr>\n";
echo "<tr>";
echo "<th><strong><em>Name</em></strong></th>";
echo "<th><strong><em>Owner ID</em></strong></th>";
echo "<th><strong><em>Permissions</em></strong></th>";
echo "<th><strong><em>Size</em></strong></th>";
echo "</tr>\n";
foreach ($DirEntries as $Entry) {
     if ((strcmp($Entry, '.') != 0) && (strcmp($Entry, '..') != 0)) {
          $FullEntryName=$Dir . "/" . $Entry;
          echo "<tr><td>";
          if (is_file($FullEntryName))
               echo "<a href=\"FileDownloader.php?filename=$Entry\">" . htmlentities($Entry). "</a>\n";
          else
               echo htmlentities($Entry);
          echo "</td><td align='center'>" . fileowner($FullEntryName);
          if (is_file($FullEntryName)) {
               $perms = fileperms($FullEntryName);
               $perms = decoct($perms % 01000);
               echo "</td><td align='center'>0$perms";
               echo "</td><td align='right'>" . number_format(filesize($FullEntryName), 0) . " bytes";
          }
          else
               echo "</td><td colspan='2' align='center'>&lt;DIR&gt;";
          echo "</td></tr>\n";
     }
}
echo "</table>\n";



?>
</body>
</html>

