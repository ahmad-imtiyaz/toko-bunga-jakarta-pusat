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
$locations = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url    = setting('whatsapp_url');

$product_count = count($products);
$min_price     = !empty($products) ? min(array_column($products, 'price')) : 300000;

require __DIR__ . '/../includes/header.php';
?>

<style>
/* ═══════════════════════════════════════════════════════
   HANA-MATSURI · Toko Bunga Jakarta Pusat
   Tema: Festival Obon — Terang, Festif, Penuh Bunga
   Warna: Putih Washi · Oranye Matsuri · Marun Hanko
═══════════════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;500&family=Zen+Kaku+Gothic+New:wght@300;400;500&family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&display=swap');

:root {
  /* Warna utama */
  --washi:      #FDFAF5;
  --washi-warm: #FAF3E8;
  --tatami:     #F0E8D8;
  --tatami-dk:  #E0D4BC;

  /* Oranye Matsuri */
  --matsu:      #E8621A;
  --matsu-lt:   #F5894A;
  --matsu-pale: #FDE8D8;
  --matsu-glow: rgba(232,98,26,.12);

  /* Marun Hanko */
  --hanko:      #8B1A1A;
  --hanko-lt:   #B02A2A;
  --hanko-pale: #F5E0E0;

  /* Aksen Gold */
  --gold:       #C8921A;
  --gold-lt:    #E8B84A;
  --gold-pale:  #FDF2D8;

  /* Hijau Daun */
  --leaf:       #6B8A52;
  --leaf-lt:    #8BAA6E;
  --leaf-pale:  #EBF2E4;

  /* Netral */
  --ink:        #2A1A0E;
  --ink-60:     rgba(42,26,14,.6);
  --ink-40:     rgba(42,26,14,.4);
  --ink-20:     rgba(42,26,14,.2);
  --ink-10:     rgba(42,26,14,.1);

  --shadow-sm:  0 2px 8px rgba(42,26,14,.08);
  --shadow-md:  0 6px 24px rgba(42,26,14,.12);
  --shadow-lg:  0 16px 48px rgba(42,26,14,.16);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ── Washi texture overlay ── */
.washi-tex {
  position: relative;
}
.washi-tex::before {
  content: '';
  position: absolute; inset: 0; z-index: 0; pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
  opacity: .028;
  mix-blend-mode: multiply;
}

/* ── Tatami grid subtle ── */
.tatami-grid {
  background-image:
    repeating-linear-gradient(0deg,  transparent 0, transparent 47px, var(--ink-10) 47px, var(--ink-10) 48px),
    repeating-linear-gradient(90deg, transparent 0, transparent 47px, var(--ink-10) 47px, var(--ink-10) 48px);
}

/* ── Animasi ── */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes petalFall {
  0%   { transform: translateY(-20px) rotate(0deg)   translateX(0);      opacity: 0; }
  10%  { opacity: .7; }
  90%  { opacity: .5; }
  100% { transform: translateY(110vh) rotate(720deg) translateX(60px);   opacity: 0; }
}
@keyframes lanternSway {
  0%, 100% { transform: rotate(-3deg); }
  50%       { transform: rotate(3deg); }
}
@keyframes shimmer {
  0%   { background-position: -200% center; }
  100% { background-position: 200% center; }
}
@keyframes tickerRoll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
@keyframes pulseRing {
  0%   { transform: scale(1);    opacity: .6; }
  100% { transform: scale(1.8);  opacity: 0; }
}
@keyframes kumoScroll1 { from { transform: translateX(0); }    to { transform: translateX(-50%); } }
@keyframes kumoScroll2 { from { transform: translateX(-50%); } to { transform: translateX(0); } }
@keyframes kanjiDrift {
  0%,100% { transform: translateY(0)   rotate(0deg);   opacity: .04; }
  50%      { transform: translateY(-18px) rotate(.8deg); opacity: .07; }
}
@keyframes emberUp {
  0%   { transform: translateY(0) scale(1);   opacity: .9; }
  100% { transform: translateY(-80px) scale(0); opacity: 0; }
}

.reveal { animation: fadeUp .6s ease both; }
.rv1 { animation-delay: .05s; }
.rv2 { animation-delay: .15s; }
.rv3 { animation-delay: .25s; }
.rv4 { animation-delay: .38s; }
.rv5 { animation-delay: .52s; }

/* ─────────────────────────────
   HERO SECTION
───────────────────────────── */
.hero-wrap {
  position: relative;
  min-height: 560px;
  background: linear-gradient(135deg, #FDFAF5 0%, #FAF0E0 40%, #F5E8D0 100%);
  overflow: hidden;
  padding-top: 90px;
}

/* Bunga SVG dekoratif pojok */
.hero-floral-deco {
  position: absolute;
  pointer-events: none;
  z-index: 0;
}

/* Petal jatuh */
.petal {
  position: absolute;
  width: 10px; height: 14px;
  border-radius: 80% 20% 80% 20%;
  pointer-events: none;
  animation: petalFall linear infinite;
  z-index: 1;
}

/* Kanji dekoratif besar */
.kanji-bg {
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-weight: 200;
  writing-mode: vertical-rl;
  pointer-events: none;
  animation: kanjiDrift ease-in-out infinite;
  z-index: 0;
  user-select: none;
}

/* Strip judul hero */
.hero-category-badge {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 6px 18px 6px 12px;
  background: var(--hanko-pale);
  border: 1px solid rgba(139,26,26,.2);
  border-left: 4px solid var(--hanko);
  border-radius: 2px;
  margin-bottom: 18px;
}

/* Stat card hero */
.hero-stat {
  background: rgba(255,255,255,.9);
  border: 1px solid var(--ink-10);
  border-radius: 8px;
  padding: 14px 18px;
  backdrop-filter: blur(8px);
  box-shadow: var(--shadow-sm);
  text-align: center;
  transition: transform .25s ease;
}
.hero-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }

/* CTA tombol */
.btn-matsuri {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 14px 28px;
  background: linear-gradient(135deg, var(--hanko), var(--hanko-lt));
  color: #fff;
  border-radius: 4px;
  text-decoration: none;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 14px;
  font-weight: 400;
  letter-spacing: .04em;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 16px rgba(139,26,26,.3);
  transition: all .3s ease;
  position: relative;
  overflow: hidden;
}
.btn-matsuri::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.15) 50%, transparent 100%);
  background-size: 200% auto;
  animation: shimmer 3s linear infinite;
}
.btn-matsuri:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 28px rgba(139,26,26,.4);
  color: #fff;
}
.btn-outline-matsuri {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 13px 22px;
  border: 2px solid var(--matsu);
  color: var(--matsu);
  border-radius: 4px;
  text-decoration: none;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 14px;
  font-weight: 400;
  letter-spacing: .04em;
  transition: all .3s ease;
  background: transparent;
}
.btn-outline-matsuri:hover {
  background: var(--matsu);
  color: #fff;
  transform: translateY(-2px);
}

