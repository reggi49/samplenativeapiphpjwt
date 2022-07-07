<?php
include_once('../config.php');
if(isset($_GET['cari'])){
    $q   = mysqli_real_escape_string($conn,$_GET['cari']);
    $query = "select id, klasifikasi,toko, alamat, hp, contact, status, latitude, longitude, gambar, gambar2, subklasifikasi AS category from data_pros where (toko like '%".$q."%' OR alamat like '%".$q."%') AND (toko NOT LIKE '%cv%' AND klasifikasi NOT LIKE '%user%' )  AND (status is NOT null AND status !='N') ORDER BY status LIMIT 50 ";
}
// if(isset($_GET['cari'])&&($_GET['cari'])){
//     $q   = mysqli_real_escape_string($conn,$_GET['cari']);
//     $k   = mysqli_real_escape_string($conn,$_GET['kat']);
//     $query = "select id, klasifikasi,toko, alamat, hp, contact, status, latitude, longitude, gambar, gambar2, subklasifikasi AS category from data_pros where (toko like '%".$q."%' AND klasifikasi like '%".$k."%') AND (toko NOT LIKE '%cv%' AND klasifikasi NOT LIKE '%user%' )  AND (status is NOT null AND status !='N') ORDER BY status LIMIT 50 ";
// }
$result = mysqli_query($conn,$query);
// print_r($result);
if(mysqli_num_rows($result)>0){
 $array_data = array();
//  $array_data["items"]=array(); 
 while($baris = mysqli_fetch_assoc($result))
    {
        // $array_data[]=$baris;
        extract($baris); 
        // if ($category == "MOTOR" || $category == "MOBIL")
        // {
        //     $category = "JOK " .$category;
        // } 
        $itemDetails=array(
            "id" => $id,
            "klasifikasi" => $klasifikasi,
            "toko" => $toko,
            "alamat" => $alamat,
            "phone"	=> substr(str_replace(array(" ", "-"), "", $hp),0,14),
            "contact" => strlen($contact) <  11 ?  $contact :  substr($contact,0,11).'..',
            "status" => $status,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "gambar" => $gambar,
            "avatar" => $gambar2,
            // "category" => $category == "" ? "FURNITURE" : $category,  
            "category" => $category,  
        );
        array_push($array_data, $itemDetails); 
    }
header('Content-Type: application/json');
echo json_encode($array_data);
}else {
    $array_data = array();
    $itemDetails=array(
            "id" => '1',
            "klasifikasi" => 'Not Found',
            "toko" => 'Not Found',
            "alamat" => 'Not Found',
            "phone"	=> 'Not Found',
            "contact" => 'Not Found',
            "status" => 'Not Found',
            "latitude" => 'Not Found',
            "longitude" => 'Not Found',
            "gambar" => 'noimage.jpg',
            "category" => 'Not Found',  
        );
    array_push($array_data, $itemDetails); 
    header('Content-Type: application/json');
    echo json_encode($array_data);
}
?>