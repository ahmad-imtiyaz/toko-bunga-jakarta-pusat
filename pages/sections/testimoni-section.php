<?php
/* ================================================================
   TESTIMONI SECTION — Tanzaku (短冊) Haiku Wall
   Konsep: Kertas haiku vertikal tergantung dari rail bambu
           seperti festival Tanabata — berayun saat hover
   Warna: Gelap (#0f0d0a) → Cream (#F5F0E8)
   Elemen: Kumo atas/bawah, Kanji dekoratif, Rod kayu, Hover dramatis
================================================================ */

// Fallback data jika $testimonials tidak ada
if (!isset($testimonials) || empty($testimonials)) {
  $testimonials = [
    ['name'=>'Sari Dewi',      'rating'=>5, 'message'=>'Bunga-bunganya segar sekali dan pengirimannya tepat waktu. Sangat puas!', 'created_at'=>'2024-03-15'],
    ['name'=>'Budi Santoso',   'rating'=>5, 'message'=>'Rangkaian buket pernikahan kami luar biasa indah. Semua tamu memuji.', 'created_at'=>'2024-03-10'],
    ['name'=>'Rini Maharani',  'rating'=>5, 'message'=>'Pelayanan ramah dan hasilnya melebihi ekspektasi. Highly recommended!', 'created_at'=>'2024-03-08'],
    ['name'=>'Dian Puspita',   'rating'=>5, 'message'=>'Sudah 3x pesan, selalu konsisten bagus. Toko bunga terpercaya!', 'created_at'=>'2024-02-28'],
    ['name'=>'Andi Kurniawan', 'rating'=>5, 'message'=>'Harga terjangkau tapi kualitas premium. Bunga tahan lama sampai seminggu!', 'created_at'=>'2024-02-20'],
    ['name'=>'Mega Lestari',   'rating'=>5, 'message'=>'Packaging cantik banget, cocok buat hadiah. Penerima langsung senang!', 'created_at'=>'2024-02-15'],
  ];
}

// Kanji dekoratif pool
$kanjiPool = ['花','美','縁','愛','春','咲','香','心','詩','夢','彩','幸'];
// Label kanji per tanzaku
$tanzakuKanji = ['花咲','心縁','詩春','美夢','香彩','幸愛'];
?>

<style>
/* ═══════════════════════════════════════════
   TANZAKU SECTION — CORE VARIABLES
═══════════════════════════════════════════ */
#testimoni {
  --ink:       #0f0d0a;
  --ink2:      #1a1612;
  --washi:     #F5F0E8;
  --tatami:    #EDE8DF;
  --bamboo:    #C4A882;
  --bamboo-dk: #8B6F5E;
  --matcha:    #7A8C6E;
  --hanko:     #8B2020;
  --sakura:    #E8C4B8;
  --gold:      #C9A96E;
  --gold-lt:   #E8D5A3;
  --cream:     #FAF5EE;
  --muted:     #9A8070;
  --night:     #0f0d0a;
  font-family: 'Zen Kaku Gothic New', 'Noto Sans JP', sans-serif;
}

/* ═══════════════════════════════════════════
   KUMO ATAS — dari Area (gelap) → Tanzaku (gelap)
═══════════════════════════════════════════ */
.tanzaku-kumo-top {
  position: relative;
  z-index: 5;
  line-height: 0;
  margin-bottom: -2px;
  pointer-events: none;
}
.tanzaku-kumo-top svg { display: block; width: 100%; }

/* ═══════════════════════════════════════════
   SECTION WRAPPER
═══════════════════════════════════════════ */
#testimoni {
  position: relative;
  overflow: hidden;
  /* Gelap di atas → Cream di bawah */
  background: linear-gradient(
    to bottom,
    #0f0d0a 0%,
    #1a1612 20%,
    #2c2318 40%,
    #8B6F5E 62%,
    #C4A882 75%,
    #EDE8DF 88%,
    #F5F0E8 100%
  );
  padding: 0;
}

/* Tatami grid overlay — hanya di bagian bawah */
#testimoni::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 45%;
  background-image:
    repeating-linear-gradient(0deg, rgba(139,111,94,.08) 0, rgba(139,111,94,.08) 1px, transparent 1px, transparent 40px),
    repeating-linear-gradient(90deg, rgba(139,111,94,.08) 0, rgba(139,111,94,.08) 1px, transparent 1px, transparent 40px);
  pointer-events: none;
  z-index: 0;
}

/* Washi noise overlay */
#testimoni::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='.025'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
  opacity: .6;
}

/* ═══════════════════════════════════════════
   INNER CONTENT
═══════════════════════════════════════════ */
.tanzaku-inner {
  position: relative;
  z-index: 2;
  max-width: 1300px;
  margin: 0 auto;
  padding: 80px 24px 100px;
}

/* ═══════════════════════════════════════════
   HEADER
═══════════════════════════════════════════ */
.tanzaku-header {
  text-align: center;
  margin-bottom: 60px;
  position: relative;
}

.tanzaku-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--gold);
  background: rgba(201,169,110,.1);
  border: 1px solid rgba(201,169,110,.25);
  border-radius: 100px;
  padding: 4px 14px;
  margin-bottom: 18px;
}
.tanzaku-eyebrow-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: var(--gold);
  animation: softPulse 2s ease-in-out infinite;
}
@keyframes softPulse {
  0%,100% { opacity: 1; transform: scale(1); }
  50%      { opacity: .5; transform: scale(.7); }
}

