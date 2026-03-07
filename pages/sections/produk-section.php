<?php
/* ============================================================
   PRODUK SECTION — Manila Florist · Kertas Cream Warm
   Fungsi: filter tab (kategori + sub-dropdown), show more,
           kartu produk, CTA WA
============================================================ */

/* ── Recursive root category finder ── */
function getRootId(int $id, array &$map): int {
    if (!isset($map[$id])) return $id;
    $pid = (int)($map[$id]['parent_id'] ?? 0);
    return $pid === 0 ? $id : getRootId($pid, $map);
}

/* ── Bangun peta kategori ── */
$catMap = [];
foreach (db()->query(
    "SELECT id, name, slug, parent_id FROM categories WHERE status = 'active'"
)->fetchAll() as $c) {
    $catMap[$c['id']] = $c;
}

/* ── Produk aktif + root cat id ── */
$all_products = [];
foreach (db()->query("
    SELECT p.*, c.name AS cat_name, c.id AS cat_id, c.parent_id AS cat_pid
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'active'
    ORDER BY p.created_at DESC
")->fetchAll() as $p) {
    $p['root_cat_id'] = getRootId((int)$p['cat_id'], $catMap);
    $all_products[] = $p;
}

/* ── Root categories (tab utama) ── */
$tab_cats = [];
foreach ($catMap as $c) {
    if ((int)($c['parent_id'] ?? 0) === 0) $tab_cats[] = $c;
}
usort($tab_cats, fn($a, $b) => $a['id'] <=> $b['id']);

/* ── Sub-kategori per parent (hanya yang punya produk) ── */
$subsMap = [];
foreach ($catMap as $c) {
    $pid = (int)($c['parent_id'] ?? 0);
    if ($pid === 0) continue;
    $cnt = count(array_filter($all_products, fn($p) => $p['cat_id'] == $c['id']));
    if ($cnt > 0) {
        $c['prod_count'] = $cnt;
        $subsMap[$pid][] = $c;
    }
}

/* ── Jumlah produk per root cat ── */
$countByRoot = [];
foreach ($all_products as $p) {
    $countByRoot[$p['root_cat_id']] = ($countByRoot[$p['root_cat_id']] ?? 0) + 1;
}

$CARD_INIT = 8; /* kartu yang langsung tampil */

/* ── SVG icon paths per tab (bergantian, bukan emoji) ── */
$tab_icons = [
    /* grid/semua     */ 'M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z',
    /* bunga/rangkaian*/ 'M12 2C10 2 8 4 8 7c0 2 1 3.5 2.5 4.3V22h3V11.3C15 10.5 16 9 16 7c0-3-2-5-4-5z',
    /* bouquet/tangan */ 'M9 3s-2 3-2 6 2 5 5 5 5-2 5-5-2-6-2-6M12 14v8M9 18c-2 0-3 1-3 2.5M15 18c2 0 3 1 3 2.5',
    /* hati/wedding   */ 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l8.84 8.84 8.84-8.84a5.5 5.5 0 0 0 0-7.78z',
    /* daun/dekor     */ 'M12 22V12M12 12C10 9 7 8 5 9.5S3 14 5 16c1.5 1.5 4 2 7-4zM12 12c2-3 5-4 7-2.5s2 4.5 0 6.5c-1.5 1.5-4 2-7-4z',
    /* kotak/gift     */ 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16zM12 22V12M3.27 6.96L12 12l8.73-5.04',
    /* bintang/spesial*/ 'M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z',
    /* rumah/dekor    */ 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z',
];
?>

<style>
/* ══════════════════════════════════════════
   PRODUK SECTION — Manila Florist
   Background: var(--paper) / #FBF6EE
══════════════════════════════════════════ */

/* ── Wave divider helper ── */
.p-wave         { line-height: 0; }
.p-wave svg     { width: 100%; display: block; }

/* ── Section wrapper ── */
#produk {
  position: relative;
  background: var(--paper);
}

