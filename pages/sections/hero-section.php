<?php
/* ============================================================
   HERO — Toko Bunga Jakarta Pusat
   Tema: Kertas Manila · Collage Asimetris · Center Layout
============================================================ */
$wa_url = setting('whatsapp_number') ?? '6281234567890';
$wa_msg = urlencode(setting('whatsapp_default_message') ?? 'Halo, saya ingin memesan bunga');
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Jost:wght@300;400;500;600&display=swap');

/* ─── TOKENS ─── */
:root {
  --manila:     #F2E8D5;
  --manila-d:   #E8D9BF;
  --manila-dd:  #D6C4A0;
  --paper:      #FBF6EE;
  --ink:        #2A1F14;
  --ink-l:      #5C4A35;
  --rose:       #C07B60;
  --rose-l:     #DFA98C;
  --sage:       #6B8C6A;
  --sage-l:     #9AB89A;
  --muted:      #8A7560;
  --border:     rgba(90,70,45,.13);
}

/* ─── RESET ─── */
#hjp, #hjp *, #hjp *::before, #hjp *::after {
  box-sizing: border-box; margin: 0; padding: 0;
}
#hjp {
  font-family: 'Jost', sans-serif;
  background: var(--manila);
  position: relative;
  overflow: hidden;
}

/* ─── GRAIN PAPER TEXTURE ─── */
#hjp::before {
  content: '';
  position: fixed;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  opacity: .045;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 220px 220px;
}

/* ─── TOPBAR ─── */
.hjp-top {
  position: relative; z-index: 20;
  background: var(--ink);
  display: flex; align-items: center; justify-content: center;
  gap: 32px;
  padding: 10px 40px;
}
.hjp-top-item {
  font-size: 10.5px; font-weight: 400;
  color: rgba(251,246,238,.55);
  letter-spacing: .1em;
  display: flex; align-items: center; gap: 7px;
}
.hjp-top-item b { color: rgba(251,246,238,.88); font-weight: 500; }
.hjp-top-sep { color: var(--rose-l); opacity: .4; font-size: 8px; }

/* ─── TICKER ─── */
.hjp-ticker { 
  position: relative; z-index: 20;
  background: var(--manila-d);
  border-bottom: 1px solid var(--manila-dd);
  padding: 8px 0; overflow: hidden;
}
@keyframes hjp-tick { from{transform:translateX(0)} to{transform:translateX(-33.333%)} }
.hjp-ticker-track {
  display: flex; width: max-content;
  animation: hjp-tick 42s linear infinite;
}
.hjp-ticker-item {
  display: inline-flex; align-items: center; gap: 12px;
  padding: 0 22px;
  font-size: 10px; font-weight: 500;
  letter-spacing: .16em; text-transform: uppercase;
  color: var(--muted); white-space: nowrap;
}
.hjp-ticker-item span { color: var(--rose); font-size: 7px; }

/* ═══════════════════════════════════════
   HERO WRAPPER — center everything
═══════════════════════════════════════ */
.hjp-hero {
  position: relative; z-index: 1;
  min-height: calc(100svh - 80px);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 60px 40px 20px;
  overflow: hidden;
}

/* ─── WATERMARK TEKS BESAR (dekoratif) ─── */
.hjp-watermark {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(120px, 16vw, 220px);
  font-weight: 300;
  font-style: italic;
  color: var(--manila-dd);
  opacity: .35;
  white-space: nowrap;
  pointer-events: none;
  user-select: none;
  letter-spacing: -.02em;
  line-height: 1;
}

/* ─── GARIS ORNAMEN HORIZONTAL ─── */
.hjp-ornament-line {
  display: flex; align-items: center;
  gap: 14px; width: 100%; max-width: 720px;
  margin: 0 auto 28px;
}
.hjp-ornament-line::before,
.hjp-ornament-line::after {
  content: '';
  flex: 1; height: 1px;
  background: linear-gradient(to right, transparent, var(--manila-dd));
}
.hjp-ornament-line::after {
  background: linear-gradient(to left, transparent, var(--manila-dd));
}
.hjp-ornament-center {
  font-family: 'Cormorant Garamond', serif;
  font-size: 11px; font-style: italic;
  color: var(--muted); letter-spacing: .18em;
  white-space: nowrap; opacity: .7;
}

/* ═══════════════════════════════════════
   KONTEN UTAMA — 3 kolom: foto kiri | teks | foto kanan
═══════════════════════════════════════ */
.hjp-main {
  display: grid;
  grid-template-columns: 1fr auto 1fr;
  gap: 36px;
  align-items: center;
  width: 100%;
  max-width: 1180px;
  margin: 0 auto;
}

