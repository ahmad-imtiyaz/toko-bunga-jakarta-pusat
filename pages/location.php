<?php
require_once __DIR__ . '/../includes/config.php';

$meta_title    = $location['meta_title']       ?: 'Toko Bunga ' . $location['name'] . ' - Florist Jakarta Pusat Terpercaya';
$meta_desc     = $location['meta_description'] ?: '';
$meta_keywords = 'toko bunga ' . strtolower($location['name']) . ', florist ' . strtolower($location['name']) . ', bunga Jakarta Pusat';

$all_cats_raw = db()->query("SELECT * FROM categories WHERE status='active' ORDER BY urutan ASC, id ASC")->fetchAll();
$all_cats = []; $all_cats_subs = [];
foreach ($all_cats_raw as $ac) {
    $pid = $ac['parent_id'] ?? null;
    if ($pid === null || $pid == 0) $all_cats[] = $ac;
    else $all_cats_subs[$pid][] = $ac;
}

$cats_with_products = [];
foreach ($all_cats as $cat) {
    $sub_ids   = array_column($all_cats_subs[$cat['id']] ?? [], 'id');
    $all_ids   = array_merge([$cat['id']], $sub_ids);
    $in_clause = implode(',', array_fill(0, count($all_ids), '?'));
    $stmt      = db()->prepare("SELECT * FROM products WHERE status='active' AND category_id IN ($in_clause) ORDER BY id ASC");
    $stmt->execute($all_ids);
    $prods     = $stmt->fetchAll();
    if (!empty($prods)) $cats_with_products[] = ['cat' => $cat, 'products' => $prods];
}

$locations = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$faqs      = db()->query("SELECT * FROM faqs WHERE status='active' ORDER BY urutan LIMIT 6")->fetchAll();
$wa_url    = setting('whatsapp_url');

// ── Slider kalkulasi ──
$slider_per_page    = 10;
$slider_total       = count($locations);
$slider_pages       = (int)ceil($slider_total / $slider_per_page);
$slider_active_idx  = array_search($location['id'], array_column($locations, 'id'));
$slider_active_page = ($slider_active_idx !== false) ? (int)floor($slider_active_idx / $slider_per_page) : 0;
$all_prices = [];
foreach ($cats_with_products as $row) foreach ($row['products'] as $p) $all_prices[] = $p['price'];
$min_price = !empty($all_prices) ? min($all_prices) : 300000;

require __DIR__ . '/../includes/header.php';
?>

<style>
/* ─── AREA/LOCATION PAGE — Manila Bunga Kertas ─── */

/* Animasi ringan — hanya transform + opacity */
@keyframes areaFadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes areaPetalDrift {
  0%   { transform: translateY(-8px) rotate(0deg)   translateX(0);   opacity: 0; }
  8%   { opacity: .35; }
  90%  { opacity: .2; }
  100% { transform: translateY(108vh) rotate(500deg) translateX(36px); opacity: 0; }
}
@keyframes areaPulseRing {
  0%   { transform: scale(1);   opacity: .6; }
  100% { transform: scale(2.2); opacity: 0; }
}
@keyframes areaTicker {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}

.area-rv1 { animation: areaFadeUp .5s ease both .06s; }
.area-rv2 { animation: areaFadeUp .5s ease both .16s; }
.area-rv3 { animation: areaFadeUp .5s ease both .28s; }
.area-rv4 { animation: areaFadeUp .5s ease both .42s; }

/* ─── KELOPAK JATUH ─── */
.area-petal {
  position: fixed;
  pointer-events: none; z-index: 9998;
  border-radius: 80% 20% 80% 20% / 60% 60% 40% 40%;
  animation: areaPetalDrift linear infinite;
}

/* ═══════════════════
   HERO
═══════════════════ */
.area-hero {
  position: relative;
  min-height: 520px;
  background: var(--paper, #FBF6EE);
  overflow: hidden;
  padding-top: 88px;
}

/* Grain texture — static */
.area-hero::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.028'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 0;
}

/* Warm glow */
.area-hero::after {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 65% 80% at 100% 50%, rgba(242,232,213,.65) 0%, transparent 60%),
    radial-gradient(ellipse 35% 50% at 0% 100%,  rgba(192,123,96,.07) 0%, transparent 55%);
  pointer-events: none; z-index: 0;
}