/* ─────────────────────────────
   KUMO CSS DIVIDER (terang)
───────────────────────────── */
.kumo-divider {
  position: relative;
  height: 80px;
  overflow: hidden;
  pointer-events: none;
}
.kumo-divider svg {
  position: absolute;
  bottom: 0; left: 0;
  width: 200%; height: 100%;
}

/* ─────────────────────────────
   TICKER BUNGA
───────────────────────────── */
.hana-ticker {
  background: var(--hanko);
  overflow: hidden;
  padding: 10px 0;
  position: relative;
}
.hana-ticker-inner {
  display: flex;
  white-space: nowrap;
  animation: tickerRoll 20s linear infinite;
}
.ticker-item {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  margin: 0 24px;
  font-family: 'Noto Serif JP', serif;
  font-size: 11px;
  font-weight: 200;
  letter-spacing: .3em;
  text-transform: uppercase;
  color: rgba(255,255,255,.75);
  text-decoration: none;
  flex-shrink: 0;
  transition: color .2s;
}
.ticker-item:hover { color: #fff; }
.ticker-dot {
  width: 4px; height: 4px;
  border-radius: 50%;
  background: rgba(255,255,255,.4);
  flex-shrink: 0;
}

/* ─────────────────────────────
   LAYOUT UTAMA
───────────────────────────── */
.page-body {
  background: var(--washi);
  padding: 56px 0 80px;
}
.page-container {
  max-width: 1280px;
  margin: 0 auto;
  padding: 0 24px;
}
.page-grid {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 40px;
  align-items: start;
}

/* ─────────────────────────────
   SIDEBAR
───────────────────────────── */
.sidebar {
  position: sticky;
  top: 100px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

/* Panel sidebar */
.sidebar-panel {
  background: #fff;
  border: 1px solid var(--ink-10);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}
.sidebar-panel-head {
  padding: 14px 18px;
  background: linear-gradient(135deg, var(--hanko), var(--hanko-lt));
  display: flex;
  align-items: center;
  gap: 10px;
}
.sidebar-panel-head span {
  font-family: 'Noto Serif JP', serif;
  font-size: 11px;
  font-weight: 200;
  letter-spacing: .25em;
  text-transform: uppercase;
  color: rgba(255,255,255,.85);
}
.sidebar-panel-body { padding: 12px; }

/* Nav link sidebar */
.snav-link {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 11px 14px;
  border-radius: 6px;
  text-decoration: none;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 15px;
  font-weight: 300;
  color: var(--ink-60);
  border: 1px solid transparent;
  transition: all .2s ease;
  margin-bottom: 2px;
}
.snav-link:hover {
  color: var(--hanko);
  background: var(--hanko-pale);
  border-color: rgba(139,26,26,.12);
  padding-left: 18px;
}
.snav-link.active {
  color: var(--hanko);
  background: var(--hanko-pale);
  border-color: rgba(139,26,26,.2);
  font-weight: 500;
}
.snav-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--hanko);
  flex-shrink: 0;
}

/* Acc sidebar */
.sacc-btn {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  text-align: left;
  padding: 11px 14px;
  border-radius: 6px;
  background: transparent;
  border: 1px solid transparent;
  cursor: pointer;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 15px;
  font-weight: 300;
  color: var(--ink-60);
  transition: all .2s ease;
  margin-bottom: 2px;
}
.sacc-btn:hover, .sacc-btn.open {
  color: var(--hanko);
  background: var(--hanko-pale);
}
.sacc-btn .chevron { transition: transform .3s ease; }
.sacc-btn.open .chevron { transform: rotate(180deg); }
.sacc-body {
  max-height: 0;
  overflow: hidden;
  transition: max-height .35s ease;
  padding-left: 12px;
  border-left: 2px solid rgba(139,26,26,.1);
  margin: 0 0 4px 12px;
}
.sacc-body.open { max-height: 400px; }

/* Panel CTA WA */
.sidebar-wa {
  background: linear-gradient(135deg, #F5FFF7, #E8F8EB);
  border: 1px solid rgba(45,106,50,.2);
  border-radius: 8px;
  padding: 22px;
  text-align: center;
  box-shadow: var(--shadow-sm);
}
.lantern-icon {
  font-size: 36px;
  display: block;
  margin-bottom: 12px;
  animation: lanternSway 4s ease-in-out infinite;
  transform-origin: top center;
}

/* ─────────────────────────────
   PRODUK MASONRY BENTO
───────────────────────────── */
.prod-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 28px;
  padding-bottom: 20px;
  border-bottom: 2px solid var(--tatami);
  flex-wrap: wrap;
}

/* Dekorasi judul produk */
.prod-title-deco {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 8px;
}
.prod-title-deco::before, .prod-title-deco::after {
  content: '';
  flex: 1;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--matsu-lt), transparent);
  max-width: 60px;
}

/* ── Grid produk seragam 3 kolom ── */
.prod-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

/* Kartu produk seragam */
.prod-card {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  background: #fff;
  box-shadow: var(--shadow-sm);
  border: 1px solid var(--ink-10);
  cursor: pointer;
  transition: transform .35s cubic-bezier(.25,.46,.45,.94), box-shadow .35s ease;
  display: flex;
  flex-direction: column;
  text-decoration: none;
}
.prod-card:hover {
  transform: translateY(-7px);
  box-shadow: 0 20px 48px rgba(42,26,14,.15), 0 0 0 2px rgba(232,98,26,.18);
}

/* Area foto — rasio konsisten 4:3 */
.prod-card-img-wrap {
  position: relative;
  width: 100%;
  padding-top: 75%; /* 4:3 ratio */
  overflow: hidden;
  background: var(--tatami);
  flex-shrink: 0;
}
.prod-card-img {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .7s cubic-bezier(.25,.46,.45,.94);
}
.prod-card:hover .prod-card-img { transform: scale(1.07); }

/* Label kategori di atas foto */
.prod-card-label {
  position: absolute;
  top: 12px; left: 12px;
  padding: 5px 12px;
  background: rgba(255,255,255,.94);
  border-radius: 4px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 11px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--hanko);
  z-index: 4;
  backdrop-filter: blur(6px);
  border: 1px solid rgba(139,26,26,.15);
}

