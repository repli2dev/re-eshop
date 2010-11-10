<?
$hash = $_GET['hash'];
if($hash == "tR0Z862"){
  // Connect to db
  mysql_connect('localhost','re_eshop_1gb_cz','');
  mysql_select_db('re_eshop_1gb_cz');
  mysql_query("SET CHARACTER SET utf8");
  mysql_query("SET NAMES utf8");
  // Delete data from data dir
  destroy('./data/news/');
  destroy('./data/products/');
  destroy('./data/upload/');

  // Delete whole database
  $tables = array('news','page','shop_cart','shop_cat','shop_order','shop_order_product','shop_payment','shop_manufacturer','shop_product','shop_product_cat','shop_shipping','shop_user_extend','users');

  foreach($tables as $row){
	  $sql = "DROP TABLE ".$row;
	  $query = mysql_query($sql);
  }

  // Import sql structure
  mysql_import('./docs/db_structure.sql');

  // Import sql example data
  mysql_import('./docs/db_example.sql');
} else {

}

function destroy($dir) {
    $mydir = opendir($dir);
    while(false !== ($file = readdir($mydir))) {
        if($file != "." && $file != "..") {
            chmod($dir.$file, 0777);
            if(is_dir($dir.$file)) {
                chdir('.');
                destroy($dir.$file.'/');
                rmdir($dir.$file) or DIE("couldn't delete $dir$file<br />");
            }
            else
                unlink($dir.$file) or DIE("couldn't delete $dir$file<br />");
        }
    }
    closedir($mydir);
}

function mysql_import($filename) {
echo "Importing...";
// let's pretend that connection to server is established
// and database chosen...
$sql = explode(';', file_get_contents ($filename));
$n = count ($sql) - 1;
for ($i = 0; $i < $n; $i++) {
$query = $sql[$i];
$result = mysql_query ($query)
or die ('<p>Query: <br><tt>' . $query .
'</tt><br>failed. MySQL error: ' . mysql_error());
}
}

?>
