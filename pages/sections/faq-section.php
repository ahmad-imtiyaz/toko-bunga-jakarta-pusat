<?php
/* ================================================================
   FAQ SECTION — Makimono (巻物) Accordion Gulungan
   Konsep: Setiap FAQ = satu gulungan makimono yang terbuka saat diklik
           Rod kayu atas & bawah, tali pengikat, kertas washi
   Warna: Matcha Sage (#7A8C6E) + Cream (#F5F0E8)
   Elemen: Kanji vertikal dekoratif, Hanko stamp, Animasi accordion
================================================================ */

// Fallback data
if (!isset($faqs) || empty($faqs)) {
  $faqs = [
    ['question' => 'Berapa lama proses pengiriman bunga?',
     'answer'   => 'Pengiriman same-day tersedia untuk order sebelum jam 14.00 WIB. Untuk wilayah Jakarta Pusat dan sekitarnya biasanya tiba dalam 2–4 jam. Area luar Jakarta membutuhkan 1–2 hari kerja tergantung lokasi tujuan.'],
    ['question' => 'Apakah bisa custom desain rangkaian bunga?',
     'answer'   => 'Tentu! Kami sangat senang menerima request custom. Cukup kirim referensi foto atau deskripsi keinginan Anda via WhatsApp, tim florist kami akan membantu mewujudkan visi Anda dengan bunga-bunga pilihan terbaik.'],
    ['question' => 'Bagaimana cara merawat bunga agar tahan lama?',
     'answer'   => 'Tempatkan bunga di air bersih, ganti air setiap 2 hari, dan potong sedikit bagian bawah batang secara diagonal. Jauhkan dari sinar matahari langsung dan AC. Dengan perawatan yang tepat, bunga segar bisa bertahan 5–10 hari.'],
    ['question' => 'Apakah tersedia layanan dekorasi untuk acara?',
     'answer'   => 'Ya! Kami melayani dekorasi pernikahan, ulang tahun, pembukaan toko, wisuda, dan berbagai acara lainnya. Konsultasi gratis tersedia untuk membantu merencanakan dekorasi impian Anda sesuai budget.'],
    ['question' => 'Metode pembayaran apa saja yang diterima?',
     'answer'   => 'Kami menerima transfer bank (BCA, Mandiri, BNI, BRI), e-wallet (GoPay, OVO, Dana, ShopeePay), QRIS, dan COD untuk area tertentu. Untuk pesanan besar, bisa menggunakan cicilan 0%.'],
    ['question' => 'Apakah ada garansi kesegaran bunga?',
     'answer'   => 'Kami menjamin semua bunga dalam kondisi segar saat dikirim. Jika ada kendala kualitas, hubungi kami dalam 24 jam setelah penerimaan disertai foto, dan kami akan memberikan penggantian atau refund penuh.'],
  ];
}

$kanjiList = ['問','答','花','縁','心','誠','信','和','美','静'];
$sageAccents = ['#7A8C6E','#6B7D60','#8FA082','#5A6E52'];
?>

<!-- FAQ Schema SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php foreach ($faqs as $i => $faq): ?>
    {
      "@type": "Question",
      "name": "<?= addslashes(htmlspecialchars_decode($faq['question'])) ?>",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<?= addslashes(htmlspecialchars_decode($faq['answer'])) ?>"
      }
    }<?= $i < count($faqs)-1 ? ',' : '' ?>
    <?php endforeach; ?>
  ]
}
</script>

<style>
/* ═══════════════════════════════════════
   FAQ — CORE VARIABLES
═══════════════════════════════════════ */
#faq {
  --matcha:    #7A8C6E;
  --matcha-dk: #5A6E52;
  --matcha-lt: #A8BF9A;
  --sage:      #8FA082;
  --washi:     #F5F0E8;
  --tatami:    #EDE8DF;
  --bamboo:    #C4A882;
  --bamboo-dk: #8B6F5E;
  --gold:      #C9A96E;
  --hanko:     #8B2020;
  --ink:       #1C1C1C;
  --muted:     #6B7A62;
  font-family: 'Zen Kaku Gothic New', 'Noto Sans JP', sans-serif;
}

