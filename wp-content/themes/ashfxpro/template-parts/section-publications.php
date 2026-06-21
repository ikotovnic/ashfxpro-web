<?php
$img = get_template_directory_uri() . '/assets/images';
$ico = get_template_directory_uri() . '/assets/icons';

$pubs = array_slice(
    get_option( 'ashfxpro_publications', ashfxpro_publications_defaults() ),
    0, 5
);
?>
<section class="section-publications" aria-label="<?php esc_attr_e( 'Recent publications', 'ashfxpro' ); ?>">

  <div class="publications-intro">
    <h2 class="publications-intro__title">Recent publications</h2>
    <div class="publications-avatars" aria-hidden="true">
      <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
        <div class="avatar-stack">
          <img src="<?php echo esc_url( "$img/avatar1.jpg" ); ?>" alt="">
          <?php if ( $i >= 2 ) : ?>
            <img src="<?php echo esc_url( "$img/avatar" . ( $i + 1 ) . ".jpg" ); ?>" alt="">
          <?php endif; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <div class="publications-carousel js-carousel" aria-label="<?php esc_attr_e( 'Posts carousel', 'ashfxpro' ); ?>">
    <?php foreach ( $pubs as $idx => $pub ) :
      // Extract hashtags from text
      preg_match_all( '/#[\w\x{0400}-\x{04FF}]+/u', $pub['text'], $tag_matches );
      $hashtags   = $tag_matches[0];
      $clean_text = trim( preg_replace( '/#[\w\x{0400}-\x{04FF}]+\s*/u', '', $pub['text'] ) );
      $date_label = ashfxpro_format_pub_date( $pub['date'] );
      $is_active  = ( $idx === 0 );
      $left_cls   = $is_active ? 'post-card-left--active' : 'post-card-left--inactive';
    ?>
    <a class="post-card"
       href="<?php echo esc_url( $pub['tg_url'] ); ?>"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="<?php esc_attr_e( 'Open post in Telegram', 'ashfxpro' ); ?>">

      <div class="post-card-bg" aria-hidden="true">
        <img src="<?php echo esc_url( $pub['image_url'] ); ?>" alt="" loading="lazy">
        <div class="post-card-bg-dark"></div>
      </div>

      <div class="post-card-content">
        <div class="post-card-left <?php echo esc_attr( $left_cls ); ?>">

          <div class="post-card-header">
            <div class="post-author-avatar">
              <img src="<?php echo esc_url( "$img/avatar1.jpg" ); ?>" alt="">
              <img src="<?php echo esc_url( "$img/avatar3.jpg" ); ?>" alt="">
              <img src="<?php echo esc_url( "$img/avatar5.jpg" ); ?>" alt="">
            </div>
            <div class="post-author-info">
              <img src="<?php echo esc_url( "$ico/telegram.svg" ); ?>" alt="Telegram" width="20" height="17">
              <span class="post-author-name">AshFXPro</span>
            </div>
          </div>

          <h3 class="post-title"><?php echo nl2br( esc_html( $clean_text ) ); ?></h3>

          <div class="post-meta">
            <div class="post-media">
              <?php foreach ( $hashtags as $tag ) : ?>
                <span><?php echo esc_html( $tag ); ?></span>
              <?php endforeach; ?>
            </div>
            <time datetime="<?php echo esc_attr( $pub['date'] ); ?>">
              <?php echo esc_html( $date_label ); ?>
            </time>
          </div>

        </div>
        <div class="post-card-right" aria-hidden="true"></div>
      </div>

    </a>
    <?php endforeach; ?>
  </div>

</section>
