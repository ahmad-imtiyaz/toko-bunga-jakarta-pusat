<?php
/* ================================================================
   AREA SECTION — Emaki Sumi-e Map | Zen Wabi-Sabi
   Konsep: Gulungan peta bergaya tinta sumi-e Jepang kuno,
           atas gelap langit malam → bawah cream washi,
           pin hanko merah tiap kecamatan, awan kumo mengapit,
           kanji nama area, stats bar pengiriman, hover khas Jepang
================================================================ */
?>

<style>
/* ══════════════════════════════════════════════
   EMAKI SUMI-E MAP — AREA SECTION
   Atas: sumi night gelap | Bawah: washi cream terang
══════════════════════════════════════════════ */

#area {
  position: relative;
  overflow: hidden;
  font-family: 'Zen Kaku Gothic New', sans-serif;
}

/* Gradient besar gelap → terang */
#area::before {
  content: '';
  position: absolute;
  inset: 0; z-index: 0;
  background: linear-gradient(
    to bottom,
    #0f0d0a  0%,
    #1a1510  18%,
    #2d2318  35%,
    #8B6F5E  55%,
    #C4A882  70%,
    #EDE8DF  82%,
    #F5F0E8  100%
  );
  pointer-events: none;
}

/* Bintang-bintang di bagian atas gelap */
#area::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; height: 45%;
  z-index: 0;
  background-image:
    radial-gradient(1px 1px at 8%  12%, rgba(245,240,232,.4) 0%, transparent 100%),
    radial-gradient(1px 1px at 22% 7%,  rgba(245,240,232,.3) 0%, transparent 100%),
    radial-gradient(1px 1px at 38% 18%, rgba(245,240,232,.35) 0%, transparent 100%),
    radial-gradient(1px 1px at 54% 5%,  rgba(245,240,232,.25) 0%, transparent 100%),
    radial-gradient(1.5px 1.5px at 67% 14%, rgba(245,240,232,.4) 0%, transparent 100%),
    radial-gradient(1px 1px at 82% 9%,  rgba(245,240,232,.3) 0%, transparent 100%),
    radial-gradient(1px 1px at 91% 20%, rgba(196,168,130,.5) 0%, transparent 100%),
    radial-gradient(1px 1px at 15% 28%, rgba(245,240,232,.2) 0%, transparent 100%),
    radial-gradient(1px 1px at 72% 22%, rgba(245,240,232,.25) 0%, transparent 100%),
    radial-gradient(1px 1px at 44% 30%, rgba(245,240,232,.2) 0%, transparent 100%);
  pointer-events: none;
}

/* ══ Kumo TOP — dari keunggulan cream ke gelap ══ */
.area-kumo-top {
  position: relative; z-index: 2;
  line-height: 0; margin-top: -2px;
  pointer-events: none; overflow: hidden;
}
.area-kumo-top svg { width: 100%; display: block; }

/* ══ INNER ══ */
.emaki-inner {
  position: relative; z-index: 1;
  max-width: 1380px;
  margin: 0 auto;
  padding: 80px 40px 0;
}

/* ══════════════
   HEADER — di bagian gelap
══════════════ */
.emaki-header {
  text-align: center;
  margin-bottom: 56px;
  position: relative;
}

/* Bulan artistik di belakang header */
.emaki-moon {
  position: absolute;
  top: -60px; left: 50%;
  transform: translateX(-50%);
  width: clamp(180px, 24vw, 300px);
  height: clamp(180px, 24vw, 300px);
  border-radius: 50%;
  background: radial-gradient(circle at 38% 36%,
    rgba(255,248,220,.14) 0%,
    rgba(230,218,180,.08) 40%,
    transparent 70%
  );
  pointer-events: none;
  animation: moonGlow 8s ease-in-out infinite;
}

.emaki-overline {
  display: inline-flex; align-items: center; gap: 10px;
  font-size: 10px; font-weight: 500;
  letter-spacing: .32em; text-transform: uppercase;
  color: rgba(196,168,130,.75); margin-bottom: 18px;
}
.emaki-overline-dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: #8B2020;
  box-shadow: 0 0 6px rgba(139,32,32,.8);
  animation: softPulse 2.5s infinite;
}

.emaki-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(1.9rem, 3.6vw, 2.9rem);
  font-weight: 200; color: #F5F0E8;
  line-height: 1.12; letter-spacing: .04em;
  margin-bottom: 10px;
}
.emaki-title em {
  font-style: italic;
  font-family: 'Cormorant Garamond', serif;
  color: #C4A882; font-size: 1.1em;
}

.emaki-brush {
  display: block; margin: 10px auto 20px;
  width: clamp(130px, 26%, 240px); opacity: .45;
}

.emaki-rule {
  display: flex; align-items: center; justify-content: center; gap: 14px;
  margin-bottom: 12px;
}
.emaki-rule-line {
  flex: 1; max-width: 90px; height: 1px;
  background: linear-gradient(to right, transparent, rgba(196,168,130,.35), transparent);
}
.emaki-rule-diamond {
  width: 5px; height: 5px; background: #7A8C6E; transform: rotate(45deg);
}

