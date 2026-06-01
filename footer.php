	</main>

	<?php
		$phone	= get_field('footer_phone', 'option');
		$adress	= get_field('footer_adress', 'option');
		$linkedin	= get_field('option_linkedin', 'option');
		$youtube	= get_field('option_youtube', 'option');
		$instagram	= get_field('option_instagram', 'option');
		$twitter	= get_field('option_twitter', 'option');
		$facebook	= get_field('option_facebook', 'option');
	?> 

	<footer class="cbo-footer" role="contentinfo" itemscope itemtype="https://schema.org/Organization">
		<span class="sr-only" itemprop="name"><?php echo esc_html( get_bloginfo('name') ); ?></span>
		<div class="footer-inner">
			<div class="footer-top cbo-container container--padding container--nomargin">
				<a class="footer-logo cbo-picture-contain" href="<?php echo esc_url( home_url() ); ?>/" rel="home" aria-label="<?php esc_attr(pll__('Revenir à l\'accueil')) ?>" itemprop="url">
					<img
						decoding="async"
						src="<?php echo esc_url( get_template_directory_uri() ); ?>/library/images/logo-speedernet-footer.svg"
						alt="<?php echo esc_attr( get_bloginfo('name') ); ?>"
						sizes="148px"
						loading="lazy"
						width="148" height="159"
						itemprop="logo"
					>
				</a>

				<div class="footer-nav">
					<nav aria-label="<?php esc_attr(pll__('Navigation du pied de page')) ?>">
						<?php wp_nav_menu( array(
							'container' => false,
							'container_class' => '',
							'menu_class' => 'footer-menu',
							'theme_location' => 'footer-nav',
						));?>
					</nav>
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="bottom-inner cbo-container container--nomargin">
				<div class="bottom-contacts">
					<?php if($phone): ?>
						<a class="contacts-phone" href="<?php echo esc_attr(pll__( 'tel:' . $phone )); ?>" itemprop="telephone" aria-label="<?php pll_e('Nous appeler au ') ?> <?php echo esc_attr( wp_strip_all_tags($phone) ); ?>">
							<?php echo wp_kses_post($phone); ?>
						</a>
					<?php endif; ?>

					<?php if($adress): ?>
						<address class="contacts-adress" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
							<?php echo wp_kses_post($adress); ?>
						</address>
					<?php endif; ?>
				</div>

				<ul class="bottom-social" role="list" aria-label="<?php pll_e('Nos réseaux sociaux') ?>">
					<?php if($linkedin): ?>
						<li class="social-el">
							<a class="el-inner" href="<?php echo esc_url( $linkedin ); ?>" itemprop="sameAs" target="_blank" aria-label="<?php pll_e('Notre page LinkedIn (nouvelle fenêtre)') ?>" rel="noopener noreferrer">
								<i class="icon icon--linkedin" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>

					<?php if($youtube): ?>
						<li class="social-el">
							<a class="el-inner" href="<?php echo esc_url( $youtube ); ?>" itemprop="sameAs" target="_blank" aria-label="<?php pll_e('Notre chaîne YouTube (nouvelle fenêtre)') ?>" rel="noopener noreferrer">
								<i class="icon icon--youtube" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>

					<?php if($instagram): ?>
						<li class="social-el">
							<a class="el-inner" href="<?php echo esc_url( $instagram ); ?>" itemprop="sameAs" target="_blank" aria-label="<?php pll_e('Notre page Instagram (nouvelle fenêtre)') ?>" rel="noopener noreferrer">
								<i class="icon icon--instagram" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>

					<?php if($twitter): ?>
						<li class="social-el">
							<a class="el-inner" href="<?php echo esc_url( $twitter ); ?>" itemprop="sameAs" target="_blank" aria-label="<?php pll_e('Notre page Twitter (nouvelle fenêtre)') ?>" rel="noopener noreferrer">
								<i class="icon icon--x" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>

					<?php if($facebook): ?>
						<li class="social-el">
							<a class="el-inner"	 href="<?php echo esc_url( $facebook ); ?>" itemprop="sameAs" target="_blank" aria-label="<?php pll_e('Notre page Facebook (nouvelle fenêtre)') ?>" rel="noopener noreferrer">
								<i class="icon icon--facebook" aria-hidden="true"></i>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="footer-mentions">
			<div class="mentions-inner cbo-container container--nomargin">
				<nav aria-label="<?php pll_e('Navigation annexe') ?>">
					<?php wp_nav_menu( array(
						'container' => false,
						'container_class' => '',
						'menu_class' => 'mentions-nav',
						'theme_location' => 'footer-annexe',
					));?>
				</nav>

				<div class="inner-copyright">
					<meta itemprop="copyrightYear" content="<?php echo esc_attr( date('Y') ); ?>">
					<span itemprop="copyrightHolder" itemscope itemtype="https://schema.org/Organization">
						© <?php echo date('Y'); ?>
						<span itemprop="name">Speedernet</span>
					</span>
					- <?php pll_e('Tous droits réservés') ?>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
</body>
</html>