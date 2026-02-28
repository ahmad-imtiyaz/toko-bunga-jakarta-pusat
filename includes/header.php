<?php
/* ============================================================
   HEADER / NAVBAR — Shoji Screen | Zen Wabi-Sabi
   Konsep: Panel shoji putih washi, hanko ring logo,
           kanji sub-label menu, CTA matcha, 三 hamburger
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

/* Nav items dipecah 2 — Produk dropdown disisipkan di tengah */
$nav_items_before = [
    ['label'=>'Beranda',  'kanji'=>'家', 'href'=> BASE_URL . '/'],
    ['label'=>'Tentang',  'kanji'=>'話', 'href'=> BASE_URL . '/#tentang'],
    ['label'=>'Layanan',  'kanji'=>'花', 'href'=> BASE_URL . '/#layanan'],
];
$nav_items_after = [
    ['label'=>'Area',     'kanji'=>'地', 'href'=> BASE_URL . '/#area'],
    ['label'=>'Testimoni','kanji'=>'声', 'href'=> BASE_URL . '/#testimoni'],
    ['label'=>'FAQ',      'kanji'=>'問', 'href'=> BASE_URL . '/#faq'],
];
/* Gabungan untuk mobile */
$nav_items = array_merge($nav_items_before, $nav_items_after);

/* Produk tree */
$desktop_tree = [];
if (!empty($nav_parents)) {
    foreach ($nav_parents as $par)
        $desktop_tree[] = ['name'=>$par['name'],'slug'=>$par['slug'],'children'=>$nav_children[$par['id']]??[]];
} else {
    $desktop_tree = [
        ['name'=>'Bunga Papan','slug'=>'bunga-papan-jakarta-pusat','children'=>[
            ['name'=>'Happy Wedding','slug'=>'bunga-papan-happy-wedding'],
            ['name'=>'Duka Cita','slug'=>'bunga-papan-duka-cita'],
            ['name'=>'Selamat & Sukses','slug'=>'bunga-papan-selamat'],
        ]],
        ['name'=>'Hand Bouquet','slug'=>'hand-bouquet-jakarta-pusat','children'=>[
            ['name'=>'Anniversary','slug'=>'hand-bouquet-anniversary'],
            ['name'=>'Birthday','slug'=>'hand-bouquet-birthday'],
            ['name'=>'Graduation','slug'=>'hand-bouquet-graduation'],
        ]],
        ['name'=>'Bunga Meja','slug'=>'bunga-meja-jakarta-pusat','children'=>[]],
        ['name'=>'Standing Flowers','slug'=>'standing-flowers-jakarta-pusat','children'=>[]],
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

<!-- ── Google Fonts ── -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;600;700&family=Zen+Kaku+Gothic+New:wght@300;400;500;700&family=Cormorant+Garamond:ital,wght@0,300;1,300;1,400&display=swap" rel="stylesheet">

<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        sumi:    '#1C1C1C',
        washi:   '#F5F0E8',
        matcha:  '#7A8C6E',
        shiitake:'#8B6F5E',
        bamboo:  '#C4A882',
        sakura:  '#E8C4B8',
        ink:     '#3D2B1F',
        moss:    '#4A5E3A',
        rice:    '#FDFAF5',
      },
      fontFamily: {
        serif:  ['"Noto Serif JP"','Georgia','serif'],
        sans:   ['"Zen Kaku Gothic New"','sans-serif'],
        italic: ['"Cormorant Garamond"','Georgia','serif'],
      },
    }
  }
}
</script>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<style>
/* ══════════════════════════════════════════
   CSS VARIABLES — Zen Wabi-Sabi
══════════════════════════════════════════ */
:root {
  --sumi:     #1C1C1C;
  --washi:    #F5F0E8;
  --matcha:   #7A8C6E;
  --shiitake: #8B6F5E;
  --bamboo:   #C4A882;
  --sakura:   #E8C4B8;
  --ink:      #3D2B1F;
  --moss:     #4A5E3A;
  --rice:     #FDFAF5;
  --torii:    #8B2020;
}

/* ── Base body ── */
body {
  font-family: 'Zen Kaku Gothic New', sans-serif;
  background: var(--rice);
  color: var(--sumi);
}
h1,h2,h3 { font-family: 'Noto Serif JP', serif; }
section[id] { scroll-margin-top: 88px; }