/* Hanko stamp pojok kanan atas */
.prod-hanko {
  position: absolute;
  top: 10px; right: 10px;
  width: 36px; height: 36px;
  border-radius: 5px;
  background: var(--hanko);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Noto Serif JP', serif;
  font-size: 14px;
  font-weight: 300;
  color: rgba(255,255,255,.9);
  writing-mode: vertical-rl;
  z-index: 4;
  box-shadow: 0 2px 10px rgba(0,0,0,.25);
  border: 1px solid rgba(255,255,255,.2);
  transition: transform .3s ease;
}
.prod-card:hover .prod-hanko { transform: rotate(7deg) scale(1.1); }

/* Info konten di BAWAH foto (bukan overlay) */
.prod-card-info {
  padding: 18px 18px 20px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  flex: 1;
  background: #fff;
  border-top: 2px solid var(--tatami);
  justify-content: flex-start;
}

.prod-card-name {
  font-family: 'Noto Serif JP', serif;
  font-weight: 400;
  font-size: 16px;
  line-height: 1.45;
  color: var(--ink);

  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;

  min-height: 46px;
}
.prod-card-price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 500;
  color: var(--hanko);
  line-height: 1;

  margin-top: auto; 
  padding-top: 8px;
}



/* Tombol pesan — selalu tampil, bukan hide */
.prod-card-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 11px 16px;
  background: linear-gradient(135deg, var(--hanko), var(--hanko-lt));
  color: #fff;
  border-radius: 6px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 13px;
  font-weight: 500;
  letter-spacing: .04em;
  text-decoration: none;
  border: none;
  transition: all .25s ease;
  margin-top: auto;
  box-shadow: 0 3px 10px rgba(139,26,26,.2);
}
.prod-card-btn:hover {
  background: linear-gradient(135deg, var(--hanko-lt), var(--matsu));
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(139,26,26,.3);
  color: #fff;
}

/* Empty state */
.empty-state {
  text-align: center;
  padding: 80px 20px;
  background: #fff;
  border-radius: 12px;
  border: 2px dashed var(--tatami-dk);
}

/* ─────────────────────────────
   SEO SECTION — Tatami Festif
───────────────────────────── */
.seo-section {
  background: var(--washi-warm);
  position: relative;
  overflow: hidden;
}

/* Lentera dekoratif seo */
.seo-lantern {
  position: absolute;
  pointer-events: none;
  animation: lanternSway ease-in-out infinite;
  transform-origin: top center;
  z-index: 0;
}

/* Info card */
.seo-info-card {
  background: #fff;
  border: 1px solid var(--ink-10);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}
.seo-info-head {
  padding: 14px 20px;
  background: linear-gradient(135deg, var(--matsu-pale), var(--gold-pale));
  border-bottom: 1px solid var(--tatami);
  display: flex;
  align-items: center;
  gap: 10px;
}
.seo-info-body { padding: 18px 20px; }

/* Keunggulan */
.unggulan-row {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 13px 16px;
  border-radius: 8px;
  border: 1px solid var(--ink-10);
  background: #fff;
  border-left: 3px solid var(--matsu);
  box-shadow: var(--shadow-sm);
  transition: transform .2s ease, box-shadow .2s ease;
}
.unggulan-row:hover {
  transform: translateX(4px);
  box-shadow: var(--shadow-md);
}
.unggulan-icon {
  width: 32px; height: 32px;
  border-radius: 50%;
  background: var(--matsu-pale);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  font-size: 15px;
}

/* Info row */
.info-row-seo {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
  padding: 9px 0;
  border-bottom: 1px solid var(--tatami);
}
.info-row-seo:last-child { border-bottom: none; }

/* Area pill */
.area-pill {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 5px 11px;
  border-radius: 20px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 11px;
  font-weight: 300;
  border: 1px solid rgba(232,98,26,.25);
  color: var(--matsu);
  text-decoration: none;
  background: var(--matsu-pale);
  transition: all .2s ease;
}
.area-pill:hover {
  background: var(--matsu);
  color: #fff;
  border-color: var(--matsu);
  transform: translateY(-2px);
}

/* ─────────────────────────────
   KUMO SECTION DIVIDER (Terang)
───────────────────────────── */
.kumo-light-wrap {
  position: relative;
  height: 70px;
  overflow: hidden;
  pointer-events: none;
}
.kumo-light-wrap svg {
  position: absolute;
  bottom: 0; left: 0;
  width: 200%; height: 100%;
}
/* tambahan patal */
.petal {
  position: absolute;
  top: -20px;
  opacity: 0.5;
  border-radius: 50%;
}

/* Responsive */
@media (max-width: 1023px) {
  .page-grid { grid-template-columns: 1fr; }
  .sidebar   { display: none; }
  .seo-grid  { grid-template-columns: 1fr !important; }
  .prod-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .prod-grid { grid-template-columns: 1fr; }
}
</style>

<!-- ════════════════════════════════════════
     PETAL JATUH (dekoratif background)
════════════════════════════════════════ -->
<div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:9999;">
  <?php
  $petal_colors = ['#E8621A','#F5894A','#FDE8D8','#8B1A1A','#FFD4A8','#F5C0A0'];
  for ($i = 0; $i < 10; $i++):
    $left  = rand(2, 98);
    $delay = rand(0, 18);
    $dur   = rand(12, 22);
    $size  = rand(7, 13);
    $col   = $petal_colors[array_rand($petal_colors)];
    $rot   = rand(-30, 30);
  ?>
  <div class="petal"
     style="
       left: <?= $left ?>%;
       width: <?= $size ?>px;
       height: <?= round($size*1.4) ?>px;
       background: <?= $col ?>;
       animation-delay: <?= $delay ?>s;
       animation-duration: <?= $dur ?>s;
       transform: rotate(<?= $rot ?>deg);
     ">
     
</div>

  <?php endfor; ?>
</div>