/* Grain texture — static, satu SVG, 0 animasi */
#produk::before {
  content: '';
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  opacity: .028;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 200px 200px;
}

.produk-inner {
  position: relative;
  z-index: 1;
  max-width: 1280px;
  margin: 0 auto;
  padding: 72px 32px 80px;
}

/* ════════════════════════
   HEADER
════════════════════════ */
.produk-header {
  text-align: center;
  margin-bottom: 48px;
}
.produk-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--manila);
  border: 1px solid var(--manila-dd);
  border-radius: 100px;
  padding: 6px 16px 6px 10px;
  margin-bottom: 20px;
}
.produk-badge-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--rose);
  flex-shrink: 0;
}
.produk-badge-text {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px;
  font-weight: 500;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--ink-l);
}
.produk-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.8vw, 3.2rem);
  font-weight: 600;
  color: var(--ink);
  line-height: 1.1;
  letter-spacing: -.01em;
}
.produk-title em {
  font-style: italic;
  font-weight: 300;
  color: var(--rose);
}
.produk-rule {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin: 18px auto 14px;
  max-width: 300px;
}
.produk-rule-line     { flex: 1; height: 1px; background: linear-gradient(to right, transparent, var(--manila-dd)); }
.produk-rule-line.rev { background: linear-gradient(to left, transparent, var(--manila-dd)); }
.produk-rule-dot      { width: 4px; height: 4px; border-radius: 50%; background: var(--rose-l); flex-shrink: 0; }
.produk-subtitle {
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  line-height: 1.8;
  color: var(--muted);
  max-width: 460px;
  margin: 0 auto;
}

/* ════════════════════════
   FILTER TABS
════════════════════════ */
.produk-tabs {
  margin-bottom: 36px;
}
.produk-tabs-row {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
  padding-bottom: 16px;
  border-bottom: 1px solid var(--border);
}

/* Tab button */
.produk-tab {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-family: 'Jost', sans-serif;
  font-size: 12.5px;
  font-weight: 500;
  letter-spacing: .02em;
  color: var(--muted);
  background: transparent;
  border: 1px solid transparent;
  padding: 7px 14px 7px 10px;
  border-radius: 100px;
  cursor: pointer;
  white-space: nowrap;
  transition: color .18s, background .18s, border-color .18s;
}
.produk-tab:hover {
  color: var(--ink);
  background: rgba(192,123,96,.07);
  border-color: var(--border);
}
.produk-tab.active {
  color: var(--ink);
  background: var(--manila);
  border-color: var(--manila-dd);
}

/* Icon SVG dalam tab */
.ptab-icon {
  width: 13px; height: 13px;
  stroke: currentColor;
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
  flex-shrink: 0;
  opacity: .55;
  transition: opacity .18s;
}
.produk-tab:hover .ptab-icon,
.produk-tab.active .ptab-icon { opacity: 1; }

/* Count pill */
.ptab-count {
  font-size: 9.5px;
  font-weight: 600;
  color: var(--muted);
  background: var(--manila);
  border: 1px solid var(--manila-dd);
  padding: 1px 6px;
  border-radius: 100px;
  transition: color .18s;
}
.produk-tab.active .ptab-count {
  color: var(--rose);
  background: var(--paper);
}

/* Chevron dropdown kecil */
.ptab-chevron {
  width: 9px; height: 9px;
  stroke: currentColor; fill: none;
  stroke-width: 2.5;
  flex-shrink: 0;
  opacity: .4;
  transition: transform .2s, opacity .2s;
}
.ptab-wrap.open .ptab-chevron {
  transform: rotate(180deg);
  opacity: .75;
}

/* ── Sub dropdown ── */
.ptab-wrap { position: relative; }

.ptab-sub {
  display: none;
  position: absolute;
  top: calc(100% + 8px);
  left: 0;
  min-width: 200px;
  background: var(--paper);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: 0 8px 24px rgba(42,31,20,.1);
  padding: 5px;
  z-index: 200;
}