/* ── Shared utilities ── */
@keyframes softPulse {
  0%,100% { opacity:1; transform:scale(1); }
  50%      { opacity:.35; transform:scale(1.5); }
}
@keyframes ropeSwing {
  0%,100% { transform:translateY(0); }
  50%      { transform:translateY(5px); }
}
@keyframes ddSlideIn {
  from { opacity:0; transform:translateY(-8px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes shimmerGold {
  0%   { background-position:-200% center; }
  100% { background-position:200% center; }
}

/* ══════════════════════════════════════════
   TOP BAR — sumi dark strip
══════════════════════════════════════════ */
#topbar {
  background: var(--sumi);
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 10.5px;
  font-weight: 400;
  letter-spacing: .06em;
  color: rgba(245,240,232,.42);
  padding: 6px 0;
  border-bottom: 1px solid rgba(196,168,130,.12);
}
#topbar a {
  color: rgba(196,168,130,.75);
  text-decoration: none;
  transition: color .2s;
}
#topbar a:hover { color: var(--bamboo); }
.topbar-sep { color: rgba(196,168,130,.2); margin: 0 10px; }
.topbar-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 11px;
  color: rgba(196,168,130,.3);
  margin-right: 6px;
}

/* ══════════════════════════════════════════
   NAVBAR — Shoji Screen
══════════════════════════════════════════ */
#navbar {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(253,250,245,.96);
  backdrop-filter: blur(14px) saturate(1.2);
  -webkit-backdrop-filter: blur(14px) saturate(1.2);
  transition: box-shadow .35s ease, background .35s ease;

  /* Shoji border bawah — garis panel + motif */
  border-bottom: 1px solid rgba(139,111,94,.18);
}

/* Shoji panel lines — pseudo element */
#navbar::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(
    to right,
    transparent 0%,
    rgba(196,168,130,.0) 5%,
    var(--matcha) 20%,
    var(--bamboo) 50%,
    var(--matcha) 80%,
    rgba(196,168,130,.0) 95%,
    transparent 100%
  );
  opacity: 0;
  transition: opacity .35s;
}
#navbar.scrolled::after { opacity: 1; }

#navbar.scrolled {
  background: rgba(253,250,245,.99);
  box-shadow:
    0 1px 0 rgba(139,111,94,.15),
    0 4px 24px rgba(28,28,28,.07),
    0 12px 40px rgba(28,28,28,.04);
}

/* Shoji grid pattern di bg navbar (sangat halus) */
#navbar-inner {
  position: relative;
}
#navbar-inner::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(139,111,94,.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(139,111,94,.04) 1px, transparent 1px);
  background-size: 48px 48px;
  pointer-events: none;
  z-index: 0;
}

/* ── BRAND ── */
.nav-brand {
  display: flex;
  align-items: center;
  gap: 11px;
  text-decoration: none;
  flex-shrink: 0;
  transition: opacity .22s;
  position: relative;
  z-index: 1;
}
.nav-brand:hover { opacity: .82; text-decoration: none; }

/* Hanko ring — lingkaran segel Jepang */
.nav-hanko {
  position: relative;
  width: 44px; height: 44px;
  flex-shrink: 0;
}
.nav-hanko-ring {
  width: 44px; height: 44px;
  border-radius: 50%;
  border: 2px solid var(--torii);
  box-shadow:
    0 0 0 1px rgba(139,32,32,.12),
    0 0 0 3px rgba(253,250,245,.6),
    0 0 0 4px rgba(139,32,32,.08),
    0 4px 14px rgba(139,32,32,.2);
  overflow: hidden;
  transition: box-shadow .3s;
}
.nav-brand:hover .nav-hanko-ring {
  box-shadow:
    0 0 0 1px rgba(139,32,32,.2),
    0 0 0 3px rgba(253,250,245,.8),
    0 0 0 5px rgba(139,32,32,.15),
    0 6px 20px rgba(139,32,32,.3);
}
.nav-hanko-ring img {
  width: 100%; height: 100%;
  object-fit: cover;
}
/* Titik merah hanko kecil */
.nav-hanko-dot {
  position: absolute;
  bottom: 0; right: 0;
  width: 11px; height: 11px;
  background: var(--torii);
  border-radius: 50%;
  border: 2px solid rgba(253,250,245,.9);
  box-shadow: 0 1px 4px rgba(139,32,32,.4);
}

