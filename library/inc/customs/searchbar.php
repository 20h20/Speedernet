<div class="cbo-searchoverlay"></div>

<div class="cbo-searchbar" aria-hidden="true">
    <div class="searchbar-inner">
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchbar-form">
            <i class="icon icon--search" aria-hidden="true"></i>
            <input type="search" name="s" class="searchbar-input" placeholder="<?php echo esc_attr(pll__('Rechercher…')); ?>" autocomplete="off" />
            <button type="button" class="searchbar-close" aria-label="<?php echo esc_attr(pll__('Fermer la recherche')); ?>">
                <i class="icon icon-close" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</div>