<?php
/**
 * Desentupidora BH - Admin e Analytics local.
 *
 * @package DesentupidoraBH
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DBH_ADMIN_VERSION', '1.0.0' );
define( 'DBH_ADMIN_COOKIE', 'dbh_admin_session' );
define( 'DBH_ADMIN_DEFAULT_USER', 'desentupidorabh' );
define( 'DBH_ADMIN_DEFAULT_PASSWORD_HASH', '$2y$12$nZSINkNw6VuRhTuwvCQeEeAwQhcx1S5SHY0UdaOds9P9jUe/J4xVW' );

function dbh_admin_table( $name ) {
	global $wpdb;
	return $wpdb->prefix . 'dbh_' . $name;
}

function dbh_admin_defaults() {
	return array(
		'tracking_enabled' => '1',
		'telefone' => '(31) 99267-6876',
		'whatsapp' => '5531992676876',
		'whatsapp_msg' => 'Olá, vim por meio do site do google, e gostaria de solicitar um orçamento para desentupimento.',
		'titulo' => 'Esgoto entupido? Resolvemos hoje.',
		'descricao' => 'Desentupimento de esgoto, pias, ralos, vasos e tanques, além de água pluvial e troca de rede de esgoto. Chegamos rápido em Belo Horizonte e região metropolitana, com orçamento gratuito e garantia.',
		'blog_path' => '/blog',
		'ga4_id' => '',
		'gtm_id' => 'GTM-KSB3NZX7',
		'ads_id' => '',
		'ads_label' => '',
		'search_console' => '',
		'meta_pixel' => '',
	);
}

function dbh_get_settings() {
	$settings = get_option( 'dbh_settings', array() );
	return wp_parse_args( is_array( $settings ) ? $settings : array(), dbh_admin_defaults() );
}

function dbh_get_setting( $key, $default = '' ) {
	$settings = dbh_get_settings();
	return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
}

function dbh_admin_install() {
	if ( get_option( 'dbh_admin_version' ) === DBH_ADMIN_VERSION ) {
		return;
	}

	global $wpdb;
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';

	$charset = $wpdb->get_charset_collate();
	$visits  = dbh_admin_table( 'visits' );
	$events  = dbh_admin_table( 'events' );

	$sql_visits = "CREATE TABLE {$visits} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		visitor_hash CHAR(64) NOT NULL,
		session_id CHAR(64) NOT NULL,
		started_at DATETIME NOT NULL,
		last_seen_at DATETIME NOT NULL,
		duration INT UNSIGNED NOT NULL DEFAULT 0,
		page_url TEXT NOT NULL,
		referrer TEXT NULL,
		source VARCHAR(190) NOT NULL DEFAULT 'Direto',
		utm_source VARCHAR(190) NULL,
		utm_medium VARCHAR(190) NULL,
		utm_campaign VARCHAR(190) NULL,
		device VARCHAR(30) NOT NULL DEFAULT 'Desktop',
		browser VARCHAR(60) NOT NULL DEFAULT 'Outro',
		os VARCHAR(60) NOT NULL DEFAULT 'Outro',
		screen_width SMALLINT UNSIGNED NOT NULL DEFAULT 0,
		PRIMARY KEY (id),
		KEY started_at (started_at),
		KEY visitor_hash (visitor_hash),
		KEY session_id (session_id),
		KEY source (source),
		KEY device (device)
	) {$charset};";

	$sql_events = "CREATE TABLE {$events} (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		visit_id BIGINT UNSIGNED NOT NULL,
		event_name VARCHAR(80) NOT NULL,
		event_data TEXT NULL,
		created_at DATETIME NOT NULL,
		PRIMARY KEY (id),
		KEY visit_id (visit_id),
		KEY event_name (event_name),
		KEY created_at (created_at)
	) {$charset};";

	dbDelta( $sql_visits );
	dbDelta( $sql_events );

	if ( ! get_option( 'dbh_settings' ) ) {
		update_option( 'dbh_settings', dbh_admin_defaults(), false );
	}

	if ( ! get_option( 'dbh_admin_password_hash' ) ) {
		update_option( 'dbh_admin_password_hash', DBH_ADMIN_DEFAULT_PASSWORD_HASH, false );
	}

	update_option( 'dbh_admin_version', DBH_ADMIN_VERSION, false );
}

add_action( 'init', 'dbh_admin_install', 1 );

function dbh_admin_session_start() {
	if ( headers_sent() || session_status() === PHP_SESSION_ACTIVE ) {
		return;
	}
	$path = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
	$secure = is_ssl();
	ini_set( 'session.use_strict_mode', '1' );
	session_set_cookie_params(
		array(
			'lifetime' => 0,
			'path' => $path,
			'domain' => defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '',
			'secure' => $secure,
			'httponly' => true,
			'samesite' => 'Lax',
		)
	);
	session_start();
}

function dbh_admin_cookie_options() {
	return array(
		'expires' => time() + 12 * HOUR_IN_SECONDS,
		'path' => '/',
		'secure' => is_ssl(),
		'httponly' => true,
		'samesite' => 'Lax',
	);
}

function dbh_admin_set_session( $user ) {
	$token = wp_generate_password( 64, false, false );
	$csrf  = wp_generate_password( 48, false, false );
	set_transient(
		'dbh_admin_session_' . hash( 'sha256', $token ),
		array(
			'user' => $user,
			'csrf' => $csrf,
			'created' => time(),
		),
		12 * HOUR_IN_SECONDS
	);
	setcookie( DBH_ADMIN_COOKIE, $token, dbh_admin_cookie_options() );
	return $csrf;
}

function dbh_admin_session() {
	$token = isset( $_COOKIE[ DBH_ADMIN_COOKIE ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ DBH_ADMIN_COOKIE ] ) ) : '';
	if ( ! $token ) {
		return false;
	}
	$data = get_transient( 'dbh_admin_session_' . hash( 'sha256', $token ) );
	return is_array( $data ) && ! empty( $data['user'] ) ? $data : false;
}

function dbh_admin_logout() {
	$token = isset( $_COOKIE[ DBH_ADMIN_COOKIE ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ DBH_ADMIN_COOKIE ] ) ) : '';
	if ( $token ) {
		delete_transient( 'dbh_admin_session_' . hash( 'sha256', $token ) );
	}
	setcookie(
		DBH_ADMIN_COOKIE,
		'',
		array(
			'expires' => time() - HOUR_IN_SECONDS,
			'path' => '/',
			'secure' => is_ssl(),
			'httponly' => true,
			'samesite' => 'Lax',
		)
	);
}

function dbh_admin_is_authenticated() {
	return (bool) dbh_admin_session();
}

function dbh_admin_csrf_valid( $session ) {
	$csrf = isset( $_POST['csrf'] ) ? sanitize_text_field( wp_unslash( $_POST['csrf'] ) ) : '';
	return $csrf && ! empty( $session['csrf'] ) && hash_equals( $session['csrf'], $csrf );
}

function dbh_admin_rate_key() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	return 'dbh_admin_login_' . hash( 'sha256', $ip );
}

function dbh_admin_login_allowed() {
	$data = get_transient( dbh_admin_rate_key() );
	return ! is_array( $data ) || empty( $data['locked_until'] ) || time() >= (int) $data['locked_until'];
}

function dbh_admin_register_failure() {
	$key  = dbh_admin_rate_key();
	$data = get_transient( $key );
	$data = is_array( $data ) ? $data : array( 'count' => 0 );
	$data['count']++;
	$data['locked_until'] = $data['count'] >= 5 ? time() + 15 * MINUTE_IN_SECONDS : 0;
	set_transient( $key, $data, 15 * MINUTE_IN_SECONDS );
}

function dbh_admin_login() {
	if ( ! dbh_admin_login_allowed() ) {
		return 'Muitas tentativas. Aguarde 15 minutos.';
	}

	$username = isset( $_POST['username'] ) ? sanitize_user( wp_unslash( $_POST['username'] ) ) : '';
	$password = isset( $_POST['password'] ) ? (string) wp_unslash( $_POST['password'] ) : '';
	$hash = (string) get_option( 'dbh_admin_password_hash', DBH_ADMIN_DEFAULT_PASSWORD_HASH );

	if ( hash_equals( DBH_ADMIN_DEFAULT_USER, $username ) && password_verify( $password, $hash ) ) {
		delete_transient( dbh_admin_rate_key() );
		$csrf = dbh_admin_set_session( $username );
		return array( 'ok' => true, 'csrf' => $csrf );
	}

	dbh_admin_register_failure();
	return 'Usuário ou senha inválidos.';
}

function dbh_admin_page_url( $args = array() ) {
	return add_query_arg( $args, home_url( '/admin/' ) );
}

function dbh_admin_redirect( $args = array() ) {
	wp_safe_redirect( dbh_admin_page_url( $args ) );
	exit;
}

function dbh_admin_handle_request() {
	$path = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path = trim( (string) wp_parse_url( $path, PHP_URL_PATH ), '/' );

	if ( 'admin' !== $path ) {
		return;
	}

	dbh_admin_install();
	$session = dbh_admin_session();

	if ( 'POST' === strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		$action = isset( $_POST['dbh_action'] ) ? sanitize_key( wp_unslash( $_POST['dbh_action'] ) ) : '';

		if ( 'login' === $action && ! $session ) {
			$result = dbh_admin_login();
			if ( is_array( $result ) && ! empty( $result['ok'] ) ) {
				dbh_admin_redirect();
			}
			dbh_admin_render_login( is_string( $result ) ? $result : 'Não foi possível entrar.' );
			exit;
		}

		if ( ! $session || ! dbh_admin_csrf_valid( $session ) ) {
			status_header( 403 );
			wp_die( 'Sessão inválida ou expirada.', 'Acesso negado', array( 'response' => 403 ) );
		}

		if ( 'logout' === $action ) {
			dbh_admin_logout();
			dbh_admin_redirect();
		}

		if ( 'save_settings' === $action ) {
			$keys = array_keys( dbh_admin_defaults() );
			$settings = dbh_get_settings();
			foreach ( $keys as $key ) {
				$value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
				$settings[ $key ] = 'tracking_enabled' === $key ? ( ! empty( $value ) ? '1' : '0' ) : sanitize_textarea_field( $value );
			}
			update_option( 'dbh_settings', $settings, false );

			$new_password = isset( $_POST['new_password'] ) ? (string) wp_unslash( $_POST['new_password'] ) : '';
			if ( $new_password ) {
				if ( strlen( $new_password ) < 10 ) {
					dbh_admin_redirect( array( 'saved' => 0, 'error' => 'A nova senha precisa ter pelo menos 10 caracteres.' ) );
				}
				update_option( 'dbh_admin_password_hash', password_hash( $new_password, PASSWORD_DEFAULT ), false );
			}
			dbh_admin_redirect( array( 'saved' => 1 ) );
		}
	}
}

add_action( 'template_redirect', 'dbh_admin_handle_request', 0 );

function dbh_admin_render_login( $error = '' ) {
	status_header( 200 );
	nocache_headers();
	?>
	<!doctype html>
	<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin · Desentupidora BH 24H</title>
		<style>
			:root{--bg:#0b1020;--panel:#11182b;--line:#26314b;--text:#f5f7fb;--muted:#96a1b8;--accent:#ff6b2c;--accent2:#ff9b52}
			*{box-sizing:border-box}body{margin:0;min-height:100vh;background:radial-gradient(circle at 15% 10%,#182443 0,transparent 38%),var(--bg);color:var(--text);font:15px Inter,system-ui,sans-serif;display:grid;place-items:center;padding:24px}
			.dbh-login{width:min(430px,100%);background:rgba(17,24,43,.94);border:1px solid var(--line);border-radius:22px;padding:34px;box-shadow:0 24px 80px rgba(0,0,0,.35)}
			.dbh-brand{display:flex;align-items:center;gap:14px;margin-bottom:28px}.dbh-brand img{width:54px;height:54px;object-fit:contain;border-radius:12px}.dbh-brand strong{display:block;font-size:18px}.dbh-brand span{color:var(--muted);font-size:13px}
			h1{font-size:27px;margin:0 0 8px}.sub{color:var(--muted);margin:0 0 24px;line-height:1.5}label{display:block;font-weight:600;font-size:13px;margin:16px 0 8px}input{width:100%;background:#0c1324;color:var(--text);border:1px solid var(--line);border-radius:11px;padding:13px 14px;outline:none}input:focus{border-color:var(--accent)}button{width:100%;border:0;border-radius:11px;padding:13px 16px;margin-top:22px;background:linear-gradient(135deg,var(--accent),var(--accent2));color:#fff;font-weight:700;cursor:pointer}.error{background:#3a1720;border:1px solid #6d2939;color:#ffb8c5;padding:11px 13px;border-radius:10px;margin-bottom:16px;font-size:13px}.hint{color:#66728b;text-align:center;font-size:12px;margin-top:18px}
		</style>
	</head>
	<body>
		<main class="dbh-login">
			<div class="dbh-brand">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/desentupidora-logo.png' ); ?>" alt="">
				<div><strong>Desentupidora BH 24H</strong><span>Painel administrativo</span></div>
			</div>
			<h1>Entrar no painel</h1>
			<p class="sub">Acompanhe os acessos, conversões e configure o site.</p>
			<?php if ( $error ) : ?><div class="error"><?php echo esc_html( $error ); ?></div><?php endif; ?>
			<form method="post" autocomplete="off">
				<input type="hidden" name="dbh_action" value="login">
				<label for="dbh-user">Usuário</label>
				<input id="dbh-user" name="username" value="" autocomplete="username" required>
				<label for="dbh-pass">Senha</label>
				<input id="dbh-pass" type="password" name="password" autocomplete="current-password" required>
				<button type="submit">Entrar no painel</button>
			</form>
			<div class="hint">Acesso protegido por sessão segura e limite de tentativas.</div>
		</main>
	</body>
	</html>
	<?php
}

function dbh_admin_format_duration( $seconds ) {
	$seconds = max( 0, (int) $seconds );
	if ( $seconds < 60 ) {
		return $seconds . 's';
	}
	return floor( $seconds / 60 ) . 'm ' . ( $seconds % 60 ) . 's';
}

function dbh_admin_render_dashboard( $session ) {
	global $wpdb;
	$visits = dbh_admin_table( 'visits' );
	$events = dbh_admin_table( 'events' );
	$start = gmdate( 'Y-m-d H:i:s', time() - 30 * DAY_IN_SECONDS );

	$total = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$visits} WHERE started_at >= %s", $start ) );
	$unique = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(DISTINCT visitor_hash) FROM {$visits} WHERE started_at >= %s", $start ) );
	$avg = (float) $wpdb->get_var( $wpdb->prepare( "SELECT AVG(LEAST(duration,7200)) FROM {$visits} WHERE started_at >= %s", $start ) );
	$cta = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$events} WHERE created_at >= %s AND event_name IN ('whatsapp_click','phone_click')", $start ) );

	$sources = $wpdb->get_results( $wpdb->prepare( "SELECT source, COUNT(*) total FROM {$visits} WHERE started_at >= %s GROUP BY source ORDER BY total DESC LIMIT 6", $start ) );
	$devices = $wpdb->get_results( $wpdb->prepare( "SELECT device, COUNT(*) total FROM {$visits} WHERE started_at >= %s GROUP BY device ORDER BY total DESC", $start ) );
	$recent = $wpdb->get_results( "SELECT id, started_at, source, device, browser, os, duration, page_url FROM {$visits} ORDER BY id DESC LIMIT 12" );
	$settings = dbh_get_settings();
	$csrf = $session['csrf'];
	?>
	<!doctype html>
	<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin · Desentupidora BH 24H</title>
		<style>
			:root{--bg:#0a0f1d;--panel:#11182a;--panel2:#0d1424;--line:#202c44;--text:#f6f8fc;--muted:#8e9bb3;--accent:#ff6b2c;--accent2:#ff9d5c;--green:#36d39a;--blue:#6ea8ff;--danger:#ff657a}
			*{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:var(--bg);color:var(--text);font:14px Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}.wrap{display:flex;min-height:100vh}.side{width:250px;background:#0d1424;border-right:1px solid var(--line);padding:22px 16px;position:fixed;inset:0 auto 0 0}.brand{display:flex;gap:12px;align-items:center;padding:6px 8px 25px}.brand img{width:42px;height:42px;object-fit:contain;border-radius:10px}.brand strong{display:block;font-size:14px}.brand span{font-size:11px;color:var(--muted)}.nav a{display:flex;gap:10px;align-items:center;color:#aab5c9;text-decoration:none;padding:11px 12px;border-radius:10px;margin:3px 0}.nav a:hover,.nav a.active{background:#182238;color:#fff}.nav .ico{width:20px;text-align:center}.side-bottom{position:absolute;bottom:20px;left:16px;right:16px}.side-bottom a{color:#8e9bb3;text-decoration:none}.main{margin-left:250px;width:calc(100% - 250px);padding:30px clamp(18px,4vw,55px)}.top{display:flex;justify-content:space-between;align-items:center;gap:20px;margin-bottom:28px}.top h1{margin:0;font-size:29px;letter-spacing:-.5px}.top p{margin:6px 0 0;color:var(--muted)}.actions{display:flex;gap:9px}.btn{border:1px solid var(--line);background:#151e31;color:#fff;border-radius:9px;padding:9px 13px;text-decoration:none;cursor:pointer}.btn.primary{border:0;background:linear-gradient(135deg,var(--accent),var(--accent2))}.grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px}.card{background:var(--panel);border:1px solid var(--line);border-radius:15px;padding:18px}.metric-label{color:var(--muted);font-size:12px}.metric{font-size:28px;font-weight:750;margin-top:9px}.metric small{font-size:12px;color:var(--muted);font-weight:500}.two{display:grid;grid-template-columns:1.15fr .85fr;gap:14px;margin-top:14px}.section-title{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}.section-title h2{font-size:16px;margin:0}.section-title span{font-size:12px;color:var(--muted)}.bar{margin:12px 0}.bar-head{display:flex;justify-content:space-between;color:#c4ccda;font-size:12px;margin-bottom:7px}.track{height:8px;background:#202b40;border-radius:99px;overflow:hidden}.fill{height:100%;background:linear-gradient(90deg,var(--accent),var(--accent2));border-radius:inherit}.device{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #1c2639}.device:last-child{border-bottom:0}.pill{font-size:11px;color:#b8c3d5;background:#182238;border:1px solid #27344d;padding:4px 8px;border-radius:99px}.table-wrap{overflow:auto}.table{width:100%;border-collapse:collapse}.table th,.table td{text-align:left;padding:12px 10px;border-bottom:1px solid #1c2639;white-space:nowrap}.table th{font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase}.table td{font-size:12px;color:#cbd3e0}.settings{margin-top:14px}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:13px}.field{display:flex;flex-direction:column;gap:7px}.field.full{grid-column:1/-1}.field label{font-size:12px;color:#aeb8ca;font-weight:600}.field input,.field textarea{width:100%;background:var(--panel2);color:#fff;border:1px solid var(--line);border-radius:9px;padding:11px 12px;outline:none;font:inherit}.field input:focus,.field textarea:focus{border-color:var(--accent)}.field textarea{min-height:100px;resize:vertical}.toggle{display:flex;align-items:center;gap:10px;color:#cbd3e0}.toggle input{width:18px;height:18px}.notice{margin-bottom:15px;padding:11px 13px;border-radius:9px;background:#102c25;border:1px solid #1d604d;color:#9cf0d0}.notice.error{background:#351720;border-color:#6b2736;color:#ffb7c2}.subhead{margin:28px 0 13px;font-size:14px;color:#fff}.muted{color:var(--muted)}@media(max-width:950px){.side{width:72px;padding:18px 10px}.brand div,.nav span:not(.ico),.side-bottom span{display:none}.brand{justify-content:center}.nav a{justify-content:center}.main{margin-left:72px;width:calc(100% - 72px)}.grid{grid-template-columns:repeat(2,minmax(0,1fr))}.two{grid-template-columns:1fr}}@media(max-width:650px){.main{padding:20px 14px}.top{align-items:flex-start;flex-direction:column}.grid,.form-grid{grid-template-columns:1fr}.top h1{font-size:24px}.card{padding:15px}}
		</style>
	</head>
	<body>
	<div class="wrap">
		<aside class="side">
			<div class="brand"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/desentupidora-logo.png' ); ?>" alt=""><div><strong>Desentupidora BH</strong><span>Administração</span></div></div>
			<nav class="nav">
				<a class="active" href="#visao"><span class="ico">▦</span><span>Visão geral</span></a>
				<a href="#acessos"><span class="ico">◉</span><span>Acessos</span></a>
				<a href="#config"><span class="ico">⚙</span><span>Configurações</span></a>
			</nav>
			<div class="side-bottom"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank"><span>↗ Ver site</span></a></div>
		</aside>
		<main class="main">
			<header class="top" id="visao">
				<div><h1>Visão geral</h1><p>Últimos 30 dias · dados coletados pelo próprio site</p></div>
				<div class="actions">
					<a class="btn" href="<?php echo esc_url( dbh_admin_page_url() ); ?>">Atualizar</a>
					<form method="post"><input type="hidden" name="dbh_action" value="logout"><input type="hidden" name="csrf" value="<?php echo esc_attr( $csrf ); ?>"><button class="btn" type="submit">Sair</button></form>
				</div>
			</header>
			<?php if ( isset( $_GET['saved'] ) && '1' === $_GET['saved'] ) : ?><div class="notice">Configurações salvas com sucesso.</div><?php endif; ?>
			<?php if ( isset( $_GET['error'] ) ) : ?><div class="notice error"><?php echo esc_html( sanitize_text_field( wp_unslash( $_GET['error'] ) ) ); ?></div><?php endif; ?>

			<section class="grid">
				<div class="card"><div class="metric-label">Visitas</div><div class="metric"><?php echo esc_html( number_format_i18n( $total ) ); ?></div></div>
				<div class="card"><div class="metric-label">Visitantes únicos</div><div class="metric"><?php echo esc_html( number_format_i18n( $unique ) ); ?></div></div>
				<div class="card"><div class="metric-label">Tempo médio</div><div class="metric"><?php echo esc_html( dbh_admin_format_duration( round( $avg ) ) ); ?></div></div>
				<div class="card"><div class="metric-label">Conversões <small>WhatsApp + telefone</small></div><div class="metric"><?php echo esc_html( number_format_i18n( $cta ) ); ?></div></div>
			</section>

			<section class="two" id="acessos">
				<div class="card">
					<div class="section-title"><h2>Origem do tráfego</h2><span>30 dias</span></div>
					<?php $max_source = ! empty( $sources ) ? max( 1, (int) $sources[0]->total ) : 1; ?>
					<?php if ( $sources ) : foreach ( $sources as $row ) : ?>
						<div class="bar"><div class="bar-head"><span><?php echo esc_html( $row->source ?: 'Direto' ); ?></span><strong><?php echo esc_html( number_format_i18n( $row->total ) ); ?></strong></div><div class="track"><div class="fill" style="width:<?php echo esc_attr( min( 100, ( $row->total / $max_source ) * 100 ) ); ?>%"></div></div></div>
					<?php endforeach; else : ?><p class="muted">Ainda não há acessos registrados.</p><?php endif; ?>
				</div>
				<div class="card">
					<div class="section-title"><h2>Dispositivos</h2><span>30 dias</span></div>
					<?php if ( $devices ) : foreach ( $devices as $row ) : ?><div class="device"><span><?php echo esc_html( $row->device ); ?></span><span class="pill"><?php echo esc_html( number_format_i18n( $row->total ) ); ?></span></div><?php endforeach; else : ?><p class="muted">Sem dados ainda.</p><?php endif; ?>
				</div>
			</section>

			<section class="card" style="margin-top:14px">
				<div class="section-title"><h2>Acessos recentes</h2><span>12 últimos</span></div>
				<div class="table-wrap"><table class="table"><thead><tr><th>Data</th><th>Origem</th><th>Dispositivo</th><th>Navegador</th><th>SO</th><th>Tempo</th></tr></thead><tbody>
				<?php if ( $recent ) : foreach ( $recent as $row ) : ?><tr><td><?php echo esc_html( mysql2date( 'd/m H:i', $row->started_at ) ); ?></td><td><?php echo esc_html( $row->source ); ?></td><td><?php echo esc_html( $row->device ); ?></td><td><?php echo esc_html( $row->browser ); ?></td><td><?php echo esc_html( $row->os ); ?></td><td><?php echo esc_html( dbh_admin_format_duration( $row->duration ) ); ?></td></tr><?php endforeach; else : ?><tr><td colspan="6" class="muted">Nenhum acesso registrado ainda.</td></tr><?php endif; ?>
				</tbody></table></div>
			</section>

			<section class="card settings" id="config">
				<div class="section-title"><h2>Configurações do site</h2><span>Salvas no WordPress</span></div>
				<form method="post">
					<input type="hidden" name="dbh_action" value="save_settings"><input type="hidden" name="csrf" value="<?php echo esc_attr( $csrf ); ?>">
					<div class="form-grid">
						<div class="field full"><label class="toggle"><input type="checkbox" name="tracking_enabled" value="1" <?php checked( $settings['tracking_enabled'], '1' ); ?>> Ativar analytics local</label></div>
						<div class="field"><label>Telefone</label><input name="telefone" value="<?php echo esc_attr( $settings['telefone'] ); ?>"></div>
						<div class="field"><label>WhatsApp</label><input name="whatsapp" value="<?php echo esc_attr( $settings['whatsapp'] ); ?>"></div>
						<div class="field full"><label>Mensagem do WhatsApp</label><textarea name="whatsapp_msg"><?php echo esc_textarea( $settings['whatsapp_msg'] ); ?></textarea></div>
						<div class="field full"><label>Título principal</label><input name="titulo" value="<?php echo esc_attr( $settings['titulo'] ); ?>"></div>
						<div class="field full"><label>Descrição principal</label><textarea name="descricao"><?php echo esc_textarea( $settings['descricao'] ); ?></textarea></div>
						<div class="field"><label>Caminho do blog</label><input name="blog_path" value="<?php echo esc_attr( $settings['blog_path'] ); ?>"></div>
						<div class="field"><label>Google Analytics 4</label><input name="ga4_id" placeholder="G-XXXXXXXXXX" value="<?php echo esc_attr( $settings['ga4_id'] ); ?>"></div>
						<div class="field"><label>Google Tag Manager</label><input name="gtm_id" placeholder="GTM-XXXXXXX" value="<?php echo esc_attr( $settings['gtm_id'] ); ?>"></div>
						<div class="field"><label>Google Ads ID</label><input name="ads_id" placeholder="AW-XXXXXXXXX" value="<?php echo esc_attr( $settings['ads_id'] ); ?>"></div>
						<div class="field"><label>Google Ads Label</label><input name="ads_label" value="<?php echo esc_attr( $settings['ads_label'] ); ?>"></div>
						<div class="field"><label>Search Console</label><input name="search_console" value="<?php echo esc_attr( $settings['search_console'] ); ?>"></div>
						<div class="field"><label>Meta Pixel</label><input name="meta_pixel" value="<?php echo esc_attr( $settings['meta_pixel'] ); ?>"></div>
					</div>
					<h3 class="subhead">Segurança</h3>
					<div class="form-grid">
						<div class="field"><label>Nova senha do painel</label><input type="password" name="new_password" minlength="10" autocomplete="new-password" placeholder="Deixe vazio para manter"></div>
						<div class="field"><label>Usuário</label><input value="<?php echo esc_attr( DBH_ADMIN_DEFAULT_USER ); ?>" disabled></div>
					</div>
					<div style="margin-top:18px"><button class="btn primary" type="submit">Salvar configurações</button></div>
				</form>
			</section>
		</main>
	</div>
	</body>
	</html>
	<?php
}

function dbh_admin_bootstrap_page() {
	if ( ! dbh_admin_is_authenticated() ) {
		dbh_admin_render_login();
		exit;
	}
	nocache_headers();
	dbh_admin_render_dashboard( dbh_admin_session() );
	exit;
}

add_action( 'template_redirect', function () {
	$path = isset( $_SERVER['REQUEST_URI'] ) ? trim( (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ), '/' ) : '';
	if ( 'admin' === $path ) {
		dbh_admin_bootstrap_page();
	}
}, 99 );

function dbh_admin_detect_device( $ua ) {
	if ( preg_match( '/tablet|ipad/i', $ua ) ) {
		return 'Tablet';
	}
	if ( preg_match( '/mobile|android|iphone|ipod/i', $ua ) ) {
		return 'Mobile';
	}
	return 'Desktop';
}

function dbh_admin_detect_browser( $ua ) {
	if ( preg_match( '/edg/i', $ua ) ) return 'Edge';
	if ( preg_match( '/chrome|crios/i', $ua ) ) return 'Chrome';
	if ( preg_match( '/firefox|fxios/i', $ua ) ) return 'Firefox';
	if ( preg_match( '/safari/i', $ua ) && ! preg_match( '/chrome|crios/i', $ua ) ) return 'Safari';
	if ( preg_match( '/opr|opera/i', $ua ) ) return 'Opera';
	return 'Outro';
}

function dbh_admin_detect_os( $ua ) {
	if ( preg_match( '/windows/i', $ua ) ) return 'Windows';
	if ( preg_match( '/android/i', $ua ) ) return 'Android';
	if ( preg_match( '/iphone|ipad|ipod/i', $ua ) ) return 'iOS';
	if ( preg_match( '/mac os|macintosh/i', $ua ) ) return 'macOS';
	if ( preg_match( '/linux/i', $ua ) ) return 'Linux';
	return 'Outro';
}

function dbh_admin_source( $referrer, $utm_source ) {
	if ( $utm_source ) {
		return $utm_source;
	}
	if ( ! $referrer ) {
		return 'Direto';
	}
	$host = wp_parse_url( $referrer, PHP_URL_HOST );
	if ( ! $host ) {
		return 'Referência';
	}
	$host = preg_replace( '/^www\./', '', strtolower( $host ) );
	if ( strpos( $host, 'google.' ) !== false ) return 'Google';
	if ( strpos( $host, 'bing.' ) !== false ) return 'Bing';
	if ( strpos( $host, 'facebook.' ) !== false || strpos( $host, 'instagram.' ) !== false ) return 'Meta';
	if ( strpos( $host, 'tiktok.' ) !== false ) return 'TikTok';
	return $host;
}

function dbh_admin_client_ip_hash() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	return hash_hmac( 'sha256', $ip, wp_salt( 'auth' ) );
}

function dbh_track_request() {
	check_ajax_referer( 'dbh_track', 'nonce' );
	if ( ! dbh_get_setting( 'tracking_enabled', '1' ) ) {
		wp_send_json_success( array( 'disabled' => true ) );
	}

	global $wpdb;
	$visits = dbh_admin_table( 'visits' );
	$events = dbh_admin_table( 'events' );
	$type = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
	$visit_id = isset( $_POST['visit_id'] ) ? absint( $_POST['visit_id'] ) : 0;

	if ( 'page_view' === $type ) {
		$client_id = isset( $_POST['client_id'] ) ? preg_replace( '/[^a-zA-Z0-9_-]/', '', wp_unslash( $_POST['client_id'] ) ) : '';
		$session_id = isset( $_POST['session_id'] ) ? preg_replace( '/[^a-zA-Z0-9_-]/', '', wp_unslash( $_POST['session_id'] ) ) : '';
		if ( strlen( $client_id ) < 8 || strlen( $session_id ) < 8 ) {
			wp_send_json_error( array( 'message' => 'Identificador inválido.' ), 400 );
		}
		$visitor_hash = hash_hmac( 'sha256', $client_id, wp_salt( 'auth' ) );
		$session_hash = hash( 'sha256', $session_id );
		$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
		$page_url = isset( $_POST['page_url'] ) ? esc_url_raw( wp_unslash( $_POST['page_url'] ) ) : home_url( '/' );
		$referrer = isset( $_POST['referrer'] ) ? esc_url_raw( wp_unslash( $_POST['referrer'] ) ) : '';
		$utm_source = isset( $_POST['utm_source'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_source'] ) ) : '';
		$utm_medium = isset( $_POST['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_medium'] ) ) : '';
		$utm_campaign = isset( $_POST['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_POST['utm_campaign'] ) ) : '';
		$now = current_time( 'mysql', true );

		$wpdb->insert(
			$visits,
			array(
				'visitor_hash' => $visitor_hash,
				'session_id' => $session_hash,
				'started_at' => $now,
				'last_seen_at' => $now,
				'duration' => 0,
				'page_url' => substr( $page_url, 0, 1000 ),
				'referrer' => substr( $referrer, 0, 1000 ),
				'source' => substr( dbh_admin_source( $referrer, $utm_source ), 0, 190 ),
				'utm_source' => substr( $utm_source, 0, 190 ),
				'utm_medium' => substr( $utm_medium, 0, 190 ),
				'utm_campaign' => substr( $utm_campaign, 0, 190 ),
				'device' => dbh_admin_detect_device( $ua ),
				'browser' => dbh_admin_detect_browser( $ua ),
				'os' => dbh_admin_detect_os( $ua ),
				'screen_width' => isset( $_POST['screen_width'] ) ? min( 9999, absint( $_POST['screen_width'] ) ) : 0,
			),
			array( '%s','%s','%s','%s','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d' )
		);
		wp_send_json_success( array( 'visit_id' => (int) $wpdb->insert_id ) );
	}

	if ( ! $visit_id ) {
		wp_send_json_error( array( 'message' => 'Visita inválida.' ), 400 );
	}

	$exists = (int) $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$visits} WHERE id=%d", $visit_id ) );
	if ( ! $exists ) {
		wp_send_json_error( array( 'message' => 'Visita não encontrada.' ), 404 );
	}

	if ( in_array( $type, array( 'heartbeat', 'page_end' ), true ) ) {
		$duration = isset( $_POST['duration'] ) ? min( 7200, max( 0, absint( $_POST['duration'] ) ) ) : 0;
		$wpdb->update( $visits, array( 'duration' => $duration, 'last_seen_at' => current_time( 'mysql', true ) ), array( 'id' => $visit_id ), array( '%d','%s' ), array( '%d' ) );
		wp_send_json_success();
	}

	if ( 'event' === $type ) {
		$name = isset( $_POST['event_name'] ) ? sanitize_key( wp_unslash( $_POST['event_name'] ) ) : '';
		$allowed = array( 'whatsapp_click', 'phone_click', 'scroll_90', 'cta_click' );
		if ( ! in_array( $name, $allowed, true ) ) {
			wp_send_json_error( array( 'message' => 'Evento não permitido.' ), 400 );
		}
		$data = isset( $_POST['event_data'] ) ? sanitize_text_field( wp_unslash( $_POST['event_data'] ) ) : '';
		$wpdb->insert( $events, array( 'visit_id' => $visit_id, 'event_name' => $name, 'event_data' => substr( $data, 0, 500 ), 'created_at' => current_time( 'mysql', true ) ), array( '%d','%s','%s','%s' ) );
		wp_send_json_success();
	}

	wp_send_json_error( array( 'message' => 'Tipo inválido.' ), 400 );
}

add_action( 'wp_ajax_dbh_track', 'dbh_track_request' );
add_action( 'wp_ajax_nopriv_dbh_track', 'dbh_track_request' );

function dbh_tracking_script() {
	if ( is_admin() || ! dbh_get_setting( 'tracking_enabled', '1' ) ) {
		return;
	}
	$config = array(
		'endpoint' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'dbh_track' ),
	);
	?>
	<script>
	(function(){
		const cfg=<?php echo wp_json_encode( $config ); ?>;
		const key='dbh_client_id';
		const sid='dbh_session_id';
		const getId=(name)=>{try{let v=localStorage.getItem(name);if(!v){v=(crypto.randomUUID?crypto.randomUUID():Date.now()+'-'+Math.random().toString(36).slice(2));localStorage.setItem(name,v)}return v}catch(e){return Date.now()+'-'+Math.random().toString(36).slice(2)}};
		const clientId=getId(key),sessionId=getId(sid),started=Date.now();
		let visitId=0,lastSent=0,hiddenAt=0,totalPaused=0;
		const params=new URLSearchParams(location.search);
		const post=(data,keepalive=true)=>{data.nonce=cfg.nonce;data.action='dbh_track';data.client_id=clientId;data.session_id=sessionId;data.screen_width=innerWidth;const body=new URLSearchParams(data);try{fetch(cfg.endpoint,{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},body,keepalive,credentials:'same-origin'}).then(r=>r.json()).then(j=>{if(j&&j.success&&j.data&&j.data.visit_id)visitId=j.data.visit_id}).catch(()=>{})}catch(e){}};
		post({type:'page_view',page_url:location.href,referrer:document.referrer,utm_source:params.get('utm_source')||'',utm_medium:params.get('utm_medium')||'',utm_campaign:params.get('utm_campaign')||''});
		const duration=()=>Math.max(0,Math.floor((Date.now()-started-totalPaused)/1000));
		const heartbeat=()=>{if(visitId)post({type:'heartbeat',visit_id:visitId,duration:duration()})};
		setInterval(heartbeat,15000);
		document.addEventListener('visibilitychange',()=>{if(document.hidden){hiddenAt=Date.now();heartbeat()}else if(hiddenAt){totalPaused+=Date.now()-hiddenAt;hiddenAt=0}});
		window.addEventListener('pagehide',()=>{if(visitId)post({type:'page_end',visit_id:visitId,duration:duration()},true)});
		const sendEvent=(name,data)=>{if(visitId)post({type:'event',visit_id:visitId,event_name:name,event_data:data||''},true)};
		document.addEventListener('click',e=>{const a=e.target.closest&&e.target.closest('a');if(!a)return;const href=a.getAttribute('href')||'';if(/^tel:/i.test(href))sendEvent('phone_click',href);else if(/wa\.me|api\.whatsapp\.com|whatsapp:/i.test(href))sendEvent('whatsapp_click',href)});
		let scrolled=false;addEventListener('scroll',()=>{if(!scrolled&&(scrollY/(document.documentElement.scrollHeight-innerHeight||1))>=.9){scrolled=true;sendEvent('scroll_90')}},{passive:true});
	})();
	</script>
	<?php
}

add_action( 'wp_footer', 'dbh_tracking_script', 20 );
