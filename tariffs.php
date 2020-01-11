<?
define("URL", "https://www.sknt.ru/job/frontend/data.json");

$ch = curl_init(URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);
$data = json_decode($res, true);

//В ответе на одном из масивов была неверная последовательность данных, подправил сортировкой
array_multisort($data['tarifs'][0]['tarifs']);

$res = json_encode($data );

echo $res;
?>