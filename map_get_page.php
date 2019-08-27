<?php
include_once('vendor/simple_html_dom.php');
include_once('buses.php');

$finished_bus_array = [];
$url_string = 'http://webgyor.enykk.hu/php/sql.php?varos=1&id=online_buszok|';

$buses = [];

if(isset($_GET['bus']) && !empty($_GET['bus'])) {
  $bus_list = explode(',', $_GET['bus']);
  foreach ($bus_list as $key => $bus) {
    foreach ($bus_array[$bus] as $key => $value) {
      $finished_bus_array[] = $value;
    }
  }
}

$buses[] = file_get_html($url_string . join(',', $finished_bus_array));


$response = [
    'type' => "FeatureCollection",
    'crs' => [
        "type" => "name",
        "properties" => [
            "name"=> "urn:ogc:def:crs:OGC:1.3:CRS84"
        ]
    ],
    "features" => [],
];

if(isset($buses) && !empty($buses)) {
  foreach ($buses as $bus) {
    $bus = str_replace('nyomvon_id|GH|GV|datum|vonalvezetes_leiras|ST|kocsiall_id|nyomvonal|irany|tipus ', '', $bus);
    $businfo = explode('|', $bus);

    if(isset($businfo) && !empty($businfo) && $businfo[0] != '') {
        $new_arr = [
            "geometry" => [
                "coordinates" => [
                    $businfo[1], //lng
                    $businfo[2], //lat
                ],
                "type" => "Point"
            ],
            "type" => "Feature",
            "properties" => [
                "geometry/coordinates/longitude" => $businfo['1'],
                "geometry/type" => "Point",
                "mmsi" => $businfo['0'],
                "geometry/coordinates/latitude" => $businfo['2'],
                "name" => $businfo['7'] . '- ' . $businfo['4'],
                "type" => "Feature",
                "icon" => str_replace( ' ', '', $businfo['7'] ),
            ]
        ];
        array_push($response['features'], $new_arr);

        if(count($businfo) >= 11) {
            $new_arr = [
                "geometry" => [
                    "coordinates" => [
                        $businfo['10'], //lng
                        $businfo['11'], //lat
                    ],
                    "type" => "Point"
                ],
                "type" => "Feature",
                "properties" => [
                    "geometry/coordinates/longitude" => $businfo['10'],
                    "geometry/type" => "Point",
                    "mmsi" => $businfo['15'],
                    "geometry/coordinates/latitude" => $businfo['11'],
                    "name" => $businfo['16'] . '- ' . $businfo['13'],
                    "type" => "Feature",
                    "icon" => str_replace( ' ', '', $businfo['16'] ),
                ]
            ];
            array_push($response['features'], $new_arr);
        }
    }
  }
}

echo json_encode($response);
?>
