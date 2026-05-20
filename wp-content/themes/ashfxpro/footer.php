
<footer class="site-footer">
  <nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'ashfxpro' ); ?>">
    <?php
    $footer_links = [
      [ 'num' => '01', 'label' => 'About',        'url' => '/about' ],
      [ 'num' => '02', 'label' => 'Track Record',  'url' => '/track-record' ],
      [ 'num' => '03', 'label' => 'Price',          'url' => '/price' ],
      [ 'num' => '04', 'label' => 'Education',      'url' => '/education' ],
      [ 'num' => '05', 'label' => 'Contact',        'url' => '/contact' ],
    ];
    foreach ( $footer_links as $item ) : ?>
      <div class="footer-nav-item">
        <span class="footer-nav-item__num"><?php echo esc_html( $item['num'] ); ?></span>
        <a href="<?php echo esc_url( home_url( $item['url'] ) ); ?>" class="footer-nav-item__link">
          <?php echo esc_html( $item['label'] ); ?>
        </a>
      </div>
    <?php endforeach; ?>
  </nav>

  <div class="footer-bottom">
    <p class="footer-bottom__copy">@ ashfxpro.ru 2026</p>
    <p class="footer-bottom__disclaimer">
      Используя сайт, вы соглашаетесь с обработкой технических данных (cookies, IP) в целях аналитики<br>
      Информация на сайте не является инвестиционной рекомендацией. Торговля сопряжена с риском потери капитала.
    </p>
    <p class="footer-bottom__lang">En</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
