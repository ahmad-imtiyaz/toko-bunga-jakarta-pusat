<?php
require_once __DIR__ . '/../includes/config.php';

$meta_title    = $category['meta_title']    ?: 'Toko Bunga Jakarta Pusat - ' . $category['name'];
$meta_desc     = $category['meta_description'] ?: '';
$meta_keywords = $category['name'] . ', toko bunga Jakarta Pusat, florist Jakarta Pusat';

$stmt = db()->prepare("SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? AND p.status='active' ORDER BY p.id");
$stmt->execute([$category['id']]);
$products = $stmt->fetchAll();

$all_cats_raw = db()->query("SELECT * FROM categories WHERE status='active' ORDER BY urutan ASC, id ASC")->fetchAll();
$all_cats = []; $all_cats_subs = [];
foreach ($all_cats_raw as $ac) {
    $pid = $ac['parent_id'] ?? null;
    if ($pid === null || $pid == 0) $all_cats[] = $ac;
    else $all_cats_subs[$pid][] = $ac;
}
$locations     = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url        = setting('whatsapp_url');
$product_count = count($products);
$min_price     = !empty($products) ? min(array_column($products, 'price')) : 300000;

require __DIR__ . '/../includes/header.php';
?>

<style>
/* ─── CATEGORY PAGE — Manila Bunga Kertas ─── */

/* Animasi ringan */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes ctgPetalDrift {
  0%   { transform: translateY(-10px) rotate(0deg)   translateX(0);   opacity: 0; }
  8%   { opacity: .4; }
  90%  { opacity: .25; }
  100% { transform: translateY(110vh) rotate(540deg) translateX(40px); opacity: 0; }
}
@keyframes ctgTickerRoll {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
@keyframes ctgPulseRing {
  0%   { transform: scale(1);   opacity: .6; }
  100% { transform: scale(2);   opacity: 0; }
}

.ctg-reveal      { animation: fadeUp .55s ease both; }
.ctg-rv1         { animation-delay: .05s; }
.ctg-rv2         { animation-delay: .15s; }
.ctg-rv3         { animation-delay: .28s; }
.ctg-rv4         { animation-delay: .42s; }

/* ─── HERO ─── */
.ctg-hero {
  position: relative;
  min-height: 520px;
  background: var(--paper, #FBF6EE);
  overflow: hidden;
  padding-top: 88px;
}

/* Grain texture static */
.ctg-hero::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.028'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 0;
}

/* Warm accent glow */
.ctg-hero::after {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 70% 80% at 100% 50%, rgba(242,232,213,.7) 0%, transparent 60%),
    radial-gradient(ellipse 40% 60% at 0% 100%,  rgba(192,123,96,.08) 0%, transparent 60%);
  pointer-events: none; z-index: 0;
}

