<section class="container mt-5">
  <p style="text-align: center">There is right now : <?= $nombreNews ?> news. Here's the list :</p>
  <a href="/admin/insert" class="btn btnD1">Add a News</a>
  <table class="table table-striped table-hover table-dark table-responsive mt-3">
    <tr><th>Category</th><th>Title</th><th>Author</th><th>Date creation</th><th>Last edit</th><th>Image</th><th>Action</th></tr>
  <?php
  foreach ($listeNews as $news)
  {
    echo '<tr><td>', $news['category'], '</td><td>', $news['titre'], '</td><td>', $news['auteur'], '</td><td>', $news['dateAjout']->format('d/m/Y à H\hi'), '</td><td>', ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le '.$news['dateModif']->format('d/m/Y à H\hi')), '</td><td>'.$news['image'].'</td><td><a href="/admin/edit-', $news['id'], '"><img src="/images/update.png" alt="Edit" /></a> <a href="/admin/delete-', $news['id'], '"><img src="/images/delete.png" alt="Delete" /></a></td></tr>', "\n";
  }
  ?>
  </table>
</section>