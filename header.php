<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<title><?php wp_title(' - '); ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />

		<?php $theme_uri = esc_url(get_template_directory_uri()); ?>
		<link rel="preload" href="<?php echo $theme_uri; ?>/library/fonts/Mulish-Regular.woff2" as="font" type="font/woff2" crossorigin="anonymous">
		<link rel="preload" href="<?php echo $theme_uri; ?>/library/fonts/Mulish-Bold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
		<link rel="preload" href="<?php echo $theme_uri; ?>/library/fonts/Mulish-ExtraBold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
		<link rel="preload" href="<?php echo $theme_uri; ?>/library/fonts/Mulish-Black.woff2" as="font" type="font/woff2" crossorigin="anonymous">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $theme_uri; ?>/library/images/fav/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $theme_uri; ?>/library/images/fav/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $theme_uri; ?>/library/images/fav/favicon-16x16.png">
		<?php wp_head(); ?>

		<?php
			$hdbt     = get_field('header_button', 'option');
		?>
	</head>

	<body <?php body_class('cbo-main'); ?> itemscope itemtype="https://schema.org/WebPage">

		<a class="skip-link" href="#main-content">
			<?php pll_e('Aller au contenu principal') ?>
		</a>

		<?php include get_template_directory() . '/library/inc/customs/upheader.php'; ?>

		<header class="cbo-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
			<div class="header-inner">
				<a
					class="header-logo"
					title="Accueil - <?php echo get_bloginfo('description'); ?>"
					href="<?php echo home_url(); ?>"
					itemprop="url"
				>
					<img
						class="logo-full"
						decoding="async"
						src="<?php bloginfo('template_directory'); ?>/library/images/logo-speedernet-header.svg"
						alt="<?php echo get_bloginfo('description'); ?>"
						sizes="100vw"
						itemprop="logo"
						fetchpriority="high"
					>
					<img
						class="logo-min"
						decoding="async"
						src="<?php bloginfo('template_directory'); ?>/library/images/logo-speedernet-min.svg"
						alt=""
						aria-hidden="true"
					>
				</a>

				<button
					type="button"
					class="burger-menu"
					aria-label="<?php pll_e('Ouvrir la navigation principale'); ?>"
					aria-expanded="false"
					aria-controls="menu-principal"
				>
					<span class="top"></span>
					<span class="bottom"></span>
				</button>

				<nav
					class="cbo-nav"
					role="navigation"
					itemscope
					itemtype="https://schema.org/SiteNavigationElement"
					aria-label="<?php pll_e('Navigation principale'); ?>"
				>
					<?php wp_nav_menu(array(
						'container'      => false,
						'menu_class'     => '',
						'theme_location' => 'main-nav',
						'menu_id'        => 'menu-principal',
					)); ?>

					<?php if ($hdbt): ?>
						<a
							class="nav-button cbo-button"
							href="<?php echo esc_url($hdbt['url']); ?>"
							target="<?php echo esc_attr($hdbt['target'] ?: '_self'); ?>"
							<?php if (($hdbt['target'] ?? '') === '_blank'): ?>rel="noopener noreferrer"<?php endif; ?>
						>
							<?php echo esc_html($hdbt['title']); ?>
						</a>
					<?php endif; ?>
				</nav>
			</div>
		</header>

		<div class="mega-backdrop" aria-hidden="true"></div>
		<main id="main-content" class="cbo-page" role="main" itemscope itemtype="https://schema.org/WebPageElement">

			<?php if (!is_front_page()) get_part('breadcrumb/template'); ?>