.nav-brand-text { display: flex; flex-direction: column; gap: 1px; }
.nav-brand-name {
  font-family: 'Noto Serif JP', serif;
  font-size: 17px;
  font-weight: 600;
  color: var(--ink);
  line-height: 1.15;
  letter-spacing: .04em;
}
.nav-brand-sub {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 9px;
  font-weight: 400;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: rgba(139,111,94,.6);
}
.nav-brand-sub-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 11px;
  color: rgba(196,168,130,.55);
  font-weight: 300;
  letter-spacing: 0;
}

/* ── DESKTOP NAV LINKS dengan kanji sub-label ── */
.nav-links {
  display: flex;
  align-items: center;
  gap: 2px;
  position: relative;
  z-index: 1;
}

.nav-link {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1px;
  padding: 6px 12px 5px;
  border-radius: 3px;
  text-decoration: none;
  cursor: pointer;
  background: none;
  border: none;
  position: relative;
  transition: background .22s;
  outline: none;
}
.nav-link:hover  { background: rgba(122,140,110,.08); }
.nav-link.active { background: rgba(122,140,110,.1); }

/* Garis bawah aktif */
.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0; left: 20%; right: 20%;
  height: 1.5px;
  background: linear-gradient(to right, transparent, var(--matcha), transparent);
  transform: scaleX(0);
  transition: transform .3s ease;
}
.nav-link:hover::after,
.nav-link.active::after { transform: scaleX(1); }

.nav-link-label {
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 12.5px;
  font-weight: 500;
  color: var(--ink);
  letter-spacing: .02em;
  white-space: nowrap;
  transition: color .22s;
}
.nav-link:hover  .nav-link-label,
.nav-link.active .nav-link-label { color: var(--matcha); }

/* Kanji kecil di bawah label */
.nav-link-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 8px;
  color: rgba(139,111,94,.38);
  font-weight: 300;
  letter-spacing: .05em;
  transition: color .22s;
  line-height: 1;
}
.nav-link:hover  .nav-link-kanji,
.nav-link.active .nav-link-kanji { color: rgba(122,140,110,.65); }

/* Chevron di link dropdown */
.nav-link-chevron {
  width: 10px; height: 10px;
  opacity: .4;
  transition: transform .22s, opacity .22s;
  flex-shrink: 0;
  margin-left: 3px;
  align-self: center;
}
.nav-dropdown:hover .nav-link-chevron,
.nav-dropdown:focus-within .nav-link-chevron {
  transform: rotate(180deg);
  opacity: .75;
}

/* ── DROPDOWN MENU ── */
.nav-dropdown { position: relative; }

.nav-dropdown-menu {
  display: none;
  position: absolute;
  top: calc(100% + 10px);
  left: 50%;
  transform: translateX(-50%);
  min-width: 230px;
  background: rgba(253,250,245,.98);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(139,111,94,.16);
  border-radius: 4px;
  box-shadow:
    0 4px 0 rgba(139,111,94,.08),
    0 16px 48px rgba(28,28,28,.1);
  padding: 8px;
  z-index: 999;
  animation: ddSlideIn .18s ease;

  /* Shoji grid halus di dalam dropdown */
  background-image:
    linear-gradient(rgba(139,111,94,.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(139,111,94,.03) 1px, transparent 1px);
  background-size: 36px 36px;
  background-color: rgba(253,250,245,.98);
}

/* Arrow kecil ke atas */
.nav-dropdown-menu::before {
  content: '';
  position: absolute;
  top: -5px; left: 50%;
  transform: translateX(-50%) rotate(45deg);
  width: 9px; height: 9px;
  background: rgba(253,250,245,.98);
  border-left: 1px solid rgba(139,111,94,.16);
  border-top: 1px solid rgba(139,111,94,.16);
}

.nav-dropdown:hover .nav-dropdown-menu,
.nav-dropdown:focus-within .nav-dropdown-menu { display: block; }

/* Nested sub-menu */
.nav-sub-dropdown { position: relative; }
.nav-sub-menu {
  display: none;
  position: absolute;
  top: -8px;
  left: calc(100% + 8px);
  min-width: 220px;
  background: rgba(253,250,245,.98);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(139,111,94,.16);
  border-radius: 4px;
  box-shadow: 0 16px 48px rgba(28,28,28,.1);
  padding: 8px;
  z-index: 1000;
  animation: ddSlideIn .18s ease;
}
@media (max-width: 1100px) {
  .nav-sub-menu { left: auto; right: calc(100% + 8px); }
}
.nav-sub-dropdown:hover .nav-sub-menu,
.nav-sub-dropdown:focus-within .nav-sub-menu { display: block; }

/* Dropdown item */
.dd-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 9px 12px;
  border-radius: 3px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 12.5px;
  font-weight: 400;
  color: var(--ink);
  text-decoration: none;
  white-space: nowrap;
  transition: background .15s, color .15s;
  cursor: pointer;
  position: relative;
}
.dd-item::before {
  content: '';
  position: absolute;
  left: 0; top: 20%; bottom: 20%;
  width: 2px;
  background: var(--matcha);
  border-radius: 1px;
  transform: scaleY(0);
  transition: transform .2s;
}
.dd-item:hover::before,
.dd-item.active::before { transform: scaleY(1); }
.dd-item:hover  { background: rgba(122,140,110,.07); color: var(--moss); }
.dd-item.active { color: var(--moss); font-weight: 500; }
.dd-item .sub-arrow { margin-left: auto; opacity: .35; transition: opacity .15s; }
.dd-item:hover .sub-arrow { opacity: .8; }

