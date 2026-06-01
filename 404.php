<?php
	get_header();
?>
	<div class="cbo-page page-404">
		<section class="cbo-text">
			<div class="text-inner cbo-container container--small">
				<div class="text-content cbo-cms">
					<h1 class="contact-title cbo-title-1 slide-up">
						<?php pll_e('Erreur 404') ?>
					</h1>

					<?php pll_e('La page que vous rechechez n\'existe pas.<br />Vous pouvez toujours revenir sur vos pas.') ?><br/><br/>
					<a class="cbo-button" href="<?php echo home_url(); ?>">
						<?php pll_e('Revenir à l\'accueil') ?>
					</a>
				</div>
			</div>
		</section>
	</div>
<?php
	get_footer();
?>