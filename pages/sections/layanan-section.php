<?php
/* ============================================================
   LAYANAN SECTION — Lantern Gate | Zen Wabi-Sabi
   Konsep: Torii + Tirai Noren hover reveal, Kumo pembatas,
           Kanji watermark, Seigaiha bg, Brush stroke judul
============================================================ */

$parent_cats = array_filter($categories, fn($c) => empty($c['parent_id']) || $c['parent_id'] == 0);
$parent_cats = array_values($parent_cats);

$sub_cats = db()->query("
    SELECT * FROM categories
    WHERE parent_id IS NOT NULL AND parent_id != 0 AND status = 'active'
    ORDER BY urutan ASC, id ASC
")->fetchAll();

$subs_by_parent = [];
foreach ($sub_cats as $sc) {
    $subs_by_parent[$sc['parent_id']][] = $sc;
}

/* Kanji & ikon per indeks kategori (fallback) */
$kanji_list = ['花','美','愛','縁','命','輪','香','彩'];
$icon_list  = ['🌸','💐','🌺','🌹','🌷','🌼','🪷','🏵️'];
?>

<style>
/* ══════════════════════════════════════════════
   LAYANAN — LANTERN GATE
   Palet mengikuti hero: sumi, washi, matcha, bamboo
══════════════════════════════════════════════ */

/* ── Seigaiha SVG pattern (background) ── */
#layanan-zen {
  position: relative;
  background-color: #F7F2EA;
  overflow: hidden;
  font-family: 'Zen Kaku Gothic New', sans-serif;
}

/* Seigaiha pattern overlay */
#layanan-zen::before {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='28' fill='none' stroke='%238B6F5E' stroke-width='0.6' opacity='0.13'/%3E%3Ccircle cx='0' cy='60' r='28' fill='none' stroke='%238B6F5E' stroke-width='0.6' opacity='0.13'/%3E%3Ccircle cx='60' cy='60' r='28' fill='none' stroke='%238B6F5E' stroke-width='0.6' opacity='0.13'/%3E%3Ccircle cx='0' cy='0' r='28' fill='none' stroke='%238B6F5E' stroke-width='0.6' opacity='0.13'/%3E%3Ccircle cx='60' cy='0' r='28' fill='none' stroke='%238B6F5E' stroke-width='0.6' opacity='0.13'/%3E%3C/svg%3E");
  background-size: 60px 60px;
  pointer-events: none;
  opacity: 0.7;
}

/* ── KUMO top pembatas dari hero ── */
.layanan-kumo-top {
  position: relative;
  z-index: 2;
  margin-top: -2px;
  line-height: 0;
  pointer-events: none;
  overflow: hidden;
}
.layanan-kumo-top svg { width: 100%; display: block; }

/* ── KUMO bottom pembatas ke section berikutnya ── */
.layanan-kumo-bottom {
  position: relative;
  z-index: 2;
  margin-bottom: -2px;
  line-height: 0;
  pointer-events: none;
  overflow: hidden;
}
.layanan-kumo-bottom svg { width: 100%; display: block; }

/* ── Section inner ── */
.layanan-inner {
  position: relative;
  z-index: 1;
  max-width: 1380px;
  margin: 0 auto;
  padding: 72px 32px 80px;
}

/* ────────────────────────────
   HEADER SECTION
──────────────────────────── */
.layanan-header {
  text-align: center;
  margin-bottom: 64px;
  position: relative;
}

.layanan-overline {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .32em;
  text-transform: uppercase;
  color: #8B6F5E;
  margin-bottom: 18px;
}
.layanan-overline-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: #7A8C6E;
  animation: softPulse 2.5s infinite;
}
.layanan-overline-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 13px;
  color: rgba(196,168,130,.5);
  font-weight: 300;
}

