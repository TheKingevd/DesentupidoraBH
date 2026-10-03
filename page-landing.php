<?php
$DBH_SETTINGS = function_exists( 'dbh_settings' ) ? dbh_settings() : array();
$DBH_TRACKING = ! empty( $DBH_SETTINGS['tracking_enabled'] );
$DBH_GA4_ID = isset( $DBH_SETTINGS['ga4_id'] ) ? $DBH_SETTINGS['ga4_id'] : '';
$DBH_GTM_ID = isset( $DBH_SETTINGS['gtm_id'] ) ? $DBH_SETTINGS['gtm_id'] : '';
$DBH_ADS_ID = isset( $DBH_SETTINGS['ads_id'] ) ? $DBH_SETTINGS['ads_id'] : '';
$DBH_ADS_LABEL = isset( $DBH_SETTINGS['ads_label'] ) ? $DBH_SETTINGS['ads_label'] : '';
$DBH_SEARCH_CONSOLE = isset( $DBH_SETTINGS['search_console'] ) ? $DBH_SETTINGS['search_console'] : '';
$DBH_META_PIXEL = isset( $DBH_SETTINGS['meta_pixel'] ) ? $DBH_SETTINGS['meta_pixel'] : '';
$DBH_TELEFONE = isset( $DBH_SETTINGS['telefone'] ) ? $DBH_SETTINGS['telefone'] : '(31) 99267-6876';
$DBH_WHATSAPP = isset( $DBH_SETTINGS['whatsapp'] ) ? $DBH_SETTINGS['whatsapp'] : '5531992676876';
$DBH_WHATSAPP_MSG = isset( $DBH_SETTINGS['whatsapp_msg'] ) ? $DBH_SETTINGS['whatsapp_msg'] : 'Olá, vim por meio do site do google, e gostaria de solicitar um orçamento para desentupimento.';
$DBH_TITULO = isset( $DBH_SETTINGS['titulo'] ) ? $DBH_SETTINGS['titulo'] : 'Esgoto entupido? Resolvemos hoje.';
$DBH_DESCRICAO = isset( $DBH_SETTINGS['descricao'] ) ? $DBH_SETTINGS['descricao'] : 'Desentupimento de esgoto, pias, ralos, vasos e tanques, além de água pluvial e troca de rede de esgoto. Chegamos rápido em Belo Horizonte e região metropolitana, com orçamento gratuito e garantia.';
$DBH_BLOG_PATH = isset( $DBH_SETTINGS['blog_path'] ) ? $DBH_SETTINGS['blog_path'] : '/blog';

$DBH_LOGO            = get_stylesheet_directory_uri() . '/desentupidora-logo.png';
$DBH_FAVICON_SVG     = get_stylesheet_directory_uri() . '/desentupidora-favicon.svg';
$DBH_FAVICON_ICO     = get_stylesheet_directory_uri() . '/desentupidora-favicon.ico';
$DBH_FAVICON_TOUCH   = get_stylesheet_directory_uri() . '/desentupidora-favicon-256.png';
$DBH_HERO_IMAGE      = 'https://images.pexels.com/photos/12880833/pexels-photo-12880833.jpeg?auto=compress&cs=tinysrgb&w=1600';
$DBH_CSS_URL         = get_stylesheet_directory_uri() . '/landing.css';

$dbh_cidades = array(
  'Belo Horizonte', 'Contagem', 'Betim', 'Nova Lima', 'Brumadinho', 'Sabará',
  'Ouro Preto', 'Mariana', 'Ibirité', 'Sarzedo', 'Itabirito', 'Lagoa Santa',
  'Santa Luzia', 'Vespasiano', 'Sete Lagoas', 'Juatuba', 'Itaúna', 'Nova Serrana',
  'Pitangui', 'Venda Nova — Belo Horizonte',
);