.tanzaku-title {
  font-family: 'Noto Serif JP', 'Georgia', serif;
  font-size: clamp(28px, 4vw, 46px);
  font-weight: 300;
  color: #F5F0E8;
  letter-spacing: .06em;
  line-height: 1.3;
  margin: 0 0 10px;
  position: relative;
}

/* Brush stroke SVG di bawah judul */
.tanzaku-brush {
  display: block;
  margin: 8px auto 0;
  opacity: .45;
}

/* Kanji besar dekoratif mengambang di header */
.tanzaku-header-kanji {
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-size: 140px;
  font-weight: 200;
  color: rgba(201,169,110,.05);
  top: -30px;
  left: 50%;
  transform: translateX(-50%);
  pointer-events: none;
  user-select: none;
  letter-spacing: .1em;
  line-height: 1;
}

.tanzaku-subtitle {
  font-size: 14px;
  color: rgba(245,240,232,.5);
  margin-top: 14px;
  letter-spacing: .04em;
}

/* ═══════════════════════════════════════════
   RAIL BAMBU (tali gantungan tanzaku)
═══════════════════════════════════════════ */
.tanzaku-rail-wrap {
  position: relative;
  margin-bottom: 4px;
}

/* Rail horizontal (rod bambu) */
.tanzaku-rail {
  position: relative;
  height: 22px;
  background: linear-gradient(
    to bottom,
    #d4a96a 0%,
    #C4A882 30%,
    #a88555 60%,
    #8B6F5E 100%
  );
  border-radius: 11px;
  box-shadow:
    0 4px 16px rgba(0,0,0,.5),
    inset 0 2px 4px rgba(255,220,150,.25),
    inset 0 -2px 3px rgba(0,0,0,.3);
  z-index: 3;
}

/* Ujung bulat kuningan rail */
.tanzaku-rail::before,
.tanzaku-rail::after {
  content: '';
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 32px; height: 32px;
  border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #f0d080, #C9A96E 40%, #8B6F5E 80%);
  box-shadow: 0 3px 10px rgba(0,0,0,.5), inset 0 1px 3px rgba(255,220,100,.4);
  z-index: 4;
}
.tanzaku-rail::before { left: -10px; }
.tanzaku-rail::after  { right: -10px; }

/* Node bambu (ruas) */
.tanzaku-rail-node {
  position: absolute;
  top: 0; bottom: 0;
  width: 4px;
  background: rgba(0,0,0,.25);
  border-radius: 2px;
}

/* ═══════════════════════════════════════════
   TANZAKU CARDS CONTAINER
═══════════════════════════════════════════ */
.tanzaku-cards-wrap {
  display: flex;
  justify-content: center;
  gap: 18px;
  flex-wrap: wrap;
  padding: 0 12px;
}

/* ═══════════════════════════════════════════
   TANZAKU ITEM (satu kartu + tali)
═══════════════════════════════════════════ */
.tanzaku-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 0 0 auto;
  width: 180px;
  /* Setiap tanzaku sedikit berbeda tingginya — dikontrol via JS */
  position: relative;
}

/* Tali gantung */
.tanzaku-string {
  width: 2px;
  height: 32px;
  background: linear-gradient(to bottom, rgba(201,169,110,.9), rgba(139,111,94,.5));
  position: relative;
  flex-shrink: 0;
  transition: transform .4s ease;
  transform-origin: top center;
}

/* Knot tali di atas tanzaku */
.tanzaku-string::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 8px; height: 8px;
  border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #d4a96a, #8B6F5E);
  box-shadow: 0 2px 4px rgba(0,0,0,.4);
}

/* KARTU TANZAKU */
.tanzaku-card {
  position: relative;
  width: 160px;
  /* Tinggi bervariasi per card */
  border-radius: 4px 4px 12px 12px;
  overflow: hidden;
  cursor: pointer;
  transform-origin: top center;
  transition:
    transform .45s cubic-bezier(.34, 1.56, .64, 1),
    box-shadow .4s ease;
  box-shadow:
    4px 8px 24px rgba(0,0,0,.5),
    1px 2px 4px rgba(0,0,0,.3),
    inset 0 0 0 1px rgba(255,220,150,.08);
}

/* Hover: berayun + naik dramatis */
.tanzaku-item:hover .tanzaku-card {
  transform: translateY(-14px) rotate(1.5deg);
  box-shadow:
    6px 20px 48px rgba(0,0,0,.55),
    2px 4px 8px rgba(0,0,0,.3),
    0 0 30px rgba(201,169,110,.15),
    inset 0 0 0 1px rgba(255,220,150,.15);
}
.tanzaku-item:nth-child(even):hover .tanzaku-card {
  transform: translateY(-14px) rotate(-1.5deg);
}

/* Tali berayun saat hover */
.tanzaku-item:hover .tanzaku-string {
  transform: rotate(3deg);
}
.tanzaku-item:nth-child(even):hover .tanzaku-string {
  transform: rotate(-3deg);
}

/* Swing animasi idle */
@keyframes tanzakuSwing {
  0%,100% { transform: rotate(0deg); }
  25%      { transform: rotate(.8deg); }
  75%      { transform: rotate(-.8deg); }
}
.tanzaku-card { animation: tanzakuSwing 5s ease-in-out infinite; }
.tanzaku-item:nth-child(2n)   .tanzaku-card { animation-delay: -.8s; }
.tanzaku-item:nth-child(3n)   .tanzaku-card { animation-delay: -1.6s; }
.tanzaku-item:nth-child(4n)   .tanzaku-card { animation-delay: -2.4s; }
.tanzaku-item:nth-child(5n)   .tanzaku-card { animation-delay: -3.2s; }
.tanzaku-item:nth-child(6n)   .tanzaku-card { animation-delay: -4s; }
.tanzaku-item:hover .tanzaku-card { animation-play-state: paused; }