<!-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ -->
<section class="hero-wrap washi-tex">

  <!-- Kanji dekoratif besar -->
  <span class="kanji-bg" style="font-size:280px;top:-20px;right:5%;color:rgba(232,98,26,.06);animation-duration:16s;">花</span>
  <span class="kanji-bg" style="font-size:180px;top:15%;left:2%;color:rgba(139,26,26,.04);animation-duration:20s;animation-delay:3s;">祭</span>
  <span class="kanji-bg" style="font-size:140px;bottom:0;left:38%;color:rgba(200,146,26,.05);animation-duration:24s;animation-delay:7s;">美</span>

  <!-- Motif bunga SVG pojok kanan atas -->
  <svg class="hero-floral-deco" style="right:0;top:0;width:420px;opacity:.08;" viewBox="0 0 420 420" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="350" cy="70"  r="120" stroke="#8B1A1A" stroke-width="1"/>
    <circle cx="350" cy="70"  r="80"  stroke="#E8621A" stroke-width="1"/>
    <circle cx="350" cy="70"  r="40"  fill="rgba(232,98,26,.15)"/>
    <circle cx="280" cy="140" r="90"  stroke="#8B1A1A" stroke-width="1"/>
    <circle cx="390" cy="10"  r="70"  stroke="#C8921A" stroke-width="1"/>
    <!-- Kelopak stilasi -->
    <ellipse cx="350" cy="20"  rx="18" ry="50" fill="rgba(139,26,26,.12)" transform="rotate(0 350 70)"/>
    <ellipse cx="350" cy="20"  rx="18" ry="50" fill="rgba(139,26,26,.12)" transform="rotate(45 350 70)"/>
    <ellipse cx="350" cy="20"  rx="18" ry="50" fill="rgba(139,26,26,.12)" transform="rotate(90 350 70)"/>
    <ellipse cx="350" cy="20"  rx="18" ry="50" fill="rgba(139,26,26,.12)" transform="rotate(135 350 70)"/>
  </svg>

  <!-- Foto kategori (bila ada) sebagai accent kanan -->
  <?php if (!empty($category['image'])): ?>
  <div style="position:absolute;right:0;top:0;bottom:0;width:45%;z-index:0;overflow:hidden;" class="hero-floral-deco" style="position:absolute;">
    <div style="position:absolute;inset:0;background-image:url('<?= e(imgUrl($category['image'],'category')) ?>');background-size:cover;background-position:center;"></div>
    <div style="position:absolute;inset:0;background:linear-gradient(90deg,var(--washi) 0%,rgba(253,250,245,.7) 30%,rgba(253,250,245,.2) 60%,rgba(253,250,245,.1) 100%);"></div>
    <!-- Bingkai tatami tipis kanan -->
    <div style="position:absolute;right:0;top:0;bottom:0;width:4px;background:linear-gradient(180deg,var(--matsu-lt),var(--hanko),var(--matsu-lt));"></div>
  </div>
  <?php endif; ?>

  <!-- Lentera gantung kiri -->
  <div style="position:absolute;left:32px;top:70px;z-index:2;pointer-events:none;animation:lanternSway 5s ease-in-out infinite;transform-origin:top center;">
    <div style="width:2px;height:30px;background:var(--ink-20);margin:0 auto;"></div>
    <div style="width:32px;height:56px;background:radial-gradient(ellipse at 50% 35%,#FFB84A,var(--matsu));border-radius:16px 16px 20px 20px;border:1.5px solid rgba(232,98,26,.3);box-shadow:0 0 24px rgba(232,98,26,.35),0 0 48px rgba(232,98,26,.12);position:relative;margin:0 auto;">
      <div style="position:absolute;inset:5px;background:radial-gradient(ellipse at 50% 25%,rgba(255,210,120,.7),transparent 70%);border-radius:12px;"></div>
      <div style="position:absolute;bottom:-4px;left:50%;transform:translateX(-50%);width:12px;height:8px;background:var(--hanko);border-radius:0 0 4px 4px;"></div>
    </div>
  </div>

  <!-- Konten hero -->
  <div style="position:relative;z-index:5;max-width:1280px;margin:0 auto;padding:0 24px 90px;">

    <!-- Breadcrumb -->
    <nav class="reveal rv1" style="display:flex;align-items:center;gap:8px;margin-bottom:36px;font-family:'Zen Kaku Gothic New',sans-serif;font-size:11px;letter-spacing:.15em;text-transform:uppercase;">
      <a href="<?= BASE_URL ?>/" style="color:var(--ink-40);text-decoration:none;transition:color .2s;"
         onmouseover="this.style.color='var(--matsu)'" onmouseout="this.style.color='var(--ink-40)'">花の宿</a>
      <span style="color:var(--matsu-lt);font-size:14px;">›</span>
      <span style="color:var(--hanko);"><?= e($category['name']) ?></span>
    </nav>

    <div style="max-width:560px;">

      <!-- Badge kategori -->
      <div class="hero-category-badge reveal rv1">
        <span style="width:7px;height:7px;border-radius:50%;background:var(--hanko);display:inline-block;position:relative;">
          <span style="position:absolute;inset:-3px;border-radius:50%;border:1px solid var(--hanko);animation:pulseRing 2s ease-out infinite;"></span>
        </span>
        <span style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:11px;font-weight:400;letter-spacing:.18em;text-transform:uppercase;color:var(--hanko);">
          Florist Terpercaya · Jakarta Pusat
        </span>
      </div>

      <!-- Judul -->
      <h1 class="reveal rv2" style="font:300 clamp(2.6rem,5.5vw,4rem)/1.15 'Noto Serif JP',serif;color:var(--ink);margin-bottom:8px;letter-spacing:-.02em;">
        <?= e($category['name']) ?>
      </h1>
      <p class="reveal rv2" style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:clamp(1.1rem,2.2vw,1.4rem);color:var(--matsu);font-weight:300;margin-bottom:22px;letter-spacing:.04em;">
        Segar, Indah, Dikirim ke Pintu Anda
      </p>

      <!-- Deskripsi -->
      <p class="reveal rv3" style="font:300 17px/1.9 'Zen Kaku Gothic New',sans-serif;color:var(--ink-60);max-width:480px;margin-bottom:32px;">
        <?= !empty($category['meta_description'])
          ? e($category['meta_description'])
          : 'Toko bunga Jakarta Pusat terpercaya menyediakan '.e(strtolower($category['name'])).' berkualitas tinggi dengan bunga segar pilihan. Pesan sekarang, kirim cepat.' ?>
      </p>

      <!-- Stat cards -->
      <div class="reveal rv3" style="display:flex;gap:10px;margin-bottom:32px;flex-wrap:wrap;">
        <div class="hero-stat" style="flex:1;min-width:90px;">
          <div style="font-family:'Noto Serif JP',serif;font-size:9px;font-weight:200;color:var(--ink-40);letter-spacing:.2em;text-transform:uppercase;margin-bottom:4px;">品数</div>
          <div style="font-family:'Cormorant Garamond',serif;font-size:30px;font-weight:400;color:var(--hanko);line-height:1;"><?= $product_count ?>+</div>
          <div style="font-size:10px;color:var(--ink-40);font-family:'Zen Kaku Gothic New',sans-serif;margin-top:2px;">Produk</div>
        </div>
        <div class="hero-stat" style="flex:1;min-width:90px;">
          <div style="font-family:'Noto Serif JP',serif;font-size:9px;font-weight:200;color:var(--ink-40);letter-spacing:.2em;text-transform:uppercase;margin-bottom:4px;">配達</div>
          <div style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:400;color:var(--matsu);line-height:1;">2-4<span style="font-size:14px;">Jam</span></div>
          <div style="font-size:10px;color:var(--ink-40);font-family:'Zen Kaku Gothic New',sans-serif;margin-top:2px;">Pengiriman</div>
        </div>
        <div class="hero-stat" style="flex:1;min-width:100px;">
          <div style="font-family:'Noto Serif JP',serif;font-size:9px;font-weight:200;color:var(--ink-40);letter-spacing:.2em;text-transform:uppercase;margin-bottom:4px;">価格</div>
          <div style="font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:400;color:var(--gold);line-height:1;"><?= 'Rp '.number_format($min_price/1000,0,',','.').'rb' ?></div>
          <div style="font-size:10px;color:var(--ink-40);font-family:'Zen Kaku Gothic New',sans-serif;margin-top:2px;">Mulai dari</div>
        </div>
      </div>

      <!-- CTA -->
      <div class="reveal rv4" style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
        <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan '.$category['name'].' di Jakarta Pusat.') ?>" target="_blank" class="btn-matsuri">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
          Pesan Sekarang
        </a>
        <a href="#produk" class="btn-outline-matsuri">
          Lihat Koleksi ↓
        </a>
      </div>

    </div>
  </div>

  <!-- Hiasan bawah hero: strip motif -->
  <div style="position:absolute;bottom:0;left:0;right:0;height:6px;z-index:6;">
    <div style="height:3px;background:linear-gradient(90deg,var(--hanko),var(--matsu),var(--gold),var(--matsu),var(--hanko));"></div>
    <div style="height:3px;background:var(--tatami);"></div>
  </div>