/* Caret segitiga */
.ptab-sub::before {
  content: '';
  position: absolute;
  top: -5px; left: 18px;
  width: 8px; height: 8px;
  background: var(--paper);
  border-left: 1px solid var(--border);
  border-top: 1px solid var(--border);
  transform: rotate(45deg);
}
.ptab-wrap.open .ptab-sub { display: block; }

.ptab-sub-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  width: 100%;
  padding: 8px 12px;
  border-radius: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 12.5px;
  color: var(--ink-l);
  background: none;
  border: none;
  text-align: left;
  cursor: pointer;
  transition: background .15s, color .15s;
}
.ptab-sub-item:hover  { background: rgba(192,123,96,.07); color: var(--rose); }
.ptab-sub-item.active { color: var(--rose); font-weight: 500; }
.ptab-sub-count {
  font-size: 9px;
  color: var(--muted);
  background: var(--manila);
  border: 1px solid var(--manila-dd);
  padding: 1px 7px;
  border-radius: 100px;
  flex-shrink: 0;
}
.ptab-sub-divider {
  height: 1px;
  background: var(--border);
  margin: 3px 8px;
}

/* ════════════════════════
   PRODUCT GRID
════════════════════════ */
@keyframes pCardUp {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: translateY(0); }
}

.produk-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

/* Extra cards wrapper */
.produk-extra-wrap {
  overflow: hidden;
  max-height: 0;
  opacity: 0;
  transition: max-height .55s cubic-bezier(.4,0,.2,1), opacity .4s ease;
}
.produk-extra-wrap.open {
  max-height: 9999px;
  opacity: 1;
}
.produk-extra-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  padding-top: 20px;
}

/* Pemisah tipis antara grid utama & extra */
.produk-extra-rule {
  height: 1px;
  background: linear-gradient(to right, transparent, var(--manila-dd), transparent);
  margin: 0;
  opacity: 0;
  transition: opacity .4s .2s;
}
.produk-extra-wrap.open ~ .produk-extra-rule,
.produk-extra-rule.visible { opacity: 1; }

/* ── Kartu produk ── */
.pcard {
  position: relative;
  border-radius: 10px;
  overflow: hidden;
  background: var(--paper);
  border: 1px solid rgba(255,255,255,.75);
  box-shadow:
    2px 4px 14px rgba(42,31,20,.1),
    0 1px 2px rgba(42,31,20,.05);
  display: flex;
  flex-direction: column;
  transition: transform .28s ease, box-shadow .28s ease;
  animation: pCardUp .3s ease both;
}
.pcard:hover {
  transform: translateY(-5px);
  box-shadow:
    4px 12px 28px rgba(42,31,20,.14),
    0 2px 6px rgba(42,31,20,.07);
}

/* Foto */
.pcard-photo {
  position: relative;
  width: 100%;
  aspect-ratio: 3/4;
  overflow: hidden;
  background: var(--manila-d);
  flex-shrink: 0;
}
.pcard-photo img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform .4s ease;
}
.pcard:hover .pcard-photo img { transform: scale(1.04); }

/* Overlay gradient */
.pcard-photo::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 55%;
  background: linear-gradient(to top, rgba(42,31,20,.32), transparent);
  pointer-events: none;
}

/* Badge kategori */
.pcard-cat {
  position: absolute;
  top: 10px; left: 10px;
  z-index: 2;
  background: rgba(251,246,238,.88);
  backdrop-filter: blur(4px);
  border: 1px solid var(--manila-dd);
  padding: 3px 9px;
  border-radius: 100px;
  font-family: 'Jost', sans-serif;
  font-size: 8.5px;
  font-weight: 600;
  letter-spacing: .09em;
  text-transform: uppercase;
  color: var(--muted);
}

/* Harga di foto — kotak kecil pojok kanan bawah */
.pcard-price-tag {
  position: absolute;
  bottom: 10px; right: 10px;
  z-index: 3;
  background: rgba(42,31,20,.82);
  color: var(--paper);
  font-family: 'Cormorant Garamond', serif;
  font-size: 13.5px;
  font-weight: 600;
  padding: 4px 9px;
  border-radius: 5px;
  letter-spacing: .01em;
  backdrop-filter: blur(4px);
}

