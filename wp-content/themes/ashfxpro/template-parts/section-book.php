<?php
$img = get_template_directory_uri() . '/assets/images';
function ashfxpro_book_t( $key, $fallback ) {
    return function_exists( 'pll__' ) ? pll__( $fallback ) : $fallback;
}
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
      <span class="book-label"><?php echo esc_html( ashfxpro_book_t( 'book_label', 'Готовится к выходу' ) ); ?></span>
      <h2 class="book-title"><?php echo esc_html( ashfxpro_book_t( 'book_title', 'Книга «Язык Графика»' ) ); ?></h2>
    </div>
    <p class="book-description"><?php echo esc_html( ashfxpro_book_t( 'book_desc', 'Весь мой опыт в текстовом издании. Для тех, кто ценит фундаментальные знания' ) ); ?></p>
  </div>
</section>
