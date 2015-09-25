<?
include "global.php" ;
print "<META http-equiv=Content-Type content=\"text/html; charset=windows-1256\"> \n";
print "<LINK href=\"css.php\" type=text/css rel=StyleSheet>   \n";
$qr = db_query("select title,id from store_news order by id DESC limit 20");

 print "
    <marquee onmouseover=\"this.stop()\"
    onmouseout=\"this.start()\" scrollAmount=\"5\" scrollDelay=\"0\" direction=right   width=\"100%\">"    ;

    while($data = db_fetch($qr))
    {

            print " &nbsp&nbsp&nbsp <a href='news_$data[id].html' target='_blank'>$data[title]</a> &nbsp&nbsp&nbsp ** ";
            }

            print "</marquee>";

            ?>