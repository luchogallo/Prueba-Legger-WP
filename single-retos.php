<?php
get_header(); 
?>

<div class="reto-detalle">
    <?php while (have_posts()): the_post(); ?>

    <div class="container-reto">
        <div class="container-reto__info">
            <h1><?php the_field('website_name'); ?></h1>
            <div class="effect-card">
                <a href="<?php echo site_url('/home/?rtc=' . get_field('codigo_unico')); ?>" class="service-button grow">Ir a Formulario de Registro</a>
            </div>
        </div>

        <div class="container-reto__info">
            <h2><?php the_field('section_1_titulo'); ?></h2>
            <p><?php the_field('section_1_descripcion'); ?></p>
        </div>

    </div>

    <div class="container-description">
        <div class="container-description__info">
            <p><?php the_field('descripcion_larga'); ?></p>
        </div>

        <figure>
            <?php $imagen = get_field('imagen_promocional'); ?>
            <?php if ($imagen): ?>
                <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>">
            <?php endif; ?>
        </figure>

    </div>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>