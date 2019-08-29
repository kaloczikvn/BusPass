<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
?>
<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="KVN">
    <title>BusPass by KVN</title>
    <link href="webfonts/font.css" rel="stylesheet">
    <link href="css/style.css?v=4" rel="stylesheet">
    <link rel="manifest" href="manifest.json" />
    <link rel="apple-touch-icon" sizes="57x57" href="img/favico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/favico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favico/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffc40d">
  </head>
  <body>
    <nav>
        <img src="img/logo@2x.png" width="150" height="38">
    </nav>
    <div id="notification" class="notification hidden">
      No realtime GPS data found.
    </div>

    <div id="bus_menu_div" class="hidden">
      <h2 id="bus_label">Select a bus</h2>
      <ul class="navbar-nav ml-auto">
        <?php
        $bus_lines = [
          '1' => 'Gyirmót - Ménfőcsanak - Marcalváros - Pápai út - Belváros - Újváros, Nép utca',
          '1A' => 'Marcalváros - Pápai út - Belváros - Újváros, Nép utca',
          '2' => 'Révai Miklós utca - Zrínyi utca - Zöld utca, Szőnyi Márton utca',
          '2B' => 'Zöld utca, Szőnyi Márton utca - Zrínyi utca - Sziget - Egyetem - Révai Miklós utca',
          '5' => 'Révai Miklós utca - Kismegyer',
          '5B' => 'Révai Miklós utca (- Raktárváros) - Agroker - Kismegyer',
          '5R' => 'Révai Miklós utca - Raktárváros - Kismegyer',
          '6' => 'Sárás - Egyetem - Dunakapu tér - Városrét - Belváros - Kismegyer',
          '7' => 'Révai Miklós utca - Fehérvári út - Szabadhegy - Adyváros - Virágpiac',
          '8' => 'Likócs - Gyárváros - Belváros - Aqua sportközpont - Pinnyéd',
          '8B' => '(Likócs - Gyárváros -) Belváros - Korányi tér - Aqua sportközpont - Pinnyéd',
          '9' => 'Egyetem - Sziget - Belváros - Kollégium - Adyváros - Révai Miklós utca',
          '9A' => 'Virágpiac - Kollégium - Adyváros - Virágpiac',
          '10' => 'Autóbusz-állomás - Víziváros - Bácsa, vámosszabadi elágazás',
          '11' => 'Marcalváros - Adyváros - Belváros - Sziget - Egyetem - Bácsa, Ergényi lakótelep',
          '11Y' => 'Marcalváros - Adyváros - Belváros - Bácsa, Ergényi lakótelep',
          '12' => 'Révai Miklós utca - Kandó utca - AUDI gyár, 5-ös porta',
          '12A' => 'Révai Miklós utca - Kandó utca - AUDI gyár, 8-as porta',
          '14' => 'Marcalváros - Adyváros - Gyárváros - Belváros - Liget utca, Nyár utca',
          '14B' => 'Marcalváros - Temető - Adyváros - Gyárváros - Belváros - Liget utca, Nyár utca',
          '15' => 'Révai Miklós utca - Gyárváros - AUDI gyár - Ipari Park - Révai Miklós utca',
          '15A' => 'Révai Miklós utca - Gyárváros - AUDI gyár, 5-ös porta',
          '17' => 'Virágpiac - Adyváros - Szabadhegy - Fehérvári út - Révai Miklós utca',
          '17B' => 'Virágpiac - Adyváros - Új köztemető - Fehérvári út - Révai Miklós utca',
          '19' => 'Révai Miklós utca - Adyváros - Kollégium - Belváros - Sziget - Egyetem',
          '19A' => 'Virágpiac - Adyváros - Kollégium - Virágpiac',
          '20' => 'Zöld utca, Soproni út - Adyváros - Gyárváros - AUDI gyár, 8-as porta',
          '20Y' => 'Ménfőcsanak, Győri út - Új élet út - Adyváros - Gyárváros - AUDI gyár, 8-as porta',
          '21' => 'Révai Miklós utca - Nádor tér - Marcalváros - Ménfőcsanak, Győri út (- Új élet út)',
          '21B' => 'Révai Miklós utca - Nádor tér - Marcalváros - Győzelem utca - Győri út',
          '22' => 'Révai Miklós utca - Marcalváros - Új élet út - Ménfőcsanak, Győri út',
          '22A' => 'Révai Miklós utca - Marcalváros',
          '22B' => 'Révai Miklós utca - Marcalváros - Új élet út - Győri út (- Győzelem utca)',
          '22Y' => 'Révai Miklós utca - Marcalváros - Ménfőcsanak, Győzelem utca',
          '23' => 'Marcalváros - Adyváros - Gyárváros - Győrszentiván, Kálmán Imre út',
          '23A' => 'Marcalváros - Adyváros - Ipar utca, ÉNYKK Zrt.',
          '24' => 'Marcalváros - Adyváros - AUDI gyár, 5-ös porta',
          '25' => 'Marcalváros - Adyváros - Ipari Park',
          '26' => 'Marcalváros - Szabadhegy - Ipari Park',
          '27' => 'Autóbusz-állomás - Szabadhegy - Fehérvári út 206.',
          '28' => 'Marcalváros - Adyváros - Ipari Park - LOC1 - LOC2 logisztikai csarnok',
          '29' => 'Révai Miklós utca - Sziget - Egyetem',
          '30' => 'Révai Miklós utca - Győrszentiván, Kálmán Imre út - Homoksor',
          '30A' => 'Révai Miklós utca - Győrszentiván, Kálmán Imre út',
          '30B' => 'Révai Miklós utca - Ipari Park - Győrszentiván, Kálmán Imre út',
          '30Y' => 'Révai Miklós utca - AUDI gyár - Ipari Park - Győrszentiván, Kálmán Imre út',
          '31' => 'Révai Miklós utca - Győrszentiván, Homoksor - Kálmán Imre út',
          '31A' => 'Révai Miklós utca - Győrszentiván, Homoksor',
          '32' => 'Autóbusz-állomás - Adyváros - Temető - Ménfőcsanak, Hegyalja utca',
          //'34' => 'Autóbusz-állomás - Adyváros - Temető - Ménfőcsanak, Sokorópátkai út',
          //'36' => 'Autóbusz-állomás - Adyváros - Temető - Ménfőcsanak, Koroncói úti telep',
          '37' => 'Révai Miklós utca - Adyváros - Temető - Ménfőcsanak - Gyirmót',
          //'37T' => 'Temetőjárat: Marcalváros - Temető - Adyváros - Zechmeister utca',
          '38' => 'Révai Miklós utca - Adyváros - Szabadhegy - Ipari Park',
          '38A' => 'Révai Miklós utca - Adyváros - Szabadhegy - Ipari Park',
          '41' => 'Zöld utca, Soproni út - Adyváros - Honvédség',
          '42' => 'Marcalváros - Belváros - Honvédség',
          '900' => 'Autóbusz-állomás - Adyváros - Marcalváros - Ménfőcsanak, Hegyalja utca',
          'CITY' => 'Belvárosi körjárat: Egyetem - Városrét - Munkácsy Mihály utca - Egyetem',
        ];

        foreach ($bus_lines as $bus_line => $name) { ?>
          <a href="#" class="grid bus-select" data-id="<?php echo $bus_line; ?>">
            <div class="span-row-2"><?php echo $bus_line; ?></div>
            <div class="title">
              <?php
                $name_arr = get_new_name($name);
                echo $name_arr[0] . ' ' . $name_arr[1] . ' ...';
              ?>
              <div class="sub-title"><?php echo $name; ?></div>
            </div>
          </a>
        <?php
        }
        ?>
      </ul>
    </div>

    <div class="map-container">
      <div id="map" style="height: 100%; width: 100%;"></div>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
      <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-realtime/2.1.1/leaflet-realtime.min.js"></script>
    </div>

    <div class="bus-selector"></div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/js.cookie.js"></script>
    <script src="js/map-script.js?v=3"></script>
  </body>
</html>

<?php
function get_new_name($name) {
  $new_name = str_replace('- ', '', $name);
  $new_name = str_replace(',', '', $new_name);
  $new_name = str_replace(':', '', $new_name);
  return explode(' ', $new_name);
}