/* Washi paper background card */
.tanzaku-card-bg {
  position: absolute;
  inset: 0;
  background: linear-gradient(160deg, #faf3e8 0%, #f0e8d8 40%, #e8ddc8 100%);
  z-index: 0;
}
/* Serat washi vertikal */
.tanzaku-card-bg::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    repeating-linear-gradient(
      90deg,
      transparent 0px,
      transparent 3px,
      rgba(180,150,110,.06) 3px,
      rgba(180,150,110,.06) 4px
    );
}
/* Texture noise washi */
.tanzaku-card-bg::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");
  opacity: .8;
}

/* Konten dalam card (z-index di atas bg) */
.tanzaku-card-content {
  position: relative;
  z-index: 2;
  padding: 18px 14px 22px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0;
}

/* Kanji besar transparan di center card (watermark) */
.tanzaku-kanji-watermark {
  font-family: 'Noto Serif JP', serif;
  font-size: 68px;
  font-weight: 200;
  color: rgba(139,111,94,.1);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  line-height: 1;
  pointer-events: none;
  user-select: none;
  z-index: 1;
  letter-spacing: -.02em;
  /* Kanji vertikal, 2 karakter */
  writing-mode: vertical-rl;
}

/* Divider garis merah tipis (seperti garis buku harian) */
.tanzaku-divider {
  width: 1px;
  height: 20px;
  background: linear-gradient(to bottom, transparent, rgba(139,32,32,.3), transparent);
  margin: 6px 0;
  flex-shrink: 0;
}

/* Hanko stamp bulat */
.tanzaku-hanko {
  width: 34px; height: 34px;
  border-radius: 50%;
  border: 2px solid rgba(139,32,32,.6);
  background: rgba(139,32,32,.08);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Noto Serif JP', serif;
  font-size: 13px;
  font-weight: 700;
  color: var(--hanko);
  letter-spacing: -.02em;
  flex-shrink: 0;
  margin-bottom: 10px;
  transition: transform .3s ease, background .3s ease;
  writing-mode: horizontal-tb;
}
.tanzaku-item:hover .tanzaku-hanko {
  transform: rotate(8deg) scale(1.1);
  background: rgba(139,32,32,.15);
}

/* Bintang rating */
.tanzaku-stars {
  display: flex;
  gap: 2px;
  margin-bottom: 8px;
  writing-mode: horizontal-tb;
}
.tanzaku-star { font-size: 9px; line-height: 1; }
.tanzaku-star-fill  { color: #C9A96E; }
.tanzaku-star-empty { color: rgba(139,111,94,.2); }

/* Teks review — vertikal ala Jepang */
.tanzaku-text {
  font-size: 11px;
  line-height: 1.9;
  color: #4a3828;
  text-align: center;
  /* Tulis horizontal tapi ditampilkan dalam card vertikal */
  writing-mode: horizontal-tb;
  max-height: 120px;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 6;
  -webkit-box-orient: vertical;
}

/* Nama author */
.tanzaku-name {
  font-family: 'Noto Serif JP', serif;
  font-size: 11px;
  font-weight: 600;
  color: #2c1a1e;
  letter-spacing: .06em;
  margin-top: 10px;
  writing-mode: horizontal-tb;
  text-align: center;
}

/* Lokasi */
.tanzaku-loc {
  font-size: 9px;
  color: rgba(74,56,40,.5);
  letter-spacing: .08em;
  text-transform: uppercase;
  margin-top: 2px;
  writing-mode: horizontal-tb;
  text-align: center;
}

/* Ornamen bawah card — ujung runcing halus, warna menyatu */
.tanzaku-tip {
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 24px;
  height: 12px;
  background: inherit;
  clip-path: polygon(0 0, 100% 0, 50% 100%);
  z-index: 3;
  /* Sembunyikan — visual runcing sudah cukup dari border-radius card */
  display: none;
}
/* Shadow bawah */
.tanzaku-card::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 40px;
  background: linear-gradient(to bottom, transparent, rgba(180,150,110,.12));
  z-index: 1;
  pointer-events: none;
}

/* ═══════════════════════════════════════════
   KANJI VERTIKAL FLOATING di SECTION
═══════════════════════════════════════════ */
.tanzaku-float-kanji {
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-weight: 200;
  color: rgba(201,169,110,.04);
  pointer-events: none;
  user-select: none;
  writing-mode: vertical-rl;
  line-height: 1;
  animation: kanjiFloat 12s ease-in-out infinite;
}
@keyframes kanjiFloat {
  0%,100% { transform: translateY(0px) rotate(0deg); opacity: .6; }
  33%      { transform: translateY(-18px) rotate(.5deg); opacity: 1; }
  66%      { transform: translateY(8px) rotate(-.5deg); opacity: .7; }
}

/* ═══════════════════════════════════════════
   STATS BAR — Prasasti Batu
═══════════════════════════════════════════ */
.tanzaku-stats {
  display: flex;
  justify-content: center;
  gap: 0;
  margin-top: 60px;
  flex-wrap: wrap;
}