/* Divider dalam dropdown */
.dd-divider {
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(139,111,94,.15), transparent);
  margin: 5px 8px;
}

/* ── CTA BUTTON — matcha + torii style ── */
.nav-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: .06em;
  color: #fff;

  /* Gradien matcha-moss */
  background: linear-gradient(135deg, var(--matcha) 0%, var(--moss) 100%);
  padding: 10px 20px;
  border-radius: 2px; /* persegi ala shoji, bukan pill */
  text-decoration: none;
  flex-shrink: 0;
  position: relative;
  overflow: hidden;
  box-shadow:
    0 4px 14px rgba(74,94,58,.35),
    0 1px 0 rgba(255,255,255,.1) inset;
  transition: transform .25s, box-shadow .25s, background .25s;
}
/* Shimmer overlay */
.nav-cta::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 60%);
  pointer-events: none;
}
/* Torii gate mini ornamen kiri */
.nav-cta::after {
  content: '⛩';
  position: absolute;
  left: -22px;
  font-size: 14px;
  opacity: 0;
  transition: left .25s, opacity .25s;
}
.nav-cta:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(74,94,58,.5);
  color: #fff;
  text-decoration: none;
}
.nav-cta:hover::after {
  left: 8px;
  opacity: .6;
}

/* Kanji kecil di CTA */
.nav-cta-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 10px;
  opacity: .65;
  font-weight: 300;
}

/* ── HAMBURGER 三 (san) — mobile ── */
#menu-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px; height: 40px;
  border-radius: 3px;
  border: 1px solid rgba(139,111,94,.22);
  background: rgba(245,240,232,.6);
  cursor: pointer;
  transition: background .2s, border-color .2s;
  position: relative;
  overflow: hidden;
  z-index: 1;
}
#menu-btn:hover {
  background: rgba(122,140,110,.1);
  border-color: rgba(122,140,110,.35);
}
/* Ikon 三 sebagai text Kanji */
.menu-san-open {
  font-family: 'Noto Serif JP', serif;
  font-size: 19px;
  color: var(--ink);
  font-weight: 300;
  line-height: 1;
  letter-spacing: 0;
  transition: opacity .18s, transform .18s;
}
.menu-san-close {
  font-family: 'Noto Serif JP', serif;
  font-size: 16px;
  color: var(--ink);
  font-weight: 400;
  line-height: 1;
  position: absolute;
  opacity: 0;
  transform: rotate(-90deg);
  transition: opacity .18s, transform .18s;
}
#menu-btn.open .menu-san-open  { opacity: 0; transform: rotate(90deg); }
#menu-btn.open .menu-san-close { opacity: 1; transform: rotate(0deg); }

@media (min-width: 768px) {
  #menu-btn { display: none !important; }
}

