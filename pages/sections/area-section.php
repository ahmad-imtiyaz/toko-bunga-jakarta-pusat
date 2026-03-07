<?php
/* ============================================================
   AREA SECTION — Manila Florist · Kertas Cream Warm
   Konten: grid lokasi kecamatan + 3 stats + CTA WA
============================================================ */
?>

<style>
/* ══════════════════════════════════════════
   AREA SECTION — Manila Florist
══════════════════════════════════════════ */
#area {
  position: relative;
  background: var(--manila);
  overflow: hidden;
}

/* Grain texture — static */
#area::before {
  content: '';
  position: absolute;
  inset: 0; z-index: 0;
  pointer-events: none;
  opacity: .03;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 200px 200px;
}

/* Wave divider */
.area-wave     { line-height: 0; }
.area-wave svg { width: 100%; display: block; }

/* Inner */
.area-inner {
  position: relative;
  z-index: 1;
  max-width: 1280px;
  margin: 0 auto;
  padding: 72px 32px 80px;
}

/* ════════════════════════
   HEADER
════════════════════════ */
.area-header {
  text-align: center;
  margin-bottom: 48px;
}
.area-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--paper);
  border: 1px solid var(--manila-dd);
  border-radius: 100px;
  padding: 6px 16px 6px 10px;
  margin-bottom: 20px;
}
.area-badge-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--rose);
  flex-shrink: 0;
}
.area-badge-text {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px;
  font-weight: 500;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--ink-l);
}
.area-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.8vw, 3.2rem);
  font-weight: 600;
  color: var(--ink);
  line-height: 1.1;
  letter-spacing: -.01em;
}
.area-title em {
  font-style: italic;
  font-weight: 300;
  color: var(--rose);
}
.area-rule {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin: 18px auto 14px;
  max-width: 300px;
}
.area-rule-line     { flex: 1; height: 1px; background: linear-gradient(to right, transparent, var(--manila-dd)); }
.area-rule-line.rev { background: linear-gradient(to left, transparent, var(--manila-dd)); }
.area-rule-dot      { width: 4px; height: 4px; border-radius: 50%; background: var(--rose-l); flex-shrink: 0; }
.area-subtitle {
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  line-height: 1.8;
  color: var(--muted);
  max-width: 460px;
  margin: 0 auto;
}

/* ════════════════════════
   PETA WRAPPER — border dekoratif seperti kertas terlipat
════════════════════════ */
.area-map-wrap {
  background: var(--paper);
  border: 1px solid var(--manila-dd);
  border-radius: 12px;
  box-shadow:
    0 2px 0 var(--manila-dd),
    4px 8px 28px rgba(42,31,20,.1);
  overflow: hidden;
  margin-bottom: 40px;
}

/* Strip atas peta — seperti header kertas */
.area-map-header {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px 24px;
  background: var(--manila);
  border-bottom: 1px solid var(--manila-dd);
}
.area-map-header-icon {
  width: 32px; height: 32px;
  background: var(--paper);
  border-radius: 8px;
  border: 1px solid var(--manila-dd);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.area-map-header-icon svg {
  width: 16px; height: 16px;
  stroke: var(--rose);
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}
.area-map-header-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1rem;
  font-weight: 600;
  color: var(--ink);
  letter-spacing: .01em;
}
.area-map-header-sub {
  font-family: 'Jost', sans-serif;
  font-size: 9.5px;
  font-weight: 500;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--muted);
  margin-left: auto;
}

/* Grid kecamatan */
.area-loc-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1px;
  background: var(--border); /* gap jadi garis antar cell */
}

/* Card kecamatan */
.area-loc-card {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 20px 18px;
  background: var(--paper);
  text-decoration: none;
  transition: background .2s;
  overflow: hidden;
}
.area-loc-card:hover {
  background: var(--manila);
  text-decoration: none;
}

/* Garis aksen atas saat hover */
.area-loc-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(to right, transparent, var(--rose-l), transparent);
  opacity: 0;
  transition: opacity .2s;
}
.area-loc-card:hover::before { opacity: 1; }

/* Nomor urut */
.alc-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .14em;
  color: var(--muted);
  opacity: .5;
}

/* Header: pin + nama */
.alc-head {
  display: flex;
  align-items: flex-start;
  gap: 10px;
}
.alc-pin {
  width: 30px; height: 30px;
  background: var(--manila);
  border-radius: 8px;
  border: 1px solid var(--manila-dd);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: background .2s, border-color .2s, transform .25s;
}
.area-loc-card:hover .alc-pin {
  background: var(--rose);
  border-color: var(--rose);
  transform: scale(1.1) rotate(-5deg);
}
.alc-pin svg {
  width: 14px; height: 14px;
  stroke: var(--ink-l);
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
  transition: stroke .2s;
}
.area-loc-card:hover .alc-pin svg { stroke: white; }

.alc-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1rem;
  font-weight: 600;
  color: var(--ink);
  line-height: 1.25;
  letter-spacing: -.01em;
  transition: color .2s;
}
.area-loc-card:hover .alc-name { color: var(--rose); }