/* Foto placeholder */
.pcard-photo-ph {
  width: 100%; height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--manila) 0%, var(--manila-d) 100%);
}
.pcard-photo-ph svg {
  width: 40px; height: 40px;
  stroke: var(--ink-l);
  fill: none;
  stroke-width: 1.2;
  stroke-linecap: round;
  stroke-linejoin: round;
  opacity: .22;
}

/* Body */
.pcard-body {
  padding: 13px 15px 15px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.pcard-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.08rem;
  font-weight: 600;
  color: var(--ink);
  line-height: 1.3;
  margin-bottom: 5px;
  letter-spacing: -.01em;

  display: -webkit-box;
  -webkit-box-orient: vertical;

  -webkit-line-clamp: 2; /* Chrome, Safari, Edge lama */
  line-clamp: 2;         /* Standard property */

  overflow: hidden;
}
.pcard-desc {
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  line-height: 1.7;
  color: var(--muted);
  margin-bottom: 12px;
  flex: 1;

  display: -webkit-box;
  -webkit-box-orient: vertical;

  -webkit-line-clamp: 2; /* WebKit browsers */
  line-clamp: 2;         /* Standard property */

  overflow: hidden;
}
/* Footer */
.pcard-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  padding-top: 10px;
  border-top: 1px solid var(--border);
  margin-top: auto;
}
.pcard-price-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 8px;
  font-weight: 500;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--muted);
  margin-bottom: 1px;
}
.pcard-price {
  font-family: 'Cormorant Garamond', serif;
  font-size: 14.5px;
  font-weight: 600;
  color: var(--ink);
  letter-spacing: .01em;
  line-height: 1;
}

/* Tombol WA */
.pcard-wa {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .04em;
  color: var(--paper);
  background: var(--ink);
  border: none;
  padding: 7px 12px;
  border-radius: 100px;
  text-decoration: none;
  flex-shrink: 0;
  transition: background .2s, transform .2s;
}
.pcard-wa:hover {
  background: var(--ink-l);
  transform: translateY(-1px);
  color: var(--paper);
  text-decoration: none;
}
.pcard-wa svg { flex-shrink: 0; }

/* ════════════════════════
   SHOW MORE BUTTON
════════════════════════ */
.produk-more {
  text-align: center;
  margin-top: 30px;
}
.produk-more-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Jost', sans-serif;
  font-size: 11.5px;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--ink-l);
  background: transparent;
  border: 1.5px solid var(--manila-dd);
  padding: 11px 24px;
  border-radius: 100px;
  cursor: pointer;
  transition: color .2s, border-color .2s, background .2s;
}
.produk-more-btn:hover {
  color: var(--rose);
  border-color: rgba(192,123,96,.4);
  background: rgba(192,123,96,.05);
}
.produk-more-btn svg {
  flex-shrink: 0;
  transition: transform .3s ease;
}
.produk-more-btn.open svg { transform: rotate(180deg); }

/* ════════════════════════
   EMPTY STATE
════════════════════════ */
.produk-empty {
  grid-column: 1 / -1;
  text-align: center;
  padding: 60px 20px;
}
.produk-empty svg {
  width: 44px; height: 44px;
  stroke: var(--manila-dd);
  fill: none;
  stroke-width: 1.2;
  margin: 0 auto 12px;
  display: block;
}
.produk-empty-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: 19px;
  font-weight: 300;
  font-style: italic;
  color: var(--muted);
}

/* ════════════════════════
   CTA BAWAH
════════════════════════ */
.produk-cta {
  text-align: center;
  margin-top: 52px;
  padding-top: 36px;
  border-top: 1px solid var(--border);
}
.produk-cta-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: 17px;
  font-style: italic;
  font-weight: 300;
  color: var(--muted);
  margin-bottom: 20px;
}
.produk-cta-btn {
  display: inline-flex;
  align-items: center;
  gap: 9px;
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--paper);
  background: var(--ink);
  padding: 13px 28px;
  border-radius: 100px;
  text-decoration: none;
  transition: background .2s, transform .2s;
}
.produk-cta-btn:hover {
  background: var(--ink-l);
  transform: translateY(-2px);
  color: var(--paper);
  text-decoration: none;
}

