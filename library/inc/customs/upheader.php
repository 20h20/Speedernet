<?php

$sur_link = get_field('surheader_link', 'option');
$phone = get_field('global_phone', 'option');
$mail = get_field('global_mail', 'option');

?>

<div class="cbo-upheader" role="complementary" aria-label="<?php pll_e('Barre d\'information'); ?>">
    <div class="upheader-inner">
        <div class="upheader-contacts" itemprop="contactPoint" itemscope itemtype="https://schema.org/ContactPoint">
            <meta itemprop="telephone" content="<?php echo esc_attr($phone); ?>">
            <meta itemprop="email" content="<?php echo esc_attr($mail); ?>">

            <a
                class="upheader-button"
                href="<?php echo esc_url('tel:' . $phone); ?>"
                aria-label="<?php pll_e('Appeler Speedernet'); ?>"
            >
                <i class="icon icon--phone" aria-hidden="true"></i>
            </a>

            <a
                class="upheader-button"
                href="<?php echo esc_url('mailto:' . $mail); ?>"
                aria-label="<?php pll_e('Envoyer un email à Speedernet'); ?>"
            >
                <i class="icon icon--mail" aria-hidden="true"></i>
            </a>
        </div>

        <div class="upheader-info">
            <?php if ($sur_link): ?>
                <span class="info-tag cbo-tag tag--blue" aria-hidden="true">
                    <?php pll_e('Info'); ?>
                </span>
                <?php
                    $is_blank = ($sur_link['target'] ?? '') === '_blank';
                ?>
                <a
                    href="<?php echo esc_url($sur_link['url']); ?>"
                    class="info-text"
                    target="<?php echo esc_attr($sur_link['target'] ?: '_self'); ?>"
                    <?php if ($is_blank): ?>
                        rel="noopener noreferrer"
                        aria-label="<?php echo esc_attr($sur_link['title']); ?> (<?php pll_e('nouvelle fenêtre'); ?>)"
                    <?php endif; ?>
                >
                    <?php echo esc_html($sur_link['title']); ?>
                    <i class="icon icon--arrow-next" aria-hidden="true"></i>
                </a>
            <?php endif; ?>
        </div>

        <div class="upheader-actions">
            <button
                type="button"
                class="upheader-button upheader-search"
                aria-label="<?php pll_e('Ouvrir la recherche'); ?>"
                aria-expanded="false"
                aria-controls="cbo-searchbar"
            >
                <i class="icon icon--search" aria-hidden="true"></i>
            </button>

            <div class="upheader-languages">
                <button
                    class="languages-button"
                    type="button"
                    aria-label="<?php pll_e('Sélectionner la langue'); ?>"
                    aria-expanded="false"
                    aria-controls="cboLanguagesList"
                >
                    <?php echo esc_html(strtoupper(pll_current_language('slug'))); ?>
                    <i class="icon icon--chevron" aria-hidden="true"></i>
                </button>

                <ul class="languages-list" id="cboLanguagesList">
                    <?php
                        pll_the_languages(array(
                            "show_names"       => true,
                            "display_names_as" => "slug",
                            "hide_current"     => 1,
                        ));
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>