.tanzaku-stat-block {
  position: relative;
  flex: 1;
  min-width: 160px;
  max-width: 260px;
  padding: 24px 28px;
  background: linear-gradient(135deg, #2e2520 0%, #1e1914 50%, #2a1e14 100%);
  border-top: 1px solid rgba(201,169,110,.15);
  border-bottom: 1px solid rgba(0,0,0,.4);
  text-align: center;
  transition: transform .3s ease, box-shadow .3s ease;
  overflow: hidden;
}
.tanzaku-stat-block:first-child {
  border-radius: 8px 0 0 8px;
  border-left: 1px solid rgba(201,169,110,.1);
}
.tanzaku-stat-block:last-child {
  border-radius: 0 8px 8px 0;
  border-right: 1px solid rgba(201,169,110,.1);
}
.tanzaku-stat-block + .tanzaku-stat-block {
  border-left: 1px solid rgba(201,169,110,.08);
}
/* Retakan dekoratif */
.tanzaku-stat-block::before {
  content: '';
  position: absolute;
  top: 10px; right: 14px;
  width: 1px; height: 35px;
  background: linear-gradient(to bottom, transparent, rgba(201,169,110,.12), transparent);
  transform: rotate(12deg);
}
.tanzaku-stat-block::after {
  content: '';
  position: absolute;
  top: 8px; right: 20px;
  width: 1px; height: 28px;
  background: linear-gradient(to bottom, transparent, rgba(201,169,110,.07), transparent);
  transform: rotate(-8deg);
}
.tanzaku-stat-block:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 32px rgba(0,0,0,.4), 0 0 20px rgba(201,169,110,.08);
  z-index: 1;
}

.tanzaku-stat-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 22px;
  font-weight: 300;
  color: rgba(201,169,110,.35);
  line-height: 1;
  margin-bottom: 6px;
}
.tanzaku-stat-num {
  font-family: 'Noto Serif JP', serif;
  font-size: 32px;
  font-weight: 300;
  color: #F5F0E8;
  line-height: 1;
  letter-spacing: .04em;
}
.tanzaku-stat-num span {
  font-size: 16px;
  color: var(--gold);
}
.tanzaku-stat-label {
  font-size: 10px;
  letter-spacing: .16em;
  text-transform: uppercase;
  color: rgba(245,240,232,.35);
  margin-top: 5px;
}

/* ═══════════════════════════════════════════
   CAROUSEL VIEWPORT
═══════════════════════════════════════════ */
.tanzaku-carousel-outer {
  overflow: hidden;
  position: relative;
}

.tanzaku-carousel-track {
  display: flex;
  gap: 18px;
  transition: transform .55s cubic-bezier(.4,0,.2,1);
  will-change: transform;
  /* padding agar shadow tanzaku tidak terpotong */
  padding: 8px 4px 40px;
}

/* Setiap slide = grup 6 tanzaku */
.tanzaku-slide-page {
  display: flex;
  gap: 18px;
  flex-shrink: 0;
}

/* ═══════════════════════════════════════════
   TOMBOL NAVIGASI KIRI / KANAN
═══════════════════════════════════════════ */
.tanzaku-nav-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  margin-top: 12px;
}

.tanzaku-nav-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 12px 28px;
  border-radius: 100px;
  border: 1.5px solid rgba(201,169,110,.7);
  background: rgba(30,22,16,.85);
  color: #E8D5A3;
  font-family: 'Noto Serif JP', serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: .1em;
  cursor: pointer;
  transition: all .3s ease;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0,0,0,.4), inset 0 1px 0 rgba(201,169,110,.2);
}
.tanzaku-nav-btn::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(201,169,110,.2), transparent);
  opacity: 0;
  transition: opacity .3s ease;
}
.tanzaku-nav-btn:hover {
  border-color: #C9A96E;
  background: rgba(40,28,18,.95);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,0,0,.5), 0 0 20px rgba(201,169,110,.2);
  color: #f0d888;
}
.tanzaku-nav-btn:hover::before { opacity: 1; }
.tanzaku-nav-btn:active { transform: translateY(0); }
.tanzaku-nav-btn svg {
  width: 16px; height: 16px;
  flex-shrink: 0;
  transition: transform .3s ease;
  stroke: #C9A96E;
}
.tanzaku-nav-btn.nav-prev:hover svg { transform: translateX(-3px); }
.tanzaku-nav-btn.nav-next:hover svg { transform: translateX(3px); }
.tanzaku-nav-btn:disabled {
  opacity: .3;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* Counter halaman */
.tanzaku-nav-counter {
  font-family: 'Noto Serif JP', serif;
  font-size: 12px;
  color: rgba(201,169,110,.7);
  letter-spacing: .1em;
  min-width: 56px;
  text-align: center;
}

/* Dot indicator halaman */
.tanzaku-nav-dots {
  display: flex;
  gap: 6px;
  align-items: center;
}
.tanzaku-nav-dot {
  width: 6px; height: 6px;
  border-radius: 100px;
  background: rgba(201,169,110,.2);
  border: 1px solid rgba(201,169,110,.25);
  cursor: pointer;
  transition: all .3s ease;
}
.tanzaku-nav-dot.active {
  width: 22px;
  background: rgba(201,169,110,.7);
  border-color: rgba(201,169,110,.8);
}

/* ═══════════════════════════════════════════
   KUMO BAWAH — dari Tanzaku (cream) → FAQ (tatami)
═══════════════════════════════════════════ */
.tanzaku-kumo-bottom {
  position: relative;
  z-index: 5;
  line-height: 0;
  margin-top: -2px;
  pointer-events: none;
}
.tanzaku-kumo-bottom svg { display: block; width: 100%; }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 1200px) {
  .tanzaku-item { width: 160px; }
  .tanzaku-card { width: 144px; }
}
@media (max-width: 900px) {
  .tanzaku-cards-wrap {
    flex-wrap: nowrap;
    justify-content: flex-start;
    padding: 0 20px;
  }
  .tanzaku-item { flex-shrink: 0; }
}
@media (max-width: 600px) {
  .tanzaku-inner { padding: 60px 16px 80px; }
  .tanzaku-item { width: 145px; }
  .tanzaku-card { width: 128px; }
  .tanzaku-stats { gap: 8px; padding: 0 12px; }
  .tanzaku-stat-block {
    min-width: 140px; padding: 18px 16px;
    border-radius: 8px !important;
    border: 1px solid rgba(201,169,110,.1) !important;
  }
}
</style>

