<?php
/**
 * The main index template file.
 *
 * @package ExMachina
 */
?>

<?php get_header(); ?>
  <article>
    <div class="entry-content">
      <h3>ExMachina Settings</h3>
      <p>Just a placeholder while we build the backend functions.</p>
      <hr>

      <dl class="dl-horizontal">
        <dt>exmachina_get_option('demo_one'): </dt>
        <dd><?php // echo exmachina_get_option('demo_one'); ?></dd>
      </dl>

      <dl class="dl-horizontal">
        <dt>exmachina_get_option('demo_two'): </dt>
        <dd><?php // echo exmachina_get_option('demo_two'); ?></dd>
      </dl>

      <pre>

      </pre>
    </div><!-- .entry-content -->
  </article><!-- article -->
<?php get_footer(); ?>