<?php
$img = get_template_directory_uri() . '/assets/images';
$ico = get_template_directory_uri() . '/assets/icons';

$posts = [
  [ 'active' => true ],
  [ 'active' => false ],
  [ 'active' => false ],
];
?>
<section class="section-publications" aria-label="<?php esc_attr_e( 'Recent publications', 'ashfxpro' ); ?>">

  <div class="publications-intro">
    <h2 class="publications-intro__title">Recent publications</h2>
    <div class="publications-avatars" aria-hidden="true">
      <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
        <div class="avatar-stack">
          <img src="<?php echo esc_url( "$img/avatar1.jpg" ); ?>" alt="">
          <?php if ( $i >= 2 ) : ?>
            <img src="<?php echo esc_url( "$img/avatar" . ($i+1) . ".jpg" ); ?>" alt="">
          <?php endif; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>

  <div class="publications-carousel js-carousel" aria-label="<?php esc_attr_e( 'Posts carousel', 'ashfxpro' ); ?>">
    <?php foreach ( $posts as $post ) :
      $cls = $post['active'] ? 'post-card-left--active' : 'post-card-left--inactive';
    ?>
      <article class="post-card">
        <div class="post-card-bg" aria-hidden="true">
          <img src="<?php echo esc_url( "$img/post-bg1.jpg" ); ?>" alt="" loading="lazy">
          <img src="<?php echo esc_url( "$img/post-bg2.jpg" ); ?>" alt="" loading="lazy">
          <img src="<?php echo esc_url( "$img/post-bg3.jpg" ); ?>" alt="" loading="lazy">
          <div class="post-card-bg-overlay"></div>
          <img src="<?php echo esc_url( "$img/post-bg4.jpg" ); ?>" alt="" loading="lazy">
          <div class="post-card-bg-dark"></div>
        </div>
        <div class="post-card-content">
          <div class="post-card-left <?php echo esc_attr( $cls ); ?>">
            <div class="post-card-header">
              <div class="post-author-avatar">
                <img src="<?php echo esc_url( "$img/avatar1.jpg" ); ?>" alt="">
                <img src="<?php echo esc_url( "$img/avatar3.jpg" ); ?>" alt="">
                <img src="<?php echo esc_url( "$img/avatar5.jpg" ); ?>" alt="">
              </div>
              <div class="post-author-info">
                <img src="<?php echo esc_url( "$ico/telegram.svg" ); ?>" alt="Telegram" width="20" height="17">
                <span class="post-author-name">vvv rtm</span>
              </div>
            </div>
            <h3 class="post-title">Fact + new forecast.<br>Frame 1H/4H.<br>Not an investment recommendation.</h3>
            <div class="post-meta">
              <span>#PENDLEUSDT</span>
              <time>Today 10:13</time>
            </div>
          </div>
          <div class="post-card-right" aria-hidden="true"></div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

</section>