<!-- ═══════════════════════════════════════════
     KUMO ATAS — Area (gelap) → Tanzaku (gelap)
═══════════════════════════════════════════ -->
<div class="tanzaku-kumo-top" aria-hidden="true">
  <svg viewBox="0 0 1440 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,0 L1440,0 L1440,100 L0,100 Z" fill="#0f0d0a"/>
    <!-- Awan kumo berlapis — fill EDE8DF (warna area bawah) mengisi ke gelap -->
    <ellipse cx="80"   cy="98" rx="110" ry="42" fill="#EDE8DF" opacity=".95"/>
    <ellipse cx="55"   cy="95" rx="70"  ry="30" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="160"  cy="95" rx="95"  ry="36" fill="#EDE8DF" opacity=".92"/>
    <ellipse cx="240"  cy="98" rx="80"  ry="34" fill="#EDE8DF" opacity=".88"/>
    <ellipse cx="320"  cy="94" rx="100" ry="38" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="420"  cy="97" rx="90"  ry="35" fill="#EDE8DF" opacity=".87"/>
    <ellipse cx="510"  cy="95" rx="105" ry="40" fill="#EDE8DF" opacity=".93"/>
    <ellipse cx="620"  cy="98" rx="88"  ry="36" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="720"  cy="94" rx="100" ry="40" fill="#EDE8DF" opacity=".88"/>
    <ellipse cx="820"  cy="97" rx="92"  ry="37" fill="#EDE8DF" opacity=".91"/>
    <ellipse cx="920"  cy="95" rx="105" ry="41" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="1020" cy="98" rx="88"  ry="35" fill="#EDE8DF" opacity=".87"/>
    <ellipse cx="1110" cy="94" rx="100" ry="39" fill="#EDE8DF" opacity=".92"/>
    <ellipse cx="1200" cy="97" rx="95"  ry="37" fill="#EDE8DF" opacity=".89"/>
    <ellipse cx="1290" cy="95" rx="88"  ry="36" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="1370" cy="98" rx="100" ry="40" fill="#EDE8DF" opacity=".88"/>
    <ellipse cx="1440" cy="95" rx="80"  ry="33" fill="#EDE8DF" opacity=".85"/>
    <!-- Lapisan kedua lebih kecil -->
    <ellipse cx="100"  cy="100" rx="70"  ry="28" fill="#0f0d0a" opacity=".6"/>
    <ellipse cx="280"  cy="100" rx="85"  ry="32" fill="#0f0d0a" opacity=".55"/>
    <ellipse cx="480"  cy="100" rx="75"  ry="30" fill="#0f0d0a" opacity=".6"/>
    <ellipse cx="680"  cy="100" rx="90"  ry="33" fill="#0f0d0a" opacity=".58"/>
    <ellipse cx="880"  cy="100" rx="80"  ry="31" fill="#0f0d0a" opacity=".6"/>
    <ellipse cx="1080" cy="100" rx="85"  ry="32" fill="#0f0d0a" opacity=".55"/>
    <ellipse cx="1280" cy="100" rx="78"  ry="30" fill="#0f0d0a" opacity=".58"/>
  </svg>
</div>

<!-- ═══════════════════════════════════════════
     TESTIMONI SECTION
