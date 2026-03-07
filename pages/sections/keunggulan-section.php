<?php
/* ============================================================
   TENTANG SECTION — Manila Florist · Kertas Cream Warm
   Konten: 4 foto grid + 5 keunggulan card + 4 stats + CTA
============================================================ */
?>

<style>
/* ══════════════════════════════════════════
   TENTANG SECTION — Manila Florist
══════════════════════════════════════════ */
#tentang {
  position: relative;
  background: var(--manila);
  overflow: hidden;
}

/* Grain texture — static, 0 animasi */
#tentang::before {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 0;
  pointer-events: none;
  opacity: .032;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 200px 200px;
}

/* Wave divider */
.tentang-wave     { line-height: 0; }
.tentang-wave svg { width: 100%; display: block; }

/* Inner wrapper */
.tentang-inner {
  position: relative;
  z-index: 1;
  max-width: 1280px;
  margin: 0 auto;
  padding: 72px 32px 80px;
}

/* ════════════════════════
   HEADER
════════════════════════ */
.tentang-header {
  text-align: center;
  margin-bottom: 56px;
}
.tentang-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--paper);
  border: 1px solid var(--manila-dd);
  border-radius: 100px;
  padding: 6px 16px 6px 10px;
  margin-bottom: 20px;
}
.tentang-badge-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--sage);
  flex-shrink: 0;
}
.tentang-badge-text {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px;
  font-weight: 500;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--ink-l);
}
.tentang-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.8vw, 3.2rem);
  font-weight: 600;
  color: var(--ink);
  line-height: 1.1;
  letter-spacing: -.01em;
}
.tentang-title em {
  font-style: italic;
  font-weight: 300;
  color: var(--rose);
}
.tentang-rule {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin: 18px auto 14px;
  max-width: 300px;
}
.tentang-rule-line     { flex: 1; height: 1px; background: linear-gradient(to right, transparent, var(--manila-dd)); }
.tentang-rule-line.rev { background: linear-gradient(to left,  transparent, var(--manila-dd)); }
.tentang-rule-dot      { width: 4px; height: 4px; border-radius: 50%; background: var(--rose-l); flex-shrink: 0; }
.tentang-subtitle {
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  line-height: 1.85;
  color: var(--muted);
  max-width: 500px;
  margin: 0 auto;
}

/* ════════════════════════
   4 FOTO GRID
════════════════════════ */
.tentang-photos {
  margin-bottom: 64px;
}
.tentang-photos-label {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 16px;
}
.tentang-photos-line     { flex: 1; height: 1px; background: linear-gradient(to right, var(--manila-dd), transparent); }
.tentang-photos-line.rev { background: linear-gradient(to left,  var(--manila-dd), transparent); }
.tentang-photos-text {
  font-family: 'Jost', sans-serif;
  font-size: 9.5px;
  font-weight: 500;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--muted);
}

/* Grid asimetris */
.tentang-photo-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr 1fr;
  grid-template-rows: 1fr 1fr;
  gap: 10px;
  height: 440px;
}
.tpg-1 { grid-column: 1; grid-row: 1 / 3; }
.tpg-2 { grid-column: 2; grid-row: 1; }
.tpg-3 { grid-column: 3; grid-row: 1; }
.tpg-4 { grid-column: 2 / 4; grid-row: 2; }

.tpg-cell {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
  box-shadow: 2px 4px 16px rgba(42,31,20,.12);
  transition: box-shadow .3s, transform .3s;
}
.tpg-cell:hover {
  box-shadow: 4px 10px 28px rgba(42,31,20,.18);
  transform: scale(1.012);
  z-index: 2;
}
.tpg-cell img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform .5s ease;
}
.tpg-cell:hover img { transform: scale(1.05); }

/* Overlay gradient */
.tpg-cell::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(42,31,20,.42) 0%, rgba(42,31,20,.08) 45%, transparent 100%);
  pointer-events: none;
}

/* Badge label pojok bawah */
.tpg-badge {
  position: absolute;
  bottom: 12px; left: 12px;
  z-index: 2;
  font-family: 'Jost', sans-serif;
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: rgba(251,246,238,.85);
  background: rgba(42,31,20,.55);
  backdrop-filter: blur(6px);
  border: 1px solid rgba(255,255,255,.1);
  padding: 4px 10px;
  border-radius: 100px;
  opacity: 0;
  transform: translateY(4px);
  transition: opacity .25s, transform .25s;
}
.tpg-cell:hover .tpg-badge { opacity: 1; transform: translateY(0); }

/* ════════════════════════
   5 KEUNGGULAN CARDS
════════════════════════ */
.tentang-cards-label {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 24px;
}
.tentang-cards-label-line     { flex: 1; height: 1px; background: linear-gradient(to right, var(--border), transparent); }
.tentang-cards-label-line.rev { background: linear-gradient(to left, var(--border), transparent); }
.tentang-cards-label-text {
  font-family: 'Jost', sans-serif;
  font-size: 9.5px;
  font-weight: 500;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--muted);
}

