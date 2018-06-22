<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package prs-wp-theme
 */

?>

            </div><?php // #content ?>

        </div><?php // #page ?>
        <footer id="colophon" class="row prs-footer">
            <div class="col-sm-12 prs-footer__info">
                &copy; 2017&mdash;<?php echo date('Y'); ?> Ruby Idrees
                <span class="sep"> &bull; </span>
                All rights reserved.
            </div><?php // .site-info ?>
        </footer><?php // #colophon ?>

        <?php wp_footer(); ?>
    </div>
</body>
</html>
