<!-- ============================================================
     PRODUK SECTION — Chochin Market | Zen Wabi-Sabi
     Konsep: Pasar malam Jepang, lampion gantung, papan kayu
             warung, hanko stamp harga, washi card texture,
             mon krest ikon kategori, kumo cloud row divider
============================================================ -->
<?php
/* ── Recursive root finder ── */
function getRootId(int $id, array &$map): int {
    if (!isset($map[$id])) return $id;
    $pid = (int)($map[$id]['parent_id'] ?? 0);
    return $pid === 0 ? $id : getRootId($pid, $map);
}

$catMap = [];
foreach (db()->query("SELECT id,name,slug,parent_id FROM categories WHERE status='active'")->fetchAll() as $c) {
    $catMap[$c['id']] = $c;
}

$all_products = [];
foreach (db()->query("
    SELECT p.*, c.name AS cat_name, c.id AS cat_id, c.parent_id AS cat_pid
    FROM products p LEFT JOIN categories c ON p.category_id=c.id
    WHERE p.status='active' ORDER BY p.created_at DESC
")->fetchAll() as $p) {
    $p['root_cat_id'] = getRootId((int)$p['cat_id'], $catMap);
    $all_products[] = $p;
}

$tab_cats = [];
foreach ($catMap as $c) {
    if ((int)($c['parent_id'] ?? 0) === 0) $tab_cats[] = $c;
}
usort($tab_cats, fn($a,$b) => $a['id'] <=> $b['id']);

$subsMap = [];
foreach ($catMap as $c) {
    $pid = (int)($c['parent_id'] ?? 0);
    if ($pid === 0) continue;
    $cnt = count(array_filter($all_products, fn($p) => $p['cat_id'] == $c['id']));
    if ($cnt > 0) { $c['prod_count'] = $cnt; $subsMap[$pid][] = $c; }
}

$countByRoot = [];
foreach ($all_products as $p) {
    $countByRoot[$p['root_cat_id']] = ($countByRoot[$p['root_cat_id']] ?? 0) + 1;
}

$CARD_INIT = 8;

/* Mon krest SVG paths per kategori — pakai index fallback */
$mon_symbols = [
    '<circle cx="12" cy="12" r="7" fill="none" stroke="currentColor" stroke-width="1.2"/><circle cx="12" cy="12" r="3" fill="currentColor"/><line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="1"/><line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="1"/>',
    '<polygon points="12,3 20,8 20,16 12,21 4,16 4,8" fill="none" stroke="currentColor" stroke-width="1.2"/><circle cx="12" cy="12" r="3.5" fill="currentColor"/>',
    '<circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.2"/><line x1="12" y1="4" x2="12" y2="8" stroke="currentColor" stroke-width="1.2"/><line x1="12" y1="16" x2="12" y2="20" stroke="currentColor" stroke-width="1.2"/><line x1="4" y1="12" x2="8" y2="12" stroke="currentColor" stroke-width="1.2"/><line x1="16" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="1.2"/>',
    '<rect x="6" y="6" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.2" transform="rotate(45 12 12)"/><circle cx="12" cy="12" r="2.5" fill="currentColor"/>',
    '<path d="M12 3 L14.5 9 L21 9.5 L16 14 L17.5 21 L12 17.5 L6.5 21 L8 14 L3 9.5 L9.5 9 Z" fill="none" stroke="currentColor" stroke-width="1.2"/>',
    '<circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1"/><path d="M12 6 Q16 9 16 12 Q16 15 12 18 Q8 15 8 12 Q8 9 12 6Z" fill="none" stroke="currentColor" stroke-width="1.2"/>',
    '<circle cx="12" cy="12" r="7" fill="none" stroke="currentColor" stroke-width="1.2"/><path d="M9 9 L15 9 L15 15 L9 15 Z" fill="none" stroke="currentColor" stroke-width="1.2"/><circle cx="12" cy="12" r="1.5" fill="currentColor"/>',
    '<circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1"/><path d="M12 4 L12 20 M4 12 L20 12 M6.3 6.3 L17.7 17.7 M17.7 6.3 L6.3 17.7" stroke="currentColor" stroke-width=".8"/>',
];
$kanji_list = ['花','美','愛','縁','命','輪','香','彩'];
$icon_list  = ['🌸','💐','🌺','🌹','🌷','🌼','🪷','🏵️'];
?>

<style>
/* ══════════════════════════════════════════════
   CHOCHIN MARKET — PRODUK SECTION
   Palet: sumi night, washi warm, torii red, bamboo gold, matcha
══════════════════════════════════════════════ */

#produk {
  position: relative;
  background: #0f0d0a;
  overflow: hidden;
  font-family: 'Zen Kaku Gothic New', sans-serif;
}

/* ── Langit malam gradient ── */
#produk::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 80% 50% at 20% 0%, rgba(139,32,32,.18) 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 80% 0%, rgba(196,168,130,.1) 0%, transparent 50%),
    radial-gradient(ellipse 100% 60% at 50% 100%, rgba(28,28,28,.8) 0%, transparent 70%),
    linear-gradient(to bottom, #1a1208 0%, #0f0d0a 40%, #0a0908 100%);
  pointer-events: none;
  z-index: 0;
}

/* ── Bintang-bintang kecil ── */
#produk::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    radial-gradient(1px 1px at 10% 15%, rgba(245,240,232,.35) 0%, transparent 100%),
    radial-gradient(1px 1px at 25% 8%, rgba(245,240,232,.25) 0%, transparent 100%),
    radial-gradient(1px 1px at 40% 20%, rgba(245,240,232,.3) 0%, transparent 100%),
    radial-gradient(1px 1px at 55% 5%, rgba(245,240,232,.2) 0%, transparent 100%),
    radial-gradient(1px 1px at 70% 18%, rgba(245,240,232,.35) 0%, transparent 100%),
    radial-gradient(1px 1px at 85% 10%, rgba(245,240,232,.25) 0%, transparent 100%),
    radial-gradient(1.5px 1.5px at 15% 30%, rgba(245,240,232,.2) 0%, transparent 100%),
    radial-gradient(1px 1px at 90% 25%, rgba(196,168,130,.4) 0%, transparent 100%),
    radial-gradient(1px 1px at 60% 12%, rgba(245,240,232,.3) 0%, transparent 100%),
    radial-gradient(1px 1px at 32% 35%, rgba(245,240,232,.15) 0%, transparent 100%);
  pointer-events: none;
  z-index: 0;
}

/* ── Inner ── */
.chochin-inner {
  position: relative;
  z-index: 2;
  max-width: 1380px;
  margin: 0 auto;
  padding: 80px 32px 88px;
}

