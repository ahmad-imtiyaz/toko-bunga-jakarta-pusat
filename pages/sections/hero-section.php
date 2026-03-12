<?php
$wa_url = setting('whatsapp_number') ?? '6281234567890';
$wa_msg = urlencode(setting('whatsapp_default_message') ?? 'Halo, saya ingin memesan bunga');
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Jost:wght@300;400;500;600&display=swap');

:root {
  --manila:    #F2E8D5;
  --manila-d:  #E8D9BF;
  --manila-dd: #D6C4A0;
  --paper:     #FBF6EE;
  --ink:       #2A1F14;
  --ink-l:     #5C4A35;
  --rose:      #C07B60;
  --rose-l:    #DFA98C;
  --sage:      #6B8C6A;
  --muted:     #8A7560;
}

#hjp, #hjp *, #hjp *::before, #hjp *::after {
  box-sizing: border-box; margin: 0; padding: 0;
}
#hjp {
  font-family: 'Jost', sans-serif;
  background: var(--manila);
  position: relative;
  overflow: hidden;
}

/* ── GRAIN TEXTURE ── */
#hjp::before {
  content: '';
  position: fixed; inset: 0;
  pointer-events: none; z-index: 0; opacity: .04;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 220px 220px;
}

/* ════════════════════════════════
   TOPBAR
════════════════════════════════ */
.hjp-top {
  position: relative; z-index: 20;
  background: var(--ink);
  display: flex; align-items: center;
  justify-content: center;
  gap: 6px 20px;
  padding: 11px 24px;
  flex-wrap: wrap;
}
.hjp-top-item {
  display: flex; align-items: center; gap: 6px;
  font-size: 11px; font-weight: 400;
  color: rgba(251,246,238,.55);
  letter-spacing: .07em; white-space: nowrap;
}
.hjp-top-item b { color: rgba(251,246,238,.9); font-weight: 500; }
.hjp-top-sep { color: var(--rose-l); opacity: .4; font-size: 8px; }

/* ════════════════════════════════
   TICKER
════════════════════════════════ */
.hjp-ticker {
  position: relative; z-index: 20;
  background: var(--manila-d);
  border-bottom: 1px solid var(--manila-dd);
  padding: 7px 0; overflow: hidden;
}
@keyframes hjp-tick {
  from { transform: translateX(0); }
  to   { transform: translateX(-33.333%); }
}
.hjp-ticker-track {
  display: flex; width: max-content;
  animation: hjp-tick 42s linear infinite;
}
.hjp-ticker-item {
  display: inline-flex; align-items: center; gap: 10px;
  padding: 0 20px;
  font-size: 10px; font-weight: 500;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--muted); white-space: nowrap;
}
.hjp-ticker-item span { color: var(--rose); font-size: 7px; }

/* ════════════════════════════════
   HERO WRAPPER
════════════════════════════════ */
.hjp-hero {
  position: relative; z-index: 1;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 56px 40px 48px;
  min-height: calc(100svh - 80px);
  overflow: hidden;
}

/* Watermark */
.hjp-watermark {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(100px, 15vw, 200px);
  font-weight: 300; font-style: italic;
  color: var(--manila-dd); opacity: .3;
  white-space: nowrap; pointer-events: none;
  user-select: none; line-height: 1;
}

/* Ornamen garis */
.hjp-ornament-line {
  display: flex; align-items: center;
  gap: 14px; width: 100%; max-width: 700px;
  margin: 0 auto 28px;
}
.hjp-ornament-line::before,
.hjp-ornament-line::after {
  content: ''; flex: 1; height: 1px;
}
.hjp-ornament-line::before {
  background: linear-gradient(to right, transparent, var(--manila-dd));
}
.hjp-ornament-line::after {
  background: linear-gradient(to left, transparent, var(--manila-dd));
}
.hjp-ornament-center {
  font-family: 'Cormorant Garamond', serif;
  font-size: 11px; font-style: italic;
  color: var(--muted); letter-spacing: .16em;
  white-space: nowrap; opacity: .65;
}

/* ════════════════════════════════
   GRID UTAMA — Desktop: 3 kolom
════════════════════════════════ */
.hjp-main {
  display: grid;
  grid-template-columns: 1fr auto 1fr;
  gap: 36px;
  align-items: center;
  width: 100%;
  max-width: 1180px;
  margin: 0 auto;
}

/* ── KOLOM TENGAH ── */
.hjp-center {
  display: flex; flex-direction: column;
  align-items: center; text-align: center;
  min-width: 300px; max-width: 400px;
}

