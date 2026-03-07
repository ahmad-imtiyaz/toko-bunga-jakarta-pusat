<?php
/* ============================================================
   HEADER / NAVBAR — Manila Florist · Kertas Cream Warm
============================================================ */
$meta_title    = $meta_title    ?? setting('meta_title_home');
$meta_desc     = $meta_desc     ?? setting('meta_desc_home');
$meta_keywords = $meta_keywords ?? setting('meta_keywords_home');
$wa_url        = setting('whatsapp_url');
$site_name     = setting('site_name');
$phone         = setting('phone_display');

$nav_categories = db()->query("
    SELECT * FROM categories WHERE status = 'active' ORDER BY urutan ASC, id ASC
")->fetchAll();

$nav_parents = []; $nav_children = [];
foreach ($nav_categories as $nc) {
    $pid = $nc['parent_id'] ?? null;
    if ($pid === null || $pid == 0) $nav_parents[] = $nc;
    else $nav_children[$pid][] = $nc;
}

$current_slug = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base_path    = trim(parse_url(BASE_URL, PHP_URL_PATH), '/');
if ($base_path && str_starts_with($current_slug, $base_path))
    $current_slug = trim(substr($current_slug, strlen($base_path)), '/');

$nav_items_before = [
    ['label' => 'Beranda',   'href' => BASE_URL . '/'],
    ['label' => 'Tentang',   'href' => BASE_URL . '/#tentang'],
    ['label' => 'Layanan',   'href' => BASE_URL . '/#layanan'],
];
$nav_items_after = [
    ['label' => 'Area',      'href' => BASE_URL . '/#area'],
    ['label' => 'Testimoni', 'href' => BASE_URL . '/#testimoni'],
    ['label' => 'FAQ',       'href' => BASE_URL . '/#faq'],
];

$desktop_tree = [];
if (!empty($nav_parents)) {
    foreach ($nav_parents as $par)
        $desktop_tree[] = ['name' => $par['name'], 'slug' => $par['slug'], 'children' => $nav_children[$par['id']] ?? []];
} else {
    $desktop_tree = [
        ['name' => 'Bunga Papan',      'slug' => 'bunga-papan-jakarta-pusat', 'children' => [
            ['name' => 'Happy Wedding',    'slug' => 'bunga-papan-happy-wedding'],
            ['name' => 'Duka Cita',        'slug' => 'bunga-papan-duka-cita'],
            ['name' => 'Selamat & Sukses', 'slug' => 'bunga-papan-selamat'],
        ]],
        ['name' => 'Hand Bouquet',     'slug' => 'hand-bouquet-jakarta-pusat', 'children' => [
            ['name' => 'Anniversary', 'slug' => 'hand-bouquet-anniversary'],
            ['name' => 'Birthday',    'slug' => 'hand-bouquet-birthday'],
            ['name' => 'Graduation',  'slug' => 'hand-bouquet-graduation'],
        ]],
        ['name' => 'Bunga Meja',       'slug' => 'bunga-meja-jakarta-pusat',       'children' => []],
        ['name' => 'Standing Flowers', 'slug' => 'standing-flowers-jakarta-pusat', 'children' => []],
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($meta_title) ?></title>
<meta name="description" content="<?= e($meta_desc) ?>">
<meta name="keywords"    content="<?= e($meta_keywords) ?>">
<meta name="robots"      content="index, follow">
<link rel="icon"         href="<?= BASE_URL ?>/assets/images/icon.png">
<link rel="canonical"    href="<?= e(BASE_URL . '/' . trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')) ?>">
<meta property="og:title"       content="<?= e($meta_title) ?>">
<meta property="og:description" content="<?= e($meta_desc) ?>">
<meta property="og:type"        content="website">
<meta property="og:url"         content="<?= e(BASE_URL) ?>">

<!-- Fonts: Cormorant (display) + Jost (body) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        manila:  '#F2E8D5',
        paper:   '#FBF6EE',
        ink:     '#2A1F14',
        inkl:    '#5C4A35',
        rose:    '#C07B60',
        rosel:   '#DFA98C',
        sage:    '#6B8C6A',
        muted:   '#8A7560',
      }
    }
  }
}
</script>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<style>
/* ══════════════════════════════════════════
   TOKENS
══════════════════════════════════════════ */
:root {
  --manila:    #F2E8D5;
  --manila-d:  #E8D9BF;
  --manila-dd: #D6C4A0;
  --paper:     #FBF6EE;
  --ink:       #2A1F14;
  --ink-l:     #5C4A35;
  --rose:      #C07B60;
  --rose-l:    #DFA98C;
  --sage:      #6B8C6A;
  --muted:     #8A7560;
  --border:    rgba(90,70,45,.13);
}