/* ════ KOLOM TENGAH — TEKS ════ */
.hjp-center {
  display: flex; flex-direction: column;
  align-items: center; text-align: center;
  min-width: 320px; max-width: 400px;
  gap: 0;
}

@keyframes hjp-up {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}

.hjp-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--paper);
  border: 1px solid var(--manila-dd);
  border-radius: 100px;
  padding: 6px 16px 6px 10px;
  margin-bottom: 22px;
  animation: hjp-up .5s .05s both;
}
.hjp-badge-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: var(--sage); flex-shrink: 0;
}
.hjp-badge-text {
  font-size: 10.5px; font-weight: 500;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--ink-l);
}

.hjp-headline {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.6rem, 3.8vw, 4rem);
  font-weight: 600; line-height: 1.08;
  color: var(--ink); margin-bottom: 6px;
  animation: hjp-up .5s .12s both;
  letter-spacing: -.01em;
}
.hjp-headline em {
  display: block; font-style: italic; font-weight: 300;
  color: var(--rose); font-size: 1.05em;
}

.hjp-sub-italic {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; font-size: 14px;
  color: var(--sage); margin-bottom: 20px;
  animation: hjp-up .5s .17s both;
  letter-spacing: .04em;
}

/* garis tengah dekoratif */
.hjp-rule {
  display: flex; align-items: center; gap: 10px;
  margin-bottom: 18px;
  animation: hjp-up .5s .2s both;
  width: 100%;
  justify-content: center;
}
.hjp-rule-line { width: 40px; height: 1px; background: var(--manila-dd); }
.hjp-rule-dot  { width: 4px; height: 4px; border-radius: 50%; background: var(--rose-l); }

.hjp-desc {
  font-size: 13.5px; line-height: 1.82;
  color: var(--muted); font-weight: 400;
  margin-bottom: 26px;
  animation: hjp-up .5s .24s both;
}

/* Chips */
.hjp-chips {
  display: flex; flex-wrap: wrap; gap: 6px;
  justify-content: center; margin-bottom: 28px;
  animation: hjp-up .5s .29s both;
}
.hjp-chip {
  font-size: 10.5px; font-weight: 500;
  color: var(--sage); letter-spacing: .04em;
  border: 1px solid rgba(107,140,106,.3);
  background: rgba(107,140,106,.07);
  padding: 5px 13px; border-radius: 100px;
}

/* CTA */
.hjp-ctas {
  display: flex; flex-direction: column;
  align-items: center; gap: 10px; width: 100%;
  margin-bottom: 32px;
  animation: hjp-up .5s .34s both;
}
.hjp-btn-wa {
  display: inline-flex; align-items: center;
  justify-content: center;
  gap: 9px; width: 100%;
  background: var(--ink);
  color: var(--paper);
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 600;
  letter-spacing: .04em;
  padding: 14px 28px; border-radius: 100px;
  text-decoration: none;
  transition: background .2s, transform .2s;
}
.hjp-btn-wa:hover {
  background: var(--ink-l);
  transform: translateY(-2px);
  text-decoration: none; color: var(--paper);
}
.hjp-btn-wa svg { width:14px; height:14px; fill:var(--paper); flex-shrink:0; }

.hjp-btn-outline {
  display: inline-flex; align-items: center;
  justify-content: center; gap: 8px;
  width: 100%;
  border: 1.5px solid var(--manila-dd);
  color: var(--ink-l);
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 500;
  padding: 13px 24px; border-radius: 100px;
  text-decoration: none;
  transition: border-color .2s, color .2s, transform .2s;
}
.hjp-btn-outline:hover {
  border-color: var(--rose); color: var(--rose);
  transform: translateY(-2px); text-decoration: none;
}

/* Stats */
.hjp-stats {
  display: flex; align-items: stretch;
  width: 100%;
  background: var(--paper);
  border: 1px solid var(--manila-dd);
  border-radius: 14px; overflow: hidden;
  animation: hjp-up .5s .4s both;
}
.hjp-stat {
  flex: 1; display: flex; flex-direction: column;
  align-items: center; text-align: center;
  padding: 14px 10px;
  position: relative;
}
.hjp-stat + .hjp-stat::before {
  content: ''; position: absolute;
  left: 0; top: 20%; bottom: 20%;
  width: 1px; background: var(--manila-dd);
}
.hjp-stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px; font-weight: 600;
  color: var(--ink); line-height: 1; margin-bottom: 3px;
}
.hjp-stat-num sup { font-size: 11px; color: var(--rose); vertical-align: super; }
.hjp-stat-lbl {
  font-size: 9px; font-weight: 600;
  letter-spacing: .12em; text-transform: uppercase;
  color: var(--muted);
}