═══════════════════════════════════════════ -->
<section id="testimoni" role="region" aria-label="Testimoni Pelanggan">

  <!-- Kanji floating dekoratif (kiri) -->
  <div class="tanzaku-float-kanji" style="font-size:160px;left:2%;top:8%;animation-delay:-2s;opacity:.5;">花<br>美</div>
  <!-- Kanji floating dekoratif (kanan) -->
  <div class="tanzaku-float-kanji" style="font-size:140px;right:2%;top:15%;animation-delay:-5s;opacity:.4;">縁<br>詩</div>
  <!-- Kanji kecil kiri bawah -->
  <div class="tanzaku-float-kanji" style="font-size:100px;left:5%;bottom:15%;animation-delay:-8s;opacity:.35;">春</div>
  <!-- Kanji kecil kanan bawah -->
  <div class="tanzaku-float-kanji" style="font-size:120px;right:4%;bottom:10%;animation-delay:-3s;opacity:.3;">香</div>

  <div class="tanzaku-inner">

    <!-- ── HEADER ── -->
    <header class="tanzaku-header">
      <div class="tanzaku-header-kanji" aria-hidden="true">花短冊</div>

      <div class="tanzaku-eyebrow">
        <span class="tanzaku-eyebrow-dot"></span>
        短冊の声 · Suara dari Tanzaku
      </div>

      <h2 class="tanzaku-title">
        Apa Kata<br>
        <em style="font-style:italic;font-weight:200;color:var(--gold);">Pelanggan Kami</em>
      </h2>

      <!-- Brush stroke SVG -->
      <svg class="tanzaku-brush" width="200" height="14" viewBox="0 0 200 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8,10 Q30,3 60,8 Q90,13 120,7 Q150,2 175,9 Q188,12 196,8" stroke="#C9A96E" stroke-width="2.5" stroke-linecap="round" fill="none" opacity=".55"/>
        <path d="M20,11 Q55,5 90,9 Q125,13 160,7 Q180,4 195,9" stroke="#C9A96E" stroke-width="1" stroke-linecap="round" fill="none" opacity=".25"/>
      </svg>

      <p class="tanzaku-subtitle">
        Kepercayaan pelanggan adalah bunga yang mekar sepanjang musim
      </p>
    </header>

    <!-- ── RAIL BAMBU ── -->
    <div class="tanzaku-rail-wrap" aria-hidden="true">
      <div class="tanzaku-rail" id="tanzaku-rail">
        <!-- Node bambu di-inject JS -->
      </div>
    </div>

    <!-- ── TANZAKU CAROUSEL ── -->
    <div class="tanzaku-carousel-outer" id="tanzaku-carousel-outer">
      <div class="tanzaku-carousel-track" id="tanzaku-track">

        <?php
        $heights   = [340, 310, 360, 290, 350, 320];
        $stringH   = [30, 36, 28, 40, 32, 26];
        $bgVariant = [
          'linear-gradient(160deg,#faf3e8 0%,#f0e8d8 40%,#e8ddc8 100%)',
          'linear-gradient(160deg,#f8f0e4 0%,#ede4d4 40%,#e4d8c4 100%)',
          'linear-gradient(160deg,#f5ece0 0%,#ead8c8 40%,#e0ccbc 100%)',
          'linear-gradient(160deg,#faf4ec 0%,#f2e9da 40%,#ead8c8 100%)',
          'linear-gradient(160deg,#f8f2e8 0%,#eee4d4 40%,#e6d8c4 100%)',
          'linear-gradient(160deg,#faf3ea 0%,#f0e6d6 40%,#e8dcc6 100%)',
        ];

        /* Render semua card flat — JS yang akan grupkan per page sesuai breakpoint */
        foreach ($testimonials as $ti => $t):
          $idx     = $ti % count($heights);
          $h       = $heights[$idx];
          $sh      = $stringH[$idx];
          $bg      = $bgVariant[$idx % count($bgVariant)];
          $kanji   = $tanzakuKanji[$idx % count($tanzakuKanji)];
          $initial = strtoupper(mb_substr($t['name'], 0, 1, 'UTF-8'));
          $rating  = (int)($t['rating'] ?? 5);
          $date    = isset($t['created_at']) ? date('M Y', strtotime($t['created_at'])) : '';
        ?>
        <div class="tanzaku-item" data-idx="<?= $ti ?>"
             data-h="<?= $h ?>" data-sh="<?= $sh ?>"
             data-bg="<?= htmlspecialchars($bg, ENT_QUOTES) ?>"
             data-kanji="<?= $kanji ?>"
             data-initial="<?= $initial ?>"
             data-rating="<?= $rating ?>"
             data-name="<?= htmlspecialchars($t['name'] ?? '', ENT_QUOTES) ?>"
             data-loc="<?= htmlspecialchars($t['location'] ?? ($date ?: ''), ENT_QUOTES) ?>"
             data-msg="<?= htmlspecialchars($t['message'] ?? ($t['content'] ?? ''), ENT_QUOTES) ?>"
             data-anim="<?= 4.5 + ($ti * .4) ?>"
             style="display:none;">
        </div>
        <?php endforeach; ?>

      </div><!-- /tanzaku-track -->
    </div><!-- /carousel-outer -->

    <!-- ── TOMBOL NAVIGASI ── -->
    <div class="tanzaku-nav-wrap">

      <!-- Tombol Kiri -->
      <button class="tanzaku-nav-btn nav-prev" id="tanzaku-prev" aria-label="Testimoni sebelumnya">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M15 18l-6-6 6-6"/>
        </svg>
        <span style="font-family:'Zen Kaku Gothic New',sans-serif;letter-spacing:.06em;">前へ</span>
      </button>

      <!-- Dot indicator + counter -->
      <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
        <div class="tanzaku-nav-dots" id="tanzaku-dots"></div>
        <div class="tanzaku-nav-counter" id="tanzaku-counter">1 / 1</div>
      </div>

      <!-- Tombol Kanan -->
      <button class="tanzaku-nav-btn nav-next" id="tanzaku-next" aria-label="Testimoni berikutnya">
        <span style="font-family:'Zen Kaku Gothic New',sans-serif;letter-spacing:.06em;">次へ</span>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 18l6-6-6-6"/>
        </svg>
      </button>

    </div><!-- /nav-wrap -->

    <!-- ── STATS BAR — Prasasti Batu ── -->
    <div class="tanzaku-stats" role="list">

      <div class="tanzaku-stat-block" role="listitem">
        <div class="tanzaku-stat-kanji" aria-hidden="true">客</div>
        <div class="tanzaku-stat-num">500<span>+</span></div>
        <div class="tanzaku-stat-label">Pelanggan Puas</div>
      </div>

      <div class="tanzaku-stat-block" role="listitem">
        <div class="tanzaku-stat-kanji" aria-hidden="true">星</div>
        <div class="tanzaku-stat-num">4.9<span>★</span></div>
        <div class="tanzaku-stat-label">Rating Google</div>
      </div>

      <div class="tanzaku-stat-block" role="listitem">
        <div class="tanzaku-stat-kanji" aria-hidden="true">年</div>
        <div class="tanzaku-stat-num">5<span>th</span></div>
        <div class="tanzaku-stat-label">Tahun Berpengalaman</div>
      </div>

      <div class="tanzaku-stat-block" role="listitem">
        <div class="tanzaku-stat-kanji" aria-hidden="true">花</div>
        <div class="tanzaku-stat-num">98<span>%</span></div>
        <div class="tanzaku-stat-label">Repeat Order</div>
      </div>

    </div><!-- /stats -->

  </div><!-- /inner -->
