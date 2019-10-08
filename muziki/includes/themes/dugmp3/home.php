<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");

if ( isset( $_GET['searching'] ) ) {
  if ( $_GET['searching'] ) {
    redirect( search_permalink( $_GET['searching'] ) );
  } else {
    redirect( site_url() );
  }
}
delete_cache_json( get_cache_path() . '/home', 43200 );

$site_title = get_option( 'site_tagline' );
$meta_description = str_replace( [ '%site_name%', '%domain%' ], [ get_option( 'site_name' ), $_SERVER['HTTP_HOST']], get_option( 'home_description' ) );

$top_songs = agc()->get_itunes_top_songs();
$new_releases = agc()->get_itunes_new_releases();
?>
<?php include 'include/head.php'; ?> <!-- head -->
<div class="container">
	<div class="box">
		<div class="box-content">
			<div class="large-content">
				<h2>Top Songs</h2>
				<?php if ( $top_songs ) { ?>
				 	<?php foreach ( $top_songs as $item ) { ?>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="col-md-12 grid">
							<div class="col-xs-3">
								<div class="image" style="background-image:url(<?php echo photon_cdn($item['image']); ?>);"></div>
							</div>
							<div class="col-xs-9">
								<ul class="list-unstyled">
									<li class="grid-title"><span><b><i class="fa fa-check-square"></i></b> <b><?php echo htmlentities( $item['title'], ENT_QUOTES ); ?></b></span>
									</li>
									<li class="grid-artist"><b><i class="fa fa-user"></i></b><span><?php  echo $item['artist']; ?></span>
									</li>
									<li class="grid-download">
										<div class="mp3-dl"><a href="<?php echo search_permalink( $item['title'] ); ?>" title="Download <?php  echo htmlentities( $item['title'], ENT_QUOTES ); ?> Mp3 and Videos"><span><b><i class="fa fa-download"></i> DOWNLOAD</b></span></a>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				 	<?php 
					}
				} 
				?>
			</div>
			<div class="large-content">
				<h2>New Release</h2>
			 	<?php  if ( $new_releases ) { ?>
			 	<?php  foreach ( $new_releases as $item ) { ?>
			   	<div class="col-md-2 col-sm-6 col-xs-4">
					<div class="grid-album">
						<div class="panel panel-default">
							<div class="grid-album-image">
								 <a title="Download <?php  echo htmlentities( $item['title'], ENT_QUOTES ); ?> Mp3 and Videos" href="<?php  echo search_permalink( $item['title'] ); ?>"><img src="<?php echo photon_cdn($item['image']); ?>" alt="<?php  echo htmlentities( $item['title'], ENT_QUOTES ); ?>" class="img-responsive"></a>
							</div>
							<div class="panel-body">
								<div class="grid-album-title">
									<h3><a href="<?php  echo search_permalink($item['artist']); ?>"> <?php echo $item['artist']; ?></a></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			   	<?php } ?>
			   	<?php } ?>		
			</div>

			</div>
		</div>
	</div>