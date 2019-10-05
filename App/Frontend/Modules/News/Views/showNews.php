<div class="minijumbo"></div>

<section class="container"> <!-- News -->
	<div class="offset-sm-2 col-sm-8 bg-white category">
		<i class="fas fa-plus fa-3x float-left mr-3"></i>
		<h1><?= $news['titre'] ?></h1>
		<p>By <em><?= $news['auteur'] ?></em><i class="fas fa-calendar-week pr-1 pl-2"></i>   <?= $news['dateAjout']->format('Y-m-d') ?><i class="pr-1 pl-2 fas fa-briefcase"></i>  <?= $news['category'] ?></p>
	</div>
	<figure class="m-5"><img src="/images/<?=$news['image'] ?>" alt="Responsive image" class="d-block img-fluid img-responsive mx-auto" width="1000"></figure>
	<?= nl2br($news['contenu']) ?>

	<?php if ($news['dateAjout'] != $news['dateModif']) { ?>
	  <p style="text-align: right;"><small><em>Edited <?= $news['dateModif']->format('Y-m-d') ?></em></small></p>
	<?php } ?>
</section>

<section class="container bg-light mt-5 p-5" id="comments"> <!-- Comments -->
	<?php
if (empty($comments))
{
?>
<p>No comments</p>
<?php
}else {
  	 if ($user->hasComment()) {?>
    	<div class="alert alert-success"><?= $user->getFlashComment() ?></div>
    <?php }
	foreach ($comments as $comment)
	{
	?>
	<fieldset class="p-2 bg-white">
	  <legend class="m-0 p-0">
	    <strong class="text-white bg-dark"><?= htmlspecialchars($comment['auteur']) ?></strong> - <?= $comment['date']->format('Y-m-d') ?>
	    <?php if ($user->isAuthenticated()) { ?> -
	      <a href="admin/comment-update-<?= $comment['id'] ?>.html">Modifier</a> |
	      <a href="admin/comment-delete-<?= $comment['id'] ?>.html">Supprimer</a>
	    <?php } ?>
	  </legend>
	  <p><?= nl2br(htmlspecialchars($comment['contenu'])) ?></p><tr>
	</fieldset>
	<?php
	}?>
	<ul class="pagination justify-content-center pt-3">
        <?php 
        if ($numberOfPagesComments > 1){
	        for ($i = 1; $i <= $numberOfPagesComments; $i++)
	        {
	            if ($i == $currentPage){
	                echo '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
	            } else {
	                echo '<li class="page-item"><a class="page-link" href="/news/'. $generator->generate($news['titre']) .'_'.$news['id']. '/page=' . $i .'#comments">'.$i.'</a></li>';
	            }
	        }   $i--; 
	    }?>
    </ul>
<?php 
}?>

<form method="post" action="/news/<?php echo $generator->generate($news['titre']); ?>_<?= $news['id'] ?>" class="needs-validation" novalidate>
<fieldset>
	<legend class="text-white bg-dark" width="10">Leave your comment</legend>
	<?= $form ?>
	<div class="g-recaptcha mb-3" data-sitekey="6LdkRKQUAAAAADAZGRkGreW42dS-v-MWWwdcw_9u"></div>
	<input type="submit" name="" value="comment" class="btn btnD1">
</fieldset>
</form>
</section> <!-- End of Comments -->

<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>