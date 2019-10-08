<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");

if ( $redirect = badword_redirect() ) {
  redirect( $redirect );
}
dmca_redirect();

delete_cache_json( get_cache_path() . '/single', 86400 );
$result = agc()->get_search();
$recent = get_recent_user_access( get_option( 'recent_searches_count' ) );
$size = ( isset( $result[0]['size'] ) ) ? $result[0]['size'] : '';

$site_title = str_replace( [ '%query%', '%domain%' ], [ get_search_query(), $_SERVER['HTTP_HOST'] ], get_option( 'search_title' ) );
$meta_description = str_replace( [ '%query%', '%domain%' ], [ get_search_query(), $_SERVER['HTTP_HOST'] ], get_option( 'search_description' ) );
$fafifu_text = str_replace(['%query%','%site_name%'], [ '<strong>'.get_search_query().'</strong>', $_SERVER['HTTP_HOST'] ], get_option( 'fafifu_search' ) );
?>
<?php include 'include/head.php'; ?> <!-- head -->

<div class="container">
	<div class="box">
		<div class="box-content">
			<div class="large-content">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<h1><?php echo get_search_query(); ?> Mp3 Download</h1>
					<div class="item">Free download <?php echo get_search_query(); ?> Mp3. We have about <?php echo count($result); ?> matching results to play and download. If the results do not contain the songs you were looking for please try to find the song by the name of the artist or by the name of the song.</div>
					<div>
						<center>
							<!-- ADS -->
						</center>
					</div>
					<?php if ( $result ): ?>
					<?php foreach ( $result as $item ) { ?>
						<div class="item">
						<div class="col-md-3 col-sm-3 col-xs-12">
						<img src="<?php echo photon_cdn($item['image']); ?>" alt="<?php echo htmlentities( $item['title'], ENT_QUOTES ); ?>" />
						</div>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="clearfix"></div>
							<p><strong><?php echo ucwords(strtolower($item['title'])) ; ?></strong>
								<br>Play and download <?php echo ucwords(strtolower($item['title'])) ; ?> mp3 for free</p>
							<hr />
							<div class="button">
								 <a rel="nofollow" title="Download <?php echo htmlentities( $item['title'], ENT_QUOTES ); ?> Mp3 and Videos" href="<?php echo download_permalink( $item['title'], $item['source'] . '--' . $item['id'] ); ?>">Download</a>
							</div>
							<div class="clearfix"></div>
						</div>
						</div>
					<?php } unset( $item ); ?>
					<?php endif ?>
									

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
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'include/footer.php'; ?>