/* ════════════════════════
   RESPONSIVE
════════════════════════ */
@media (max-width: 1100px) {
  .produk-grid,
  .produk-extra-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 767px) {
  .produk-grid,
  .produk-extra-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .produk-inner      { padding: 48px 16px 56px; }
}
</style>

<!-- Wave atas: manila → paper -->
<div class="p-wave" style="background:var(--manila)">
  <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 0 C360 48 1080 0 1440 48 L1440 0 Z" fill="var(--paper)"/>
  </svg>
</div>

<section id="produk">
<div class="produk-inner">

  <!-- ════════ HEADER ════════ -->
  <header class="produk-header">
    <div class="produk-badge">
      <span class="produk-badge-dot"></span>
      <span class="produk-badge-text">Koleksi Bunga · Jakarta Pusat</span>
    </div>
    <h2 class="produk-title">Produk <em>Pilihan</em></h2>
    <div class="produk-rule">
      <div class="produk-rule-line"></div>
      <div class="produk-rule-dot"></div>
      <div class="produk-rule-line rev"></div>
    </div>
    <p class="produk-subtitle">
      Setiap rangkaian dibuat dengan bunga segar pilihan,
      siap diantar ke seluruh wilayah Jakarta Pusat.
    </p>
  </header>

  <!-- ════════ FILTER TABS ════════ -->
  <div class="produk-tabs">
    <div class="produk-tabs-row">

      <!-- Semua -->
      <div class="ptab-wrap">
        <button class="produk-tab active"
                onclick="pFilter('semua',this,null)">
          <svg class="ptab-icon" viewBox="0 0 24 24">
            <path d="M3 3h7v7H3zM14 3h7v7h-7zM3 14h7v7H3zM14 14h7v7h-7z"/>
          </svg>
          Semua
          <span class="ptab-count"><?= count($all_products) ?></span>
        </button>
      </div>

      <?php foreach ($tab_cats as $idx => $tc):
        $rc   = $countByRoot[$tc['id']] ?? 0;
        $subs = $subsMap[$tc['id']] ?? [];
        $hasSub = !empty($subs);
        $tid  = (int)$tc['id'];
        $ipath = $tab_icons[$idx % count($tab_icons)];
      ?>
      <div class="ptab-wrap"<?= $hasSub ? ' id="ptw-'.$tid.'"' : '' ?>>
        <button class="produk-tab"
                onclick="<?= $hasSub
                  ? 'pToggleSub(event,'.$tid.')'
                  : 'pFilter(\''.$tid.'\',this,null)' ?>">
          <svg class="ptab-icon" viewBox="0 0 24 24">
            <path d="<?= $ipath ?>"/>
          </svg>
          <?= e($tc['name']) ?>
          <span class="ptab-count"><?= $rc ?></span>
          <?php if ($hasSub): ?>
          <svg class="ptab-chevron" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
          <?php endif; ?>
        </button>

        <?php if ($hasSub): ?>
        <div class="ptab-sub" id="pts-<?= $tid ?>">
          <button class="ptab-sub-item"
                  onclick="pFilter('root-<?= $tid ?>',this,<?= $tid ?>)">
            Semua <?= e($tc['name']) ?>
            <span class="ptab-sub-count"><?= $rc ?></span>
          </button>
          <div class="ptab-sub-divider"></div>
          <?php foreach ($subs as $sub): ?>
          <button class="ptab-sub-item"
                  onclick="pFilter('<?= $sub['id'] ?>',this,<?= $tid ?>)">
            <?= e($sub['name']) ?>
            <span class="ptab-sub-count"><?= $sub['prod_count'] ?></span>
          </button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>

    </div>
  </div>

  <!-- ════════ GRID UTAMA (8 pertama) ════════ -->
  <div class="produk-grid" id="produk-grid">
    <?php
    $shown = array_slice($all_products, 0, $CARD_INIT);
    foreach ($shown as $i => $prod):
      $img     = !empty($prod['image']) ? e(imgUrl($prod['image'], 'product')) : '';
      $price   = rupiah($prod['price']);
      $wa_text = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga {$price}. Apakah masih tersedia?");
      $desc    = !empty($prod['description'])
                 ? e(mb_substr(strip_tags($prod['description']), 0, 72))
                 : 'Bunga segar berkualitas, siap diantar ke seluruh Jakarta Pusat.';
    ?>
    <article class="pcard"
             data-cat="<?= (int)$prod['cat_id'] ?>"
             data-root="<?= (int)$prod['root_cat_id'] ?>"
             style="animation-delay:<?= ($i % 4) * .06 ?>s">

      <div class="pcard-photo">
        <?php if ($img): ?>
          <img src="<?= $img ?>" alt="<?= e($prod['name']) ?>" loading="lazy">
        <?php else: ?>
          <div class="pcard-photo-ph">
            <svg viewBox="0 0 24 24">
              <path d="M12 2C10 2 8 4 8 7c0 2 1 3.5 2.5 4.3V22h3V11.3C15 10.5 16 9 16 7c0-3-2-5-4-5z"/>
            </svg>
          </div>
        <?php endif; ?>
        <?php if (!empty($prod['cat_name'])): ?>
          <span class="pcard-cat"><?= e($prod['cat_name']) ?></span>
        <?php endif; ?>
        <span class="pcard-price-tag"><?= $price ?></span>
      </div>

      <div class="pcard-body">
        <h3 class="pcard-name"><?= e($prod['name']) ?></h3>
        <p class="pcard-desc"><?= $desc ?></p>
        <div class="pcard-footer">
          <div>
            <div class="pcard-price-lbl">Mulai dari</div>
            <div class="pcard-price"><?= $price ?></div>
          </div>
          <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_text ?>"
             target="_blank" rel="noopener"
             class="pcard-wa"
             onclick="event.stopPropagation()">
            <!-- WhatsApp icon -->
            <svg width="11" height="11" fill="white" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
            Pesan
          </a>
        </div>
      </div>

    </article>
    <?php endforeach; ?>
  </div>

  <?php if (count($all_products) > $CARD_INIT): ?>

  <!-- Garis pemisah tipis — muncul saat extra terbuka -->
  <div class="produk-extra-rule" id="produk-extra-rule"></div>

  <!-- Extra cards -->
  <div class="produk-extra-wrap" id="produk-extra-wrap">
    <div class="produk-extra-grid" id="produk-extra-grid">
      <?php
      $extras = array_slice($all_products, $CARD_INIT);
      foreach ($extras as $i => $prod):
        $img     = !empty($prod['image']) ? e(imgUrl($prod['image'], 'product')) : '';
        $price   = rupiah($prod['price']);
        $wa_text = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga {$price}. Apakah masih tersedia?");
        $desc    = !empty($prod['description'])
                   ? e(mb_substr(strip_tags($prod['description']), 0, 72))
                   : 'Bunga segar berkualitas, siap diantar ke seluruh Jakarta Pusat.';
      ?>
      <article class="pcard"
               data-cat="<?= (int)$prod['cat_id'] ?>"
               data-root="<?= (int)$prod['root_cat_id'] ?>"
               style="animation-delay:<?= ($i % 4) * .06 ?>s">

        <div class="pcard-photo">
          <?php if ($img): ?>
            <img src="<?= $img ?>" alt="<?= e($prod['name']) ?>" loading="lazy">
          <?php else: ?>
            <div class="pcard-photo-ph">
              <svg viewBox="0 0 24 24">
                <path d="M12 2C10 2 8 4 8 7c0 2 1 3.5 2.5 4.3V22h3V11.3C15 10.5 16 9 16 7c0-3-2-5-4-5z"/>
              </svg>
            </div>
          <?php endif; ?>
          <?php if (!empty($prod['cat_name'])): ?>
            <span class="pcard-cat"><?= e($prod['cat_name']) ?></span>
          <?php endif; ?>
          <span class="pcard-price-tag"><?= $price ?></span>
        </div>

        <div class="pcard-body">
          <h3 class="pcard-name"><?= e($prod['name']) ?></h3>
          <p class="pcard-desc"><?= $desc ?></p>
          <div class="pcard-footer">
            <div>
              <div class="pcard-price-lbl">Mulai dari</div>
              <div class="pcard-price"><?= $price ?></div>
            </div>
            <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_text ?>"
               target="_blank" rel="noopener"
               class="pcard-wa"
               onclick="event.stopPropagation()">
              <svg width="11" height="11" fill="white" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
              </svg>
              Pesan
            </a>
          </div>
        </div>

      </article>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Show more button -->
  <div class="produk-more">
    <button class="produk-more-btn" id="produk-more-btn"
            onclick="pToggleExtra(this)">
      <span id="produk-more-label">
        Lihat Semua <?= count($all_products) ?> Produk
      </span>
      <svg width="12" height="12" fill="none" stroke="currentColor"
           stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
      </svg>
    </button>
  </div>

  <?php endif; ?>

  <!-- ════════ CTA BAWAH ════════ -->
  <div class="produk-cta">
    <p class="produk-cta-text">
      Tidak menemukan yang kamu cari? Konsultasi langsung dengan kami.
    </p>
    <?php $wa_catalog = urlencode('Halo, saya ingin melihat katalog bunga lengkap.'); ?>
    <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_catalog ?>"
       target="_blank" rel="noopener"
       class="produk-cta-btn">
      <svg width="13" height="13" fill="white" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
      </svg>
      Lihat Katalog Lengkap
    </a>
  </div>