/* Deskripsi / alamat */
.alc-desc {
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  line-height: 1.7;
  color: var(--muted);

  display: -webkit-box;
  -webkit-box-orient: vertical;

  -webkit-line-clamp: 2; /* WebKit browsers */
  line-clamp: 2;         /* Standard property */

  overflow: hidden;
}
/* Badge kirim */
.alc-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: rgba(107,140,106,.07);
  border: 1px solid rgba(107,140,106,.22);
  padding: 3px 9px;
  border-radius: 100px;
  font-family: 'Jost', sans-serif;
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .06em;
  color: var(--sage);
  width: fit-content;
}
.alc-badge-dot {
  width: 4px; height: 4px;
  border-radius: 50%;
  background: var(--sage);
  flex-shrink: 0;
}

/* CTA link kecil */
.alc-cta {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-family: 'Jost', sans-serif;
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--muted);
  transition: gap .22s, color .2s;
}
.area-loc-card:hover .alc-cta {
  gap: 9px;
  color: var(--rose);
}
.alc-cta svg { transition: transform .22s; }
.area-loc-card:hover .alc-cta svg { transform: translateX(3px); }

/* ════════════════════════
   STATS BAR
════════════════════════ */
.area-stats-label {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 18px;
}
.area-stats-label-line     { flex: 1; height: 1px; background: linear-gradient(to right, var(--border), transparent); }
.area-stats-label-line.rev { background: linear-gradient(to left, var(--border), transparent); }
.area-stats-label-text {
  font-family: 'Jost', sans-serif;
  font-size: 9.5px;
  font-weight: 500;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--muted);
}

.area-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  max-width: 780px;
  margin: 0 auto 52px;
}
.area-stat {
  background: var(--ink);
  border-radius: 10px;
  padding: 26px 20px 22px;
  text-align: center;
  position: relative;
  overflow: hidden;
  transition: transform .28s ease, box-shadow .28s ease;
}
.area-stat:hover {
  transform: translateY(-4px);
  box-shadow: 4px 12px 28px rgba(42,31,20,.22);
}
.area-stat::before {
  content: '';
  position: absolute;
  top: 0; left: 20%; right: 20%;
  height: 2px;
  background: linear-gradient(to right, transparent, var(--rose-l), transparent);
}
.area-stat-icon {
  width: 26px; height: 26px;
  background: rgba(255,255,255,.06);
  border-radius: 7px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 10px;
}
.area-stat-icon svg {
  width: 13px; height: 13px;
  stroke: var(--rose-l);
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}
.area-stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(24px, 2.8vw, 34px);
  font-weight: 600;
  color: var(--paper);
  line-height: 1;
  margin-bottom: 5px;
}
.area-stat-num sup {
  font-size: .42em;
  color: var(--rose-l);
  font-weight: 300;
  vertical-align: super;
}
.area-stat-label {
  font-family: 'Jost', sans-serif;
  font-size: 9px;
  font-weight: 500;
  letter-spacing: .15em;
  text-transform: uppercase;
  color: rgba(251,246,238,.42);
}

