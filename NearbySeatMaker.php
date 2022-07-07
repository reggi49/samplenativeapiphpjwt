<?php
include_once('../config.php');

if(isset($_GET['lat'])&&($_GET['long'])){
    $lat   = mysqli_real_escape_string($conn,$_GET['lat']);
    $long   = mysqli_real_escape_string($conn,$_GET['long']);
    $query = "select id,toko, alamat, hp, contact, status, latitude, longitude, gambar, gambar2, subklasifikasi AS category, distance from 
    (SELECT *, 
        (
            (
                (
                    acos(
                        sin(( $lat * pi() / 180))
                        *
                        sin(( `latitude` * pi() / 180)) + cos(( $lat * pi() /180 ))
                        *
                        cos(( `latitude` * pi() / 180)) * cos((( $long - `longitude`) * pi()/180)))
                ) * 180/pi()
            ) * 60 * 1.1515 * 1.609344
        )
        as distance FROM `data_pros`
    )data_pros where distance <= 15 AND (toko NOT LIKE '%cv%' AND klasifikasi NOT LIKE '%user%' )  AND (STATUS is NOT null AND status !='N') ORDER BY distance ASC LIMIT 5 ";
}
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
 $array_data = array();
//  $array_data["items"]=array(); 
 while($baris = mysqli_fetch_assoc($result))
    {
        // $array_data[]=$baris;
        extract($baris); 
        $itemDetails=array(
            "id" => $id,
            "toko" => $toko,
            "alamat" => $alamat,
            "phone"	=> substr(str_replace(array(" ", "-"), "", $hp),0,14),
            "contact" =>  strlen($contact) <  11 ?  $contact :  substr($contact,0,11).'..',
            "status" => $status,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "distance" => $distance,
            "gambar" => $gambar,
            "avatar" => $gambar2,
            "category" => $category == "" ? "FURNITURE" : $category,  
            // "category" => substr($category,0,5) == "FURNI" ? substr($category,0,5)."TURE" : substr($category,0,5)."",  
        );
        array_push($array_data, $itemDetails); 
    }
header('Content-Type: application/json');
echo json_encode($array_data);
}
?>