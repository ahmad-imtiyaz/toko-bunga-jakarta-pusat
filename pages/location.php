<?php
require_once __DIR__ . '/../includes/config.php';

$meta_title    = $location['meta_title']       ?: 'Toko Bunga ' . $location['name'] . ' - Florist Grogol Terpercaya';
$meta_desc     = $location['meta_description'] ?: '';
$meta_keywords = 'toko bunga ' . strtolower($location['name']) . ', florist ' . strtolower($location['name']) . ', bunga Grogol';

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

$all_prices = [];
foreach ($cats_with_products as $row) foreach ($row['products'] as $p) $all_prices[] = $p['price'];
$min_price = !empty($all_prices) ? min($all_prices) : 300000;

require __DIR__ . '/../includes/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@400;500;600;700;800&family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   TSUKIMI-EN 月見園 — MOONLIT ONSEN
   Navy · Lavender · Silver Moonlight
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
:root {
  --navy:    #0D1B2A;
  --navy2:   #112236;
  --navy3:   #162C45;
  --indigo:  #1E3A5F;
  --lav:     #C4B5D4;
  --lav2:    #D8CCE8;
  --lav3:    #EDE6F5;
  --silver:  #E8E0F0;
  --moon:    #F5F0FF;
  --gold:    #C9A84C;
  --gold2:   #E2C46A;
  --sakura:  #FFB7C5;
  --misty:   rgba(196,181,212,0.15);
  --moonray: rgba(245,240,255,0.08);
  --ink:     rgba(13,27,42,0.85);
  --tsuki:   #F0E8FF; /* moonlight white */
}

* { box-sizing: border-box; }

body { font-family: 'Zen Kaku Gothic New', sans-serif; background: var(--navy); }

/* ══ FIREFLY ANIMATION ══ */
@keyframes firefly-rise {
  0%   { transform: translateY(0) translateX(0) scale(0.6); opacity: 0; }
  15%  { opacity: 1; }
  50%  { transform: translateY(-40vh) translateX(var(--fx,20px)) scale(1); opacity: 0.9; }
  85%  { opacity: 0.4; }
  100% { transform: translateY(-80vh) translateX(var(--fx2,−10px)) scale(0.4); opacity: 0; }
}
@keyframes firefly-glow {
  0%,100% { box-shadow: 0 0 4px 2px rgba(196,181,212,0.5); }
  50%      { box-shadow: 0 0 12px 5px rgba(245,240,255,0.9), 0 0 24px 10px rgba(196,181,212,0.3); }
}
.firefly {
  position: absolute;
  width: 4px; height: 4px;
  border-radius: 50%;
  background: var(--tsuki);
  pointer-events: none;
  z-index: 1;
  animation:
    firefly-rise var(--dur,8s) ease-in var(--del,0s) infinite,
    firefly-glow 2s ease-in-out var(--del,0s) infinite;
}
/* Wrapper untuk fireflies agar tidak meledakkan height section */
.firefly-container {
  position: absolute;
  inset: 0;
  overflow: hidden;
  pointer-events: none;
  z-index: 1;
}

/* ══ UKIYO-E LAYERS ══ */
@keyframes float-layer {
  0%,100% { transform: translateY(0); }
  50%      { transform: translateY(-12px); }
}
@keyframes moon-pulse {
  0%,100% { box-shadow: 0 0 60px 20px rgba(245,240,255,0.25), 0 0 120px 60px rgba(196,181,212,0.1); }
  50%      { box-shadow: 0 0 80px 30px rgba(245,240,255,0.4), 0 0 160px 80px rgba(196,181,212,0.2); }
}
@keyframes cloud-drift {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
@keyframes ink-reveal {
  from { clip-path: inset(0 100% 0 0); }
  to   { clip-path: inset(0 0% 0 0); }
}
@keyframes fade-up {
  from { opacity:0; transform:translateY(30px); }
  to   { opacity:1; transform:translateY(0); }
}
.fade-up-1 { animation: fade-up 0.8s ease both 0.1s; }
.fade-up-2 { animation: fade-up 0.8s ease both 0.3s; }
.fade-up-3 { animation: fade-up 0.8s ease both 0.5s; }
.fade-up-4 { animation: fade-up 0.8s ease both 0.7s; }

/* ══ SEIGAIHA PATTERN ══ */
.seigaiha-bg {
  background-color: var(--navy);
  background-image:
    radial-gradient(ellipse 30px 20px at 30px 20px, transparent 19px, rgba(196,181,212,0.06) 19px, rgba(196,181,212,0.06) 20px, transparent 20px),
    radial-gradient(ellipse 30px 20px at 0px 20px, transparent 19px, rgba(196,181,212,0.06) 19px, rgba(196,181,212,0.06) 20px, transparent 20px);
  background-size: 30px 20px;
}

/* ══ SHIMMER LINE ══ */
@keyframes shim { 0%{background-position:-200% center}100%{background-position:200% center} }
.moon-line {
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--lav), var(--tsuki), var(--lav), transparent);
  background-size: 200% auto;
  animation: shim 4s linear infinite;
}

/* ═══════════════════════════════════
   HERO — UKIYO-E LAYERED
═══════════════════════════════════ */
.hero-tsukimi {
  position: relative;
  min-height: 100vh;
  overflow: hidden;
  background: var(--navy);
  padding-top: 80px;
  display: flex;
  align-items: center;
}

/* Sky gradient */
.hero-sky {
  position: absolute; inset: 0;
  background: linear-gradient(180deg,
    #060D18 0%,
    #0D1B2A 30%,
    #112236 60%,
    #1a2a45 80%,
    #1E2D4A 100%);
}

/* Stars */
.star-field {
  position: absolute; inset: 0;
  background-image:
    radial-gradient(1px 1px at 15% 20%, rgba(255,255,255,0.8) 0%, transparent 100%),
    radial-gradient(1.5px 1.5px at 28% 8%, rgba(255,255,255,0.6) 0%, transparent 100%),
    radial-gradient(1px 1px at 45% 15%, rgba(255,255,255,0.9) 0%, transparent 100%),
    radial-gradient(1px 1px at 62% 5%, rgba(255,255,255,0.7) 0%, transparent 100%),
    radial-gradient(1.5px 1.5px at 78% 22%, rgba(255,255,255,0.5) 0%, transparent 100%),
    radial-gradient(1px 1px at 90% 10%, rgba(255,255,255,0.8) 0%, transparent 100%),
    radial-gradient(1px 1px at 5% 40%, rgba(255,255,255,0.4) 0%, transparent 100%),
    radial-gradient(1px 1px at 35% 35%, rgba(255,255,255,0.6) 0%, transparent 100%),
    radial-gradient(1.5px 1.5px at 55% 28%, rgba(255,255,255,0.5) 0%, transparent 100%),
    radial-gradient(1px 1px at 82% 42%, rgba(255,255,255,0.7) 0%, transparent 100%),
    radial-gradient(1px 1px at 70% 38%, rgba(196,181,212,0.6) 0%, transparent 100%),
    radial-gradient(1px 1px at 22% 55%, rgba(255,255,255,0.3) 0%, transparent 100%),
    radial-gradient(1px 1px at 95% 30%, rgba(255,255,255,0.6) 0%, transparent 100%);
}

/* Moon */
.ukiyo-moon {
  position: absolute;
  top: 12%;
  right: 14%;
  width: 130px; height: 130px;
  border-radius: 50%;
  background: radial-gradient(circle at 40% 35%, var(--tsuki) 0%, var(--lav3) 50%, var(--lav2) 100%);
  animation: moon-pulse 5s ease-in-out infinite;
  z-index: 2;
}
.ukiyo-moon::after {
  content: '';
  position: absolute;
  inset: -20px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(240,232,255,0.15) 0%, transparent 70%);
}