/* ════════════════════════
   CTA BAWAH
════════════════════════ */
.area-cta {
  text-align: center;
  padding-top: 36px;
  border-top: 1px solid var(--border);
}
.area-cta-text {
  font-family: 'Cormorant Garamond', serif;
  font-size: 17px;
  font-style: italic;
  font-weight: 300;
  color: var(--muted);
  margin-bottom: 22px;
}
.area-cta-btns {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  flex-wrap: wrap;
}
.area-btn-primary {
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
.area-btn-primary:hover {
  background: var(--ink-l);
  transform: translateY(-2px);
  color: var(--paper);
  text-decoration: none;
}
.area-btn-secondary {
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
.area-btn-secondary:hover {
  border-color: rgba(192,123,96,.4);
  color: var(--rose);
  background: rgba(192,123,96,.05);
  text-decoration: none;
}

/* ════════════════════════
   RESPONSIVE
════════════════════════ */
@media (max-width: 1100px) {
  .area-loc-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 767px) {
  .area-inner         { padding: 48px 16px 56px; }
  .area-loc-grid      { grid-template-columns: repeat(2, 1fr); }
  .area-stats         { grid-template-columns: repeat(3, 1fr); }
  .area-map-header-sub { display: none; }
}
@media (max-width: 480px) {
  .area-loc-grid  { grid-template-columns: 1fr 1fr; }
  .alc-desc       { display: none; }
  .area-stats     { max-width: 100%; gap: 10px; }
}
</style>

<!-- Wave atas: paper → manila -->
<div class="area-wave" style="background:var(--paper)">
  <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 48 C360 0 1080 48 1440 0 L1440 48 Z" fill="var(--manila)"/>
  </svg>
</div>

<section id="area">
<div class="area-inner">

  <!-- ════ HEADER ════ -->
  <header class="area-header">
    <div class="area-badge">
      <span class="area-badge-dot"></span>
      <span class="area-badge-text">Area Pengiriman · Jakarta Pusat</span>
    </div>
    <h2 class="area-title">Kami Hadir di <em>Seluruh Jakarta Pusat</em></h2>
    <div class="area-rule">
      <div class="area-rule-line"></div>
      <div class="area-rule-dot"></div>
      <div class="area-rule-line rev"></div>
    </div>
    <p class="area-subtitle">
      Pengiriman bunga segar ke seluruh wilayah Jakarta Pusat —
      cepat, aman, dan tepat waktu untuk setiap momen spesial Anda.
    </p>
  </header>

  <!-- ════ PETA LOKASI ════ -->
  <div class="area-map-wrap">

    <!-- Header peta -->
    <div class="area-map-header">
      <div class="area-map-header-icon">
        <svg viewBox="0 0 24 24">
          <path d="M12 2C8.686 2 6 4.686 6 8c0 5.25 6 13 6 13s6-7.75 6-13c0-3.314-2.686-6-6-6z"/>
          <circle cx="12" cy="8" r="2.5"/>
        </svg>
      </div>
      <span class="area-map-header-title">Wilayah Layanan Jakarta Pusat</span>
      <span class="area-map-header-sub"><?= count($locations) ?> Kecamatan Terlayani</span>
    </div>

    <!-- Grid kecamatan -->
    <div class="area-loc-grid">
      <?php foreach ($locations as $idx => $loc):
        $num     = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
        $wa_text = urlencode('Halo, saya ingin pesan bunga dengan pengiriman ke ' . $loc['name'] . '. Apakah bisa?');
      ?>
      <a href="<?= BASE_URL ?>/<?= e($loc['slug']) ?>/"
         class="area-loc-card">

        <div class="alc-num"><?= $num ?></div>

        <div class="alc-head">
          <div class="alc-pin">
            <svg viewBox="0 0 24 24">
              <path d="M12 2C8.686 2 6 4.686 6 8c0 5.25 6 13 6 13s6-7.75 6-13c0-3.314-2.686-6-6-6z"/>
              <circle cx="12" cy="8" r="2.5" stroke-width="1.6"/>
            </svg>
          </div>
          <div class="alc-name"><?= e($loc['name']) ?></div>
        </div>

        <?php if (!empty($loc['address'])): ?>
        <p class="alc-desc"><?= e(mb_substr(strip_tags($loc['address']), 0, 72)) ?></p>
        <?php else: ?>
        <p class="alc-desc">Layanan pengiriman bunga segar tersedia di seluruh area ini.</p>
        <?php endif; ?>

        <div class="alc-badge">
          <span class="alc-badge-dot"></span>
          Kirim 2–4 Jam
        </div>

        <div class="alc-cta">
          Lihat Layanan
          <svg width="10" height="10" fill="none" stroke="currentColor"
               stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </div>

      </a>
      <?php endforeach; ?>
    </div>

  </div><!-- /area-map-wrap -->

  <!-- ════ STATS ════ -->
  <div class="area-stats-label">
    <div class="area-stats-label-line"></div>
    <span class="area-stats-label-text">Statistik Pengiriman</span>
    <div class="area-stats-label-line rev"></div>
  </div>

  <div class="area-stats">

    <div class="area-stat">
      <div class="area-stat-icon">
        <svg viewBox="0 0 24 24">
          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
          <circle cx="12" cy="9" r="2.5"/>
        </svg>
      </div>
      <div class="area-stat-num"><?= count($locations) ?><sup>+</sup></div>
      <div class="area-stat-label">Wilayah Terlayani</div>
    </div>

    <div class="area-stat">
      <div class="area-stat-icon">
        <svg viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
      </div>
      <div class="area-stat-num">2–4<sup>Jam</sup></div>
      <div class="area-stat-label">Estimasi Pengiriman</div>
    </div>

    <div class="area-stat">
      <div class="area-stat-icon">
        <svg viewBox="0 0 24 24">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
      </div>
      <div class="area-stat-num">24<sup>/7</sup></div>
      <div class="area-stat-label">Siap Melayani</div>
    </div>

  </div>

  <!-- ════ CTA ════ -->
  <div class="area-cta">
    <p class="area-cta-text">
      Tidak menemukan area Anda? Kami tetap bisa membantu.
    </p>
    <div class="area-cta-btns">
      <?php $wa_msg = urlencode('Halo, apakah ada layanan pengiriman ke area saya?'); ?>
      <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_msg ?>"
         target="_blank" rel="noopener"
         class="area-btn-primary">
        <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Tanya via WhatsApp
      </a>
      <a href="#produk" class="area-btn-secondary">
        Lihat Produk
        <svg width="12" height="12" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </a>
    </div>
  </div>

</div>
</section>

<!-- Wave bawah: manila → paper -->
<div class="area-wave" style="background:var(--manila)">
  <svg viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 0 C360 48 1080 0 1440 48 L1440 0 Z" fill="var(--paper)"/>
  </svg>
</div>