</section>

<!-- ═══════════════════════════════════════════
     KUMO BAWAH — Tanzaku (cream) → FAQ (tatami)
═══════════════════════════════════════════ -->
<div class="tanzaku-kumo-bottom" aria-hidden="true">
  <svg viewBox="0 0 1440 110" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,0 L1440,0 L1440,110 L0,110 Z" fill="#F5F0E8"/>
    <!-- Awan kumo — fill tatami/FAQ color (#EDE8DF) -->
    <ellipse cx="60"   cy="5"  rx="100" ry="38" fill="#EDE8DF" opacity=".95"/>
    <ellipse cx="40"   cy="8"  rx="65"  ry="27" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="150"  cy="4"  rx="90"  ry="35" fill="#EDE8DF" opacity=".92"/>
    <ellipse cx="240"  cy="6"  rx="80"  ry="32" fill="#EDE8DF" opacity=".88"/>
    <ellipse cx="320"  cy="3"  rx="95"  ry="37" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="420"  cy="6"  rx="88"  ry="34" fill="#EDE8DF" opacity=".87"/>
    <ellipse cx="510"  cy="4"  rx="100" ry="39" fill="#EDE8DF" opacity=".93"/>
    <ellipse cx="620"  cy="7"  rx="85"  ry="33" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="720"  cy="3"  rx="98"  ry="38" fill="#EDE8DF" opacity=".88"/>
    <ellipse cx="820"  cy="6"  rx="90"  ry="35" fill="#EDE8DF" opacity=".91"/>
    <ellipse cx="920"  cy="4"  rx="102" ry="40" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="1020" cy="7"  rx="85"  ry="33" fill="#EDE8DF" opacity=".87"/>
    <ellipse cx="1110" cy="3"  rx="97"  ry="38" fill="#EDE8DF" opacity=".92"/>
    <ellipse cx="1200" cy="6"  rx="92"  ry="36" fill="#EDE8DF" opacity=".89"/>
    <ellipse cx="1290" cy="4"  rx="85"  ry="34" fill="#EDE8DF" opacity=".9"/>
    <ellipse cx="1380" cy="7"  rx="98"  ry="39" fill="#EDE8DF" opacity=".88"/>
    <ellipse cx="1440" cy="4"  rx="78"  ry="32" fill="#EDE8DF" opacity=".85"/>
    <!-- Lapisan dalam lebih gelap -->
    <ellipse cx="80"   cy="2"  rx="68"  ry="26" fill="#F5F0E8" opacity=".6"/>
    <ellipse cx="270"  cy="3"  rx="80"  ry="30" fill="#F5F0E8" opacity=".55"/>
    <ellipse cx="470"  cy="2"  rx="72"  ry="28" fill="#F5F0E8" opacity=".6"/>
    <ellipse cx="670"  cy="3"  rx="88"  ry="32" fill="#F5F0E8" opacity=".58"/>
    <ellipse cx="870"  cy="2"  rx="78"  ry="30" fill="#F5F0E8" opacity=".6"/>
    <ellipse cx="1070" cy="3"  rx="82"  ry="31" fill="#F5F0E8" opacity=".55"/>
    <ellipse cx="1270" cy="2"  rx="76"  ry="29" fill="#F5F0E8" opacity=".58"/>
  </svg>
</div>

<script>
(function(){
  /* ── Rail nodes ── */
  const rail = document.getElementById('tanzaku-rail');
  if (rail) {
    const rw = rail.offsetWidth || 1200;
    const nodeCount = Math.floor(rw / 80);
    for (let i = 1; i < nodeCount; i++) {
      const nd = document.createElement('div');
      nd.className = 'tanzaku-rail-node';
      nd.style.left = ((i / nodeCount) * 100) + '%';
      rail.appendChild(nd);
    }
  }

  /* ── CARD BUILDER ── */
  function buildCardHTML(d) {
    let stars = '';
    for (let s = 0; s < d.rating; s++)     stars += '<span class="tanzaku-star tanzaku-star-fill">★</span>';
    for (let s = d.rating; s < 5; s++)     stars += '<span class="tanzaku-star tanzaku-star-empty">★</span>';
    const loc = d.loc ? `<div class="tanzaku-loc">${d.loc}</div>` : '';
    return `
      <div class="tanzaku-item">
        <div class="tanzaku-string" style="height:${d.sh}px;" aria-hidden="true"></div>
        <div class="tanzaku-card" style="height:${d.h}px;animation-duration:${d.anim}s;">
          <div class="tanzaku-card-bg" style="background:${d.bg};"></div>
          <div class="tanzaku-kanji-watermark" aria-hidden="true">${d.kanji}</div>
          <div class="tanzaku-card-content">
            <div class="tanzaku-hanko">${d.initial}</div>
            <div class="tanzaku-stars" aria-label="Rating ${d.rating} dari 5">${stars}</div>
            <div class="tanzaku-divider" aria-hidden="true"></div>
            <p class="tanzaku-text">"${d.msg}"</p>
            <div class="tanzaku-divider" aria-hidden="true"></div>
            <div class="tanzaku-name">${d.name}</div>
            ${loc}
          </div>
          <div class="tanzaku-tip" aria-hidden="true"></div>
        </div>
      </div>`;
  }

  /* ── RESPONSIVE CAROUSEL ENGINE ── */
  const track    = document.getElementById('tanzaku-track');
  const outer    = document.getElementById('tanzaku-carousel-outer');
  const prevBtn  = document.getElementById('tanzaku-prev');
  const nextBtn  = document.getElementById('tanzaku-next');
  const dotsWrap = document.getElementById('tanzaku-dots');
  const counter  = document.getElementById('tanzaku-counter');

  /* Ambil semua data dari hidden PHP items */
  const dataItems = Array.from(document.querySelectorAll('#tanzaku-track .tanzaku-item[data-idx]')).map(el => ({
    h:       el.dataset.h,
    sh:      el.dataset.sh,
    bg:      el.dataset.bg,
    kanji:   el.dataset.kanji,
    initial: el.dataset.initial,
    rating:  parseInt(el.dataset.rating),
    name:    el.dataset.name,
    loc:     el.dataset.loc,
    msg:     el.dataset.msg,
    anim:    el.dataset.anim,
  }));

  let current    = 0;
  let totalPages = 1;

  function getPerPage() {
    const w = window.innerWidth;
    if (w >= 1200) return 6;
    if (w >= 768)  return 4;
    return 2;
  }

  function getCardWidth() {
    const w = window.innerWidth;
    if (w >= 1200) return 180;
    if (w >= 768)  return 160;
    return 145;
  }

  function rebuildCarousel() {
    const perPage = getPerPage();
    const cardW   = getCardWidth();
    totalPages    = Math.max(1, Math.ceil(dataItems.length / perPage));
    current       = Math.min(current, totalPages - 1);

    /* Clear & rebuild track */
    track.innerHTML = '';
    for (let p = 0; p < totalPages; p++) {
      const pageEl = document.createElement('div');
      pageEl.className = 'tanzaku-slide-page';
      pageEl.dataset.page = p;

      const slice = dataItems.slice(p * perPage, (p + 1) * perPage);

      /* Center page: kalau card kurang dari perPage, beri padding kiri */
      const cardGap    = 18;
      const pageW      = slice.length * cardW + (slice.length - 1) * cardGap;
      const outerW     = outer.offsetWidth || window.innerWidth;
      const paddingL   = Math.max(0, (outerW - pageW) / 2);
      pageEl.style.paddingLeft  = paddingL + 'px';
      pageEl.style.paddingRight = paddingL + 'px';
      pageEl.style.boxSizing    = 'border-box';

      slice.forEach(d => {
        const tmp = document.createElement('div');
        tmp.innerHTML = buildCardHTML(d);
        pageEl.appendChild(tmp.firstElementChild);
      });

      track.appendChild(pageEl);
    }

    buildDots();
    goTo(current, false);
  }

  function getPageWidth() {
    const page = track.querySelector('.tanzaku-slide-page');
    if (!page) return 0;
    /* Width termasuk padding kiri kanan + margin antar page (gap track = 18) */
    return page.offsetWidth + 18;
  }

  function goTo(idx, animate = true) {
    if (idx < 0)           idx = totalPages - 1;
    if (idx >= totalPages) idx = 0;
    current = idx;

    track.style.transition = animate
      ? 'transform .55s cubic-bezier(.4,0,.2,1)'
      : 'none';
    track.style.transform = `translateX(-${current * getPageWidth()}px)`;

    dotsWrap.querySelectorAll('.tanzaku-nav-dot').forEach((d, i) => {
      d.classList.toggle('active', i === current);
    });

    if (counter) counter.textContent = `${current + 1} / ${totalPages}`;

    if (prevBtn) prevBtn.disabled = (totalPages <= 1);
    if (nextBtn) nextBtn.disabled = (totalPages <= 1);

    if (!animate) {
      track.offsetHeight; // force reflow
      track.style.transition = 'transform .55s cubic-bezier(.4,0,.2,1)';
    }
  }

  function buildDots() {
    if (!dotsWrap) return;
    dotsWrap.innerHTML = '';
    for (let i = 0; i < totalPages; i++) {
      const d = document.createElement('button');
      d.className = 'tanzaku-nav-dot' + (i === current ? ' active' : '');
      d.setAttribute('aria-label', `Halaman testimoni ${i + 1}`);
      d.addEventListener('click', () => goTo(i));
      dotsWrap.appendChild(d);
    }
  }

  if (prevBtn) prevBtn.addEventListener('click', () => goTo(current - 1));
  if (nextBtn) nextBtn.addEventListener('click', () => goTo(current + 1));

  /* Touch / swipe */
  let touchStartX = 0;
  if (outer) {
    outer.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
    outer.addEventListener('touchend', e => {
      const diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) goTo(diff > 0 ? current + 1 : current - 1);
    });
  }

  /* Resize → rebuild */
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(rebuildCarousel, 200);
  });

  /* Init */
  rebuildCarousel();

})();
</script>