body {
  font-family: 'Jost', sans-serif;
  background: var(--paper);
  color: var(--ink);
}
h1, h2, h3 { font-family: 'Cormorant Garamond', serif; }
section[id] { scroll-margin-top: 80px; }

/* ── Dropdown fade ── */
@keyframes ddFade {
  from { opacity: 0; transform: translateY(-4px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ══════════════════════════════════════════
   TOP BAR
══════════════════════════════════════════ */
#topbar {
  background: var(--ink);
  font-family: 'Jost', sans-serif;
  font-size: 10.5px;
  font-weight: 400;
  letter-spacing: .1em;
  color: rgba(251,246,238,.45);
  padding: 7px 0;
  border-bottom: 1px solid rgba(255,255,255,.05);
}
#topbar a {
  color: var(--rose-l);
  text-decoration: none;
  transition: color .2s;
}
#topbar a:hover { color: var(--manila); }
.topbar-sep {
  color: var(--rose);
  opacity: .35;
  margin: 0 14px;
  font-size: 6px;
}

/* ══════════════════════════════════════════
   NAVBAR
══════════════════════════════════════════ */
#navbar {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(251,246,238,.97);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-bottom: 1px solid var(--border);
  transition: box-shadow .3s ease;
}
#navbar.scrolled {
  box-shadow: 0 2px 20px rgba(42,31,20,.08);
}

/* ── BRAND ── */
.nav-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  flex-shrink: 0;
  transition: opacity .2s;
}
.nav-brand:hover { opacity: .82; }

.nav-logo-ring {
  width: 40px; height: 40px;
  border-radius: 50%;
  border: 1.5px solid var(--manila-dd);
  overflow: hidden;
  flex-shrink: 0;
  box-shadow: 0 2px 8px rgba(42,31,20,.1);
}
.nav-logo-ring img { width: 100%; height: 100%; object-fit: cover; display: block; }

.nav-brand-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 600;
  color: var(--ink);
  letter-spacing: .02em;
  line-height: 1.15;
}
.nav-brand-tagline {
  font-family: 'Jost', sans-serif;
  font-size: 9px;
  font-weight: 500;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--muted);
  line-height: 1;
  margin-top: 2px;
}

/* ── DESKTOP NAV LINKS ── */
.nav-links {
  display: flex;
  align-items: center;
  gap: 2px;
}

.nav-link {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 7px 13px;
  border-radius: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  font-weight: 500;
  color: var(--ink);
  letter-spacing: .02em;
  white-space: nowrap;
  text-decoration: none;
  cursor: pointer;
  background: none;
  border: none;
  outline: none;
  position: relative;
  transition: background .2s, color .2s;
}
.nav-link:hover,
.nav-link.active { color: var(--rose); background: rgba(192,123,96,.07); }

/* garis bawah aktif */
.nav-link::after {
  content: '';
  position: absolute;
  bottom: 3px; left: 30%; right: 30%;
  height: 1px;
  background: var(--rose);
  transform: scaleX(0);
  transition: transform .25s ease;
}
.nav-link:hover::after,
.nav-link.active::after { transform: scaleX(1); }

/* chevron dropdown */
.nav-chevron {
  width: 10px; height: 10px;
  stroke: currentColor;
  fill: none;
  flex-shrink: 0;
  opacity: .5;
  transition: transform .2s, opacity .2s;
}
.nav-dropdown.is-open > button .nav-chevron {
  transform: rotate(180deg);
  opacity: .8;
}

/* ── DROPDOWN LEVEL 1 ── */
.nav-dropdown { position: relative; }

