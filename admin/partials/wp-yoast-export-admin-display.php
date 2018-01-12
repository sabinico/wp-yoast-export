<?php

/**
 * Provide a admin area view for the plugin
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

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="yoast_export_options" action="options.php">

      <?php
      //Grab all options
      $options = get_option($this->plugin_name);

      // Cleanup
      $count_key = $options['count_key'];
      $remove_html = $options['remove_html'];
      $include_img_key = $options['include_img_key'];
      $export_content = $options['export_content'];
      ?>

      <?php
      settings_fields($this->plugin_name);
      do_settings_sections($this->plugin_name);
      ?>

        <!-- Contar numero de repeticiones palabra clave -->
        <fieldset>
            <legend class="screen-reader-text"><span>Contador de repeticiones de la palabra clave</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-count_key">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-count_key" name="<?php echo $this->plugin_name; ?>[count_key]" value="1" <?php checked($count_key, 1); ?>/>
                <span><?php esc_attr_e('Contador de repeticiones de la palabra clave', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <!-- Eliminar HTML para contar palabras -->
        <fieldset>
            <legend class="screen-reader-text"><span>Eliminar HTML para contar palabras</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-remove_html">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-remove_html" name="<?php echo $this->plugin_name; ?>[remove_html]" value="1" <?php checked($remove_html, 1); ?>/>
                <span><?php esc_attr_e('Eliminar HTML para contar palabras', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <!-- Incluir palabra clave de los pie de fotos -->
        <fieldset>
            <legend class="screen-reader-text"><span>Incluir palabra clave de los pie de fotos</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-include_img_key">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-include_img_key" name="<?php echo $this->plugin_name; ?>[include_img_key]" value="1" <?php checked($include_img_key, 1); ?>/>
                <span><?php esc_attr_e('Incluir palabra clave de los pie de fotos', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <!-- Incluir contenido en texto plano -->
        <fieldset>
            <legend class="screen-reader-text"><span>Exportar también contenido en texto plano (No HTML & NO BBCode)</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-export_content">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-export_content" name="<?php echo $this->plugin_name; ?>[export_content]" value="1" <?php checked($export_content, 1); ?>/>
                <span><?php esc_attr_e('Exportar también contenido en texto plano (No HTML & NO BBCode)', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <?php submit_button('Guardar todos los cambios', 'primary','submit', TRUE); ?>
        <?php
        $export_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&export=1";
        ?>
        <a class="button button-primary" href="<?php print $export_link; ?>">EXPORTAR AHORA</a>

    </form>

</div>