$dbh_servicos = array(
  array( 'titulo' => 'Rede de esgoto', 'texto' => 'Desobstrução de colunas e redes de esgoto com máquinas rotativas e hidrojateamento. Localizamos o ponto exato do problema.' ),
  array( 'titulo' => 'Pias', 'texto' => 'Pia de cozinha e banheiro com gordura ou resíduos acumulados. Voltamos o escoamento normal no mesmo dia.' ),
  array( 'titulo' => 'Ralos', 'texto' => 'Ralos de banheiro, box, área de serviço e varanda. Remoção completa do entupimento, sem sujeira.' ),
  array( 'titulo' => 'Vasos sanitários', 'texto' => 'Vaso com retorno de água ou descarga lenta, resolvido com equipamento próprio, sem quebrar louça ou piso.' ),
  array( 'titulo' => 'Tanques', 'texto' => 'Tanque de lavar roupa e área de serviço travados. Desentupimento rápido e limpo.' ),
  array( 'titulo' => 'Água pluvial', 'texto' => 'Calhas, canaletas, bueiros e ralos de chuva que não escoam. Limpeza e desobstrução antes da próxima chuva.' ),
  array( 'titulo' => 'Troca de rede de esgoto', 'texto' => 'Substituição de tubulação de esgoto antiga ou rompida, com o mínimo de intervenção e garantia no serviço.', 'destaque' => true ),
  array( 'titulo' => 'Caixa de gordura', 'texto' => 'Limpeza de caixa de gordura para evitar mau cheiro, retorno de água pela pia e entupimentos recorrentes.' ),
);

$dbh_vantagens = array(
  array( 'titulo' => 'Orçamento gratuito', 'texto' => 'Visita técnica e orçamento sem custo e sem compromisso.' ),
  array( 'titulo' => 'Garantia nos serviços', 'texto' => 'Se o mesmo ponto entupir dentro do prazo, voltamos sem cobrar.' ),
  array( 'titulo' => 'Pagamento facilitado', 'texto' => 'Cartão de crédito, débito, Pix e dinheiro.' ),
  array( 'titulo' => 'Equipe uniformizada', 'texto' => 'Técnicos capacitados, identificados e com equipamento próprio.' ),
);

$dbh_sobre = array(
  'Atendimento imediato em toda a região',
  'Funcionamento 24 horas, inclusive feriados',
  'Garantia em todos os serviços',
  'Técnicos uniformizados e capacitados',
  'Preço justo e orçamento direto pelo WhatsApp',
  'Respeito ao cliente e compromisso com a solução',
);

$dbh_faq = array(
  array( 'p' => 'Quando devo chamar uma desentupidora?', 'r' => 'Quando os métodos caseiros não resolvem, o entupimento se repete, há mau cheiro nos ralos, a água retorna pelo ralo ou vaso, ou a drenagem está lenta. Esses sinais indicam obstrução na tubulação e pedem atendimento profissional para evitar danos maiores.' ),
  array( 'p' => 'Qual o valor médio do serviço?', 'r' => 'Depende do tipo de entupimento e da complexidade. Em média os valores ficam entre R$ 200 e R$ 550. Para um valor exato, mande uma foto ou vídeo pelo WhatsApp que retornamos com o orçamento, ou agende a visita gratuita.' ),
  array( 'p' => 'Como funciona o orçamento?', 'r' => 'A equipe vai até o local, avalia o problema e apresenta o valor antes de começar. A visita é gratuita e sem compromisso. Só executamos o serviço com a sua aprovação.' ),
  array( 'p' => 'O desentupimento quebra parede ou piso?', 'r' => 'Na grande maioria dos casos, não. Trabalhamos com máquinas rotativas, sondas e câmeras de inspeção que resolvem sem intervenção na estrutura. Quando é necessário abrir algum ponto, avisamos antes.' ),
  array( 'p' => 'Vocês atendem de madrugada, fim de semana e feriado?', 'r' => 'Sim. O plantão é 24 horas, todos os dias, inclusive feriados. Emergência não escolhe hora.' ),
  array( 'p' => 'Atendem fora de Belo Horizonte?', 'r' => 'Sim. Além da região metropolitana, atendemos chamados em cidades a até 100 ou 110 km de BH. É só chamar no WhatsApp e confirmar a sua cidade.' ),
);

$dbh_site_url = 'https://' . preg_replace( '#^www\.#', '', (string) wp_parse_url( home_url(), PHP_URL_HOST ) );

$dbh_tel_digits     = preg_replace( '/\D/', '', $DBH_TELEFONE );
$dbh_tel_href       = 'tel:+' . ( strpos( $dbh_tel_digits, '55' ) === 0 ? $dbh_tel_digits : '55' . $dbh_tel_digits );
$dbh_whatsapp_digits = preg_replace( '/\D/', '', $DBH_WHATSAPP );
$dbh_whatsapp_url   = 'https://wa.me/' . $dbh_whatsapp_digits . '?text=' . rawurlencode( $DBH_WHATSAPP_MSG );
$dbh_blog_url       = $DBH_BLOG_PATH ? home_url( $DBH_BLOG_PATH ) : '';

