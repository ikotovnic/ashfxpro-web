<?php

function ashfxpro_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption', 'script', 'style' ] );

    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'ashfxpro' ),
    ] );
}
add_action( 'after_setup_theme', 'ashfxpro_setup' );

function ashfxpro_dequeue_wp_defaults() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'classic-theme-styles' );
    wp_dequeue_style( 'global-styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'wp_enqueue_scripts', 'ashfxpro_dequeue_wp_defaults', 20 );

function ashfxpro_enqueue_assets() {
    wp_enqueue_style(
        'google-fonts-montserrat',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400;600;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'ashfxpro-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'google-fonts-montserrat' ],
        '1.7.0'
    );
    wp_enqueue_script(
        'ashfxpro-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.7.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'ashfxpro_enqueue_assets' );

/**
 * Register translatable strings for Polylang.
 * Edit translations at: Languages → Translations in WP admin.
 */
function ashfxpro_register_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) {
        return;
    }
    $group = 'ashfxpro';

    $strings = [
        // Hero
        'hero_headline'     => 'Look deeper. Trade smarter.',
        // Stats
        'stat_last_signals' => 'Last 500 signals',
        'stat_all_tickets'  => 'All tickets',
        'stat_total_return' => 'Total Return',
        'stat_verify'       => 'Verify Track Record',
        'stat_total_profit' => 'Total Profit',
        'stat_drawdown'     => 'Max Drawdown',
        'stat_rr'           => 'Average R/R',
        'stat_activity'     => 'Activity',
        'stat_month'        => 'Month',
        'stat_publications' => 'Publications in May',
        'stat_top_req'      => 'Top requests',
        'stat_analytics'    => 'Personal analytics',
        // Publications
        'pub_title'         => 'Recent publications',
        'pub_post_title'    => 'Fact + new forecast. Frame 1H/4H. Not an investment recommendation.',
        // Access
        'access_heading'    => "Прямой доступ\nбез Telegram\nи VPN",
        'access_desc'       => 'Чтобы вы не зависели от стабильности telegram, мы создали автономное веб-приложение. Это гарантирует получение сигналов и доступ к постам в любой ситуации, даже при технических сбоях',
        'access_feat1'      => 'Полное дублирование всего контента',
        'access_feat2'      => 'Доступ без VPN и блокировок',
        'access_feat3'      => 'Синхронизация в реальном времени',
        'pwa_btn'           => 'Перейти в веб-приложение',
        'pwa_title'         => 'PWA (Progressive Web App)',
        'pwa_desc'          => 'Добавьте приложение на главный экран, чтобы получать сигналы мгновенно и без ограничений',
        // Book
        'book_label'        => 'Готовится к выходу',
        'book_title'        => 'Книга «Язык Графика»',
        'book_desc'         => 'Весь мой опыт в текстовом издании. Для тех, кто ценит фундаментальные знания',
        // Nav
        'nav_about'         => 'About us',
        'nav_track'         => 'Track Record',
        'nav_prices'        => 'Prices',
        'nav_education'     => 'Education',
        'nav_contact'       => 'Contact',
        // Footer
        'footer_disclaimer' => 'Используя сайт, вы соглашаетесь с обработкой технических данных (cookies, IP) в целях аналитики. Информация на сайте не является инвестиционной рекомендацией. Торговля сопряжена с риском потери капитала.',
    ];

    foreach ( $strings as $name => $default ) {
        pll_register_string( $name, $default, $group );
    }
}
add_action( 'init', 'ashfxpro_register_strings' );

// ── Helpers ───────────────────────────────────────────────────────────────────
function ashfxpro_hex_rgba( $hex, $alpha ) {
    $hex = ltrim( $hex, '#' );
    if ( strlen( $hex ) === 3 ) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    return 'rgba(' . hexdec( substr( $hex, 0, 2 ) ) . ','
                   . hexdec( substr( $hex, 2, 2 ) ) . ','
                   . hexdec( substr( $hex, 4, 2 ) ) . ','
                   . $alpha . ')';
}

// ── Stats: default data ───────────────────────────────────────────────────────
function ashfxpro_donut_defaults() {
    return [
        'total_count'  => 1365,
        'period_label' => 'May',
        'segments'     => [
            ['label' => 'Russia', 'value' => 40, 'color' => '#00a1ff'],
            ['label' => 'World',  'value' => 30, 'color' => '#0cd241'],
            ['label' => 'Crypto', 'value' => 20, 'color' => '#c1d20c'],
            ['label' => 'FX',     'value' => 5,  'color' => '#d23d0c'],
            ['label' => 'Com',    'value' => 5,  'color' => '#ff9900'],
        ],
        'bars' => [
            ['ticker' => 'IRUS',     'value' => 420, 'color' => '#8800ff'],
            ['ticker' => 'BTC/USDT', 'value' => 336, 'color' => '#0062ff'],
            ['ticker' => 'ETH/USDT', 'value' => 380, 'color' => '#d23e0c'],
            ['ticker' => 'AFLT',     'value' => 152, 'color' => '#c1d20c'],
            ['ticker' => 'CCH6',     'value' => 200, 'color' => '#0cd241'],
        ],
    ];
}

// ── Admin settings page (Settings › AshFXPro Stats) ───────────────────────────
add_action( 'admin_menu', function () {
    add_options_page( 'AshFXPro Stats', 'AshFXPro Stats', 'manage_options', 'ashfxpro-stats', 'ashfxpro_stats_page' );
} );

function ashfxpro_stats_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( isset( $_POST['_wpnonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'ashfxpro_stats_save' ) ) {

        $saved = ashfxpro_donut_defaults();
        $saved['total_count']  = absint( $_POST['total_count'] ?? $saved['total_count'] );
        $saved['period_label'] = sanitize_text_field( wp_unslash( $_POST['period_label'] ?? $saved['period_label'] ) );

        foreach ( $saved['segments'] as $i => &$seg ) {
            if ( isset( $_POST[ 'seg_' . $i ] ) ) {
                $seg['value'] = max( 0, absint( $_POST[ 'seg_' . $i ] ) );
            }
        }
        unset( $seg );

        $saved['bars'] = [];
        for ( $i = 0; $i < 5; $i++ ) {
            $ticker = sanitize_text_field( wp_unslash( $_POST[ "bar_{$i}_ticker" ] ?? '' ) );
            $value  = absint( $_POST[ "bar_{$i}_value" ] ?? 0 );
            $color  = sanitize_hex_color( $_POST[ "bar_{$i}_color" ] ?? '#000000' ) ?: '#000000';
            if ( $ticker !== '' ) {
                $saved['bars'][] = [ 'ticker' => $ticker, 'value' => $value, 'color' => $color ];
            }
        }

        update_option( 'ashfxpro_donut_chart', $saved );
        echo '<div class="notice notice-success is-dismissible"><p>Saved.</p></div>';
    }

    $chart = get_option( 'ashfxpro_donut_chart', ashfxpro_donut_defaults() );
    ?>
    <div class="wrap">
    <h1>AshFXPro — Stats</h1>
    <form method="post">
        <?php wp_nonce_field( 'ashfxpro_stats_save' ); ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="total_count">Publications count</label></th>
                <td><input id="total_count" name="total_count" type="number" class="regular-text"
                           value="<?php echo esc_attr( $chart['total_count'] ); ?>"></td>
            </tr>
            <tr>
                <th scope="row"><label for="period_label">Period label</label></th>
                <td><input id="period_label" name="period_label" type="text" class="regular-text"
                           value="<?php echo esc_attr( $chart['period_label'] ); ?>"></td>
            </tr>
            <?php foreach ( $chart['segments'] as $i => $seg ) : ?>
            <tr>
                <th scope="row"><?php echo esc_html( $seg['label'] ); ?> (%)</th>
                <td><input name="seg_<?php echo $i; ?>" type="number" class="small-text"
                           value="<?php echo esc_attr( $seg['value'] ); ?>" min="0" max="100"></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h2 style="margin-top:24px;">Bar Chart — Top Requests</h2>
        <p>Values in absolute units. Sorted descending; top 5 shown. Heights are proportional to the max value.</p>
        <table class="form-table" role="presentation">
            <?php
            $bars_saved = array_pad( $chart['bars'] ?? [], 5, [ 'ticker' => '', 'value' => 0, 'color' => '#000000' ] );
            for ( $i = 0; $i < 5; $i++ ) :
                $b = $bars_saved[ $i ];
            ?>
            <tr>
                <th scope="row">Bar <?php echo $i + 1; ?></th>
                <td>
                    <input name="bar_<?php echo $i; ?>_ticker" type="text" placeholder="Ticker"
                           value="<?php echo esc_attr( $b['ticker'] ); ?>" style="width:120px;">
                    &nbsp;
                    <input name="bar_<?php echo $i; ?>_value" type="number" placeholder="Value"
                           value="<?php echo esc_attr( $b['value'] ); ?>" class="small-text" min="0">
                    &nbsp;
                    <input name="bar_<?php echo $i; ?>_color" type="color"
                           value="<?php echo esc_attr( $b['color'] ); ?>">
                </td>
            </tr>
            <?php endfor; ?>
        </table>
        <?php submit_button( 'Save changes' ); ?>
    </form>
    </div>
    <?php
}

// ── REST API endpoint for external service ────────────────────────────────────
// POST /wp-json/ashfxpro/v1/stats/donut
// Auth: WordPress Application Password (Users › Profile › Application Passwords)
// Body: { "total_count": 1420, "period_label": "June",
//         "segments": [{"value":42},{"value":28},{"value":20},{"value":5},{"value":5}] }
add_action( 'rest_api_init', function () {
    register_rest_route( 'ashfxpro/v1', '/stats/donut', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'ashfxpro_rest_update_donut',
        'permission_callback' => function () { return current_user_can( 'manage_options' ); },
    ] );
} );

function ashfxpro_rest_update_donut( WP_REST_Request $req ) {
    $body = $req->get_json_params();
    if ( empty( $body ) ) {
        return new WP_Error( 'invalid_data', 'JSON body required.', [ 'status' => 400 ] );
    }
    $chart = get_option( 'ashfxpro_donut_chart', ashfxpro_donut_defaults() );
    if ( isset( $body['total_count'] ) )  { $chart['total_count']  = absint( $body['total_count'] ); }
    if ( isset( $body['period_label'] ) ) { $chart['period_label'] = sanitize_text_field( $body['period_label'] ); }
    if ( isset( $body['segments'] ) && is_array( $body['segments'] ) ) {
        foreach ( $chart['segments'] as $i => &$seg ) {
            if ( isset( $body['segments'][ $i ]['value'] ) ) {
                $seg['value'] = max( 0, absint( $body['segments'][ $i ]['value'] ) );
            }
        }
        unset( $seg );
    }
    if ( isset( $body['bars'] ) && is_array( $body['bars'] ) ) {
        $chart['bars'] = array_map( function ( $b ) {
            return [
                'ticker' => sanitize_text_field( $b['ticker'] ?? '' ),
                'value'  => max( 0, absint( $b['value'] ?? 0 ) ),
                'color'  => sanitize_hex_color( $b['color'] ?? '#000000' ) ?: '#000000',
            ];
        }, $body['bars'] );
    }
    update_option( 'ashfxpro_donut_chart', $chart );
    return new WP_REST_Response( [ 'ok' => true, 'data' => $chart ], 200 );
}

// ── Publications ──────────────────────────────────────────────────────────────
function ashfxpro_publications_defaults() {
    $img = get_template_directory_uri() . '/assets/images';
    return [
        [ 'tg_url' => '#', 'image_url' => $img . '/post-bg1.jpg', 'date' => gmdate( 'c' ),
          'text'   => 'Fact + new forecast. Frame 1H/4H. Not an investment recommendation. #PENDLEUSDT' ],
        [ 'tg_url' => '#', 'image_url' => $img . '/post-bg2.jpg', 'date' => gmdate( 'c', strtotime( '-1 day' ) ),
          'text'   => 'Technical setup confirmed. Entry zone reached. #BTCUSDT #crypto' ],
        [ 'tg_url' => '#', 'image_url' => $img . '/post-bg3.jpg', 'date' => gmdate( 'c', strtotime( '-2 days' ) ),
          'text'   => 'Strong momentum. Watch the 4H close. #ETHUSDT' ],
        [ 'tg_url' => '#', 'image_url' => $img . '/post-bg4.jpg', 'date' => gmdate( 'c', strtotime( '-3 days' ) ),
          'text'   => 'Breakout pattern forming. Not an investment recommendation. #IRUS #AFLT' ],
        [ 'tg_url' => '#', 'image_url' => $img . '/post-bg1.jpg', 'date' => gmdate( 'c', strtotime( '-4 days' ) ),
          'text'   => 'Key level reaction. Frame 1H. #CCH6 #futures' ],
    ];
}

function ashfxpro_format_pub_date( $date_str ) {
    try {
        $dt = new DateTime( $date_str );
    } catch ( Exception $e ) {
        return esc_html( $date_str );
    }
    $today     = new DateTime( 'today' );
    $yesterday = new DateTime( 'yesterday' );
    $dt_day    = ( clone $dt )->setTime( 0, 0, 0 );
    if ( $dt_day == $today )     { return 'Today ' . $dt->format( 'H:i' ); }
    if ( $dt_day == $yesterday ) { return 'Yesterday ' . $dt->format( 'H:i' ); }
    return $dt->format( 'j M H:i' );
}

// Publications admin page (Settings › AshFXPro Publications)
add_action( 'admin_menu', function () {
    add_options_page( 'AshFXPro Publications', 'AshFXPro Publications', 'manage_options', 'ashfxpro-pubs', 'ashfxpro_pubs_page' );
} );

function ashfxpro_pubs_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    if ( isset( $_POST['_wpnonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'ashfxpro_pubs_save' ) ) {
        $saved = [];
        for ( $i = 0; $i < 5; $i++ ) {
            $tg    = esc_url_raw( wp_unslash( $_POST[ "pub_{$i}_tg" ]    ?? '' ) );
            $img   = esc_url_raw( wp_unslash( $_POST[ "pub_{$i}_img" ]   ?? '' ) );
            $date  = sanitize_text_field( wp_unslash( $_POST[ "pub_{$i}_date" ] ?? '' ) );
            $text  = sanitize_textarea_field( wp_unslash( $_POST[ "pub_{$i}_text" ] ?? '' ) );
            if ( $tg || $text ) {
                $saved[] = [ 'tg_url' => $tg, 'image_url' => $img, 'date' => $date, 'text' => $text ];
            }
        }
        update_option( 'ashfxpro_publications', $saved );
        echo '<div class="notice notice-success is-dismissible"><p>Saved.</p></div>';
    }

    $pubs = get_option( 'ashfxpro_publications', ashfxpro_publications_defaults() );
    $pubs = array_pad( $pubs, 5, [ 'tg_url' => '', 'image_url' => '', 'date' => '', 'text' => '' ] );
    ?>
    <div class="wrap">
    <h1>AshFXPro — Publications</h1>
    <p>Up to 5 posts. Sorted by date descending by the external service.</p>
    <form method="post">
        <?php wp_nonce_field( 'ashfxpro_pubs_save' ); ?>
        <?php for ( $i = 0; $i < 5; $i++ ) : $p = $pubs[$i]; ?>
        <h2>Post <?php echo $i + 1; ?></h2>
        <table class="form-table" role="presentation">
            <tr><th>Telegram URL</th><td><input name="pub_<?php echo $i; ?>_tg" type="url" class="regular-text"
                value="<?php echo esc_attr( $p['tg_url'] ); ?>"></td></tr>
            <tr><th>Image URL</th><td><input name="pub_<?php echo $i; ?>_img" type="url" class="regular-text"
                value="<?php echo esc_attr( $p['image_url'] ); ?>"></td></tr>
            <tr><th>Date (ISO 8601)</th><td><input name="pub_<?php echo $i; ?>_date" type="datetime-local" class="regular-text"
                value="<?php echo esc_attr( str_replace( '+00:00', '', $p['date'] ) ); ?>"></td></tr>
            <tr><th>Text (with #hashtags)</th><td><textarea name="pub_<?php echo $i; ?>_text" rows="3"
                class="large-text"><?php echo esc_textarea( $p['text'] ); ?></textarea></td></tr>
        </table>
        <?php endfor; ?>
        <?php submit_button( 'Save changes' ); ?>
    </form>
    </div>
    <?php
}

// ── Info section ─────────────────────────────────────────────────────────────
function ashfxpro_info_defaults() {
    return [
        'subtitle' => 'Понятные торговые сигналы с проверяемой историей — от трейдера, который сам торгует на свои деньги.',
        'stats'    => [
            [ 'value' => '10+',    'label' => 'лет опыта в трейдинге' ],
            [ 'value' => '19900+', 'label' => 'подписчиков в Telegram' ],
            [ 'value' => '1000+',  'label' => 'сигналов за 2024 год' ],
        ],
    ];
}

add_action( 'admin_menu', function () {
    add_options_page( 'AshFXPro Info', 'AshFXPro Info', 'manage_options', 'ashfxpro-info', 'ashfxpro_info_page' );
} );

function ashfxpro_info_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    if ( isset( $_POST['_wpnonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'ashfxpro_info_save' ) ) {
        $saved = [
            'subtitle' => sanitize_textarea_field( wp_unslash( $_POST['subtitle'] ?? '' ) ),
            'stats'    => [],
        ];
        for ( $i = 0; $i < 3; $i++ ) {
            $saved['stats'][] = [
                'value' => sanitize_text_field( wp_unslash( $_POST[ "stat_{$i}_value" ] ?? '' ) ),
                'label' => sanitize_text_field( wp_unslash( $_POST[ "stat_{$i}_label" ] ?? '' ) ),
            ];
        }
        update_option( 'ashfxpro_info', $saved );
        echo '<div class="notice notice-success is-dismissible"><p>Saved.</p></div>';
    }

    $info  = get_option( 'ashfxpro_info', ashfxpro_info_defaults() );
    $stats = array_pad( $info['stats'] ?? [], 3, [ 'value' => '', 'label' => '' ] );
    ?>
    <div class="wrap">
    <h1>AshFXPro — Info section</h1>
    <form method="post">
        <?php wp_nonce_field( 'ashfxpro_info_save' ); ?>
        <table class="form-table" role="presentation">
            <tr>
                <th scope="row"><label for="subtitle">Subtitle</label></th>
                <td><textarea id="subtitle" name="subtitle" rows="3" class="large-text"><?php echo esc_textarea( $info['subtitle'] ?? '' ); ?></textarea></td>
            </tr>
            <?php for ( $i = 0; $i < 3; $i++ ) : $s = $stats[ $i ]; ?>
            <tr>
                <th scope="row">Stat <?php echo $i + 1; ?></th>
                <td>
                    <input name="stat_<?php echo $i; ?>_value" type="text" placeholder="e.g. 10+" class="regular-text"
                           value="<?php echo esc_attr( $s['value'] ); ?>">
                    &nbsp;
                    <input name="stat_<?php echo $i; ?>_label" type="text" placeholder="Label" class="regular-text"
                           value="<?php echo esc_attr( $s['label'] ); ?>">
                </td>
            </tr>
            <?php endfor; ?>
        </table>
        <?php submit_button( 'Save changes' ); ?>
    </form>
    </div>
    <?php
}

// POST /wp-json/ashfxpro/v1/info
add_action( 'rest_api_init', function () {
    register_rest_route( 'ashfxpro/v1', '/info', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'ashfxpro_rest_update_info',
        'permission_callback' => function () { return current_user_can( 'manage_options' ); },
    ] );
} );

function ashfxpro_rest_update_info( WP_REST_Request $req ) {
    $body = $req->get_json_params();
    if ( empty( $body ) ) {
        return new WP_Error( 'invalid_data', 'JSON body required.', [ 'status' => 400 ] );
    }
    $info = get_option( 'ashfxpro_info', ashfxpro_info_defaults() );
    if ( isset( $body['subtitle'] ) ) {
        $info['subtitle'] = sanitize_textarea_field( $body['subtitle'] );
    }
    if ( isset( $body['stats'] ) && is_array( $body['stats'] ) ) {
        $info['stats'] = array_map( function ( $s ) {
            return [
                'value' => sanitize_text_field( $s['value'] ?? '' ),
                'label' => sanitize_text_field( $s['label'] ?? '' ),
            ];
        }, array_slice( $body['stats'], 0, 3 ) );
    }
    update_option( 'ashfxpro_info', $info );
    return new WP_REST_Response( [ 'ok' => true, 'data' => $info ], 200 );
}

// ── Forecasts (cards-stack) ───────────────────────────────────────────────────
function ashfxpro_forecasts_defaults() {
    return [
        [ 'image_url' => '', 'ticker' => 'BTC/USDT', 'title' => 'Прогноз на рост: пробой уровня сопротивления подтверждён', 'date' => 'Янв 2024', 'channel_name' => 'AshFXPro', 'channel_url' => '#' ],
        [ 'image_url' => '', 'ticker' => 'ETH/USDT', 'title' => 'Разворот от ключевой поддержки на таймфрейме 4H', 'date' => 'Фев 2024', 'channel_name' => 'AshFXPro', 'channel_url' => '#' ],
        [ 'image_url' => '', 'ticker' => 'IRUS',     'title' => 'Импульсный выход после консолидации', 'date' => 'Мар 2024', 'channel_name' => 'AshFXPro', 'channel_url' => '#' ],
        [ 'image_url' => '', 'ticker' => 'AFLT',     'title' => 'Коррекция завершена, возобновление восходящего тренда', 'date' => 'Апр 2024', 'channel_name' => 'AshFXPro', 'channel_url' => '#' ],
        [ 'image_url' => '', 'ticker' => 'CCH6',     'title' => 'Накопление перед следующим движением', 'date' => 'Май 2024', 'channel_name' => 'AshFXPro', 'channel_url' => '#' ],
    ];
}

add_action( 'admin_menu', function () {
    add_options_page( 'AshFXPro Forecasts', 'AshFXPro Forecasts', 'manage_options', 'ashfxpro-forecasts', 'ashfxpro_forecasts_page' );
} );

function ashfxpro_forecasts_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    if ( isset( $_POST['_wpnonce'] ) &&
         wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'ashfxpro_forecasts_save' ) ) {
        $saved = [];
        for ( $i = 0; $i < 5; $i++ ) {
            $saved[] = [
                'image_url'    => esc_url_raw( wp_unslash( $_POST[ "fc_{$i}_img" ]     ?? '' ) ),
                'ticker'       => sanitize_text_field( wp_unslash( $_POST[ "fc_{$i}_ticker" ]  ?? '' ) ),
                'title'        => sanitize_text_field( wp_unslash( $_POST[ "fc_{$i}_title" ]   ?? '' ) ),
                'date'         => sanitize_text_field( wp_unslash( $_POST[ "fc_{$i}_date" ]    ?? '' ) ),
                'channel_name' => sanitize_text_field( wp_unslash( $_POST[ "fc_{$i}_chname" ]  ?? '' ) ),
                'channel_url'  => esc_url_raw( wp_unslash( $_POST[ "fc_{$i}_churl" ]  ?? '' ) ),
            ];
        }
        update_option( 'ashfxpro_forecasts', $saved );
        echo '<div class="notice notice-success is-dismissible"><p>Saved.</p></div>';
    }

    $forecasts = get_option( 'ashfxpro_forecasts', ashfxpro_forecasts_defaults() );
    $blank     = [ 'image_url' => '', 'ticker' => '', 'title' => '', 'date' => '', 'channel_name' => '', 'channel_url' => '' ];
    $forecasts = array_pad( $forecasts, 5, $blank );
    ?>
    <div class="wrap">
    <h1>AshFXPro — Forecasts (cards)</h1>
    <p>Exactly 5 cards. Image URL, ticker badge, title, date string, and Telegram channel.</p>
    <form method="post">
        <?php wp_nonce_field( 'ashfxpro_forecasts_save' ); ?>
        <?php for ( $i = 0; $i < 5; $i++ ) : $f = $forecasts[ $i ]; ?>
        <h2>Card <?php echo $i + 1; ?></h2>
        <table class="form-table" role="presentation">
            <tr><th>Image URL</th><td><input name="fc_<?php echo $i; ?>_img" type="url" class="large-text"
                value="<?php echo esc_attr( $f['image_url'] ); ?>"></td></tr>
            <tr><th>Ticker</th><td><input name="fc_<?php echo $i; ?>_ticker" type="text" class="regular-text"
                value="<?php echo esc_attr( $f['ticker'] ); ?>"></td></tr>
            <tr><th>Title</th><td><input name="fc_<?php echo $i; ?>_title" type="text" class="large-text"
                value="<?php echo esc_attr( $f['title'] ); ?>"></td></tr>
            <tr><th>Date</th><td><input name="fc_<?php echo $i; ?>_date" type="text" class="regular-text"
                placeholder="e.g. Май 2024" value="<?php echo esc_attr( $f['date'] ); ?>"></td></tr>
            <tr><th>Channel name</th><td><input name="fc_<?php echo $i; ?>_chname" type="text" class="regular-text"
                value="<?php echo esc_attr( $f['channel_name'] ); ?>"></td></tr>
            <tr><th>Channel URL</th><td><input name="fc_<?php echo $i; ?>_churl" type="url" class="large-text"
                value="<?php echo esc_attr( $f['channel_url'] ); ?>"></td></tr>
        </table>
        <?php endfor; ?>
        <?php submit_button( 'Save changes' ); ?>
    </form>
    </div>
    <?php
}

// POST /wp-json/ashfxpro/v1/forecasts
// Body: array of 5 objects { image_url, ticker, title, date, channel_name, channel_url }
add_action( 'rest_api_init', function () {
    register_rest_route( 'ashfxpro/v1', '/forecasts', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'ashfxpro_rest_update_forecasts',
        'permission_callback' => function () { return current_user_can( 'manage_options' ); },
    ] );
} );