/* Judul dengan brush stroke ornamen */
.layanan-title-wrap {
  position: relative;
  display: inline-block;
  margin-bottom: 10px;
}
.layanan-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(2rem, 4vw, 3.2rem);
  font-weight: 200;
  color: #1C1C1C;
  line-height: 1.12;
  letter-spacing: .04em;
}
.layanan-title em {
  font-style: italic;
  font-family: 'Cormorant Garamond', serif;
  font-weight: 300;
  color: #8B6F5E;
  font-size: 1.1em;
}
/* Brush stroke bawah judul — SVG inline */
.layanan-brush-stroke {
  display: block;
  margin: 8px auto 0;
  width: clamp(160px, 40%, 320px);
  opacity: .55;
}

.layanan-rule {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 14px;
  margin: 22px auto 18px;
  max-width: 360px;
}
.layanan-rule-line {
  flex: 1; height: 1px;
  background: linear-gradient(to right, transparent, #C4A882, transparent);
}
.layanan-rule-diamond {
  width: 5px; height: 5px;
  background: #7A8C6E;
  transform: rotate(45deg);
  flex-shrink: 0;
}

.layanan-subtitle {
  font-size: 13.5px;
  line-height: 1.85;
  color: rgba(28,28,28,.52);
  max-width: 520px;
  margin: 0 auto;
  font-weight: 300;
}

/* ────────────────────────────
   GATE GRID
──────────────────────────── */
.layanan-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}

/* ── Gate card ── */
.lgate {
  position: relative;
  border-radius: 4px;
  overflow: hidden;
  background: #1C1C1C;
  min-height: 440px;
  cursor: pointer;
  isolation: isolate;
  box-shadow: 0 12px 40px rgba(28,28,28,.22), 0 2px 0 rgba(196,168,130,.25);
  transition: transform .4s cubic-bezier(.25,.46,.45,.94), box-shadow .4s;
}
.lgate:hover {
  transform: translateY(-6px);
  box-shadow: 0 24px 60px rgba(28,28,28,.32), 0 2px 0 rgba(196,168,130,.4);
}

/* Kanji watermark besar */
.lgate-kanji {
  position: absolute;
  z-index: 1;
  font-family: 'Noto Serif JP', serif;
  font-weight: 700;
  font-size: clamp(120px, 14vw, 200px);
  color: rgba(245,240,232,.06);
  line-height: 1;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  pointer-events: none;
  user-select: none;
  transition: opacity .4s;
}
.lgate:hover .lgate-kanji { opacity: 0; }

/* Foto background */
.lgate-photo {
  position: absolute;
  inset: 0;
  z-index: 0;
}
.lgate-photo img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  filter: brightness(.55) saturate(.8) sepia(.15);
  transition: filter .6s ease, transform .8s cubic-bezier(.25,.46,.45,.94);
}
.lgate:hover .lgate-photo img {
  filter: brightness(.72) saturate(.95) sepia(.08);
  transform: scale(1.06);
}

