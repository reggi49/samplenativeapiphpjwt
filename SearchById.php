<?php
include_once('../config.php');
if(isset($_GET['id'])){
    $q   = mysqli_real_escape_string($conn,$_GET['id']);
    $query = "select id, klasifikasi,toko, alamat, hp, contact, status, latitude, longitude, gambar, gambar2, subklasifikasi AS category from data_pros where id = '".$q."'";
}
if(isset($_GET['cari'])&&($_GET['cari'])){
    $q   = mysqli_real_escape_string($conn,$_GET['cari']);
    $k   = mysqli_real_escape_string($conn,$_GET['kat']);
    $query = "select id, klasifikasi,toko, alamat, hp, contact, status, latitude, longitude, gambar, gambar2, subklasifikasi AS category from data_pros where (toko like '%".$q."%' AND klasifikasi like '%".$k."%') AND (toko NOT LIKE '%cv%' AND klasifikasi NOT LIKE '%user%' )  AND (STATUS is NOT null AND status !='N') ORDER BY status LIMIT 50 ";
}
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
while($baris = mysqli_fetch_assoc($result))
{
    extract($baris); 
    //  if ($category == "MOTOR" || $category == "MOBIL")
    //     {
    //         $category = "JOK " .$category;
    //     } 
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
        "category" => $category,  
        // "category" => $category == "" ? "FURNITURE" : $category,  
    );
    header('Content-Type: application/json');
    echo json_encode($itemDetails);
}
}else {
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
    header('Content-Type: application/json');
    echo json_encode($itemDetails);
}
?>