.emaki-subtitle {
  font-size: 12.5px; line-height: 1.85;
  color: rgba(245,240,232,.42); max-width: 440px;
  margin: 0 auto; font-weight: 300;
}

/* ══════════════════════════════════════════════════
   EMAKI GULUNGAN PEMBUNGKUS PETA
   Rod kayu atas & bawah seperti gulungan emaki
══════════════════════════════════════════════════ */
.emaki-scroll-wrap {
  position: relative;
  margin-bottom: 0;
}

/* Rod atas — kayu gulungan */
.emaki-rod-top {
  width: 100%;
  height: 22px;
  background: linear-gradient(to bottom, #d4a96a 0%, #8B6030 40%, #c49050 60%, #6b4520 100%);
  border-radius: 6px;
  box-shadow:
    0 6px 20px rgba(0,0,0,.45),
    inset 0 1px 0 rgba(255,255,255,.18),
    inset 0 -1px 0 rgba(0,0,0,.2);
  position: relative; z-index: 3;
}
.emaki-rod-top::before, .emaki-rod-top::after {
  content: '';
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 38px; height: 38px; border-radius: 50%;
  background: radial-gradient(circle at 33% 33%, #eebc74, #8B5a20);
  box-shadow: 0 5px 14px rgba(0,0,0,.5);
  border: 2px solid rgba(255,255,255,.12);
}
.emaki-rod-top::before { left: -12px; }
.emaki-rod-top::after  { right: -12px; }

/* Label rod atas */
.emaki-rod-label {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-family: 'Noto Serif JP', serif;
  font-size: 9px; color: rgba(245,240,232,.45);
  letter-spacing: .35em; white-space: nowrap; pointer-events: none;
}

/* Canvas peta — area utama gulungan */
.emaki-canvas {
  position: relative;
  background:
    /* Washi texture */
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.68' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"),
    /* Sepia gradient washi */
    linear-gradient(160deg, #f2e8d2 0%, #ede0c6 25%, #e8d9bc 75%, #dfd0b0 100%);
  border-left:  8px solid #6b4520;
  border-right: 8px solid #6b4520;
  padding: 48px 52px 52px;
  overflow: hidden;
}

/* Woodgrain strip di tepi kiri kanan canvas */
.emaki-canvas::before {
  content: '';
  position: absolute; top: 0; left: 0; bottom: 0; width: 8px;
  background: repeating-linear-gradient(
    to bottom,
    #8B6030 0px, #a07040 18px, #6a4520 18px, #5a3818 20px, #8B6030 20px
  );
}
.emaki-canvas::after {
  content: '';
  position: absolute; top: 0; right: 0; bottom: 0; width: 8px;
  background: repeating-linear-gradient(
    to bottom,
    #8B6030 0px, #a07040 18px, #6a4520 18px, #5a3818 20px, #8B6030 20px
  );
}

/* ══ Ornamen kanji besar transparan di bg peta ══ */
.emaki-bg-kanji {
  position: absolute; z-index: 0;
  font-family: 'Noto Serif JP', serif; font-weight: 700;
  color: rgba(139,111,94,.04); pointer-events: none; user-select: none;
}
.emaki-bg-kanji-1 {
  font-size: clamp(180px, 22vw, 320px);
  top: -30px; right: -20px; line-height: 1;
  animation: kanjiFloat 12s ease-in-out infinite;
}
.emaki-bg-kanji-2 {
  font-size: clamp(90px, 11vw, 160px);
  bottom: -10px; left: 0; line-height: 1;
  animation: kanjiFloat 16s ease-in-out infinite;
  animation-delay: -6s;
}

/* ══ SUMI-E ILLUSTRATION — ilustrasi tinta di background ══ */
.emaki-sumi-art {
  position: absolute; inset: 0; z-index: 0;
  pointer-events: none; overflow: hidden;
}

/* ══ HEADER sub-section peta ══ */
.emaki-map-header {
  position: relative; z-index: 2;
  text-align: center; margin-bottom: 36px;
}
.emaki-map-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(1.1rem, 1.8vw, 1.5rem);
  font-weight: 200; color: rgba(42,26,16,.7);
  letter-spacing: .06em;
}
.emaki-map-title span {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; color: #8B6030; font-size: 1.15em;
}
.emaki-map-subtitle {
  font-size: 11px; color: rgba(42,26,16,.42);
  letter-spacing: .22em; font-weight: 300;
  font-family: 'Noto Serif JP', serif; margin-top: 4px;
}

/* ════════════════════════════════════
   LOCATION CARDS — Papan nama desa Jepang
══════════════════════════════════════ */
.emaki-loc-grid {
  position: relative; z-index: 2;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
}

/* Card lokasi */
.emaki-loc-card {
  position: relative;
  display: flex; flex-direction: column;
  text-decoration: none;
  cursor: pointer;
  transition: transform .35s cubic-bezier(.25,.46,.45,.94);
}
.emaki-loc-card:hover { transform: translateY(-8px); }

/* Tali gantung di atas card */
.elc-string {
  display: flex; justify-content: center;
  margin-bottom: -1px;
}
.elc-string-line {
  width: 1.5px; height: 20px;
  background: linear-gradient(to bottom, rgba(139,96,48,.55), rgba(139,96,48,.2));
}

/* Body card — papan kayu desa */
.elc-body {
  background:
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.82' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"),
    linear-gradient(160deg, #f8f0e0 0%, #f2e8d0 50%, #eee0c4 100%);
  border: 1px solid rgba(139,96,48,.2);
  border-top: 3px solid rgba(139,32,32,.45);
  border-radius: 3px;
  padding: 18px 16px 16px;
  flex: 1;
  display: flex; flex-direction: column; gap: 8px;
  position: relative; overflow: hidden;
  box-shadow:
    0 4px 16px rgba(42,26,16,.1),
    inset 0 1px 0 rgba(255,255,255,.5);
  transition: border-color .3s, box-shadow .3s, background .3s;
}
.emaki-loc-card:hover .elc-body {
  border-color: rgba(139,32,32,.7);
  border-top-color: rgba(139,32,32,.85);
  box-shadow: 0 12px 36px rgba(42,26,16,.18), inset 0 1px 0 rgba(255,255,255,.6);
  background:
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.82' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"),
    linear-gradient(160deg, #fdf7eb 0%, #f8eed8 50%, #f4e6cc 100%);
}

/* Glow torii merah saat hover */
.elc-body::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(to right, transparent, rgba(139,32,32,.6), transparent);
  opacity: 0; transition: opacity .3s;
}
.emaki-loc-card:hover .elc-body::before { opacity: 1; }

/* Kanji besar transparan di card */
.elc-bg-kanji {
  position: absolute; bottom: -8px; right: 4px;
  font-family: 'Noto Serif JP', serif;
  font-size: 64px; font-weight: 700;
  color: rgba(139,96,48,.055);
  line-height: 1; pointer-events: none; user-select: none;
  transition: opacity .3s, transform .4s;
  transform: rotate(-5deg);
}
.emaki-loc-card:hover .elc-bg-kanji {
  opacity: .1;
  transform: rotate(-3deg) scale(1.08);
}

/* Header card — Hanko pin + nama */
.elc-header {
  display: flex; align-items: center; gap: 10px;
}

/* Pin hanko merah — ikon lokasi khas Jepang */
.elc-hanko {
  width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
  background: linear-gradient(135deg, #a02828, #6b1a1a);
  border: 1.5px solid rgba(139,32,32,.5);
  box-shadow: 0 3px 10px rgba(139,32,32,.3);
  display: flex; align-items: center; justify-content: center;
  transition: transform .3s ease, box-shadow .3s;
}
.emaki-loc-card:hover .elc-hanko {
  transform: scale(1.12) rotate(-6deg);
  box-shadow: 0 5px 16px rgba(139,32,32,.45);
}
.elc-hanko svg { width: 14px; height: 14px; color: rgba(245,240,232,.9); }

.elc-name-wrap { flex: 1; min-width: 0; }

/* Nama area — utama */
.elc-name {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(12.5px, 1.05vw, 14px);
  font-weight: 400; color: #2a1a10;
  line-height: 1.25; letter-spacing: .02em;
  margin-bottom: 2px;
  transition: color .25s;
}
.emaki-loc-card:hover .elc-name { color: #6b1a1a; }

/* Kanji nama kecil */
.elc-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 9px; font-weight: 300;
  color: rgba(139,96,48,.45); letter-spacing: .18em;
  display: block;
}

/* Garis ornamen */
.elc-divider {
  height: 1px;
  background: linear-gradient(to right, rgba(139,96,48,.2), rgba(139,96,48,.08), transparent);
}

/* Deskripsi */
.elc-desc {
  font-size: 10.5px; line-height: 1.7;
  color: rgba(42,26,16,.45); font-weight: 300; flex: 1;
}

/* Badge estimasi */
.elc-badge {
  display: inline-flex; align-items: center; gap: 5px;
  background: rgba(139,32,32,.08);
  border: 1px solid rgba(139,32,32,.18);
  padding: 4px 10px; border-radius: 2px;
  font-size: 9.5px; font-weight: 500; letter-spacing: .1em;
  color: rgba(139,32,32,.75); width: fit-content;
  transition: background .25s, border-color .25s;
}
.emaki-loc-card:hover .elc-badge {
  background: rgba(139,32,32,.14);
  border-color: rgba(139,32,32,.35);
}
.elc-badge-dot {
  width: 4px; height: 4px; border-radius: 50%;
  background: #8B2020;
  box-shadow: 0 0 4px rgba(139,32,32,.7);
  animation: softPulse 2s infinite;
}

/* CTA link */
.elc-cta {
  display: flex; align-items: center; gap: 5px;
  font-size: 9.5px; font-weight: 500; letter-spacing: .1em; text-transform: uppercase;
  color: rgba(139,96,48,.6);
  transition: gap .25s, color .25s;
}
.emaki-loc-card:hover .elc-cta { gap: 9px; color: #8B2020; }
.elc-cta svg { transition: transform .25s; }
.emaki-loc-card:hover .elc-cta svg { transform: translateX(3px); }

/* ══ Sumi-e stroke dekoratif di bawah grid ══ */
.emaki-sumi-bottom {
  position: relative; z-index: 2;
  margin-top: 40px;
  display: flex; align-items: center; gap: 14px;
}
.emaki-sumi-line {
  flex: 1; height: 1px;
  background: linear-gradient(to right, transparent, rgba(139,96,48,.25), transparent);
}
.emaki-sumi-text {
  font-family: 'Noto Serif JP', serif;
  font-size: 10px; color: rgba(139,96,48,.45);
  letter-spacing: .3em; font-weight: 300;
}

/* Rod bawah */
.emaki-rod-bottom {
  width: 100%; height: 22px;
  background: linear-gradient(to bottom, #d4a96a 0%, #8B6030 40%, #c49050 60%, #6b4520 100%);
  border-radius: 6px;
  box-shadow:
    0 -3px 12px rgba(0,0,0,.25),
    0 6px 20px rgba(0,0,0,.4),
    inset 0 1px 0 rgba(255,255,255,.18);
  position: relative; z-index: 3;
}
.emaki-rod-bottom::before, .emaki-rod-bottom::after {
  content: '';
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 38px; height: 38px; border-radius: 50%;
  background: radial-gradient(circle at 33% 33%, #eebc74, #8B5a20);
  box-shadow: 0 5px 14px rgba(0,0,0,.5);
  border: 2px solid rgba(255,255,255,.12);
}
.emaki-rod-bottom::before { left: -12px; }
.emaki-rod-bottom::after  { right: -12px; }

/* ══════════════════════════════════════════
   STATS BAR — di bagian terang bawah
══════════════════════════════════════════ */
.emaki-statsbar-wrap {
  position: relative; z-index: 1;
  background: linear-gradient(160deg, #f5f0e8 0%, #ede8df 100%);
  padding: 0 40px 0;
  max-width: 100%;
}

.emaki-stats-rule {
  display: flex; align-items: center; gap: 16px;
  max-width: 1380px; margin: 0 auto;
  padding: 48px 0 28px;
}
.emaki-stats-rule-line {
  flex: 1; height: 1px;
  background: linear-gradient(to right, transparent, rgba(139,111,94,.28), transparent);
}
.emaki-stats-rule-text {
  font-family: 'Noto Serif JP', serif; font-size: 10.5px;
  color: rgba(139,111,94,.48); letter-spacing: .28em; font-weight: 300;
}

.emaki-statsbar {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 16px; max-width: 900px; margin: 0 auto 0;
}

.emaki-stat-block {
  background:
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E"),
    linear-gradient(160deg, #fdf8f0 0%, #f8f0e4 100%);
  border: 1px solid rgba(196,168,130,.22);
  border-radius: 3px;
  padding: 26px 20px 22px; text-align: center;
  position: relative; overflow: hidden;
  box-shadow: 0 4px 16px rgba(42,26,16,.06);
  transition: transform .3s, box-shadow .3s, border-color .3s;
}
.emaki-stat-block:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 28px rgba(42,26,16,.1);
  border-color: rgba(196,168,130,.42);
}
/* Garis atas dekoratif */
.emaki-stat-block::before {
  content: '';
  position: absolute; top: 0; left: 20%; right: 20%; height: 2px;
  background: linear-gradient(to right, transparent, rgba(196,168,130,.4), transparent);
}
.emaki-stat-block::after {
  content: '';
  position: absolute; top: 0; left: 50%; transform: translateX(-50%);
  width: 1px; height: 30%;
  background: linear-gradient(to bottom, rgba(196,168,130,.25), transparent);
}

.emaki-stat-icon {
  font-family: 'Noto Serif JP', serif;
  font-size: 20px; color: rgba(139,111,94,.45);
  font-weight: 300; display: block; margin-bottom: 10px;
  transition: color .3s;
}
.emaki-stat-block:hover .emaki-stat-icon { color: rgba(139,96,48,.7); }

.emaki-stat-num {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(22px, 2.6vw, 30px); font-weight: 600;
  color: #1C1C1C; line-height: 1; margin-bottom: 5px;
}
.emaki-stat-num sup { font-size: .44em; color: #8B6F5E; font-weight: 300; vertical-align: super; }
.emaki-stat-label {
  font-size: 9.5px; font-weight: 500; letter-spacing: .2em; text-transform: uppercase;
  color: rgba(28,28,28,.38); display: block; margin-bottom: 3px;
}
.emaki-stat-label-jp {
  font-family: 'Noto Serif JP', serif; font-size: 8.5px;
  color: rgba(139,111,94,.4); letter-spacing: .1em; display: block;
}

/* Jarak atas & bawah stats bar */
.emaki-statsbar-wrap {
  padding: 80px 20px 60px;
}

/* Jarak antara stats bar dan CTA */
.emaki-footer-cta {
  padding: 70px 20px 90px;
  margin-top: 40px;
}

/* ══ CTA footer ══ */
.emaki-footer-cta {
  text-align: center;
  padding: 44px 16px 80px;
  /* Background lebih gelap agar teks & button terlihat jelas */
  background: linear-gradient(160deg, #2a1e14 0%, #1e1510 100%);
  position: relative;
}
/* Kumo kecil dekoratif di dalam footer cta */
.emaki-footer-cta::before {
  content: '';
  position: absolute; inset: 0; pointer-events: none;
  background-image:
    radial-gradient(1px 1px at 15% 30%, rgba(245,240,232,.12) 0%, transparent 100%),
    radial-gradient(1px 1px at 55% 20%, rgba(245,240,232,.1) 0%, transparent 100%),
    radial-gradient(1px 1px at 80% 35%, rgba(196,168,130,.15) 0%, transparent 100%);
}
.emaki-footer-quote {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px; font-style: italic;
  /* Warna terang agar kontras di background gelap */
  color: rgba(245,240,232,.82);
  margin-bottom: 24px;
  position: relative; z-index: 1;
}
.emaki-footer-quote span {
  display: block; font-family: 'Noto Serif JP', serif;
  font-size: 9.5px; font-style: normal; font-weight: 300;
  color: rgba(196,168,130,.65); letter-spacing: .22em; margin-top: 6px;
}
.emaki-footer-btns {
  display: flex; align-items: center; justify-content: center;
  gap: 12px; flex-wrap: wrap;
  position: relative; z-index: 1;
}
.emaki-btn-primary {
  display: inline-flex; align-items: center; gap: 9px;
  font-size: 11.5px; font-weight: 500; letter-spacing: .08em; color: #F5F0E8;
  background: linear-gradient(135deg, #8B2020, #5a1a1a);
  /* Border lebih tebal & jelas */
  border: 1.5px solid rgba(200,80,80,.55);
  padding: 13px 26px; border-radius: 2px; text-decoration: none;
  box-shadow: 0 4px 20px rgba(139,32,32,.45), 0 0 0 1px rgba(200,80,80,.1);
  transition: transform .25s, box-shadow .25s, border-color .25s;
}
.emaki-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 32px rgba(139,32,32,.6), 0 0 0 1px rgba(200,80,80,.25);
  border-color: rgba(200,80,80,.8);
  color: #fff; text-decoration: none;
}
.emaki-btn-secondary {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 11.5px; font-weight: 400; letter-spacing: .06em;
  /* Warna teks lebih terang & kontras */
  color: rgba(196,168,130,.9);
  /* Border jelas terlihat di background gelap */
  border: 1.5px solid rgba(196,168,130,.45);
  background: rgba(196,168,130,.08);
  padding: 12px 20px; border-radius: 2px; text-decoration: none;
  transition: border-color .25s, color .25s, background .25s;
}
.emaki-btn-secondary:hover {
  border-color: #C4A882;
  color: #F5F0E8;
  background: rgba(196,168,130,.18); text-decoration: none;
}

/* ══ Kumo BOTTOM ══ */
.area-kumo-bottom {
  position: relative; z-index: 2;
  line-height: 0; pointer-events: none; overflow: hidden;
}
.area-kumo-bottom svg { width: 100%; display: block; }

/* ─── Responsive ─── */
@media (max-width: 1100px) {
  .emaki-loc-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1023px) {
  .emaki-inner { padding: 64px 24px 0; }
  .emaki-canvas { padding: 36px 36px 40px; }
  .emaki-statsbar-wrap { padding: 0 24px; }
  .emaki-statsbar { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 767px) {
  .emaki-loc-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .emaki-canvas { padding: 24px 20px 28px; }
  .emaki-statsbar { grid-template-columns: 1fr; max-width: 340px; }
  .emaki-inner { padding: 48px 16px 0; }
  .emaki-statsbar-wrap { padding: 0 16px; }
}
@media (max-width: 480px) {
  .emaki-loc-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
  .elc-desc { display: none; }
}
</style>


<!-- ══════════════════════════════════
     KUMO ATAS — dari keunggulan cream ke area gelap
══════════════════════════════════ -->
<div class="area-kumo-top">
  <svg viewBox="0 0 1440 110" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 0 L0 55 Q60 110 160 75 Q260 45 380 85 Q500 115 620 72 Q740 35 860 78 Q980 115 1100 72 Q1220 35 1320 75 Q1380 95 1440 62 L1440 0 Z" fill="#0f0d0a"/>
    <ellipse cx="100"  cy="65" rx="82"  ry="34" fill="#0f0d0a"/>
    <ellipse cx="60"   cy="78" rx="62"  ry="28" fill="#0f0d0a"/>
    <ellipse cx="148"  cy="52" rx="57"  ry="24" fill="#0f0d0a"/>
    <ellipse cx="330"  cy="76" rx="86"  ry="32" fill="#0f0d0a"/>
    <ellipse cx="282"  cy="90" rx="65"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="388"  cy="60" rx="58"  ry="22" fill="#0f0d0a"/>
    <ellipse cx="570"  cy="66" rx="84"  ry="30" fill="#0f0d0a"/>
    <ellipse cx="522"  cy="80" rx="62"  ry="25" fill="#0f0d0a"/>
    <ellipse cx="622"  cy="52" rx="55"  ry="20" fill="#0f0d0a"/>
    <ellipse cx="810"  cy="70" rx="82"  ry="31" fill="#0f0d0a"/>
    <ellipse cx="762"  cy="84" rx="60"  ry="25" fill="#0f0d0a"/>
    <ellipse cx="862"  cy="56" rx="54"  ry="20" fill="#0f0d0a"/>
    <ellipse cx="1050" cy="66" rx="78"  ry="29" fill="#0f0d0a"/>
    <ellipse cx="1002" cy="80" rx="58"  ry="24" fill="#0f0d0a"/>
    <ellipse cx="1102" cy="52" rx="52"  ry="18" fill="#0f0d0a"/>
    <ellipse cx="1280" cy="68" rx="74"  ry="28" fill="#0f0d0a"/>
    <ellipse cx="1232" cy="82" rx="56"  ry="22" fill="#0f0d0a"/>
    <ellipse cx="1332" cy="54" rx="50"  ry="18" fill="#0f0d0a"/>
    <ellipse cx="1400" cy="60" rx="48"  ry="18" fill="#0f0d0a"/>
  </svg>
</div>


<section id="area">

  <div class="emaki-inner">

    <!-- ══ HEADER — di atas gelap ══ -->
    <header class="emaki-header">
      <div class="emaki-moon"></div>

      <div class="emaki-overline">
        <span class="emaki-overline-dot"></span>
        Area Pengiriman · 配達エリア
        <span style="font-family:'Noto Serif JP',serif;font-size:13px;color:rgba(196,168,130,.35);font-weight:300;margin-left:4px;">花屋</span>
      </div>

      <h2 class="emaki-title">
        Kami Hadir di <em>Seluruh<br>Jakarta Pusat</em>
      </h2>

      <svg class="emaki-brush" viewBox="0 0 240 16" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 11 Q33 3 66 9 Q99 15 120 7 Q141 1 174 9 Q207 15 235 7"
              stroke="rgba(196,168,130,.6)" stroke-width="3" fill="none"
              stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M26 13 Q75 8 120 12 Q165 15 214 9"
              stroke="rgba(196,168,130,.3)" stroke-width="1.3" fill="none"
              stroke-linecap="round"/>
      </svg>

      <div class="emaki-rule">
        <div class="emaki-rule-line"></div>
        <div class="emaki-rule-diamond"></div>
        <span style="font-family:'Noto Serif JP',serif;font-size:9px;color:rgba(196,168,130,.4);letter-spacing:.22em;">配達の道</span>
        <div class="emaki-rule-diamond"></div>
        <div class="emaki-rule-line" style="background:linear-gradient(to left,transparent,rgba(196,168,130,.35),transparent)"></div>
      </div>

      <p class="emaki-subtitle">
        Pengiriman bunga segar ke seluruh wilayah Jakarta Pusat —<br>
        cepat, aman, dan tepat waktu seperti bulan menerangi malam.
      </p>
    </header>


    <!-- ══ EMAKI GULUNGAN PETA ══ -->
    <div class="emaki-scroll-wrap">

      <!-- Rod atas -->
      <div class="emaki-rod-top">
        <span class="emaki-rod-label">絵巻地図 · Peta Gulungan Jakarta Pusat</span>
      </div>

      <!-- Canvas peta -->
      <div class="emaki-canvas">

        <!-- Kanji bg besar -->
        <div class="emaki-bg-kanji emaki-bg-kanji-1">地</div>
        <div class="emaki-bg-kanji emaki-bg-kanji-2">花</div>

        <!-- Ilustrasi sumi-e SVG decorative -->
        <div class="emaki-sumi-art">
          <svg width="100%" height="100%" viewBox="0 0 1200 500"
               xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
            <!-- Gunung sumi-e samar kiri -->
            <path d="M0 480 Q60 200 160 240 Q220 260 280 180 Q340 100 420 320 Q460 400 520 480"
                  fill="rgba(139,111,94,.04)" stroke="rgba(139,111,94,.06)" stroke-width="1"/>
            <path d="M0 480 Q80 280 180 300 Q260 320 320 220 Q360 160 440 340 Q480 420 540 480"
                  fill="rgba(139,111,94,.03)"/>
            <!-- Gunung kanan -->
            <path d="M780 480 Q860 240 960 220 Q1020 210 1080 260 Q1140 310 1200 480"
                  fill="rgba(139,111,94,.04)" stroke="rgba(139,111,94,.05)" stroke-width="1"/>
            <!-- Sungai halus -->
            <path d="M400 480 Q440 380 460 320 Q480 260 520 240 Q560 220 590 260 Q620 300 640 480"
                  fill="rgba(139,111,94,.025)" stroke="rgba(139,111,94,.04)" stroke-width="0.8"/>
            <!-- Garis batas wilayah sumi-e -->
            <path d="M0 200 Q150 180 300 210 Q450 240 600 200 Q750 165 900 200 Q1050 230 1200 190"
                  fill="none" stroke="rgba(139,96,48,.06)" stroke-width="1.2" stroke-dasharray="8,6"/>
            <!-- Awan sumi-e mini -->
            <ellipse cx="200" cy="60" rx="60" ry="22" fill="rgba(139,111,94,.04)"/>
            <ellipse cx="240" cy="48" rx="42" ry="18" fill="rgba(139,111,94,.035)"/>
            <ellipse cx="160" cy="52" rx="38" ry="15" fill="rgba(139,111,94,.03)"/>
            <ellipse cx="920" cy="55" rx="55" ry="20" fill="rgba(139,111,94,.04)"/>
            <ellipse cx="960" cy="44" rx="40" ry="16" fill="rgba(139,111,94,.035)"/>
            <ellipse cx="880" cy="48" rx="36" ry="14" fill="rgba(139,111,94,.03)"/>
          </svg>
        </div>

        <!-- Header peta -->
        <div class="emaki-map-header">
          <div class="emaki-map-title">
            Wilayah Layanan <span>Jakarta Pusat</span>
          </div>
          <div class="emaki-map-subtitle">ジャカルタ中央区 · Peta Pengiriman Bunga Kami</div>
        </div>

        <!-- ══ LOCATION CARDS ══ -->
        <div class="emaki-loc-grid">
          <?php
          /* Kanji fallback per index */
          $kanji_area = ['央','北','南','東','西','中','上','下','内','外','新','古','大','小'];
          foreach ($locations as $idx => $loc):
            $kanji   = $kanji_area[$idx % count($kanji_area)];
            $wa_text = urlencode('Halo, saya ingin pesan bunga dengan pengiriman ke ' . $loc['name'] . '. Apakah bisa?');
          ?>

          <a href="<?= BASE_URL ?>/<?= e($loc['slug']) ?>/"
             class="emaki-loc-card">

            <!-- Tali gantung -->
            <div class="elc-string">
              <div class="elc-string-line"></div>
            </div>

            <div class="elc-body">
              <!-- Kanji bg -->
              <div class="elc-bg-kanji"><?= $kanji ?></div>

              <!-- Header: hanko pin + nama -->
              <div class="elc-header">
                <div class="elc-hanko">
                  <svg fill="none" stroke="currentColor" stroke-width="2"
                       viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 2C8.686 2 6 4.686 6 8c0 5.25 6 13 6 13s6-7.75 6-13c0-3.314-2.686-6-6-6z"/>
                    <circle cx="12" cy="8" r="2.5" stroke-width="1.8"/>
                  </svg>
                </div>
                <div class="elc-name-wrap">
                  <div class="elc-name"><?= e($loc['name']) ?></div>
                  <span class="elc-kanji"><?= $kanji ?> · Jakarta Pusat</span>
                </div>
              </div>

              <div class="elc-divider"></div>

              <div class="elc-desc">
                <?php if (!empty($loc['address'])): ?>
                  <?= e(mb_substr(strip_tags($loc['address']), 0, 72)) ?>
                <?php else: ?>
                  Layanan pengiriman bunga segar tersedia di seluruh area ini.
                <?php endif; ?>
              </div>

              <!-- Badge estimasi -->
              <div class="elc-badge">
                <span class="elc-badge-dot"></span>
                Kirim 2–4 Jam
              </div>

              <!-- CTA -->
              <div class="elc-cta">
                Lihat Layanan
                <svg width="11" height="11" fill="none" stroke="currentColor"
                     stroke-width="2.2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
              </div>
            </div>
          </a>

          <?php endforeach; ?>
        </div><!-- /emaki-loc-grid -->

        <!-- Sumi-e stroke ornamen bawah -->
        <div class="emaki-sumi-bottom">
          <div class="emaki-sumi-line"></div>
          <span class="emaki-sumi-text">花屋 · 配達エリア · Jakarta Pusat</span>
          <div class="emaki-sumi-line" style="background:linear-gradient(to left,rgba(139,96,48,.25),transparent)"></div>
        </div>

      </div><!-- /emaki-canvas -->

      <!-- Rod bawah -->
      <div class="emaki-rod-bottom"></div>

    </div><!-- /emaki-scroll-wrap -->

  </div><!-- /emaki-inner -->


  <!-- ══ STATS BAR — di bagian terang ══ -->
  <div class="emaki-statsbar-wrap">

    <div class="emaki-stats-rule" style="max-width:1380px;margin:0 auto">
      <div class="emaki-stats-rule-line"></div>
      <span class="emaki-stats-rule-text">配達実績 · Statistik Pengiriman</span>
      <div class="emaki-stats-rule-line"></div>
    </div>

    <div class="emaki-statsbar">
      <div class="emaki-stat-block">
        <span class="emaki-stat-icon">地</span>
        <div class="emaki-stat-num"><?= count($locations) ?><sup>+</sup></div>
        <span class="emaki-stat-label">Wilayah Terjangkau</span>
        <span class="emaki-stat-label-jp">配達可能エリア</span>
      </div>
      <div class="emaki-stat-block">
        <span class="emaki-stat-icon">速</span>
        <div class="emaki-stat-num">2–4<sup>Jam</sup></div>
        <span class="emaki-stat-label">Estimasi Kirim</span>
        <span class="emaki-stat-label-jp">配送時間</span>
      </div>
      <div class="emaki-stat-block">
        <span class="emaki-stat-icon">夜</span>
        <div class="emaki-stat-num">24<sup>/7</sup></div>
        <span class="emaki-stat-label">Siap Melayani</span>
        <span class="emaki-stat-label-jp">いつでも対応</span>
      </div>
    </div>
  </div>


  <!-- ══ CTA FOOTER ══ -->
  <div class="emaki-footer-cta">
    <p class="emaki-footer-quote">
      "Tidak menemukan area Anda? Kami tetap bisa membantu 🌸"
      <span>花の道 · Jalur Bunga Kami</span>
    </p>
    <div class="emaki-footer-btns">
     <?php 
$wa_msg = urlencode('Halo, apakah ada layanan pengiriman ke area saya?');
?>

<a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_msg ?>"
   target="_blank" class="emaki-btn-primary">
  <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
  </svg>
  Tanya via WhatsApp
  <span style="font-family:'Noto Serif JP',serif;font-size:9px;opacity:.5;font-weight:300;">質問</span>
</a>
      <a href="#produk" class="emaki-btn-secondary">
        Lihat Produk
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </div>

</section>


<!-- ══════════════════════════════════
     KUMO BAWAH — ke section testimoni
══════════════════════════════════ -->
<div class="area-kumo-bottom">
  <?php $area_next = '#0f0d0a'; /* testimoni gelap */ ?>
  <svg viewBox="0 0 1440 110" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 0 L0 55 Q60 110 160 75 Q260 45 380 85 Q500 115 620 72 Q740 35 860 78 Q980 115 1100 72 Q1220 35 1320 75 Q1380 95 1440 62 L1440 0 Z" fill="<?= $area_next ?>"/>
    <ellipse cx="100"  cy="65" rx="82"  ry="34" fill="<?= $area_next ?>"/>
    <ellipse cx="60"   cy="78" rx="62"  ry="28" fill="<?= $area_next ?>"/>
    <ellipse cx="148"  cy="52" rx="57"  ry="24" fill="<?= $area_next ?>"/>
    <ellipse cx="330"  cy="76" rx="86"  ry="32" fill="<?= $area_next ?>"/>
    <ellipse cx="282"  cy="90" rx="65"  ry="26" fill="<?= $area_next ?>"/>
    <ellipse cx="388"  cy="60" rx="58"  ry="22" fill="<?= $area_next ?>"/>
    <ellipse cx="570"  cy="66" rx="84"  ry="30" fill="<?= $area_next ?>"/>
    <ellipse cx="522"  cy="80" rx="62"  ry="25" fill="<?= $area_next ?>"/>
    <ellipse cx="622"  cy="52" rx="55"  ry="20" fill="<?= $area_next ?>"/>
    <ellipse cx="810"  cy="70" rx="82"  ry="31" fill="<?= $area_next ?>"/>
    <ellipse cx="762"  cy="84" rx="60"  ry="25" fill="<?= $area_next ?>"/>
    <ellipse cx="862"  cy="56" rx="54"  ry="20" fill="<?= $area_next ?>"/>
    <ellipse cx="1050" cy="66" rx="78"  ry="29" fill="<?= $area_next ?>"/>
    <ellipse cx="1002" cy="80" rx="58"  ry="24" fill="<?= $area_next ?>"/>
    <ellipse cx="1102" cy="52" rx="52"  ry="18" fill="<?= $area_next ?>"/>
    <ellipse cx="1280" cy="68" rx="74"  ry="28" fill="<?= $area_next ?>"/>
    <ellipse cx="1232" cy="82" rx="56"  ry="22" fill="<?= $area_next ?>"/>
    <ellipse cx="1332" cy="54" rx="50"  ry="18" fill="<?= $area_next ?>"/>
    <ellipse cx="1400" cy="60" rx="48"  ry="18" fill="<?= $area_next ?>"/>
  </svg>
</div>