.nav-dd-menu {
  display: none;
  position: absolute;
  top: calc(100% + 6px);
  left: 50%;
  transform: translateX(-50%);
  min-width: 210px;
  background: var(--paper);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: 0 8px 28px rgba(42,31,20,.11);
  padding: 5px;
  z-index: 500;
  animation: ddFade .14s ease;
}
/* Arrow caret */
.nav-dd-menu::before {
  content: '';
  position: absolute;
  top: -5px; left: 50%;
  transform: translateX(-50%) rotate(45deg);
  width: 8px; height: 8px;
  background: var(--paper);
  border-left: 1px solid var(--border);
  border-top: 1px solid var(--border);
}
.nav-dropdown.is-open > .nav-dd-menu { display: block; }

/* ── DROPDOWN LEVEL 2 (sub-menu) — hover CSS ── */
.nav-sub-wrap {
  position: relative;
}
.nav-sub-menu {
  display: none;
  position: absolute;
  top: 0;
  left: calc(100% + 4px);
  min-width: 195px;
  background: var(--paper);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: 0 8px 28px rgba(42,31,20,.11);
  padding: 5px;
  z-index: 501;
  animation: ddFade .14s ease;
}
/* Hover CSS saja — lebih responsif untuk level 2 */
.nav-sub-wrap:hover > .nav-sub-menu { display: block; }

/* Layar sempit — sub-menu ke kiri */
@media (max-width: 1200px) {
  .nav-sub-menu {
    left: auto;
    right: calc(100% + 4px);
  }
}

/* ── DROPDOWN ITEMS ── */
.dd-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  padding: 8px 12px;
  border-radius: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 12.5px;
  font-weight: 400;
  color: var(--ink-l);
  text-decoration: none;
  white-space: nowrap;
  cursor: pointer;
  transition: background .15s, color .15s;
}
.dd-item:hover,
.dd-item.active { background: rgba(192,123,96,.07); color: var(--rose); }
.dd-item.active { font-weight: 500; }

.dd-arrow {
  width: 12px; height: 12px;
  stroke: currentColor; fill: none;
  flex-shrink: 0; opacity: .4;
}
.dd-item:hover .dd-arrow { opacity: .8; }

.dd-header {
  padding: 5px 12px 7px;
  border-bottom: 1px solid var(--border);
  margin-bottom: 3px;
  font-family: 'Jost', sans-serif;
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--muted);
}

/* ── CTA BUTTON ── */
.nav-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Jost', sans-serif;
  font-size: 12.5px;
  font-weight: 600;
  letter-spacing: .03em;
  color: var(--paper);
  background: var(--ink);
  padding: 9px 18px;
  border-radius: 100px;
  text-decoration: none;
  flex-shrink: 0;
  transition: background .2s, transform .2s;
}
.nav-cta:hover {
  background: var(--ink-l);
  transform: translateY(-1px);
  color: var(--paper);
  text-decoration: none;
}
.nav-cta svg { flex-shrink: 0; }

/* ══════════════════════════════════════════
   HAMBURGER — hanya muncul di mobile
══════════════════════════════════════════ */
#menu-btn {
  display: none; /* hidden by default */
  width: 38px; height: 38px;
  border-radius: 100px;
  border: 1.5px solid var(--border);
  background: transparent;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  transition: background .2s, border-color .2s;
  position: relative;
  flex-shrink: 0;
}
#menu-btn:hover {
  background: rgba(192,123,96,.08);
  border-color: rgba(192,123,96,.3);
}
/* Hanya tampil saat layar < 768px */
@media (max-width: 767px) {
  #menu-btn { display: flex; }
}

.ham-icon,
.ham-close {
  font-size: 16px;
  color: var(--ink);
  line-height: 1;
  transition: opacity .15s, transform .15s;
  position: absolute;
}
.ham-close { opacity: 0; transform: rotate(-90deg); }
#menu-btn.open .ham-icon  { opacity: 0; transform: rotate(90deg); }
#menu-btn.open .ham-close { opacity: 1; transform: rotate(0); }