/* ═══════════════════════════════════════
   KUMO ATAS — Tanzaku (cream) → FAQ (matcha)
═══════════════════════════════════════ */
.faq-kumo-top {
  position: relative;
  z-index: 5;
  line-height: 0;
  margin-bottom: -2px;
  pointer-events: none;
}
.faq-kumo-top svg { display: block; width: 100%; }

/* ═══════════════════════════════════════
   SECTION WRAPPER
═══════════════════════════════════════ */
#faq {
  position: relative;
  overflow: hidden;
  background: linear-gradient(
    to bottom,
    #EDE8DF 0%,
    #dde8d8 18%,
    #cdd9c6 35%,
    #b8ccaf 55%,
    #A8BF9A 75%,
    #8FA082 100%
  );
  padding: 0;
}

/* Tatami grid subtle */
#faq::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    repeating-linear-gradient(0deg,  rgba(90,110,82,.05) 0, rgba(90,110,82,.05) 1px, transparent 1px, transparent 44px),
    repeating-linear-gradient(90deg, rgba(90,110,82,.05) 0, rgba(90,110,82,.05) 1px, transparent 1px, transparent 44px);
  pointer-events: none;
  z-index: 0;
}

/* Washi noise */
#faq::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.7' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='.025'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
}

/* ═══════════════════════════════════════
   INNER
═══════════════════════════════════════ */
.faq-inner {
  position: relative;
  z-index: 2;
  max-width: 1100px;
  margin: 0 auto;
  padding: 80px 24px 100px;
}

/* ═══════════════════════════════════════
   FLOATING KANJI VERTIKAL
═══════════════════════════════════════ */
.faq-float-kanji {
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-weight: 200;
  color: rgba(90,110,82,.07);
  pointer-events: none;
  user-select: none;
  writing-mode: vertical-rl;
  line-height: 1;
  animation: faqKanjiFloat 14s ease-in-out infinite;
}
@keyframes faqKanjiFloat {
  0%,100% { transform: translateY(0) rotate(0deg); opacity: .7; }
  40%     { transform: translateY(-20px) rotate(.4deg); opacity: 1; }
  70%     { transform: translateY(10px) rotate(-.3deg); opacity: .8; }
}

/* ═══════════════════════════════════════
   HEADER
═══════════════════════════════════════ */
.faq-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  margin-bottom: 56px;
  position: relative;
}

.faq-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .22em;
  text-transform: uppercase;
  color: var(--matcha-dk);
  background: rgba(122,140,110,.12);
  border: 1px solid rgba(122,140,110,.3);
  border-radius: 100px;
  padding: 4px 14px;
  margin-bottom: 16px;
}
.faq-eyebrow-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: var(--matcha-dk);
  animation: faqPulse 2.2s ease-in-out infinite;
}
@keyframes faqPulse {
  0%,100% { opacity: 1; transform: scale(1); }
  50%     { opacity: .4; transform: scale(.65); }
}

.faq-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(26px, 3.8vw, 44px);
  font-weight: 300;
  color: #2a3a25;
  letter-spacing: .06em;
  line-height: 1.3;
  margin: 0 0 8px;
  position: relative;
}
.faq-title em {
  font-style: normal;
  font-weight: 200;
  color: var(--matcha-dk);
}

/* Brush stroke bawah judul */
.faq-brush {
  display: block;
  margin: 10px auto 0;
  opacity: .4;
}

.faq-subtitle {
  font-size: 13.5px;
  color: rgba(42,58,37,.6);
  margin-top: 12px;
  letter-spacing: .04em;
  max-width: 460px;
}

/* Kanji besar di header */
.faq-header-kanji {
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-size: 160px;
  font-weight: 200;
  color: rgba(90,110,82,.05);
  top: -40px;
  left: 50%;
  transform: translateX(-50%);
  pointer-events: none;
  user-select: none;
  letter-spacing: .1em;
}