/* ══════════════════════════════════════════
   MOBILE MENU — Shoji drawer
══════════════════════════════════════════ */
#mobile-menu {
  border-top: 1px solid rgba(139,111,94,.14);
  background: rgba(253,250,245,.99);
  padding: 10px 12px 20px;
  /* FIX SCROLL BUG: max-height + overflow-y scroll */
  max-height: calc(100dvh - 72px);
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  /* Shoji grid */
  background-image:
    linear-gradient(rgba(139,111,94,.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(139,111,94,.025) 1px, transparent 1px);
  background-size: 40px 40px;
  background-color: rgba(253,250,245,.99);
}

.mob-link {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 11px 14px;
  border-radius: 3px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 13.5px;
  font-weight: 400;
  color: var(--ink);
  text-decoration: none;
  width: 100%;
  background: none;
  border: none;
  text-align: left;
  cursor: pointer;
  transition: background .15s, color .15s;
  position: relative;
}
.mob-link:hover { background: rgba(122,140,110,.08); color: var(--moss); }
/* Kanji di kanan */
.mob-link-kanji {
  margin-left: auto;
  font-family: 'Noto Serif JP', serif;
  font-size: 14px;
  color: rgba(196,168,130,.4);
  font-weight: 300;
}

/* Mobile accordion */
.mob-acc-content {
  max-height: 0;
  overflow: hidden;
  transition: max-height .32s ease;
}
.mob-acc-content.open { max-height: 900px; }
.mob-acc-btn .acc-chevron {
  width: 14px; height: 14px;
  opacity: .38;
  transition: transform .25s, opacity .2s;
}
.mob-acc-btn.open .acc-chevron { transform: rotate(180deg); opacity: .75; }

.mob-sub-link {
  display: flex;
  align-items: center;
  padding: 8px 14px 8px 16px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 12.5px;
  color: rgba(61,43,31,.6);
  text-decoration: none;
  border-radius: 3px;
  transition: background .15s, color .15s;
}
.mob-sub-link:hover { background: rgba(122,140,110,.07); color: var(--moss); }
.mob-sub-link.see-all {
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--matcha);
  padding-top: 10px;
}

.mob-divider {
  border: none;
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(139,111,94,.15), transparent);
  margin: 8px 4px;
}

/* ══════════════════════════════════════════
   UTILITIES — dipakai di seluruh halaman
══════════════════════════════════════════ */
.line-clamp-2 {
  display: -webkit-box;
  display: box; /* future compatibility */

  -webkit-box-orient: vertical;
  box-orient: vertical;

  -webkit-line-clamp: 2;
  line-clamp: 2;

  overflow: hidden;
}
.prose p  { margin-bottom: 1rem; line-height: 1.75; }
.prose ul { padding-left: 1.25rem; margin-bottom: 1rem; }
.prose li { margin-bottom: .5rem; }
.prose a  { color: var(--matcha); text-decoration: underline; }

/* Form elements */
.form-input, .form-select, .form-textarea {
  width: 100%; padding: .6rem .85rem;
  border: 1px solid rgba(139,111,94,.25);
  border-radius: 3px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: .875rem; outline: none;
  background: rgba(253,250,245,.8);
  transition: border-color .18s, box-shadow .18s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
  border-color: var(--matcha);
  box-shadow: 0 0 0 3px rgba(122,140,110,.12);
}
.form-label {
  display: block;
  font-size: .8rem;
  font-weight: 500;
  color: var(--ink);
  margin-bottom: .35rem;
  letter-spacing: .04em;
}

/* Card hover */
.card-hover { transition: transform .22s ease, box-shadow .22s ease; }
.card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(28,28,28,.09); }
</style>

<script type="application/ld+json">
{
  "@context":"https://schema.org","@type":"LocalBusiness",
  "name":"<?= e($site_name) ?>","description":"<?= e($meta_desc) ?>",
  "url":"<?= BASE_URL ?>","telephone":"<?= e(setting('phone_display')) ?>",
  "address":{
    "@type":"PostalAddress",
    "streetAddress":"<?= e(setting('address')) ?>",
    "addressLocality":"Jakarta Pusat",
    "addressRegion":"DKI Jakarta",
    "addressCountry":"ID"
  },
  "openingHours":"Mo-Su 00:00-24:00",
  "priceRange":"Rp300.000 - Rp1.500.000"
}
</script>
</head>
<body>

<!-- ══════════════════════════════════
     TOP BAR