/* ═══════════════════════════════════════
   TALI LAMPION — dekorasi tali horizontal
═══════════════════════════════════════ */
.chochin-rope {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 120px;
  z-index: 3;
  pointer-events: none;
  overflow: hidden;
}
.chochin-rope svg { width: 100%; height: 100%; }

/* Lampion gantung dekorasi header */
.chochin-lanterns-deco {
  display: flex;
  justify-content: center;
  gap: clamp(24px, 4vw, 56px);
  margin-bottom: 56px;
  position: relative;
}
.chochin-lanterns-deco::before {
  content: '';
  position: absolute;
  top: 12px; left: 5%; right: 5%;
  height: 2px;
  background: linear-gradient(to right,
    transparent 0%,
    rgba(196,168,130,.35) 10%,
    rgba(196,168,130,.6) 50%,
    rgba(196,168,130,.35) 90%,
    transparent 100%
  );
}

/* Lampion SVG individual */
.chochin-lamp {
  display: flex;
  flex-direction: column;
  align-items: center;
  animation: lampSway 3.5s ease-in-out infinite;
  transform-origin: top center;
}
.chochin-lamp:nth-child(2) { animation-delay: .4s; animation-duration: 4s; }
.chochin-lamp:nth-child(3) { animation-delay: .8s; animation-duration: 3.8s; }
.chochin-lamp:nth-child(4) { animation-delay: .2s; animation-duration: 4.2s; }
.chochin-lamp:nth-child(5) { animation-delay: .6s; animation-duration: 3.6s; }
.chochin-lamp:nth-child(6) { animation-delay: 1s; animation-duration: 4.5s; }
.chochin-lamp:nth-child(7) { animation-delay: .3s; animation-duration: 3.9s; }

@keyframes lampSway {
  0%,100% { transform: rotate(-2deg); }
  50%     { transform: rotate(2deg); }
}

.chochin-lamp-string {
  width: 1.5px;
  height: 20px;
  background: linear-gradient(to bottom, rgba(196,168,130,.6), rgba(196,168,130,.3));
}

.chochin-lamp-body {
  width: 36px;
  height: 52px;
  position: relative;
}
.chochin-lamp-body svg { width: 100%; height: 100%; }

.chochin-lamp-glow {
  position: absolute;
  inset: -8px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,180,50,.25) 0%, transparent 70%);
  animation: glowPulse 2s ease-in-out infinite;
}
.chochin-lamp:nth-child(odd) .chochin-lamp-glow {
  background: radial-gradient(circle, rgba(139,32,32,.3) 0%, transparent 70%);
}

@keyframes glowPulse {
  0%,100% { opacity: .6; transform: scale(1); }
  50%     { opacity: 1; transform: scale(1.2); }
}

/* ═══════════════════════════════════════
   HEADER SECTION
═══════════════════════════════════════ */
.chochin-header {
  text-align: center;
  margin-bottom: 52px;
}

.chochin-overline {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 9.5px;
  font-weight: 500;
  letter-spacing: .35em;
  text-transform: uppercase;
  color: rgba(196,168,130,.65);
  margin-bottom: 16px;
}
.chochin-overline-dot {
  width: 4px; height: 4px;
  border-radius: 50%;
  background: #8B2020;
  box-shadow: 0 0 6px rgba(139,32,32,.8);
  animation: redGlow 2s infinite;
}
@keyframes redGlow {
  0%,100% { box-shadow: 0 0 4px rgba(139,32,32,.6); }
  50%     { box-shadow: 0 0 10px rgba(139,32,32,1), 0 0 20px rgba(139,32,32,.4); }
}

.chochin-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(2rem, 4vw, 3.2rem);
  font-weight: 200;
  color: #F5F0E8;
  line-height: 1.12;
  letter-spacing: .04em;
  margin-bottom: 8px;
}
.chochin-title em {
  font-style: italic;
  font-family: 'Cormorant Garamond', serif;
  color: #C4A882;
  font-weight: 300;
}
.chochin-subtitle {
  font-size: 12.5px;
  color: rgba(245,240,232,.38);
  font-weight: 300;
  letter-spacing: .06em;
  max-width: 420px;
  margin: 0 auto;
  line-height: 1.8;
}

/* Rule dekoratif */
.chochin-rule {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin: 20px auto 0;
  max-width: 300px;
}
.chochin-rule-line {
  flex: 1; height: 1px;
  background: linear-gradient(to right, transparent, rgba(196,168,130,.3), transparent);
}
.chochin-rule-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 10px;
  color: rgba(196,168,130,.4);
  font-weight: 300;
  letter-spacing: .15em;
}

/* ═══════════════════════════════════════
   PAPAN KAYU TAB — warung filter
═══════════════════════════════════════ */
.chochin-tabs-board {
  position: relative;
  margin-bottom: 44px;
}