$dbh_schema_empresa = array(
  '@context'      => 'https://schema.org',
  '@type'         => array( 'LocalBusiness', 'Plumber' ),
  '@id'           => $dbh_site_url . '/#empresa',
  'name'          => 'Desentupidora BH 24H',
  'alternateName' => 'Desentupidora BH',
  'description'   => 'Serviço de desentupimento 24 horas em Belo Horizonte e região, com atendimento para esgoto, pias, ralos, vasos sanitários, tanques, caixas de gordura e água pluvial.',
  'url'           => $dbh_site_url,
  'telephone'     => '+5531992676876',
  'image'         => array( $dbh_site_url . '/logo.png' ),
  'logo'          => $dbh_site_url . '/logo.png',
  'areaServed'    => array_map(
    function ( $cidade ) {
      return array(
        '@type'            => 'City',
        'name'             => $cidade,
        'containedInPlace' => array( '@type' => 'State', 'name' => 'Minas Gerais' ),
      );
    },
    $dbh_cidades
  ),
  'serviceType'   => array(
    'Desentupimento de esgoto', 'Desentupimento de pia', 'Desentupimento de ralo',
    'Desentupimento de vaso sanitário', 'Desentupimento de tanque',
    'Limpeza de caixa de gordura', 'Desobstrução de água pluvial', 'Troca de rede de esgoto',
  ),
  'openingHoursSpecification' => array(
    array(
      '@type'     => 'OpeningHoursSpecification',
      'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' ),
      'opens'     => '00:00',
      'closes'    => '23:59',
    ),
  ),
  'contactPoint'  => array(
    '@type'             => 'ContactPoint',
    'telephone'         => '+5531992676876',
    'contactType'       => 'customer service',
    'availableLanguage' => array( 'pt-BR' ),
  ),
);

$dbh_schema_faq = array(
  '@context'   => 'https://schema.org',
  '@type'      => 'FAQPage',
  'mainEntity' => array_map(
    function ( $item ) {
      return array(
        '@type'          => 'Question',
        'name'           => $item['p'],
        'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item['r'] ),
      );
    },
    $dbh_faq
  ),
);

$dbh_gtag_primary = $DBH_GA4_ID ? $DBH_GA4_ID : $DBH_ADS_ID;