</section>

<!-- ════════════════════════════════════════
     TICKER
════════════════════════════════════════ -->
<div class="hana-ticker">
  <div class="hana-ticker-inner">
    <?php for ($r=0;$r<2;$r++): ?>
    <?php foreach ($all_cats as $c): ?>
    <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" class="ticker-item">
      <span class="ticker-dot"></span>
      <?= e($c['name']) ?>
    </a>
    <?php endforeach; ?>
    <?php endfor; ?>
  </div>
</div>

<!-- KUMO: Hero → Body -->
<div style="position:relative;height:64px;overflow:hidden;pointer-events:none;background:linear-gradient(180deg,var(--hanko) 0%,var(--washi) 100%);">
  <svg style="position:absolute;bottom:0;left:0;width:200%;height:100%;" viewBox="0 0 2880 64" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <g style="animation:kumoScroll1 22s linear infinite;">
      <ellipse cx="100"  cy="52" rx="100" ry="28" fill="#FDFAF5"/>
      <ellipse cx="240"  cy="46" rx="85"  ry="24" fill="#FDFAF5"/>
      <ellipse cx="370"  cy="54" rx="110" ry="30" fill="#FDFAF5"/>
      <ellipse cx="510"  cy="44" rx="90"  ry="26" fill="#FDFAF5"/>
      <ellipse cx="640"  cy="54" rx="105" ry="29" fill="#FDFAF5"/>
      <ellipse cx="770"  cy="46" rx="88"  ry="25" fill="#FDFAF5"/>
      <ellipse cx="900"  cy="53" rx="102" ry="28" fill="#FDFAF5"/>
      <ellipse cx="1035" cy="45" rx="92"  ry="26" fill="#FDFAF5"/>
      <ellipse cx="1165" cy="54" rx="108" ry="29" fill="#FDFAF5"/>
      <ellipse cx="1300" cy="46" rx="85"  ry="24" fill="#FDFAF5"/>
      <ellipse cx="1430" cy="53" rx="100" ry="28" fill="#FDFAF5"/>
      <!-- Duplikat seamless -->
      <ellipse cx="1540" cy="52" rx="100" ry="28" fill="#FDFAF5"/>
      <ellipse cx="1680" cy="46" rx="85"  ry="24" fill="#FDFAF5"/>
      <ellipse cx="1810" cy="54" rx="110" ry="30" fill="#FDFAF5"/>
      <ellipse cx="1950" cy="44" rx="90"  ry="26" fill="#FDFAF5"/>
      <ellipse cx="2080" cy="54" rx="105" ry="29" fill="#FDFAF5"/>
      <ellipse cx="2210" cy="46" rx="88"  ry="25" fill="#FDFAF5"/>
      <ellipse cx="2340" cy="53" rx="102" ry="28" fill="#FDFAF5"/>
      <ellipse cx="2475" cy="45" rx="92"  ry="26" fill="#FDFAF5"/>
      <ellipse cx="2605" cy="54" rx="108" ry="29" fill="#FDFAF5"/>
      <ellipse cx="2740" cy="46" rx="85"  ry="24" fill="#FDFAF5"/>
      <ellipse cx="2870" cy="53" rx="100" ry="28" fill="#FDFAF5"/>
    </g>
  </svg>
</div>

<!-- ════════════════════════════════════════
     BODY: SIDEBAR + PRODUK
