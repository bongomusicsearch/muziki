<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");

dmca_redirect();

delete_cache_json( get_cache_path() . '/downloads', 43200 );

$result = agc()->get_download();
$recent = get_recent_user_access( get_option( 'recent_searches_count' ) );
if ( $result ) {
  $site_title = str_replace( [ '%title%', '%duration%', '%domain%','%size%'], [ $result['title'], $result['duration'], $_SERVER['HTTP_HOST'], $result['size'] ], get_option( 'download_title' ) );
  $meta_description = str_replace( [ '%title%', '%duration%', '%domain%','%size%' ], [ $result['title'], $result['duration'], $_SERVER['HTTP_HOST'], $result['size'] ], get_option( 'download_description' ) );
  $meta_robots = get_option( 'download_robots' );

  if ( $result['source'] == 'sc' ) {
      $audio_url = agc()->get_soundcloud_stream_url( $result['id'], $result['client_id'] );
      $result['audio_url'] = $audio_url;
    }
  } else {
  redirect( site_url() );
}

$fafifu_text_download = str_replace(['%query%','%site_name%','%query_em%'], [ '<strong>'.get_search_query().'</strong>', $_SERVER['HTTP_HOST'], '<em>'.get_search_query().'</em>'], get_option( 'fafifu_download' ) );
?>
<?php include 'include/head.php'; ?> <!-- head -->

<div class="container">
	<div class="box">
		<div class="box-content">
			<div class="large-content">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<h1><?php echo get_search_query(); ?></h1>
					<div class="item">
						<?php if ( $result['source'] == 'yt' ): ?>
							<iframe width="100%" height="360" src="//www.youtube.com/embed/<?php echo $result['id']; ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen=""></iframe>
						<?php else: ?>
							<?php if (isset($result['audio_url'])): ?>
								<audio style="width: 100%;" src="<?php echo $result['audio_url']; ?>" preload='none' controls></audio>	
							<?php endif ?>
							
						<?php endif ?>						
						<div class="clearfix"></div>
						<?php if ( $result['source'] == 'sc' && isset( $result['audio_url'] ) ) : ?>
						<div class="mp3-dl" style="text-align: center;">
							<a href="<?php echo file_permalink() . '?u=' . base64_url_encode( $result['audio_url'] ) . '&ti=' . urlencode( $result['title'] ) . '&s=1&ty=mp3'; ?>"><span><b><i class="fa fa-download"></i> DOWNLOAD</b></span></a>
						</div>
						<?php else: ?>
						<div class="mp3-dl" style="text-align: center;">
							<iframe frameborder="0" height="50px" src="https://y-api.org/button/?v=<?php echo $result['id']; ?>&f=mp3&t=0&fc=#ffffff&bc=#d04e38">
              				</iframe>
						</div>
						<?php endif ?>		
						<div class="clearfix"></div>
					</div>
					<div>
						<center>
							<img src="http://via.placeholder.com/468x60" alt="ADS">
						</center>
					</div>
					<div class="item download-item">
						<br>
						<p>On this page you can listen and download <?php echo $result['title']; ?> Mp3 for promotional and evaluation purposes only, You MUST remove a song from the computer after listening. Please read our disclaimer carefully before download MP3 files. <?php echo $_SERVER['HTTP_HOST']; ?> DO NOT host any <?php echo $result['title']; ?> music, mp3, song, video, mp4 files in our server.</p>
						<p><strong>Note:</strong> 
						<?php if ($result['source'] == 'yt'): ?>
							This file is hosted on Youtube.com NOT on <?php echo $_SERVER['HTTP_HOST']; ?> server and we do not upload the file. If you think this is an illegal file please report to <a href="https://www.youtube.com/reportabuse" rel="nofollow">Youtube</a> with url https://www.youtube.com/watch?v=<?php echo $result['id']; ?>
						<?php else: ?>
							This file is hosted on SoundCloud.com NOT on <?php echo $_SERVER['HTTP_HOST']; ?> server and we do not upload the file. If you think this is an illegal file please report to <a href="https://soundcloud.com/pages/copyright/report" rel="nofollow">Report Copyright Infringement on SoundCloud</a> with url <?php echo $result['permalink_url']; ?>
						<?php endif ?>
							</p>
					</div>

				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
			      <?php if ($recent): ?>
			      	<div class="sidebar">
						<h2><?php echo $lang['last_term']; ?></h2>
						<ul class="chart">
							<?php foreach ($recent as $item): ?>
								<li><a href="<?php echo search_permalink( $item['title'] ); ?>"><?php echo substrwords($item['title'],'60'); ?></a>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
			      <?php endif ?>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php include 'include/footer.php'; ?>