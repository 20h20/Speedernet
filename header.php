<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
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
			$hdbt = get_field('header_button', 'option');
		?>

		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-DL663BQ4HZ"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-DL663BQ4HZ');
		</script>
	</head>

	<body <?php body_class('cbo-main'); ?> itemscope itemtype="https://schema.org/WebPage">

		<a class="skip-link" href="#main-content">
			<?php pll_e('Aller au contenu principal') ?>
		</a>

		<header class="cbo-header">
			<?php include get_template_directory() . '/library/inc/customs/upheader.php'; ?>

			<div class="header-inner">
				<a
					class="header-logo"
					aria-label="<?php echo esc_attr( get_bloginfo('name') . ' — ' . pll__('Accueil') ); ?>"
					href="<?php echo esc_url(home_url('/')); ?>"
				>
					<img
						class="logo-full"
						decoding="async"
						src="<?php echo esc_url(get_template_directory_uri()); ?>/library/images/logo-speedernet-header.svg"
						alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
						width="200"
						height="50"
						fetchpriority="high"
					>
					<img
						class="logo-min"
						decoding="async"
						src="<?php echo esc_url(get_template_directory_uri()); ?>/library/images/logo-speedernet-min.svg"
						alt=""
						aria-hidden="true"
						width="40"
						height="42"
					>
				</a>

				<button
					type="button"
					class="burger-menu"
					aria-label="<?php pll_e('Ouvrir la navigation principale'); ?>"
					aria-expanded="false"
					aria-controls="menu-principal"
				>
					<span class="top" aria-hidden="true"></span>
					<span class="bottom" aria-hidden="true"></span>
				</button>

				<nav
					class="cbo-nav"
					aria-label="<?php pll_e('Navigation principale'); ?>"
				>
					<?php wp_nav_menu(array(
						'container'      => false,
						'menu_class'     => '',
						'theme_location' => 'main-nav',
						'menu_id'        => 'menu-principal',
						'walker'         => new CBO_Walker_Mega_Menu(),
					)); ?>

					<?php if ($hdbt):
						$hdbt_blank = ($hdbt['target'] ?? '') === '_blank';
					?>
						<a
							class="nav-button cbo-button"
							href="<?php echo esc_url($hdbt['url']); ?>"
							target="<?php echo esc_attr($hdbt['target'] ?: '_self'); ?>"
							<?php if ($hdbt_blank): ?>
								rel="noopener noreferrer"
								aria-label="<?php echo esc_attr($hdbt['title']); ?> (<?php pll_e('nouvelle fenêtre'); ?>)"
							<?php endif; ?>
						>
							<?php echo esc_html($hdbt['title']); ?>
						</a>
					<?php endif; ?>
				</nav>
			</div>
		</header>

		<main id="main-content" class="cbo-page">

			<?php if (!is_front_page()) get_part('breadcrumb/template'); ?>