@keyframes hjp-up {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: translateY(0); }
}

.hjp-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--paper);
  border: 1px solid var(--manila-dd);
  border-radius: 100px;
  padding: 5px 14px 5px 9px;
  margin-bottom: 20px;
  animation: hjp-up .45s .05s both;
}
.hjp-badge-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: var(--sage); flex-shrink: 0;
}
.hjp-badge-text {
  font-size: 10px; font-weight: 500;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--ink-l);
}

.hjp-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.4rem, 3.6vw, 3.8rem);
  font-weight: 600; line-height: 1.08;
  color: var(--ink); margin-bottom: 6px;
  letter-spacing: -.01em;
  animation: hjp-up .45s .1s both;
}
.hjp-headline em {
  display: block; font-style: italic;
  font-weight: 300; color: var(--rose);
}

.hjp-sub-italic {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; font-size: 14px;
  color: var(--sage); margin-bottom: 18px;
  letter-spacing: .04em;
  animation: hjp-up .45s .15s both;
}

.hjp-rule {
  display: flex; align-items: center;
  gap: 10px; margin-bottom: 16px;
  width: 100%; justify-content: center;
  animation: hjp-up .45s .18s both;
}
.hjp-rule-line { width: 36px; height: 1px; background: var(--manila-dd); }
.hjp-rule-dot  { width: 4px; height: 4px; border-radius: 50%; background: var(--rose-l); }

.hjp-desc {
  font-size: 13.5px; line-height: 1.8;
  color: var(--muted); font-weight: 400;
  margin-bottom: 24px;
  animation: hjp-up .45s .22s both;
}

/* ── TOMBOL CTA ── */
.hjp-ctas {
  display: flex; flex-direction: column;
  align-items: center;        /* center, bukan stretch */
  width: 100%;
  gap: 10px; margin-bottom: 0;
  animation: hjp-up .45s .3s both;
}

.hjp-btn-wa {
  display: inline-flex; align-items: center;
  justify-content: center; gap: 9px;
  width: auto;                /* tidak full width */
  min-width: 220px;           /* lebar minimum */
  background: var(--ink); color: var(--paper);
  font-family: 'Jost', sans-serif;
  font-size: 14px; font-weight: 500;
  padding: 13px 32px;         /* tinggi + lega kiri-kanan */
  text-decoration: none; border-radius: 6px;
  letter-spacing: .04em;
  transition: background .2s, transform .2s;
}
.hjp-btn-wa:hover {
  background: var(--ink-l);
  transform: translateY(-2px);
  color: var(--paper); text-decoration: none;
}
.hjp-btn-wa svg { width: 17px; height: 17px; fill: var(--paper); flex-shrink: 0; }

.hjp-btn-outline {
  display: inline-flex; align-items: center;
  justify-content: center;
  width: auto;                /* tidak full width */
  min-width: 220px;
  border: 1.5px solid var(--manila-dd);
  color: var(--ink-l);
  font-family: 'Jost', sans-serif;
  font-size: 13.5px; font-weight: 500;
  padding: 11px 32px;
  text-decoration: none; border-radius: 6px;
  transition: border-color .2s, color .2s, transform .2s;
}
.hjp-btn-outline:hover {
  border-color: var(--rose); color: var(--rose);
  transform: translateY(-2px); text-decoration: none;
}
/* ── KOLOM FOTO ── */
.hjp-photos-left {
  display: flex; flex-direction: column;
  align-items: flex-end; gap: 14px;
}
.hjp-photos-right {
  display: flex; flex-direction: column;
  align-items: flex-start; gap: 14px;
}

.hjp-photo {
  position: relative; overflow: hidden;
  border-radius: 12px;
  background: var(--manila-d);
  box-shadow: 3px 5px 18px rgba(42,31,20,.13);
  border: 1px solid rgba(255,255,255,.55);
  transition: transform .3s ease, box-shadow .3s ease;
}
.hjp-photo img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform .4s ease;
}
.hjp-photo:hover { box-shadow: 6px 14px 32px rgba(42,31,20,.18); }
.hjp-photo:hover img { transform: scale(1.04); }
.hjp-photo::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(to bottom,
    transparent 50%, rgba(42,31,20,.2) 100%);
  pointer-events: none;
}

.hjp-photo-tag {
  position: absolute; bottom: 10px; left: 10px;
  background: rgba(251,246,238,.92);
  backdrop-filter: blur(4px);
  padding: 3px 10px; border-radius: 100px;
  font-size: 9px; font-weight: 600;
  color: var(--ink); letter-spacing: .06em;
  z-index: 2;
}