function ashfxpro_rest_update_forecasts( WP_REST_Request $req ) {
    $body = $req->get_json_params();
    if ( ! is_array( $body ) || empty( $body ) ) {
        return new WP_Error( 'invalid_data', 'Expected a JSON array of 5 forecast objects.', [ 'status' => 400 ] );
    }
    $saved = [];
    foreach ( array_slice( $body, 0, 5 ) as $f ) {
        $saved[] = [
            'image_url'    => esc_url_raw( $f['image_url']    ?? '' ),
            'ticker'       => sanitize_text_field( $f['ticker']       ?? '' ),
            'title'        => sanitize_text_field( $f['title']        ?? '' ),
            'date'         => sanitize_text_field( $f['date']         ?? '' ),
            'channel_name' => sanitize_text_field( $f['channel_name'] ?? '' ),
            'channel_url'  => esc_url_raw( $f['channel_url']  ?? '' ),
        ];
    }
    update_option( 'ashfxpro_forecasts', $saved );
    return new WP_REST_Response( [ 'ok' => true, 'count' => count( $saved ) ], 200 );
}

// POST /wp-json/ashfxpro/v1/publications
// Body: array of { tg_url, image_url, date, text } — replaces all 5 posts
add_action( 'rest_api_init', function () {
    register_rest_route( 'ashfxpro/v1', '/publications', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'ashfxpro_rest_update_pubs',
        'permission_callback' => function () { return current_user_can( 'manage_options' ); },
    ] );
} );

function ashfxpro_rest_update_pubs( WP_REST_Request $req ) {
    $body = $req->get_json_params();
    if ( ! is_array( $body ) || empty( $body ) ) {
        return new WP_Error( 'invalid_data', 'Expected a JSON array of posts.', [ 'status' => 400 ] );
    }
    $saved = [];
    foreach ( array_slice( $body, 0, 5 ) as $p ) {
        $saved[] = [
            'tg_url'    => esc_url_raw( $p['tg_url']    ?? '' ),
            'image_url' => esc_url_raw( $p['image_url'] ?? '' ),
            'date'      => sanitize_text_field( $p['date'] ?? '' ),
            'text'      => sanitize_textarea_field( $p['text'] ?? '' ),
        ];
    }
    update_option( 'ashfxpro_publications', $saved );
    return new WP_REST_Response( [ 'ok' => true, 'count' => count( $saved ) ], 200 );
}