/* Papan kayu background */
.chochin-tabs-bg {
  position: absolute;
  inset: -10px -16px;
  background:
    linear-gradient(180deg, #2d1f0e 0%, #1e1408 50%, #2a1c0c 100%);
  border-radius: 6px;
  border: 1px solid rgba(196,168,130,.15);
  box-shadow:
    0 4px 0 rgba(0,0,0,.4),
    0 8px 24px rgba(0,0,0,.3),
    inset 0 1px 0 rgba(255,255,255,.05);
  /* Serat kayu halus */
  background-image:
    repeating-linear-gradient(
      88deg,
      transparent 0px,
      transparent 40px,
      rgba(255,255,255,.012) 40px,
      rgba(255,255,255,.012) 41px
    ),
    linear-gradient(180deg, #2d1f0e 0%, #1e1408 50%, #2a1c0c 100%);
}

.chochin-tabs-row {
  position: relative;
  z-index: 1;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  align-items: center;
  padding: 4px 0;
}

/* Paku dekorasi sudut papan */
.chochin-nail {
  position: absolute;
  width: 8px; height: 8px;
  border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #d4b483, #8B6F5E);
  box-shadow: 0 1px 2px rgba(0,0,0,.5);
  z-index: 2;
}
.chochin-nail:nth-child(1) { top: -4px; left: -8px; }
.chochin-nail:nth-child(2) { top: -4px; right: -8px; }
.chochin-nail:nth-child(3) { bottom: -4px; left: -8px; }
.chochin-nail:nth-child(4) { bottom: -4px; right: -8px; }

/* Tab button — label papan kecil */
.chochin-tab {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 11.5px;
  font-weight: 500;
  letter-spacing: .05em;
  color: rgba(245,240,232,.55);
  background: rgba(255,255,255,.04);
  border: 1px solid rgba(196,168,130,.12);
  padding: 8px 16px 8px 12px;
  border-radius: 3px;
  cursor: pointer;
  white-space: nowrap;
  transition: all .25s ease;
  position: relative;
  overflow: hidden;
}
.chochin-tab::before {
  /* Sinar lampion hover */
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse at center, rgba(255,160,50,.08) 0%, transparent 70%);
  opacity: 0;
  transition: opacity .3s;
}
.chochin-tab:hover::before { opacity: 1; }
.chochin-tab:hover {
  color: #C4A882;
  border-color: rgba(196,168,130,.3);
  background: rgba(196,168,130,.07);
}
.chochin-tab.active {
  color: #F5F0E8;
  background: rgba(139,32,32,.35);
  border-color: rgba(139,32,32,.5);
  box-shadow: 0 0 12px rgba(139,32,32,.25), inset 0 1px 0 rgba(255,255,255,.06);
}
.chochin-tab.active::before {
  background: radial-gradient(ellipse at center, rgba(139,32,32,.2) 0%, transparent 70%);
  opacity: 1;
}

/* Mon icon di tab */
.tab-mon {
  width: 18px; height: 18px;
  flex-shrink: 0;
  color: rgba(196,168,130,.5);
  transition: color .25s;
}
.chochin-tab:hover .tab-mon,
.chochin-tab.active .tab-mon { color: #C4A882; }

/* Count badge */
.tab-count-badge {
  font-size: 9px;
  font-weight: 600;
  color: rgba(196,168,130,.6);
  background: rgba(196,168,130,.1);
  border: 1px solid rgba(196,168,130,.15);
  padding: 1px 6px;
  border-radius: 10px;
  min-width: 18px;
  text-align: center;
  transition: all .25s;
}
.chochin-tab.active .tab-count-badge {
  background: rgba(139,32,32,.3);
  border-color: rgba(139,32,32,.4);
  color: rgba(245,240,232,.8);
}

/* Chevron dropdown */
.tab-chevron-dd {
  width: 10px; height: 10px;
  opacity: .4;
  transition: transform .2s, opacity .2s;
  flex-shrink: 0;
}
.chochin-tab-wrap.open .tab-chevron-dd { transform: rotate(180deg); opacity: .8; }

/* Sub-dropdown */
.chochin-tab-wrap { position: relative; }
.chochin-sub-dd {
  display: none;
  position: absolute;
  top: calc(100% + 10px);
  left: 0;
  min-width: 220px;
  background: #2a1c0c;
  border: 1px solid rgba(196,168,130,.2);
  border-radius: 4px;
  box-shadow: 0 16px 48px rgba(0,0,0,.5);
  padding: 7px;
  z-index: 300;
  animation: ddFadeIn .18s ease;
  /* Serat kayu */
  background-image: repeating-linear-gradient(
    88deg, transparent 0px, transparent 40px,
    rgba(255,255,255,.015) 40px, rgba(255,255,255,.015) 41px
  );
}
@keyframes ddFadeIn {
  from { opacity:0; transform: translateY(-8px); }
  to   { opacity:1; transform: translateY(0); }
}
.chochin-tab-wrap.open .chochin-sub-dd { display: block; }

.sub-dd-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  padding: 9px 12px;
  border-radius: 3px;
  font-size: 12px;
  font-weight: 400;
  color: rgba(245,240,232,.55);
  cursor: pointer;
  background: none;
  border: none;
  width: 100%;
  text-align: left;
  transition: background .15s, color .15s;
}
.sub-dd-item:hover { background: rgba(196,168,130,.08); color: #C4A882; }
.sub-dd-item.active { color: #F5F0E8; font-weight: 500; }
.sub-dd-count {
  font-size: 9px;
  color: rgba(196,168,130,.45);
  background: rgba(196,168,130,.08);
  padding: 2px 7px;
  border-radius: 8px;
}
.sub-dd-divider {
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(196,168,130,.12), transparent);
  margin: 4px 8px;
}

/* ═══════════════════════════════════════
   KUMO CLOUD ROW DIVIDER
═══════════════════════════════════════ */
.chochin-kumo-row {
  position: relative;
  height: 60px;
  margin: 4px -32px;
  pointer-events: none;
  overflow: hidden;
  opacity: .4;
}
.chochin-kumo-row svg { width: 100%; height: 100%; }

/* ═══════════════════════════════════════
   CARD GRID
═══════════════════════════════════════ */
@keyframes cardRise {
  from { opacity:0; transform: translateY(20px); }
  to   { opacity:1; transform: translateY(0); }
}

.chochin-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}
#cards-extra-wrap {
  max-height: 0;
  overflow: hidden;
  transition: max-height .7s cubic-bezier(.4,0,.2,1), opacity .5s ease;
  opacity: 0;
}
#cards-extra-wrap.open { max-height: 9999px; opacity: 1; }
#cards-extra-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  padding-top: 20px;
}

/* ── Lampion tali di atas tiap card ── */
.prod-card {
  position: relative;
  display: flex;
  flex-direction: column;
  border-radius: 4px;
  overflow: visible; /* supaya tali card muncul di atas */
  cursor: pointer;
  animation: cardRise .4s ease both;
  transition: transform .35s cubic-bezier(.25,.46,.45,.94);
}
.prod-card:hover { transform: translateY(-6px); }

/* Tali gantung di atas card */
.prod-card-string {
  display: flex;
  justify-content: center;
  margin-bottom: -1px;
  position: relative;
  z-index: 2;
}
.prod-card-string-line {
  width: 1.5px;
  height: 18px;
  background: linear-gradient(to bottom, rgba(196,168,130,.5), rgba(196,168,130,.2));
}
/* Lampion kecil di ujung tali */
.prod-card-mini-lamp {
  position: absolute;
  top: -2px;
  width: 8px; height: 12px;
}
.prod-card-mini-lamp svg { width: 100%; height: 100%; }

/* Body card — washi texture */
.prod-card-body {
  background:
    /* Washi paper texture */
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"),
    linear-gradient(160deg, #2a1e12 0%, #1f1509 50%, #261a0d 100%);
  border: 1px solid rgba(196,168,130,.14);
  border-radius: 4px;
  overflow: hidden;
  flex: 1;
  display: flex;
  flex-direction: column;
  box-shadow:
    0 8px 32px rgba(0,0,0,.45),
    0 2px 0 rgba(196,168,130,.08) inset,
    0 0 0 1px rgba(0,0,0,.3);
  transition: box-shadow .35s, border-color .35s;
}
.prod-card:hover .prod-card-body {
  border-color: rgba(196,168,130,.28);
  box-shadow:
    0 16px 48px rgba(0,0,0,.55),
    0 0 24px rgba(255,140,40,.06),
    0 2px 0 rgba(196,168,130,.12) inset;
}

/* Gambar produk */
.prod-img-wrap {
  position: relative;
  aspect-ratio: 4/5;
  overflow: hidden;
  background: #1a1006;
}
.prod-img-wrap img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  filter: brightness(.85) saturate(.9) sepia(.08);
  transition: filter .6s ease, transform .8s cubic-bezier(.25,.46,.45,.94);
}
.prod-card:hover .prod-img-wrap img {
  filter: brightness(.95) saturate(1) sepia(.04);
  transform: scale(1.05);
}

