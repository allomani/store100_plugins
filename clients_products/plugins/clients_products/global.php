<?
function get_client_name($id){
    $id =(int) $id;
    $product_client =  db_qr_fetch("select username from store_clients where id='".$id."'");
    return $product_client['username'];
}