/* Mountain layers */
.ukiyo-mtn-far {
  position: absolute;
  bottom: 28%;
  left: 0; right: 0;
  height: 220px;
  background: linear-gradient(180deg, transparent 0%, #1a2d50 40%, #162540 100%);
  clip-path: polygon(0 100%, 8% 40%, 18% 60%, 28% 20%, 40% 55%, 52% 15%, 64% 50%, 75% 25%, 85% 55%, 95% 35%, 100% 50%, 100% 100%);
  z-index: 3;
  animation: float-layer 12s ease-in-out infinite;
}
.ukiyo-mtn-near {
  position: absolute;
  bottom: 18%;
  left: 0; right: 0;
  height: 200px;
  background: linear-gradient(180deg, #112036 0%, #0D1B2A 100%);
  clip-path: polygon(0 100%, 0 70%, 15% 30%, 30% 65%, 45% 20%, 60% 55%, 72% 28%, 85% 58%, 100% 35%, 100% 100%);
  z-index: 4;
  animation: float-layer 18s ease-in-out infinite reverse;
}

/* Cloud strips */
.ukiyo-clouds {
  position: absolute;
  top: 35%;
  left: 0;
  width: 200%;
  z-index: 3;
  display: flex;
  gap: 0;
  animation: cloud-drift 40s linear infinite;
  pointer-events: none;
}
.ukiyo-cloud-strip {
  flex-shrink: 0;
  width: 50%;
  height: 60px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(196,181,212,0.06) 15%,
    rgba(220,210,235,0.12) 35%,
    rgba(196,181,212,0.08) 55%,
    rgba(196,181,212,0.04) 70%,
    transparent 85%,
    rgba(196,181,212,0.07) 100%);
  filter: blur(8px);
}

/* Sakura tree silhouette — pure CSS */
.ukiyo-tree {
  position: absolute;
  bottom: 15%;
  right: 8%;
  z-index: 5;
  pointer-events: none;
}
.tree-trunk {
  width: 8px; height: 100px;
  background: linear-gradient(180deg, #2a1a3a, #1a0e28);
  margin: 0 auto;
  border-radius: 4px;
}
.tree-branch {
  position: absolute;
  background: #2a1a3a;
  border-radius: 2px;
  transform-origin: bottom left;
}
.tree-blossom {
  position: absolute;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,183,197,0.6), rgba(255,183,197,0.2));
  filter: blur(8px);
}

/* Foreground water ripple */
.ukiyo-water {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 22%;
  background: linear-gradient(180deg, transparent 0%, rgba(13,27,42,0.8) 40%, #080F1A 100%);
  z-index: 6;
}
.water-line {
  position: absolute;
  left: 5%; right: 5%;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(196,181,212,0.25), rgba(245,240,255,0.4), rgba(196,181,212,0.25), transparent);
}

/* Bamboo silhouettes */
.ukiyo-bamboo {
  position: absolute;
  bottom: 16%;
  left: 4%;
  z-index: 5;
  display: flex;
  gap: 14px;
  align-items: flex-end;
  pointer-events: none;
}
.bamboo-stalk {
  width: 5px;
  background: linear-gradient(180deg, rgba(13,40,20,0.6), rgba(8,25,12,0.8));
  border-radius: 3px;
  position: relative;
}
.bamboo-stalk::before {
  content: '';
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  background: rgba(255,255,255,0.08);
  height: 1px;
}
@keyframes bamboo-sway {
  0%,100% { transform: rotate(0deg); transform-origin: bottom center; }
  33%      { transform: rotate(1.5deg); transform-origin: bottom center; }
  66%      { transform: rotate(-1deg); transform-origin: bottom center; }
}
.bamboo-stalk { animation: bamboo-sway var(--bs,6s) ease-in-out infinite; }

/* Hero content */
.hero-content {
  position: relative;
  z-index: 10;
  width: 100%;
  padding: 0 2rem;
  max-width: 1280px;
  margin: 0 auto;
}

/* Kanji watermark */
.kanji-watermark {
  position: absolute;
  right: 6%;
  top: 50%;
  transform: translateY(-50%);
  font-family: 'Shippori Mincho', serif;
  font-size: clamp(120px, 18vw, 220px);
  font-weight: 800;
  color: rgba(196,181,212,0.04);
  writing-mode: vertical-rl;
  text-orientation: mixed;
  letter-spacing: 0.1em;
  pointer-events: none;
  z-index: 1;
  user-select: none;
}

/* ═══════════════════════════════════
   TICKER — MOONLIT STYLE
═══════════════════════════════════ */
@keyframes ticker-scroll { from{transform:translateX(0)} to{transform:translateX(-50%)} }
.tsuki-ticker {
  background: linear-gradient(90deg, var(--navy2), var(--indigo), var(--navy2));
  border-top: 1px solid rgba(196,181,212,0.15);
  border-bottom: 1px solid rgba(196,181,212,0.15);
  overflow: hidden;
  padding: 10px 0;
}
.tsuki-ticker-inner {
  display: flex;
  white-space: nowrap;
  animation: ticker-scroll 28s linear infinite;
}
.tsuki-ticker-item {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  margin: 0 28px;
  font-family: 'Shippori Mincho', serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: rgba(196,181,212,0.6);
  text-decoration: none;
  transition: color 0.2s;
  flex-shrink: 0;
}
.tsuki-ticker-item.active { color: var(--lav2); }
.tsuki-ticker-sep {
  display: inline-block;
  width: 4px; height: 4px;
  border-radius: 50%;
  background: rgba(196,181,212,0.25);
  vertical-align: middle;
  flex-shrink: 0;
}

/* ═══════════════════════════════════
   BYOBU FOLDING SCREEN — LAYANAN
═══════════════════════════════════ */
.byobu-section {
  background: var(--navy2);
  position: relative;
  overflow: hidden;
}
.byobu-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 0;
}
@media(min-width: 768px) { .byobu-grid { grid-template-columns: repeat(3, 1fr); } }
@media(min-width: 1100px) { .byobu-grid { grid-template-columns: repeat(4, 1fr); } }

.byobu-panel {
  position: relative;
  overflow: hidden;
  min-height: 340px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  text-decoration: none;
  border-right: 1px solid rgba(196,181,212,0.08);
  border-bottom: 1px solid rgba(196,181,212,0.08);
  cursor: pointer;
  transition: flex 0.6s cubic-bezier(0.4,0,0.2,1);
}

/* Alternating panel tilt — folding screen effect */
.byobu-panel:nth-child(even) {
  background: linear-gradient(170deg, var(--navy3) 0%, var(--navy2) 100%);
}
.byobu-panel:nth-child(odd) {
  background: linear-gradient(190deg, var(--navy2) 0%, #0e2035 100%);
}

/* Fold shadow line on right edge */
.byobu-panel::before {
  content: '';
  position: absolute;
  top: 0; right: 0; bottom: 0;
  width: 3px;
  background: linear-gradient(180deg,
    transparent,
    rgba(196,181,212,0.12) 30%,
    rgba(245,240,255,0.2) 50%,
    rgba(196,181,212,0.12) 70%,
    transparent);
  z-index: 5;
  pointer-events: none;
}

/* Gold top strip */
.byobu-panel::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, var(--gold), var(--gold2), var(--gold), transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 5;
}
.byobu-panel:hover::after { opacity: 1; }

/* Panel image bg */
.byobu-bg {
  position: absolute; inset: 0;
  background-size: cover;
  background-position: center;
  transition: transform 0.7s cubic-bezier(0.4,0,0.2,1), filter 0.5s ease;
  filter: brightness(0.35) saturate(0.7);
}
.byobu-panel:hover .byobu-bg {
  transform: scale(1.08);
  filter: brightness(0.55) saturate(1.1);
}

