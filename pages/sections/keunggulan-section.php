<?php
/* ================================================================
   tentang SECTION — Kakejiku Scroll Wall | Zen Wabi-Sabi
   Konsep: Gulungan kaligrafi Jepang tergantung (掛け軸),
           4 foto grid di atas, kanji vertikal, tatami bg,
           stats bar prasasti batu, kumo pembatas
================================================================ */
?>

<style>
/* ══════════════════════════════════════════════
   KAKEJIKU SCROLL WALL — tentang SECTION
   Palet: tatami warm, sumi, matcha, bamboo, ink
══════════════════════════════════════════════ */

#tentang {
  position: relative;
  overflow: hidden;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  background-color: #EDE8DF;
}

/* Tatami mat texture */
#tentang::before {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 0;
  background-image:
    repeating-linear-gradient(0deg, transparent 0px, transparent 59px, rgba(139,111,94,.07) 59px, rgba(139,111,94,.07) 60px),
    repeating-linear-gradient(90deg, transparent 0px, transparent 119px, rgba(139,111,94,.05) 119px, rgba(139,111,94,.05) 120px);
  pointer-events: none;
}

/* Washi noise */
#tentang::after {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.72' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.028'/%3E%3C/svg%3E");
  pointer-events: none;
}

/* ══ Kumo TOP ══ */
.tentang-kumo-top {
  position: relative; z-index: 2;
  line-height: 0; margin-top: -2px;
  pointer-events: none; overflow: hidden;
}
.tentang-kumo-top svg { width: 100%; display: block; }

/* ══ INNER ══ */
.kakejiku-inner {
  position: relative;
  z-index: 1;
  max-width: 1380px;
  margin: 0 auto;
  padding: 80px 40px 0;
}

/* ══════════════
   HEADER
══════════════ */
.kakejiku-header {
  text-align: center;
  margin-bottom: 64px;
  position: relative;
}

.kakejiku-header-kanji {
  position: absolute;
  top: -28px; left: 50%;
  transform: translateX(-50%);
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(110px, 17vw, 210px);
  font-weight: 700;
  color: rgba(139,111,94,.055);
  line-height: 1;
  pointer-events: none;
  user-select: none;
  white-space: nowrap;
}

.kakejiku-overline {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-size: 10px; font-weight: 500;
  letter-spacing: .32em; text-transform: uppercase;
  color: #8B6F5E; margin-bottom: 18px;
}
.kakejiku-overline-dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: #7A8C6E;
  animation: softPulse 2.5s infinite;
}

.kakejiku-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(2rem, 3.8vw, 3rem);
  font-weight: 200; color: #1C1C1C;
  line-height: 1.12; letter-spacing: .04em;
  margin-bottom: 10px;
}
.kakejiku-title em {
  font-style: italic;
  font-family: 'Cormorant Garamond', serif;
  color: #8B6F5E; font-size: 1.1em;
}

.kakejiku-brush {
  display: block; margin: 10px auto 22px;
  width: clamp(140px, 28%, 260px); opacity: .5;
}

.kakejiku-rule {
  display: flex; align-items: center; justify-content: center; gap: 14px;
  margin-bottom: 14px;
}
.kakejiku-rule-line {
  flex: 1; max-width: 100px; height: 1px;
  background: linear-gradient(to right, transparent, #C4A882, transparent);
}
.kakejiku-rule-diamond {
  width: 5px; height: 5px; background: #7A8C6E; transform: rotate(45deg);
}
.kakejiku-subtitle {
  font-size: 13px; line-height: 1.85;
  color: rgba(28,28,28,.48); max-width: 460px;
  margin: 0 auto; font-weight: 300;
}

/* ══════════════════════════════════════════
   4 FOTO GRID — di atas gulungan
   Layout asimetris: besar kiri + 3 kanan
══════════════════════════════════════════ */
.kakejiku-photo-section {
  margin-bottom: 72px;
}

.kakejiku-photo-label {
  display: flex; align-items: center; gap: 14px; margin-bottom: 18px;
}
.kakejiku-photo-label-line {
  flex: 1; height: 1px;
  background: linear-gradient(to right, rgba(196,168,130,.3), transparent);
}
.kakejiku-photo-label-line.rev {
  background: linear-gradient(to left, rgba(196,168,130,.3), transparent);
}
.kakejiku-photo-label-text {
  font-family: 'Noto Serif JP', serif; font-size: 10px;
  color: rgba(139,111,94,.5); letter-spacing: .28em; font-weight: 300;
}

/* Grid utama */
.kakejiku-photo-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr 1fr;
  grid-template-rows: 1fr 1fr;
  gap: 10px;
  height: 460px;
}