/* Overlay gradient gambar */
.prod-img-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to top,
    rgba(15,13,10,.85) 0%,
    rgba(15,13,10,.2) 50%,
    transparent 100%
  );
}

/* Badge kategori */
.prod-cat-badge {
  position: absolute;
  top: 10px; left: 10px;
  font-size: 9px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: rgba(196,168,130,.85);
  background: rgba(15,13,10,.75);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(196,168,130,.2);
  padding: 3px 9px;
  border-radius: 2px;
}

/* ── HANKO STAMP merah — harga ── */
.prod-hanko {
  position: absolute;
  bottom: 10px; right: 10px;
  z-index: 3;
}
.prod-hanko-ring {
  width: 52px; height: 52px;
  border-radius: 50%;
  border: 2px solid rgba(139,32,32,.7);
  background: rgba(139,32,32,.15);
  backdrop-filter: blur(4px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow:
    0 0 0 1px rgba(139,32,32,.3),
    0 4px 12px rgba(139,32,32,.3);
  transition: transform .3s, box-shadow .3s;
}
.prod-card:hover .prod-hanko-ring {
  transform: rotate(-8deg) scale(1.05);
  box-shadow: 0 0 0 1px rgba(139,32,32,.5), 0 6px 18px rgba(139,32,32,.45);
}
.prod-hanko-price {
  font-family: 'Noto Serif JP', serif;
  font-size: 9px;
  font-weight: 600;
  color: rgba(245,240,232,.85);
  line-height: 1;
  text-align: center;
  letter-spacing: .02em;
}
.prod-hanko-label {
  font-size: 7px;
  color: rgba(139,32,32,.9);
  letter-spacing: .05em;
  font-weight: 500;
  margin-top: 1px;
}

/* Info bawah card */
.prod-info {
  padding: 14px 15px 16px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

/* Mon + nama produk */
.prod-header {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin-bottom: 8px;
}
.prod-mon {
  width: 22px; height: 22px;
  flex-shrink: 0;
  color: rgba(196,168,130,.35);
  margin-top: 2px;
  transition: color .3s;
}
.prod-card:hover .prod-mon { color: rgba(196,168,130,.65); }

.prod-name {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(13px, 1.1vw, 15px);
  font-weight: 300;
  color: rgba(245,240,232,.9);
  line-height: 1.35;
  letter-spacing: .03em;

  display: -webkit-box;
  -webkit-box-orient: vertical;

  /* WebKit */
  -webkit-line-clamp: 2;

  /* Standard */
  line-clamp: 2;

  overflow: hidden;
}

.prod-desc {
  font-size: 11px;
  line-height: 1.7;
  color: rgba(245,240,232,.3);
  font-weight: 300;
  margin-bottom: 12px;

  display: -webkit-box;
  -webkit-box-orient: vertical;

  /* WebKit */
  -webkit-line-clamp: 2;

  /* Standard */
  line-clamp: 2;

  overflow: hidden;
  flex: 1;
}

/* Footer card */
.prod-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  margin-top: auto;
  padding-top: 10px;
  border-top: 1px solid rgba(196,168,130,.08);
}

/* Price di footer (backup selain hanko) */
.prod-price-wrap { display: flex; flex-direction: column; gap: 1px; }
.prod-price-label {
  font-size: 8px;
  font-weight: 500;
  letter-spacing: .15em;
  text-transform: uppercase;
  color: rgba(196,168,130,.4);
}
.prod-price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 15px;
  font-weight: 600;
  color: #C4A882;
  letter-spacing: .02em;
}

/* CTA button — style lampion */
.prod-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .08em;
  color: rgba(245,240,232,.9);
  background: linear-gradient(135deg, #8B2020, #701a1a);
  border: 1px solid rgba(139,32,32,.5);
  padding: 7px 13px;
  border-radius: 2px;
  text-decoration: none;
  flex-shrink: 0;
  box-shadow: 0 3px 10px rgba(139,32,32,.3);
  transition: transform .2s, box-shadow .2s, background .2s;
}
.prod-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(139,32,32,.45);
  background: linear-gradient(135deg, #a02828, #8B2020);
  color: #fff;
  text-decoration: none;
}

/* ═══════════════════════════════════════
   TOMBOL LIHAT SEMUA
═══════════════════════════════════════ */
.chochin-show-more-wrap { text-align: center; margin-top: 36px; }
.chochin-show-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: rgba(196,168,130,.75);
  background: rgba(196,168,130,.05);
  border: 1px solid rgba(196,168,130,.2);
  padding: 12px 28px;
  border-radius: 2px;
  cursor: pointer;
  transition: all .25s;
}
.chochin-show-btn:hover {
  border-color: rgba(196,168,130,.4);
  color: #C4A882;
  background: rgba(196,168,130,.08);
}
.chochin-show-btn svg { transition: transform .3s; }
.chochin-show-btn.open svg { transform: rotate(180deg); }

/* ═══════════════════════════════════════
   CTA BAWAH
═══════════════════════════════════════ */
.chochin-cta-wrap {
  text-align: center;
  margin-top: 52px;
  padding-top: 40px;
  border-top: 1px solid rgba(196,168,130,.08);
}
.chochin-cta-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-style: italic;
  color: rgba(245,240,232,.35);
  margin-bottom: 20px;
}
.chochin-cta-btn {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: #F5F0E8;
  background: linear-gradient(135deg, #7A8C6E, #4A5E3A);
  border: 1px solid rgba(122,140,110,.3);
  padding: 14px 32px;
  border-radius: 2px;
  text-decoration: none;
  box-shadow: 0 6px 22px rgba(74,94,58,.3);
  transition: transform .25s, box-shadow .25s;
}
.chochin-cta-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(74,94,58,.45);
  color: #fff;
  text-decoration: none;
}

/* Empty state */
.chochin-empty {
  grid-column: 1 / -1;
  text-align: center;
  padding: 60px 20px;
}
.chochin-empty-icon { font-size: 48px; opacity: .3; margin-bottom: 12px; }
.chochin-empty-text {
  font-family: 'Noto Serif JP', serif;
  font-size: 18px;
  font-weight: 200;
  color: rgba(245,240,232,.3);
}

