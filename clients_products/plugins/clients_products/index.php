<?

if($action=="add_item" || $action=="add_item_ok"){
     global $member_data;     
     
  if(check_member_login()){   
   
      
$cat=intval($cat);
if($cat){
$all_ok=false;

if($action=="add_item_ok"){
if($name && $price){
 if($sec_img->verify_string($sec_string)){   
     
  
  if($auto_preview_text && $details){
  $content = getPreviewText($details);
}
                
//----- filter XSS Tags -------
include_once(CWD . "/includes/class_inputfilter.php");
$Filter = new InputFilter(array(),array(),1,1);
$details = $Filter->process($details);
//------------------------------

require_once(CWD. "/includes/class_save_file.php"); 
$imtype = strtolower(file_extension($_FILES['imgfile']['name']));
$upload_folder = $settings['uploader_path']."/products" ;    

       
//-------- Save New Picture ---------- 
if($_FILES['imgfile']['name']){


if(in_array($imtype,$upload_types)){


$fl = new save_file($_FILES['imgfile']['tmp_name'],$upload_folder,$_FILES['imgfile']['name']);

if($fl->status){
$saveto_filename =  $fl->saved_filename;
if($default_uploader_chmod){@chmod(CWD . "/". $saveto_filename,$default_uploader_chmod);}


//----------- Thumb Create ----------
if($saveto_filename){
$uploader_thumb_width = intval($settings['products_thumb_width']);
$uploader_thumb_hieght = intval($settings['products_thumb_hieght']);

if($uploader_thumb_width <=0){$uploader_thumb_width=100;}
if($uploader_thumb_hieght <=0){$uploader_thumb_hieght=100;}

$thumb_saved =  create_thumb($saveto_filename,$uploader_thumb_width,$uploader_thumb_hieght,$settings['products_thumb_fixed'],'thumb',true);
if($default_uploader_chmod){@chmod(CWD . "/". $thumb_saved,$default_uploader_chmod);}
}
//------------------------
   
}else{
    open_table(); 
print("<center><b>„·«ÕŸ… : </b> ·„ Ì „ —›⁄ ’Ê—… «·”·⁄… , Œÿ√ «À‰«¡ «·⁄„·Ì…</center>"); 
    close_table();
}
      
}else{
    open_table();
print_admin_table("<center><b> „·«ÕŸ… : </b> ·„ Ì „ —›⁄ «·’Ê—…, ‰Ê⁄ «·„·› €Ì— „”„ÊÕ »Â </center>");
close_table();
}

}

//--------------End Save New Picture----------------


   
$available = 1;
$can_shipping = 1;
$active = 0;
  
 
 db_query("insert into store_products_data (userid,name,img,thumb,content,details,can_shipping,price,weight,cat,date,page_title,page_description,page_keywords,active,available) 
 values ('$member_data[id]','".db_escape($name)."','".db_escape($saveto_filename,false)."','".db_escape($thumb_saved,false)."','".db_escape($content,false)."','".db_escape($details,false)."','".intval($can_shipping)."','".db_escape($price)."','".db_escape($weight)."','$cat',now(),'".db_escape($page_title)."','".db_escape($page_description)."','".db_escape($page_keywords)."','$active','".intval($available)."')");

 $new_id = mysql_insert_id();
 //------ fields ---------------//
 for($i=0;$i<count($field_id);$i++){
 
 unset($cur_field_value);    
 if(is_array($field_value[$i])){$cur_field_value = serialize($field_value[$i]);}else{$cur_field_value = $field_value[$i] ;}
   db_query("insert into store_fields_data (cat,value,product_id) values('".intval($field_id[$i])."','".db_escape($cur_field_value,false)."','$new_id')");
 
 }
 //----------------------------//
  
  $all_ok = true ;
  
  //----------------- additional photos -----------------
  $thumb_width = intval($settings['products_thumb_width']);
$thumb_hieght = intval($settings['products_thumb_hieght']);

if($thumb_width <=0){$thumb_width=100;}
if($thumb_hieght <=0){$thumb_hieght=100;}


                        
 for($i=0;$i<count($_FILES['img']);$i++){
 
 
         if($_FILES['img']['name'][$i]){
     $imtype = strtolower(file_extension($_FILES['img']['name'][$i]));

if(in_array($imtype,$upload_types)){

    
$fl = new save_file($_FILES['img']['tmp_name'][$i],$upload_folder,$_FILES['img']['name'][$i]);

if($fl->status){
$img_saved =  $fl->saved_filename;

//------- thumb --------
$thumb_saved =  create_thumb($img_saved,$thumb_width,$thumb_hieght,$settings['products_thumb_fixed'],'thumb');
  
  db_query("insert into store_products_photos (name,img,thumb,product_id) values 
             ('','".$img_saved."','$thumb_saved','$new_id')");
             
             
              
}else{
print("<center>".$fl->last_error_description."</center>");  
}



}else{
print("<center>$phrases[this_filetype_not_allowed]</center>");
}
  
           
                 
         }  
          
      }
//------------------------------------------------------------------------


  open_table();
  print "<center> ‘ﬂ—« ·ﬂ , ·ﬁœ  „  «÷«›… «·”·⁄… , ”Ê› Ì „ „—«Ã⁄… «·»Ì«‰«  „‰ ﬁ»· «·«œ«—… ›Ì «ﬁ—» Êﬁ  Ê «·„Ê«›ﬁ… ⁄·ÌÂ« </center>";
  close_table();
   
 }else{
     $all_ok = false; 
    open_table();
   print  "<center>$phrases[err_sec_code_not_valid]</center>";     
close_table(); 
 }
}else{
$all_ok = false;
open_table();
print "<center> Ì—ÃÏ «œŒ«· «”„ Ê ”⁄— «·”·⁄… </center>";
close_table();
}
}

if(!$all_ok){
//------- editor ------
require (CWD."/".$editor_path."/editor_init_functions.php") ;
editor_init();
editor_html_init(); 



    print_path_links($cat);
 open_table("«÷«›… ”·⁄…");   
print "<form action='index.php' method=post enctype='multipart/form-data'>
<input type=hidden name='action' value='add_item_ok'>
<input type=hidden name='cat' value='$cat'> 
<fieldset>
<table width=100%>
<tr>
<td><b> «”„ «·”·⁄… </b></td><td><input type=text name='name' size=20 value=\"".htmlspecialchars($name)."\"></td></tr>

                              <tr> <td width=\"100\">
                <b>$phrases[the_image]</b></td>
                                <td>
                                <input type=file name='imgfile'> 
                                 </td></tr>
                                 
<tr>
                                <td width=\"100\">
                <b>$phrases[the_price]</b></td><td >
                <input type=\"text\" name=\"price\" size=\"4\" value=\"".htmlspecialchars($price)."\"> $settings[currency]</td>
                        </tr> 
     </table></fieldset>
     <br>
     <fieldset>
                  <table border=0 width=\"100%\"  style=\"border-collapse: collapse\" class=grid>  
                                    <tr> <td width=\"50\">
                <b>$phrases[the_details]</b></td>
                                <td>";
                                 editor_print_form("details",600,300,"$details");

                                print "
                                <tr><td colspan=2><input name=\"auto_preview_text\" type=\"checkbox\" value=1> $phrases[auto_short_content_create]
                                </td></tr>
                      <tr id=preview_text_tr> <td width=\"100\">
                <b>$phrases[news_short_content]</b></td>
                            <td >
                                <textarea cols=50 rows=5 name='content'>".htmlspecialchars($content)."</textarea>
                                </td></tr>


                        </td>
                        </tr>
                        
                         
                </table></fieldset>  ";
                  //------- fields ------//
                      $fields_array = get_product_cat_fields($cat,true);
                      if(count($fields_array)){ 
                      print "<br><br><fieldset>
                      <legend>„⁄·Ê„«  «÷«›Ì…</legend>
                      <table border=0 width=\"100%\"  style=\"border-collapse: collapse\" class=grid>  ";
                         
                        $qro = db_query("select * from store_fields_sets where id IN (".implode(",",$fields_array).") and active=1 order by ord");  
                       $i=0;
                       while($datao=db_fetch($qro)){
                print "<tr><td><b>".iif($datao['title'],$datao['title'],$datao['name'])."</b></td><td>
   <input type=hidden name=\"field_id[$i]\" value=\"$datao[id]\">";
   if($datao['type']=="text"){
      
   
       print "<textarea cols=30 rows=5 name=\"field_value[$i]\">".$datao['value']."</textarea>";
   }else{
   
   if($datao['type']=="select"){    
   print "<select name=\"field_value[$i]\">
   <option value=''>$phrases[not_selected]</option>";
   }
   
    $qr_options = db_query("select * from store_fields_options where field_id='$datao[id]' order by ord");
    while($data_options = db_fetch($qr_options)){
        
        
          if($datao['type']=="select"){     
        print "<option value=\"$data_options[id]\">$data_options[value]</option>";
          }else{
              
              print "<input type=checkbox name=\"field_value[$i][]\" value=\"$data_options[id]\"> $data_options[value] <br>";
          }
          }
   if($datao['type']=="select"){     
    print "</select>";
   }
   }
   print "</td></tr>"; 
      $i++;         
                       }
                       print "</table></fieldset><br>";
                      }
                                        
                        
print "<br>

<fieldset>
<legend>’Ê— «÷«›Ì…</legend>
<table width=100%>";
for($i=0;$i<4;$i++){
    
  print " <tr> <td width=\"100\">
                <b>$phrases[the_image] #".($i+1)."</b></td>
                                <td>
                                <input type=file name='img[$i]'> 
                                 </td></tr>";
}
 print "  </table>
                                 
</fieldset><br>

<fieldset><table width=100%>
 <tr>
             <td>$phrases[security_code]</td><td>".$sec_img->output_input_box('sec_string','size=7')."
           &nbsp;<img src=\"sec_image.php\" alt=\"Verification Image\" /></td>
           <td>
<input type='submit' value='«÷«›…'>
</td></tr>
</table></fieldset>

</form>";
close_table(); 
}
}else{
    open_table("«÷«›… ”·⁄…");
print "<form action='index.php' method=get>
<input type=hidden name='action' value='add_item'>
<table width=100%><tr><td><b>«·ﬁ”„</b></td>
<td><select name='cat'>";
$qr=db_query("select * from store_products_cats order by cat,ord");
while($data=db_fetch($qr)){
unset($dir_content,$cats_data,$cats_array);    

/*
$dir_data['cat'] = $data['id'] ;
while($dir_data['cat']!=0){
   $dir_data = db_qr_fetch("select name,id,cat from store_products_cats where id='$dir_data[cat]'");

 $dir_content = "$dir_data[name] / ". $dir_content  ;
}  */

   $qrp=db_query("select name,id,cat from store_products_cats where id IN (".$data['path'].")");
   while($datap=db_fetch($qrp)){
       $cats_data[$datap['id']] = $datap;
   }
    
   $cats_array = explode(",",$data['path']);
   
foreach($cats_array as $id){
  if($id){
      $dir_data =  $cats_data[$id];

        $dir_content = "$dir_data[name] / ". $dir_content  ;
     }
        }  
        
        
print "<option value='$data[id]'>$dir_content</option>"; 
//print "<option value='$data[id]'>$data[name]</option>";
}
print "</select></td></tr>

<tr><td colspan=2 align=center><input type='submit' value=' „ «»⁄… '></td></tr>
</table></form>";
close_table(); 
}

}else{
   login_redirect();
    
} 
}