</div>
</section>

<!-- Wave bawah: paper → manila -->
<div class="p-wave" style="background:var(--paper)">
  <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 48 C360 0 1080 48 1440 0 L1440 48 Z" fill="var(--manila)"/>
  </svg>
</div>

<script>
(function () {
  'use strict';

  /* ─────────────────────────────────
     Sub-dropdown tab
  ───────────────────────────────── */
  function closeAllSubs() {
    document.querySelectorAll('.ptab-wrap.open')
      .forEach(function (w) { w.classList.remove('open'); });
  }

  window.pToggleSub = function (e, id) {
    e.stopPropagation();
    var wrap   = document.getElementById('ptw-' + id);
    var isOpen = wrap.classList.contains('open');
    closeAllSubs();
    if (!isOpen) wrap.classList.add('open');
  };

  document.addEventListener('click', closeAllSubs);
  document.querySelectorAll('.ptab-sub').forEach(function (s) {
    s.addEventListener('click', function (e) { e.stopPropagation(); });
  });

  /* ─────────────────────────────────
     Filter produk
  ───────────────────────────────── */
  window.pFilter = function (catId, btn, parentId) {
    /* Reset semua active state */
    document.querySelectorAll('.produk-tab').forEach(function (t) { t.classList.remove('active'); });
    document.querySelectorAll('.ptab-sub-item').forEach(function (s) { s.classList.remove('active'); });
    closeAllSubs();

    /* Tandai tab aktif */
    if (btn.classList.contains('produk-tab')) {
      btn.classList.add('active');
    } else {
      btn.classList.add('active');
      if (parentId !== null) {
        var pw = document.getElementById('ptw-' + parentId);
        if (pw) {
          var pt = pw.querySelector('.produk-tab');
          if (pt) pt.classList.add('active');
        }
      }
    }

    /* Filter semua card */
    var allCards   = Array.from(document.querySelectorAll('.pcard'));
    var delay      = 0;
    var hasInExtra = false;

    allCards.forEach(function (card) {
      var match;
      if      (catId === 'semua')                   match = true;
      else if (catId.indexOf('root-') === 0)         match = card.dataset.root === catId.slice(5);
      else                                           match = card.dataset.cat  === String(catId);

      if (match) {
        card.style.display = '';
        /* Re-trigger animasi masuk — hanya opacity+translateY, ringan */
        card.style.animation = 'none';
        void card.offsetWidth; /* force reflow — 1 kali per card, aman */
        card.style.animation = 'pCardUp .28s ease ' + (delay * 0.05) + 's both';
        delay++;
        if (card.closest('#produk-extra-grid')) hasInExtra = true;
      } else {
        card.style.display = 'none';
      }
    });

    /* Kelola extra wrap & show-more button */
    var extraWrap = document.getElementById('produk-extra-wrap');
    var moreBtn   = document.getElementById('produk-more-btn');
    var extraRule = document.getElementById('produk-extra-rule');

    if (extraWrap) {
      if (catId === 'semua') {
        /* Kembalikan ke kondisi awal */
        extraWrap.classList.remove('open');
        if (moreBtn)   { moreBtn.style.display = ''; moreBtn.classList.remove('open'); }
        if (extraRule)   extraRule.classList.remove('visible');
        /* Reset label show more */
        var lbl = document.getElementById('produk-more-label');
        if (lbl) lbl.textContent = 'Lihat Semua <?= count($all_products) ?> Produk';
      } else if (hasInExtra) {
        /* Ada hasil di bagian extra → buka langsung, sembunyikan tombol */
        extraWrap.classList.add('open');
        if (extraRule) extraRule.classList.add('visible');
        if (moreBtn)   moreBtn.style.display = 'none';
      } else {
        /* Tidak ada hasil di extra */
        extraWrap.classList.remove('open');
        if (extraRule) extraRule.classList.remove('visible');
        if (moreBtn)   moreBtn.style.display = 'none';
      }
    }

    /* Empty state */
    var grid   = document.getElementById('produk-grid');
    var oldEmp = grid.querySelector('.produk-empty');
    if (oldEmp) oldEmp.remove();

    var visible = allCards.filter(function (c) { return c.style.display !== 'none'; });
    if (visible.length === 0) {
      grid.insertAdjacentHTML('beforeend',
        '<div class="produk-empty">' +
          '<svg viewBox="0 0 24 24">' +
            '<path d="M12 2C10 2 8 4 8 7c0 2 1 3.5 2.5 4.3V22h3V11.3C15 10.5 16 9 16 7c0-3-2-5-4-5z"/>' +
          '</svg>' +
          '<p class="produk-empty-text">Belum ada produk di kategori ini</p>' +
        '</div>'
      );
    }
  };

  /* ─────────────────────────────────
     Toggle extra cards
  ───────────────────────────────── */
  window.pToggleExtra = function (btn) {
    var wrap   = document.getElementById('produk-extra-wrap');
    var lbl    = document.getElementById('produk-more-label');
    var rule   = document.getElementById('produk-extra-rule');
    var isOpen = wrap.classList.contains('open');
    var total  = <?= count($all_products) ?>;

    if (!isOpen) {
      wrap.classList.add('open');
      btn.classList.add('open');
      if (rule) rule.classList.add('visible');
      lbl.textContent = 'Sembunyikan';

      /* Animasi card extra */
      document.querySelectorAll('#produk-extra-grid .pcard')
        .forEach(function (card, idx) {
          card.style.animation = 'none';
          void card.offsetWidth;
          card.style.animation = 'pCardUp .28s ease ' + (idx % 4 * 0.05) + 's both';
        });
    } else {
      /* Scroll halus ke grid, lalu tutup */
      var grid = document.getElementById('produk-grid');
      grid.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      setTimeout(function () {
        wrap.classList.remove('open');
        if (rule) rule.classList.remove('visible');
      }, 280);
      btn.classList.remove('open');
      lbl.textContent = 'Lihat Semua ' + total + ' Produk';
    }
  };

})();
</script>