/* ── Responsive ── */
@media (max-width: 1100px) {
  .chochin-grid, #cards-extra-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
}
@media (max-width: 767px) {
  .chochin-grid, #cards-extra-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .chochin-inner   { padding: 56px 16px 64px; }
  .prod-info       { padding: 11px 12px 13px; }
  .chochin-lanterns-deco { gap: 16px; }
  .chochin-lamp-body { width: 28px; height: 42px; }
  .chochin-tabs-row { gap: 6px; }
  .chochin-tab { font-size: 11px; padding: 7px 12px 7px 10px; }
}
@media (max-width: 480px) {
  .chochin-grid, #cards-extra-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .chochin-lanterns-deco .chochin-lamp:nth-child(n+6) { display: none; }
}
</style>


<!-- KUMO TOP — dari section sebelumnya (putih → gelap) -->
<div style="position:relative;z-index:2;line-height:0;margin-bottom:-2px;background:#F7F2EA;">
  <svg viewBox="0 0 1440 110" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%">
    <path d="M0 0 L0 55 Q60 110 160 75 Q260 45 380 85 Q500 115 620 72 Q740 35 860 78 Q980 115 1100 72 Q1220 35 1320 75 Q1380 95 1440 62 L1440 0 Z" fill="#0f0d0a"/>
    <ellipse cx="100"  cy="64" rx="85"  ry="36" fill="#0f0d0a"/>
    <ellipse cx="60"   cy="80" rx="64"  ry="30" fill="#0f0d0a"/>
    <ellipse cx="150"  cy="50" rx="60"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="340"  cy="78" rx="90"  ry="34" fill="#0f0d0a"/>
    <ellipse cx="290"  cy="92" rx="68"  ry="28" fill="#0f0d0a"/>
    <ellipse cx="400"  cy="62" rx="60"  ry="24" fill="#0f0d0a"/>
    <ellipse cx="580"  cy="68" rx="88"  ry="32" fill="#0f0d0a"/>
    <ellipse cx="530"  cy="82" rx="64"  ry="27" fill="#0f0d0a"/>
    <ellipse cx="640"  cy="54" rx="58"  ry="22" fill="#0f0d0a"/>
    <ellipse cx="820"  cy="72" rx="85"  ry="33" fill="#0f0d0a"/>
    <ellipse cx="770"  cy="86" rx="62"  ry="27" fill="#0f0d0a"/>
    <ellipse cx="880"  cy="58" rx="57"  ry="22" fill="#0f0d0a"/>
    <ellipse cx="1060" cy="68" rx="82"  ry="31" fill="#0f0d0a"/>
    <ellipse cx="1010" cy="82" rx="60"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="1120" cy="54" rx="55"  ry="20" fill="#0f0d0a"/>
    <ellipse cx="1290" cy="70" rx="78"  ry="30" fill="#0f0d0a"/>
    <ellipse cx="1240" cy="84" rx="58"  ry="24" fill="#0f0d0a"/>
    <ellipse cx="1350" cy="56" rx="54"  ry="20" fill="#0f0d0a"/>
  </svg>
</div>


