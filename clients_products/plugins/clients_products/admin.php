<?
if(!$action){
print "<br>";
$product_count = db_qr_fetch("select count(*) as count from store_products_data where active=0 and userid !=0");
print_admin_table("<b>ÓáÚ ÊäÊÙÑ ÇáãæÇİŞÉ : </b> <a href='index.php?action=clients_items'>$product_count[count] ÓáÚÉ </a>");

}


if($action=="clients_items" || $action=="clients_items_activate"){
 if_admin();
 
if($action=="clients_items_activate"){
    $id=intval($id);
    db_query("update store_products_data set active=1 where id='$id'");
}
    
    print "<p align=center class=title> ÓáÚ ÊäÊÙÑ ÇáãæÇİŞÉ </p>";
    $qr=db_query("select * from store_products_data where active=0 and userid !=0 order by id");
    if(db_num($qr)){
        print "<table width=100% class=grid>";
        while($data=db_fetch($qr)){
            $data_client = db_qr_fetch("select ".members_fields_replace('username')." from ".members_table_replace('store_clients')." where id='$data[userid]'",MEMBER_SQL);
        print "<tr><td><a href='index.php?action=client_edit&id=$data[userid]'>$data_client[username]</a></td>
               <td>$data[name]</td>
               
               <td>";
unset($dir_content);    
$dir_data['cat'] = $data['cat'] ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from store_products_cats where id='$dir_data[cat]'");

 $dir_content = "$dir_data[name] / ". $dir_content  ;
}

               print "$dir_content</td>
               <td>
               <a href='index.php?action=clients_items_activate&id=$data[id]'> ÊİÚíá </a>
               - <a href='index.php?action=product_edit&id=$data[id]&cat=$data[cat]'>ãÔÇåÏÉ / ÊÚÏíá </a> 
               - <a href='index.php?action=products_del&id=$data[id]&cat=$data[cat]' onClick=\"return confirm('$phrases[are_you_sure]');\">ÍĞİ</a>
               </td></tr>";
        }
        print "</table>";
    }else{
    print_admin_table("<center> áÇ ÊæÌÏ ÓáÚ </center>");
    }
}