══════════════════════════════════ -->
<div id="topbar" class="hidden md:block">
  <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
    <span>
      <span class="topbar-kanji">地</span>
      <?= e(setting('address')) ?>
    </span>
    <span>
      <span class="topbar-kanji">時</span>
      <?= e(setting('jam_buka')) ?>
      <span class="topbar-sep">·</span>
      <span class="topbar-kanji">話</span>
      <a href="tel:<?= e(setting('whatsapp_number')) ?>"><?= e($phone) ?></a>
    </span>
  </div>
</div>

<!-- ══════════════════════════════════
     NAVBAR — Shoji Screen
══════════════════════════════════ -->
<nav id="navbar" role="navigation" aria-label="Navigasi utama">
  <div class="max-w-7xl mx-auto px-4" id="navbar-inner">
    <div class="flex items-center justify-between h-16 md:h-[72px]">

      <!-- ── BRAND / HANKO ── -->
      <a href="<?= BASE_URL ?>/" class="nav-brand">
        <div class="nav-hanko">
          <div class="nav-hanko-ring">
            <img src="<?= BASE_URL ?>/assets/images/icon.png" alt="Logo <?= e($site_name) ?>">
          </div>
          <div class="nav-hanko-dot"></div>
        </div>
        <div class="nav-brand-text">
          <span class="nav-brand-name"><?= e($site_name) ?></span>
          <span class="nav-brand-sub hidden sm:flex">
            <span class="nav-brand-sub-kanji">花屋</span>
            <?= e(setting('site_tagline') ?: 'Florist Jakarta Pusat') ?>
          </span>
        </div>
      </a>

      <!-- ── DESKTOP LINKS ── -->
      <div class="nav-links hidden md:flex">

        <?php foreach ($nav_items_before as $item): ?>
        <a href="<?= $item['href'] ?>"
           class="nav-link <?= ($current_slug === '' && $item['href'] === BASE_URL.'/') ? 'active' : '' ?>">
          <span class="nav-link-label"><?= $item['label'] ?></span>
          <span class="nav-link-kanji"><?= $item['kanji'] ?></span>
        </a>
        <?php endforeach; ?>

        <!-- Produk dropdown — disisip antara Layanan & Area -->
        <div class="nav-dropdown">
          <button class="nav-link flex-row gap-1" aria-haspopup="true" style="flex-direction:row;gap:4px;align-items:center;">
            <span style="display:flex;flex-direction:column;align-items:center;gap:1px;">
              <span class="nav-link-label">Produk</span>
              <span class="nav-link-kanji">品</span>
            </span>
            <svg class="nav-link-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <div class="nav-dropdown-menu" role="menu">
            <!-- Header dropdown -->
            <div style="padding:6px 12px 8px;border-bottom:1px solid rgba(139,111,94,.1);margin-bottom:4px;">
              <span style="font-family:'Noto Serif JP',serif;font-size:9px;letter-spacing:.22em;text-transform:uppercase;color:rgba(139,111,94,.5);">品揃え · Koleksi</span>
            </div>

            <?php foreach ($desktop_tree as $node):
              $hasKids = !empty($node['children']); ?>
              <?php if ($hasKids): ?>
              <div class="nav-sub-dropdown">
                <div class="dd-item <?= $current_slug===$node['slug']?'active':'' ?>">
                  <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                     style="text-decoration:none;color:inherit;flex:1">
                    <?= e($node['name']) ?>
                  </a>
                  <svg class="sub-arrow w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                  </svg>
                </div>
                <div class="nav-sub-menu" role="menu">
                  <?php foreach ($node['children'] as $ch): ?>
                  <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
                     class="dd-item <?= $current_slug===$ch['slug']?'active':'' ?>" role="menuitem">
                    <?= e($ch['name']) ?>
                  </a>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php else: ?>
              <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                 class="dd-item <?= $current_slug===$node['slug']?'active':'' ?>" role="menuitem">
                <?= e($node['name']) ?>
              </a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div><!-- /nav-dropdown Produk -->

        <?php foreach ($nav_items_after as $item): ?>
        <a href="<?= $item['href'] ?>"
           class="nav-link">
          <span class="nav-link-label"><?= $item['label'] ?></span>
          <span class="nav-link-kanji"><?= $item['kanji'] ?></span>
        </a>
        <?php endforeach; ?>

      </div><!-- /nav-links -->

      <!-- ── CTA + HAMBURGER ── -->
      <div class="flex items-center gap-3">

        <!-- CTA matcha -->
        <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener"
           class="nav-cta hidden md:inline-flex">
          <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink:0">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
          </svg>
          Pesan Sekarang
          <span class="nav-cta-kanji">注文</span>
        </a>

        <!-- Hamburger 三 -->
        <button id="menu-btn" aria-label="Buka menu" aria-expanded="false">
          <span class="menu-san-open">三</span>
          <span class="menu-san-close">✕</span>
        </button>

      </div>

    </div><!-- /flex row -->

    <!-- ── MOBILE MENU ── -->
    <div id="mobile-menu" class="md:hidden hidden">

      <?php foreach ($nav_items_before as $item): ?>
      <a href="<?= $item['href'] ?>" class="mob-link mob-close">
        <span><?= $item['label'] ?></span>
        <span class="mob-link-kanji"><?= $item['kanji'] ?></span>
      </a>
      <?php endforeach; ?>

      <!-- Produk accordion — disisip antara Layanan & Area -->
      <div>
        <button class="mob-acc-btn mob-link" onclick="toggleAcc(this)">
          <span>Produk</span>
          <span class="mob-link-kanji" style="margin-left:0">品</span>
          <svg class="acc-chevron ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="mob-acc-content">
          <div class="pl-3 ml-4" style="border-left:2px solid rgba(122,140,110,.2)">
            <?php foreach ($desktop_tree as $node):
              $hasKids2 = !empty($node['children']); ?>
              <?php if ($hasKids2): ?>
              <div>
                <button class="mob-acc-btn mob-link text-sm" onclick="toggleAcc(this)">
                  <?= e($node['name']) ?>
                  <svg class="acc-chevron ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <div class="mob-acc-content">
                  <div class="pl-2 ml-3" style="border-left:1px solid rgba(122,140,110,.15)">
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
        <span><?= $item['label'] ?></span>
        <span class="mob-link-kanji"><?= $item['kanji'] ?></span>
      </a>
      <?php endforeach; ?>

      <div class="mob-divider"></div>

      <!-- CTA mobile -->
      <a href="<?= e($wa_url) ?>" target="_blank"
         class="nav-cta mt-1 justify-center">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Pesan via WhatsApp
        <span class="nav-cta-kanji">注文</span>
      </a>

    </div><!-- /mobile-menu -->

  </div><!-- /navbar-inner -->
