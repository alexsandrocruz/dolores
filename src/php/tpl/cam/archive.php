<?php
add_filter('get_the_archive_title', function($title) {
  if (is_category()) {
    $title = single_cat_title('', false);
  }
  switch ($title) {
  case 'Contribuições':
    $title = 'Contribuições para o debate';
    break;
  case 'Projetos na câmara':
    $title = 'Conheça nossos projetos na câmara municipal';
    break;
  }
  return $title;
});

get_header();
?>

<main class="wrap default-wrap no-padding-bottom">
  <h2 class="archive-title"><?php the_archive_title(); ?></h2>
  <?php
  if (is_category() && category_description()) {
    ?>
    <div class="archive-description">
      <?php echo category_description(); ?>
    </div>
    <?php
  }
  ?>
</main>

<?php
dolores_grid();
?>

<?php
get_footer();
?>
