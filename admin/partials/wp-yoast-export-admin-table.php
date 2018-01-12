<?php

/**
 * Provide a table view for the export
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sabinico.com
 * @since      1.0.0
 *
 * @package    Wp_Yoast_Export
 * @subpackage Wp_Yoast_Export/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <?php $options = get_option($this->plugin_name); ?>

    <h2>Tabla de datos</h2>
    <table class="table table-hover">
      <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Categoría</th>
        <th>URL</th>
        <?php if($options['export_content']): ?>
        <th>Contenido</th>
        <?php endif; ?>
        <th>Score content</th>
        <th>Legibilidad</th>
        <th>Contador palabras</th>
        <th>Palabra clave</th>
        <?php if($options['count_key']): ?>
        <th>Repeticiones</th>
        <?php endif; ?>
      </tr>
    <?php foreach($export as $post): ?>
      <tr>
        <td><?php print $post->ID; ?></td>
        <td><?php print $post->post_date; ?></td>
        <td><?php print $post->post_title; ?></td>
        <td><?php print get_user_by('ID',$post->post_author)->display_name; ?></td>
        <td><?php print implode(", ", get_the_category($post->ID)); ?></td>
        <td><?php print get_permalink($post->guid); ?></td>
        <?php if($options['export_content']): ?>
        <td><?php print $post->content_plain; ?></td>
        <?php endif; ?>
        <td><?php print $post->score_content; ?></td>
        <td><?php print $post->score_legi; ?></td>
        <td><?php print $post->words_count; ?></td>
        <td><?php print $post->yoast_kw; ?></td>
        <?php if($options['count_key']): ?>
        <td><?php print $post->yoast_kw_count; ?></td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
    </table>

    <?php if(isset($_REQUEST['specific'])): ?>
      <pre><?php print_r($export[0]); ?></pre>
    <?php endif; ?>
</div>