/* ════ KOLOM FOTO KIRI ════ */
.hjp-photos-left {
  display: flex; flex-direction: column;
  align-items: flex-end; gap: 14px;
}

/* ════ KOLOM FOTO KANAN ════ */
.hjp-photos-right {
  display: flex; flex-direction: column;
  align-items: flex-start; gap: 14px;
}

/* ─── FOTO CARD ─── */
.hjp-photo {
  position: relative; overflow: hidden;
  border-radius: 12px;
  background: var(--manila-d);
  /* Shadow kertas */
  box-shadow: 3px 5px 18px rgba(42,31,20,.14),
              0 1px 3px rgba(42,31,20,.08);
  /* Efek kertas — border tipis */
  border: 1px solid rgba(255,255,255,.6);
  transition: transform .35s ease, box-shadow .35s ease;
}
.hjp-photo:hover {
  transform: translateY(-5px) rotate(0deg);
  box-shadow: 6px 14px 32px rgba(42,31,20,.18);
}
.hjp-photo img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform .45s ease;
}
.hjp-photo:hover img { transform: scale(1.04); }

/* Overlay tipis */
.hjp-photo::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(to bottom,
    rgba(42,31,20,.02) 0%, rgba(42,31,20,.22) 100%);
  pointer-events: none;
}

/* Tag label bawah */
.hjp-photo-tag {
  position: absolute; bottom: 10px; left: 10px;
  background: rgba(251,246,238,.9);
  backdrop-filter: blur(4px);
  padding: 4px 11px; border-radius: 100px;
  font-size: 9.5px; font-weight: 600;
  color: var(--ink); letter-spacing: .06em;
  z-index: 2; pointer-events: none;
}

/* Placeholder angka saat foto belum ada */
.hjp-photo-ph {
  position: absolute; inset: 0;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  gap: 4px; pointer-events: none;
}
.hjp-photo-ph-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 56px; font-weight: 300;
  color: var(--manila-dd); line-height: 1;
}
.hjp-photo-ph-txt {
  font-size: 9px; font-weight: 600;
  letter-spacing: .2em; text-transform: uppercase;
  color: var(--muted); opacity: .6;
}

/* Ukuran foto — asimetris */
/* Kiri: foto 1 besar atas, foto 2 kecil bawah */
.hjp-photo.kiri-1 { width: 240px; height: 300px; transform: rotate(-1.8deg); }
.hjp-photo.kiri-1:hover { transform: rotate(-1.8deg) translateY(-5px); }
.hjp-photo.kiri-2 { width: 190px; height: 220px; transform: rotate(.8deg); align-self: flex-end; }
.hjp-photo.kiri-2:hover { transform: rotate(.8deg) translateY(-5px); }

/* Kanan: foto 3 kecil atas, foto 4 besar bawah */
.hjp-photo.kanan-1 { width: 195px; height: 210px; transform: rotate(-1deg); }
.hjp-photo.kanan-1:hover { transform: rotate(-1deg) translateY(-5px); }
.hjp-photo.kanan-2 { width: 245px; height: 295px; transform: rotate(1.5deg); }
.hjp-photo.kanan-2:hover { transform: rotate(1.5deg) translateY(-5px); }

/* ─── ORNAMEN BAWAH ─── */
.hjp-bottom {
  position: relative; z-index: 1;
  width: 100%; padding: 0 40px 10px;
}
.hjp-ornament-line.bottom { margin-bottom: 0; }

/* ═══════════════════════════════════════
   STRIP KEUNGGULAN
═══════════════════════════════════════ */
.hjp-strip {
  position: relative; z-index: 1;
  background: var(--paper);
  border-top: 1px solid var(--manila-dd);
}
.hjp-strip-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  max-width: 100%;
}
.hjp-strip-item {
  padding: 26px 28px 24px;
  border-right: 1px solid var(--manila-dd);
  transition: background .2s;
}
.hjp-strip-item:last-child { border-right: none; }
.hjp-strip-item:hover { background: rgba(90,70,45,.025); }

