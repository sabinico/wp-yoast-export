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
        <th>Titulo</th>
        <th>Palabra clave</th>
        <?php if($options['count_key']): ?>
        <th>Repeticiones</th>
        <?php endif; ?>
        <th>Contador palabras</th>
      </tr>
    <?php foreach($export as $post): ?>
      <tr>
        <td><?php print $post->ID; ?></td>
        <td><?php print $post->post_title; ?></td>
        <td><?php print $post->yoast_kw; ?></td>
        <?php if($options['count_key']): ?>
        <td><?php print $post->yoast_kw_count; ?></td>
        <?php endif; ?>
        <td><?php print $post->words_count; ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
</div>
