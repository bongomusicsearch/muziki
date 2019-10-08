<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");
return [
  '/' => [ 'name' => 'home', 'file' => 'home.php' ],
  'search/([^/_~!#$&*()+={}\[\]|;,]+)' => [ 'name' => 'search', 'file' => 'search.php' ],
  'download/([^/_~!#$&*()+={}\[\]|;,]+)-([^/_~!#$&*()+={}\[\]|;,]+)' => [ 'name' => 'download', 'file' => 'download.php' ],
  'play/([^/_~!#$&*()+={}\[\]|;,]+)-([^/_~!#$&*()+={}\[\]|;,]+)' => [ 'name' => 'play', 'file' => 'play.php' ],
  'file' => [ 'name' => 'file', 'file' => 'file.php' ],
  'sitemap/searches.xml' => [ 'name' => 'sitemap-searches', 'file' => 'sitemap.php' ],
  'sitemap/keywords.xml' => [ 'name' => 'sitemap-keywords', 'file' => 'sitemap.php' ],
  'sitemap/keyword/([0-9-]+).xml' => [ 'name' => 'sitemap-keyword', 'file' => 'sitemap.php' ],
  'sitemap/downloads.xml' => [ 'name' => 'sitemap-downloads', 'file' => 'sitemap.php' ],
  'sitemap/download/([0-9-]+).xml' => [ 'name' => 'sitemap-download', 'file' => 'sitemap.php' ],
  'sitemap/play/([0-9-]+).xml' => [ 'name' => 'sitemap-play', 'file' => 'sitemap.php' ],
  'sitemap/plays.xml' => [ 'name' => 'sitemap-plays', 'file' => 'sitemap.php' ],
  'sitemap.xml' => [ 'name' => 'sitemap-index', 'file' => 'sitemap.php' ],

  //DISCLAIMER & TOS PAGE
  'tos' => ['name' => 'tos', 'file' => 'tos.php'],
  'disclaimer' => ['name' => 'disclaimer', 'file' => 'disclaimer.php'],
  //gsm route
  'phone' => ['name' => 'phone', 'file' => 'phone.php'],
  //Billboard - The Hot 100 Chart
  'billboard' => ['name' => 'billboard', 'file' => 'billboard.php'],
  //Itunes Top Song 50
  'itunestopsongs' => ['name' => 'itunestopsongs', 'file' => 'itunestopsongs.php'],
  //Lirik
  'lyrics' => ['name' => 'lyrics', 'file' => 'lyrics.php'],
];
