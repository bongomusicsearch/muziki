<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");
$recent = get_recent_user_access( get_option( 'recent_searches_count' ) );
$host =  $_SERVER['HTTP_HOST'];
$site_title = 'Disclaimer '.get_option( 'site_tagline' );
$meta_description =  'Disclaimer '.get_option( 'site_tagline' ).' '.get_option( 'home_description' );
$meta_robots = get_option( 'download_robots' );
?>
<?php include 'include/head.php'; ?> <!-- head -->

<div class="container">
	<div class="box">
		<div class="box-content">
			<div class="large-content">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="content white" style="width: 590px;padding: 10px;">
					<h1>Disclaimer</h1>
						<ol>
							<li><?php echo $host; ?> DOES NOT HOST any of the songs displayed on this site. We are 
							completely aware of copyright infringement.</li>
							<li><?php echo $host; ?> indexes these files which are located on remote servers which 
							neither <?php echo $host; ?> nor it's affiliates have any connection with / control of 
							/ association with.</li>
							<li>You download MP3 files from another host service. (Not From <?php echo $host; ?>)</li>
							<li>All music on is presented only for fact-finding listening.</li>
							<li>You MUST remove a song from the computer after listening.</li>
							<li>If You won't delete files from the computer, You'll break the copyrights 
							protection laws.</li>
							<li>All the rights on the songs are the property of their respective owners.</li>
							<li>By using this site you agree to have read and understood our Terms Of 
							Service.</li>
							<li> We are just a SEARCH ENGINE, but we respect an Copyright Laws. So if You have 
							found the link to an illegal mp3 file, please contact us via
							 and we'll try to 
							contact the site hosting it to remove it.</li>
						</ol>

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
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php include 'include/footer.php'; ?>