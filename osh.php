<?php

$d=1;
if(isset($_GET['d']))$d=$_GET['d'];

$url = "https://fastly.live.brightcove.com/6375380916112/us-west-2/627008079/eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJob3N0IjoibDhmNWk3LmVncmVzcy5obnljdWkiLCJhY2NvdW50X2lkIjoiNjI3MDA4MDc5IiwiZWhuIjoiZmFzdGx5LmxpdmUuYnJpZ2h0Y292ZS5jb20iLCJpc3MiOiJibGl2ZS1wbGF5YmFjay1zb3VyY2UtYXBpIiwic3ViIjoicGF0aG1hcHRva2VuIiwiYXVkIjpbIjYyNzAwODA3OSJdLCJqdGkiOiI2Mzc1MzgwOTE2MTEyIn0.cdIoChamG1S-xroVFo-QRPNxWxyISsNYIh-iw_WGXJw/";
$name = "chunklist_hls1080p.m3u8";

$start = 0;
$end = 0;

if($d==1){
    $start = 297425493;
    $end = 297445553;
}
elseif($d==2){
    $start = 297445554;
    $end = 297461676;
}
elseif($d==3){
    $url = "https://fastly.live.brightcove.com/6401832923112/us-west-2/627008079/eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJob3N0IjoibDhmNWk3LmVncmVzcy5obnljdWkiLCJhY2NvdW50X2lkIjoiNjI3MDA4MDc5IiwiZWhuIjoiZmFzdGx5LmxpdmUuYnJpZ2h0Y292ZS5jb20iLCJpc3MiOiJibGl2ZS1wbGF5YmFjay1zb3VyY2UtYXBpIiwic3ViIjoicGF0aG1hcHRva2VuIiwiYXVkIjpbIjYyNzAwODA3OSJdLCJqdGkiOiI2NDAxODMyOTIzMTEyIn0.T13DvhDf9Bzzd1GUzqZYL1dV6TSu4q0rHZvu3dnS-aU/";
    $start = 297455255;
//     $end = 297457005;
    
    $lastbits = trim(file_get_contents($url.$name));
    $lastnum=array_pop(explode("\n",$lastbits));
    $parts = explode("_",$lastnum);
    $num = explode(".",$parts[2]);
    $end = $num[0];
}
else{
    $start = 297461676;
    
    $lastbits = trim(file_get_contents($url.$name));
    $lastnum=array_pop(explode("\n",$lastbits));
    $parts = explode("_",$lastnum);
    $num = explode(".",$parts[2]);
    $end = $num[0];
}

header("Content-type: application/vnd.apple.mpegurl");

echo "#EXTM3U
#EXT-X-VERSION:3
#EXT-X-INDEPENDENT-SEGMENTS
#EXT-X-TARGETDURATION:6
#EXT-X-MEDIA-SEQUENCE:$start
#EXT-X-DISCONTINUITY-SEQUENCE:1";

while($end>=$start){
    echo "
#EXTINF:2.0,
".$url."media_hls1080p_$start.ts";
    $start++;
}
if($d==1 || $d==2)echo "\n#EXT-X-ENDLIST";  // || $d==3