/* Ukuran foto — desktop */
.hjp-photo.kiri-1  { width: 238px; height: 296px; transform: rotate(-1.8deg); }
.hjp-photo.kiri-1:hover { transform: rotate(-1.8deg) translateY(-5px); }
.hjp-photo.kiri-2  { width: 188px; height: 218px; transform: rotate(.8deg); align-self: flex-end; }
.hjp-photo.kiri-2:hover { transform: rotate(.8deg) translateY(-5px); }
.hjp-photo.kanan-1 { width: 193px; height: 208px; transform: rotate(-1deg); }
.hjp-photo.kanan-1:hover { transform: rotate(-1deg) translateY(-5px); }
.hjp-photo.kanan-2 { width: 242px; height: 292px; transform: rotate(1.5deg); }
.hjp-photo.kanan-2:hover { transform: rotate(1.5deg) translateY(-5px); }

/* Ornamen bawah */
.hjp-ornament-line.bottom { margin-top: 28px; margin-bottom: 0; }

/* ════════════════════════════════
   STRIP KEUNGGULAN
════════════════════════════════ */
.hjp-strip {
  position: relative; z-index: 1;
  background: var(--paper);
  border-top: 1px solid var(--manila-dd);
  padding: 52px 40px 56px;
  display: flex; flex-direction: column;
  align-items: center;
}
.hjp-strip-heading {
  text-align: center; margin-bottom: 36px; width: 100%;
}
.hjp-strip-heading-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 26px; font-weight: 600;
  color: var(--ink); margin-bottom: 5px;
}
.hjp-strip-heading-sub {
  font-size: 12px; color: var(--muted);
  font-style: italic; letter-spacing: .06em;
}
.hjp-strip-grid {
  display: grid;
  grid-template-columns: repeat(4, 210px);
  gap: 18px; justify-content: center;
}
.hjp-strip-item {
  background: var(--manila);
  border: 1px solid var(--manila-dd);
  border-radius: 18px; padding: 28px 18px 24px;
  display: flex; flex-direction: column;
  align-items: center; text-align: center;
  transition: background .2s, box-shadow .3s, transform .3s;
}
.hjp-strip-item:hover {
  background: #fff;
  box-shadow: 0 14px 36px rgba(42,31,20,.09);
  transform: translateY(-5px);
}
.hjp-strip-icon {
  width: 56px; height: 56px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  background: var(--paper); border: 1.5px solid var(--manila-dd);
  border-radius: 50%; margin-bottom: 16px;
  transition: transform .2s;
}
.hjp-strip-item:hover .hjp-strip-icon { transform: translateY(-3px) scale(1.07); }
.hjp-strip-icon img { width: 26px; height: 26px; display: block; }
.hjp-strip-title {
  font-size: 13px; font-weight: 600;
  color: var(--ink); margin-bottom: 7px; line-height: 1.35;
}
.hjp-strip-sub {
  font-size: 11.5px; color: var(--muted);
  font-weight: 400; line-height: 1.65;
}

/* ════════════════════════════════
   RESPONSIVE — TABLET (≤1024px)
════════════════════════════════ */
@media (max-width: 1024px) {
  .hjp-hero { padding: 36px 24px 32px; min-height: auto; }
  .hjp-watermark { display: none; }
  .hjp-ornament-line { display: none; }

  /* Grid jadi 1 kolom, urutan: foto atas → teks → foto bawah */
  .hjp-main {
    grid-template-columns: 1fr;
    gap: 24px;
  }
  .hjp-photos-left  { order: 1; flex-direction: row; justify-content: center; gap: 12px; }
  .hjp-center       { order: 2; max-width: 100%; min-width: 0; }
  .hjp-photos-right { order: 3; flex-direction: row; justify-content: center; gap: 12px; }

  /* Foto — lebih kecil, tanpa rotate */
  .hjp-photo.kiri-1, .hjp-photo.kiri-2,
  .hjp-photo.kanan-1, .hjp-photo.kanan-2 {
    width: calc(50% - 6px); max-width: 200px;
    height: 180px;
    transform: none !important; align-self: auto;
  }
  .hjp-photo.kiri-1:hover, .hjp-photo.kiri-2:hover,
  .hjp-photo.kanan-1:hover, .hjp-photo.kanan-2:hover {
    transform: translateY(-4px) !important;
  }

  .hjp-strip { padding: 36px 24px 40px; }
  .hjp-strip-grid {
    grid-template-columns: repeat(2, 1fr);
    width: 100%; max-width: 480px;
  }
}