if ( ! function_exists( 'dbh_icon_whats' ) ) {

  function dbh_icon_whats() {
    return '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2Zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.6.8-.8 1-.3.2-.5.1a6.7 6.7 0 0 1-3.3-2.9c-.3-.4.2-.4.7-1.3.1-.2 0-.3 0-.4l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2 5.2 5.2 0 0 0 1.1 2.7 11.8 11.8 0 0 0 4.5 4c1.7.7 2.3.8 3.2.6a2.7 2.7 0 0 0 1.8-1.2 2.2 2.2 0 0 0 .1-1.3l-.6-.3Z"/></svg>';
  }

  function dbh_icon_fone() {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z"/></svg>';
  }

  function dbh_icon_cartao() {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 9h18M7 14h3M7 16h6"/></svg>';
  }

  function dbh_icon_dinheiro() {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="12" cy="12" r="3"/><path d="M6 9h.01M18 15h.01"/></svg>';
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo esc_html( $DBH_TITULO ); ?> | Desentupidora BH 24H</title>
<meta name="description" content="<?php echo esc_attr( $DBH_DESCRICAO ); ?>">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="Desentupidora BH 24H">
<meta name="theme-color" content="#111B39">
<meta name="geo.region" content="BR-MG">
<meta name="geo.placename" content="Belo Horizonte">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Desentupidora BH 24H">
<meta property="og:locale" content="pt_BR">
<meta property="og:title" content="<?php echo esc_attr( $DBH_TITULO ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $DBH_DESCRICAO ); ?>">
<meta property="og:url" content="<?php echo esc_url( $dbh_site_url ); ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="canonical" href="<?php echo esc_url( $dbh_site_url ); ?>">
<link rel="icon" href="<?php echo esc_url( $DBH_FAVICON_SVG ); ?>" type="image/svg+xml">
<link rel="icon" href="<?php echo esc_url( $DBH_FAVICON_ICO ); ?>" sizes="any">
<link rel="apple-touch-icon" href="<?php echo esc_url( $DBH_FAVICON_TOUCH ); ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap">
<link rel="stylesheet" href="<?php echo esc_url( $DBH_CSS_URL ); ?>">

<?php if ( $DBH_SEARCH_CONSOLE ) : ?>
<meta name="google-site-verification" content="<?php echo esc_attr( $DBH_SEARCH_CONSOLE ); ?>">
<?php endif; ?>

<?php if ( $DBH_TRACKING && $DBH_GTM_ID ) : ?>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?php echo esc_js( $DBH_GTM_ID ); ?>');</script>
<?php endif; ?>

<?php if ( $DBH_TRACKING && $dbh_gtag_primary ) : ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo rawurlencode( $dbh_gtag_primary ); ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){ dataLayer.push(arguments); }
  gtag('js', new Date());
  <?php if ( $DBH_GA4_ID ) : ?>gtag('config', <?php echo wp_json_encode( $DBH_GA4_ID ); ?>);<?php endif; ?>
  <?php if ( $DBH_ADS_ID ) : ?>gtag('config', <?php echo wp_json_encode( $DBH_ADS_ID ); ?>);<?php endif; ?>
</script>
<?php endif; ?>

<?php if ( $DBH_TRACKING && $DBH_META_PIXEL ) : ?>
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,"script","https://connect.facebook.net/en_US/fbevents.js");
fbq('init', <?php echo wp_json_encode( $DBH_META_PIXEL ); ?>);
fbq('track', 'PageView');
</script>
<?php endif; ?>