.tentang-cards {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 16px;
  margin-bottom: 60px;
}

/* Kartu keunggulan */
.tcard {
  background: var(--paper);
  border: 1px solid rgba(255,255,255,.75);
  border-radius: 10px;
  padding: 24px 18px 22px;
  box-shadow: 2px 4px 14px rgba(42,31,20,.09);
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  transition: transform .28s ease, box-shadow .28s ease;
}
.tcard:hover {
  transform: translateY(-5px);
  box-shadow: 4px 12px 28px rgba(42,31,20,.14);
}

/* Icon kotak */
.tcard-icon {
  width: 48px; height: 48px;
  background: var(--manila);
  border-radius: 12px;
  border: 1px solid var(--manila-dd);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 14px;
  transition: transform .3s ease;
}
.tcard:hover .tcard-icon { transform: rotate(-6deg) scale(1.08); }
.tcard-icon svg {
  width: 22px; height: 22px;
  stroke: var(--rose);
  fill: none;
  stroke-width: 1.6;
  stroke-linecap: round;
  stroke-linejoin: round;
}
/* Jika icon pakai img SVG */
.tcard-icon img {
  width: 22px; height: 22px;
  object-fit: contain;
}

/* Nomor kecil */
.tcard-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .14em;
  color: var(--muted);
  margin-bottom: 8px;
  opacity: .55;
}

/* Garis dekoratif */
.tcard-rule {
  width: 24px; height: 1px;
  background: var(--rose-l);
  margin: 0 auto 10px;
  transition: width .3s ease;
}
.tcard:hover .tcard-rule { width: 40px; }

.tcard-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.05rem;
  font-weight: 600;
  color: var(--ink);
  line-height: 1.3;
  margin-bottom: 8px;
  letter-spacing: -.01em;
}
.tcard-desc {
  font-family: 'Jost', sans-serif;
  font-size: 11.5px;
  line-height: 1.72;
  color: var(--muted);
  font-weight: 400;
}

/* ════════════════════════
   STATS BAR
════════════════════════ */
.tentang-stats-label {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 20px;
}
.tentang-stats-label-line     { flex: 1; height: 1px; background: linear-gradient(to right, var(--border), transparent); }
.tentang-stats-label-line.rev { background: linear-gradient(to left, var(--border), transparent); }
.tentang-stats-label-text {
  font-family: 'Jost', sans-serif;
  font-size: 9.5px;
  font-weight: 500;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--muted);
}

.tentang-stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 56px;
}

/* Stat tile */
.tstat {
  background: var(--ink);
  border-radius: 10px;
  padding: 28px 20px 24px;
  text-align: center;
  position: relative;
  overflow: hidden;
  transition: transform .28s ease, box-shadow .28s ease;
}
.tstat:hover {
  transform: translateY(-4px);
  box-shadow: 4px 12px 28px rgba(42,31,20,.25);
}

/* Dekorasi garis atas */
.tstat::before {
  content: '';
  position: absolute;
  top: 0; left: 20%; right: 20%;
  height: 2px;
  background: linear-gradient(to right, transparent, var(--rose-l), transparent);
}

.tstat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(26px, 3vw, 36px);
  font-weight: 600;
  color: var(--paper);
  line-height: 1;
  margin-bottom: 6px;
  letter-spacing: .01em;
}
.tstat-num sup {
  font-size: .42em;
  color: var(--rose-l);
  font-weight: 300;
  vertical-align: super;
}
.tstat-label {
  font-family: 'Jost', sans-serif;
  font-size: 9px;
  font-weight: 500;
  letter-spacing: .16em;
  text-transform: uppercase;
  color: rgba(251,246,238,.45);
  display: block;
}

/* Icon dekoratif di stat */
.tstat-icon {
  width: 28px; height: 28px;
  background: rgba(255,255,255,.06);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 12px;
}
.tstat-icon svg {
  width: 14px; height: 14px;
  stroke: var(--rose-l);
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}