/* ══════════════════════════════════════════
   MOBILE MENU
══════════════════════════════════════════ */
#mobile-menu {
  background: var(--paper);
  border-top: 1px solid var(--border);
  padding: 8px 12px 24px;
  max-height: calc(100dvh - 68px);
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
}

.mob-link {
  display: flex;
  align-items: center;
  padding: 11px 14px;
  border-radius: 7px;
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  font-weight: 400;
  color: var(--ink);
  text-decoration: none;
  width: 100%;
  background: none;
  border: none;
  text-align: left;
  cursor: pointer;
  transition: background .15s, color .15s;
  gap: 0;
}
.mob-link:hover { background: rgba(192,123,96,.07); color: var(--rose); }

/* Chevron accordion — ukuran fixed agar tidak raksasa */
.mob-chevron {
  width: 16px;
  height: 16px;
  stroke: currentColor;
  fill: none;
  margin-left: auto;
  flex-shrink: 0;
  opacity: .4;
  transition: transform .25s, opacity .2s;
}
.mob-acc-btn.open .mob-chevron {
  transform: rotate(180deg);
  opacity: .75;
}

/* Accordion content */
.mob-acc-content {
  max-height: 0;
  overflow: hidden;
  transition: max-height .32s ease;
}
.mob-acc-content.open { max-height: 900px; }

.mob-sub-link {
  display: block;
  padding: 8px 14px;
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  font-weight: 400;
  color: var(--muted);
  text-decoration: none;
  border-radius: 6px;
  transition: background .15s, color .15s;
}
.mob-sub-link:hover { background: rgba(192,123,96,.07); color: var(--rose); }
.mob-sub-link.see-all {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--rose);
  padding-top: 10px;
}

.mob-divider {
  height: 1px;
  background: var(--border);
  margin: 8px 4px;
  border: none;
}

/* ══════════════════════════════════════════
   UTILITIES
══════════════════════════════════════════ */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  overflow: hidden;
}
.prose p  { margin-bottom: 1rem; line-height: 1.75; }
.prose ul { padding-left: 1.25rem; margin-bottom: 1rem; }
.prose li { margin-bottom: .5rem; }
.prose a  { color: var(--sage); text-decoration: underline; }

.form-input, .form-select, .form-textarea {
  width: 100%; padding: .6rem .85rem;
  border: 1px solid rgba(90,70,45,.2);
  border-radius: 6px;
  font-family: 'Jost', sans-serif;
  font-size: .875rem; outline: none;
  background: rgba(251,246,238,.8);
  color: var(--ink);
  transition: border-color .18s, box-shadow .18s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
  border-color: var(--sage);
  box-shadow: 0 0 0 3px rgba(107,140,106,.12);
}
.form-label {
  display: block;
  font-size: .8rem;
  font-weight: 500;
  color: var(--ink);
  margin-bottom: .35rem;
  letter-spacing: .04em;
}

.card-hover { transition: transform .22s ease, box-shadow .22s ease; }
.card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(28,28,28,.09); }
</style>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "<?= e($site_name) ?>",
  "description": "<?= e($meta_desc) ?>",
  "url": "<?= BASE_URL ?>",
  "telephone": "<?= e(setting('phone_display')) ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "<?= e(setting('address')) ?>",
    "addressLocality": "Jakarta Pusat",
    "addressRegion": "DKI Jakarta",
    "addressCountry": "ID"
  },
  "openingHours": "Mo-Su 00:00-24:00",
  "priceRange": "Rp300.000 - Rp1.500.000"
}
</script>
</head>
<body>

<!-- ══════════════════════════════════
     TOP BAR — desktop only
══════════════════════════════════ -->
<div id="topbar" class="hidden md:block">
  <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
    <span><?= e(setting('address')) ?></span>
    <span style="display:flex;align-items:center;">
      <?= e(setting('jam_buka')) ?>
      <span class="topbar-sep">✦</span>
      <a href="tel:<?= e(setting('whatsapp_number')) ?>"><?= e($phone) ?></a>
    </span>
  </div>
</div>

<!-- ══════════════════════════════════
     NAVBAR
