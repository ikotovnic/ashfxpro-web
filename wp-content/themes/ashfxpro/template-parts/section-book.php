<?php
$img = get_template_directory_uri() . '/assets/images';
?>
<section class="section-book" aria-label="Book">
  <div class="book-bg" aria-hidden="true">
    <picture>
      <source srcset="<?php echo esc_url( "$img/book-bg1.webp" ); ?>" type="image/webp">
      <img src="<?php echo esc_url( "$img/book-bg1.jpg" ); ?>" alt="" loading="lazy">
    </picture>
    <picture>
      <source srcset="<?php echo esc_url( "$img/book-bg2.webp" ); ?>" type="image/webp">
      <img src="<?php echo esc_url( "$img/book-bg2.jpg" ); ?>" alt="" loading="lazy">
    </picture>
  </div>
  <div class="book-content">
    <div class="book-content__top">
      <span class="book-label"><?php echo esc_html( ashfxpro_t( 'Готовится к выходу' ) ); ?></span>
      <h2 class="book-title"><?php echo esc_html( ashfxpro_t( 'Книга «Язык Графика»' ) ); ?></h2>
    </div>
    <p class="book-description"><?php echo esc_html( ashfxpro_t( 'Весь мой опыт в текстовом издании. Для тех, кто ценит фундаментальные знания' ) ); ?></p>
  </div>
</section>