/* ════════════════════════════════
   RESPONSIVE — MOBILE (≤640px)
════════════════════════════════ */
@media (max-width: 640px) {
  /* Hero */
  .hjp-hero { padding: 28px 16px 24px; }

  /* Grid tetap 1 kolom, foto tetap tampil */
  .hjp-main { gap: 20px; }

  /* Foto atas (kiri-1 & kiri-2) */
  .hjp-photos-left { gap: 10px; }
  .hjp-photo.kiri-1,
  .hjp-photo.kiri-2 {
    width: calc(50% - 5px);
    height: 150px;
    max-width: none;
  }

  /* Foto bawah (kanan-1 & kanan-2) */
  .hjp-photos-right { gap: 10px; }
  .hjp-photo.kanan-1,
  .hjp-photo.kanan-2 {
    width: calc(50% - 5px);
    height: 150px;
    max-width: none;
  }

  /* Teks */
  .hjp-center { padding: 0; }
  .hjp-headline { font-size: 2rem; }
  .hjp-desc { font-size: 13px; }
  .hjp-badge-text { font-size: 9.5px; }

  /* Tombol — ukuran wajar */
  .hjp-btn-wa {
    font-size: 14px;
    padding: 13px 18px;
  }
  .hjp-btn-outline {
    font-size: 13px;
    padding: 11px 18px;
  }

  /* Topbar — lebih compact */
  .hjp-top {
    gap: 4px 12px;
    padding: 9px 16px;
  }
  .hjp-top-item { font-size: 10.5px; }
  /* Sembunyikan item ke-4 (Est. 2014) di mobile */
  .hjp-top-item:nth-of-type(4),
  .hjp-top-sep:nth-of-type(3) { display: none; }

  /* Strip */
  .hjp-strip { padding: 28px 16px 32px; }
  .hjp-strip-heading-title { font-size: 22px; }
  .hjp-strip-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 10px; max-width: 100%;
  }
  .hjp-strip-item { padding: 20px 12px 18px; border-radius: 14px; }
  .hjp-strip-icon { width: 48px; height: 48px; margin-bottom: 12px; }
  .hjp-strip-icon img { width: 22px; height: 22px; }
  .hjp-strip-title { font-size: 12.5px; }
  .hjp-strip-sub { font-size: 11px; }
}

/* ════════════════════════════════
   RESPONSIVE — SMALL (≤380px)
════════════════════════════════ */
@media (max-width: 380px) {
  .hjp-hero { padding: 20px 14px 20px; }
  .hjp-headline { font-size: 1.8rem; }
  .hjp-photo.kiri-1, .hjp-photo.kiri-2,
  .hjp-photo.kanan-1, .hjp-photo.kanan-2 {
    height: 130px;
  }
  .hjp-btn-wa, .hjp-btn-outline { font-size: 13px; padding: 12px 14px; }
}
</style>