/* ════════════════════════
   CTA BAWAH
════════════════════════ */
.tentang-cta {
  text-align: center;
  padding-top: 36px;
  border-top: 1px solid var(--border);
}
.tentang-cta-quote {
  font-family: 'Cormorant Garamond', serif;
  font-size: 17px;
  font-style: italic;
  font-weight: 300;
  color: var(--muted);
  margin-bottom: 22px;
}
.tentang-cta-btns {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
}
.tentang-btn-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--paper);
  background: var(--ink);
  padding: 12px 24px;
  border-radius: 100px;
  text-decoration: none;
  transition: background .2s, transform .2s;
}
.tentang-btn-primary:hover {
  background: var(--ink-l);
  transform: translateY(-2px);
  color: var(--paper);
  text-decoration: none;
}
.tentang-btn-secondary {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  font-weight: 500;
  letter-spacing: .04em;
  color: var(--ink-l);
  background: transparent;
  border: 1.5px solid var(--manila-dd);
  padding: 11px 20px;
  border-radius: 100px;
  text-decoration: none;
  transition: border-color .2s, color .2s, background .2s;
}
.tentang-btn-secondary:hover {
  border-color: rgba(192,123,96,.4);
  color: var(--rose);
  background: rgba(192,123,96,.05);
  text-decoration: none;
}