<section id="produk">
<div class="chochin-inner">

  <!-- ═══════════════════
       LAMPION DEKORASI HEADER
  ═══════════════════ -->
  <div class="chochin-lanterns-deco">
    <?php
    $lamp_colors = [
      ['body'=>'#8B2020','glow'=>'rgba(139,32,32,.8)','dark'=>'#5a1010'],
      ['body'=>'#C4A882','glow'=>'rgba(196,168,130,.6)','dark'=>'#8B6F5E'],
      ['body'=>'#8B2020','glow'=>'rgba(139,32,32,.8)','dark'=>'#5a1010'],
      ['body'=>'#7A8C6E','glow'=>'rgba(122,140,110,.7)','dark'=>'#4A5E3A'],
      ['body'=>'#8B2020','glow'=>'rgba(139,32,32,.8)','dark'=>'#5a1010'],
      ['body'=>'#C4A882','glow'=>'rgba(196,168,130,.6)','dark'=>'#8B6F5E'],
      ['body'=>'#8B2020','glow'=>'rgba(139,32,32,.8)','dark'=>'#5a1010'],
    ];
    foreach ($lamp_colors as $lc):
    ?>
    <div class="chochin-lamp">
      <div class="chochin-lamp-string"></div>
      <div class="chochin-lamp-body">
        <div class="chochin-lamp-glow"></div>
        <svg viewBox="0 0 36 52" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Topi -->
          <rect x="11" y="1" width="14" height="4" rx="1" fill="<?= $lc['dark'] ?>"/>
          <rect x="13" y="4" width="10" height="2" fill="<?= $lc['dark'] ?>"/>
          <!-- Tubuh lampion -->
          <ellipse cx="18" cy="27" rx="14" ry="20" fill="<?= $lc['body'] ?>" opacity=".85"/>
          <!-- Rusuk lampion -->
          <?php for ($r = 0; $r < 5; $r++): $y = 10 + $r * 8; ?>
          <path d="M5 <?= $y ?> Q18 <?= $y-2 ?> 31 <?= $y ?>" stroke="<?= $lc['dark'] ?>" stroke-width="1" opacity=".6"/>
          <?php endfor; ?>
          <!-- Cahaya dalam -->
          <ellipse cx="18" cy="24" rx="8" ry="12" fill="rgba(255,220,100,.18)"/>
          <!-- Bawah lampion -->
          <rect x="13" y="46" width="10" height="2" fill="<?= $lc['dark'] ?>"/>
          <rect x="15" y="48" width="6" height="3" rx="1" fill="<?= $lc['dark'] ?>"/>
          <!-- Tali bawah -->
          <line x1="18" y1="51" x2="18" y2="54" stroke="<?= $lc['dark'] ?>" stroke-width="1.5"/>
        </svg>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- ═══════════════════
       HEADER
  ═══════════════════ -->
  <header class="chochin-header">
    <div class="chochin-overline">
      <span class="chochin-overline-dot"></span>
      Koleksi Kami · 商品一覧
      <span style="font-family:'Noto Serif JP',serif;font-size:11px;color:rgba(196,168,130,.25);font-weight:300;">花屋</span>
    </div>

    <h2 class="chochin-title">
      Produk <em>Pilihan</em><br>
      <span style="font-size:.65em;letter-spacing:.12em;color:rgba(196,168,130,.5);font-family:'Zen Kaku Gothic New',sans-serif;font-weight:300;">Bunga Segar Jakarta Pusat</span>
    </h2>

    <div class="chochin-rule">
      <div class="chochin-rule-line"></div>
      <span class="chochin-rule-kanji">品 · 花 · 美</span>
      <div class="chochin-rule-line"></div>
    </div>

    <p class="chochin-subtitle">
      Setiap rangkaian dibuat dengan bunga segar pilihan terbaik,<br>siap diantar ke seluruh wilayah Jakarta Pusat.
    </p>
  </header>

  <!-- ═══════════════════
       PAPAN KAYU TABS
  ═══════════════════ -->
  <div class="chochin-tabs-board" style="margin-bottom:44px">
    <div class="chochin-tabs-bg"></div>
    <!-- Paku sudut -->
    <div class="chochin-nail"></div>
    <div class="chochin-nail"></div>
    <div class="chochin-nail"></div>
    <div class="chochin-nail"></div>

    <div class="chochin-tabs-row">

      <!-- Tab Semua -->
      <div class="chochin-tab-wrap">
        <button class="chochin-tab active" onclick="chochinFilter('semua',this,null)">
          <svg class="tab-mon" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="7" fill="none" stroke="currentColor" stroke-width="1.2"/>
            <circle cx="12" cy="12" r="3" fill="currentColor"/>
            <line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="1"/>
            <line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="1"/>
          </svg>
          Semua
          <span class="tab-count-badge"><?= count($all_products) ?></span>
        </button>
      </div>

      <?php foreach ($tab_cats as $idx => $tc):
        $rc  = $countByRoot[$tc['id']] ?? 0;
        $sub = $subsMap[$tc['id']] ?? [];
        $hs  = !empty($sub);
        $id  = (int)$tc['id'];
        $mon = $mon_symbols[$idx % count($mon_symbols)];
      ?>
      <div class="chochin-tab-wrap"<?= $hs ? ' id="cwrap-'.$id.'"' : '' ?>>
        <button class="chochin-tab"
                onclick="<?= $hs ? 'chochinToggleSub(event,'.$id.')' : 'chochinFilter(\''.$id.'\',this,null)' ?>">
          <svg class="tab-mon" viewBox="0 0 24 24"><?= $mon ?></svg>
          <?= e($tc['name']) ?>
          <span class="tab-count-badge"><?= $rc ?></span>
          <?php if ($hs): ?>
          <svg class="tab-chevron-dd" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
          </svg>
          <?php endif; ?>
        </button>

        <?php if ($hs): ?>
        <div class="chochin-sub-dd" id="csubdrop-<?= $id ?>">
          <button class="sub-dd-item" onclick="chochinFilter('root-<?= $id ?>',this,<?= $id ?>)">
            Semua <?= e($tc['name']) ?>
            <span class="sub-dd-count"><?= $rc ?></span>
          </button>
          <div class="sub-dd-divider"></div>
          <?php foreach ($sub as $ch): ?>
          <button class="sub-dd-item" onclick="chochinFilter('<?= $ch['id'] ?>',this,<?= $id ?>)">
            <?= e($ch['name']) ?>
            <span class="sub-dd-count"><?= $ch['prod_count'] ?></span>
          </button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>

    </div>
  </div>

  <!-- ═══════════════════
       PRODUK GRID — 8 pertama
  ═══════════════════ -->
  <div class="chochin-grid" id="produk-grid">
  <?php
  $shown = array_slice($all_products, 0, $CARD_INIT);
  foreach ($shown as $i => $prod):
    $img     = imgUrl($prod['image'], 'product');
    $wa_text = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga ".rupiah($prod['price']).". Apakah masih tersedia?");
    $price_short = rupiah($prod['price']);
    $mon_idx = array_search(getRootId((int)$prod['cat_id'], $catMap), array_column($tab_cats,'id'));
    $mon_idx = $mon_idx !== false ? $mon_idx : ($i % count($mon_symbols));
    $mon_svg = $mon_symbols[$mon_idx % count($mon_symbols)];
    /* Potong harga jadi singkat untuk hanko */
    preg_match('/[\d\.]+/', str_replace('.','', $price_short), $m);
    $harga_num = isset($m[0]) ? number_format((int)$m[0]/1000, 0, ',', '.') : '—';
  ?>
  <div class="prod-card"
       data-cat="<?= (int)$prod['cat_id'] ?>"
       data-root="<?= (int)$prod['root_cat_id'] ?>"
       style="animation-delay:<?= ($i % 4) * .07 ?>s">

    <!-- Tali gantung -->
    <div class="prod-card-string">
      <div class="prod-card-string-line"></div>
    </div>

    <div class="prod-card-body">
      <!-- Gambar -->
      <div class="prod-img-wrap">
        <img src="<?= e($img) ?>" alt="<?= e($prod['name']) ?>" loading="lazy">
        <div class="prod-img-overlay"></div>
        <?php if (!empty($prod['cat_name'])): ?>
        <span class="prod-cat-badge"><?= e($prod['cat_name']) ?></span>
        <?php endif; ?>

        <!-- Hanko stamp -->
        <div class="prod-hanko">
          <div class="prod-hanko-ring">
            <div class="prod-hanko-price"><?= $harga_num ?>k</div>
            <div class="prod-hanko-label">円</div>
          </div>
        </div>
      </div>

      <!-- Info -->
      <div class="prod-info">
        <div class="prod-header">
          <svg class="prod-mon" viewBox="0 0 24 24"><?= $mon_svg ?></svg>
          <h3 class="prod-name"><?= e($prod['name']) ?></h3>
        </div>

        <p class="prod-desc">
          <?= !empty($prod['description'])
              ? e(mb_substr(strip_tags($prod['description']), 0, 80))
              : 'Bunga segar berkualitas tinggi, siap diantar ke seluruh wilayah.' ?>
        </p>

        <div class="prod-footer">
          <div class="prod-price-wrap">
            <span class="prod-price-label">Mulai dari</span>
            <span class="prod-price"><?= $price_short ?></span>
          </div>
        <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_text ?>" 
   target="_blank"
   class="prod-btn" 
   onclick="event.stopPropagation()">
  <!-- Logo WhatsApp resmi -->
  <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
    <path d="M20.52 3.48A11.933 11.933 0 0012 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12 0-3.192-1.244-6.184-3.48-8.52zm-8.52 18a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818zm5.02-7.376c-.274.771-1.573 1.464-2.167 1.549-.577.084-1.327.12-3.55-1.29-1.31-.873-2.184-2.189-2.452-2.43-.268-.242-1.71-1.865-1.71-3.554 0-1.69.894-2.522 1.21-2.853.315-.33.701-.414.936-.414.234 0 .47.001.675.01.205.01.472-.082.742.563.27.644.919 2.227.999 2.39.08.162.135.36.002.58-.132.221-.198.356-.387.555-.193.202-.403.447-.575.602-.171.154-.349.33-.15.651.198.32.877 1.44 1.883 2.33 1.307 1.19 2.363 1.566 2.693 1.743.33.176.522.147.714-.088.192-.234.82-.958 1.047-1.284.228-.326.456-.268.768-.162.312.107 1.97.933 2.31 1.102.34.169.57.254.648.395.079.142.079.82-.195 1.591z"/>
  </svg>
  Pesan