<!-- ══════════════ HERO ══════════════ -->
<div id="hjp">
  <div class="hjp-hero">

    <div class="hjp-watermark" aria-hidden="true">Bunga</div>

    <div class="hjp-ornament-line">
      <span class="hjp-ornament-center">Toko Bunga Jakarta Pusat · Rangkaian Segar Pilihan</span>
    </div>

    <div class="hjp-main">

      <!-- FOTO KIRI -->
      <div class="hjp-photos-left">
        <div class="hjp-photo kiri-1">
          <img src="<?= BASE_URL ?>/assets/images/h1.jpeg" alt="Hand Bouquet Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Hand Bouquet</div>
        </div>
        <div class="hjp-photo kiri-2">
          <img src="<?= BASE_URL ?>/assets/images/h2.jpeg" alt="Bunga Papan Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Bunga Papan</div>
        </div>
      </div>

      <!-- TEKS TENGAH -->
      <div class="hjp-center">

        <div class="hjp-badge">
          <span class="hjp-badge-dot"></span>
          <span class="hjp-badge-text">Florist Terpercaya · Jakarta Pusat</span>
        </div>

        <h1 class="hjp-headline">
          <?= e(setting('hero_title')) ?>
          <em>dari Tangan ke Hati</em>
        </h1>

        <p class="hjp-sub-italic">Rangkaian segar, langsung untuk momen spesialmu</p>

        <div class="hjp-rule">
          <span class="hjp-rule-line"></span>
          <span class="hjp-rule-dot"></span>
          <span class="hjp-rule-line"></span>
        </div>

        <p class="hjp-desc">
          <?= e(setting('hero_subtitle')) ?>
          Kami hadir untuk mewarnai setiap momenmu dengan bunga pilihan, segar dan artistik.
        </p>

        <div class="hjp-ctas">
          <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_msg ?>" target="_blank" class="hjp-btn-wa">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
            Pesan via WhatsApp
          </a>
          <a href="#produk" class="hjp-btn-outline">Lihat Koleksi Bunga ↓</a>
        </div>

      </div>

      <!-- FOTO KANAN -->
      <div class="hjp-photos-right">
        <div class="hjp-photo kanan-1">
          <img src="<?= BASE_URL ?>/assets/images/h3.jpeg" alt="Wedding Flower Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Wedding</div>
        </div>
        <div class="hjp-photo kanan-2">
          <img src="<?= BASE_URL ?>/assets/images/h4.jpeg" alt="Buket Wisuda Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Buket Wisuda</div>
        </div>
      </div>

    </div>

    <div class="hjp-ornament-line bottom" style="margin-top:28px;">
      <span class="hjp-ornament-center">Pengiriman ke seluruh Jakarta Pusat · Pesan sekarang via WhatsApp</span>
    </div>

  </div><!-- /hjp-hero -->

  <!-- TOPBAR -->
  <div class="hjp-top">
    <span class="hjp-top-item"><b>Jakarta Pusat</b></span>
    <span class="hjp-top-sep">✦</span>
    <span class="hjp-top-item">Buka <b>24 Jam</b></span>
    <span class="hjp-top-sep">✦</span>
    <span class="hjp-top-item">Antar <b>2–4 Jam</b></span>
    <span class="hjp-top-sep">✦</span>
    <span class="hjp-top-item">Florist Jakarta Pusat <b>Est. 2014</b></span>
  </div>

  <!-- TICKER -->
  <div class="hjp-ticker" aria-hidden="true">
    <div class="hjp-ticker-track">
      <?php
      $tickers = ['Hand Bouquet','Bunga Papan','Wedding Decoration',
                  'Duka Cita','Buket Wisuda','Pengiriman 2–4 Jam',
                  'Custom Design','Mulai Rp 300.000','Bunga Segar Setiap Hari'];
      for ($i = 0; $i < 3; $i++):
        foreach ($tickers as $t): ?>
        <span class="hjp-ticker-item"><span>✦</span><?= $t ?></span>
      <?php endforeach; endfor; ?>
    </div>
  </div>

  <!-- STRIP KEUNGGULAN -->
  <div class="hjp-strip">
    <div class="hjp-strip-heading">
      <div class="hjp-strip-heading-title">Mengapa Memilih Kami?</div>
      <div class="hjp-strip-heading-sub">Kepercayaan pelanggan adalah prioritas utama kami</div>
    </div>
    <div class="hjp-strip-grid">
      <div class="hjp-strip-item">
        <div class="hjp-strip-icon">
          <img src="<?= BASE_URL ?>/assets/svg/flower.svg" alt="Flower Icon">
        </div>
        <div class="hjp-strip-title">Kualitas Terjamin</div>
        <div class="hjp-strip-sub">Bunga segar dipilih setiap pagi langsung dari kebun terbaik</div>
      </div>
      <div class="hjp-strip-item">
        <div class="hjp-strip-icon">
          <img src="<?= BASE_URL ?>/assets/svg/delivery.svg" alt="Delivery Icon">
        </div>
        <div class="hjp-strip-title">Pengiriman Cepat</div>
        <div class="hjp-strip-sub">2–4 jam tiba, melayani 12 kecamatan di Jakarta Pusat</div>
      </div>
      <div class="hjp-strip-item">
        <div class="hjp-strip-icon">
          <img src="<?= BASE_URL ?>/assets/svg/brush-2.svg" alt="Brush Icon">
        </div>
        <div class="hjp-strip-title">Desain Custom</div>
        <div class="hjp-strip-sub">Rangkaian sesuai tema, warna, dan keinginan Anda</div>
      </div>
      <div class="hjp-strip-item">
        <div class="hjp-strip-icon">
          <img src="<?= BASE_URL ?>/assets/svg/envelope.svg" alt="Envelope Icon">
        </div>
        <div class="hjp-strip-title">Konsultasi Gratis</div>
        <div class="hjp-strip-sub">Tim kami siap membantu 24 jam via WhatsApp</div>
      </div>
    </div>
  </div>

</div><!-- /hjp -->