/* ════════════════════════
   RESPONSIVE
════════════════════════ */
@media (max-width: 1100px) {
  .tentang-cards { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1024px) {
  .tentang-photo-grid { height: 360px; }
  .tentang-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 767px) {
  .tentang-inner { padding: 48px 16px 56px; }
  .tentang-cards { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .tentang-photo-grid {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto;
    height: auto;
  }
  .tpg-1 { grid-column: 1; grid-row: 1; aspect-ratio: 1/1; }
  .tpg-2 { grid-column: 2; grid-row: 1; aspect-ratio: 1/1; }
  .tpg-3 { grid-column: 1; grid-row: 2; aspect-ratio: 1/1; }
  .tpg-4 { grid-column: 2; grid-row: 2; aspect-ratio: 1/1; }
}
@media (max-width: 480px) {
  .tentang-cards { grid-template-columns: 1fr 1fr; }
  .tentang-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
}
</style>

<!-- Wave atas: paper → manila -->
<div class="tentang-wave" style="background:var(--paper)">
  <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 48 C360 0 1080 48 1440 0 L1440 48 Z" fill="var(--manila)"/>
  </svg>
</div>

<section id="tentang">
<div class="tentang-inner">

  <!-- ════ HEADER ════ -->
  <header class="tentang-header">
    <div class="tentang-badge">
      <span class="tentang-badge-dot"></span>
      <span class="tentang-badge-text">Tentang Kami · Florist Jakarta Pusat</span>
    </div>
    <h2 class="tentang-title">Kenapa Memilih <em>Kami?</em></h2>
    <div class="tentang-rule">
      <div class="tentang-rule-line"></div>
      <div class="tentang-rule-dot"></div>
      <div class="tentang-rule-line rev"></div>
    </div>
    <p class="tentang-subtitle">
      Lebih dari satu dekade merangkai bunga segar untuk Jakarta Pusat —
      setiap karya dibuat dengan sepenuh hati untuk momen spesial Anda.
    </p>
  </header>

  <!-- ════ 4 FOTO GRID ════ -->
  <div class="tentang-photos">
    <div class="tentang-photos-label">
      <div class="tentang-photos-line"></div>
      <span class="tentang-photos-text">Kisah Bunga Kami</span>
      <div class="tentang-photos-line rev"></div>
    </div>

    <div class="tentang-photo-grid">

      <div class="tpg-cell tpg-1">
        <img src="<?= BASE_URL ?>/assets/images/h1.jpeg" alt="Bunga Segar" loading="lazy">
        <span class="tpg-badge">Bunga Segar</span>
      </div>

      <div class="tpg-cell tpg-2">
        <img src="<?= BASE_URL ?>/assets/images/h2.jpeg" alt="Hand Bouquet" loading="lazy">
        <span class="tpg-badge">Hand Bouquet</span>
      </div>

      <div class="tpg-cell tpg-3">
        <img src="<?= BASE_URL ?>/assets/images/h3.jpeg" alt="Bunga Papan" loading="lazy">
        <span class="tpg-badge">Bunga Papan</span>
      </div>

      <div class="tpg-cell tpg-4">
        <img src="<?= BASE_URL ?>/assets/images/h4.jpeg" alt="Standing Flower" loading="lazy">
        <span class="tpg-badge">Standing Flower</span>
      </div>

    </div>
  </div>

  <!-- ════ 5 KEUNGGULAN CARDS ════ -->
  <div class="tentang-cards-label">
    <div class="tentang-cards-label-line"></div>
    <span class="tentang-cards-label-text">Keunggulan Kami</span>
    <div class="tentang-cards-label-line rev"></div>
  </div>

  <?php
  $kk_items = [
    [
      'num'  => '01',
      'icon_svg' => 'M12 2C10 2 8 4 8 7c0 2 1 3.5 2.5 4.3V22h3V11.3C15 10.5 16 9 16 7c0-3-2-5-4-5z',
      'icon_img' => BASE_URL . '/assets/svg/cherry.svg',
      'title'=> 'Bunga 100% Segar Setiap Hari',
      'desc' => 'Dipilih dari pasar tiap pagi. Layu sebelum waktunya? Kami ganti tanpa syarat.',
    ],
    [
      'num'  => '02',
      'icon_svg' => 'M12 2l2 7h7l-5.5 4 2 7L12 16l-5.5 4 2-7L3 9h7z',
      'icon_img' => BASE_URL . '/assets/svg/brush-2.svg',
      'title'=> 'Desain Custom Gratis',
      'desc' => 'Tim florist siap merancang rangkaian sesuai keinginan dan budget Anda.',
    ],
    [
      'num'  => '03',
      'icon_svg' => 'M5 12h14M12 5l7 7-7 7',
      'icon_img' => BASE_URL . '/assets/svg/train.svg',
      'title'=> 'Pengiriman 2–4 Jam',
      'desc' => 'Armada siap antar ke 12 kecamatan Jakarta Pusat hari yang sama.',
    ],
    [
      'num'  => '04',
      'icon_svg' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z',
      'icon_img' => BASE_URL . '/assets/svg/torii.svg',
      'title'=> 'Layanan 24 Jam / 7 Hari',
      'desc' => 'Melayani pesanan kapan saja — malam hari dan hari libur pun siap.',
    ],
    [
      'num'  => '05',
      'icon_svg' => 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l8.84 8.84 8.84-8.84a5.5 5.5 0 0 0 0-7.78z',
      'icon_img' => BASE_URL . '/assets/svg/karasu.svg',
      'title'=> 'Rating 4.9 · 500+ Pelanggan',
      'desc' => 'Dipercaya selama lebih dari satu dekade dengan rekam jejak terbaik.',
    ],
  ];
  ?>

  <div class="tentang-cards">
    <?php foreach ($kk_items as $item): ?>
    <div class="tcard">

      <div class="tcard-icon">
        <?php
        /* Gunakan img jika file SVG tersedia, fallback ke inline SVG */
        $img_path = str_replace(BASE_URL, $_SERVER['DOCUMENT_ROOT'], $item['icon_img']);
        if (file_exists($img_path)):
        ?>
          <img src="<?= $item['icon_img'] ?>" alt="">
        <?php else: ?>
          <svg viewBox="0 0 24 24">
            <path d="<?= $item['icon_svg'] ?>"/>
          </svg>
        <?php endif; ?>
      </div>

      <div class="tcard-num"><?= $item['num'] ?></div>
      <div class="tcard-rule"></div>
      <div class="tcard-title"><?= $item['title'] ?></div>
      <p class="tcard-desc"><?= $item['desc'] ?></p>

    </div>
    <?php endforeach; ?>
  </div>

  <!-- ════ STATS ════ -->
  <div class="tentang-stats-label">
    <div class="tentang-stats-label-line"></div>
    <span class="tentang-stats-label-text">Pencapaian Nyata Kami</span>
    <div class="tentang-stats-label-line rev"></div>
  </div>

  <div class="tentang-stats">

    <div class="tstat">
      <div class="tstat-icon">
        <svg viewBox="0 0 24 24">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
      </div>
      <div class="tstat-num">500<sup>+</sup></div>
      <span class="tstat-label">Pelanggan Puas</span>
    </div>

    <div class="tstat">
      <div class="tstat-icon">
        <svg viewBox="0 0 24 24">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
      <div class="tstat-num">10<sup>+ Thn</sup></div>
      <span class="tstat-label">Tahun Pengalaman</span>
    </div>

    <div class="tstat">
      <div class="tstat-icon">
        <svg viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
      </div>
      <div class="tstat-num">2–4<sup>Jam</sup></div>
      <span class="tstat-label">Estimasi Pengiriman</span>
    </div>

    <div class="tstat">
      <div class="tstat-icon">
        <svg viewBox="0 0 24 24">
          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
          <circle cx="12" cy="9" r="2.5"/>
        </svg>
      </div>
      <div class="tstat-num">12</div>
      <span class="tstat-label">Kecamatan Terlayani</span>
    </div>

  </div>

  <!-- ════ CTA ════ -->
  <div class="tentang-cta">
    <p class="tentang-cta-quote">
      "Setiap momen spesial berhak mendapat bunga terbaik."
    </p>
    <div class="tentang-cta-btns">
      <?php $wa_msg = urlencode('Halo, saya ingin konsultasi tentang pesanan bunga.'); ?>
      <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_msg ?>"
         target="_blank" rel="noopener"
         class="tentang-btn-primary">
        <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Konsultasi Gratis
      </a>
      <a href="#produk" class="tentang-btn-secondary">
        Lihat Produk
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </div>

</div>
</section>

<!-- Wave bawah: manila → paper -->
<div class="tentang-wave" style="background:var(--manila)">
  <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 0 C360 48 1080 0 1440 48 L1440 0 Z" fill="var(--paper)"/>
  </svg>
</div>