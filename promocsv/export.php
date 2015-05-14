<?php
//require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

$promoconn = mysql_connect("localhost","salad_commandc","NDS7hic2JHJBCG");
mysql_select_db('salad_commandc');

function CSVExport($query) {
    $sql_csv = mysql_query($query) or die("Error: " . mysql_error()); //Replace this line with what is appropriate for your DB abstraction layer

    header("Content-type:text/octect-stream");
    header("Content-Disposition:attachment;filename=data.csv");
    while($row = mysql_fetch_row($sql_csv)) {
		$titleq = mysql_query("SELECT post_title FROM wp_posts WHERE ID=".$row[1]."");
		$title = mysql_fetch_array($titleq);
		$row[1]=$title['post_title'];
        print '"' . stripslashes(implode('","',$row)) . "\"\n";
    }

    exit;
}

CSVExport("SELECT * FROM wp_promotions WHERE post_id='".mysql_real_escape_string($_GET['expo'])."' ORDER BY last_name, first_name, id");


?>