/* Foto fallback (tanpa gambar) */
.lgate-photo-fallback {
  width: 100%; height: 100%;
  background: linear-gradient(135deg, #2a1a10 0%, #3d2b1f 50%, #1c1c1c 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 80px;
  opacity: .3;
  transition: opacity .4s;
}
.lgate:hover .lgate-photo-fallback { opacity: .45; }

/* Overlay gelap gradient */
.lgate-overlay {
  position: absolute;
  inset: 0;
  z-index: 2;
  background: linear-gradient(
    to top,
    rgba(11,10,8,.92) 0%,
    rgba(11,10,8,.55) 45%,
    rgba(11,10,8,.18) 100%
  );
  transition: opacity .4s;
}

/* ══ TORII ornamen atas ══ */
.lgate-torii {
  position: absolute;
  top: 0; left: 0; right: 0;
  z-index: 3;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 18px;
  pointer-events: none;
}
/* Balok atas torii */
.lgate-torii-beam {
  width: calc(100% - 40px);
  height: 9px;
  background: linear-gradient(to right, #8B2020, #c0392b, #8B2020);
  border-radius: 2px 2px 0 0;
  box-shadow: 0 3px 12px rgba(139,32,32,.5);
  position: relative;
}
.lgate-torii-beam::before,
.lgate-torii-beam::after {
  content: '';
  position: absolute;
  top: -5px;
  width: 100%;
  height: 5px;
  background: linear-gradient(to right, #701a1a, #a02828, #701a1a);
  border-radius: 2px;
}
/* Balok tengah tipis */
.lgate-torii-bar {
  width: calc(100% - 80px);
  height: 5px;
  background: linear-gradient(to right, #8B2020, #c0392b, #8B2020);
  border-radius: 1px;
  margin-top: 8px;
  box-shadow: 0 2px 8px rgba(139,32,32,.35);
}
/* Tiang kiri kanan */
.lgate-torii-legs {
  display: flex;
  justify-content: space-between;
  width: calc(100% - 80px);
  position: absolute;
  top: 18px;
}
.lgate-torii-leg {
  width: 8px;
  height: 40px;
  background: linear-gradient(to bottom, #8B2020, #701a1a);
  border-radius: 0 0 3px 3px;
  box-shadow: 2px 0 8px rgba(0,0,0,.3);
}
/* Ornamen gantung */
.lgate-torii-bell {
  font-size: 16px;
  margin-top: 6px;
  animation: ropeSwing 3s ease-in-out infinite;
  opacity: .8;
}

/* ══ NOREN tirai (reveal foto saat hover) ══ */
.lgate-noren {
  position: absolute;
  top: 0; left: 0; right: 0;
  z-index: 4;
  display: flex;
  gap: 3px;
  padding: 0 12px;
  pointer-events: none;
  /* Tinggi tirai = 60% card */
  height: 62%;
}
.lgate-noren-strip {
  flex: 1;
  position: relative;
  transform-origin: top center;
  transition: transform .55s cubic-bezier(.4,0,.2,1);
  /* Simulasi kain */
  background: linear-gradient(
    to bottom,
    #1a0f0a 0%,
    #2d1a10 30%,
    #3d2416 70%,
    #2d1a10 100%
  );
  border-radius: 0 0 6px 6px;
  overflow: hidden;
}
/* Tiap strip punya delay berbeda → efek gelombang */
.lgate-noren-strip:nth-child(1) { transition-delay: .00s; }
.lgate-noren-strip:nth-child(2) { transition-delay: .04s; }
.lgate-noren-strip:nth-child(3) { transition-delay: .08s; }
.lgate-noren-strip:nth-child(4) { transition-delay: .12s; }
.lgate-noren-strip:nth-child(5) { transition-delay: .16s; }
.lgate-noren-strip:nth-child(6) { transition-delay: .20s; }

/* Strip ganjil sedikit lebih panjang (asimetri kain) */
.lgate-noren-strip:nth-child(odd)  { height: 100%; }
.lgate-noren-strip:nth-child(even) { height: 92%; }

/* Pola kain pada strip */
.lgate-noren-strip::before {
  content: '';
  position: absolute;
  inset: 0;
  background: repeating-linear-gradient(
    to bottom,
    transparent 0px,
    transparent 18px,
    rgba(255,255,255,.04) 18px,
    rgba(255,255,255,.04) 19px
  );
}
/* Kanji pada strip tengah */
.lgate-noren-strip:nth-child(3)::after,
.lgate-noren-strip:nth-child(4)::after {
  content: attr(data-kanji);
  position: absolute;
  top: 12px;
  left: 50%;
  transform: translateX(-50%);
  font-family: 'Noto Serif JP', serif;
  font-size: 11px;
  color: rgba(196,168,130,.55);
  letter-spacing: .15em;
  writing-mode: vertical-rl;
  pointer-events: none;
}
/* Warna aksen tiap strip */
.lgate-noren-strip:nth-child(1),
.lgate-noren-strip:nth-child(6) {
  background: linear-gradient(to bottom, #1a0a14 0%, #2d1020 100%);
}
.lgate-noren-strip:nth-child(2),
.lgate-noren-strip:nth-child(5) {
  background: linear-gradient(to bottom, #0a1a10 0%, #102d16 100%);
}

/* Hover → tirai terangkat (scaleY 0) */
.lgate:hover .lgate-noren-strip {
  transform: scaleY(0);
}

/* ══ Badge nomor atas-kiri ══ */
.lgate-num {
  position: absolute;
  top: 72px; left: 18px;
  z-index: 5;
  font-family: 'Noto Serif JP', serif;
  font-size: 9px;
  letter-spacing: .25em;
  color: rgba(245,240,232,.55);
  background: rgba(28,28,28,.5);
  backdrop-filter: blur(8px);
  border: 1px solid rgba(196,168,130,.2);
  padding: 4px 10px;
  border-radius: 2px;
}

/* ══ KONTEN bawah card ══ */
.lgate-body {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  z-index: 6;
  padding: 24px 22px 26px;
}

/* Icon/emoji */
.lgate-icon {
  font-size: 20px;
  margin-bottom: 8px;
  display: block;
  transform: scale(1);
  transition: transform .3s;
}
.lgate:hover .lgate-icon { transform: scale(1.15) rotate(-5deg); }

/* Judul layanan */
.lgate-name {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(1.1rem, 1.6vw, 1.4rem);
  font-weight: 300;
  color: #F5F0E8;
  line-height: 1.25;
  margin-bottom: 8px;
  letter-spacing: .04em;
}

/* Garis ornamen di bawah nama */
.lgate-rule {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 10px;
}
.lgate-rule-line {
  height: 1px; width: 24px;
  background: linear-gradient(to right, #C4A882, transparent);
  transition: width .4s;
}
.lgate:hover .lgate-rule-line { width: 44px; }
.lgate-rule-dot {
  width: 3px; height: 3px;
  border-radius: 50%;
  background: #7A8C6E;
  flex-shrink: 0;
}

/* Deskripsi */
.lgate-desc {
  font-size: 11.5px;
  line-height: 1.75;
  color: rgba(245,240,232,.52);
  margin-bottom: 14px;
  font-weight: 300;
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transition: max-height .5s ease, opacity .4s ease;
}
.lgate:hover .lgate-desc {
  max-height: 80px;
  opacity: 1;
}

/* Sub-kategori pills */
.lgate-subs {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-bottom: 14px;
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transition: max-height .5s .05s ease, opacity .4s .05s ease;
}
.lgate:hover .lgate-subs {
  max-height: 60px;
  opacity: 1;
}
.lgate-sub-pill {
  font-size: 9.5px;
  font-weight: 500;
  letter-spacing: .06em;
  color: #C4A882;
  border: 1px solid rgba(196,168,130,.25);
  background: rgba(196,168,130,.08);
  padding: 3px 9px;
  border-radius: 2px;
  text-decoration: none;
  white-space: nowrap;
  transition: background .2s, border-color .2s;
}
.lgate-sub-pill:hover {
  background: rgba(196,168,130,.2);
  border-color: rgba(196,168,130,.5);
}

/* CTA link */
.lgate-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .16em;
  text-transform: uppercase;
  color: #C4A882;
  text-decoration: none;
  opacity: 0;
  transform: translateY(6px);
  transition: opacity .35s .1s, transform .35s .1s, gap .25s, color .2s;
}
.lgate:hover .lgate-cta {
  opacity: 1;
  transform: translateY(0);
}
.lgate-cta:hover {
  color: #F5F0E8;
  gap: 14px;
  text-decoration: none;
}
.lgate-cta svg { flex-shrink: 0; }

/* ── Row ke-2 jika lebih dari 3 kategori ── */
/* Kategori ke-4 dst sedikit lebih pendek */
.lgate:nth-child(n+4) { min-height: 380px; }

/* ── Kumo separator (di antara grid baris) ── */
.layanan-kumo-mid {
  position: relative;
  z-index: 2;
  pointer-events: none;
  overflow: hidden;
  margin: -14px 0;
  display: none; /* tampil hanya kalau ada baris ke-2 via JS */
}
.layanan-kumo-mid svg { width: 100%; display: block; }

/* ────────────────────────────
   RESPONSIVE
──────────────────────────── */
@media (max-width: 1100px) {
  .layanan-grid { grid-template-columns: repeat(2, 1fr); gap: 22px; }
  .lgate        { min-height: 400px; }
  .lgate:nth-child(n+4) { min-height: 370px; }
}
@media (max-width: 640px) {
  .layanan-grid         { grid-template-columns: 1fr; gap: 18px; }
  .lgate                { min-height: 360px; }
  .lgate:nth-child(n+4) { min-height: 340px; }
  .layanan-inner        { padding: 48px 16px 56px; }
  .lgate-noren          { padding: 0 8px; gap: 2px; }
  .lgate-desc           { font-size: 11px; }
}
</style>


<!-- ══════════════════════════════════
     KUMO ATAS — pembatas dari hero
══════════════════════════════════ -->
<div class="layanan-kumo-top">
  <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none">
    <defs>
      <radialGradient id="lk-top1" cx="20%" cy="0%" r="60%">
        <stop offset="0%"   stop-color="#F7F2EA" stop-opacity="1"/>
        <stop offset="100%" stop-color="#F7F2EA" stop-opacity="0"/>
      </radialGradient>
      <radialGradient id="lk-top2" cx="80%" cy="0%" r="60%">
        <stop offset="0%"   stop-color="#F7F2EA" stop-opacity="1"/>
        <stop offset="100%" stop-color="#F7F2EA" stop-opacity="0"/>
      </radialGradient>
    </defs>
    <!-- Base wave -->
    <path d="M0 100 L0 40 Q80 0 160 30 Q240 60 360 20 Q480 -10 600 28 Q720 65 840 22 Q960 -15 1080 30 Q1200 70 1320 28 Q1380 10 1440 38 L1440 100 Z"
          fill="#F7F2EA"/>
    <!-- Awan bulat-bulat di wave -->
    <ellipse cx="120"  cy="42" rx="90"  ry="42" fill="#F7F2EA"/>
    <ellipse cx="80"   cy="56" rx="70"  ry="36" fill="#F7F2EA"/>
    <ellipse cx="170"  cy="28" rx="65"  ry="30" fill="#F7F2EA"/>
    <ellipse cx="380"  cy="22" rx="100" ry="40" fill="#F7F2EA"/>
    <ellipse cx="330"  cy="36" rx="72"  ry="32" fill="#F7F2EA"/>
    <ellipse cx="440"  cy="12" rx="68"  ry="28" fill="#F7F2EA"/>
    <ellipse cx="620"  cy="30" rx="95"  ry="38" fill="#F7F2EA"/>
    <ellipse cx="570"  cy="44" rx="68"  ry="30" fill="#F7F2EA"/>
    <ellipse cx="675"  cy="18" rx="62"  ry="26" fill="#F7F2EA"/>
    <ellipse cx="860"  cy="24" rx="92"  ry="36" fill="#F7F2EA"/>
    <ellipse cx="810"  cy="38" rx="66"  ry="30" fill="#F7F2EA"/>
    <ellipse cx="920"  cy="14" rx="60"  ry="25" fill="#F7F2EA"/>
    <ellipse cx="1100" cy="32" rx="88"  ry="34" fill="#F7F2EA"/>
    <ellipse cx="1050" cy="46" rx="64"  ry="28" fill="#F7F2EA"/>
    <ellipse cx="1155" cy="20" rx="58"  ry="24" fill="#F7F2EA"/>
    <ellipse cx="1320" cy="28" rx="85"  ry="33" fill="#F7F2EA"/>
    <ellipse cx="1270" cy="42" rx="62"  ry="27" fill="#F7F2EA"/>
    <ellipse cx="1375" cy="16" rx="56"  ry="22" fill="#F7F2EA"/>
  </svg>
</div>

<!-- ══════════════════════════════════
     LAYANAN SECTION
══════════════════════════════════ -->
<section id="layanan-zen">
  <div class="layanan-inner">

    <!-- Header -->
    <header class="layanan-header">
      <div class="layanan-overline">
        <span class="layanan-overline-dot"></span>
        Layanan Kami · サービス
        <span class="layanan-overline-kanji">花屋</span>
      </div>

      <div class="layanan-title-wrap">
        <h2 class="layanan-title">
          Layanan <em>Spesial</em><br>
          untuk Setiap Momen
        </h2>

        <!-- Brush stroke SVG di bawah judul -->
        <svg class="layanan-brush-stroke" viewBox="0 0 320 18" xmlns="http://www.w3.org/2000/svg">
          <path d="M8 12 Q40 4 80 10 Q120 16 160 8 Q200 2 240 10 Q280 16 312 8"
                stroke="#7A8C6E" stroke-width="3.5" fill="none"
                stroke-linecap="round" stroke-linejoin="round"
                opacity=".7"/>
          <path d="M40 15 Q100 9 160 13 Q220 17 280 11"
                stroke="#C4A882" stroke-width="1.5" fill="none"
                stroke-linecap="round" opacity=".45"/>
        </svg>
      </div>

      <div class="layanan-rule">
        <div class="layanan-rule-line"></div>
        <div class="layanan-rule-diamond"></div>
        <span style="font-family:'Noto Serif JP',serif;font-size:9px;color:rgba(139,111,94,.55);letter-spacing:.2em;">和の花</span>
        <div class="layanan-rule-diamond"></div>
        <div class="layanan-rule-line" style="background:linear-gradient(to left,transparent,#C4A882,transparent)"></div>
      </div>

      <p class="layanan-subtitle">
        Kami menyediakan berbagai rangkaian bunga segar berkualitas tinggi,
        dirancang khusus untuk setiap momen spesial Anda di Jakarta Pusat.
      </p>
    </header>

    <!-- Gate Grid -->
    <div class="layanan-grid" id="layanan-grid">

      <?php foreach ($parent_cats as $i => $cat):
        $has_img  = !empty($cat['image']);
        $img_url  = $has_img ? e(imgUrl($cat['image'], 'category')) : '';
        $children = $subs_by_parent[$cat['id']] ?? [];
        $kanji    = $kanji_list[$i % count($kanji_list)];
        $icon     = !empty($cat['icon']) ? $cat['icon'] : $icon_list[$i % count($icon_list)];
        $num      = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $desc     = !empty($cat['description'])
                    ? $cat['description']
                    : 'Rangkaian ' . $cat['name'] . ' kami dirancang menggunakan bunga-bunga segar pilihan terbaik.';
      ?>

      <article class="lgate" data-index="<?= $i ?>">

        <!-- Foto BG -->
        <div class="lgate-photo">
          <?php if ($has_img): ?>
            <img src="<?= $img_url ?>" alt="<?= e($cat['name']) ?>" loading="lazy">
          <?php else: ?>
            <div class="lgate-photo-fallback"><?= $icon ?></div>
          <?php endif; ?>
        </div>

        <!-- Overlay -->
        <div class="lgate-overlay"></div>

        <!-- Kanji watermark -->
        <div class="lgate-kanji"><?= $kanji ?></div>

        <!-- Torii -->
        <div class="lgate-torii">
          <div class="lgate-torii-beam">
            <div class="lgate-torii-legs">
              <div class="lgate-torii-leg"></div>
              <div class="lgate-torii-leg"></div>
            </div>
          </div>
          <div class="lgate-torii-bar"></div>
          <span class="lgate-torii-bell">🔔</span>
        </div>

        <!-- Noren tirai — 6 strip -->
        <div class="lgate-noren">
          <div class="lgate-noren-strip" data-kanji="花"></div>
          <div class="lgate-noren-strip"></div>
          <div class="lgate-noren-strip" data-kanji="<?= $kanji ?>"></div>
          <div class="lgate-noren-strip" data-kanji="美"></div>
          <div class="lgate-noren-strip"></div>
          <div class="lgate-noren-strip"></div>
        </div>

        <!-- Badge nomor -->
        <div class="lgate-num"><?= $num ?> / <?= str_pad(count($parent_cats), 2, '0', STR_PAD_LEFT) ?></div>

        <!-- Body -->
        <div class="lgate-body">
          <span class="lgate-icon"><?= $icon ?></span>

          <h3 class="lgate-name"><?= e($cat['name']) ?></h3>

          <div class="lgate-rule">
            <div class="lgate-rule-line"></div>
            <div class="lgate-rule-dot"></div>
          </div>

          <p class="lgate-desc"><?= e(mb_substr(strip_tags($desc), 0, 100)) ?>...</p>

          <?php if (!empty($children)): ?>
          <div class="lgate-subs">
            <?php foreach (array_slice($children, 0, 4) as $ch): ?>
            <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
               class="lgate-sub-pill"><?= e($ch['name']) ?></a>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>

          <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/" class="lgate-cta">
            Lihat Koleksi
            <svg width="14" height="14" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </a>
        </div>

      </article>

      <?php endforeach; ?>

    </div><!-- /layanan-grid -->

  </div><!-- /layanan-inner -->
</section>

<!-- ══════════════════════════════════
     KUMO BAWAH — pembatas ke section berikutnya
══════════════════════════════════ -->
<div class="layanan-kumo-bottom">
  <svg viewBox="0 0 1440 110" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none">
    <!-- Warna bawah menyesuaikan section berikutnya (putih/rice) -->
    <path d="M0 0 L0 55 Q60 110 160 75 Q260 45 380 85 Q500 115 620 72 Q740 35 860 78 Q980 115 1100 72 Q1220 35 1320 75 Q1380 95 1440 62 L1440 0 Z"
          fill="#F7F2EA"/>
    <ellipse cx="100"  cy="64" rx="85"  ry="36" fill="#F7F2EA"/>
    <ellipse cx="60"   cy="80" rx="64"  ry="30" fill="#F7F2EA"/>
    <ellipse cx="150"  cy="52" rx="60"  ry="26" fill="#F7F2EA"/>
    <ellipse cx="340"  cy="78" rx="90"  ry="34" fill="#F7F2EA"/>
    <ellipse cx="290"  cy="92" rx="68"  ry="28" fill="#F7F2EA"/>
    <ellipse cx="400"  cy="64" rx="60"  ry="24" fill="#F7F2EA"/>
    <ellipse cx="580"  cy="68" rx="88"  ry="32" fill="#F7F2EA"/>
    <ellipse cx="530"  cy="82" rx="64"  ry="27" fill="#F7F2EA"/>
    <ellipse cx="640"  cy="56" rx="58"  ry="22" fill="#F7F2EA"/>
    <ellipse cx="820"  cy="72" rx="85"  ry="33" fill="#F7F2EA"/>
    <ellipse cx="770"  cy="86" rx="62"  ry="27" fill="#F7F2EA"/>
    <ellipse cx="880"  cy="60" rx="57"  ry="22" fill="#F7F2EA"/>
    <ellipse cx="1060" cy="68" rx="82"  ry="31" fill="#F7F2EA"/>
    <ellipse cx="1010" cy="82" rx="60"  ry="26" fill="#F7F2EA"/>
    <ellipse cx="1120" cy="56" rx="55"  ry="20" fill="#F7F2EA"/>
    <ellipse cx="1290" cy="70" rx="78"  ry="30" fill="#F7F2EA"/>
    <ellipse cx="1240" cy="84" rx="58"  ry="24" fill="#F7F2EA"/>
    <ellipse cx="1350" cy="58" rx="54"  ry="20" fill="#F7F2EA"/>
  </svg>
</div>