.kp-cell-1 { grid-column: 1; grid-row: 1 / 3; }   /* besar, kiri full */
.kp-cell-2 { grid-column: 2; grid-row: 1; }         /* kanan atas kiri */
.kp-cell-3 { grid-column: 3; grid-row: 1; }         /* kanan atas kanan */
.kp-cell-4 { grid-column: 2 / 4; grid-row: 2; }    /* kanan bawah lebar */

.kp-cell {
  position: relative; overflow: hidden;
  border-radius: 3px; cursor: pointer;
  box-shadow: 0 6px 22px rgba(28,28,28,.13);
  transition: box-shadow .4s, transform .35s;
}
.kp-cell:hover {
  box-shadow: 0 16px 44px rgba(28,28,28,.22);
  transform: scale(1.01); z-index: 2;
}

.kp-cell img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  filter: sepia(.08) saturate(.92) brightness(.88);
  transition: filter .6s ease, transform .8s cubic-bezier(.25,.46,.45,.94);
}
.kp-cell:hover img {
  filter: sepia(.04) saturate(1) brightness(.95);
  transform: scale(1.06);
}

.kp-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(28,28,28,.55) 0%, rgba(28,28,28,.1) 45%, transparent 100%);
}

/* Badge label pojok */
.kp-badge {
  position: absolute;
  bottom: 12px; left: 14px;
  font-family: 'Noto Serif JP', serif; font-size: 9px;
  letter-spacing: .2em; color: rgba(245,240,232,.75);
  background: rgba(28,28,28,.55); backdrop-filter: blur(8px);
  border: 1px solid rgba(196,168,130,.18);
  padding: 4px 10px; border-radius: 2px;
  opacity: 0; transform: translateY(4px);
  transition: opacity .3s, transform .3s;
}
.kp-cell:hover .kp-badge { opacity: 1; transform: translateY(0); }

/* Kanji dekoratif di foto besar */
.kp-kanji-deco {
  position: absolute; top: 14px; right: 14px;
  font-family: 'Noto Serif JP', serif;
  font-size: 38px; font-weight: 700;
  color: rgba(245,240,232,.11);
  writing-mode: vertical-rl;
  pointer-events: none; user-select: none;
  animation: kanjiFloat 10s ease-in-out infinite;
}

/* Shoji grid overlay di foto besar */
.kp-shoji-grid {
  position: absolute; inset: 0; pointer-events: none;
  background-image:
    repeating-linear-gradient(0deg, transparent 0px, transparent 47px, rgba(245,240,232,.04) 47px, rgba(245,240,232,.04) 48px),
    repeating-linear-gradient(90deg, transparent 0px, transparent 47px, rgba(245,240,232,.04) 47px, rgba(245,240,232,.04) 48px);
}

