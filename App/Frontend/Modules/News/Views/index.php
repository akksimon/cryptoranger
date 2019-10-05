<div class="banner" id="home">
	<h1 class="fontTitle"><strong><span>C</span>rypto<span>R</span>anger.</strong></h1>		
</div>
<div class="jumbotron-fluid">
	<p class="p-0 m-0">Sharing my ideas about <strong>cryptocurrencies</strong> and <strong>blockchain</strong> relative projects.</p>
</div>

<div class="container-fluid">
	<div class="row">
		<section class="col-lg-8 col-sm-12 blog" id="blog"> <!-- Start of recent articles -->	
					<div class="row gutter justify-content-center">		
						<div class="offset-sm-2 col-sm-8 bg-white category">
							<i class="fas fa-plus fa-3x float-left mr-3"></i>
							<h1 class="w-75">RECENT ARTICLES</h1>
							<p class="w-50 clearfix">Here are my latest post ! </p>
						</div>
					</div>
					<div class="row gutter">
						<?php
						foreach ($listeNews as $news){?>
						<div class="col-md-6 d-flex">
							<article class="blogpost border rounded flex-fill">
								<div class="imgBx">
									<img src="images/<?=$news['image'] ?>" alt="" class="img-fluid">
								</div>
								<div class="content">
                                  	<div class="newstitleindex">
									   <h2 class="itemrecent1"><?= $news['titre'] ?></h2>
                                   	   <p class="float-left m-0"><i class="fas fa-clock"></i>  <?= $news['dateAjout']->format('Y-m-d') ?></p><br>
                                 	</div>
									<p class="itemrecent1"><?= nl2br($news['contenu']) ?></p>
									<div><a href="news/<?php echo $generator->generate($news['titre']); ?>_<?= $news['id'] ?>" class="btn btnD1">Read</a></div>
                              </div>
							</article>
						</div>
						<?php } ?>   <!-- End of recent articles -->
					</div>
		</section>
		<aside class="col-lg-4 col-sm-12">
					<div class="row justify-content-center">
						<div class="col-sm-12 bg-white category">
							<i class="fas fa-plus fa-3x float-left mr-3"></i>
							<h1 class="w-75 text-no">FOLLOW ME ON TWITTER !</h1>
							<p class="w-50 clearfix">To get in touch about my charts and crypto relative tweets.</p>
						</div>
					</div>
					<div class="row justify-content-center">
						<div class="col-sm-12">
							<div class="row justify-content-center">
								<div class="col-lg-12 col-md-6">
									<div class="twitter">
										<a class="twitter-timeline" data-width="315" data-height="350" data-theme="dark" href="https://twitter.com/TheChartRanger?ref_src=twsrc%5Etfw">Tweets by TheChartRanger</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
									</div>
								</div>
								<div class="col-lg-8 col-md-6 col-sm-6">
									<h3 class="disclaimer text-center backcolor">DISCLAIMER</h3>
									<p>This website references an opinion and is for entertainment and informational purposes only. It is not intended to be investment advice.</p>
								</div>
							</div>
						</div>
					</div>
			</aside>
		</div>
	</div>
</div>


<section class="sec1" id="guides"> <!--'GUIDE / NEW TO CRYPTO ?' -->
	<div class="container">
		<div class="row">
			<div class="offset-sm-2 col-sm-8 bg-white recent">
				<i class="fas fa-plus fa-3x float-left mr-3"></i>
				<h1 class="w-75">GUIDES AND MORE</h1>
				<p class="w-50 clearfix">Crypto ecosystem, tech relative, trading crypto asset...</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="guideBx">
						<div class="imgBx">
							<img src="images/gettingstarted.png" alt="responsive image" class="round img-fluid">
						</div>
						<div class="content">
							<h3 class="itemstart">GETTING STARTED</h3>
							<p class="itemstart">These words will help you to get started with Cryptocurrency and the Blockchain Technology.</p>
							<a href="guides/getstarted" class="btn btnD1">See</a>
						</div>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="col-md-4">
				<div class="guideBx">
						<div class="imgBx">
							<img src="images/fundamentals.jpg" alt="responsive image" class="round img-fluid">
						</div>
						<div class="content">
							<h3 class="itemstart">FUNDAMENTALS</h3>
							<p class="itemstart">Fundamentals of <strong>Cryptocurrency and Blockchain</strong> to understand its revolutionary impact on the <strong>economy, society and institutions</strong>.</p>
							<a href="guides/fundamentals" class="btn btnD1">See</a>
						</div>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="col-md-4">
				<div class="guideBx">
						<div class="imgBx">
							<img src="images/trading.jpg" alt="responsive image" class="round img-fluid">
						</div>
						<div class="content">
							<h3 class="itemstart">TRADING</h3>
							<p class="itemstart">I'm not a pro, just a casual investor but i can share my thought of those years inside the crypto market.</p>
							<a href="guides/trading" class="btn btnD1">See</a>
						</div>
				</div>
				<div class="clearfix"></div>
			</div>
	<!-- End of 'GUIDE / NEW TO CRYPTO ?' -->
		</div>
	</div>
</section>