/* ═══════════════════════════════════════
   LAYOUT — 2 KOLOM
═══════════════════════════════════════ */
.faq-layout {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 40px;
  align-items: start;
}
@media (max-width: 900px) {
  .faq-layout { grid-template-columns: 1fr; gap: 32px; }
}

/* ═══════════════════════════════════════
   MAKIMONO ACCORDION LIST
═══════════════════════════════════════ */
.faq-scroll-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

/* ═══════════════════════════════════════
   SATU MAKIMONO ITEM
═══════════════════════════════════════ */
.faq-maki {
  position: relative;
}

/* Rod kayu ATAS tiap makimono */
.faq-rod {
  position: relative;
  height: 18px;
  background: linear-gradient(to bottom, #d4a96a 0%, #C4A882 35%, #a88555 65%, #8B6F5E 100%);
  border-radius: 9px;
  box-shadow: 0 3px 10px rgba(0,0,0,.25), inset 0 1px 3px rgba(255,220,150,.2);
  z-index: 3;
  margin: 0 12px;
}
.faq-rod::before,
.faq-rod::after {
  content: '';
  position: absolute;
  top: 50%; transform: translateY(-50%);
  width: 26px; height: 26px;
  border-radius: 50%;
  background: radial-gradient(circle at 35% 35%, #f0d080, #C9A96E 40%, #8B6F5E 80%);
  box-shadow: 0 2px 8px rgba(0,0,0,.4), inset 0 1px 2px rgba(255,220,100,.4);
  z-index: 4;
}
.faq-rod::before { left: -10px; }
.faq-rod::after  { right: -10px; }

/* Rod node bambu */
.faq-rod-node {
  position: absolute;
  top: 0; bottom: 0;
  width: 3px;
  background: rgba(0,0,0,.2);
  border-radius: 2px;
}

/* ═══════════════════════════════════════
   WASHI PAPER BODY (collapsed)
═══════════════════════════════════════ */
.faq-washi {
  position: relative;
  background: linear-gradient(160deg, #f8f3ea 0%, #f0e8d8 50%, #e8ddc8 100%);
  margin: 0 16px;
  overflow: hidden;
  box-shadow: 3px 6px 20px rgba(0,0,0,.15), inset 0 0 0 1px rgba(196,168,130,.12);
  /* Serat washi */
  background-image:
    linear-gradient(160deg, #f8f3ea 0%, #f0e8d8 50%, #e8ddc8 100%),
    repeating-linear-gradient(90deg, transparent 0px, transparent 3px, rgba(180,150,110,.04) 3px, rgba(180,150,110,.04) 4px);
  transition: box-shadow .3s ease;
}
.faq-maki.open .faq-washi {
  box-shadow: 4px 10px 32px rgba(0,0,0,.22), 0 0 0 1.5px rgba(122,140,110,.3);
}

/* Kanji watermark di dalam washi */
.faq-washi-kanji {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  font-family: 'Noto Serif JP', serif;
  font-size: 72px;
  font-weight: 200;
  color: rgba(122,140,110,.07);
  writing-mode: vertical-rl;
  line-height: 1;
  pointer-events: none;
  user-select: none;
  transition: opacity .4s ease;
}
.faq-maki.open .faq-washi-kanji { opacity: .12; }

/* ═══════════════════════════════════════
   QUESTION ROW (trigger)
═══════════════════════════════════════ */
.faq-q-row {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 18px 20px;
  cursor: pointer;
  position: relative;
  z-index: 2;
  transition: background .25s ease;
  -webkit-tap-highlight-color: transparent;
  user-select: none;
}
.faq-q-row:hover { background: rgba(122,140,110,.06); }

/* Hanko stamp (nomor) */
.faq-hanko {
  width: 36px; height: 36px;
  border-radius: 50%;
  border: 2px solid rgba(139,32,32,.5);
  background: rgba(139,32,32,.07);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Noto Serif JP', serif;
  font-size: 13px;
  font-weight: 700;
  color: var(--hanko);
  flex-shrink: 0;
  transition: transform .35s cubic-bezier(.34,1.56,.64,1), background .3s ease;
}
.faq-maki.open .faq-hanko {
  transform: rotate(10deg) scale(1.1);
  background: rgba(139,32,32,.14);
}

/* Kanji label kecil di sebelah hanko */
.faq-hanko-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 9px;
  color: rgba(139,32,32,.4);
  letter-spacing: .05em;
  margin-top: 1px;
  text-align: center;
  line-height: 1;
}

.faq-q-text {
  flex: 1;
  font-family: 'Noto Serif JP', serif;
  font-size: 14.5px;
  font-weight: 500;
  color: #2a3a25;
  line-height: 1.5;
  letter-spacing: .02em;
}

/* Brush stroke expand icon */
.faq-expand-icon {
  width: 32px; height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: transform .4s cubic-bezier(.34,1.56,.64,1);
}
.faq-maki.open .faq-expand-icon {
  transform: rotate(180deg);
}
.faq-expand-icon svg { display: block; }

/* ═══════════════════════════════════════
   ACCORDION ANSWER — GULUNGAN TERBUKA
═══════════════════════════════════════ */
.faq-answer-wrap {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows .45s cubic-bezier(.4,0,.2,1);
}
.faq-maki.open .faq-answer-wrap {
  grid-template-rows: 1fr;
}
.faq-answer-inner {
  overflow: hidden;
}

.faq-answer-body {
  padding: 0 20px 22px 20px;
  padding-left: 74px; /* indent sejajar teks pertanyaan */
  position: relative;
}

/* Garis aksen kiri (brush stroke vertikal) */
.faq-answer-body::before {
  content: '';
  position: absolute;
  left: 62px;
  top: 0; bottom: 10px;
  width: 2px;
  background: linear-gradient(to bottom, rgba(122,140,110,.5), rgba(122,140,110,.1));
  border-radius: 2px;
}

.faq-answer-text {
  font-size: 13.5px;
  line-height: 1.9;
  color: rgba(42,58,37,.75);
  letter-spacing: .02em;
}

/* Brush stamp "✓ Dijawab" */
.faq-answered-stamp {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--matcha-dk);
  background: rgba(122,140,110,.1);
  border: 1px solid rgba(122,140,110,.25);
  border-radius: 100px;
  padding: 3px 10px;
  margin-top: 10px;
}

/* Rod bambu BAWAH */
.faq-rod-bottom {
  height: 10px;
  background: linear-gradient(to bottom, #a88555 0%, #8B6F5E 100%);
  margin: 0 28px;
  border-radius: 0 0 5px 5px;
  box-shadow: 0 3px 8px rgba(0,0,0,.2);
  /* Muncul saat terbuka */
  max-height: 0;
  overflow: hidden;
  transition: max-height .4s cubic-bezier(.4,0,.2,1) .05s;
}
.faq-maki.open .faq-rod-bottom {
  max-height: 10px;
}

/* Tali pengikat (ikatan gulungan) */
.faq-string {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 3px;
  background: linear-gradient(to bottom, rgba(196,168,130,.8), rgba(139,111,94,.4));
  top: 18px;
  height: 10px;
  z-index: 5;
  border-radius: 2px;
  transition: opacity .3s ease;
}
.faq-maki.open .faq-string { opacity: 0; }

/* ═══════════════════════════════════════
   PANEL KANAN — Makimono Info
═══════════════════════════════════════ */
.faq-side-panel {
  display: flex;
  flex-direction: column;
  gap: 20px;
  position: sticky;
  top: 100px;
}

/* Gulungan dekoratif besar */
.faq-deco-scroll {
  position: relative;
  background: linear-gradient(160deg, #f8f3ea 0%, #ede5d4 100%);
  border-radius: 8px;
  padding: 28px 24px;
  box-shadow: 4px 8px 24px rgba(0,0,0,.12);
  text-align: center;
  overflow: hidden;
}
/* Rod atas panel */
.faq-deco-scroll::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 12px;
  background: linear-gradient(to bottom, #C4A882, #a88555);
  border-radius: 8px 8px 0 0;
}
/* Rod bawah panel */
.faq-deco-scroll::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 10px;
  background: linear-gradient(to top, #8B6F5E, #a88555);
  border-radius: 0 0 8px 8px;
}

.faq-deco-content {
  padding: 8px 0;
  position: relative;
  z-index: 1;
}

.faq-deco-kanji {
  font-family: 'Noto Serif JP', serif;
  font-size: 52px;
  font-weight: 200;
  color: rgba(90,110,82,.2);
  line-height: 1;
  margin-bottom: 12px;
}

.faq-deco-num {
  font-family: 'Noto Serif JP', serif;
  font-size: 40px;
  font-weight: 300;
  color: #2a3a25;
  line-height: 1;
}
.faq-deco-num span {
  font-size: 18px;
  color: var(--matcha-dk);
}
.faq-deco-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: rgba(42,58,37,.45);
  margin-top: 4px;
}

.faq-deco-divider {
  width: 60px; height: 1px;
  background: linear-gradient(90deg, transparent, rgba(122,140,110,.4), transparent);
  margin: 14px auto;
}

/* Stats kecil dalam panel */
.faq-deco-stats {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-top: 4px;
}
.faq-deco-stat {
  text-align: center;
}
.faq-deco-stat-val {
  font-family: 'Noto Serif JP', serif;
  font-size: 18px;
  font-weight: 400;
  color: #2a3a25;
}
.faq-deco-stat-lbl {
  font-size: 9px;
  font-weight: 700;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: rgba(42,58,37,.4);
}

/* CTA WA Panel */
.faq-wa-panel {
  background: linear-gradient(135deg, #5A6E52, #7A8C6E);
  border-radius: 16px;
  padding: 24px 20px;
  text-align: center;
  box-shadow: 0 8px 28px rgba(90,110,82,.3);
  position: relative;
  overflow: hidden;
}
.faq-wa-panel::before {
  content: '問';
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-size: 120px;
  font-weight: 200;
  color: rgba(255,255,255,.04);
  top: -20px;
  right: -10px;
  line-height: 1;
  pointer-events: none;
}
.faq-wa-title {
  font-family: 'Noto Serif JP', serif;
  font-size: 15px;
  font-weight: 400;
  color: rgba(245,240,232,.9);
  margin-bottom: 4px;
  letter-spacing: .05em;
}
.faq-wa-sub {
  font-size: 11.5px;
  color: rgba(245,240,232,.5);
  margin-bottom: 16px;
  letter-spacing: .04em;
}
.faq-wa-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #F5F0E8;
  color: #2a3a25;
  font-weight: 700;
  font-size: 12.5px;
  padding: 11px 22px;
  border-radius: 100px;
  text-decoration: none;
  transition: all .3s ease;
  box-shadow: 0 4px 12px rgba(0,0,0,.2);
  letter-spacing: .04em;
}
.faq-wa-btn:hover {
  background: #fff;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,0,0,.25);
}

/* Reset button */
.faq-reset-link {
  font-size: 11.5px;
  color: rgba(42,58,37,.5);
  text-align: center;
  cursor: pointer;
  padding: 8px;
  border-radius: 8px;
  transition: color .2s, background .2s;
  border: 1px solid rgba(122,140,110,.2);
  background: rgba(122,140,110,.06);
  letter-spacing: .04em;
}
.faq-reset-link:hover {
  background: rgba(122,140,110,.14);
  color: var(--matcha-dk);
}

/* ═══════════════════════════════════════
   KUMO BAWAH — FAQ (matcha) → CTA
═══════════════════════════════════════ */
.faq-kumo-bottom {
  position: relative;
  z-index: 5;
  line-height: 0;
  margin-top: -2px;
  pointer-events: none;
}
.faq-kumo-bottom svg { display: block; width: 100%; }

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media (max-width: 767px) {
  .faq-inner { padding: 60px 16px 80px; }
  .faq-answer-body { padding-left: 20px; }
  .faq-answer-body::before { display: none; }
  .faq-q-row { padding: 15px 16px; }
  .faq-washi { margin: 0 8px; }
  .faq-rod { margin: 0 8px; }
  .faq-rod-bottom { margin: 0 20px; }
  .faq-side-panel { position: static; }
}
</style>

<!-- ═══════════════════════════════════════
     KUMO ATAS — Tanzaku cream → FAQ matcha
═══════════════════════════════════════ -->
<div class="faq-kumo-top" aria-hidden="true">
  <svg viewBox="0 0 1440 110" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,0 L1440,0 L1440,110 L0,110 Z" fill="#EDE8DF"/>
    <!-- Kumo bergradasi ke matcha -->
    <ellipse cx="60"   cy="108" rx="105" ry="42" fill="#dde8d8" opacity=".95"/>
    <ellipse cx="40"   cy="105" rx="68"  ry="28" fill="#dde8d8" opacity=".9"/>
    <ellipse cx="155"  cy="106" rx="92"  ry="37" fill="#cdd9c6" opacity=".92"/>
    <ellipse cx="245"  cy="108" rx="82"  ry="34" fill="#cdd9c6" opacity=".88"/>
    <ellipse cx="330"  cy="105" rx="98"  ry="39" fill="#c2d3ba" opacity=".9"/>
    <ellipse cx="430"  cy="107" rx="90"  ry="36" fill="#b8ccaf" opacity=".87"/>
    <ellipse cx="520"  cy="105" rx="106" ry="41" fill="#b8ccaf" opacity=".93"/>
    <ellipse cx="625"  cy="108" rx="88"  ry="36" fill="#aec5a6" opacity=".9"/>
    <ellipse cx="725"  cy="104" rx="102" ry="40" fill="#aec5a6" opacity=".88"/>
    <ellipse cx="825"  cy="107" rx="94"  ry="37" fill="#A8BF9A" opacity=".91"/>
    <ellipse cx="925"  cy="105" rx="106" ry="41" fill="#A8BF9A" opacity=".9"/>
    <ellipse cx="1025" cy="108" rx="90"  ry="36" fill="#9fb690" opacity=".87"/>
    <ellipse cx="1115" cy="104" rx="100" ry="40" fill="#9fb690" opacity=".92"/>
    <ellipse cx="1205" cy="107" rx="94"  ry="37" fill="#8FA082" opacity=".89"/>
    <ellipse cx="1295" cy="105" rx="90"  ry="36" fill="#8FA082" opacity=".9"/>
    <ellipse cx="1380" cy="108" rx="102" ry="40" fill="#7A8C6E" opacity=".88"/>
    <ellipse cx="1440" cy="105" rx="82"  ry="33" fill="#7A8C6E" opacity=".85"/>
    <!-- Lapisan gelap-ish -->
    <ellipse cx="100"  cy="110" rx="70"  ry="27" fill="#EDE8DF" opacity=".55"/>
    <ellipse cx="285"  cy="110" rx="82"  ry="31" fill="#EDE8DF" opacity=".5"/>
    <ellipse cx="485"  cy="110" rx="74"  ry="29" fill="#EDE8DF" opacity=".52"/>
    <ellipse cx="685"  cy="110" rx="88"  ry="32" fill="#EDE8DF" opacity=".48"/>
    <ellipse cx="885"  cy="110" rx="78"  ry="30" fill="#EDE8DF" opacity=".5"/>
    <ellipse cx="1085" cy="110" rx="84"  ry="31" fill="#EDE8DF" opacity=".45"/>
    <ellipse cx="1285" cy="110" rx="78"  ry="30" fill="#EDE8DF" opacity=".5"/>
  </svg>
</div>

<!-- ═══════════════════════════════════════
     FAQ SECTION
═══════════════════════════════════════ -->
<section id="faq" role="region" aria-label="Pertanyaan yang Sering Ditanyakan">

  <!-- Kanji floating dekoratif -->
  <div class="faq-float-kanji" style="font-size:180px;left:1%;top:5%;animation-delay:-3s;">問<br>答</div>
  <div class="faq-float-kanji" style="font-size:140px;right:1.5%;top:20%;animation-delay:-7s;">花<br>縁</div>
  <div class="faq-float-kanji" style="font-size:110px;left:4%;bottom:12%;animation-delay:-11s;">誠</div>
  <div class="faq-float-kanji" style="font-size:130px;right:3%;bottom:8%;animation-delay:-5s;">静<br>和</div>

  <div class="faq-inner">

    <!-- HEADER -->
    <header class="faq-header">
      <div class="faq-header-kanji" aria-hidden="true">巻物問答</div>

      <div class="faq-eyebrow">
        <span class="faq-eyebrow-dot"></span>
        巻物問答 · Makimono FAQ
      </div>

      <h2 class="faq-title">
        Pertanyaan <em>Sering</em><br>Ditanyakan
      </h2>

      <svg class="faq-brush" width="220" height="14" viewBox="0 0 220 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10,10 Q35,3 65,8 Q95,13 130,7 Q160,2 190,9 Q205,12 214,8" stroke="#5A6E52" stroke-width="2.5" stroke-linecap="round" fill="none" opacity=".5"/>
        <path d="M22,11 Q58,5 95,9 Q132,13 168,7 Q190,4 212,9" stroke="#5A6E52" stroke-width="1" stroke-linecap="round" fill="none" opacity=".2"/>
      </svg>

      <p class="faq-subtitle">
        Klik gulungan di bawah untuk membuka jawaban kami 🍵
      </p>
    </header>

    <!-- LAYOUT -->
    <div class="faq-layout">

      <!-- ACCORDION LIST -->
      <div class="faq-scroll-list" id="faq-list">

        <?php
        $kanjiNums = ['一','二','三','四','五','六','七','八','九','十'];
        foreach ($faqs as $fi => $faq):
          $kNum = $kanjiNums[$fi % count($kanjiNums)];
          $kDeco = $kanjiList[$fi % count($kanjiList)];
        ?>
        <div class="faq-maki" id="faq-item-<?= $fi ?>" role="listitem">

          <!-- Tali pengikat -->
          <div class="faq-string" aria-hidden="true"></div>

          <!-- Rod bambu atas -->
          <div class="faq-rod" aria-hidden="true">
            <div class="faq-rod-node" style="left:20%;"></div>
            <div class="faq-rod-node" style="left:40%;"></div>
            <div class="faq-rod-node" style="left:60%;"></div>
            <div class="faq-rod-node" style="left:80%;"></div>
          </div>

          <!-- Washi paper -->
          <div class="faq-washi">

            <!-- Kanji watermark -->
            <div class="faq-washi-kanji" aria-hidden="true"><?= $kDeco ?></div>

            <!-- Trigger row -->
            <div class="faq-q-row"
                 role="button"
                 aria-expanded="false"
                 aria-controls="faq-answer-<?= $fi ?>"
                 tabindex="0"
                 onclick="faqToggle(<?= $fi ?>)"
                 onkeydown="if(event.key==='Enter'||event.key===' ')faqToggle(<?= $fi ?>)">

              <div style="display:flex;flex-direction:column;align-items:center;gap:2px;">
                <div class="faq-hanko"><?= $kNum ?></div>
                <div class="faq-hanko-kanji"><?= $kDeco ?></div>
              </div>

              <span class="faq-q-text"><?= htmlspecialchars($faq['question'], ENT_QUOTES, 'UTF-8') ?></span>

              <div class="faq-expand-icon" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none">
                  <circle cx="11" cy="11" r="10" stroke="rgba(90,110,82,.3)" stroke-width="1.5"/>
                  <path d="M7 9.5l4 4 4-4" stroke="#5A6E52" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </div>

            <!-- Jawaban accordion -->
            <div class="faq-answer-wrap" id="faq-answer-<?= $fi ?>" role="region">
              <div class="faq-answer-inner">
                <div class="faq-answer-body">
                  <p class="faq-answer-text"><?= htmlspecialchars($faq['answer'], ENT_QUOTES, 'UTF-8') ?></p>
                  <div class="faq-answered-stamp">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                      <path d="M2 5.2l2 2 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Dijawab · <?= $kNum ?>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- /faq-washi -->

          <!-- Rod bambu bawah (muncul saat buka) -->
          <div class="faq-rod-bottom" aria-hidden="true"></div>

        </div><!-- /faq-maki -->
        <?php endforeach; ?>

      </div><!-- /faq-scroll-list -->

      <!-- PANEL KANAN -->
      <aside class="faq-side-panel">

        <!-- Gulungan dekoratif info -->
        <div class="faq-deco-scroll">
          <div class="faq-deco-content">
            <div class="faq-deco-kanji" aria-hidden="true">問</div>
            <div class="faq-deco-num"><?= count($faqs) ?><span> FAQ</span></div>
            <div class="faq-deco-label">Pertanyaan Tersedia</div>
            <div class="faq-deco-divider"></div>
            <div class="faq-deco-stats">
              <div class="faq-deco-stat">
                <div class="faq-deco-stat-val">24/7</div>
                <div class="faq-deco-stat-lbl">Siap Bantu</div>
              </div>
              <div class="faq-deco-stat">
                <div class="faq-deco-stat-val">Free</div>
                <div class="faq-deco-stat-lbl">Konsultasi</div>
              </div>
            </div>
          </div>
        </div>

        <!-- CTA WhatsApp -->
        <div class="faq-wa-panel">
          <div class="faq-wa-title">Belum Terjawab?</div>
          <div class="faq-wa-sub">Hubungi kami langsung via WhatsApp</div>
          <?php 
$wa_msg = urlencode('Halo, saya punya pertanyaan tentang Hana no Yado 🌸');
?>

<a href="<?= isset($wa_url) 
    ? 'https://wa.me/' . $wa_url . '?text=' . $wa_msg 
    : '#' ?>"
   target="_blank"
   rel="noopener noreferrer"
   class="faq-wa-btn">
  <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.25-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
  </svg>
  Tanya WhatsApp
</a>
        </div>

        <!-- Reset -->
        <div class="faq-reset-link" role="button" tabindex="0"
             onclick="faqResetAll()"
             onkeydown="if(event.key==='Enter')faqResetAll()">
          🔄 Tutup Semua Gulungan
        </div>

      </aside>
    </div><!-- /faq-layout -->

  </div><!-- /faq-inner -->
</section>



<script>
(function () {

  /* ── Toggle satu makimono ── */
  window.faqToggle = function(idx) {
    const item    = document.getElementById('faq-item-' + idx);
    const answer  = document.getElementById('faq-answer-' + idx);
    const trigger = item?.querySelector('.faq-q-row');
    if (!item) return;

    const isOpen = item.classList.contains('open');

    /* Opsi: tutup semua dulu (accordion eksklusif) */
    document.querySelectorAll('#faq-list .faq-maki.open').forEach(el => {
      if (el !== item) {
        el.classList.remove('open');
        el.querySelector('.faq-q-row')?.setAttribute('aria-expanded', 'false');
      }
    });

    if (!isOpen) {
      item.classList.add('open');
      trigger?.setAttribute('aria-expanded', 'true');
      /* Scroll ke item jika tidak kelihatan */
      setTimeout(() => {
        const rect = item.getBoundingClientRect();
        if (rect.top < 80) {
          item.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }, 300);
    } else {
      item.classList.remove('open');
      trigger?.setAttribute('aria-expanded', 'false');
    }
  };

  /* ── Reset semua ── */
  window.faqResetAll = function() {
    document.querySelectorAll('#faq-list .faq-maki').forEach(el => {
      el.classList.remove('open');
      el.querySelector('.faq-q-row')?.setAttribute('aria-expanded', 'false');
    });
  };

  /* ── Tambah rod nodes ── */
  document.querySelectorAll('#faq-list .faq-rod').forEach(rod => {
    const rw = rod.offsetWidth || 600;
    const n  = Math.floor(rw / 70);
    for (let i = 1; i < n; i++) {
      const nd = document.createElement('div');
      nd.className = 'faq-rod-node';
      nd.style.left = ((i / n) * 100) + '%';
      rod.appendChild(nd);
    }
  });

})();
</script>