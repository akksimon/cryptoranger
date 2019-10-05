<div class="minijumbo"></div>
<figure class="center-block mt-3">
	<img src="/images/<?php echo $category . 'back.jpg'; ?>" class="imgback img-fluid ">
</figure>
<section class="container mt-3" id="ancre">	
	<div class="row">		
		<div class="offset-sm-2 col-sm-8 bg-white category">
			<i class="fas fa-plus fa-3x float-left mr-3"></i>
				<h1>CATEGORY : <span class="backcolor"><?= strtoupper($category) ?></span></h1>
				<?php
				switch ($category) {
					case 'trading':
						?><p class="clearfix">Please note this is not financial advice.</p><?php
						break;
					case 'fundamentals':
						?><p class="clearfix">Fundamental is the strongest things to learn in crypto. You should be aware of that space, new tech are volatiles and you need to prepare before joining the space.</p><?php
						break;
					case 'getstarted':
						?><p class="clearfix">Some guides and experience i can share...</p><?php
						break;
					default:
						# code...
						break;
				}?>
			<p class="w-50 clearfix"></p>
		</div>
	</div>
	<div class="row bg-light"> 
    <?php
    foreach ($newsList as $news){?>
    <div class="col-lg-4 d-flex">
      <article class="blogpost border rounded flex-fill">
          <div class="imgBx">
            <img src="/images/<?=$news['image'] ?>" alt="" class="img-fluid">
          </div>
          <div class="content h-100">
            <div class="newstitle">
              <h2 class="itemrecent1"><?= $news['titre'] ?></h2>
           	  <p class="float-left m-0"><i class="fas fa-clock"></i>  <?= $news['dateAjout']->format('Y-m-d') ?></p><br>
            </div>
           	<p class="itemrecent1"><?= nl2br($news['contenu']) ?></p>
            <?php
            if ($category === 'news'){?>
            <div class="itemrecent1"><a href="/news/<?php echo $generator->generate($news['titre']); ?>_<?= $news['id'] ?>" class="btn btnD1">Read</a></div>
            <?php
            }else {?>
            <div class="itemrecent1"><a href="/guide/<?= $category ?>/<?php echo $generator->generate($news['titre']); ?>_<?= $news['id'] ?>" class="btn btnD1">Read</a></div>
            <?php
            }?>
            <div class="clearfix"></div>
          </div>
      </article>
    </div>
    <?php } ?>   <!-- End of news -->
  	</div>
	<nav class="bg-light row mb-4 justify-content-center">
		<ul class="pagination pt-3">
		    <?php
		    if ($numberOfPagesNews > 1){
			    for ($i = 1; $i <= $numberOfPagesNews; $i++)
			    {
			        if ($i == $currentPage){
			            echo '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
			        } else {
			        	if ($category === 'news'){
			        		echo '<li class="page-item"><a class="page-link" href="/news/page='. $i .'#ancre">'.$i.'</a></li>';
			        	}else {
			        		echo '<li class="page-item"><a class="page-link" href="/guides/'.$category.'/page='. $i .'#ancre">'.$i.'</a></li>';
			        	}
			        }
			    }   $i--; 
			}?>
		</ul>
	</nav>
</section>