/* ══════════════════════════════════════════
   TALI RAIL — tali gantung horizontal
══════════════════════════════════════════ */
.kakejiku-rail {
  position: relative;
  height: 32px;
  display: flex; align-items: flex-start; justify-content: center;
}
.kakejiku-rail::before {
  content: '';
  position: absolute;
  top: 8px; left: 6%; right: 6%;
  height: 2px;
  background: linear-gradient(to right,
    transparent 0%, rgba(139,96,48,.45) 4%,
    #a07840 25%, #c49858 50%, #a07840 75%,
    rgba(139,96,48,.45) 96%, transparent 100%
  );
  border-radius: 1px;
  box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
/* Kait kiri */
.kakejiku-rail::after {
  content: '';
  position: absolute;
  top: 2px; left: 6%;
  width: 12px; height: 12px; border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #d4a96a, #8B5a20);
  box-shadow: 0 2px 6px rgba(0,0,0,.3);
}

/* ══════════════════════════════════════════
   KAKEJIKU ROW — 5 gulungan tergantung
══════════════════════════════════════════ */
.kakejiku-row {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
}

/* ── Tiap gulungan ── */
.kakejiku-scroll {
  display: flex; flex-direction: column; align-items: center;
  cursor: pointer; position: relative;
  transition: transform .35s cubic-bezier(.25,.46,.45,.94);
}
.kakejiku-scroll:hover { transform: translateY(-8px); }

/* Tali atas */
.kk-string {
  width: 1.5px; height: 24px;
  background: linear-gradient(to bottom, #a07840, rgba(139,96,48,.35));
  flex-shrink: 0;
}

/* Rod atas kayu */
.kk-rod-top {
  width: 100%; height: 16px;
  background: linear-gradient(to bottom, #c49858 0%, #8B6030 45%, #c08848 60%, #6b4520 100%);
  border-radius: 4px;
  box-shadow: 0 3px 10px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.15);
  position: relative; flex-shrink: 0;
}
.kk-rod-top::before, .kk-rod-top::after {
  content: '';
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 22px; height: 22px; border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #e8b860, #7a4a18);
  box-shadow: 0 3px 8px rgba(0,0,0,.4);
  border: 1.5px solid rgba(255,255,255,.1);
}
.kk-rod-top::before { left: -8px; }
.kk-rod-top::after  { right: -8px; }

/* Body kertas kaligrafi */
.kk-body {
  width: 100%;
  background:
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.045'/%3E%3C/svg%3E"),
    linear-gradient(to bottom, #f4ede0 0%, #ede5d4 15%, #e8dece 85%, #dfd5c2 100%);
  border-left:  3px solid #8B6030;
  border-right: 3px solid #8B6030;
  position: relative; overflow: hidden;
  min-height: 268px;
  display: flex; flex-direction: column;
  align-items: center; padding: 22px 16px 20px;
}

/* Serat kayu di border body */
.kk-body::before, .kk-body::after {
  content: '';
  position: absolute; top: 0; bottom: 0; width: 6px;
}
.kk-body::before {
  left: -3px;
  background: repeating-linear-gradient(to bottom, #8B6030 0px, #a07040 18px, #6a4520 18px, #5a3818 20px, #8B6030 20px);
}
.kk-body::after {
  right: -3px;
  background: repeating-linear-gradient(to bottom, #8B6030 0px, #a07040 18px, #6a4520 18px, #5a3818 20px, #8B6030 20px);
}

/* Kanji besar transparan di bg gulungan */
.kk-bg-kanji {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-family: 'Noto Serif JP', serif;
  font-size: 108px; font-weight: 700;
  color: rgba(139,111,94,.065);
  line-height: 1; pointer-events: none; user-select: none;
  transition: opacity .4s, font-size .4s;
}
.kakejiku-scroll:hover .kk-bg-kanji { opacity: .14; font-size: 118px; }

/* Ornamen garis atas/bawah */
.kk-ornament-top, .kk-ornament-bot {
  width: 100%; display: flex; align-items: center; gap: 8px;
  position: relative; z-index: 1;
}
.kk-ornament-top { margin-bottom: 12px; }
.kk-ornament-bot { margin-top: 12px; }

.kk-orn-line {
  flex: 1; height: 1px;
  background: linear-gradient(to right, transparent, rgba(139,96,48,.32), transparent);
}
.kk-orn-diamond {
  width: 4px; height: 4px;
  background: rgba(139,96,48,.38); transform: rotate(45deg); flex-shrink: 0;
}

/* Nomor kanji */
.kk-num {
  font-family: 'Noto Serif JP', serif; font-size: 11px; font-weight: 300;
  color: rgba(139,96,48,.42); letter-spacing: .18em;
  margin-bottom: 12px; position: relative; z-index: 1;
}

/* Icon */
.kk-icon {
  width: 52px; height: 52px; border-radius: 50%;
  background: linear-gradient(135deg, rgba(196,168,130,.25), rgba(122,140,110,.15));
  border: 1px solid rgba(196,168,130,.3);
  box-shadow: 0 3px 12px rgba(196,168,130,.18);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; margin-bottom: 14px;
  position: relative; z-index: 1;
  transition: transform .35s ease, box-shadow .35s;
}
.kakejiku-scroll:hover .kk-icon {
  transform: scale(1.12) rotate(-6deg);
  box-shadow: 0 6px 20px rgba(196,168,130,.35);
}

/* Judul */
.kk-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(11.5px, 1vw, 13.5px); font-weight: 400;
  color: #2a1a10; text-align: center;
  line-height: 1.45; margin-bottom: 5px;
  position: relative; z-index: 1; letter-spacing: .02em;
}

/* Kanji label kecil */
.kk-kanji-label {
  font-family: 'Noto Serif JP', serif; font-size: 10px; font-weight: 300;
  color: rgba(139,96,48,.45); letter-spacing: .2em;
  margin-bottom: 10px; position: relative; z-index: 1;
}

/* Divider kuas */
.kk-divider {
  width: 38%; height: 1px;
  background: linear-gradient(to right, transparent, rgba(139,96,48,.28), transparent);
  margin: 0 auto 10px; position: relative; z-index: 1;
  transition: width .4s ease;
}
.kakejiku-scroll:hover .kk-divider { width: 72%; }

/* Deskripsi */
.kk-desc {
  font-size: 10.5px; line-height: 1.75;
  color: rgba(28,18,10,.45); text-align: center;
  font-weight: 300; position: relative; z-index: 1;
  max-width: 95%;
}

/* Rod bawah */
.kk-rod-bottom {
  width: 100%; height: 16px;
  background: linear-gradient(to bottom, #c49858 0%, #8B6030 45%, #c08848 60%, #6b4520 100%);
  border-radius: 4px;
  box-shadow: 0 3px 10px rgba(0,0,0,.35), inset 0 1px 0 rgba(255,255,255,.15);
  position: relative; flex-shrink: 0;
}
.kk-rod-bottom::before, .kk-rod-bottom::after {
  content: '';
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 22px; height: 22px; border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #e8b860, #7a4a18);
  box-shadow: 0 3px 8px rgba(0,0,0,.4);
  border: 1.5px solid rgba(255,255,255,.1);
}
.kk-rod-bottom::before { left: -8px; }
.kk-rod-bottom::after  { right: -8px; }

/* Tali bawah + tetesan tinta */
.kk-string-bottom {
  width: 1.5px; height: 18px;
  background: linear-gradient(to bottom, rgba(139,96,48,.35), transparent);
}
.kk-ink-drop {
  width: 5px; height: 5px; border-radius: 50%;
  background: rgba(139,96,48,.28);
}

/* ══════════════════════════
   STATS BAR — Prasasti Batu
══════════════════════════ */
.kakejiku-statsbar-wrap {
  position: relative; z-index: 1;
  padding: 0 40px; max-width: 1380px; margin: 0 auto;
}
.kakejiku-stats-rule {
  display: flex; align-items: center; gap: 16px;
  padding: 56px 0 28px;
}
.kakejiku-stats-rule-line {
  flex: 1; height: 1px;
  background: linear-gradient(to right, transparent, rgba(139,111,94,.28), transparent);
}
.kakejiku-stats-rule-text {
  font-family: 'Noto Serif JP', serif; font-size: 10.5px;
  color: rgba(139,111,94,.46); letter-spacing: .28em; font-weight: 300;
}

.kakejiku-statsbar {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
}

.kk-stat-stone {
  position: relative;
  background:
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E"),
    linear-gradient(160deg, #2e2520 0%, #231c18 50%, #1e1914 100%);
  border: 1px solid rgba(196,168,130,.13);
  border-radius: 3px; padding: 28px 22px 24px; text-align: center; overflow: hidden;
  box-shadow: 0 8px 28px rgba(0,0,0,.2), inset 0 1px 0 rgba(196,168,130,.07), inset 0 -1px 0 rgba(0,0,0,.25);
  transition: transform .3s, box-shadow .3s, border-color .3s;
}
.kk-stat-stone:hover {
  transform: translateY(-4px);
  box-shadow: 0 16px 40px rgba(0,0,0,.28), inset 0 1px 0 rgba(196,168,130,.12);
  border-color: rgba(196,168,130,.26);
}
.kk-stat-stone::before {
  content: ''; position: absolute;
  top: 0; left: 50%; transform: translateX(-50%);
  width: 1px; height: 28%;
  background: linear-gradient(to bottom, rgba(196,168,130,.18), transparent);
}
.kk-stat-stone::after {
  content: ''; position: absolute;
  top: 0; left: 20%; right: 20%; height: 2px;
  background: linear-gradient(to right, transparent, rgba(196,168,130,.22), transparent);
}
.kk-stat-kanji {
  font-family: 'Noto Serif JP', serif; font-size: 22px;
  color: rgba(196,168,130,.38); font-weight: 300;
  display: block; margin-bottom: 12px; transition: color .3s;
}
.kk-stat-stone:hover .kk-stat-kanji { color: rgba(196,168,130,.68); }
.kk-stat-num {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(22px, 2.8vw, 32px); font-weight: 600;
  color: #F5F0E8; line-height: 1; margin-bottom: 6px; letter-spacing: .02em;
}
.kk-stat-num sup { font-size: .44em; color: #C4A882; font-weight: 300; vertical-align: super; }
.kk-stat-label {
  font-size: 9.5px; font-weight: 500; letter-spacing: .2em; text-transform: uppercase;
  color: rgba(245,240,232,.3); display: block; margin-bottom: 3px;
}
.kk-stat-label-jp {
  font-family: 'Noto Serif JP', serif; font-size: 8.5px;
  color: rgba(196,168,130,.28); letter-spacing: .1em; display: block;
}

/* ══ CTA Bawah ══ */
.kakejiku-cta-wrap {
  text-align: center; padding: 48px 16px 80px;
  position: relative; z-index: 1;
}
.kakejiku-cta-quote {
  font-family: 'Cormorant Garamond', serif; font-size: 17px;
  font-style: italic; color: rgba(28,18,10,.38); margin-bottom: 24px;
}
.kakejiku-cta-quote span {
  display: block; font-family: 'Noto Serif JP', serif;
  font-size: 9.5px; font-style: normal; font-weight: 300;
  color: rgba(139,111,94,.45); letter-spacing: .22em; margin-top: 5px;
}
.kakejiku-cta-btns {
  display: flex; align-items: center; justify-content: center;
  gap: 12px; flex-wrap: wrap;
}
.kakejiku-btn-primary {
  display: inline-flex; align-items: center; gap: 9px;
  font-size: 11.5px; font-weight: 500; letter-spacing: .08em; color: #F5F0E8;
  background: linear-gradient(135deg, #7A8C6E, #4A5E3A);
  border: 1px solid rgba(122,140,110,.3);
  padding: 13px 26px; border-radius: 2px; text-decoration: none;
  box-shadow: 0 4px 16px rgba(74,94,58,.25);
  transition: transform .25s, box-shadow .25s;
}
.kakejiku-btn-primary:hover {
  transform: translateY(-2px); box-shadow: 0 10px 28px rgba(74,94,58,.4);
  color: #fff; text-decoration: none;
}
.kakejiku-btn-secondary {
  display: inline-flex; align-items: center; gap: 7px;
  font-size: 11.5px; font-weight: 400; letter-spacing: .06em; color: #8B6F5E;
  border: 1px solid rgba(139,111,94,.25); background: transparent;
  padding: 12px 20px; border-radius: 2px; text-decoration: none;
  transition: border-color .25s, color .25s, background .25s;
}
.kakejiku-btn-secondary:hover {
  border-color: #C4A882; color: #1C1C1C;
  background: rgba(196,168,130,.07); text-decoration: none;
}

/* ══ Kumo BOTTOM ══ */
.tentang-kumo-bottom {
  position: relative; z-index: 2;
  line-height: 0; pointer-events: none; overflow: hidden;
}
.tentang-kumo-bottom svg { width: 100%; display: block; }

/* ─── Responsive ─── */
@media (max-width: 1200px) {
  .kakejiku-row { grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .kakejiku-photo-grid { height: 380px; }
}
@media (max-width: 1023px) {
  .kakejiku-inner { padding: 64px 24px 0; }
  .kakejiku-statsbar-wrap { padding: 0 24px; }
  .kakejiku-statsbar { grid-template-columns: repeat(2, 1fr); }
  .kakejiku-photo-grid { height: 320px; }
}
@media (max-width: 767px) {
  .kakejiku-row { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .kakejiku-photo-grid {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    height: auto;
  }
  .kp-cell-1 { grid-column: 1; grid-row: 1; aspect-ratio: 1 / 1; }
  .kp-cell-2 { grid-column: 2; grid-row: 1; aspect-ratio: 1 / 1; }
  .kp-cell-3 { grid-column: 1; grid-row: 2; aspect-ratio: 1 / 1; }
  .kp-cell-4 { grid-column: 2; grid-row: 2; aspect-ratio: 1 / 1; }
  .kakejiku-inner { padding: 48px 16px 0; }
  .kakejiku-statsbar-wrap { padding: 0 16px; }
}
@media (max-width: 480px) {
  .kakejiku-row { grid-template-columns: 1fr 1fr; }
  .kk-desc { font-size: 10px; }
  .kakejiku-statsbar { grid-template-columns: repeat(2, 1fr); gap: 10px; }
}
</style>


<!-- ══════════════════════════════════
     KUMO ATAS — dari produk gelap ke tatami cream
══════════════════════════════════ -->
<div class="tentang-kumo-top">
  <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 100 L0 40 Q80 0 160 30 Q240 60 360 20 Q480 -10 600 28 Q720 65 840 22 Q960 -15 1080 30 Q1200 70 1320 28 Q1380 10 1440 38 L1440 100 Z" fill="#EDE8DF"/>
    <ellipse cx="100"  cy="38" rx="84"  ry="38" fill="#EDE8DF"/>
    <ellipse cx="62"   cy="52" rx="64"  ry="30" fill="#EDE8DF"/>
    <ellipse cx="148"  cy="26" rx="58"  ry="26" fill="#EDE8DF"/>
    <ellipse cx="320"  cy="22" rx="96"  ry="38" fill="#EDE8DF"/>
    <ellipse cx="272"  cy="36" rx="70"  ry="30" fill="#EDE8DF"/>
    <ellipse cx="376"  cy="12" rx="62"  ry="25" fill="#EDE8DF"/>
    <ellipse cx="560"  cy="28" rx="90"  ry="36" fill="#EDE8DF"/>
    <ellipse cx="512"  cy="42" rx="65"  ry="28" fill="#EDE8DF"/>
    <ellipse cx="612"  cy="16" rx="58"  ry="22" fill="#EDE8DF"/>
    <ellipse cx="800"  cy="22" rx="88"  ry="34" fill="#EDE8DF"/>
    <ellipse cx="752"  cy="36" rx="64"  ry="28" fill="#EDE8DF"/>
    <ellipse cx="852"  cy="12" rx="56"  ry="22" fill="#EDE8DF"/>
    <ellipse cx="1040" cy="30" rx="84"  ry="32" fill="#EDE8DF"/>
    <ellipse cx="992"  cy="44" rx="62"  ry="26" fill="#EDE8DF"/>
    <ellipse cx="1092" cy="18" rx="54"  ry="20" fill="#EDE8DF"/>
    <ellipse cx="1260" cy="26" rx="80"  ry="30" fill="#EDE8DF"/>
    <ellipse cx="1212" cy="40" rx="58"  ry="24" fill="#EDE8DF"/>
    <ellipse cx="1312" cy="14" rx="52"  ry="20" fill="#EDE8DF"/>
    <ellipse cx="1400" cy="36" rx="55"  ry="22" fill="#EDE8DF"/>
  </svg>
</div>


<section id="tentang">
<div class="kakejiku-inner">

  <!-- ══ HEADER ══ -->
  <header class="kakejiku-header">
    <div class="kakejiku-header-kanji">掛軸　花</div>

    <div class="kakejiku-overline">
      <span class="kakejiku-overline-dot"></span>
      tentang Kami · 特徴
      <span style="font-family:'Noto Serif JP',serif;font-size:13px;color:rgba(196,168,130,.42);font-weight:300;margin-left:4px;">花屋</span>
    </div>

    <h2 class="kakejiku-title">Kenapa Memilih <em>Kami?</em></h2>

    <svg class="kakejiku-brush" viewBox="0 0 260 16" xmlns="http://www.w3.org/2000/svg">
      <path d="M6 11 Q36 3 72 9 Q108 15 130 7 Q152 1 188 9 Q224 15 254 7"
            stroke="#7A8C6E" stroke-width="3.2" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity=".75"/>
      <path d="M28 13 Q82 8 130 12 Q178 15 232 9"
            stroke="#C4A882" stroke-width="1.4" fill="none" stroke-linecap="round" opacity=".4"/>
    </svg>

    <div class="kakejiku-rule">
      <div class="kakejiku-rule-line"></div>
      <div class="kakejiku-rule-diamond"></div>
      <span style="font-family:'Noto Serif JP',serif;font-size:9px;color:rgba(139,111,94,.45);letter-spacing:.22em;">和の誇り</span>
      <div class="kakejiku-rule-diamond"></div>
      <div class="kakejiku-rule-line" style="background:linear-gradient(to left,transparent,#C4A882,transparent)"></div>
    </div>

    <p class="kakejiku-subtitle">
      Lebih dari satu dekade merangkai bunga segar untuk Jakarta Pusat —<br>
      setiap gulungan menceritakan komitmen kami dengan filosofi <em style="font-family:'Cormorant Garamond',serif;color:#8B6F5E;">Wabi-Sabi.</em>
    </p>
  </header>


  <!-- ══ 4 FOTO GRID ══ -->
  <div class="kakejiku-photo-section">
    <div class="kakejiku-photo-label">
      <div class="kakejiku-photo-label-line"></div>
      <span class="kakejiku-photo-label-text">花の物語 · Kisah Bunga Kami</span>
      <div class="kakejiku-photo-label-line rev"></div>
    </div>

    <div class="kakejiku-photo-grid">

      <div class="kp-cell kp-cell-1">
        <img src="<?= BASE_URL ?>/assets/images/jep 1.jpg" alt="Bunga Segar" loading="lazy">
        <div class="kp-overlay"></div>
        <div class="kp-shoji-grid"></div>
        <div class="kp-kanji-deco">花</div>
        <span class="kp-badge">Bunga Segar</span>
      </div>

      <div class="kp-cell kp-cell-2">
        <img src="<?= BASE_URL ?>/assets/images/jep 2.jpg" alt="Hand Bouquet" loading="lazy">
        <div class="kp-overlay"></div>
        <span class="kp-badge">Hand Bouquet</span>
      </div>

      <div class="kp-cell kp-cell-3">
        <img src="<?= BASE_URL ?>/assets/images/jep 3.jpg" alt="Bunga Papan" loading="lazy">
        <div class="kp-overlay"></div>
        <span class="kp-badge">Bunga Papan</span>
      </div>

      <div class="kp-cell kp-cell-4">
        <img src="<?= BASE_URL ?>/assets/images/jep 4.jpg" alt="Standing Flower" loading="lazy">
        <div class="kp-overlay"></div>
        <span class="kp-badge">Standing Flower</span>
      </div>

    </div>
  </div>


  <!-- ══ TALI RAIL ══ -->
  <div class="kakejiku-rail"></div>


  <!-- ══ KAKEJIKU ROW — 5 gulungan ══ -->
  <div class="kakejiku-row">

  <?php
$kk_items = [
  [
    'num'=>'一',
    'kanji'=>'花',
    'icon' => BASE_URL . '/assets/svg/cherry.svg',
    'title'=>'Bunga 100% Segar Setiap Hari',
    'desc'=>'Dipilih dari pasar tiap pagi. Layu sebelum waktunya? Kami ganti tanpa syarat.'
  ],
  [
    'num'=>'二',
    'kanji'=>'心',
    'icon' => BASE_URL . '/assets/svg/brush-2.svg',
    'title'=>'Desain Custom Gratis',
    'desc'=>'Tim florist siap merancang rangkaian sesuai keinginan dan budget Anda.'
  ],
  [
    'num'=>'三',
    'kanji'=>'速',
    'icon' => BASE_URL . '/assets/svg/train.svg',
    'title'=>'Kirim 2–4 Jam',
    'desc'=>'Armada siap antar ke 12 kecamatan Jakarta Pusat hari yang sama.'
  ],
  [
    'num'=>'四',
    'kanji'=>'夜',
    'icon' => BASE_URL . '/assets/svg/torii.svg',
    'title'=>'Layanan 24 Jam / 7 Hari',
    'desc'=>'Melayani pesanan kapan saja — malam hari dan hari libur pun siap.'
  ],
  [
    'num'=>'五',
    'kanji'=>'誉',
    'icon' => BASE_URL . '/assets/svg/karasu.svg',
    'title'=>'Rating 4.9 · 500+ Pelanggan',
    'desc'=>'Dipercaya selama lebih dari satu dekade dengan rekam jejak terbaik.'
  ],
];
    foreach ($kk_items as $kk): ?>

    <div class="kakejiku-scroll">
      <div class="kk-string"></div>
      <div class="kk-rod-top"></div>

      <div class="kk-body">
        <div class="kk-bg-kanji"><?= $kk['kanji'] ?></div>

        <div class="kk-ornament-top">
          <div class="kk-orn-line"></div>
          <div class="kk-orn-diamond"></div>
          <div class="kk-orn-line"></div>
        </div>

        <div class="kk-num"><?= $kk['num'] ?></div>
       <div class="kk-icon">
  <img src="<?= $kk['icon']; ?>" alt="Icon">
</div>
        <div class="kk-title"><?= $kk['title'] ?></div>
        <div class="kk-kanji-label"><?= $kk['kanji'] ?></div>
        <div class="kk-divider"></div>
        <div class="kk-desc"><?= $kk['desc'] ?></div>

        <div class="kk-ornament-bot">
          <div class="kk-orn-line"></div>
          <div class="kk-orn-diamond"></div>
          <div class="kk-orn-line"></div>
        </div>
      </div>

      <div class="kk-rod-bottom"></div>
      <div class="kk-string-bottom"></div>
      <div class="kk-ink-drop"></div>
    </div>

    <?php endforeach; ?>

  </div><!-- /kakejiku-row -->

</div><!-- /kakejiku-inner -->


<!-- ══ STATS BAR — PRASASTI BATU ══ -->
<div class="kakejiku-statsbar-wrap">
  <div class="kakejiku-stats-rule">
    <div class="kakejiku-stats-rule-line"></div>
    <span class="kakejiku-stats-rule-text">実績 · Pencapaian Nyata Kami</span>
    <div class="kakejiku-stats-rule-line"></div>
  </div>
  <div class="kakejiku-statsbar">
    <div class="kk-stat-stone">
      <span class="kk-stat-kanji">客</span>
      <div class="kk-stat-num">500<sup>+</sup></div>
      <span class="kk-stat-label">Pelanggan Puas</span>
      <span class="kk-stat-label-jp">満足のお客様</span>
    </div>
    <div class="kk-stat-stone">
      <span class="kk-stat-kanji">年</span>
      <div class="kk-stat-num">10<sup>+</sup></div>
      <span class="kk-stat-label">Tahun Pengalaman</span>
      <span class="kk-stat-label-jp">経験年数</span>
    </div>
    <div class="kk-stat-stone">
      <span class="kk-stat-kanji">速</span>
      <div class="kk-stat-num">2–4<sup>Jam</sup></div>
      <span class="kk-stat-label">Estimasi Kirim</span>
      <span class="kk-stat-label-jp">配送時間</span>
    </div>
    <div class="kk-stat-stone">
      <span class="kk-stat-kanji">地</span>
      <div class="kk-stat-num">12</div>
      <span class="kk-stat-label">Kecamatan</span>
      <span class="kk-stat-label-jp">配達エリア</span>
    </div>
  </div>
</div>


<!-- ══ CTA BAWAH ══ -->
<div class="kakejiku-cta-wrap">
  <p class="kakejiku-cta-quote">
    "Setiap momen spesial berhak mendapat bunga terbaik."
    <span>花の心 · Filosofi Kami</span>
  </p>
  <div class="kakejiku-cta-btns">
    <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin konsultasi tentang pesanan bunga.') ?>"
       target="_blank" class="kakejiku-btn-primary">
      <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
      </svg>
      Konsultasi Gratis
      <span style="font-family:'Noto Serif JP',serif;font-size:9px;opacity:.5;font-weight:300;">無料</span>
    </a>
    <a href="#produk" class="kakejiku-btn-secondary">
      Lihat Produk
      <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
      </svg>
    </a>
  </div>
</div>

</section>


<!-- ══════════════════════════════════
     KUMO BAWAH — ke section berikutnya
══════════════════════════════════ -->
<div class="tentang-kumo-bottom">
  <?php $kk_next = '#FDFAF5'; ?>
  <svg viewBox="0 0 1440 110" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 0 L0 55 Q60 110 160 75 Q260 45 380 85 Q500 115 620 72 Q740 35 860 78 Q980 115 1100 72 Q1220 35 1320 75 Q1380 95 1440 62 L1440 0 Z" fill="<?= $kk_next ?>"/>
    <ellipse cx="100"  cy="65" rx="82"  ry="34" fill="<?= $kk_next ?>"/>
    <ellipse cx="60"   cy="78" rx="62"  ry="28" fill="<?= $kk_next ?>"/>
    <ellipse cx="148"  cy="54" rx="57"  ry="24" fill="<?= $kk_next ?>"/>
    <ellipse cx="330"  cy="76" rx="86"  ry="32" fill="<?= $kk_next ?>"/>
    <ellipse cx="282"  cy="90" rx="65"  ry="26" fill="<?= $kk_next ?>"/>
    <ellipse cx="388"  cy="62" rx="58"  ry="22" fill="<?= $kk_next ?>"/>
    <ellipse cx="570"  cy="66" rx="84"  ry="30" fill="<?= $kk_next ?>"/>
    <ellipse cx="522"  cy="80" rx="62"  ry="25" fill="<?= $kk_next ?>"/>
    <ellipse cx="622"  cy="54" rx="55"  ry="20" fill="<?= $kk_next ?>"/>
    <ellipse cx="810"  cy="70" rx="82"  ry="31" fill="<?= $kk_next ?>"/>
    <ellipse cx="762"  cy="84" rx="60"  ry="25" fill="<?= $kk_next ?>"/>
    <ellipse cx="862"  cy="58" rx="54"  ry="20" fill="<?= $kk_next ?>"/>
    <ellipse cx="1050" cy="66" rx="78"  ry="29" fill="<?= $kk_next ?>"/>
    <ellipse cx="1002" cy="80" rx="58"  ry="24" fill="<?= $kk_next ?>"/>
    <ellipse cx="1102" cy="54" rx="52"  ry="18" fill="<?= $kk_next ?>"/>
    <ellipse cx="1280" cy="68" rx="74"  ry="28" fill="<?= $kk_next ?>"/>
    <ellipse cx="1232" cy="82" rx="56"  ry="22" fill="<?= $kk_next ?>"/>
    <ellipse cx="1332" cy="56" rx="50"  ry="18" fill="<?= $kk_next ?>"/>
    <ellipse cx="1400" cy="60" rx="48"  ry="18" fill="<?= $kk_next ?>"/>
  </svg>
</div>