</a>
        </div>
      </div>
    </div><!-- /prod-card-body -->
  </div>
  <?php endforeach; ?>
  </div><!-- /chochin-grid -->

  <?php
  $extra_products = array_slice($all_products, $CARD_INIT);
  if (!empty($extra_products)):
  ?>

  <!-- KUMO divider antara baris pertama & extra -->
  <div class="chochin-kumo-row" id="kumo-row-divider">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
      <ellipse cx="80"   cy="50" rx="75" ry="28" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="40"   cy="58" rx="55" ry="22" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="130"  cy="40" rx="58" ry="22" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="280"  cy="52" rx="80" ry="28" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="230"  cy="60" rx="60" ry="22" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="340"  cy="42" rx="55" ry="20" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="500"  cy="48" rx="82" ry="28" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="450"  cy="58" rx="62" ry="22" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="560"  cy="38" rx="52" ry="18" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="720"  cy="50" rx="78" ry="26" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="670"  cy="60" rx="58" ry="22" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="780"  cy="40" rx="55" ry="18" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="940"  cy="50" rx="76" ry="26" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="890"  cy="58" rx="58" ry="22" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="1000" cy="40" rx="52" ry="18" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="1160" cy="50" rx="74" ry="26" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="1110" cy="60" rx="56" ry="20" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="1220" cy="40" rx="50" ry="18" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="1360" cy="50" rx="72" ry="26" fill="rgba(196,168,130,.06)"/>
      <ellipse cx="1320" cy="60" rx="55" ry="20" fill="rgba(196,168,130,.06)"/>
    </svg>
  </div>

  <!-- Extra cards -->
  <div id="cards-extra-wrap">
    <div id="cards-extra-grid">
    <?php foreach ($extra_products as $i => $prod):
      $img     = imgUrl($prod['image'], 'product');
      $wa_text = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga ".rupiah($prod['price']).". Apakah masih tersedia?");
      $price_short = rupiah($prod['price']);
      $mon_idx = array_search(getRootId((int)$prod['cat_id'], $catMap), array_column($tab_cats,'id'));
      $mon_idx = $mon_idx !== false ? $mon_idx : ($i % count($mon_symbols));
      $mon_svg = $mon_symbols[$mon_idx % count($mon_symbols)];
      preg_match('/[\d\.]+/', str_replace('.','', $price_short), $m);
      $harga_num = isset($m[0]) ? number_format((int)$m[0]/1000, 0, ',', '.') : '—';
    ?>
    <div class="prod-card"
         data-cat="<?= (int)$prod['cat_id'] ?>"
         data-root="<?= (int)$prod['root_cat_id'] ?>"
         style="animation-delay:<?= ($i % 4) * .07 ?>s">
      <div class="prod-card-string"><div class="prod-card-string-line"></div></div>
      <div class="prod-card-body">
        <div class="prod-img-wrap">
          <img src="<?= e($img) ?>" alt="<?= e($prod['name']) ?>" loading="lazy">
          <div class="prod-img-overlay"></div>
          <?php if (!empty($prod['cat_name'])): ?>
          <span class="prod-cat-badge"><?= e($prod['cat_name']) ?></span>
          <?php endif; ?>
          <div class="prod-hanko">
            <div class="prod-hanko-ring">
              <div class="prod-hanko-price"><?= $harga_num ?>k</div>
              <div class="prod-hanko-label">円</div>
            </div>
          </div>
        </div>
        <div class="prod-info">
          <div class="prod-header">
            <svg class="prod-mon" viewBox="0 0 24 24"><?= $mon_svg ?></svg>
            <h3 class="prod-name"><?= e($prod['name']) ?></h3>
          </div>
          <p class="prod-desc">
            <?= !empty($prod['description'])
                ? e(mb_substr(strip_tags($prod['description']), 0, 80))
                : 'Bunga segar berkualitas tinggi, siap diantar ke seluruh wilayah.' ?>
          </p>
          <div class="prod-footer">
            <div class="prod-price-wrap">
              <span class="prod-price-label">Mulai dari</span>
              <span class="prod-price"><?= $price_short ?></span>
            </div>
         <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_text ?>" 
   target="_blank"
   class="prod-btn" 
   onclick="event.stopPropagation()">
  <!-- Logo WhatsApp resmi -->
  <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
    <path d="M20.52 3.48A11.933 11.933 0 0012 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12 0-3.192-1.244-6.184-3.48-8.52zm-8.52 18a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818zm5.02-7.376c-.274.771-1.573 1.464-2.167 1.549-.577.084-1.327.12-3.55-1.29-1.31-.873-2.184-2.189-2.452-2.43-.268-.242-1.71-1.865-1.71-3.554 0-1.69.894-2.522 1.21-2.853.315-.33.701-.414.936-.414.234 0 .47.001.675.01.205.01.472-.082.742.563.27.644.919 2.227.999 2.39.08.162.135.36.002.58-.132.221-.198.356-.387.555-.193.202-.403.447-.575.602-.171.154-.349.33-.15.651.198.32.877 1.44 1.883 2.33 1.307 1.19 2.363 1.566 2.693 1.743.33.176.522.147.714-.088.192-.234.82-.958 1.047-1.284.228-.326.456-.268.768-.162.312.107 1.97.933 2.31 1.102.34.169.57.254.648.395.079.142.079.82-.195 1.591z"/>
  </svg>
  Pesan
</a>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    </div>
  </div>

  <!-- Tombol lihat semua -->
  <div class="chochin-show-more-wrap">
    <button class="chochin-show-btn" id="chochin-show-btn" onclick="toggleChochinExtra(this)">
      <span id="chochin-show-label">Lihat Semua <?= count($all_products) ?> Produk</span>
      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
      </svg>
    </button>
  </div>

  <?php endif; ?>

  <!-- CTA -->
  <div class="chochin-cta-wrap">
    <p class="chochin-cta-text">Tidak menemukan yang kamu cari? Konsultasi langsung dengan kami 🌸</p>
   <?php 
$wa_msg = urlencode('Halo, saya ingin melihat katalog bunga lengkap.');
?>

<a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_msg ?>"
   target="_blank" class="chochin-cta-btn">
  <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
  </svg>
  Lihat Katalog Lengkap
  <span style="font-family:'Noto Serif JP',serif;font-size:10px;opacity:.6;font-weight:300;">目録</span>
</a>
  </div>

</div><!-- /chochin-inner -->
</section>


