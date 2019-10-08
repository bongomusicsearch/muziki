<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");
$recent = get_recent_user_access( get_option( 'recent_searches_count' ) );
$host =  $_SERVER['HTTP_HOST'];
$site_title = 'Term Of Service '.get_option( 'site_tagline' );
$meta_description =  'Term Of Service '.get_option( 'site_tagline' ).' '.get_option( 'home_description' );
$meta_robots = get_option( 'download_robots' );
?>
<?php include 'include/head.php'; ?> <!-- head -->

<div class="container">
	<div class="box">
		<div class="box-content">
			<div class="large-content">
				<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="content white" style="width: 590px;padding: 10px;">
      				<h1>Term Of Service</h1>
					<strong>Personal Information</strong>
					<p>
					<?php echo $host; ?> is committed to protecting your privacy online. We are also committed to providing you with the very best experience we can on our web site. In order to enhance your experience at our sites we gather certain personal information about you that helps us customize our content to your tastes and preferences. We may ask for your name, e-mail address, zip code, and country. The more information you share with us (and the more accurate it is), the better we are able to enhance and customize your experience on our sites. 
					</p>
					<p>
					By using our web site, you consent to the collection and use of your personal information by <?php echo $host; ?> as outlined in this privacy policy. <?php echo $host; ?> does not sell, rent, or trade your personal information with others unless specified.
					</p>
					<br>
					<strong>IP address and logging</strong>
					<p>
					Your IP address is used to gather broad demographic information and to track your general visiting paterns (how many pages you view while at one website, downloads, etc). 
					</p>
					<br>
					<strong>Third Party Advertising</strong>
					<p>
					We use third-party advertising companies to serve ads when you visit our Web site. These companies may use aggregated information (not including your name, address, email address or telephone number) about your visits to this and other Web sites in order to provide advertisements about goods and services of interest to you. If you would like more information about this practice and to know your choices about not having this information used by these companies, <a href="http://www.networkadvertising.org/managing/opt_out.asp" target="_blank" rel="nofollow">click here</a>
					</p>
					<br>
					<strong>Cookies</strong>
					<p>
					Some ads displayed may come from our servers. Ads loading from our servers may also contain cookies, the purpose of these cookies is just to introduce and select the proper advertisements to be shown for your interests. We only have access to information of visiting frequencies of our visitors from cookies you might receive while viewing ads from our servers. 
					</p>
					<br>
					<strong>Third Party Cookies</strong>
					<p>
					In the course of serving advertisements to this site, our third-party advertiser may place or recognize a unique cookie on your browser.</p>
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