/* Foto kategori — kanan */
.ctg-hero-img {
  position: absolute;
  right: 0; top: 0; bottom: 0;
  width: 44%;
  z-index: 1;
}
.ctg-hero-img-bg {
  position: absolute; inset: 0;
  background-size: cover;
  background-position: center;
}
.ctg-hero-img-fade {
  position: absolute; inset: 0;
  background: linear-gradient(90deg,
    var(--paper, #FBF6EE) 0%,
    rgba(251,246,238,.75) 25%,
    rgba(251,246,238,.2) 60%,
    rgba(251,246,238,.05) 100%
  );
}
.ctg-hero-img-accent {
  position: absolute; right: 0; top: 0; bottom: 0;
  width: 3px;
  background: linear-gradient(180deg, var(--manila-dd,#D6C4A0), var(--rose,#C07B60), var(--manila-dd,#D6C4A0));
}

/* Ornamen corner bunga SVG */
.ctg-hero-floral {
  position: absolute;
  pointer-events: none; z-index: 0;
  right: 0; top: 0;
  width: 380px; opacity: .06;
}

/* Kelopak jatuh — CSS only */
.ctg-petal {
  position: fixed;
  pointer-events: none; z-index: 9998;
  border-radius: 80% 20% 80% 20% / 60% 60% 40% 40%;
  animation: ctgPetalDrift linear infinite;
}

/* ─── HERO CONTENT ─── */
.ctg-hero-inner {
  position: relative; z-index: 5;
  max-width: 1280px; margin: 0 auto;
  padding: 0 24px 88px;
}

/* Breadcrumb */
.ctg-breadcrumb {
  display: flex; align-items: center; gap: 8px;
  margin-bottom: 36px;
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 400;
  letter-spacing: .12em; text-transform: uppercase;
}
.ctg-breadcrumb a {
  color: var(--muted, #8A7560);
  text-decoration: none;
  transition: color .2s;
}
.ctg-breadcrumb a:hover { color: var(--rose, #C07B60); }
.ctg-breadcrumb-sep { color: var(--rose-l, #DFA98C); font-size: 14px; }
.ctg-breadcrumb-cur { color: var(--rose, #C07B60); }

/* Badge */
.ctg-badge {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 5px 14px 5px 10px;
  background: var(--manila, #F2E8D5);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-left: 3px solid var(--rose, #C07B60);
  border-radius: 3px;
  margin-bottom: 16px;
}
.ctg-badge-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--rose, #C07B60);
  position: relative;
}
.ctg-badge-dot::after {
  content: '';
  position: absolute; inset: -3px; border-radius: 50%;
  border: 1px solid var(--rose, #C07B60);
  animation: ctgPulseRing 2s ease-out infinite;
}
.ctg-badge-text {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--rose, #C07B60);
}

/* Judul */
.ctg-h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.4rem, 5vw, 3.8rem);
  font-weight: 600;
  color: var(--ink, #2A1F14);
  line-height: 1.1;
  letter-spacing: -.01em;
  margin-bottom: 8px;
}
.ctg-tagline {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; font-weight: 300;
  font-size: clamp(1.05rem, 2vw, 1.3rem);
  color: var(--rose, #C07B60);
  margin-bottom: 20px;
  letter-spacing: .03em;
}

/* Deskripsi */
.ctg-desc {
  font-family: 'Jost', sans-serif;
  font-size: 15px; font-weight: 300;
  line-height: 1.85;
  color: var(--ink-l, #5C4A35);
  max-width: 480px;
  margin-bottom: 28px;
  opacity: .8;
}

/* Stat cards */
.ctg-stats { display: flex; gap: 10px; margin-bottom: 28px; flex-wrap: wrap; }
.ctg-stat {
  flex: 1; min-width: 90px;
  background: #fff;
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 8px;
  padding: 14px 16px;
  text-align: center;
  transition: transform .25s ease, box-shadow .25s ease;
}
.ctg-stat:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(42,31,20,.1);
}
.ctg-stat-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 9px; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--muted, #8A7560);
  margin-bottom: 5px;
}
.ctg-stat-val {
  font-family: 'Cormorant Garamond', serif;
  font-size: 28px; font-weight: 600;
  color: var(--rose, #C07B60);
  line-height: 1;
}
.ctg-stat-val span { font-size: 13px; }
.ctg-stat-sub {
  font-family: 'Jost', sans-serif;
  font-size: 10px; color: var(--muted, #8A7560);
  margin-top: 2px;
}

/* CTA buttons */
.ctg-btns { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.ctg-btn-main {
  display: inline-flex; align-items: center; gap: 9px;
  padding: 14px 26px;
  background: var(--ink, #2A1F14);
  color: var(--paper, #FBF6EE);
  font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 600;
  letter-spacing: .04em; border-radius: 100px;
  text-decoration: none; border: none; cursor: pointer;
  transition: background .25s, transform .25s, box-shadow .25s;
  box-shadow: 0 4px 14px rgba(42,31,20,.25);
}
.ctg-btn-main:hover {
  background: var(--ink-l, #5C4A35);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(42,31,20,.3);
  color: var(--paper, #FBF6EE);
}
.ctg-btn-sec {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 13px 22px;
  border: 1.5px solid var(--manila-dd, #D6C4A0);
  color: var(--ink-l, #5C4A35);
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 500;
  border-radius: 100px; text-decoration: none;
  transition: border-color .2s, color .2s, background .2s, transform .2s;
  background: transparent;
}
.ctg-btn-sec:hover {
  border-color: var(--rose, #C07B60);
  color: var(--rose, #C07B60);
  background: rgba(192,123,96,.05);
  transform: translateY(-1px);
}

/* Strip bawah hero */
.ctg-hero-strip {
  position: absolute; bottom: 0; left: 0; right: 0;
  height: 5px; z-index: 6;
  background: linear-gradient(90deg, var(--manila-dd,#D6C4A0), var(--rose,#C07B60), var(--manila-dd,#D6C4A0));
}

/* ─── TICKER ─── */
.ctg-ticker {
  background: var(--ink, #2A1F14);
  overflow: hidden; padding: 9px 0;
}
.ctg-ticker-inner {
  display: flex; white-space: nowrap;
  animation: ctgTickerRoll 22s linear infinite;
}
.ctg-ticker-item {
  display: inline-flex; align-items: center; gap: 10px;
  margin: 0 20px;
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 400;
  letter-spacing: .14em; text-transform: uppercase;
  color: rgba(251,246,238,.4);
  text-decoration: none; flex-shrink: 0;
  transition: color .2s;
}
.ctg-ticker-item:hover { color: var(--rose-l, #DFA98C); }
.ctg-ticker-dot {
  width: 3px; height: 3px; border-radius: 50%;
  background: var(--rose, #C07B60); opacity: .5; flex-shrink: 0;
}

/* ─── BODY ─── */
.ctg-body {
  background: var(--paper, #FBF6EE);
  padding: 52px 0 76px;
  position: relative;
}
/* Subtle grid */
.ctg-body::before {
  content: '';
  position: absolute; inset: 0;
  background-image:
    repeating-linear-gradient(0deg,  transparent 0, transparent 47px, rgba(42,31,20,.04) 47px, rgba(42,31,20,.04) 48px),
    repeating-linear-gradient(90deg, transparent 0, transparent 47px, rgba(42,31,20,.04) 47px, rgba(42,31,20,.04) 48px);
  pointer-events: none;
}

.ctg-container {
  position: relative; z-index: 1;
  max-width: 1280px; margin: 0 auto; padding: 0 24px;
}
.ctg-layout {
  display: grid;
  grid-template-columns: 268px 1fr;
  gap: 40px;
  align-items: start;
}

/* ─── SIDEBAR ─── */
.ctg-sidebar {
  position: sticky; top: 96px;
  display: flex; flex-direction: column; gap: 14px;
}

.ctg-sidebar-panel {
  background: var(--manila, #F2E8D5);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 10px; overflow: hidden;
}
.ctg-sidebar-head {
  padding: 13px 16px;
  background: var(--ink, #2A1F14);
  display: flex; align-items: center; gap: 8px;
}
.ctg-sidebar-head-text {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: rgba(251,246,238,.5);
}
.ctg-sidebar-body { padding: 10px; }

/* Nav link */
.ctg-snav {
  display: flex; align-items: center; justify-content: space-between;
  padding: 10px 12px;
  border-radius: 7px;
  font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 400;
  color: var(--ink-l, #5C4A35);
  text-decoration: none;
  border: 1px solid transparent;
  transition: background .18s, color .18s, border-color .18s, padding-left .18s;
  margin-bottom: 2px;
}
.ctg-snav:hover {
  color: var(--rose, #C07B60);
  background: rgba(192,123,96,.07);
  border-color: rgba(192,123,96,.15);
  padding-left: 16px;
}
.ctg-snav.active {
  color: var(--rose, #C07B60);
  background: rgba(192,123,96,.08);
  border-color: rgba(192,123,96,.2);
  font-weight: 600;
}
.ctg-snav-dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: var(--rose, #C07B60); flex-shrink: 0;
}

/* Accordion sidebar */
.ctg-sacc-btn {
  display: flex; align-items: center; justify-content: space-between;
  width: 100%; text-align: left;
  padding: 10px 12px; border-radius: 7px;
  background: transparent; border: 1px solid transparent;
  cursor: pointer;
  font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 400;
  color: var(--ink-l, #5C4A35);
  transition: background .18s, color .18s;
  margin-bottom: 2px;
}
.ctg-sacc-btn:hover, .ctg-sacc-btn.open {
  color: var(--rose, #C07B60);
  background: rgba(192,123,96,.07);
}
.ctg-sacc-chevron { transition: transform .3s ease; }
.ctg-sacc-btn.open .ctg-sacc-chevron { transform: rotate(180deg); }
.ctg-sacc-body {
  max-height: 0; overflow: hidden;
  transition: max-height .35s ease;
  padding-left: 10px;
  border-left: 2px solid rgba(192,123,96,.2);
  margin: 0 0 4px 12px;
}
.ctg-sacc-body.open { max-height: 400px; }

/* Sidebar WA */
.ctg-sidebar-wa {
  background: var(--paper, #FBF6EE);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 10px;
  padding: 20px;
  text-align: center;
}
.ctg-sidebar-wa-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 17px; font-weight: 600;
  color: var(--ink, #2A1F14);
  margin-bottom: 6px;
}
.ctg-sidebar-wa-sub {
  font-family: 'Jost', sans-serif;
  font-size: 12.5px; font-weight: 300;
  color: var(--muted, #8A7560);
  margin-bottom: 16px; line-height: 1.7;
}
.ctg-sidebar-wa-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  background: var(--ink, #2A1F14);
  color: var(--paper, #FBF6EE);
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 600;
  padding: 10px 16px; border-radius: 100px;
  text-decoration: none; letter-spacing: .04em;
  transition: background .2s, transform .2s;
}
.ctg-sidebar-wa-btn:hover {
  background: var(--ink-l, #5C4A35);
  transform: translateY(-1px);
  color: var(--paper, #FBF6EE);
}

/* Info cepat */
.ctg-quick-item {
  display: flex; align-items: center; gap: 10px;
  padding: 8px 10px; border-radius: 6px;
  background: var(--paper, #FBF6EE);
  border: 1px solid var(--manila-dd, #D6C4A0);
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 400;
  color: var(--ink-l, #5C4A35);
  margin-bottom: 6px;
}
.ctg-quick-item:last-child { margin-bottom: 0; }
.ctg-quick-icon {
  width: 26px; height: 26px; border-radius: 6px;
  background: var(--manila, #F2E8D5);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.ctg-quick-icon svg {
  width: 13px; height: 13px;
  stroke: var(--rose, #C07B60); fill: none;
  stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
}

/* ─── PRODUK GRID ─── */
.ctg-prod-header {
  display: flex; align-items: flex-end;
  justify-content: space-between; gap: 16px;
  margin-bottom: 28px;
  padding-bottom: 18px;
  border-bottom: 1px solid var(--manila-dd, #D6C4A0);
  flex-wrap: wrap;
}
.ctg-prod-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.5rem, 2.5vw, 2.1rem);
  font-weight: 600; color: var(--ink, #2A1F14);
  line-height: 1.15;
}
.ctg-prod-title em {
  font-style: italic; font-weight: 300;
  color: var(--rose, #C07B60); font-size: .65em;
}
.ctg-prod-eyebrow {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--rose, #C07B60); margin-bottom: 6px;
  display: flex; align-items: center; gap: 8px;
}
.ctg-prod-eyebrow::before {
  content: '';
  width: 20px; height: 1px;
  background: var(--rose, #C07B60); opacity: .5;
}

.ctg-prod-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

/* Kartu produk */
.ctg-card {
  background: #fff;
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 10px; overflow: hidden;
  display: flex; flex-direction: column;
  text-decoration: none;
  transition: transform .3s ease, box-shadow .3s ease, border-color .3s;
}
.ctg-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 40px rgba(42,31,20,.12);
  border-color: rgba(192,123,96,.35);
}

/* Foto — 4:3 */
.ctg-card-img-wrap {
  position: relative; width: 100%; padding-top: 75%;
  background: var(--manila, #F2E8D5); overflow: hidden; flex-shrink: 0;
}
.ctg-card-img {
  position: absolute; inset: 0; width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform .6s ease;
}
.ctg-card:hover .ctg-card-img { transform: scale(1.06); }

/* Label foto */
.ctg-card-label {
  position: absolute; top: 10px; left: 10px;
  padding: 4px 10px;
  background: rgba(251,246,238,.95);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 4px;
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .1em; text-transform: uppercase;
  color: var(--rose, #C07B60); z-index: 4;
}

/* Monogram pojok */
.ctg-card-mono {
  position: absolute; top: 10px; right: 10px;
  width: 32px; height: 32px; border-radius: 6px;
  background: var(--ink, #2A1F14);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 14px; font-weight: 600;
  color: var(--paper, #FBF6EE);
  z-index: 4;
  transition: transform .3s ease;
}
.ctg-card:hover .ctg-card-mono { transform: rotate(6deg) scale(1.08); }

/* Info konten */
.ctg-card-info {
  padding: 16px 16px 18px;
  display: flex; flex-direction: column;
  gap: 8px; flex: 1;
  border-top: 1px solid var(--manila-dd, #D6C4A0);
}
.ctg-card-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 17px; font-weight: 600;
  color: var(--ink, #2A1F14);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 48px;
}
.ctg-card-price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 21px; font-weight: 600;
  color: var(--rose, #C07B60);
  line-height: 1;
  margin-top: auto; padding-top: 6px;
}
.ctg-card-btn {
  display: flex; align-items: center; justify-content: center; gap: 7px;
  padding: 10px 14px;
  background: var(--ink, #2A1F14);
  color: var(--paper, #FBF6EE);
  border-radius: 7px;
  font-family: 'Jost', sans-serif;
  font-size: 12.5px; font-weight: 600;
  letter-spacing: .04em;
  text-decoration: none; border: none;
  transition: background .2s, transform .2s;
  margin-top: 4px;
}
.ctg-card-btn:hover {
  background: var(--ink-l, #5C4A35);
  transform: translateY(-1px);
  color: var(--paper, #FBF6EE);
}

/* Empty state */
.ctg-empty {
  text-align: center;
  padding: 72px 20px;
  background: var(--manila, #F2E8D5);
  border: 1px dashed var(--manila-dd, #D6C4A0);
  border-radius: 12px;
}
.ctg-empty-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px; font-weight: 600;
  color: var(--muted, #8A7560); margin-bottom: 8px;
}
.ctg-empty-sub {
  font-family: 'Jost', sans-serif;
  font-size: 13px; color: var(--muted, #8A7560);
  margin-bottom: 24px;
}

/* Divider antar section */
.ctg-section-rule {
  height: 1px; margin: 0;
  background: linear-gradient(90deg, transparent, var(--manila-dd,#D6C4A0), transparent);
}

/* ─── SEO SECTION ─── */
.ctg-seo {
  background: var(--manila, #F2E8D5);
  padding: 72px 0 76px;
  position: relative; overflow: hidden;
}
.ctg-seo::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.02'/%3E%3C/svg%3E");
  pointer-events: none;
}
.ctg-seo::after {
  content: '';
  position: absolute;
  top: 0; left: 10%; right: 10%; height: 1px;
  background: linear-gradient(90deg, transparent, var(--manila-dd,#D6C4A0), transparent);
}

.ctg-seo-inner {
  position: relative; z-index: 1;
  max-width: 1280px; margin: 0 auto; padding: 0 24px;
}

/* SEO header */
.ctg-seo-header { text-align: center; margin-bottom: 52px; }
.ctg-seo-eyebrow {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .2em; text-transform: uppercase;
  color: var(--rose, #C07B60);
  margin-bottom: 14px;
  display: flex; align-items: center; justify-content: center; gap: 10px;
}
.ctg-seo-eyebrow-line {
  width: 36px; height: 1px;
  background: var(--rose, #C07B60); opacity: .4;
}
.ctg-seo-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.8rem, 3.2vw, 2.8rem);
  font-weight: 600; color: var(--ink, #2A1F14);
  line-height: 1.2;
}
.ctg-seo-title em {
  font-style: italic; font-weight: 300;
  color: var(--rose, #C07B60);
}

/* SEO grid */
.ctg-seo-grid {
  display: grid;
  grid-template-columns: 1fr 308px;
  gap: 48px;
  align-items: start;
}

/* Prosa */
.ctg-prose {
  font-family: 'Jost', sans-serif;
  font-size: 15px; font-weight: 300;
  line-height: 1.9; color: var(--ink-l, #5C4A35);
  margin-bottom: 32px;
}
.ctg-prose strong { color: var(--rose, #C07B60); font-weight: 600; }

/* Keunggulan */
.ctg-ugln-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px; font-weight: 600;
  color: var(--ink, #2A1F14); margin-bottom: 16px;
  display: flex; align-items: center; gap: 10px;
}
.ctg-ugln-title::before {
  content: '';
  width: 3px; height: 22px;
  background: var(--rose, #C07B60); border-radius: 2px;
  flex-shrink: 0;
}
.ctg-ugln-item {
  display: flex; align-items: flex-start; gap: 12px;
  padding: 12px 14px;
  border-radius: 8px;
  background: #fff;
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-left: 2px solid var(--rose, #C07B60);
  margin-bottom: 8px;
  transition: transform .2s, box-shadow .2s;
}
.ctg-ugln-item:hover {
  transform: translateX(3px);
  box-shadow: 0 4px 16px rgba(42,31,20,.08);
}
.ctg-ugln-icon {
  width: 30px; height: 30px; border-radius: 50%;
  background: var(--manila, #F2E8D5);
  border: 1px solid var(--manila-dd, #D6C4A0);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.ctg-ugln-icon svg {
  width: 14px; height: 14px;
  stroke: var(--rose, #C07B60); fill: none;
  stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
}
.ctg-ugln-text {
  font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 400;
  color: var(--ink-l, #5C4A35); line-height: 1.65;
}

/* Cards kanan SEO */
.ctg-seo-side { display: flex; flex-direction: column; gap: 14px; position: sticky; top: 96px; }
.ctg-info-card {
  background: #fff;
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 10px; overflow: hidden;
}
.ctg-info-card-head {
  padding: 12px 16px;
  background: var(--manila, #F2E8D5);
  border-bottom: 1px solid var(--manila-dd, #D6C4A0);
  display: flex; align-items: center; gap: 9px;
}
.ctg-info-card-head-icon {
  width: 28px; height: 28px; border-radius: 6px;
  background: var(--paper, #FBF6EE);
  border: 1px solid var(--manila-dd, #D6C4A0);
  display: flex; align-items: center; justify-content: center;
}
.ctg-info-card-head-icon svg {
  width: 14px; height: 14px;
  stroke: var(--rose, #C07B60); fill: none;
  stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
}
.ctg-info-card-head-title {
  font-family: 'Jost', sans-serif;
  font-size: 11.5px; font-weight: 600;
  letter-spacing: .1em; text-transform: uppercase;
  color: var(--ink, #2A1F14);
}
.ctg-info-card-body { padding: 16px; }

/* Area pills */
.ctg-area-pill {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 5px 11px; border-radius: 20px;
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 400;
  border: 1px solid var(--manila-dd, #D6C4A0);
  color: var(--ink-l, #5C4A35);
  text-decoration: none;
  background: var(--manila, #F2E8D5);
  transition: all .2s ease;
}
.ctg-area-pill:hover {
  background: var(--ink, #2A1F14);
  color: var(--paper, #FBF6EE);
  border-color: var(--ink, #2A1F14);
  transform: translateY(-1px);
}

/* Info row */
.ctg-info-row {
  display: flex; justify-content: space-between; align-items: center;
  gap: 8px; padding: 9px 0;
  border-bottom: 1px solid var(--manila-dd, #D6C4A0);
}
.ctg-info-row:last-child { border-bottom: none; }
.ctg-info-row-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 400;
  color: var(--muted, #8A7560);
}
.ctg-info-row-val {
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 600;
  color: var(--rose, #C07B60);
  text-align: right;
}

/* ─── RESPONSIVE ─── */
@media (max-width: 1023px) {
  .ctg-layout   { grid-template-columns: 1fr; }
  .ctg-sidebar  { display: none; }
  .ctg-seo-grid { grid-template-columns: 1fr; }
  .ctg-prod-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .ctg-prod-grid { grid-template-columns: 1fr; }
  .ctg-hero { padding-top: 80px; }
  .ctg-hero-img { display: none; }
  .ctg-btns { flex-direction: column; align-items: flex-start; }
}
</style>

<!-- ─── KELOPAK JATUH ─── -->
<div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:9998;" aria-hidden="true">
<?php
$petal_colors = ['#C07B60','#DFA98C','#D6C4A0','#FBF6EE','#E8D9BF'];
for ($i = 0; $i < 9; $i++):
  $col   = $petal_colors[$i % count($petal_colors)];
  $left  = rand(2, 97);
  $delay = rand(0, 18);
  $dur   = rand(14, 24);
  $size  = rand(7, 12);
?>
<div class="ctg-petal" style="
  left: <?= $left ?>%;
  top: 0;
  width: <?= $size ?>px;
  height: <?= round($size*1.4) ?>px;
  background: <?= $col ?>;
  opacity: .35;
  animation-duration: <?= $dur ?>s;
  animation-delay: -<?= $delay ?>s;
"></div>
<?php endfor; ?>
</div>

<!-- ─── HERO ─── -->
<section class="ctg-hero">

  <!-- Foto kategori kanan -->
  <?php if (!empty($category['image'])): ?>
  <div class="ctg-hero-img">
    <div class="ctg-hero-img-bg" style="background-image:url('<?= e(imgUrl($category['image'],'category')) ?>');"></div>
    <div class="ctg-hero-img-fade"></div>
    <div class="ctg-hero-img-accent"></div>
  </div>
  <?php endif; ?>

  <!-- Ornamen SVG pojok -->
  <svg class="ctg-hero-floral" viewBox="0 0 380 380" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="320" cy="60"  r="110" stroke="#C07B60" stroke-width="1"/>
    <circle cx="320" cy="60"  r="72"  stroke="#DFA98C" stroke-width="1"/>
    <circle cx="320" cy="60"  r="36"  fill="rgba(192,123,96,.15)"/>
    <ellipse cx="320" cy="8"   rx="16" ry="52" fill="rgba(192,123,96,.2)" transform="rotate(0 320 60)"/>
    <ellipse cx="320" cy="8"   rx="16" ry="52" fill="rgba(192,123,96,.2)" transform="rotate(60 320 60)"/>
    <ellipse cx="320" cy="8"   rx="16" ry="52" fill="rgba(192,123,96,.15)" transform="rotate(120 320 60)"/>
    <circle cx="380" cy="130" r="80"  stroke="#D6C4A0" stroke-width="1"/>
  </svg>

  <div class="ctg-hero-inner">

    <!-- Breadcrumb -->
    <nav class="ctg-breadcrumb ctg-reveal ctg-rv1">
      <a href="<?= BASE_URL ?>/">Beranda</a>
      <span class="ctg-breadcrumb-sep">›</span>
      <span class="ctg-breadcrumb-cur"><?= e($category['name']) ?></span>
    </nav>

    <div style="max-width:560px;">

      <!-- Badge -->
      <div class="ctg-badge ctg-reveal ctg-rv1">
        <div class="ctg-badge-dot"></div>
        <span class="ctg-badge-text">Florist Terpercaya · Jakarta Pusat</span>
      </div>

      <!-- Judul -->
      <h1 class="ctg-h1 ctg-reveal ctg-rv2"><?= e($category['name']) ?></h1>
      <p class="ctg-tagline ctg-reveal ctg-rv2">Segar, Indah, Dikirim ke Pintu Anda</p>

      <!-- Deskripsi -->
      <p class="ctg-desc ctg-reveal ctg-rv3">
        <?= !empty($category['meta_description'])
          ? e($category['meta_description'])
          : 'Toko bunga Jakarta Pusat terpercaya menyediakan '.e(strtolower($category['name'])).' berkualitas tinggi dengan bunga segar pilihan. Pesan sekarang, kirim cepat.' ?>
      </p>

      <!-- Stats -->
      <div class="ctg-stats ctg-reveal ctg-rv3">
        <div class="ctg-stat">
          <div class="ctg-stat-lbl">Produk</div>
          <div class="ctg-stat-val"><?= $product_count ?><span>+</span></div>
          <div class="ctg-stat-sub">Tersedia</div>
        </div>
        <div class="ctg-stat">
          <div class="ctg-stat-lbl">Pengiriman</div>
          <div class="ctg-stat-val" style="color:var(--ink,#2A1F14);">2–4<span>Jam</span></div>
          <div class="ctg-stat-sub">Same Day</div>
        </div>
        <div class="ctg-stat">
          <div class="ctg-stat-lbl">Mulai dari</div>
          <div class="ctg-stat-val" style="font-size:18px;color:var(--muted,#8A7560);"><?= 'Rp '.number_format($min_price/1000,0,',','.').'rb' ?></div>
          <div class="ctg-stat-sub">Harga terbaik</div>
        </div>
      </div>

      <!-- CTA -->
      <div class="ctg-btns ctg-reveal ctg-rv4">
        <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan '.$category['name'].' di Jakarta Pusat.') ?>"
           target="_blank" rel="noopener" class="ctg-btn-main">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
          Pesan Sekarang
        </a>
        <a href="#produk" class="ctg-btn-sec">Lihat Koleksi ↓</a>
      </div>

    </div>
  </div>

  <div class="ctg-hero-strip" aria-hidden="true"></div>
</section>

<!-- ─── TICKER ─── -->
<div class="ctg-ticker" aria-label="Kategori layanan">
  <div class="ctg-ticker-inner" aria-hidden="true">
    <?php for ($r = 0; $r < 2; $r++): foreach ($all_cats as $c): ?>
    <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" class="ctg-ticker-item">
      <span class="ctg-ticker-dot"></span>
      <?= e($c['name']) ?>
    </a>
    <?php endforeach; endfor; ?>
  </div>
</div>

<!-- ─── BODY: SIDEBAR + PRODUK ─── -->
<div id="produk" class="ctg-body">
  <div class="ctg-container">
    <div class="ctg-layout">

      <!-- SIDEBAR -->
      <aside class="ctg-sidebar">

        <!-- Panel kategori -->
        <div class="ctg-sidebar-panel">
          <div class="ctg-sidebar-head">
            <svg width="13" height="13" fill="none" stroke="rgba(251,246,238,.5)" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            <span class="ctg-sidebar-head-text">Layanan Kami</span>
          </div>
          <div class="ctg-sidebar-body">
            <?php foreach ($all_cats as $c):
              $c_subs   = $all_cats_subs[$c['id']] ?? [];
              $has_subs = !empty($c_subs);
              $is_active= $c['id']==$category['id']||(isset($category['parent_id'])&&$category['parent_id']==$c['id']);
            ?>
            <?php if ($has_subs): ?>
            <button onclick="ctgToggleAcc(this)" class="ctg-sacc-btn <?= $is_active?'open':'' ?>">
              <span><?= e($c['name']) ?></span>
              <svg class="ctg-sacc-chevron" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div class="ctg-sacc-body <?= $is_active?'open':'' ?>">
              <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" class="ctg-snav" style="font-size:11.5px;color:var(--rose,#C07B60);padding:4px 10px;">
                Lihat semua ›
              </a>
              <?php foreach ($c_subs as $sub):
                $is_sub = $sub['id']==$category['id']; ?>
              <a href="<?= BASE_URL ?>/<?= e($sub['slug']) ?>/" class="ctg-snav <?= $is_sub?'active':'' ?>">
                <span><?= e($sub['name']) ?></span>
                <?php if ($is_sub): ?><span class="ctg-snav-dot"></span><?php endif; ?>
              </a>
              <?php endforeach; ?>
            </div>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" class="ctg-snav <?= $is_active?'active':'' ?>">
              <?= e($c['name']) ?>
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- WA Panel -->
        <div class="ctg-sidebar-wa">
          <div class="ctg-sidebar-wa-title">Butuh Bantuan?</div>
          <p class="ctg-sidebar-wa-sub">Konsultasi gratis 24 jam,<br>pengiriman ke seluruh Jakarta Pusat</p>
          <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener" class="ctg-sidebar-wa-btn">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Chat WhatsApp
          </a>
        </div>

        <!-- Info cepat -->
        <div class="ctg-sidebar-panel">
          <div class="ctg-sidebar-head">
            <svg width="13" height="13" fill="none" stroke="rgba(251,246,238,.5)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span class="ctg-sidebar-head-text">Info Cepat</span>
          </div>
          <div class="ctg-sidebar-body">
            <?php $quick_info = [
              ['clock', 'Buka 24 Jam / 7 Hari'],
              ['truck', 'Kirim 2–4 Jam'],
              ['credit-card', 'COD & Transfer'],
              ['map-pin', 'Jakarta Pusat'],
            ]; ?>
            <?php foreach ($quick_info as [$icon, $text]): ?>
            <div class="ctg-quick-item">
              <div class="ctg-quick-icon">
                <?php if ($icon === 'clock'): ?>
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?php elseif ($icon === 'truck'): ?>
                <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                <?php elseif ($icon === 'credit-card'): ?>
                <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                <?php else: ?>
                <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/></svg>
                <?php endif; ?>
              </div>
              <span><?= $text ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

      </aside>

      <!-- PRODUK -->
      <div>
        <div class="ctg-prod-header">
          <div>
            <div class="ctg-prod-eyebrow">Koleksi</div>
            <h2 class="ctg-prod-title">
              <?= e($category['name']) ?>
              <em>&nbsp;· <?= $product_count ?> produk</em>
            </h2>
          </div>
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin melihat katalog '.$category['name'].' lengkap.') ?>"
             target="_blank" rel="noopener"
             class="ctg-btn-sec" style="font-size:12px;padding:9px 16px;flex-shrink:0;">
            Katalog via WA ›
          </a>
        </div>

        <?php if (!empty($products)): ?>
        <div class="ctg-prod-grid">
          <?php foreach ($products as $idx => $prod):
            $img     = imgUrl($prod['image'],'product');
            $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga ".rupiah($prod['price']).". Apakah masih tersedia?");
          ?>
          <div style="animation: fadeUp .5s ease <?= $idx * 0.07 ?>s both;">
            <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>"
               target="_blank" rel="noopener" class="ctg-card">

              <div class="ctg-card-img-wrap">
                <img src="<?= e($img) ?>"
                     alt="<?= e($prod['name']) ?> Jakarta Pusat"
                     class="ctg-card-img" loading="lazy">
                <?php if (!empty($prod['cat_name'])): ?>
                <span class="ctg-card-label"><?= e($prod['cat_name']) ?></span>
                <?php endif; ?>
                <div class="ctg-card-mono">
                  <?= strtoupper(mb_substr($prod['name'], 0, 1, 'UTF-8')) ?>
                </div>
              </div>

              <div class="ctg-card-info">
                <div class="ctg-card-name"><?= e($prod['name']) ?></div>
                <div class="ctg-card-price"><?= rupiah($prod['price']) ?></div>
                <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>"
                   target="_blank" rel="noopener"
                   class="ctg-card-btn" onclick="event.stopPropagation()">
                  <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                  Pesan via WhatsApp
                </a>
              </div>

            </a>
          </div>
          <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div class="ctg-empty">
          <div class="ctg-empty-title">Produk sedang dipersiapkan</div>
          <p class="ctg-empty-sub">Hubungi kami untuk melihat koleksi terbaru</p>
          <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener" class="ctg-btn-main">
            Tanya via WhatsApp
          </a>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>

<div class="ctg-section-rule"></div>

<!-- ─── SEO SECTION ─── -->
<section class="ctg-seo">
  <div class="ctg-seo-inner">

    <header class="ctg-seo-header">
      <div class="ctg-seo-eyebrow">
        <span class="ctg-seo-eyebrow-line"></span>
        Tentang Layanan
        <span class="ctg-seo-eyebrow-line"></span>
      </div>
      <h2 class="ctg-seo-title">
        <?= e($category['name']) ?> Terbaik
        <em> di Jakarta Pusat</em>
      </h2>
    </header>

    <div class="ctg-seo-grid">

      <!-- Kiri: Konten SEO -->
      <div>
        <?php if (!empty($category['content'])): ?>
        <div class="ctg-prose"><?= $category['content'] ?></div>
        <?php endif; ?>

        <p class="ctg-prose">
          Kami sebagai <strong>florist Jakarta Pusat</strong> terpercaya menyediakan
          <?= e(strtolower($category['name'])) ?> berkualitas tinggi. Setiap rangkaian dikerjakan oleh tim florist berpengalaman dengan bunga segar pilihan yang tiba langsung dari kebun pilihan.
        </p>

        <h3 class="ctg-ugln-title">Mengapa Memilih Kami?</h3>

        <?php $ugln = [
          ['flower',    'Bunga 100% segar berkualitas premium, dipilih setiap pagi'],
          ['truck',     'Pengiriman cepat 2–4 jam ke seluruh Jakarta Pusat'],
          ['tag',       'Harga transparan mulai '.rupiah($min_price)],
          ['edit',      'Desain custom sesuai tema, warna, dan keinginan Anda'],
          ['clock',     'Melayani pesanan mendadak 24 jam via WhatsApp'],
        ]; ?>

        <?php foreach ($ugln as [$icon, $text]): ?>
        <div class="ctg-ugln-item">
          <div class="ctg-ugln-icon">
            <?php if ($icon === 'flower'): ?>
            <svg viewBox="0 0 24 24"><path d="M12 2C9.5 2 8 4.5 8 7c0 2 1 3.5 2.5 4.5C9 12.5 7 14.5 7 17c0 2.5 2 4 5 4s5-1.5 5-4c0-2.5-2-4.5-3.5-5.5C15 10.5 16 9 16 7c0-2.5-1.5-5-4-5z"/><path d="M12 11.5V22"/></svg>
            <?php elseif ($icon === 'truck'): ?>
            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            <?php elseif ($icon === 'tag'): ?>
            <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            <?php elseif ($icon === 'edit'): ?>
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            <?php else: ?>
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <?php endif; ?>
          </div>
          <span class="ctg-ugln-text"><?= $text ?></span>
        </div>
        <?php endforeach; ?>

        <div style="margin-top:28px;">
          <h3 class="ctg-ugln-title" style="margin-bottom:14px;">Cara Memesan</h3>
          <p class="ctg-prose">
            Hubungi kami via WhatsApp di <strong><?= e(setting('phone_display')) ?></strong> — informasikan jenis bunga, alamat pengiriman, tanggal &amp; jam, dan pesan yang ingin dituliskan. Mudah, cepat, bunga langsung dikirim!
          </p>
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan '.$category['name'].' di Jakarta Pusat.') ?>"
             target="_blank" rel="noopener" class="ctg-btn-main" style="display:inline-flex;margin-top:4px;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Chat WhatsApp Sekarang
          </a>
        </div>
      </div>

      <!-- Kanan: Info cards -->
      <div class="ctg-seo-side">

        <!-- Area pengiriman -->
        <div class="ctg-info-card">
          <div class="ctg-info-card-head">
            <div class="ctg-info-card-head-icon">
              <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/></svg>
            </div>
            <span class="ctg-info-card-head-title">Area Pengiriman</span>
          </div>
          <div class="ctg-info-card-body">
            <p style="font-family:'Jost',sans-serif;font-size:12px;font-weight:300;color:var(--muted,#8A7560);margin-bottom:10px;">Melayani seluruh kecamatan Jakarta Pusat:</p>
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
              <?php foreach ($locations as $l): ?>
              <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/" class="ctg-area-pill">
                <?= e($l['name']) ?>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Info pemesanan -->
        <div class="ctg-info-card">
          <div class="ctg-info-card-head">
            <div class="ctg-info-card-head-icon">
              <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
            </div>
            <span class="ctg-info-card-head-title">Info Pemesanan</span>
          </div>
          <div class="ctg-info-card-body">
            <?php $order_info = [
              ['Jam Operasional', setting('jam_buka') ?: '24 Jam / 7 Hari'],
              ['Estimasi Kirim',  '2–4 Jam setelah konfirmasi'],
              ['Harga Mulai',     rupiah($min_price)],
              ['Pembayaran',      'Transfer / COD tersedia'],
            ]; ?>
            <?php foreach ($order_info as [$lbl, $val]): ?>
            <div class="ctg-info-row">
              <span class="ctg-info-row-lbl"><?= $lbl ?></span>
              <span class="ctg-info-row-val"><?= $val ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Kartu konsultasi -->
        <div style="background:var(--ink,#2A1F14);border-radius:10px;padding:22px;text-align:center;">
          <div style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;color:var(--paper,#FBF6EE);margin-bottom:6px;">
            Konsultasi Gratis
          </div>
          <p style="font-family:'Jost',sans-serif;font-size:12px;font-weight:300;color:rgba(251,246,238,.4);margin-bottom:16px;line-height:1.7;">
            Tim kami siap membantu Anda memilih rangkaian yang tepat untuk setiap momen
          </p>
          <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener"
             style="display:inline-flex;align-items:center;gap:8px;background:var(--paper,#FBF6EE);color:var(--ink,#2A1F14);font-family:'Jost',sans-serif;font-size:12.5px;font-weight:700;padding:11px 20px;border-radius:100px;text-decoration:none;transition:background .2s,transform .2s;letter-spacing:.04em;"
             onmouseover="this.style.background='#fff';this.style.transform='translateY(-1px)'"
             onmouseout="this.style.background='var(--paper,#FBF6EE)';this.style.transform=''">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Chat WhatsApp
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
function ctgToggleAcc(btn) {
  const body   = btn.nextElementSibling;
  const isOpen = body.classList.contains('open');
  document.querySelectorAll('.ctg-sacc-body.open').forEach(el => el.classList.remove('open'));
  document.querySelectorAll('.ctg-sacc-btn.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) { btn.classList.add('open'); body.classList.add('open'); }
}
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.ctg-sacc-body.open').forEach(el => {
    el.previousElementSibling?.classList.add('open');
  });
});
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>