<!-- KUMO BOTTOM — dari gelap ke section berikutnya -->
<div style="position:relative;z-index:2;line-height:0;margin-top:-2px;background:#0f0d0a;">
  <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%">
    <?php $next_bg = '#FDFAF5'; /* warna section setelah produk */ ?>
    <path d="M0 100 L0 40 Q80 0 160 30 Q240 60 360 20 Q480 -10 600 28 Q720 65 840 22 Q960 -15 1080 30 Q1200 70 1320 28 Q1380 10 1440 38 L1440 100 Z" fill="<?= $next_bg ?>"/>
    <ellipse cx="120"  cy="42" rx="90"  ry="42" fill="<?= $next_bg ?>"/>
    <ellipse cx="80"   cy="56" rx="70"  ry="36" fill="<?= $next_bg ?>"/>
    <ellipse cx="170"  cy="28" rx="65"  ry="30" fill="<?= $next_bg ?>"/>
    <ellipse cx="380"  cy="22" rx="100" ry="40" fill="<?= $next_bg ?>"/>
    <ellipse cx="330"  cy="36" rx="72"  ry="32" fill="<?= $next_bg ?>"/>
    <ellipse cx="440"  cy="12" rx="68"  ry="28" fill="<?= $next_bg ?>"/>
    <ellipse cx="620"  cy="30" rx="95"  ry="38" fill="<?= $next_bg ?>"/>
    <ellipse cx="570"  cy="44" rx="68"  ry="30" fill="<?= $next_bg ?>"/>
    <ellipse cx="675"  cy="18" rx="62"  ry="26" fill="<?= $next_bg ?>"/>
    <ellipse cx="860"  cy="24" rx="92"  ry="36" fill="<?= $next_bg ?>"/>
    <ellipse cx="810"  cy="38" rx="66"  ry="30" fill="<?= $next_bg ?>"/>
    <ellipse cx="920"  cy="14" rx="60"  ry="25" fill="<?= $next_bg ?>"/>
    <ellipse cx="1100" cy="32" rx="88"  ry="34" fill="<?= $next_bg ?>"/>
    <ellipse cx="1050" cy="46" rx="64"  ry="28" fill="<?= $next_bg ?>"/>
    <ellipse cx="1155" cy="20" rx="58"  ry="24" fill="<?= $next_bg ?>"/>
    <ellipse cx="1320" cy="28" rx="85"  ry="33" fill="<?= $next_bg ?>"/>
    <ellipse cx="1270" cy="42" rx="62"  ry="27" fill="<?= $next_bg ?>"/>
    <ellipse cx="1375" cy="16" rx="56"  ry="22" fill="<?= $next_bg ?>"/>
  </svg>
</div>

<script>
/* ── Toggle sub-dropdown tab ── */
function chochinToggleSub(e, id) {
  e.stopPropagation();
  var wrap = document.getElementById('cwrap-' + id);
  var isOpen = wrap.classList.contains('open');
  document.querySelectorAll('.chochin-tab-wrap.open').forEach(function(w){ w.classList.remove('open'); });
  if (!isOpen) wrap.classList.add('open');
}
document.addEventListener('click', function() {
  document.querySelectorAll('.chochin-tab-wrap.open').forEach(function(w){ w.classList.remove('open'); });
});

/* ── Filter produk ── */
function chochinFilter(catId, btn, parentId) {
  /* Reset semua tab */
  document.querySelectorAll('.chochin-tab').forEach(function(t){ t.classList.remove('active'); });
  document.querySelectorAll('.sub-dd-item').forEach(function(s){ s.classList.remove('active'); });
  document.querySelectorAll('.chochin-tab-wrap.open').forEach(function(w){ w.classList.remove('open'); });

  /* Aktifkan tab yang diklik */
  if (btn.classList.contains('chochin-tab')) {
    btn.classList.add('active');
  } else {
    btn.classList.add('active');
    if (parentId) {
      var pw = document.getElementById('cwrap-' + parentId);
      if (pw) { var pt = pw.querySelector('.chochin-tab'); if (pt) pt.classList.add('active'); }
    }
  }

  /* Filter card */
  var allCards = Array.from(document.querySelectorAll('.prod-card'));
  var delay = 0;
  var hasInExtra = false;

  allCards.forEach(function(card) {
    var match = false;
    if      (catId === 'semua')            match = true;
    else if (catId.indexOf('root-') === 0) match = card.dataset.root === catId.replace('root-','');
    else                                   match = card.dataset.cat  === String(catId);

    if (match) {
      card.style.display = '';
      card.style.animation = 'none';
      card.offsetWidth;
      card.style.animation = 'cardRise .35s ease ' + delay + 's both';
      delay += 0.05;
      if (card.closest('#cards-extra-grid')) hasInExtra = true;
    } else {
      card.style.display = 'none';
    }
  });

  /* Kelola extra wrap */
  var extraWrap = document.getElementById('cards-extra-wrap');
  var showBtn   = document.getElementById('chochin-show-btn');
  var kumoDiv   = document.getElementById('kumo-row-divider');

  if (extraWrap) {
    if (catId === 'semua') {
      extraWrap.classList.remove('open');
      if (showBtn) showBtn.style.display = '';
      if (kumoDiv) kumoDiv.style.display = '';
    } else if (hasInExtra) {
      extraWrap.classList.add('open');
      if (showBtn) showBtn.style.display = 'none';
      if (kumoDiv) kumoDiv.style.opacity = '0.15';
    } else {
      extraWrap.classList.remove('open');
      if (showBtn) showBtn.style.display = 'none';
    }
  }

  /* Empty state */
  var grid = document.getElementById('produk-grid');
  var ex = grid.querySelector('.chochin-empty');
  if (ex) ex.remove();
  var vis = allCards.filter(function(c){ return c.style.display !== 'none'; });
  if (vis.length === 0) {
    grid.insertAdjacentHTML('beforeend',
      '<div class="chochin-empty"><div class="chochin-empty-icon">🏮</div><p class="chochin-empty-text">Belum ada produk di kategori ini</p></div>'
    );
  }
}

/* ── Toggle extra cards ── */
function toggleChochinExtra(btn) {
  var wrap  = document.getElementById('cards-extra-wrap');
  var label = document.getElementById('chochin-show-label');
  var isOpen = wrap.classList.contains('open');

  if (!isOpen) {
    wrap.classList.add('open');
    btn.classList.add('open');
    label.textContent = 'Sembunyikan';
    /* Trigger animasi card extra */
    document.querySelectorAll('#cards-extra-grid .prod-card').forEach(function(card, i) {
      card.style.animation = 'none';
      card.offsetWidth;
      card.style.animation = 'cardRise .35s ease ' + (i % 4 * 0.07) + 's both';
    });
  } else {
    document.getElementById('produk-grid').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    setTimeout(function() { wrap.classList.remove('open'); }, 280);
    btn.classList.remove('open');
    label.textContent = 'Lihat Semua <?= count($all_products) ?> Produk';
  }
}
</script>