/* Foto lokasi kanan — opsional */
.area-hero-img {
  position: absolute; right: 0; top: 0; bottom: 0;
  width: 42%; z-index: 1;
}
.area-hero-img-bg {
  position: absolute; inset: 0;
  background-size: cover; background-position: center;
}
.area-hero-img-fade {
  position: absolute; inset: 0;
  background: linear-gradient(90deg,
    var(--paper,#FBF6EE) 0%,
    rgba(251,246,238,.72) 22%,
    rgba(251,246,238,.18) 58%,
    rgba(251,246,238,.05) 100%
  );
}
.area-hero-img-border {
  position: absolute; right: 0; top: 0; bottom: 0;
  width: 3px;
  background: linear-gradient(180deg,
    var(--manila-dd,#D6C4A0),
    var(--rose,#C07B60),
    var(--manila-dd,#D6C4A0)
  );
}

/* Ornamen SVG pojok kanan atas */
.area-hero-floral {
  position: absolute; right: 0; top: 0;
  width: 360px; opacity: .055;
  pointer-events: none; z-index: 0;
}

/* Inner */
.area-hero-inner {
  position: relative; z-index: 5;
  max-width: 1280px; margin: 0 auto;
  padding: 0 24px 88px;
}

/* Breadcrumb */
.area-breadcrumb {
  display: flex; align-items: center; gap: 8px;
  margin-bottom: 34px;
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 400;
  letter-spacing: .12em; text-transform: uppercase;
}
.area-breadcrumb a { color: var(--muted,#8A7560); text-decoration: none; transition: color .2s; }
.area-breadcrumb a:hover { color: var(--rose,#C07B60); }
.area-breadcrumb-sep { color: var(--rose-l,#DFA98C); font-size: 13px; }
.area-breadcrumb-cur { color: var(--rose,#C07B60); }

/* Badge lokasi */
.area-badge {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 5px 14px 5px 10px;
  background: var(--manila,#F2E8D5);
  border: 1px solid var(--manila-dd,#D6C4A0);
  border-left: 3px solid var(--rose,#C07B60);
  border-radius: 3px; margin-bottom: 16px;
}
.area-badge-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--rose,#C07B60); position: relative;
}
.area-badge-dot::after {
  content: '';
  position: absolute; inset: -3px; border-radius: 50%;
  border: 1px solid var(--rose,#C07B60);
  animation: areaPulseRing 2s ease-out infinite;
}
.area-badge-text {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 600;
  letter-spacing: .16em; text-transform: uppercase;
  color: var(--rose,#C07B60);
}

/* Judul */
.area-h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 4.8vw, 3.8rem);
  font-weight: 600; color: var(--ink,#2A1F14);
  line-height: 1.1; letter-spacing: -.01em;
  margin-bottom: 8px;
}
.area-tagline {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; font-weight: 300;
  font-size: clamp(1rem, 1.9vw, 1.3rem);
  color: var(--rose,#C07B60); margin-bottom: 20px;
  letter-spacing: .03em;
}
.area-desc {
  font-family: 'Jost', sans-serif;
  font-size: 15px; font-weight: 300;
  line-height: 1.85; color: var(--ink-l,#5C4A35);
  max-width: 480px; margin-bottom: 28px; opacity: .8;
}

/* Stat cards */
.area-stats { display: flex; gap: 10px; margin-bottom: 28px; flex-wrap: wrap; }
.area-stat {
  flex: 1; min-width: 88px;
  background: #fff;
  border: 1px solid var(--manila-dd,#D6C4A0);
  border-radius: 8px; padding: 13px 15px; text-align: center;
  transition: transform .25s, box-shadow .25s;
}
.area-stat:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(42,31,20,.1); }
.area-stat-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 9px; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--muted,#8A7560); margin-bottom: 4px;
}
.area-stat-val {
  font-family: 'Cormorant Garamond', serif;
  font-size: 27px; font-weight: 600;
  color: var(--rose,#C07B60); line-height: 1;
}
.area-stat-val span { font-size: 13px; }
.area-stat-sub {
  font-family: 'Jost', sans-serif;
  font-size: 10px; color: var(--muted,#8A7560); margin-top: 2px;
}

/* Info card kanan */
.area-info-card {
  background: var(--manila,#F2E8D5);
  border: 1px solid var(--manila-dd,#D6C4A0);
  border-radius: 12px; overflow: hidden;
}
.area-info-card-head {
  padding: 14px 18px;
  background: var(--ink,#2A1F14);
}
.area-info-card-head-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px; font-weight: 600;
  color: var(--paper,#FBF6EE);
}
.area-info-card-head-sub {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 400;
  color: rgba(251,246,238,.4);
  letter-spacing: .1em; text-transform: uppercase;
  margin-bottom: 3px;
}
.area-info-row {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 16px;
  border-bottom: 1px solid var(--manila-dd,#D6C4A0);
}
.area-info-row:last-child { border-bottom: none; }
.area-info-icon {
  width: 30px; height: 30px; border-radius: 7px;
  background: var(--paper,#FBF6EE);
  border: 1px solid var(--manila-dd,#D6C4A0);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.area-info-icon svg {
  width: 14px; height: 14px;
  stroke: var(--rose,#C07B60); fill: none;
  stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
}
.area-info-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 9.5px; font-weight: 600;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--muted,#8A7560);
}
.area-info-val {
  font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 500;
  color: var(--ink,#2A1F14);
  margin-top: 1px;
}
.area-info-val-price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 17px; font-weight: 600;
  color: var(--rose,#C07B60);
}
.area-info-card-footer { padding: 14px 16px; }

/* CTA tombol */
.area-btn-main {
  display: inline-flex; align-items: center; gap: 9px;
  padding: 13px 24px; background: var(--ink,#2A1F14);
  color: var(--paper,#FBF6EE);
  font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 600;
  letter-spacing: .04em; border-radius: 100px;
  text-decoration: none; border: none; cursor: pointer;
  transition: background .25s, transform .25s, box-shadow .25s;
  box-shadow: 0 4px 14px rgba(42,31,20,.22);
}
.area-btn-main:hover {
  background: var(--ink-l,#5C4A35);
  transform: translateY(-2px);
  box-shadow: 0 8px 22px rgba(42,31,20,.28);
  color: var(--paper,#FBF6EE);
}
.area-btn-sec {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 12px 20px;
  border: 1.5px solid var(--manila-dd,#D6C4A0);
  color: var(--ink-l,#5C4A35);
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 500;
  border-radius: 100px; text-decoration: none;
  background: transparent;
  transition: border-color .2s, color .2s, background .2s, transform .2s;
}
.area-btn-sec:hover {
  border-color: var(--rose,#C07B60);
  color: var(--rose,#C07B60);
  background: rgba(192,123,96,.05);
  transform: translateY(-1px);
}

/* Strip bawah hero */
.area-hero-strip {
  position: absolute; bottom: 0; left: 0; right: 0;
  height: 5px; z-index: 6;
  background: linear-gradient(90deg,
    var(--manila-dd,#D6C4A0),
    var(--rose,#C07B60),
    var(--manila-dd,#D6C4A0)
  );
}

/* ═══════════════════
   TICKER
═══════════════════ */
.area-ticker {
  background: var(--ink,#2A1F14);
  overflow: hidden; padding: 9px 0;
}
.area-ticker-inner {
  display: flex; white-space: nowrap;
  animation: areaTicker 24s linear infinite;
}
.area-ticker-item {
  display: inline-flex; align-items: center; gap: 9px;
  margin: 0 20px;
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 400;
  letter-spacing: .13em; text-transform: uppercase;
  color: rgba(251,246,238,.35);
  text-decoration: none; flex-shrink: 0;
  transition: color .2s;
}
.area-ticker-item:hover { color: var(--rose-l,#DFA98C); }
.area-ticker-item.active { color: var(--rose-l,#DFA98C); }
.area-ticker-dot {
  width: 3px; height: 3px; border-radius: 50%;
  background: var(--rose,#C07B60); opacity: .5; flex-shrink: 0;
}

/* ═══════════════════
   LAYANAN GRID
═══════════════════ */
.area-layanan {
  background: var(--paper,#FBF6EE);
  padding: 64px 0 72px; position: relative;
}
.area-layanan::before {
  content: '';
  position: absolute; inset: 0;
  background-image:
    repeating-linear-gradient(0deg,  transparent 0, transparent 47px, rgba(42,31,20,.035) 47px, rgba(42,31,20,.035) 48px),
    repeating-linear-gradient(90deg, transparent 0, transparent 47px, rgba(42,31,20,.035) 47px, rgba(42,31,20,.035) 48px);
  pointer-events: none;
}
.area-container {
  position: relative; z-index: 1;
  max-width: 1280px; margin: 0 auto; padding: 0 24px;
}

/* Section header */
.area-section-head { margin-bottom: 40px; }
.area-section-eyebrow {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .2em; text-transform: uppercase;
  color: var(--rose,#C07B60); margin-bottom: 10px;
  display: flex; align-items: center; gap: 8px;
}
.area-section-eyebrow::before {
  content: '';
  width: 18px; height: 1px;
  background: var(--rose,#C07B60); opacity: .5;
}
.area-section-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.7rem, 3.2vw, 2.6rem);
  font-weight: 600; color: var(--ink,#2A1F14);
  line-height: 1.2;
}
.area-section-title em {
  font-style: italic; font-weight: 300;
  color: var(--rose,#C07B60);
}

/* Layanan grid 4 kolom */
.area-layanan-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0;
  border: 1px solid var(--manila-dd,#D6C4A0);
  border-radius: 10px; overflow: hidden;
}

/* Panel layanan */
.area-layanan-panel {
  position: relative; overflow: hidden;
  min-height: 280px;
  display: flex; flex-direction: column; justify-content: flex-end;
  text-decoration: none;
  border-right: 1px solid var(--manila-dd,#D6C4A0);
  border-bottom: 1px solid var(--manila-dd,#D6C4A0);
  cursor: pointer;
  background: var(--manila,#F2E8D5);
  transition: background .25s;
}
.area-layanan-panel:nth-child(4n) { border-right: none; }
.area-layanan-panel:hover { background: var(--paper,#FBF6EE); }

/* Foto background panel */
.area-panel-bg {
  position: absolute; inset: 0;
  background-size: cover; background-position: center;
  filter: brightness(.38) saturate(.7);
  transition: filter .5s, transform .6s;
}
.area-layanan-panel:hover .area-panel-bg {
  filter: brightness(.52) saturate(.9);
  transform: scale(1.04);
}

/* Overlay degradasi bawah */
.area-panel-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top,
    rgba(42,31,20,.96) 0%,
    rgba(42,31,20,.7) 40%,
    rgba(42,31,20,.1) 100%
  );
  transition: background .3s;
}
.area-layanan-panel:hover .area-panel-overlay {
  background: linear-gradient(to top,
    rgba(42,31,20,.98) 0%,
    rgba(42,31,20,.8) 50%,
    rgba(42,31,20,.15) 100%
  );
}

/* Nomor pojok */
.area-panel-num {
  position: absolute; top: 14px; right: 14px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 11px; font-weight: 600;
  color: rgba(251,246,238,.2);
  letter-spacing: .1em; z-index: 3;
  transition: color .25s;
}
.area-layanan-panel:hover .area-panel-num { color: rgba(251,246,238,.45); }

/* Konten panel */
.area-panel-body {
  position: relative; z-index: 3;
  padding: 18px 20px 22px;
}
.area-panel-line {
  width: 0; height: 1px;
  background: linear-gradient(90deg, var(--rose,#C07B60), var(--rose-l,#DFA98C));
  margin-bottom: 9px;
  transition: width .4s cubic-bezier(.4,0,.2,1);
}
.area-layanan-panel:hover .area-panel-line { width: 32px; }
.area-panel-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(.95rem, 1.4vw, 1.2rem);
  font-weight: 600; color: var(--paper,#FBF6EE);
  line-height: 1.3; margin-bottom: 6px;
  transition: color .2s;
}
.area-layanan-panel:hover .area-panel-name { color: var(--rose-l,#DFA98C); }
.area-panel-chip {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .1em; text-transform: uppercase;
  color: rgba(251,246,238,.3); margin-bottom: 9px;
  display: flex; align-items: center; gap: 6px;
}
.area-panel-chip::before {
  content: '';
  width: 10px; height: 1px;
  background: var(--rose,#C07B60); opacity: .5;
}
/* Sub items */
.area-panel-subs {
  max-height: 0; overflow: hidden;
  opacity: 0; transform: translateY(6px);
  transition: max-height .45s cubic-bezier(.4,0,.2,1), opacity .3s, transform .3s;
}
.area-layanan-panel:hover .area-panel-subs {
  max-height: 180px; opacity: 1; transform: translateY(0);
}
.area-panel-sub {
  display: flex; align-items: center; gap: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 11.5px; font-weight: 400;
  color: rgba(251,246,238,.4); padding: 2.5px 0;
  text-decoration: none;
  transition: color .15s;
}
.area-panel-sub:hover { color: var(--rose-l,#DFA98C); }
.area-panel-sub::before {
  content: '';
  width: 4px; height: 4px; border-radius: 50%;
  background: var(--rose,#C07B60); opacity: .4; flex-shrink: 0;
}
.area-panel-cta {
  display: inline-flex; align-items: center; gap: 5px;
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 700;
  letter-spacing: .1em; text-transform: uppercase;
  color: var(--ink,#2A1F14);
  background: var(--paper,#FBF6EE);
  border-radius: 4px; padding: 5px 12px;
  text-decoration: none;
  opacity: 0; transform: translateY(5px);
  transition: opacity .25s, transform .25s;
}
.area-layanan-panel:hover .area-panel-cta { opacity: 1; transform: translateY(0); }

/* ═══════════════════
   PRODUK SCROLL
═══════════════════ */
.area-produk {
  background: var(--manila,#F2E8D5);
  padding: 64px 0 80px; position: relative;
}
.area-produk::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.02'/%3E%3C/svg%3E");
  pointer-events: none;
}

/* Separator antar kategori */
.area-section-rule {
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--manila-dd,#D6C4A0), transparent);
  margin: 36px 0;
}
.area-section-rule-diamond {
  position: relative;
}
.area-section-rule-diamond::before {
  content: '';
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%) rotate(45deg);
  width: 6px; height: 6px;
  background: var(--rose,#C07B60); opacity: .4;
}

/* Baris per kategori */
.area-cat-row { margin-bottom: 12px; }
.area-cat-row-head {
  display: flex; align-items: center; gap: 14px;
  margin-bottom: 18px;
}
.area-cat-row-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.1rem, 2vw, 1.45rem);
  font-weight: 600; color: var(--ink,#2A1F14);
  white-space: nowrap;
}
.area-cat-row-line {
  flex: 1; height: 1px;
  background: linear-gradient(90deg, var(--manila-dd,#D6C4A0), transparent);
}
.area-cat-row-count {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--muted,#8A7560); flex-shrink: 0;
}
.area-cat-row-link {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 600;
  letter-spacing: .08em;
  color: var(--rose,#C07B60);
  text-decoration: none; flex-shrink: 0;
  opacity: .7; transition: opacity .2s;
}
.area-cat-row-link:hover { opacity: 1; }

/* Scroll container */
.area-scroll-wrap { position: relative; }
.area-scroll-wrap::before,
.area-scroll-wrap::after {
  content: '';
  position: absolute; top: 0; bottom: 0;
  width: 48px; z-index: 4; pointer-events: none;
}
.area-scroll-wrap::before {
  left: 0;
  background: linear-gradient(90deg, var(--manila,#F2E8D5), transparent);
}
.area-scroll-wrap::after {
  right: 0;
  background: linear-gradient(-90deg, var(--manila,#F2E8D5), transparent);
}
.area-scroll {
  display: flex; gap: 14px;
  overflow-x: auto; padding: 6px 4px 14px;
  scrollbar-width: none; scroll-behavior: smooth;
}
.area-scroll::-webkit-scrollbar { display: none; }

/* Kartu produk — vertikal */
.area-prod-card {
  flex: 0 0 158px;
  height: 300px;
  border-radius: 8px; overflow: hidden;
  background: #fff;
  border: 1px solid var(--manila-dd,#D6C4A0);
  display: flex; flex-direction: column;
  text-decoration: none;
  cursor: pointer;
  transition: transform .3s ease, box-shadow .3s, border-color .3s;
}
.area-prod-card:hover {
  transform: translateY(-7px) rotate(-.6deg);
  box-shadow: 0 16px 40px rgba(42,31,20,.14);
  border-color: rgba(192,123,96,.4);
}
.area-prod-img-wrap {
  position: relative; height: 170px; overflow: hidden;
  background: var(--manila,#F2E8D5); flex-shrink: 0;
}
.area-prod-img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .6s ease;
}
.area-prod-card:hover .area-prod-img { transform: scale(1.06); }
.area-prod-img-ov {
  position: absolute; inset: 0;
  background: linear-gradient(to bottom, transparent 45%, rgba(42,31,20,.55) 100%);
}
.area-prod-cat-badge {
  position: absolute; bottom: 8px; left: 50%;
  transform: translateX(-50%);
  font-family: 'Jost', sans-serif;
  font-size: 9px; font-weight: 700;
  letter-spacing: .09em; text-transform: uppercase;
  color: var(--paper,#FBF6EE);
  background: rgba(42,31,20,.75);
  padding: 3px 9px; border-radius: 3px;
  white-space: nowrap;
  border: 1px solid rgba(251,246,238,.1);
}
.area-prod-body {
  flex: 1; display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 10px 10px 13px; text-align: center;
  border-top: 1px solid var(--manila-dd,#D6C4A0);
}
.area-prod-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 14px; font-weight: 600;
  color: var(--ink,#2A1F14); line-height: 1.4;
  margin-bottom: 6px;
  display: -webkit-box;
  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  overflow: hidden;
}
.area-prod-price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px; font-weight: 600;
  color: var(--rose,#C07B60); margin-bottom: 9px;
}
.area-prod-btn {
  display: flex; align-items: center; gap: 5px;
  font-family: 'Jost', sans-serif;
  font-size: 9.5px; font-weight: 700;
  letter-spacing: .09em; text-transform: uppercase;
  color: var(--paper,#FBF6EE);
  background: var(--ink,#2A1F14);
  border-radius: 5px; padding: 5px 11px;
  text-decoration: none;
  opacity: 0; transform: translateY(4px);
  transition: opacity .25s, transform .25s;
}
.area-prod-card:hover .area-prod-btn { opacity: 1; transform: translateY(0); }

/* Nav tombol scroll */
.area-scroll-nav {
  position: absolute; top: 50%; transform: translateY(-50%);
  z-index: 10; width: 34px; height: 34px; border-radius: 50%;
  border: 1px solid var(--manila-dd,#D6C4A0);
  background: var(--paper,#FBF6EE);
  color: var(--ink-l,#5C4A35);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; transition: background .2s, border-color .2s, transform .2s;
  box-shadow: 0 3px 12px rgba(42,31,20,.1);
}
.area-scroll-nav:hover {
  background: var(--manila,#F2E8D5);
  border-color: var(--rose,#C07B60);
  transform: translateY(-50%) scale(1.06);
}
.area-scroll-nav.snav-l { left: 6px; }
.area-scroll-nav.snav-r { right: 6px; }
.area-scroll-nav.snav-hide { opacity: 0; pointer-events: none; }
.area-scroll-nav svg { width: 13px; height: 13px; stroke-width: 2.5; }

/* Progress track */
.area-progress-track {
  height: 2px; background: var(--manila-dd,#D6C4A0);
  border-radius: 2px; margin-top: 6px; overflow: hidden;
}
.area-progress-bar {
  height: 100%;
  background: linear-gradient(90deg, var(--rose,#C07B60), var(--rose-l,#DFA98C));
  border-radius: 2px; width: 14%;
  transition: width .15s ease;
}

/* ═══════════════════
   FAQ + SIDEBAR
═══════════════════ */
.area-faq-section {
  background: var(--paper,#FBF6EE);
  padding: 64px 0 72px; position: relative;
}
.area-faq-layout {
  display: grid;
  grid-template-columns: 1fr 308px;
  gap: 48px; align-items: start;
}

/* About */
.area-about-box {
  background: var(--manila,#F2E8D5);
  border: 1px solid var(--manila-dd,#D6C4A0);
  border-radius: 10px; padding: 24px;
  margin-bottom: 28px;
}
.area-about-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.4rem, 2.5vw, 2rem);
  font-weight: 600; color: var(--ink,#2A1F14);
  line-height: 1.2; margin-bottom: 14px;
}
.area-about-title em {
  font-style: italic; font-weight: 300;
  color: var(--rose,#C07B60);
}
.area-about-prose {
  font-family: 'Jost', sans-serif;
  font-size: 14.5px; font-weight: 300;
  line-height: 1.85; color: var(--ink-l,#5C4A35);
  margin-bottom: 12px;
}
.area-about-prose strong { color: var(--rose,#C07B60); font-weight: 600; }

/* FAQ accordion */
.area-faq-card {
  border: 1px solid var(--manila-dd,#D6C4A0);
  border-radius: 8px; overflow: hidden;
  margin-bottom: 8px; background: #fff;
  transition: border-color .2s;
}
.area-faq-card.open {
  border-color: rgba(192,123,96,.35);
  background: var(--paper,#FBF6EE);
}
.area-faq-trigger {
  display: flex; align-items: center; gap: 12px;
  padding: 13px 16px; cursor: pointer;
  width: 100%; text-align: left; background: transparent; border: none;
}
.area-faq-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px; font-weight: 600;
  color: var(--rose,#C07B60); opacity: .5;
  flex-shrink: 0; transition: opacity .2s;
  min-width: 24px;
}
.area-faq-card.open .area-faq-num { opacity: 1; }
.area-faq-q {
  flex: 1; font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 500;
  color: var(--ink,#2A1F14); line-height: 1.4;
  text-align: left;
}
.area-faq-chev {
  flex-shrink: 0; color: var(--muted,#8A7560);
  transition: transform .3s cubic-bezier(.4,0,.2,1), color .2s;
}
.area-faq-card.open .area-faq-chev {
  transform: rotate(180deg); color: var(--rose,#C07B60);
}
/* grid-template-rows transition — cara paling ringan */
.area-faq-body {
  display: grid; grid-template-rows: 0fr;
  transition: grid-template-rows .38s ease;
}
.area-faq-body.open { grid-template-rows: 1fr; }
.area-faq-body-inner {
  overflow: hidden;
  padding: 0 16px 0 52px;
}
.area-faq-answer {
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 300;
  line-height: 1.7; color: var(--muted,#8A7560);
  padding: 10px 0 16px;
  border-top: 1px solid var(--manila-dd,#D6C4A0);
}

/* Sidebar */
.area-sidebar { display: flex; flex-direction: column; gap: 14px; position: sticky; top: 96px; }
.area-sidebar-panel {
  background: var(--manila,#F2E8D5);
  border: 1px solid var(--manila-dd,#D6C4A0);
  border-radius: 10px; overflow: hidden;
}
.area-sidebar-head {
  padding: 12px 15px;
  background: var(--ink,#2A1F14);
  display: flex; align-items: center; gap: 8px;
}
.area-sidebar-head-text {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .17em; text-transform: uppercase;
  color: rgba(251,246,238,.45);
}
.area-sidebar-body { padding: 10px; }

/* WA sidebar */
.area-sidebar-wa {
  background: var(--ink,#2A1F14);
  border-radius: 10px; padding: 22px; text-align: center;
}
.area-sidebar-wa-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px; font-weight: 600;
  color: var(--paper,#FBF6EE); margin-bottom: 6px;
}
.area-sidebar-wa-sub {
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 300;
  color: rgba(251,246,238,.38);
  margin-bottom: 16px; line-height: 1.7;
}
.area-sidebar-wa-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  background: var(--paper,#FBF6EE);
  color: var(--ink,#2A1F14);
  font-family: 'Jost', sans-serif;
  font-size: 12.5px; font-weight: 700;
  padding: 10px 16px; border-radius: 100px;
  text-decoration: none; letter-spacing: .04em;
  transition: background .2s, transform .2s;
}
.area-sidebar-wa-btn:hover {
  background: var(--manila,#F2E8D5);
  transform: translateY(-1px);
  color: var(--ink,#2A1F14);
}

/* Area pills */
.area-pill {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 5px 11px; border-radius: 20px;
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 400;
  border: 1px solid var(--manila-dd,#D6C4A0);
  color: var(--ink-l,#5C4A35);
  text-decoration: none;
  background: var(--paper,#FBF6EE);
  transition: all .2s;
}
.area-pill:hover {
  background: var(--ink,#2A1F14);
  color: var(--paper,#FBF6EE);
  border-color: var(--ink,#2A1F14);
  transform: translateY(-1px);
}
.area-pill.active {
  background: var(--rose,#C07B60);
  color: var(--paper,#FBF6EE);
  border-color: var(--rose,#C07B60);
}

/* Sidebar nav link */
.area-snav {
  display: flex; align-items: center; justify-content: space-between;
  padding: 9px 12px; border-radius: 7px;
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 400;
  color: var(--ink-l,#5C4A35);
  text-decoration: none;
  border: 1px solid transparent;
  transition: background .18s, color .18s, padding-left .18s;
  margin-bottom: 2px;
}
.area-snav:hover {
  color: var(--rose,#C07B60);
  background: rgba(192,123,96,.07);
  border-color: rgba(192,123,96,.14);
  padding-left: 16px;
}
/* Sidebar accordion */
.area-sacc-btn {
  display: flex; align-items: center; justify-content: space-between;
  width: 100%; text-align: left;
  padding: 9px 12px; border-radius: 7px;
  background: transparent; border: 1px solid transparent;
  cursor: pointer;
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 400;
  color: var(--ink-l,#5C4A35);
  transition: background .18s, color .18s;
  margin-bottom: 2px;
}
.area-sacc-btn:hover, .area-sacc-btn.open {
  color: var(--rose,#C07B60);
  background: rgba(192,123,96,.07);
}
.area-sacc-chev { transition: transform .3s; }
.area-sacc-btn.open .area-sacc-chev { transform: rotate(180deg); }
.area-sacc-body {
  max-height: 0; overflow: hidden;
  transition: max-height .35s ease;
  padding-left: 10px;
  border-left: 2px solid rgba(192,123,96,.2);
  margin: 0 0 4px 12px;
}
.area-sacc-body.open { max-height: 400px; }

/* ─── RESPONSIVE ─── */

/* Tablet */
@media (max-width: 1023px) {
  .area-layanan-grid { grid-template-columns: repeat(2, 1fr); }
  .area-faq-layout { grid-template-columns: 1fr; }
  .area-sidebar { display: none; }
  .area-hero-grid {
    grid-template-columns: 1fr !important;
  }
  .area-hero-info-card {
    display: none !important;
  }
}

/* Mobile */
@media (max-width: 600px) {
  .area-layanan-grid { grid-template-columns: 1fr 1fr; }
  .area-hero { padding-top: 80px; }
  .area-hero-img { display: none; }
  .area-hero-grid {
    grid-template-columns: 1fr !important;
    gap: 20px !important;
  }
  .area-hero-info-card {
    display: none !important;
  }
  .area-stats {
    gap: 8px;
  }
  .area-stat {
    min-width: 72px;
    padding: 10px 10px;
  }
  .area-stat-val {
    font-size: 22px;
  }
  .area-hero-inner {
    padding: 0 16px 64px;
  }
}
/* Css Huruf Konten */
/* Konten SEO — heading styles */
.area-content h1 { font-family:'Cormorant Garamond',serif; font-size:1.9rem; font-weight:600; color:var(--ink,#2A1F14); margin-bottom:1rem; margin-top:1.5rem; line-height:1.2; }
.area-content h2 { font-family:'Cormorant Garamond',serif; font-size:1.45rem; font-weight:600; color:var(--ink,#2A1F14); margin-bottom:0.75rem; margin-top:1.25rem; line-height:1.3; }
.area-content h3 { font-family:'Cormorant Garamond',serif; font-size:1.15rem; font-weight:600; color:var(--rose,#C07B60); margin-bottom:0.5rem; margin-top:1rem; }
.area-content p  { margin-bottom:0.75rem; }
.area-content ul { list-style:disc; padding-left:1.5rem; margin-bottom:0.75rem; }
.area-content ol { list-style:decimal; padding-left:1.5rem; margin-bottom:0.75rem; }
.area-content li { margin-bottom:0.25rem; }
.area-content strong { color:var(--rose,#C07B60); font-weight:600; }
.area-content a  { color:var(--rose,#C07B60); text-decoration:underline; }


</style>

<!-- ─── KELOPAK JATUH ─── -->
<div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:9998;" aria-hidden="true">
<?php
$petal_colors = ['#C07B60','#DFA98C','#D6C4A0','#E8D9BF','#FBF6EE'];
for ($i = 0; $i < 8; $i++):
  $col  = $petal_colors[$i % count($petal_colors)];
  $left = rand(2, 97); $del = rand(0, 18); $dur = rand(14, 24); $sz = rand(7, 12);
?>
<div class="area-petal" style="
  left:<?= $left ?>%; top:0;
  width:<?= $sz ?>px; height:<?= round($sz*1.4) ?>px;
  background:<?= $col ?>; opacity:.3;
  animation-duration:<?= $dur ?>s; animation-delay:-<?= $del ?>s;
"></div>
<?php endfor; ?>
</div>

<!-- ═══════════════════════════════════
     HERO
═══════════════════════════════════ -->
<section class="area-hero">

  <?php if (!empty($location['image'])): ?>
  <div class="area-hero-img">
    <div class="area-hero-img-bg" style="background-image:url('<?= e(imgUrl($location['image'],'location')) ?>');"></div>
    <div class="area-hero-img-fade"></div>
    <div class="area-hero-img-border"></div>
  </div>
  <?php endif; ?>

  <!-- Ornamen bunga SVG -->
  <svg class="area-hero-floral" viewBox="0 0 360 360" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="300" cy="60" r="110" stroke="#C07B60" stroke-width="1"/>
    <circle cx="300" cy="60" r="72"  stroke="#DFA98C" stroke-width="1"/>
    <circle cx="300" cy="60" r="36"  fill="rgba(192,123,96,.15)"/>
    <ellipse cx="300" cy="6"  rx="15" ry="54" fill="rgba(192,123,96,.18)" transform="rotate(0 300 60)"/>
    <ellipse cx="300" cy="6"  rx="15" ry="54" fill="rgba(192,123,96,.18)" transform="rotate(60 300 60)"/>
    <ellipse cx="300" cy="6"  rx="15" ry="54" fill="rgba(192,123,96,.12)" transform="rotate(120 300 60)"/>
    <circle cx="360" cy="130" r="75"  stroke="#D6C4A0" stroke-width="1"/>
  </svg>

  <div class="area-hero-inner">

    <!-- Breadcrumb -->
    <nav class="area-breadcrumb area-rv1">
      <a href="<?= BASE_URL ?>/">Beranda</a>
      <span class="area-breadcrumb-sep">›</span>
      <span class="area-breadcrumb-cur"><?= e($location['name']) ?></span>
    </nav>

    <div class="area-hero-grid" style="display:grid;grid-template-columns:1fr auto;gap:32px;align-items:start;max-width:1100px;">

      <!-- Kiri -->
      <div style="max-width:560px;">

        <div class="area-badge area-rv1">
          <div class="area-badge-dot"></div>
          <span class="area-badge-text">Toko Bunga · <?= e($location['name']) ?></span>
        </div>

        <h1 class="area-h1 area-rv2">
          Toko Bunga<br><?= e($location['name']) ?>
        </h1>
        <p class="area-tagline area-rv2">Florist Terpercaya, Pengiriman Cepat</p>

        <p class="area-desc area-rv3">
          <?= !empty($location['meta_description'])
            ? e($location['meta_description'])
            : 'Florist '.e($location['name']).' terpercaya menyediakan karangan bunga papan, hand bouquet, wedding &amp; duka cita. Pengiriman 2–4 jam ke '.e($location['name']).' dan seluruh Jakarta Pusat.' ?>
        </p>

        <div class="area-stats area-rv3">
          <div class="area-stat">
            <div class="area-stat-lbl">Pengalaman</div>
            <div class="area-stat-val">10<span>+</span></div>
            <div class="area-stat-sub">Tahun</div>
          </div>
          <div class="area-stat">
            <div class="area-stat-lbl">Pengiriman</div>
            <div class="area-stat-val" style="color:var(--ink,#2A1F14);">2–4<span>Jam</span></div>
            <div class="area-stat-sub">Same Day</div>
          </div>
          <div class="area-stat">
            <div class="area-stat-lbl">Mulai dari</div>
            <div class="area-stat-val" style="font-size:17px;color:var(--muted,#8A7560);"><?= 'Rp '.number_format($min_price/1000,0,',','.').'rb' ?></div>
            <div class="area-stat-sub">Harga terbaik</div>
          </div>
        </div>

        <div style="display:flex;gap:12px;flex-wrap:wrap;" class="area-rv4">
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan bunga di '.$location['name'].', Jakarta Pusat.') ?>"
             target="_blank" rel="noopener" class="area-btn-main">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Pesan Sekarang
          </a>
          <a href="tel:<?= e(setting('whatsapp_number')) ?>" class="area-btn-sec">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
            <?= e(setting('phone_display')) ?>
          </a>
        </div>

      </div>

      <!-- Kanan: Info card -->
      <div class="area-rv4 area-hero-info-card" style="width:260px;flex-shrink:0;">
        <div class="area-info-card">
          <div class="area-info-card-head">
            <div class="area-info-card-head-sub">Info Pengiriman</div>
            <div class="area-info-card-head-title"><?= e($location['name']) ?></div>
          </div>
          <div class="area-info-row">
            <div class="area-info-icon">
              <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/></svg>
            </div>
            <div>
              <div class="area-info-lbl">Lokasi</div>
              <div class="area-info-val"><?= e($location['name']) ?>, Jakarta Pusat</div>
            </div>
          </div>
          <div class="area-info-row">
            <div class="area-info-icon">
              <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            </div>
            <div>
              <div class="area-info-lbl">Estimasi Pengiriman</div>
              <div class="area-info-val">2–4 Jam</div>
            </div>
          </div>
          <div class="area-info-row">
            <div class="area-info-icon">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
              <div class="area-info-lbl">Operasional</div>
              <div class="area-info-val"><?= e(setting('jam_buka')) ?></div>
            </div>
          </div>
          <div class="area-info-row">
            <div class="area-info-icon">
              <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
              <div class="area-info-lbl">Mulai dari</div>
              <div class="area-info-val-price"><?= rupiah($min_price) ?></div>
            </div>
          </div>
          <div class="area-info-card-footer">
            <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener"
               class="area-btn-main" style="width:100%;justify-content:center;">
              <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
              Chat WhatsApp
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="area-hero-strip" aria-hidden="true"></div>
</section>

<!-- ─── TICKER ─── -->
<div class="area-ticker" aria-label="Area pengiriman">
  <div class="area-ticker-inner" aria-hidden="true">
    <?php for ($r = 0; $r < 2; $r++): foreach ($locations as $l): ?>
    <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/"
       class="area-ticker-item <?= $l['id'] == $location['id'] ? 'active' : '' ?>">
      <span class="area-ticker-dot"></span>
      <?= e($l['name']) ?>
    </a>
    <?php endforeach; endfor; ?>
  </div>
</div>

<!-- ═══════════════════════════════════
     SECTION: LAYANAN
═══════════════════════════════════ -->
<section class="area-layanan">
  <div class="area-container">

    <div class="area-section-head">
      <div class="area-section-eyebrow">Tersedia di <?= e($location['name']) ?></div>
      <h2 class="area-section-title">
        Layanan Bunga
        <em> — Semua Tersedia</em>
      </h2>
    </div>

    <div class="area-layanan-grid">
      <?php foreach ($all_cats as $i => $cat):
        $subs    = $all_cats_subs[$cat['id']] ?? [];
        $has_sub = !empty($subs);
        $cat_url = BASE_URL . '/' . e($cat['slug']) . '/';
        $has_img = !empty($cat['image']);
        $panel_n = $i + 1;
      ?>
      <div class="area-layanan-panel"
           <?= !$has_sub ? 'onclick="location.href=\''.$cat_url.'\'"' : '' ?>>

        <?php if ($has_img): ?>
        <div class="area-panel-bg" style="background-image:url('<?= e(imgUrl($cat['image'],'category')) ?>');"></div>
        <?php else: ?>
        <div class="area-panel-bg" style="background:linear-gradient(160deg, var(--manila-dd,#D6C4A0), var(--manila,#F2E8D5));"></div>
        <?php endif; ?>
        <div class="area-panel-overlay"></div>

        <div class="area-panel-num"><?= str_pad($panel_n, 2, '0', STR_PAD_LEFT) ?></div>

        <div class="area-panel-body">
          <div class="area-panel-line"></div>
          <div class="area-panel-chip">
            <?= $has_sub ? count($subs).' Sub Layanan' : 'Lihat Produk' ?>
          </div>
          <div class="area-panel-name"><?= e($cat['name']) ?></div>

          <?php if ($has_sub): ?>
          <div class="area-panel-subs">
            <a href="<?= $cat_url ?>" class="area-panel-sub"
               style="color:rgba(223,169,140,.55);font-weight:600;"
               onclick="event.stopPropagation()">
              Semua <?= e($cat['name']) ?> ›
            </a>
            <?php foreach (array_slice($subs, 0, 4) as $sub): ?>
            <a href="<?= BASE_URL ?>/<?= e($sub['slug']) ?>/"
               class="area-panel-sub"
               onclick="event.stopPropagation()">
              <?= e($sub['name']) ?>
            </a>
            <?php endforeach; ?>
            <?php if (count($subs) > 4): ?>
            <span class="area-panel-sub" style="color:rgba(251,246,238,.2);font-style:italic;">
              +<?= count($subs) - 4 ?> lainnya
            </span>
            <?php endif; ?>
          </div>
          <?php else: ?>
          <div class="area-panel-subs">
            <?php if (!empty($cat['description'])): ?>
            <p style="font-family:'Jost',sans-serif;font-size:11px;font-weight:300;line-height:1.5;color:rgba(251,246,238,.3);margin-bottom:9px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
              <?= e($cat['description']) ?>
            </p>
            <?php endif; ?>
            <a href="<?= $cat_url ?>" class="area-panel-cta" onclick="event.stopPropagation()">
              Lihat Produk ›
            </a>
          </div>
          <?php endif; ?>
        </div>

      </div>
      <?php endforeach; ?>

      <?php
      /* Phantom panels — isi grid jika tidak penuh 4 kolom */
      $remainder = count($all_cats) % 4;
      if ($remainder > 0):
        for ($ph = 0; $ph < (4 - $remainder); $ph++): ?>
      <div style="min-height:280px;background:var(--manila,#F2E8D5);border-right:none;border-bottom:none;pointer-events:none;visibility:hidden;"></div>
      <?php endfor; endif; ?>
    </div>

  </div>
</section>

<!-- ═══════════════════════════════════
     SECTION: PRODUK SCROLL
═══════════════════════════════════ -->
<section id="produk" class="area-produk">
  <div class="area-container">

    <div class="area-section-head">
      <div class="area-section-eyebrow">Koleksi Bunga</div>
      <h2 class="area-section-title">
        Pilihan untuk
        <em> <?= e($location['name']) ?></em>
      </h2>
    </div>

    <?php foreach ($cats_with_products as $ri => $row):
      $cat   = $row['cat'];
      $prods = $row['products'];
      $sid   = 'ascroll-' . $cat['id'];
    ?>
    <div class="area-cat-row">
      <div class="area-cat-row-head">
        <h3 class="area-cat-row-title"><?= e($cat['name']) ?></h3>
        <div class="area-cat-row-line"></div>
        <span class="area-cat-row-count"><?= count($prods) ?> produk</span>
        <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/" class="area-cat-row-link" rel="noopener">
          Lihat Semua ›
        </a>
      </div>

      <div class="area-scroll-wrap">
        <button class="area-scroll-nav snav-l snav-hide" onclick="areaSnavClick('<?= $sid ?>',this,-1)" aria-label="Scroll kiri">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button class="area-scroll-nav snav-r" onclick="areaSnavClick('<?= $sid ?>',this,1)" aria-label="Scroll kanan">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>

        <div id="<?= $sid ?>" class="area-scroll"
             onscroll="areaScrollEvt(this,'<?= $sid ?>-bar')">
          <?php foreach ($prods as $prod):
            $img   = imgUrl($prod['image'], 'product');
            $wamsg = urlencode("Halo, saya tertarik memesan *{$prod['name']}* untuk dikirim ke {$location['name']}. Apakah tersedia?");
          ?>
          <a href="<?= e($wa_url) ?>?text=<?= $wamsg ?>"
             target="_blank" rel="noopener" class="area-prod-card">
            <div class="area-prod-img-wrap">
              <img src="<?= e($img) ?>" alt="<?= e($prod['name']) ?> <?= e($location['name']) ?>"
                   class="area-prod-img" loading="lazy">
              <div class="area-prod-img-ov"></div>
              <div class="area-prod-cat-badge"><?= e($cat['name']) ?></div>
            </div>
            <div class="area-prod-body">
              <div class="area-prod-name"><?= e($prod['name']) ?></div>
              <div class="area-prod-price"><?= rupiah($prod['price']) ?></div>
              <div class="area-prod-btn">
                <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                Pesan WA
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>

        <div class="area-progress-track">
          <div id="<?= $sid ?>-bar" class="area-progress-bar"></div>
        </div>
      </div>
    </div>

    <?php if ($ri < count($cats_with_products) - 1): ?>
    <div class="area-section-rule area-section-rule-diamond"></div>
    <?php endif; ?>

    <?php endforeach; ?>

  </div>
</section>

<!-- ═══════════════════════════════════
     SECTION: FAQ + SIDEBAR
═══════════════════════════════════ -->
<section class="area-faq-section">
  <div class="area-container">
    <div class="area-faq-layout">

      <!-- KIRI: About + FAQ -->
      <div>

        <!-- About -->
        <div class="area-section-eyebrow" style="margin-bottom:14px;">Tentang Toko</div>
        <div class="area-about-box">
          <h2 class="area-about-title">
            Toko Bunga <?= e($location['name']) ?>
            <em> — Terpercaya &amp; Berpengalaman</em>
          </h2>
          <?php if (!empty($location['content'])): ?>
          <div class="area-about-prose area-content"><?= $location['content'] ?></div>
          <?php endif; ?>
          <p class="area-about-prose">
            Sebagai <strong>toko bunga <?= e(strtolower($location['name'])) ?></strong> yang telah melayani lebih dari 10 tahun, kami memahami setiap momen memerlukan rangkaian bunga yang tepat. Tim florist profesional siap membantu 24 jam setiap hari untuk pengiriman ke <?= e($location['name']) ?> dan seluruh Jakarta Pusat.
          </p>
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan bunga di '.$location['name'].'.') ?>"
             target="_blank" rel="noopener" class="area-btn-main" style="display:inline-flex;margin-top:4px;">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Pesan via WhatsApp
          </a>
        </div>

        <!-- FAQ -->
        <?php if (!empty($faqs)): ?>
        <div class="area-section-eyebrow" style="margin-bottom:14px;">Pertanyaan Umum</div>
        <?php foreach ($faqs as $fi => $faq): ?>
        <div class="area-faq-card <?= $fi === 0 ? 'open' : '' ?>">
          <button class="area-faq-trigger" onclick="areaFaqToggle(this.closest('.area-faq-card'))">
            <span class="area-faq-num"><?= str_pad($fi + 1, 2, '0', STR_PAD_LEFT) ?></span>
            <span class="area-faq-q"><?= e($faq['question']) ?></span>
            <svg class="area-faq-chev" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div class="area-faq-body <?= $fi === 0 ? 'open' : '' ?>">
            <div class="area-faq-body-inner">
              <p class="area-faq-answer"><?= e($faq['answer']) ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

      </div>

      <!-- KANAN: Sidebar -->
      <div class="area-sidebar">

        <!-- WA CTA -->
        <div class="area-sidebar-wa">
          <div class="area-sidebar-wa-title">Pesan Sekarang</div>
          <p class="area-sidebar-wa-sub">Respon cepat · 24 jam · Pengiriman ke <?= e($location['name']) ?></p>
          <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener" class="area-sidebar-wa-btn">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Chat WhatsApp
          </a>
        </div>

        <!-- Info toko -->
        <div class="area-sidebar-panel">
          <div class="area-sidebar-head">
            <svg width="13" height="13" fill="none" stroke="rgba(251,246,238,.45)" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
            <span class="area-sidebar-head-text">Info Toko</span>
          </div>
          <div class="area-sidebar-body" style="padding:12px 14px;">
            <?php $toko_info = [
              ['jam_buka',      setting('jam_buka'),                 'Jam Buka'],
              ['phone_display', setting('phone_display'),            'Telepon'],
              ['address',       setting('address'),                  'Alamat'],
            ]; ?>
            <?php foreach ($toko_info as [$key, $val, $lbl]):
              if (empty($val)) continue; ?>
            <div style="padding:8px 0;border-bottom:1px solid var(--manila-dd,#D6C4A0);">
              <div style="font-family:'Jost',sans-serif;font-size:9.5px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--muted,#8A7560);margin-bottom:2px;"><?= $lbl ?></div>
              <div style="font-family:'Jost',sans-serif;font-size:13px;font-weight:400;color:var(--ink,#2A1F14);"><?= e($val) ?></div>
            </div>
            <?php endforeach; ?>
            <div style="padding:8px 0;">
              <div style="font-family:'Jost',sans-serif;font-size:9.5px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:var(--muted,#8A7560);margin-bottom:2px;">Mulai dari</div>
              <div style="font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:600;color:var(--rose,#C07B60);"><?= rupiah($min_price) ?></div>
            </div>
          </div>
        </div>

      <!-- Area lain -->
<div class="area-sidebar-panel">
  <div class="area-sidebar-head">
    <svg width="13" height="13" fill="none" stroke="rgba(251,246,238,.45)" stroke-width="2" viewBox="0 0 24 24"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
    <span class="area-sidebar-head-text">Area Lainnya</span>
  </div>
  <div class="area-sidebar-body" style="padding:12px;">

    <!-- Halaman-halaman area -->
    <?php for ($p = 0; $p < $slider_pages; $p++): ?>
    <div id="jpAreaPage<?= $p ?>"
         style="display:<?= $p === $slider_active_page ? 'grid' : 'none' ?>;
                grid-template-columns: repeat(2, 1fr);
                gap:6px; min-height:60px;">
      <?php
      $slice = array_slice($locations, $p * $slider_per_page, $slider_per_page);
      foreach ($slice as $l):
        $is_active = $l['id'] == $location['id'];
      ?>
      <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/"
         class="area-pill <?= $is_active ? 'active' : '' ?>"
         style="overflow:hidden; min-width:0; justify-content:flex-start;">
        <span style="width:4px;height:4px;border-radius:50%;flex-shrink:0;display:inline-block;
              background:<?= $is_active ? 'var(--paper,#FBF6EE)' : 'rgba(192,123,96,.35)' ?>;"></span>
        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;min-width:0;">
          <?= e($l['name']) ?>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endfor; ?>

    <!-- Navigasi -->
    <?php if ($slider_pages > 1): ?>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:12px;padding-top:10px;border-top:1px solid var(--manila-dd,#D6C4A0);">
      <button id="jpAreaPrev" onclick="jpAreaSlider(-1)"
              style="font-size:11px;padding:4px 11px;border-radius:7px;
                     border:1px solid var(--manila-dd,#D6C4A0);
                     background:var(--paper,#FBF6EE);
                     color:var(--ink-l,#5C4A35);cursor:pointer;">
        ‹ Prev
      </button>

      <div style="display:flex;gap:4px;align-items:center;">
        <?php for ($p = 0; $p < $slider_pages; $p++): ?>
        <span id="jpAreaDot<?= $p ?>" onclick="jpAreaGoPage(<?= $p ?>)"
              style="display:inline-block;height:5px;border-radius:3px;cursor:pointer;transition:all .2s;
                     width:<?= $p === $slider_active_page ? '16px' : '5px' ?>;
                     background:<?= $p === $slider_active_page ? 'var(--rose,#C07B60)' : 'var(--manila-dd,#D6C4A0)' ?>;"></span>
        <?php endfor; ?>
      </div>

      <button id="jpAreaNext" onclick="jpAreaSlider(1)"
              style="font-size:11px;padding:4px 11px;border-radius:7px;
                     border:1px solid var(--manila-dd,#D6C4A0);
                     background:var(--paper,#FBF6EE);
                     color:var(--ink-l,#5C4A35);cursor:pointer;">
        Next ›
      </button>
    </div>
    <p id="jpAreaInfo" style="text-align:center;font-size:11px;color:var(--muted,#8A7560);margin-top:5px;"></p>
    <?php endif; ?>

  </div>
</div>

        <!-- Layanan accordion -->
        <div class="area-sidebar-panel">
          <div class="area-sidebar-head">
            <svg width="13" height="13" fill="none" stroke="rgba(251,246,238,.45)" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            <span class="area-sidebar-head-text">Layanan Kami</span>
          </div>
          <div class="area-sidebar-body">
            <?php foreach ($all_cats as $c):
              $c_subs  = $all_cats_subs[$c['id']] ?? [];
              $has_sub = !empty($c_subs);
            ?>
            <?php if ($has_sub): ?>
            <button onclick="areaSaccToggle(this)" class="area-sacc-btn">
              <span><?= e($c['name']) ?></span>
              <svg class="area-sacc-chev" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div class="area-sacc-body">
              <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/"
                 style="display:block;padding:4px 10px;font-family:'Jost',sans-serif;font-size:11px;font-weight:600;color:var(--rose,#C07B60);text-decoration:none;">
                Lihat semua ›
              </a>
              <?php foreach ($c_subs as $sub): ?>
              <a href="<?= BASE_URL ?>/<?= e($sub['slug']) ?>/" class="area-snav" style="font-size:12.5px;">
                <?= e($sub['name']) ?>
                <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
              </a>
              <?php endforeach; ?>
            </div>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" class="area-snav">
              <?= e($c['name']) ?>
              <svg width="9" height="9" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
/* ── FAQ toggle ── */
function areaFaqToggle(card) {
  const body   = card.querySelector('.area-faq-body');
  const isOpen = card.classList.contains('open');
  document.querySelectorAll('.area-faq-card.open').forEach(c => {
    c.classList.remove('open');
    c.querySelector('.area-faq-body').classList.remove('open');
  });
  if (!isOpen) { card.classList.add('open'); body.classList.add('open'); }
}

/* ── Sidebar accordion ── */
function areaSaccToggle(btn) {
  const body   = btn.nextElementSibling;
  const isOpen = body.classList.contains('open');
  document.querySelectorAll('.area-sacc-body.open').forEach(el => el.classList.remove('open'));
  document.querySelectorAll('.area-sacc-btn.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) { btn.classList.add('open'); body.classList.add('open'); }
}

/* ── Scroll navigation ── */
function areaSnavClick(sid, btn, dir) {
  const el = document.getElementById(sid);
  if (!el) return;
  el.scrollBy({ left: dir * 520, behavior: 'smooth' });
  setTimeout(() => areaScrollEvt(el, sid + '-bar'), 340);
}
function areaScrollEvt(el, barId) {
  const bar  = document.getElementById(barId);
  const maxS = el.scrollWidth - el.clientWidth;
  if (bar) bar.style.width = (maxS > 0 ? (el.scrollLeft / maxS) * 72 + 14 : 14) + '%';
  const wrap = el.closest('.area-scroll-wrap');
  if (!wrap) return;
  const nl = wrap.querySelector('.snav-l');
  const nr = wrap.querySelector('.snav-r');
  if (nl) nl.classList.toggle('snav-hide', el.scrollLeft < 20);
  if (nr) nr.classList.toggle('snav-hide', el.scrollLeft >= maxS - 20);
}
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.area-scroll').forEach(el => areaScrollEvt(el, el.id + '-bar'));
});
/* ── Area slider ── */
(function() {
  var perPage = <?= $slider_per_page ?>;
  var total   = <?= $slider_total ?>;
  var pages   = <?= $slider_pages ?>;
  var cur     = <?= $slider_active_page ?>;

  function update() {
    for (var i = 0; i < pages; i++) {
      var el = document.getElementById('jpAreaPage' + i);
      if (el) el.style.display = (i === cur) ? 'grid' : 'none';
    }
    for (var i = 0; i < pages; i++) {
      var dot = document.getElementById('jpAreaDot' + i);
      if (!dot) continue;
      dot.style.width      = (i === cur) ? '16px' : '5px';
      dot.style.background = (i === cur) ? 'var(--rose,#C07B60)' : 'var(--manila-dd,#D6C4A0)';
    }
    var prev = document.getElementById('jpAreaPrev');
    var next = document.getElementById('jpAreaNext');
    if (prev) {
      prev.disabled      = (cur === 0);
      prev.style.opacity = (cur === 0) ? '0.35' : '1';
      prev.style.cursor  = (cur === 0) ? 'not-allowed' : 'pointer';
      prev.onmouseenter  = function() { if (!prev.disabled) { prev.style.background='var(--manila,#F2E8D5)'; prev.style.borderColor='var(--rose,#C07B60)'; prev.style.color='var(--rose,#C07B60)'; }};
      prev.onmouseleave  = function() { prev.style.background='var(--paper,#FBF6EE)'; prev.style.borderColor='var(--manila-dd,#D6C4A0)'; prev.style.color='var(--ink-l,#5C4A35)'; };
    }
    if (next) {
      next.disabled      = (cur === pages - 1);
      next.style.opacity = (cur === pages - 1) ? '0.35' : '1';
      next.style.cursor  = (cur === pages - 1) ? 'not-allowed' : 'pointer';
      next.onmouseenter  = function() { if (!next.disabled) { next.style.background='var(--manila,#F2E8D5)'; next.style.borderColor='var(--rose,#C07B60)'; next.style.color='var(--rose,#C07B60)'; }};
      next.onmouseleave  = function() { next.style.background='var(--paper,#FBF6EE)'; next.style.borderColor='var(--manila-dd,#D6C4A0)'; next.style.color='var(--ink-l,#5C4A35)'; };
    }
    var info = document.getElementById('jpAreaInfo');
    if (info) {
      var start = cur * perPage + 1;
      var end   = Math.min((cur + 1) * perPage, total);
      info.textContent = start + '–' + end + ' dari ' + total + ' area';
    }
  }

  window.jpAreaSlider  = function(dir) { cur = Math.max(0, Math.min(pages - 1, cur + dir)); update(); };
  window.jpAreaGoPage  = function(p)   { cur = p; update(); };

  update();
})();
</script>


<?php require __DIR__ . '/../includes/footer.php'; ?>