/* Gradient fallbacks */
.byobu-grad-0 { background: linear-gradient(160deg, #1a1535, #2a2050, #1a1a35); }
.byobu-grad-1 { background: linear-gradient(160deg, #0f1a30, #1a2840, #0f2030); }
.byobu-grad-2 { background: linear-gradient(160deg, #1a1030, #251540, #1a1030); }
.byobu-grad-3 { background: linear-gradient(160deg, #0d2035, #152a45, #0d2035); }
.byobu-grad-4 { background: linear-gradient(160deg, #1a1238, #221848, #1a1238); }
.byobu-grad-5 { background: linear-gradient(160deg, #0f2230, #182d40, #0f2230); }

/* Seigaiha overlay on panels */
.byobu-seigaiha {
  position: absolute; inset: 0;
  background-image:
    radial-gradient(ellipse 20px 14px at 20px 14px, transparent 12px, rgba(196,181,212,0.04) 12px, rgba(196,181,212,0.04) 13px, transparent 13px),
    radial-gradient(ellipse 20px 14px at 0 14px, transparent 12px, rgba(196,181,212,0.04) 12px, rgba(196,181,212,0.04) 13px, transparent 13px);
  background-size: 20px 14px;
  opacity: 0.5;
  z-index: 1;
  transition: opacity 0.4s ease;
}
.byobu-panel:hover .byobu-seigaiha { opacity: 0; }

/* Panel content */
.byobu-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(6,12,22,0.97) 0%, rgba(13,27,42,0.7) 45%, transparent 100%);
  z-index: 2;
  transition: background 0.4s ease;
}
.byobu-panel:hover .byobu-overlay {
  background: linear-gradient(to top, rgba(6,12,22,0.99) 0%, rgba(13,27,42,0.82) 55%, rgba(196,181,212,0.05) 100%);
}

.byobu-body {
  position: relative;
  z-index: 3;
  padding: 20px 22px 24px;
}

/* Vertical kanji number */
.byobu-kanji-num {
  position: absolute;
  top: 16px;
  right: 16px;
  z-index: 3;
  font-family: 'Shippori Mincho', serif;
  font-size: 11px;
  font-weight: 600;
  writing-mode: vertical-rl;
  color: rgba(196,181,212,0.25);
  letter-spacing: 0.12em;
  transition: color 0.3s ease;
}
.byobu-panel:hover .byobu-kanji-num { color: rgba(196,181,212,0.55); }

.byobu-icon {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -60%);
  font-size: 40px;
  opacity: 0.2;
  z-index: 2;
  pointer-events: none;
  transition: opacity 0.35s ease, transform 0.4s ease;
}
.byobu-panel:hover .byobu-icon {
  opacity: 0;
  transform: translate(-50%, -80%);
}

/* Gold accent line */
.byobu-goldline {
  width: 0;
  height: 1px;
  background: linear-gradient(90deg, var(--gold), var(--lav));
  margin-bottom: 10px;
  transition: width 0.45s cubic-bezier(0.4,0,0.2,1);
}
.byobu-panel:hover .byobu-goldline { width: 36px; }

.byobu-panel-name {
  font-family: 'Shippori Mincho', serif;
  font-size: clamp(1rem, 1.5vw, 1.3rem);
  font-weight: 700;
  color: var(--silver);
  line-height: 1.3;
  margin-bottom: 8px;
  transition: color 0.25s ease;
}
.byobu-panel:hover .byobu-panel-name { color: var(--lav2); }

.byobu-count-chip {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: rgba(196,181,212,0.5);
  margin-bottom: 10px;
}
.byobu-count-chip::before {
  content: '';
  display: inline-block;
  width: 12px; height: 1px;
  background: var(--gold);
  opacity: 0.6;
}

/* Sub reveals */
.byobu-subs {
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transform: translateY(8px);
  transition: max-height 0.5s cubic-bezier(0.4,0,0.2,1), opacity 0.35s ease, transform 0.35s ease;
}
.byobu-panel:hover .byobu-subs { max-height: 200px; opacity: 1; transform: translateY(0); }

.byobu-sub-item {
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: 11.5px;
  color: rgba(196,181,212,0.5);
  padding: 3px 0;
  text-decoration: none;
  transition: color 0.15s ease;
  font-family: 'Zen Kaku Gothic New', sans-serif;
}
.byobu-sub-item:hover { color: var(--lav2); }
.byobu-sub-item::before {
  content: '·';
  color: var(--gold);
  opacity: 0.5;
  font-size: 16px;
  line-height: 1;
}

.byobu-cta {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 9.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.12em;
  color: var(--navy);
  background: linear-gradient(135deg, var(--gold2), var(--gold));
  border-radius: 2px;
  padding: 6px 14px;
  text-decoration: none;
  opacity: 0;
  transform: translateY(6px);
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.byobu-panel:hover .byobu-cta { opacity: 1; transform: translateY(0); }

/* Divider ornament */
.byobu-divider {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 12px 0;
}
.byobu-divider-line {
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(196,181,212,0.2), transparent);
}
.byobu-divider-kanji {
  font-family: 'Shippori Mincho', serif;
  font-size: 18px;
  color: rgba(196,181,212,0.2);
}

/* ═══════════════════════════════════
   TANZAKU SCROLL — PRODUK CARDS
═══════════════════════════════════ */
.tanzaku-section {
  background: linear-gradient(180deg, var(--navy) 0%, #080E1A 100%);
  position: relative;
  overflow: visible;
}

/* Per-category scroll row */
.tanzaku-row { margin-bottom: 48px; }
.tanzaku-row-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
  padding: 0 2px;
}
.tanzaku-row-title {
  font-family: 'Shippori Mincho', serif;
  font-size: clamp(1.1rem, 2vw, 1.4rem);
  font-weight: 700;
  color: var(--silver);
}
.tanzaku-row-line {
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, rgba(196,181,212,0.2), transparent);
}
.tanzaku-row-count {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.12em;
  color: rgba(196,181,212,0.35);
  text-transform: uppercase;
}

/* Horizontal scroll container */
.tanzaku-scroll-wrap {
  position: relative;
}
.tanzaku-scroll-wrap::before,
.tanzaku-scroll-wrap::after {
  content: '';
  position: absolute;
  top: 0; bottom: 0;
  width: 60px;
  z-index: 4;
  pointer-events: none;
}
.tanzaku-scroll-wrap::before {
  left: 0;
  background: linear-gradient(90deg, var(--navy), transparent);
}
.tanzaku-scroll-wrap::after {
  right: 0;
  background: linear-gradient(-90deg, #080E1A, transparent);
}

.tanzaku-scroll {
  display: flex;
  gap: 14px;
  overflow-x: auto;
  padding: 8px 4px 16px;
  scrollbar-width: none;
  scroll-behavior: smooth;
}
.tanzaku-scroll::-webkit-scrollbar { display: none; }

/* THE TANZAKU CARD — vertical scroll/poem paper */
.tanzaku-card {
  flex: 0 0 165px;
  height: 310px;
  border-radius: 6px 6px 40px 40px;
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  text-decoration: none;
  cursor: pointer;
  transition: transform 0.45s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.4s ease;
  /* Tanzaku paper texture */
  background: linear-gradient(180deg,
    #1a1430 0%,
    #14102a 40%,
    #0f0c22 100%);
  box-shadow:
    0 4px 20px rgba(0,0,0,0.4),
    inset 0 1px 0 rgba(196,181,212,0.1),
    inset 1px 0 0 rgba(196,181,212,0.05),
    inset -1px 0 0 rgba(196,181,212,0.05);
}
.tanzaku-card:hover {
  transform: translateY(-10px) rotate(-1deg);
  box-shadow:
    0 24px 60px rgba(0,0,0,0.6),
    0 8px 24px rgba(196,181,212,0.15),
    inset 0 1px 0 rgba(196,181,212,0.15);
}

/* String at top (like real tanzaku hanging from bamboo) */
.tanzaku-string {
  position: absolute;
  top: -20px;
  left: 50%;
  transform: translateX(-50%);
  width: 1.5px;
  height: 22px;
  background: linear-gradient(180deg, transparent, rgba(196,181,212,0.4));
  z-index: 10;
}

/* Top hole */
.tanzaku-hole {
  position: absolute;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  width: 8px; height: 8px;
  border-radius: 50%;
  border: 1px solid rgba(196,181,212,0.2);
  background: rgba(0,0,0,0.4);
  z-index: 6;
}

/* Gold border frame */
.tanzaku-frame {
  position: absolute;
  inset: 6px;
  border: 1px solid rgba(201,168,76,0.2);
  border-radius: 3px 3px 36px 36px;
  z-index: 2;
  pointer-events: none;
  transition: border-color 0.3s ease;
}
.tanzaku-card:hover .tanzaku-frame {
  border-color: rgba(201,168,76,0.5);
}

/* Product image */
.tanzaku-img-wrap {
  position: relative;
  height: 180px;
  overflow: hidden;
  flex-shrink: 0;
}
.tanzaku-img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.7s cubic-bezier(0.4,0,0.2,1), filter 0.5s ease;
  filter: brightness(0.75) saturate(0.85);
}
.tanzaku-card:hover .tanzaku-img {
  transform: scale(1.08);
  filter: brightness(0.9) saturate(1.1);
}
.tanzaku-img-ov {
  position: absolute; inset: 0;
  background: linear-gradient(to bottom, transparent 40%, rgba(10,8,28,0.8) 100%);
}

/* Category badge */
.tanzaku-badge {
  position: absolute;
  bottom: 8px; left: 50%;
  transform: translateX(-50%);
  font-size: 9px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--gold2);
  white-space: nowrap;
  background: rgba(10,8,28,0.8);
  padding: 3px 10px;
  border-radius: 2px;
  border: 1px solid rgba(201,168,76,0.25);
  backdrop-filter: blur(4px);
}

/* Content area */
.tanzaku-body {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 10px 10px 14px;
  text-align: center;
  position: relative;
  z-index: 3;
}

/* Vertical line ornament */
.tanzaku-body::before {
  content: '';
  position: absolute;
  top: 0; bottom: 0;
  left: 50%;
  width: 1px;
  background: linear-gradient(180deg, rgba(201,168,76,0.2), transparent);
  pointer-events: none;
}

.tanzaku-name {
  font-family: 'Shippori Mincho', serif;
  font-size: 12px;
  font-weight: 600;
  color: var(--lav2);
  line-height: 1.5;
  margin-bottom: 8px;

  display: -webkit-box;
  -webkit-box-orient: vertical;

  -webkit-line-clamp: 2; /* Chrome, Safari, Edge */
  line-clamp: 2;         /* Standard property */

  overflow: hidden;

  transition: color 0.25s ease;
}
.tanzaku-card:hover .tanzaku-name { color: var(--tsuki); }

.tanzaku-price {
  font-family: 'Shippori Mincho', serif;
  font-size: 15px;
  font-weight: 800;
  color: var(--gold2);
  margin-bottom: 10px;
}

/* Shimmer on hover */
.tanzaku-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(135deg, transparent 0%, rgba(196,181,212,0.04) 50%, transparent 100%);
  opacity: 0;
  transition: opacity 0.4s ease;
  pointer-events: none;
}
.tanzaku-card:hover .tanzaku-shimmer { opacity: 1; }

.tanzaku-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
  font-size: 9px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: var(--navy);
  background: linear-gradient(135deg, var(--gold2), var(--gold));
  border-radius: 2px;
  padding: 5px 12px;
  text-decoration: none;
  opacity: 0;
  transform: translateY(5px);
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.tanzaku-card:hover .tanzaku-btn { opacity: 1; transform: translateY(0); }

/* Nav buttons */
.tzk-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
  width: 36px; height: 36px;
  border-radius: 50%;
  border: 1px solid rgba(196,181,212,0.2);
  background: rgba(13,27,42,0.85);
  backdrop-filter: blur(8px);
  color: var(--lav);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 4px 16px rgba(0,0,0,0.4);
}
.tzk-nav:hover { background: rgba(196,181,212,0.15); border-color: rgba(196,181,212,0.4); }
.tzk-nav.l { left: 8px; }
.tzk-nav.r { right: 8px; }
.tzk-nav.hide { opacity:0; pointer-events:none; }

/* Progress bar */
.tzk-progress-track {
  height: 2px;
  background: rgba(196,181,212,0.1);
  border-radius: 2px;
  margin-top: 8px;
  overflow: hidden;
}
.tzk-progress-bar {
  height: 100%;
  background: linear-gradient(90deg, var(--gold), var(--lav));
  border-radius: 2px;
  width: 15%;
  transition: width 0.15s ease;
}

/* Section separator — washi tape style */
.washi-sep {
  display: flex;
  align-items: center;
  gap: 14px;
  margin: 4px 0 36px;
}
.washi-sep-line {
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(196,181,212,0.15), transparent);
}
.washi-sep-moon { font-size: 14px; opacity: 0.4; }

/* ═══════════════════════════════════
   FAQ & SIDEBAR
═══════════════════════════════════ */
.tsuki-faq-section {
  background: linear-gradient(180deg, #080E1A 0%, var(--navy) 100%);
  position: relative;
  overflow: hidden;
}

/* FAQ accordion */
.tsuki-faq-card {
  border: 1px solid rgba(196,181,212,0.1);
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 10px;
  background: rgba(13,27,42,0.5);
  transition: border-color 0.25s ease;
}
.tsuki-faq-card.open {
  border-color: rgba(196,181,212,0.25);
  background: rgba(30,58,95,0.3);
}
.tsuki-faq-trigger {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 18px;
  cursor: pointer;
  width: 100%;
  text-align: left;
}
.tsuki-faq-num {
  font-family: 'Shippori Mincho', serif;
  font-size: 16px;
  font-weight: 700;
  color: var(--gold);
  opacity: 0.6;
  flex-shrink: 0;
  transition: opacity 0.2s;
}
.tsuki-faq-card.open .tsuki-faq-num { opacity: 1; }
.tsuki-faq-q {
  flex: 1;
  font-size: 13.5px;
  font-weight: 500;
  color: var(--silver);
  line-height: 1.4;
}
.tsuki-faq-chevron {
  flex-shrink: 0;
  color: rgba(196,181,212,0.4);
  transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), color 0.2s;
}
.tsuki-faq-card.open .tsuki-faq-chevron {
  transform: rotate(180deg);
  color: var(--lav);
}
.tsuki-faq-body {
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transition: max-height 0.45s cubic-bezier(0.4,0,0.2,1), opacity 0.3s ease;
}
.tsuki-faq-body.open { max-height: 300px; opacity: 1; }
.tsuki-faq-answer {
  padding: 0 18px 16px 46px;
  font-size: 13px;
  line-height: 1.65;
  color: rgba(196,181,212,0.6);
  border-top: 1px solid rgba(196,181,212,0.06);
  padding-top: 12px;
  margin-top: 0;
}

/* Sidebar panels */
.tsuki-sidebar-panel {
  background: rgba(13,27,42,0.6);
  border: 1px solid rgba(196,181,212,0.1);
  border-radius: 12px;
  overflow: hidden;
  margin-bottom: 16px;
  backdrop-filter: blur(8px);
}
.tsuki-panel-header {
  padding: 14px 18px 12px;
  border-bottom: 1px solid rgba(196,181,212,0.08);
  display: flex;
  align-items: center;
  gap: 10px;
}
.tsuki-panel-title {
  font-family: 'Shippori Mincho', serif;
  font-size: 14px;
  font-weight: 700;
  color: var(--silver);
}
.tsuki-panel-icon { font-size: 16px; opacity: 0.6; }

/* Area pills */
.tsuki-area-pill {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 12px;
  border-radius: 3px;
  border: 1px solid rgba(196,181,212,0.12);
  font-size: 12px;
  font-weight: 500;
  color: rgba(196,181,212,0.5);
  text-decoration: none;
  transition: all 0.2s ease;
  background: transparent;
}
.tsuki-area-pill:hover, .tsuki-area-pill.active {
  border-color: rgba(196,181,212,0.35);
  color: var(--lav2);
  background: rgba(196,181,212,0.07);
}
.tsuki-area-pill.active {
  border-color: var(--gold);
  color: var(--gold2);
}

/* CTA box */
.tsuki-cta-box {
  background: linear-gradient(135deg, rgba(30,58,95,0.6), rgba(13,27,42,0.8));
  border: 1px solid rgba(196,181,212,0.15);
  border-radius: 12px;
  text-align: center;
  padding: 24px 20px;
  position: relative;
  overflow: hidden;
}
.tsuki-cta-box::before {
  content: '月';
  position: absolute;
  right: -10px;
  top: -20px;
  font-family: 'Shippori Mincho', serif;
  font-size: 100px;
  font-weight: 800;
  color: rgba(196,181,212,0.04);
  pointer-events: none;
}

/* Sidebar accordion */
.tsuki-acc-content { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
.tsuki-acc-content.open { max-height: 600px; }
.tsuki-acc-btn.open .tsuki-acc-chev { transform: rotate(180deg); }
.tsuki-acc-chev { transition: transform 0.25s ease; }

/* Section labels */
.tsuki-section-label {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.18em;
  color: rgba(196,181,212,0.5);
  margin-bottom: 20px;
}
.tsuki-section-label::before, .tsuki-section-label::after {
  content: '';
  width: 20px; height: 1px;
  background: linear-gradient(90deg, var(--gold), transparent);
  opacity: 0.5;
}

/* Utility */
.text-tsuki { color: var(--tsuki); }
.text-lav { color: var(--lav); }
.text-lav2 { color: var(--lav2); }
.text-gold { color: var(--gold); }
.text-gold2 { color: var(--gold2); }
.text-silver { color: var(--silver); }
.text-muted { color: rgba(196,181,212,0.45); }

.stat-moon {
  font-family: 'Shippori Mincho', serif;
  background: linear-gradient(135deg, var(--gold2), var(--lav2), var(--tsuki));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Info card */
.hero-info-card {
  background: rgba(13,27,42,0.7);
  border: 1px solid rgba(196,181,212,0.15);
  border-radius: 16px;
  backdrop-filter: blur(12px);
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}
.hero-info-row {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 18px;
  border-bottom: 1px solid rgba(196,181,212,0.06);
}
.hero-info-row:last-child { border-bottom: none; }
.hero-info-icon { font-size: 18px; flex-shrink: 0; }
.hero-info-label { font-size: 9.5px; text-transform: uppercase; letter-spacing: 0.12em; color: rgba(196,181,212,0.4); font-weight: 700; }
.hero-info-val { font-size: 14px; font-weight: 600; color: var(--silver); margin-top: 2px; }

/* WA button */
.btn-wa-moon {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-weight: 800;
  padding: 14px 28px;
  border-radius: 4px;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 14px;
  background: linear-gradient(135deg, var(--gold2), var(--gold));
  color: var(--navy);
  box-shadow: 0 8px 28px rgba(201,168,76,0.35);
}
.btn-wa-moon:hover {
  transform: translateY(-3px);
  box-shadow: 0 14px 40px rgba(201,168,76,0.5);
}
.btn-outline-moon {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-weight: 700;
  padding: 13px 24px;
  border-radius: 4px;
  text-decoration: none;
  border: 1px solid rgba(196,181,212,0.3);
  color: var(--lav2);
  transition: all 0.3s ease;
  font-size: 14px;
}
.btn-outline-moon:hover {
  background: rgba(196,181,212,0.08);
  border-color: rgba(196,181,212,0.5);
}

/* About section */
.tsuki-about {
  background: rgba(30,58,95,0.25);
  border: 1px solid rgba(196,181,212,0.1);
  border-radius: 12px;
  padding: 24px;
  position: relative;
  overflow: hidden;
}
.tsuki-about::after {
  content: '花';
  position: absolute;
  right: -8px; bottom: -24px;
  font-family: 'Shippori Mincho', serif;
  font-size: 100px;
  font-weight: 800;
  color: rgba(196,181,212,0.04);
  pointer-events: none;
}

/* Scrollbar for rail */
@media (max-width: 767px) {
  .byobu-grid { grid-template-columns: repeat(2, 1fr); }
  .tanzaku-card { flex: 0 0 148px; height: 280px; }
  .tanzaku-img-wrap { height: 155px; }
}
</style>

<?php
/* ── Helper: render fireflies ── */
function renderFireflies(int $n = 18): string {
    $inner = '';
    for ($i = 0; $i < $n; $i++) {
        $left = rand(3, 97);
        $top  = rand(10, 85);
        $dur  = rand(6, 14);
        $del  = rand(0, 10);
        $fx   = rand(-40, 40) . 'px';
        $fx2  = rand(-30, 30) . 'px';
        $inner .= "<div class=\"firefly\" style=\"left:{$left}%;top:{$top}%;--dur:{$dur}s;--del:{$del}s;--fx:{$fx};--fx2:{$fx2};\"></div>";
    }
    return "<div class=\"firefly-container\">{$inner}</div>";
}
?>


<!-- ════════════════════════════════════════
     HERO — UKIYO-E LAYERED MOONLIT SCENE
════════════════════════════════════════ -->
<section class="hero-tsukimi">

  <!-- Sky & atmosphere -->
  <div class="hero-sky"></div>
  <div class="star-field"></div>

  <!-- Moon -->
  <div class="ukiyo-moon"></div>

  <!-- Drifting clouds -->
  <div class="ukiyo-clouds">
    <div class="ukiyo-cloud-strip"></div>
    <div class="ukiyo-cloud-strip"></div>
  </div>

  <!-- Mountain silhouettes -->
  <div class="ukiyo-mtn-far"></div>
  <div class="ukiyo-mtn-near"></div>

  <!-- Bamboo left -->
  <div class="ukiyo-bamboo">
    <div class="bamboo-stalk" style="height:180px;--bs:7s;"></div>
    <div class="bamboo-stalk" style="height:130px;--bs:9s;animation-delay:1s;"></div>
    <div class="bamboo-stalk" style="height:210px;--bs:6s;animation-delay:2s;"></div>
    <div class="bamboo-stalk" style="height:100px;--bs:11s;animation-delay:0.5s;"></div>
  </div>

  <!-- Sakura tree right -->
  <div class="ukiyo-tree">
    <div style="position:relative;width:120px;height:180px;">
      <div class="tree-trunk" style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);"></div>
      <!-- Blossom clouds -->
      <div class="tree-blossom" style="width:90px;height:70px;top:10px;left:10px;"></div>
      <div class="tree-blossom" style="width:70px;height:55px;top:0;left:30px;background:radial-gradient(circle,rgba(255,183,197,0.4),rgba(220,160,180,0.15));"></div>
      <div class="tree-blossom" style="width:55px;height:45px;top:20px;left:5px;"></div>
      <div class="tree-blossom" style="width:45px;height:38px;top:30px;left:55px;"></div>
    </div>
  </div>

  <!-- Water foreground -->
  <div class="ukiyo-water">
    <div class="water-line" style="bottom:55%;opacity:0.5;"></div>
    <div class="water-line" style="bottom:40%;opacity:0.35;"></div>
    <div class="water-line" style="bottom:25%;opacity:0.2;"></div>
  </div>

  <!-- Fireflies -->
  <?= renderFireflies(20) ?>

  <!-- Kanji watermark -->
  <div class="kanji-watermark">月見花</div>

  <!-- CONTENT -->
  <div class="hero-content">
    <!-- Breadcrumb -->
    <div class="fade-up-1 flex items-center gap-2 mb-10" style="font-size:11px;font-weight:600;letter-spacing:0.16em;text-transform:uppercase;">
      <a href="<?= BASE_URL ?>/" style="color:rgba(196,181,212,0.4);" class="hover:text-[var(--lav)] transition">Beranda</a>
      <span style="color:rgba(196,181,212,0.2);">—</span>
      <a href="<?= BASE_URL ?>/#area" style="color:rgba(196,181,212,0.4);" class="hover:text-[var(--lav)] transition">Area</a>
      <span style="color:rgba(196,181,212,0.2);">—</span>
      <span style="color:var(--gold);"><?= e($location['name']) ?></span>
    </div>

    <div class="grid md:grid-cols-2 gap-14 items-center">
      <!-- Left: copy -->
      <div>
        <!-- Eyebrow badge -->
        <div class="fade-up-1 inline-flex items-center gap-2 mb-7" style="font-size:10px;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;color:var(--gold);border:1px solid rgba(201,168,76,0.3);padding:5px 14px;border-radius:2px;background:rgba(201,168,76,0.07);">
          <span style="width:5px;height:5px;border-radius:50%;background:var(--gold);display:inline-block;flex-shrink:0;animation:moon-pulse 3s infinite;"></span>
          📍 <?= e($location['name']) ?>, Grogol
        </div>

        <!-- Headline -->
        <h1 class="fade-up-2" style="font-family:'Shippori Mincho',serif;font-size:clamp(2.4rem,5.5vw,3.8rem);font-weight:800;color:var(--tsuki);line-height:1.15;margin-bottom:6px;">
          Toko Bunga
        </h1>
        <h1 class="fade-up-2" style="font-family:'Shippori Mincho',serif;font-size:clamp(2.4rem,5.5vw,3.8rem);font-weight:800;line-height:1.15;margin-bottom:24px;background:linear-gradient(135deg,var(--gold2),var(--lav2),var(--tsuki));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
          <?= e($location['name']) ?>
        </h1>

        <!-- Desc -->
        <p class="fade-up-3" style="font-size:16px;line-height:1.75;color:rgba(196,181,212,0.65);margin-bottom:28px;max-width:420px;">
          <?= !empty($location['meta_description']) ? e($location['meta_description']) : 'Florist ' . e($location['name']) . ' terpercaya — karangan bunga papan, hand bouquet, wedding & duka cita. Pengiriman cepat 2–4 jam ke seluruh ' . e($location['name']) . '.' ?>
        </p>

        <!-- Stats -->
        <div class="fade-up-3 flex items-center gap-7 mb-10">
          <div>
            <div class="stat-moon" style="font-size:2.2rem;font-weight:800;line-height:1;">10+</div>
            <div style="font-size:10px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:rgba(196,181,212,0.35);margin-top:3px;">Tahun</div>
          </div>
          <div style="width:1px;height:36px;background:rgba(196,181,212,0.15);"></div>
          <div>
            <div class="stat-moon" style="font-size:2.2rem;font-weight:800;line-height:1;">2–4<span style="font-size:1rem;">Jam</span></div>
            <div style="font-size:10px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:rgba(196,181,212,0.35);margin-top:3px;">Pengiriman</div>
          </div>
          <div style="width:1px;height:36px;background:rgba(196,181,212,0.15);"></div>
          <div>
            <div class="stat-moon" style="font-size:1.5rem;font-weight:800;line-height:1;"><?= 'Rp '.number_format($min_price/1000,0,',','.').'rb' ?></div>
            <div style="font-size:10px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:rgba(196,181,212,0.35);margin-top:3px;">Mulai dari</div>
          </div>
        </div>

        <!-- CTAs -->
        <div class="fade-up-4 flex flex-wrap gap-3">
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan bunga di ' . $location['name'] . ', Grogol.') ?>"
             target="_blank" class="btn-wa-moon">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Pesan Sekarang
          </a>
          <a href="tel:<?= e(setting('whatsapp_number')) ?>" class="btn-outline-moon">
            📞 <?= e(setting('phone_display')) ?>
          </a>
        </div>
      </div>

      <!-- Right: info card -->
      <div class="fade-up-4 hidden md:block">
        <div class="hero-info-card">
          <div style="padding:16px 18px 12px;border-bottom:1px solid rgba(196,181,212,0.08);">
            <p style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.18em;color:var(--gold);opacity:0.7;">Info Pengiriman 月見</p>
            <p style="font-family:'Shippori Mincho',serif;font-size:1.1rem;font-weight:700;color:var(--silver);margin-top:3px;"><?= e($location['name']) ?></p>
          </div>
          <div class="hero-info-row">
            <span class="hero-info-icon">📍</span>
            <div><div class="hero-info-label">Lokasi</div><div class="hero-info-val"><?= e($location['name']) ?>, Grogol</div></div>
          </div>
          <div class="hero-info-row">
            <span class="hero-info-icon">⚡</span>
            <div><div class="hero-info-label">Estimasi</div><div class="hero-info-val">2–4 Jam</div></div>
          </div>
          <div class="hero-info-row">
            <span class="hero-info-icon">⏰</span>
            <div><div class="hero-info-label">Operasional</div><div class="hero-info-val"><?= e(setting('jam_buka')) ?></div></div>
          </div>
          <div class="hero-info-row">
            <span class="hero-info-icon">💐</span>
            <div><div class="hero-info-label">Mulai dari</div><div style="font-family:'Shippori Mincho',serif;font-size:16px;font-weight:800;color:var(--gold2);margin-top:2px;"><?= rupiah($min_price) ?></div></div>
          </div>
          <div style="padding:16px 18px;">
            <a href="<?= e($wa_url) ?>" target="_blank" class="btn-wa-moon" style="width:100%;justify-content:center;">
              Chat WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ════ TICKER ════ -->
<div class="tsuki-ticker">
  <div class="tsuki-ticker-inner">
    <?php for ($r = 0; $r < 2; $r++): foreach ($locations as $l): ?>
    <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/" class="tsuki-ticker-item <?= $l['id'] == $location['id'] ? 'active' : '' ?>">
      <span class="tsuki-ticker-sep"></span>
      <?= e($l['name']) ?>
    </a>
    <?php endforeach; endfor; ?>
  </div>
</div>


<!-- ════════════════════════════════════════
     BYOBU FOLDING SCREEN — LAYANAN
════════════════════════════════════════ -->
<section class="byobu-section py-20">
  <div class="moon-line"></div>
  <?= renderFireflies(10) ?>

  <div class="relative z-10 max-w-7xl mx-auto px-4 mb-12">
    <div class="tsuki-section-label">Layanan di <?= e($location['name']) ?></div>
    <h2 style="font-family:'Shippori Mincho',serif;font-size:clamp(1.8rem,4vw,2.6rem);font-weight:800;color:var(--tsuki);line-height:1.2;margin-bottom:10px;">
      Layanan Bunga<br>
      <span style="background:linear-gradient(135deg,var(--gold2),var(--lav2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">屏風 — Byobu Florist</span>
    </h2>
    <p style="font-size:15px;color:rgba(196,181,212,0.5);max-width:500px;">Semua kebutuhan bunga tersedia dan siap dikirim ke <?= e($location['name']) ?></p>
  </div>

  <!-- Byobu Grid -->
  <div class="byobu-grid" style="max-width:1400px;margin:0 auto;">
    <?php
    $byobu_grads = ['byobu-grad-0','byobu-grad-1','byobu-grad-2','byobu-grad-3','byobu-grad-4','byobu-grad-5'];
    $jp_nums = ['一','二','三','四','五','六','七','八','九','十','十一','十二'];
    foreach ($all_cats as $i => $cat):
      $subs    = $all_cats_subs[$cat['id']] ?? [];
      $has_sub = !empty($subs);
      $has_img = !empty($cat['image']);
      $grad    = $byobu_grads[$i % count($byobu_grads)];
      $jpnum   = $jp_nums[$i % count($jp_nums)];
      $cat_url = BASE_URL . '/' . e($cat['slug']) . '/';
      $tag     = $has_sub ? 'div' : 'a';
      $href    = $has_sub ? '' : 'href="' . $cat_url . '"';
    ?>
    <<?= $tag ?> <?= $href ?> class="byobu-panel">
      <!-- Background -->
      <?php if ($has_img): ?>
      <div class="byobu-bg" style="background-image:url('<?= e(imgUrl($cat['image'], 'category')) ?>');"></div>
      <?php else: ?>
      <div class="byobu-bg <?= $grad ?>"></div>
      <?php endif; ?>
      <div class="byobu-seigaiha"></div>
      <div class="byobu-overlay"></div>

      <!-- Vertical kanji number -->
      <div class="byobu-kanji-num"><?= $jpnum ?></div>

      <!-- Icon for no-image -->
      <?php if (!$has_img && !empty($cat['icon'])): ?>
      <div class="byobu-icon"><?= e($cat['icon']) ?></div>
      <?php endif; ?>

      <!-- Content -->
      <div class="byobu-body">
        <div class="byobu-goldline"></div>
        <div class="byobu-count-chip">
          <?php if ($has_sub): ?>
          <?= count($subs) ?> Sub Layanan
          <?php else: ?>
          Lihat Produk
          <?php endif; ?>
        </div>
        <div class="byobu-panel-name"><?= e($cat['name']) ?></div>

        <?php if ($has_sub): ?>
        <div class="byobu-subs">
          <a href="<?= $cat_url ?>" class="byobu-sub-item" style="color:rgba(226,196,106,0.5);font-weight:700;" onclick="event.stopPropagation()">
            Semua <?= e($cat['name']) ?> →
          </a>
          <?php foreach (array_slice($subs, 0, 4) as $sub): ?>
          <a href="<?= BASE_URL ?>/<?= e($sub['slug']) ?>/" class="byobu-sub-item" onclick="event.stopPropagation()">
            <?= e($sub['name']) ?>
          </a>
          <?php endforeach; ?>
          <?php if (count($subs) > 4): ?>
          <span class="byobu-sub-item" style="color:rgba(196,181,212,0.25);font-style:italic;">+<?= count($subs) - 4 ?> lainnya</span>
          <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="byobu-subs">
          <?php if (!empty($cat['description'])): ?>
          <p style="font-size:11.5px;line-height:1.5;color:rgba(196,181,212,0.35);margin-bottom:10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= e($cat['description']) ?></p>
          <?php endif; ?>
          <a href="<?= $cat_url ?>" class="byobu-cta" onclick="event.stopPropagation()">
            Lihat Produk →
          </a>
        </div>
        <?php endif; ?>
      </div>
    </<?= $tag ?>>
    <?php endforeach; ?>
  </div>

  <div class="moon-line mt-0"></div>
</section>


<!-- ════════════════════════════════════════
     TANZAKU SCROLL — PRODUK PER KATEGORI
════════════════════════════════════════ -->
<section id="produk" class="tanzaku-section" style="padding:60px 0 100px;overflow:hidden;">
  <?= renderFireflies(14) ?>

  <div class="relative z-10 max-w-7xl mx-auto px-4">
    <!-- Section heading -->
    <div class="text-center mb-16">
      <div class="tsuki-section-label" style="justify-content:center;">短冊 Koleksi Bunga</div>
      <h2 style="font-family:'Shippori Mincho',serif;font-size:clamp(1.8rem,4vw,2.6rem);font-weight:800;color:var(--tsuki);margin-bottom:10px;">
        Koleksi <em style="font-style:italic;background:linear-gradient(135deg,var(--gold2),var(--lav2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;"><?= e($location['name']) ?></em>
      </h2>
      <p style="font-size:15px;color:rgba(196,181,212,0.45);max-width:420px;margin:0 auto;">Gulir kanan untuk melihat lebih banyak pilihan bunga indah</p>
    </div>

    <?php
    $moon_sep = ['🌙','✦','🌸','·','月','✧'];
    foreach ($cats_with_products as $ri => $row):
      $cat   = $row['cat'];
      $prods = $row['products'];
      $sid   = 'tzk-' . $cat['id'];
      $catUrl = BASE_URL . '/' . e($cat['slug']) . '/';
      $msep  = $moon_sep[$ri % count($moon_sep)];
    ?>
    <div class="tanzaku-row">
      <!-- Row header -->
      <div class="tanzaku-row-header">
        <h3 class="tanzaku-row-title"><?= e($cat['name']) ?></h3>
        <div class="tanzaku-row-line"></div>
        <span class="tanzaku-row-count"><?= count($prods) ?> produk</span>
        <a href="<?= $catUrl ?>" style="font-size:10px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gold);text-decoration:none;flex-shrink:0;opacity:0.7;transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">
          Lihat Semua →
        </a>
      </div>

      <!-- Scroll rail -->
      <div class="tanzaku-scroll-wrap" style="position:relative;">
        <button class="tzk-nav l hide" onclick="tzkNav('<?= $sid ?>',this,-1)">
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button class="tzk-nav r" onclick="tzkNav('<?= $sid ?>',this,1)">
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </button>

        <div id="<?= $sid ?>" class="tanzaku-scroll" onscroll="tzkScrollEvt(this,'<?= $sid ?>-bar')">
          <?php foreach ($prods as $prod):
            $img   = imgUrl($prod['image'], 'product');
            $wamsg = urlencode("Halo, saya tertarik memesan *{$prod['name']}* untuk dikirim ke {$location['name']}. Apakah tersedia?");
          ?>
          <a href="<?= e($wa_url) ?>?text=<?= $wamsg ?>" target="_blank" class="tanzaku-card">
            <!-- String ornament -->
            <div class="tanzaku-string"></div>
            <div class="tanzaku-hole"></div>
            <div class="tanzaku-frame"></div>
            <div class="tanzaku-shimmer"></div>

            <!-- Image -->
            <div class="tanzaku-img-wrap">
              <img src="<?= e($img) ?>" alt="<?= e($prod['name']) ?>" class="tanzaku-img" loading="lazy">
              <div class="tanzaku-img-ov"></div>
              <div class="tanzaku-badge"><?= e($cat['name']) ?></div>
            </div>

            <!-- Body -->
            <div class="tanzaku-body">
              <div class="tanzaku-name"><?= e($prod['name']) ?></div>
              <div class="tanzaku-price"><?= rupiah($prod['price']) ?></div>
              <div class="tanzaku-btn">
                <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                Pesan WA
              </div>
            </div>
          </a>
          <?php endforeach; ?>
        </div>

        <div class="tzk-progress-track">
          <div id="<?= $sid ?>-bar" class="tzk-progress-bar"></div>
        </div>
      </div>
    </div>

    <?php if ($ri < count($cats_with_products) - 1): ?>
    <div class="washi-sep">
      <div class="washi-sep-line"></div>
      <span class="washi-sep-moon"><?= $msep ?></span>
      <div class="washi-sep-line"></div>
    </div>
    <?php endif; ?>

    <?php endforeach; ?>
  </div>
</section>


<!-- ════════════════════════════════════════
     FAQ + SIDEBAR — TSUKIMI STYLE
════════════════════════════════════════ -->
<section class="tsuki-faq-section" style="padding:120px 0 80px;">
  <?= renderFireflies(8) ?>

  <div class="relative z-10 max-w-7xl mx-auto px-4">
    <div class="grid md:grid-cols-5 gap-12">

      <!-- Left: About + FAQ (3 cols) -->
      <div class="md:col-span-3 space-y-8">

        <!-- About -->
        <div>
          <div class="tsuki-section-label">Tentang Kami</div>
          <h2 style="font-family:'Shippori Mincho',serif;font-size:clamp(1.5rem,3vw,2rem);font-weight:800;color:var(--tsuki);line-height:1.25;margin-bottom:16px;">
            Toko Bunga <?= e($location['name']) ?><br>
            <span style="background:linear-gradient(135deg,var(--gold2),var(--lav2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Terpercaya & Berpengalaman</span>
          </h2>
        </div>

        <div class="tsuki-about">
          <?php if (!empty($location['content'])): ?>
          <div style="font-size:15px;line-height:1.75;color:rgba(196,181,212,0.6);margin-bottom:14px;"><?= $location['content'] ?></div>
          <?php endif; ?>
          <p style="font-size:15px;line-height:1.75;color:rgba(196,181,212,0.55);">
            Sebagai <strong style="color:var(--lav2);">toko bunga <?= e(strtolower($location['name'])) ?></strong> yang telah melayani lebih dari 10 tahun, kami memahami setiap momen memerlukan rangkaian bunga yang tepat. Tim florist profesional siap membantu 24 jam setiap hari.
          </p>
          <div style="margin-top:20px;">
            <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan bunga di ' . $location['name'] . '.') ?>"
               target="_blank" class="btn-wa-moon">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
              Pesan via WhatsApp
            </a>
          </div>
        </div>

        <!-- FAQ -->
        <?php if (!empty($faqs)): ?>
        <div>
          <div class="tsuki-section-label">よくある質問 — FAQ</div>
          <?php foreach ($faqs as $i => $faq): ?>
          <div class="tsuki-faq-card <?= $i === 0 ? 'open' : '' ?>" onclick="toggleTsukiFaq(this)">
            <div class="tsuki-faq-trigger">
              <span class="tsuki-faq-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
              <span class="tsuki-faq-q"><?= e($faq['question']) ?></span>
              <svg class="tsuki-faq-chevron w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>
            <div class="tsuki-faq-body <?= $i === 0 ? 'open' : '' ?>">
              <p class="tsuki-faq-answer"><?= e($faq['answer']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Right: Sidebar (2 cols) -->
      <div class="md:col-span-2 space-y-4">

        <!-- CTA Box -->
        <div class="tsuki-cta-box">
          <div style="font-size:2.5rem;margin-bottom:10px;">🌙</div>
          <p style="font-family:'Shippori Mincho',serif;font-size:1.1rem;font-weight:700;color:var(--silver);margin-bottom:4px;">Siap Pesan Sekarang?</p>
          <p style="font-size:13px;color:rgba(196,181,212,0.45);margin-bottom:18px;">Respon dalam hitungan menit — 24 jam</p>
          <a href="<?= e($wa_url) ?>" target="_blank" class="btn-wa-moon" style="width:100%;justify-content:center;">
            Chat WhatsApp
          </a>
        </div>

        <!-- Info Card -->
        <div class="tsuki-sidebar-panel">
          <div class="tsuki-panel-header">
            <span class="tsuki-panel-icon">📍</span>
            <span class="tsuki-panel-title">Info Toko</span>
          </div>
          <div style="padding:12px 18px;font-size:13px;line-height:1.8;color:rgba(196,181,212,0.55);">
            <div>📍 <?= e($location['name']) ?>, Grogol</div>
            <div>⏰ <?= e(setting('jam_buka')) ?></div>
            <div>📞 <?= e(setting('phone_display')) ?></div>
            <div>💐 Mulai <?= rupiah($min_price) ?></div>
          </div>
        </div>

        <!-- Area lainnya -->
        <div class="tsuki-sidebar-panel">
          <div class="tsuki-panel-header">
            <span class="tsuki-panel-icon">🗾</span>
            <span class="tsuki-panel-title">Area Lainnya</span>
          </div>
          <div style="padding:12px 16px 14px;display:flex;flex-wrap:wrap;gap:7px;">
            <?php foreach ($locations as $l): ?>
            <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/"
               class="tsuki-area-pill <?= $l['id'] == $location['id'] ? 'active' : '' ?>">
              <span style="width:5px;height:5px;border-radius:50%;background:<?= $l['id'] == $location['id'] ? 'var(--gold)' : 'rgba(196,181,212,0.25)' ?>;display:inline-block;flex-shrink:0;"></span>
              <?= e($l['name']) ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Layanan accordion -->
        <div class="tsuki-sidebar-panel">
          <div class="tsuki-panel-header">
            <span class="tsuki-panel-icon">🌸</span>
            <span class="tsuki-panel-title">Layanan Kami</span>
          </div>
          <div style="padding:8px 10px 10px;">
            <?php foreach ($all_cats as $c):
              $c_subs  = $all_cats_subs[$c['id']] ?? [];
              $has_sub = !empty($c_subs);
            ?>
            <?php if ($has_sub): ?>
            <div style="margin-bottom:2px;">
              <button onclick="toggleTsukiAcc(this)" class="tsuki-acc-btn w-full flex items-center justify-between px-3 py-2.5 rounded-lg" style="background:transparent;border:none;cursor:pointer;text-align:left;">
                <span style="font-size:13px;font-weight:500;color:rgba(196,181,212,0.55);"><?= e($c['name']) ?></span>
                <svg class="tsuki-acc-chev w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:rgba(196,181,212,0.25);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>
              <div class="tsuki-acc-content pl-3 ml-3" style="border-left:1px solid rgba(201,168,76,0.2);">
                <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" style="display:block;padding:5px 10px;font-size:11px;font-weight:700;color:rgba(201,168,76,0.5);text-decoration:none;">Lihat semua →</a>
                <?php foreach ($c_subs as $sub): ?>
                <a href="<?= BASE_URL ?>/<?= e($sub['slug']) ?>/" style="display:flex;align-items:center;gap:6px;padding:5px 10px;font-size:12px;color:rgba(196,181,212,0.4);text-decoration:none;transition:color 0.15s;" onmouseover="this.style.color='rgba(196,181,212,0.75)'" onmouseout="this.style.color='rgba(196,181,212,0.4)'">
                  <span style="width:3px;height:3px;border-radius:50%;background:rgba(201,168,76,0.4);flex-shrink:0;display:inline-block;"></span>
                  <?= e($sub['name']) ?>
                </a>
                <?php endforeach; ?>
              </div>
            </div>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;border-radius:8px;text-decoration:none;color:rgba(196,181,212,0.5);font-size:13px;font-weight:500;transition:color 0.15s,background 0.15s;" onmouseover="this.style.color='rgba(196,181,212,0.8)';this.style.background='rgba(196,181,212,0.05)'" onmouseout="this.style.color='rgba(196,181,212,0.5)';this.style.background='transparent'">
              <span><?= e($c['name']) ?></span>
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:rgba(196,181,212,0.2);flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="moon-line" style="margin-top:60px;"></div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
/* ── FAQ toggle ── */
function toggleTsukiFaq(card) {
  const body = card.querySelector('.tsuki-faq-body');
  const isOpen = card.classList.contains('open');
  document.querySelectorAll('.tsuki-faq-card.open').forEach(c => {
    c.classList.remove('open');
    c.querySelector('.tsuki-faq-body').classList.remove('open');
  });
  if (!isOpen) { card.classList.add('open'); body.classList.add('open'); }
}

/* ── Sidebar accordion ── */
function toggleTsukiAcc(btn) {
  const content = btn.nextElementSibling;
  const isOpen = content.classList.contains('open');
  document.querySelectorAll('.tsuki-acc-content.open').forEach(el => el.classList.remove('open'));
  document.querySelectorAll('.tsuki-acc-btn.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) { btn.classList.add('open'); content.classList.add('open'); }
}

/* ── Tanzaku scroll navigation ── */
function tzkNav(sid, btn, dir) {
  const el = document.getElementById(sid);
  if (!el) return;
  el.scrollBy({ left: dir * 560, behavior: 'smooth' });
  setTimeout(() => tzkScrollEvt(el, sid + '-bar'), 350);
}
function tzkScrollEvt(el, barId) {
  const bar  = document.getElementById(barId);
  const maxS = el.scrollWidth - el.clientWidth;
  const pct  = maxS > 0 ? (el.scrollLeft / maxS) * 72 + 12 : 12;
  if (bar) bar.style.width = pct + '%';
  const wrap = el.closest('.tanzaku-scroll-wrap');
  if (!wrap) return;
  const navL = wrap.querySelector('.tzk-nav.l');
  const navR = wrap.querySelector('.tzk-nav.r');
  if (navL) navL.classList.toggle('hide', el.scrollLeft < 20);
  if (navR) navR.classList.toggle('hide', el.scrollLeft >= maxS - 20);
}
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.tanzaku-scroll').forEach(el => tzkScrollEvt(el, el.id + '-bar'));
});
</script>