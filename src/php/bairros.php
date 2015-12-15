<?php
/* Template Name: Bairros */

if (empty($_GET['v']) || intval($_GET['v']) < 3) {
  require_once("v2-bairros.php");
  exit();
}

require_once(__DIR__ . '/dlib/locations.php');

the_post();
get_header();
?>

<main class="flow">
  <div class="wrap">
    <h2 class="flow-title">
      <span>Discuta, imagine e mobilize no seu bairro!</span>
    </h2>
    <ol class="flow-list">
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #1
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #2
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #3
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #4
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
    </ol>
  </div>
</main>

<section class="temas-form bg-pattern-light-purple">
  <div class="wrap">

    <?php
    if (is_user_logged_in()) {
      $user = wp_get_current_user();
      $bairro = get_user_meta($user->ID, 'location', true);
      ?>
      <h2 class="temas-form-title">
        <?php echo $bairro; ?>
      </h2>

      <?php
      $term = get_term_by('name', $bairro, 'local');
      $active = get_term_meta($term->term_id, 'active', true);
      $link = get_term_link($term->term_id, $term->taxonomy);
      if ($active) {
        ?>
        <p class="bairros-form-description">
          <?php
          if ($term->count > 1) {
            echo $term->count; ?>
            ideias já estão sendo debatidas!
            <?php
          } else {
            ?>
            Clique no botão para entrar no debate!
            <?php
          }
          ?>
        </p>

        <p class="bairros-button-container">
          <a class="bairros-button" href="<?php echo $link; ?>">
            Participe
          </a>
        </p>
        <?php
      } else {
        $missing = DoloresLocations::get_instance()->get_missing($bairro);
        ?>
        <p class="bairros-form-description">
          Faltam <strong><?php echo $missing; ?></strong> pessoas para
          desbloquear seu bairro.
        </p>

        <p class="bairros-button-container">
          <button
              class="bairros-button"
              onclick="FB.ui({method: 'send', link: '<?php
              echo site_url("/bairros/");
              ?>'});">
            Convide seus amigos
          </button>
        </p>
        <?php
      }
    } else {
      ?>
      <h2 class="temas-form-title">
        Qual o seu bairro?
      </h2>

      <p class="temas-form-description">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
      </p>

      <div id="form-bairros"></div>
      <?php
    }
    ?>
  </div>
</section>

<section class="locais-map-container">
  <div id="locaisMap"></div>
</section>

<script type="text/javascript">
  window.onload = function() {
    <?php
    $locations = DoloresLocations::get_instance();
    $terms = $locations->get_active();
    foreach ($terms as $term) {
      $name = $term->name;
      $lat = get_term_meta($term->term_id, 'lat', true);
      $lng = get_term_meta($term->term_id, 'lng', true);
      if (!$lat || !$lng) {
        continue;
      }
      $link = get_term_link($term->term_id, $term->taxonomy);
      $user_count = $locations->get_user_count($term->name);
      $post_count = $term->count;
      ?>
      window.addMapMarker({
        position: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>},
        title: "<?php echo $name; ?>",
        content: "" +
        "<div class=\"map-marker\">" +
          "<h3 class=\"map-marker-title\"><?php echo $name; ?></h3>" +
          "<p class=\"map-marker-description\">" +
            "<strong>Usuários:</strong> <?php echo $user_count; ?><br />" +
            "<strong>Ideias:</strong> <?php echo $post_count; ?>" +
          "</p>" +
          "<p class=\"map-marker-description\">" +
            "<a class=\"map-marker-button\" href=\"<?php echo $link; ?>\">" +
              "Participar" +
            "</a>" +
          "</p>" +
        "</div>"
      });
      <?php
    }
    ?>
  };
</script>

<?php
get_footer();
?>