/* Slot icon */
.hjp-strip-icon {
  width: 48px;
  height: 48px;
  margin-bottom: 14px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #f7f4ef;
  border-radius: 12px;
}

.hjp-strip-item:hover .hjp-strip-icon{
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.hjp-strip-icon img{
  width: 24px;
  height: 24px;
  display:block;
}
.hjp-strip-title {
  font-size: 13.5px; font-weight: 600;
  color: var(--ink); margin-bottom: 5px;
  letter-spacing: -.01em;
}
.hjp-strip-sub {
  font-size: 12px; color: var(--muted);
  font-weight: 400; line-height: 1.6;
}

/* icon */
.feature-icon{
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f7f4ef;
  border-radius: 12px;
  transition: all .3s ease;
}

.feature-icon img{
  width: 28px;
  height: 28px;
}

.feature-icon:hover{
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media (max-width: 1024px) {
  .hjp-main {
    grid-template-columns: 1fr;
    gap: 0;
  }
  .hjp-photos-left, .hjp-photos-right {
    flex-direction: row;
    justify-content: center;
    align-items: center;
  }
  .hjp-photo.kiri-1, .hjp-photo.kiri-2,
  .hjp-photo.kanan-1, .hjp-photo.kanan-2 {
    width: 44vw; max-width: 210px;
    height: 52vw; max-height: 250px;
    transform: none !important;
  }
  .hjp-photo.kiri-1:hover, .hjp-photo.kiri-2:hover,
  .hjp-photo.kanan-1:hover, .hjp-photo.kanan-2:hover {
    transform: translateY(-4px) !important;
  }
  .hjp-photos-left  { order: 1; padding: 0 20px; margin-bottom: 8px; }
  .hjp-center       { order: 2; max-width: 100%; padding: 32px 20px 8px; }
  .hjp-photos-right { order: 3; padding: 8px 20px 0; margin-bottom: 8px; }
  .hjp-hero { padding: 40px 0 16px; }
  .hjp-watermark { display: none; }
  .hjp-strip-grid { grid-template-columns: 1fr 1fr; }
  .hjp-strip-item:nth-child(2) { border-right: none; }
  .hjp-strip-item:nth-child(3),
  .hjp-strip-item:nth-child(4) { border-top: 1px solid var(--manila-dd); }
}

@media (max-width: 600px) {
  .hjp-hero { padding: 28px 0 12px; }
  .hjp-photo.kiri-1, .hjp-photo.kiri-2,
  .hjp-photo.kanan-1, .hjp-photo.kanan-2 {
    width: 42vw; height: 50vw;
    max-width: 180px; max-height: 215px;
  }
  .hjp-headline { font-size: 2.2rem; }
  .hjp-center { padding: 24px 16px 8px; }
  .hjp-top { gap: 14px; padding: 9px 16px; }
  .hjp-top-item:last-child { display: none; }
  .hjp-strip-grid { grid-template-columns: 1fr; }
  .hjp-strip-item { border-right: none; border-top: 1px solid var(--manila-dd); }
  .hjp-strip-item:first-child { border-top: none; }
}
</style>
<!-- ══════════════ HERO ══════════════ -->
<div id="hjp">
  <div class="hjp-hero">

    <!-- Watermark dekoratif -->
    <div class="hjp-watermark" aria-hidden="true">Bunga</div>

    <!-- Garis ornamen atas -->
    <div class="hjp-ornament-line">
      <span class="hjp-ornament-center">Toko Bunga Jakarta Pusat · Rangkaian Segar Pilihan</span>
    </div>

    <!-- ═══ GRID UTAMA ═══ -->
    <div class="hjp-main">

      <!-- FOTO KIRI: besar atas, kecil bawah -->
      <div class="hjp-photos-left">
        <div class="hjp-photo kiri-1">
          <img src="<?= BASE_URL ?>/assets/images/h1.jpeg" alt="Hand Bouquet Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Hand Bouquet</div>
          <div class="hjp-photo-ph">
            <span class="hjp-photo-ph-num">1</span>
            <span class="hjp-photo-ph-txt">Foto Utama</span>
          </div>
        </div>
        <div class="hjp-photo kiri-2">
          <img src="<?= BASE_URL ?>/assets/images/h2.jpeg" alt="Bunga Papan Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Bunga Papan</div>
          <div class="hjp-photo-ph">
            <span class="hjp-photo-ph-num">2</span>
            <span class="hjp-photo-ph-txt">Foto 2</span>
          </div>
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

        <div class="hjp-chips">
          <span class="hjp-chip">Antar 2–4 Jam</span>
          <span class="hjp-chip">Bunga Segar</span>
          <span class="hjp-chip">Custom Design</span>
          <span class="hjp-chip">Buka 24 Jam</span>
        </div>

        <div class="hjp-ctas">
          <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_msg ?>" target="_blank" class="hjp-btn-wa">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
            Pesan via WhatsApp
          </a>
          <a href="#produk" class="hjp-btn-outline">Lihat Koleksi Bunga ↓</a>
        </div>

        <div class="hjp-stats">
          <div class="hjp-stat">
            <div class="hjp-stat-num" style="font-size:15px;color:var(--rose);">Rp 300rb</div>
            <div class="hjp-stat-lbl">Mulai Dari</div>
          </div>
          <div class="hjp-stat">
            <div class="hjp-stat-num">500<sup>+</sup></div>
            <div class="hjp-stat-lbl">Pelanggan</div>
          </div>
          <div class="hjp-stat">
            <div class="hjp-stat-num">24<sup>H</sup></div>
            <div class="hjp-stat-lbl">Siap Antar</div>
          </div>
          <div class="hjp-stat">
            <div class="hjp-stat-num">12</div>
            <div class="hjp-stat-lbl">Kecamatan</div>
          </div>
        </div>

      </div><!-- /hjp-center -->

      <!-- FOTO KANAN: kecil atas, besar bawah -->
      <div class="hjp-photos-right">
        <div class="hjp-photo kanan-1">
          <img src="<?= BASE_URL ?>/assets/images/h3.jpeg" alt="Wedding Flower Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Wedding</div>
          <div class="hjp-photo-ph">
            <span class="hjp-photo-ph-num">3</span>
            <span class="hjp-photo-ph-txt">Foto 3</span>
          </div>
        </div>
        <div class="hjp-photo kanan-2">
          <img src="<?= BASE_URL ?>/assets/images/h4.jpeg" alt="Buket Wisuda Jakarta Pusat" loading="eager">
          <div class="hjp-photo-tag">Buket Wisuda</div>
          <div class="hjp-photo-ph">
            <span class="hjp-photo-ph-num">4</span>
            <span class="hjp-photo-ph-txt">Foto 4</span>
          </div>
        </div>
      </div>

    </div><!-- /hjp-main -->

    <!-- Garis ornamen bawah -->
    <div class="hjp-ornament-line bottom" style="margin-top:32px;">
      <span class="hjp-ornament-center">Pengiriman ke seluruh Jakarta Pusat · Pesan sekarang via WhatsApp</span>
    </div>

  </div><!-- /hjp-hero -->

  
<!-- ── TOPBAR ── -->
<div class="hjp-top">
  <span class="hjp-top-item"><b>Jakarta Pusat</b></span>
  <span class="hjp-top-sep">✦</span>
  <span class="hjp-top-item">Buka <b>24 Jam</b></span>
  <span class="hjp-top-sep">✦</span>
  <span class="hjp-top-item">Antar <b>2–4 Jam</b></span>
  <span class="hjp-top-sep">✦</span>
  <span class="hjp-top-item">Florist Jakarta Pusat <b>Est. 2014</b></span>
</div>

<!-- ── TICKER ── -->
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

<!-- ══ STRIP KEUNGGULAN ══ -->
<div class="hjp-strip">
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
        <img src="<?= BASE_URL ?>/assets/svg/flower.svg" alt="Flower Icon">
      </div>
      <div class="hjp-strip-title">Pengiriman Cepat</div>
      <div class="hjp-strip-sub">2–4 jam tiba, melayani 12 kecamatan di Jakarta Pusat</div>
    </div>

    <div class="hjp-strip-item">
      <div class="hjp-strip-icon">
        <img src="<?= BASE_URL ?>/assets/svg/flower.svg" alt="Flower Icon">
      </div>
      <div class="hjp-strip-title">Desain Custom</div>
      <div class="hjp-strip-sub">Rangkaian sesuai tema, warna, dan keinginan Anda</div>
    </div>

    <div class="hjp-strip-item">
      <div class="hjp-strip-icon">
        <img src="<?= BASE_URL ?>/assets/svg/flower.svg" alt="Flower Icon">
      </div>
      <div class="hjp-strip-title">Konsultasi Gratis</div>
      <div class="hjp-strip-sub">Tim kami siap membantu 24 jam via WhatsApp</div>
    </div>

  </div>
</div>

</div><!-- /hjp -->