══════════════════════════════════ -->
<nav id="navbar" role="navigation" aria-label="Navigasi utama">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between h-16 md:h-[68px]">

      <!-- BRAND -->
      <a href="<?= BASE_URL ?>/" class="nav-brand">
        <div class="nav-logo-ring">
          <img src="<?= BASE_URL ?>/assets/images/icon.png" alt="Logo <?= e($site_name) ?>">
        </div>
        <div>
          <div class="nav-brand-name"><?= e($site_name) ?></div>
          <div class="nav-brand-tagline hidden sm:block">
            <?= e(setting('site_tagline') ?: 'Florist Jakarta Pusat') ?>
          </div>
        </div>
      </a>

      <!-- DESKTOP LINKS — hidden di mobile -->
      <div class="nav-links hidden md:flex">

        <?php foreach ($nav_items_before as $item): ?>
        <a href="<?= $item['href'] ?>"
           class="nav-link <?= ($current_slug === '' && $item['href'] === BASE_URL.'/') ? 'active' : '' ?>">
          <?= $item['label'] ?>
        </a>
        <?php endforeach; ?>

        <!-- Produk dropdown -->
        <div class="nav-dropdown">
          <button class="nav-link" id="btn-produk" aria-haspopup="true" aria-expanded="false">
            Produk
            <svg class="nav-chevron" viewBox="0 0 24 24" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <div class="nav-dd-menu" role="menu">
            <div class="dd-header">Koleksi</div>

            <?php foreach ($desktop_tree as $node):
              $hasKids = !empty($node['children']); ?>

              <?php if ($hasKids): ?>
              <div class="nav-sub-wrap">
                <div class="dd-item <?= $current_slug === $node['slug'] ? 'active' : '' ?>">
                  <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                     style="flex:1;text-decoration:none;color:inherit;">
                    <?= e($node['name']) ?>
                  </a>
                  <svg class="dd-arrow" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                  </svg>
                </div>
                <div class="nav-sub-menu" role="menu">
                  <?php foreach ($node['children'] as $ch): ?>
                  <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
                     class="dd-item <?= $current_slug === $ch['slug'] ? 'active' : '' ?>"
                     role="menuitem">
                    <?= e($ch['name']) ?>
                  </a>
                  <?php endforeach; ?>
                </div>
              </div>

              <?php else: ?>
              <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                 class="dd-item <?= $current_slug === $node['slug'] ? 'active' : '' ?>"
                 role="menuitem">
                <?= e($node['name']) ?>
              </a>
              <?php endif; ?>

            <?php endforeach; ?>
          </div>
        </div><!-- /dropdown Produk -->

        <?php foreach ($nav_items_after as $item): ?>
        <a href="<?= $item['href'] ?>" class="nav-link">
          <?= $item['label'] ?>
        </a>
        <?php endforeach; ?>

      </div><!-- /nav-links -->

      <!-- CTA + HAMBURGER -->
      <div class="flex items-center gap-3">

        <!-- CTA — desktop only -->
        <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener"
           class="nav-cta hidden md:inline-flex">
          <svg width="13" height="13" fill="white" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
          </svg>
          Pesan Sekarang
        </a>

        <!-- Hamburger — mobile only (display:none di atas 768px via CSS) -->
        <button id="menu-btn" aria-label="Buka menu" aria-expanded="false">
          <span class="ham-icon">☰</span>
          <span class="ham-close">✕</span>
        </button>

      </div>

    </div><!-- /flex row -->

    <!-- MOBILE MENU — hidden by default -->
    <div id="mobile-menu" class="md:hidden hidden">

      <?php foreach ($nav_items_before as $item): ?>
      <a href="<?= $item['href'] ?>" class="mob-link mob-close">
        <?= $item['label'] ?>
      </a>
      <?php endforeach; ?>

      <!-- Produk accordion -->
      <div>
        <button class="mob-acc-btn mob-link" onclick="toggleAcc(this)">
          <span>Produk</span>
          <svg class="mob-chevron" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="mob-acc-content">
          <div class="pl-3 ml-3" style="border-left:2px solid var(--border);">
            <?php foreach ($desktop_tree as $node):
              $hasKids2 = !empty($node['children']); ?>

              <?php if ($hasKids2): ?>
              <div>
                <button class="mob-acc-btn mob-link" style="font-size:13px;" onclick="toggleAcc(this)">
                  <?= e($node['name']) ?>
                  <svg class="mob-chevron" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <div class="mob-acc-content">
                  <div class="pl-2 ml-3" style="border-left:1px solid var(--border);">
                    <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                       class="mob-sub-link see-all mob-close">Lihat semua →</a>
                    <?php foreach ($node['children'] as $ch): ?>
                    <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
                       class="mob-sub-link mob-close"><?= e($ch['name']) ?></a>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>

              <?php else: ?>
              <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                 class="mob-sub-link mob-close"><?= e($node['name']) ?></a>
              <?php endif; ?>

            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <?php foreach ($nav_items_after as $item): ?>
      <a href="<?= $item['href'] ?>" class="mob-link mob-close">
        <?= $item['label'] ?>
      </a>
      <?php endforeach; ?>

      <div class="mob-divider"></div>

      <!-- CTA mobile -->
      <a href="<?= e($wa_url) ?>" target="_blank" class="nav-cta" style="width:100%;justify-content:center;margin-top:4px;">
        <svg width="13" height="13" fill="white" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Pesan via WhatsApp
      </a>

    </div><!-- /mobile-menu -->
  </div><!-- /max-w -->