════════════════════════════════════════ -->
<div id="produk" class="page-body tatami-grid">
  <div class="page-container">
    <div class="page-grid">

      <!-- ═══ SIDEBAR ═══ -->
      <aside class="sidebar">

        <!-- Panel kategori -->
        <div class="sidebar-panel">
          <div class="sidebar-panel-head">
            <svg width="14" height="14" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            <span>花 · Layanan Kami</span>
          </div>
          <div class="sidebar-panel-body">
            <?php foreach ($all_cats as $c):
              $c_subs   = $all_cats_subs[$c['id']] ?? [];
              $has_subs = !empty($c_subs);
              $is_active= $c['id']==$category['id']||(isset($category['parent_id'])&&$category['parent_id']==$c['id']);
            ?>
            <?php if ($has_subs): ?>
            <button onclick="toggleAcc(this)" class="sacc-btn <?= $is_active?'open':'' ?>">
              <span><?= e($c['name']) ?></span>
              <svg class="chevron" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div class="sacc-body <?= $is_active?'open':'' ?>">
              <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" style="display:block;padding:5px 10px;font-size:11px;color:var(--matsu);text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;opacity:.8;">Lihat semua →</a>
              <?php foreach ($c_subs as $sub):
                $is_sub = $sub['id']==$category['id']; ?>
              <a href="<?= BASE_URL ?>/<?= e($sub['slug']) ?>/" class="snav-link <?= $is_sub?'active':'' ?>">
                <span><?= e($sub['name']) ?></span>
                <?php if ($is_sub): ?><span class="snav-dot"></span><?php endif; ?>
              </a>
              <?php endforeach; ?>
            </div>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" class="snav-link <?= $is_active?'active':'' ?>">
              <?= e($c['name']) ?>
              <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Panel WA -->
        <div class="sidebar-wa">
          <span class="lantern-icon">🏮</span>
          <p style="font-family:'Noto Serif JP',serif;font-weight:300;font-size:17px;color:var(--ink);margin-bottom:6px;letter-spacing:.02em;">Butuh Bantuan?</p>
          <p style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:14px;font-weight:300;color:var(--ink-60);margin-bottom:18px;line-height:1.7;">Konsultasi gratis 24 jam,<br>pengiriman ke seluruh Jakarta</p>
          <a href="<?= e($wa_url) ?>" target="_blank"
             style="display:flex;align-items:center;justify-content:center;gap:8px;background:linear-gradient(135deg,#2d6a32,#1a4a1e);color:#a8d8ac;padding:11px 16px;border-radius:6px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:12px;font-weight:400;letter-spacing:.04em;border:1px solid rgba(168,216,172,.25);transition:all .3s ease;box-shadow:0 4px 12px rgba(45,106,50,.2);"
             onmouseover="this.style.color='#c8e8ca';this.style.transform='translateY(-2px)'" onmouseout="this.style.color='#a8d8ac';this.style.transform=''">
            <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Chat WhatsApp
          </a>
        </div>

        <!-- Panel info cepat -->
        <div class="sidebar-panel">
          <div class="sidebar-panel-head" style="background:linear-gradient(135deg,var(--matsu),var(--gold));">
            <span>🌸 Info Cepat</span>
          </div>
          <div class="sidebar-panel-body">
            <div style="display:flex;flex-direction:column;gap:8px;">
              <?php $info_quick=[['🕐','Buka 24 Jam / 7 Hari'],['🚚','Kirim 2–4 Jam'],['💳','COD & Transfer'],['📍','Jakarta Pusat']]; ?>
              <?php foreach ($info_quick as [$icon,$txt]): ?>
              <div style="display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:6px;background:var(--washi-warm);font-family:'Zen Kaku Gothic New',sans-serif;font-size:12px;font-weight:300;color:var(--ink-60);">
                <span style="font-size:14px;"><?= $icon ?></span>
                <span><?= $txt ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

      </aside>

      <!-- ═══ PRODUK ═══ -->
      <div>
        <!-- Header produk -->
        <div class="prod-header">
          <div>
            <div class="prod-title-deco">
              <span style="font-family:'Noto Serif JP',serif;font-size:11px;font-weight:200;letter-spacing:.3em;text-transform:uppercase;color:var(--matsu);">品 · Koleksi</span>
            </div>
            <h2 style="font:300 clamp(1.5rem,2.8vw,2.2rem)/1.2 'Noto Serif JP',serif;color:var(--ink);">
              <?= e($category['name']) ?>
              <span style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:.65em;color:var(--matsu);font-weight:300;"> · <?= $product_count ?> produk</span>
            </h2>
          </div>
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin melihat katalog '.$category['name'].' lengkap.') ?>"
             target="_blank" class="btn-outline-matsuri" style="font-size:12px;padding:9px 16px;flex-shrink:0;">
            Katalog via WA →
          </a>
        </div>

        <!-- Grid Produk Seragam -->
        <?php if (!empty($products)): ?>
        <div class="prod-grid">
          <?php foreach ($products as $idx => $prod):
            $img     = imgUrl($prod['image'],'product');
            $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga ".rupiah($prod['price']).". Apakah masih tersedia?");
          ?>
          <div style="animation:fadeUp .5s ease <?= $idx * 0.08 ?>s both;">
            <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank" class="prod-card">

              <!-- Area foto -->
              <div class="prod-card-img-wrap">
                <img src="<?= e($img) ?>" alt="<?= e($prod['name']) ?> Jakarta Pusat" class="prod-card-img" loading="lazy">

                <?php if (!empty($prod['cat_name'])): ?>
                <span class="prod-card-label"><?= e($prod['cat_name']) ?></span>
                <?php endif; ?>

                <div class="prod-hanko">花</div>
              </div>

              <!-- Info bawah foto -->
              <div class="prod-card-info">
                <div class="prod-card-name"><?= e($prod['name']) ?></div>
                
                <div class="prod-card-price"><?= rupiah($prod['price']) ?></div>
                <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank" class="prod-card-btn" onclick="event.stopPropagation()">
                  <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                  Pesan via WhatsApp
                </a>
              </div>

            </a>
          </div>
          <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div class="empty-state">
          <div style="font-size:56px;margin-bottom:16px;">🌸</div>
          <p style="font-family:'Noto Serif JP',serif;font-weight:300;font-size:18px;color:var(--ink-40);margin-bottom:8px;">Produk sedang dipersiapkan</p>
          <p style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:13px;color:var(--ink-40);margin-bottom:24px;">Hubungi kami untuk melihat koleksi terbaru</p>
          <a href="<?= e($wa_url) ?>" target="_blank" class="btn-matsuri">Tanya via WhatsApp</a>
        </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>

<!-- KUMO: Body → SEO -->
<div style="position:relative;height:70px;overflow:hidden;pointer-events:none;background:linear-gradient(180deg,var(--washi) 0%,var(--washi-warm) 100%);">
  <svg style="position:absolute;top:0;left:0;width:200%;height:100%;" viewBox="0 0 2880 70" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <g style="animation:kumoScroll2 26s linear infinite;">
      <ellipse cx="90"   cy="12" rx="95"  ry="26" fill="#FAF3E8"/>
      <ellipse cx="230"  cy="20" rx="78"  ry="22" fill="#FAF3E8"/>
      <ellipse cx="350"  cy="10" rx="102" ry="28" fill="#FAF3E8"/>
      <ellipse cx="490"  cy="18" rx="86"  ry="24" fill="#FAF3E8"/>
      <ellipse cx="618"  cy="9"  rx="98"  ry="26" fill="#FAF3E8"/>
      <ellipse cx="748"  cy="19" rx="82"  ry="23" fill="#FAF3E8"/>
      <ellipse cx="875"  cy="11" rx="99"  ry="27" fill="#FAF3E8"/>
      <ellipse cx="1010" cy="18" rx="88"  ry="24" fill="#FAF3E8"/>
      <ellipse cx="1140" cy="10" rx="104" ry="27" fill="#FAF3E8"/>
      <ellipse cx="1278" cy="19" rx="80"  ry="22" fill="#FAF3E8"/>
      <ellipse cx="1408" cy="11" rx="96"  ry="26" fill="#FAF3E8"/>
      <!-- Duplikat -->
      <ellipse cx="1530" cy="12" rx="95"  ry="26" fill="#FAF3E8"/>
      <ellipse cx="1670" cy="20" rx="78"  ry="22" fill="#FAF3E8"/>
      <ellipse cx="1790" cy="10" rx="102" ry="28" fill="#FAF3E8"/>
      <ellipse cx="1930" cy="18" rx="86"  ry="24" fill="#FAF3E8"/>
      <ellipse cx="2058" cy="9"  rx="98"  ry="26" fill="#FAF3E8"/>
      <ellipse cx="2188" cy="19" rx="82"  ry="23" fill="#FAF3E8"/>
      <ellipse cx="2315" cy="11" rx="99"  ry="27" fill="#FAF3E8"/>
      <ellipse cx="2450" cy="18" rx="88"  ry="24" fill="#FAF3E8"/>
      <ellipse cx="2580" cy="10" rx="104" ry="27" fill="#FAF3E8"/>
      <ellipse cx="2718" cy="19" rx="80"  ry="22" fill="#FAF3E8"/>
      <ellipse cx="2848" cy="11" rx="96"  ry="26" fill="#FAF3E8"/>
    </g>
  </svg>
