<?




    //--------- comments del ----
if($action=="products_comment_del"){
    if(!check_login_cookies()){die("<center> $phrases[access_denied] </center>");}   
    if_admin("products_comments"); 
    db_query("delete from store_products_comments where id='$id'");
 print "<SCRIPT>window.location=\"$scripturl/index.php?action=product_details&id=$cat\";</script>";
 }

 ?>