</nav>

<script>
/* ── Scroll shadow ── */
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 10);
}, { passive: true });

/* ── Mobile hamburger ── */
const menuBtn    = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

menuBtn.addEventListener('click', () => {
  const isNowOpen = mobileMenu.classList.toggle('hidden') === false;
  menuBtn.classList.toggle('open', isNowOpen);
  menuBtn.setAttribute('aria-expanded', String(isNowOpen));
});

function closeMob() {
  mobileMenu.classList.add('hidden');
  menuBtn.classList.remove('open');
  menuBtn.setAttribute('aria-expanded', 'false');
}
document.querySelectorAll('.mob-close').forEach(el => el.addEventListener('click', closeMob));

/* ── Mobile accordion ── */
function toggleAcc(btn) {
  const content = btn.nextElementSibling;
  const isOpen  = content.classList.contains('open');

  // Tutup semua sibling di level yang sama
  const siblings = btn.closest('div').parentElement.querySelectorAll(':scope > div > .mob-acc-btn');
  siblings.forEach(b => {
    b.classList.remove('open');
    const c = b.nextElementSibling;
    if (c) c.classList.remove('open');
  });

  if (!isOpen) {
    btn.classList.add('open');
    content.classList.add('open');
  }
}

/* ── Desktop dropdown — click toggle level 1 ── */
function closeAllDropdowns() {
  document.querySelectorAll('.nav-dropdown.is-open').forEach(el => {
    el.classList.remove('is-open');
    const btn = el.querySelector('button');
    if (btn) btn.setAttribute('aria-expanded', 'false');
  });
}

document.querySelectorAll('.nav-dropdown > button').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.stopPropagation();
    const dd     = this.closest('.nav-dropdown');
    const isOpen = dd.classList.contains('is-open');
    closeAllDropdowns();
    if (!isOpen) {
      dd.classList.add('is-open');
      this.setAttribute('aria-expanded', 'true');
    }
  });
});

// Klik luar → tutup
document.addEventListener('click', closeAllDropdowns);

// Klik dalam dropdown → jangan tutup
document.querySelectorAll('.nav-dd-menu').forEach(menu => {
  menu.addEventListener('click', e => e.stopPropagation());
});

/* ── Smooth scroll anchor ── */
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const href = a.getAttribute('href');
    if (href === '#') return;
    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();
      closeMob();
      setTimeout(() => target.scrollIntoView({ behavior: 'smooth', block: 'start' }), 80);
    }
  });
});

/* ── Image fallback ── */
document.querySelectorAll('img').forEach(img => {
  img.addEventListener('error', function () {
    if (!this.dataset.fallback) {
      this.dataset.fallback = '1';
      this.src = '<?= BASE_URL ?>/assets/images/placeholder.jpg';
    }
  });
});
</script>