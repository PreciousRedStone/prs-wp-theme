<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package prs-wp-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<?php $prsHomeClass = ( is_home() && is_front_page()) ? ' prs-home' : ''; ?>
<body <?php body_class($prsHomeClass); ?>>
    <div class="container-fluid">
        <header class="row header">
            <section class="col-sm-12 clearfix">
                <?php if (is_singular() && !is_home() && !is_front_page()) : ?>
                    <a class="header__logo-link" href="/">
                        <h1 class="header__logo">Henna and Face Painting by Ruby</h1>
                    </a>
                <?php else : ?>
                    <h1 class="header__logo">Henna and Face Painting by Ruby</h1>
                <?php endif; ?>

                <?php
                    if ( has_nav_menu('header-nav') ) {
                        wp_nav_menu( array(
                            'theme_location' => 'header-nav',
                            'menu_class' => 'header__nav-items',
                            'container' => 'nav',
                            'container_id' => 'header-nav',
                            'container_class' => 'header__nav',
                            'fallback_cb' => false
                        ) );
                    }
                ?>
            </section>
        </header>

        <?php if (is_home() && is_front_page()) : ?>
            <section class="row intro-hero">
                <div class="intro-hero__text-container">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                                <h2 class="intro-hero__text">Professional Henna &amp; Face Painting artist, based in West London</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <div id="page" class="container prs-container">

            <?php /*
            <header id="masthead" class="site-header">
                <div class="site-branding">
                    <?php
                    the_custom_logo();
                    if ( is_front_page() && is_home() ) : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                    endif;

                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <p class="site-description"><?php echo $description; /* WPCS: xss ok. * / ?></p>
                    <?php
                    endif; ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'prs' ); ?></button>
                    <?php
                        wp_nav_menu( array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                        ) );
                    ?>
                </nav><!-- #site-navigation -->
            </header><!-- #masthead --> */ ?>

            <div id="content" class="site-content">
