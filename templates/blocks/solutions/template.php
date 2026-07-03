<?php

$uptitle = get_field('solutions_uptitle');
$title   = get_field('solutions_title');

?>

<section class="cbo-solutions">
    <div class="solutions-inner cbo-container">

        <?php if ($uptitle): ?>
            <span class="cbo-tag tag--blue slide-up">
                <?php echo esc_html($uptitle); ?>
            </span>
        <?php endif; ?>

        <?php if ($title): ?>
            <div class="solutions-title cbo-title-2 slide-up">
                <?php echo wp_kses_post($title); ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('solutions_list')): ?>
            <ul class="solutions-list" role="list">
                <?php $index = 0; while (have_rows('solutions_list')): the_row();
                    $picto   = get_sub_field('picto');
                    $stitle  = get_sub_field('title');
                    $content = get_sub_field('content');
                    $index++;
                ?>
                    <li class="list-el slide-up" role="listitem">
                        <div class="el-inner">
                            <div class="el-header">
                                <span class="header-number">
                                    <?php echo str_pad($index, 2, '0', STR_PAD_LEFT); ?>
                                </span>
                                <?php if ($picto): ?>
                                    <div class="header-picto cbo-picture-contain">
                                        <img
                                            src="<?php echo esc_url($picto['sizes']['xsmall']); ?>"
                                            alt=""
                                            loading="lazy"
                                            width="60"
                                            height="60"
                                            decoding="async"
                                        >
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="el-content">
                                <?php if ($stitle): ?>
                                    <h3 class="content-title cbo-title-4">
                                        <?php echo esc_html($stitle); ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if ($content): ?>
                                    <div class="content-text cbo-cms">
                                        <?php echo wp_kses_post($content); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