<script type="application/ld+json"><?php echo wp_json_encode( $dbh_schema_empresa, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
<script type="application/ld+json"><?php echo wp_json_encode( $dbh_schema_faq, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>

<noscript>
  <style>
    .dbh-reveal { opacity: 1 !important; transform: none !important; }
    .dbh-faq-answer { grid-template-rows: 1fr !important; opacity: 1 !important; }
  </style>
</noscript>
</head>
<body>
<?php if ( $DBH_TRACKING && $DBH_GTM_ID ) : ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo rawurlencode( $DBH_GTM_ID ); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php endif; ?>

<div class="dbh-page">

  <div class="dbh-scroll-progress" id="dbhScrollProgress" aria-hidden="true"></div>

  <header class="dbh-header" id="dbhHeader">
    <div class="dbh-header-inner">
      <a class="dbh-header-brand" href="#">
        <img class="dbh-header-logo" src="<?php echo esc_url( $DBH_LOGO ); ?>" alt="Desentupidora BH 24H">
        <span class="dbh-header-tagline">
          <strong>Atendimento 24 horas</strong>
          <small>Belo Horizonte e região</small>
        </span>
      </a>

      <nav class="dbh-nav" aria-label="Navegação principal">
        <a class="dbh-nav-link" href="#servicos">Serviços</a>
        <a class="dbh-nav-link" href="#cidades">Cidades</a>
        <a class="dbh-nav-link" href="#sobre">Sobre</a>
        <a class="dbh-nav-link" href="#duvidas">Dúvidas</a>
        <?php if ( $dbh_blog_url ) : ?>
          <a class="dbh-nav-link" href="<?php echo esc_url( $dbh_blog_url ); ?>">Blog</a>
        <?php endif; ?>
      </nav>

      <a class="dbh-btn dbh-header-cta" href="<?php echo esc_url( $dbh_whatsapp_url ); ?>" target="_blank" rel="noreferrer">
        <span class="dbh-dot dbh-dot--mint"></span>
        <span class="dbh-header-cta-phone"><?php echo esc_html( $DBH_TELEFONE ); ?></span>
        <span class="dbh-header-cta-short">WhatsApp</span>
      </a>
    </div>
  </header>

  <section class="dbh-container dbh-container--wide dbh-reveal dbh-hero">
    <div class="dbh-hero-copy">
      <span class="dbh-chip"><span class="dbh-dot dbh-dot--mint dbh-pulse"></span> Atendimento 24h · Emergência</span>
      <h1 class="dbh-hero-title"><?php echo esc_html( $DBH_TITULO ); ?></h1>
      <p class="dbh-hero-text"><?php echo esc_html( $DBH_DESCRICAO ); ?></p>

      <div class="dbh-hero-actions">
        <a class="dbh-btn dbh-btn--primary" href="<?php echo esc_url( $dbh_whatsapp_url ); ?>" target="_blank" rel="noreferrer">
          <?php echo dbh_icon_whats(); ?> Chamar no WhatsApp
        </a>
        <a class="dbh-btn dbh-btn--glass" href="<?php echo esc_url( $dbh_tel_href ); ?>">
          <?php echo dbh_icon_fone(); ?> Ligar agora
        </a>
      </div>

      <div class="dbh-hero-trust">
        <span><b class="dbh-star">★</b> Garantia em todos os serviços</span>
        <span><i class="dbh-dot dbh-dot--primary"></i> Orçamento gratuito</span>
      </div>
    </div>

    <div class="dbh-hero-media">
      <div class="dbh-hero-frame">
        <img class="dbh-hero-photo"
             src="<?php echo esc_url( $DBH_HERO_IMAGE ); ?>"
             alt="Profissional de manutenção hidráulica trabalhando em uma tubulação"
             width="1600" height="1067" loading="eager">
      </div>
      <div class="dbh-hero-badge" aria-label="Plantão 24 horas para emergências">
        <div class="dbh-hero-badge-logo">
          <img src="<?php echo esc_url( $DBH_LOGO ); ?>" alt="Desentupidora BH 24H">
        </div>
        <div class="dbh-hero-badge-copy">
          <span class="dbh-hero-badge-status"><i></i> Plantão ativo</span>
          <strong>Atendimento 24h</strong>
          <small>Emergências em BH e região</small>
        </div>
      </div>
    </div>
  </section>

  <section class="dbh-container dbh-container--wide dbh-reveal dbh-benefits">
    <div class="dbh-benefits-grid">
      <?php foreach ( $dbh_vantagens as $v ) : ?>
        <div class="dbh-glass dbh-benefit">
          <span class="dbh-dot dbh-dot--primary" style="display:block"></span>
          <h3><?php echo esc_html( $v['titulo'] ); ?></h3>
          <p><?php echo esc_html( $v['texto'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="servicos" class="dbh-container dbh-container--mid dbh-reveal dbh-section dbh-anchor">
    <div class="dbh-section-head">
      <h2>O que desentupimos</h2>
      <p>Foco total em esgoto e rede hidráulica. Sem rodeios, com equipamento próprio e técnicos experientes.</p>
    </div>

    <div class="dbh-services-grid">
      <?php foreach ( $dbh_servicos as $i => $s ) : ?>
        <article class="dbh-glass dbh-service<?php echo ! empty( $s['destaque'] ) ? ' dbh-service--featured' : ''; ?>">
          <div class="dbh-service-top">
            <span class="dbh-service-index"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
            <?php if ( ! empty( $s['destaque'] ) ) : ?>
              <span class="dbh-service-tag">Principal</span>
            <?php endif; ?>
          </div>
          <h3><?php echo esc_html( $s['titulo'] ); ?></h3>
          <p><?php echo esc_html( $s['texto'] ); ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="cidades" class="dbh-container dbh-container--mid dbh-reveal dbh-anchor">
    <div class="dbh-glass dbh-cities-panel">
      <div class="dbh-cities-head">
        <div>
          <h2>Onde atendemos</h2>
          <p>Cidades com mais chamados · atendemos qualquer cidade a até 110 km de BH</p>
        </div>
        <div class="dbh-region-badge" aria-label="Atendimento em Minas Gerais">
          <span class="dbh-flag-wrap">
            <img src="https://upload.wikimedia.org/wikipedia/commons/f/f4/Bandeira_de_Minas_Gerais.svg" alt="" width="28" height="19" loading="lazy">
          </span>
          <span>
            <strong>Minas Gerais</strong>
            <small>Região Metropolitana</small>
          </span>
        </div>
      </div>

      <div class="dbh-cities-list">
        <?php foreach ( $dbh_cidades as $cidade ) : ?>
          <span class="dbh-city"><?php echo esc_html( $cidade ); ?></span>
        <?php endforeach; ?>
        <span class="dbh-city dbh-city--more">+ até 110 km de BH</span>
      </div>
    </div>
  </section>

  <section class="dbh-container dbh-container--wide dbh-reveal dbh-section">
    <div class="dbh-payment-panel">
      <div>
        <p class="dbh-eyebrow">Pagamento facilitado</p>
        <h2>Pague do jeito que for melhor para você</h2>
        <p>Aceitamos Pix, cartões de crédito e débito e dinheiro. Sem depender de uma única forma de pagamento.</p>
      </div>

      <div class="dbh-payment-grid">
        <div class="dbh-payment-card">
          <div class="dbh-payment-icon dbh-payment-icon--pix">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/50/Pix_%28Brazil%29_logo.svg" alt="Pix" width="44" height="16" loading="lazy">
          </div>
          <h3>Pix</h3>
          <p>Pagamento instantâneo, direto pelo seu banco.</p>
        </div>

        <div class="dbh-payment-card">
          <div class="dbh-payment-icon dbh-payment-icon--card"><?php echo dbh_icon_cartao(); ?></div>
          <h3>Cartão</h3>
          <p>Crédito e débito, com as principais bandeiras aceitas pela maquininha.</p>
        </div>

        <div class="dbh-payment-card">
          <div class="dbh-payment-icon dbh-payment-icon--cash"><?php echo dbh_icon_dinheiro(); ?></div>
          <h3>Dinheiro</h3>
          <p>Pagamento em espécie no atendimento.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="sobre" class="dbh-container dbh-container--mid dbh-reveal dbh-section dbh-anchor">
    <div class="dbh-about-grid">
      <div>
        <p class="dbh-eyebrow">Quem somos</p>
        <h2>Referência em desentupimento em Belo Horizonte</h2>
        <p>A Desentupidora BH 24H combines experiência, equipamentos modernos e atendimento direto. Trabalhamos dia e noite para atender emergências e demandas programadas em residências, comércios e condomínios.</p>
        <p>Investimos em máquinas de alta pressão, sondas e câmeras de inspeção para identificar a causa exata do problema e resolver sem danificar a tubulação.</p>
      </div>

      <ul class="dbh-glass dbh-about-list">
        <?php foreach ( $dbh_sobre as $item ) : ?>
          <li><span class="dbh-check">✓</span><span><?php echo esc_html( $item ); ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

  <section id="duvidas" class="dbh-container dbh-container--mid dbh-reveal dbh-anchor" style="padding-bottom:3.5rem">
    <div class="dbh-section-head">
      <h2>Perguntas frequentes</h2>
      <p>O que mais nos perguntam antes de chamar.</p>
    </div>

    <div class="dbh-faq-grid">
      <?php foreach ( $dbh_faq as $item ) : ?>
        <div class="dbh-glass dbh-faq-item">
          <button type="button" class="dbh-faq-button" aria-expanded="false">
            <?php echo esc_html( $item['p'] ); ?>
            <span class="dbh-faq-icon" aria-hidden="true">+</span>
          </button>
          <div class="dbh-faq-answer">
            <div class="dbh-faq-answer-inner">
              <p><?php echo esc_html( $item['r'] ); ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <footer class="dbh-container dbh-container--wide dbh-reveal dbh-footer">
    <div class="dbh-footer-card">
      <div>
        <img src="<?php echo esc_url( $DBH_LOGO ); ?>" alt="Desentupidora BH 24H">
        <p class="dbh-footer-title">Entupiu? Chama a gente.</p>
        <p>Orçamento rápido pelo WhatsApp, sem compromisso. Plantão 24h.</p>
      </div>
      <a class="dbh-btn dbh-btn--accent" href="<?php echo esc_url( $dbh_whatsapp_url ); ?>" target="_blank" rel="noreferrer">
        <?php echo dbh_icon_whats(); ?> <?php echo esc_html( $DBH_TELEFONE ); ?>
      </a>
    </div>

    <div class="dbh-footer-meta">
      <p>© <?php echo esc_html( date_i18n( 'Y' ) ); ?> Desentupidora BH 24H · Belo Horizonte, MG</p>

      <div class="dbh-credit">
        <span class="dbh-credit-label">Desenvolvido por</span>
        <a class="dbh-developer-badge" href="https://contrateagora.com/index.html" target="_blank" rel="noreferrer" aria-label="Desenvolvido por Growth 7x">
          <span class="dbh-developer-shine" aria-hidden="true"></span>
          <span class="dbh-developer-brand">Growth</span>
          <span class="dbh-developer-mark">7x</span>
        </a>
      </div>

      <div class="dbh-footer-links">
        <?php if ( $dbh_blog_url ) : ?>
          <a href="<?php echo esc_url( $dbh_blog_url ); ?>">Blog</a>
        <?php endif; ?>
        <a href="<?php echo esc_url( $dbh_tel_href ); ?>"><?php echo esc_html( $DBH_TELEFONE ); ?></a>
      </div>
    </div>
  </footer>

  <div class="dbh-mobile-bar">
    <a class="dbh-btn dbh-btn--ink" href="<?php echo esc_url( $dbh_tel_href ); ?>">
      <?php echo dbh_icon_fone(); ?> Ligar
    </a>
    <a class="dbh-btn dbh-btn--whats" href="<?php echo esc_url( $dbh_whatsapp_url ); ?>" target="_blank" rel="noreferrer">
      <?php echo dbh_icon_whats(); ?> WhatsApp
    </a>
  </div>

</div>

<script>
(function () {
  var page = document.querySelector('.dbh-page');
  if (!page) return;

  var bar = document.getElementById('dbhScrollProgress');
  var header = document.getElementById('dbhHeader');

  function onScroll() {
    var scrollable = document.documentElement.scrollHeight - window.innerHeight;
    if (bar) {
      bar.style.transform = 'scaleX(' + (scrollable > 0 ? Math.min(1, window.scrollY / scrollable) : 0) + ')';
    }
    if (header) {
      header.classList.toggle('is-scrolled', window.scrollY > 36);
    }
  }

  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);

  var sections = page.querySelectorAll('.dbh-reveal');
  if ('IntersectionObserver' in window) {
    Array.prototype.forEach.call(sections, function (section, index) {
      section.style.setProperty('--reveal-delay', Math.min(index * 60, 180) + 'ms');
      var observer = new IntersectionObserver(function (entries) {
        if (entries[0] && entries[0].isIntersecting) {
          section.classList.add('is-visible');
          observer.disconnect();
        }
      }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
      observer.observe(section);
    });
  } else {
    Array.prototype.forEach.call(sections, function (section) {
      section.classList.add('is-visible');
    });
  }

  Array.prototype.forEach.call(page.querySelectorAll('.dbh-faq-button'), function (button) {
    button.addEventListener('click', function () {
      var item = button.closest('.dbh-faq-item');
      var isOpen = item.classList.toggle('is-open');
      button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  });
})();

<?php if ( $DBH_TRACKING && ( $DBH_GA4_ID || $DBH_GTM_ID || $DBH_ADS_ID ) ) : ?>
(function () {
  var ADS_ID = <?php echo wp_json_encode( $DBH_ADS_ID ); ?>;
  var ADS_LABEL = <?php echo wp_json_encode( $DBH_ADS_LABEL ); ?>;
  var scrollSent = false;

  function send(name, category) {
    if (typeof window.gtag !== 'function') return;
    window.gtag('event', name, { event_category: category || 'engajamento' });
  }

  document.addEventListener('click', function (event) {
    var target = event.target;
    if (!target || !target.closest) return;
    var link = target.closest('a');
    if (!link) return;

    var href = link.getAttribute('href') || '';
    var name = null;
    if (/^tel:/i.test(href)) {
      name = 'phone_click';
    } else if (/(wa\.me|api\.whatsapp\.com|whatsapp:)/i.test(href)) {
      name = 'whatsapp_click';
    }
    if (!name) return;

    send(name);
    if (ADS_ID && ADS_LABEL && typeof window.gtag === 'function') {
      window.gtag('event', 'conversion', { send_to: ADS_ID + '/' + ADS_LABEL });
    }
  }, { passive: true });

  window.addEventListener('scroll', function () {
    if (scrollSent) return;
    var scrollable = document.documentElement.scrollHeight - window.innerHeight;
    if (scrollable <= 0) return;
    if (window.scrollY / scrollable >= 0.9) {
      scrollSent = true;
      send('scroll_90');
    }
  }, { passive: true });
})();
<?php endif; ?>
</script>
<?php if ( function_exists( "dbh_tracking_script" ) ) { dbh_tracking_script(); } ?>
</body>
</html>