</div>

<!-- ════════════════════════════════════════
     SEO CONTENT — Washi Warm + Obon Festif
════════════════════════════════════════ -->
<section class="seo-section tatami-grid washi-tex" style="padding:72px 0 80px;">

  <!-- Kanji dekoratif -->
  <span class="kanji-bg" style="font-size:240px;top:-10px;right:1%;color:rgba(232,98,26,.05);animation-duration:18s;">祭</span>
  <span class="kanji-bg" style="font-size:160px;bottom:0;left:3%;color:rgba(139,26,26,.04);animation-duration:22s;animation-delay:5s;">縁</span>

  <!-- Lentera kiri -->
  <div class="seo-lantern" style="left:20px;top:40px;animation-duration:5.5s;">
    <div style="width:2px;height:28px;background:var(--ink-20);margin:0 auto;"></div>
    <div style="width:28px;height:48px;background:radial-gradient(ellipse at 50%35%,#FFB84A,var(--matsu));border-radius:14px 14px 18px 18px;box-shadow:0 0 20px rgba(232,98,26,.3),0 0 40px rgba(232,98,26,.1);margin:0 auto;position:relative;">
      <div style="position:absolute;inset:4px;background:radial-gradient(ellipse at 50%25%,rgba(255,205,110,.65),transparent 70%);border-radius:10px;"></div>
    </div>
  </div>
  <!-- Lentera kanan -->
  <div class="seo-lantern" style="right:24px;top:80px;animation-duration:7s;animation-delay:2s;">
    <div style="width:2px;height:22px;background:var(--ink-20);margin:0 auto;"></div>
    <div style="width:22px;height:38px;background:radial-gradient(ellipse at 50%35%,#FFB84A,var(--hanko));border-radius:11px 11px 14px 14px;box-shadow:0 0 16px rgba(139,26,26,.3);margin:0 auto;position:relative;">
      <div style="position:absolute;inset:3px;background:radial-gradient(ellipse at 50%25%,rgba(255,195,100,.55),transparent 70%);border-radius:8px;"></div>
    </div>
  </div>

  <!-- Ember -->
  <div style="position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
    <?php for($e=0;$e<6;$e++): ?>
    <div style="position:absolute;width:3px;height:3px;border-radius:50%;
      background:<?= ['#E8621A','#F0B548','#C8921A','#FFD4A8'][$e%4] ?>;
      left:<?= rand(5,95) ?>%;bottom:<?= rand(5,30) ?>%;
      animation:emberUp <?= rand(24,40)/10 ?>s ease-in <?= rand(0,20)/10 ?>s infinite;">
    </div>
    <?php endfor; ?>
  </div>

  <div style="position:relative;z-index:1;max-width:1280px;margin:0 auto;padding:0 24px;">

    <!-- Judul section -->
    <div style="text-align:center;margin-bottom:56px;">
      <!-- Strip dekoratif -->
      <div style="display:flex;align-items:center;gap:16px;justify-content:center;margin-bottom:16px;">
        <div style="height:1px;width:80px;background:linear-gradient(90deg,transparent,var(--matsu-lt));"></div>
        <span style="font-family:'Noto Serif JP',serif;font-size:11px;font-weight:200;letter-spacing:.3em;text-transform:uppercase;color:var(--matsu);">盂蘭盆会 · Tentang Layanan</span>
        <div style="height:1px;width:80px;background:linear-gradient(90deg,var(--matsu-lt),transparent);"></div>
      </div>
      <h2 style="font:300 clamp(1.8rem,3.5vw,2.8rem)/1.2 'Noto Serif JP',serif;color:var(--ink);margin-bottom:0;">
        <?= e($category['name']) ?> Terbaik
        <span style="font-family:'Cormorant Garamond',serif;font-style:italic;font-weight:300;color:var(--matsu);"> di Jakarta Pusat</span>
      </h2>
    </div>

    <!-- Grid: prosa + sidebar info -->
    <div class="seo-grid" style="display:grid;grid-template-columns:1fr 320px;gap:48px;align-items:start;">

      <!-- Kiri: Konten SEO -->
      <div>

        <?php if (!empty($category['content'])): ?>
        <div style="font:300 15px/1.9 'Zen Kaku Gothic New',sans-serif;color:var(--ink-60);margin-bottom:28px;"><?= $category['content'] ?></div>
        <?php endif; ?>

        <p style="font:300 16px/1.9 'Zen Kaku Gothic New',sans-serif;color:var(--ink-60);margin-bottom:36px;">
          Kami sebagai <strong style="color:var(--hanko);font-weight:500;">florist Jakarta Pusat</strong> terpercaya menyediakan
          <?= e(strtolower($category['name'])) ?> berkualitas tinggi. Setiap rangkaian dikerjakan oleh tim florist berpengalaman dengan bunga segar pilihan yang tiba langsung dari kebun.
        </p>

        <!-- Keunggulan -->
        <h3 style="font:300 22px/1.3 'Noto Serif JP',serif;color:var(--ink);margin-bottom:18px;display:flex;align-items:center;gap:12px;">
          <span style="display:inline-block;width:4px;height:22px;background:var(--matsu);border-radius:2px;"></span>
          Mengapa Memilih Kami?
        </h3>
        <?php
        $keunggulan = [
          ['🌸','Bunga 100% segar berkualitas premium'],
          ['🚚','Pengiriman cepat 2–4 jam ke seluruh Jakarta Pusat'],
          ['💰','Harga transparan mulai '.rupiah($min_price)],
          ['✏️','Desain custom sesuai keinginan Anda'],
          ['📞','Melayani pesanan mendadak 24 jam'],
        ];
        ?>
        <div style="display:grid;gap:10px;margin-bottom:36px;">
          <?php foreach ($keunggulan as [$icon, $txt]): ?>
          <div class="unggulan-row">
            <div class="unggulan-icon"><?= $icon ?></div>
            <span style="font:300 15px/1.65 'Zen Kaku Gothic New',sans-serif;color:var(--ink-60);"><?= $txt ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Cara pesan -->
        <h3 style="font:300 22px/1.3 'Noto Serif JP',serif;color:var(--ink);margin-bottom:14px;display:flex;align-items:center;gap:12px;">
          <span style="display:inline-block;width:4px;height:22px;background:var(--hanko);border-radius:2px;"></span>
          Cara Memesan
        </h3>
        <p style="font:300 16px/1.85 'Zen Kaku Gothic New',sans-serif;color:var(--ink-60);margin-bottom:28px;">
          Hubungi kami via WhatsApp di <strong style="color:var(--hanko);font-weight:500;"><?= e(setting('phone_display')) ?></strong> —
          informasikan jenis bunga, alamat, tanggal & jam pengiriman, serta pesan yang ingin dituliskan. Mudah, cepat, bunga langsung dikirim!
        </p>

        <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan '.$category['name'].' di Jakarta Pusat.') ?>"
           target="_blank" class="btn-matsuri">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
          Chat WhatsApp Sekarang
        </a>
      </div>

      <!-- Kanan: Info cards -->
      <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:100px;">

        <!-- Area pengiriman -->
        <div class="seo-info-card">
          <div class="seo-info-head">
            <span style="font-size:18px;">📍</span>
            <span style="font-family:'Noto Serif JP',serif;font-weight:300;font-size:14px;color:var(--ink);">Area Pengiriman</span>
          </div>
          <div class="seo-info-body">
            <p style="font:300 12px/1.7 'Zen Kaku Gothic New',sans-serif;color:var(--ink-60);margin-bottom:12px;">Melayani seluruh kecamatan Jakarta Pusat:</p>
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
              <?php foreach ($locations as $l): ?>
              <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/" class="area-pill">
                🌸 <?= e($l['name']) ?>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Info pemesanan -->
        <div class="seo-info-card">
          <div class="seo-info-head">
            <span style="font-size:18px;">🏮</span>
            <span style="font-family:'Noto Serif JP',serif;font-weight:300;font-size:14px;color:var(--ink);">Info Pemesanan</span>
          </div>
          <div class="seo-info-body">
            <?php $info=[
              ['Jam Operasional', setting('jam_buka')?:'24 Jam / 7 Hari'],
              ['Estimasi Kirim',  '2–4 Jam setelah konfirmasi'],
              ['Minimal Pesan',   rupiah($min_price)],
              ['Pembayaran',      'Transfer / COD tersedia'],
            ]; ?>
            <div style="display:flex;flex-direction:column;">
              <?php foreach ($info as [$l,$v]): ?>
              <div class="info-row-seo">
                <span style="font:300 12px/1 'Zen Kaku Gothic New',sans-serif;color:var(--ink-40);"><?= $l ?></span>
                <span style="font:500 12px/1 'Zen Kaku Gothic New',sans-serif;color:var(--hanko);"><?= $v ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Dekorasi Festival kecil -->
        <div style="text-align:center;padding:20px;background:linear-gradient(135deg,var(--matsu-pale),var(--gold-pale));border-radius:10px;border:1px solid rgba(232,98,26,.15);">
          <div style="font-size:28px;margin-bottom:8px;">🎋🏮🎋</div>
          <p style="font-family:'Noto Serif JP',serif;font-weight:200;font-size:11px;letter-spacing:.25em;color:var(--matsu);text-transform:uppercase;margin-bottom:4px;">盂蘭盆会</p>
          <p style="font:300 11px/1.6 'Zen Kaku Gothic New',sans-serif;color:var(--ink-40);">Merayakan keindahan<br>dalam setiap rangkaian</p>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- KUMO: SEO → Footer -->