</nav>

<script>
/* ── Navbar scroll shadow + shoji line ── */
window.addEventListener('scroll', () => {
  document.getElementById('navbar')
    .classList.toggle('scrolled', window.scrollY > 10);
}, { passive: true });

/* ── Hamburger 三 toggle ── */
const menuBtn    = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

menuBtn.addEventListener('click', () => {
  const isOpen = mobileMenu.classList.toggle('hidden');
  menuBtn.classList.toggle('open', !isOpen);
  menuBtn.setAttribute('aria-expanded', String(!isOpen));
  // Tidak lock body — biarkan #mobile-menu scroll sendiri
});

function closeMob() {
  mobileMenu.classList.add('hidden');
  menuBtn.classList.remove('open');
  menuBtn.setAttribute('aria-expanded', 'false');
}
document.querySelectorAll('.mob-close').forEach(el =>
  el.addEventListener('click', closeMob)
);

/* ── Mobile accordion ── */
function toggleAcc(btn) {
  const content = btn.nextElementSibling;
  const isOpen  = content.classList.contains('open');
  /* Tutup semua sibling */
  const parent  = btn.closest('div');
  if (parent) {
    parent.parentElement.querySelectorAll(':scope > div > .mob-acc-btn').forEach(b => {
      b.classList.remove('open');
      const c = b.nextElementSibling;
      if (c) c.classList.remove('open');
    });
  }
  if (!isOpen) {
    btn.classList.add('open');
    content.classList.add('open');
  }
}

/* ── Smooth scroll untuk anchor ── */
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const href = a.getAttribute('href');
    if (href === '#') return;
    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();
      closeMob();
      setTimeout(() => target.scrollIntoView({ behavior:'smooth', block:'start' }), 80);
    }
  });
});

/* ── Image error fallback ── */
document.querySelectorAll('img').forEach(img => {
  img.addEventListener('error', function() {
    if (!this.dataset.fallback) {
      this.dataset.fallback = '1';
      this.src = '<?= BASE_URL ?>/assets/images/placeholder.jpg';
    }
  });
});
</script>