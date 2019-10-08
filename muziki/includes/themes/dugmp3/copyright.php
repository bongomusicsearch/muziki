<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");
$recent = get_recent_user_access( get_option( 'recent_searches_count' ) );
$host =  $_SERVER['HTTP_HOST'];
$site_title = 'Copyright '.get_option( 'site_tagline' );
$meta_description =  'Copyright '.get_option( 'site_tagline' ).' '.get_option( 'home_description' );
$meta_robots = get_option( 'download_robots' );
?>
<?php include 'include/head.php'; ?> <!-- head -->

<div class="container">
	<div class="box">
		<div class="box-content">
			<div class="large-content">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<div class="content white" style="width: 590px;padding: 10px;">
						<h1>Copyright</h1>
						<strong>Introduction</strong>
						<p>
						As part of our mission to index and organize music that has been legally posted on the Internet, <?php echo $host; ?> is committed to copyright protection. Our search engine is a continuously growing and changing index of links to music files posted on the Internet for promotional or other lawful purposes.
						</p>
						<p>
						<?php echo $host; ?> encourages its users to purchase the music they hear on our site by, among other things, including hyperlinks to Amazon.com &amp; Mp3va.com with search results. In most cases, our users can easily and legally buy the music they find on <?php echo $host; ?>.
						</p>
						<br>
						<strong>Licenses and Legal Issues</strong>
						<p>
						<?php echo $host; ?> is an information location tool that helps you find and enjoy music legally posted by others on the Internet. We are committed to organizing all the music posted on the Internet for promotional and other legal purposes to serve artists and their fans in the new digital age. We are also committed to respecting the legitimate interests of copyright owners. Therefore, where possible, <?php echo $host; ?> negotiates reasonable copyright licenses that also respect the public's legitimate interest in gaining access to public information and preserving the freedom and functionality of the Internet.
						</p>
						<p>
						<?php echo $host; ?> pays performance royalties to <strong>ASCAP</strong>, <strong>BMI</strong> and <strong>SESAC</strong>, the biggest three performance rights organizations ("PSOs") based in the United States. These three PSOs have reciprocal agreements with PSOs throughout the world. The creators and publishers of the songs you hear through <?php echo $host; ?> are being paid a royalty for their work if they are members of ASCAP, BMI or SESAC or any one of over 125 other PSOs that represent songwriters and music publishers around the world. The more a song is streamed/played through our music player, the more royalties the writer and publisher of that song are paid by us. <?php echo $host; ?> also respects the choices of performing artists as to when and where they want their music heard. Some performing artists make their music freely available on the web (see by way of example and not limitation: trade-friendly artists, creative commons licenses, and netlabels); others allow you to listen to only a few freely available songs through a promotional site; and a few would prefer that none of their music be heard on the web at all. If an artist or the artist's authorized agent advises us that our search engine is linking to a music file that was posted without authorization by providing us with a legally effective take down notice, we take down the link to that music file in accordance with law and the procedures discussed below.
						</p>
						<p>
						By enabling our users to find songs posted for promotional and other legal uses, <?php echo $host; ?> supports performing artists. We make it easy to discover new music and we make it easy to buy the song, once a listener has heard it. We believe we have created a tool for artists and record labels to promote new music to the new Internet generation. 
						</p>
						<br>
						<strong>Information Concerning Copyright Claims</strong>
						<p>
						As part of our mission to develop the most complete searchable index of music files legally posted on the Internet for promotional and other legal purposes, our search crawler continuously crawls the Internet for new, legally posted music files. We are, however, primarily an information location tool, and we maintain no editorial oversight over the links in our search index. We do not control the third party websites contained in our index. We are not a "file sharing" site, peer to peer or otherwise; and we in no way support or endorse illegal copying of music. Because we do not own or have editorial control over these third party sites, it is possible that our index may link to some music files that were posted without the copyright owner's authorization.
						</p>
						<p>
						We rely on copyright owners to protect their own copyright interests by communicating with us. We will immediately take down the link in response to a valid notice of alleged infringement submitted under the Digital Millennium Copyright Act ("DMCA"). We urge copyright owners to directly contact any third party website that has posted an infringing music file. The link in the <?php echo $host; ?> index only points to the location of the file hosted elsewhere on the web. Accordingly, while <?php echo $host; ?> can and does delete the link from its search engine upon request, it does not, because it cannot, delete the infringing file, which was posted and is hosted on the Internet by a third party over which <?php echo $host; ?> has no control. We recommend that you use our search engine to identify the third party who posted and is hosting the infringing file, and to contact that third party to delete the infringing music file itself from the Internet prior to having us remove the link.
						</p>
						<br>
						<strong>Digital Millennium Copyright Act</strong>
						<p>
						It is our policy to respond immediately to clear notices of alleged copyright infringement. This page describes the information that should be present in these notices. This procedure is designed to make submitting notices of alleged infringement to <?php echo $host; ?> as straightforward as possible, while reducing the number of notices that we receive that are fraudulent or difficult to understand or verify. The form of notice specified below is consistent with the form required by the United States law (an official summary of which can be found at the U.S. Copyright Office Web Site, http://www.copyright.gov/legislation/dmca.pdf), but we will respond to notices of this form from other jurisdictions as well. We suggest that you consult your legal advisor before filing a notice. Also, please be aware that there are penalties (including costs and attorney's fees) for false claims under the DMCA. See <a href="http://www.chillingeffects.org/dmca512/faq.cgi" target="_blank">http://www.chillingeffects.org/dmca512/faq.cgi</a> for more details.
						</p>
						<p>
						<br>
						<strong>Infringement Notification</strong>
						</p><p>
						To file a notice of infringement with us, you must provide to the <?php echo $host; ?> Copyright Agent designated below a written communication (an email, that includes each of the items specified below:
						</p>
						<p>
						<strong>[1]</strong> an electronic or physical signature of the person authorized to act on behalf of the owner of the copyright interest (a Word or PDF document highly recommended);
						<br>
						<strong>[2]</strong> a description of the copyrighted work that you claim has been infringed, identification of the time(s), date(s) and link(s) the material that you claim is infringing was displayed on the <?php echo $host; ?> website or service, and any other information that is reasonably sufficient for <?php echo $host; ?> to locate the material;
						<br>
						<strong>[3]</strong> your address, telephone number, and email address;
						<br>
						<strong>[4]</strong> a statement by you that you have a good faith belief that the disputed use is not authorized by the copyright owner, its agent, or the law; and
						<br>
						<strong>[5]</strong> a statement by you, made under penalty of perjury, that the above information in your notice is accurate and that you are the copyright owner or authorized to act on the copyright owner's behalf.
						</p>
						<p>
						Please note that you will be liable for damages (including costs and attorneys' fees) if you materially misrepresent that a product or activity infringes one of your copyrights. Accordingly, if you are not sure whether your material is protected by copyright laws, we suggest that you first seek the assistance of an attorney.
						</p>
						<p>
						Contact Email : <u><strong></strong></u>
						</p>
						<br>
						<strong>Counter-Notification to Claimed Copyright Infringement</strong>
						<p>
						If <?php echo $host; ?> has removed or disabled material due to a claim of copyright infringement and you believe that material to be yours, you may elect to make a counter-notification to the <?php echo $host; ?> Copyright Agent. When we receive a counter notification, we will reinstate the material in question unless the copyright owner files suit regarding the allegedly infringing content.
						<br>A counter-notification must sent by email, and must contain the following information:
						</p>
						<p>
						<strong>[1]</strong> an electronic or physical signature of the person authorized to act on behalf of the owner of the copyright interest (a Word or PDF document highly recommended);
						<br>
						<strong>[2]</strong> a description of the copyrighted work that you claim has been removed or to which access has been disabled, and the web site address or other location at which the material appeared before it was removed or access to it was disabled;
						<br>
						<strong>[3]</strong> your address, telephone number, and email address;
						<br>
						<strong>[4]</strong> a statement by you, under penalty of perjury, that you have a good faith belief that the material was removed or disabled as a result of a mistake or misidentification of the material; and
						<br>
						<strong>[5]</strong> a statement by you that you consent to the jurisdiction of the Federal District Court for the judicial district in which the Copyright Agent is located, or, if you reside outside the United States, for any judicial district in which <?php echo $host; ?> may be found, and that you will accept service of process from the person who provided the original copyright infringement notification or an agent of that person.
						</p><p>
						Please note that you will be liable for damages (including costs and attorneys' fees) if you materially misrepresent that a product or activity infringes one of your copyrights. Accordingly, if you are not sure whether your material is protected by copyright laws, we suggest that you first seek the assistance of an attorney.
						</p>
						<p>
						Contact Email : <u><strong></strong></u>
						</p>
						<br>
						<strong>Repeated Infringements</strong>
						<p>
						It is our policy to promptly terminate without notice the accounts of those users determined by us, in our sole discretion, to be "repeat infringers" of others' copyrights.
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
				</div>
			</div>
		</div>
	
	</div>
</div>
<?php include 'include/footer.php'; ?>