<div style="position:relative;height:60px;overflow:hidden;pointer-events:none;background:linear-gradient(180deg,var(--washi-warm) 0%,var(--tatami) 100%);">
  <svg style="position:absolute;top:0;left:0;width:200%;height:100%;" viewBox="0 0 2880 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <g style="animation:kumoScroll1 20s linear infinite;">
      <ellipse cx="80"   cy="10" rx="88"  ry="24" fill="#F0E8D8"/>
      <ellipse cx="215"  cy="18" rx="74"  ry="20" fill="#F0E8D8"/>
      <ellipse cx="338"  cy="8"  rx="94"  ry="26" fill="#F0E8D8"/>
      <ellipse cx="472"  cy="16" rx="80"  ry="22" fill="#F0E8D8"/>
      <ellipse cx="598"  cy="8"  rx="90"  ry="24" fill="#F0E8D8"/>
      <ellipse cx="728"  cy="17" rx="76"  ry="21" fill="#F0E8D8"/>
      <ellipse cx="852"  cy="9"  rx="92"  ry="25" fill="#F0E8D8"/>
      <ellipse cx="985"  cy="17" rx="82"  ry="22" fill="#F0E8D8"/>
      <ellipse cx="1112" cy="8"  rx="96"  ry="25" fill="#F0E8D8"/>
      <ellipse cx="1248" cy="17" rx="76"  ry="20" fill="#F0E8D8"/>
      <ellipse cx="1378" cy="9"  rx="90"  ry="24" fill="#F0E8D8"/>
      <!-- Duplikat -->
      <ellipse cx="1520" cy="10" rx="88"  ry="24" fill="#F0E8D8"/>
      <ellipse cx="1655" cy="18" rx="74"  ry="20" fill="#F0E8D8"/>
      <ellipse cx="1778" cy="8"  rx="94"  ry="26" fill="#F0E8D8"/>
      <ellipse cx="1912" cy="16" rx="80"  ry="22" fill="#F0E8D8"/>
      <ellipse cx="2038" cy="8"  rx="90"  ry="24" fill="#F0E8D8"/>
      <ellipse cx="2168" cy="17" rx="76"  ry="21" fill="#F0E8D8"/>
      <ellipse cx="2292" cy="9"  rx="92"  ry="25" fill="#F0E8D8"/>
      <ellipse cx="2425" cy="17" rx="82"  ry="22" fill="#F0E8D8"/>
      <ellipse cx="2552" cy="8"  rx="96"  ry="25" fill="#F0E8D8"/>
      <ellipse cx="2688" cy="17" rx="76"  ry="20" fill="#F0E8D8"/>
      <ellipse cx="2818" cy="9"  rx="90"  ry="24" fill="#F0E8D8"/>
    </g>
  </svg>
</div>

<script>
function toggleAcc(btn) {
  const body   = btn.nextElementSibling;
  const isOpen = body.classList.contains('open');
  document.querySelectorAll('.sacc-body.open').forEach(el => el.classList.remove('open'));
  document.querySelectorAll('.sacc-btn.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) { btn.classList.add('open'); body.classList.add('open'); }
}
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.sacc-body.open').forEach(el => {
    el.previousElementSibling?.classList.add('open');
  });
});
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>