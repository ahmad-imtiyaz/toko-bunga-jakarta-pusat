<?php
/* ================================================================
   CTA SECTION — Bunga Kertas · Warm Manila
   Tema: Kertas cream hangat, elegan, ringan, on-brand
================================================================ */
?>

<style>
/* ─── CTA SECTION ─── */
#cta-section {
  background: var(--ink, #2A1F14);
  position: relative;
  overflow: hidden;
  padding: 0;
}

/* Grain texture — static */
#cta-section::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.65' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
}

/* Warm radial glow — kiri bawah + kanan atas */
#cta-section::after {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 70% 60% at 0% 100%,   rgba(192,123,96,.18) 0%, transparent 65%),
    radial-gradient(ellipse 55% 50% at 100% 0%,    rgba(192,123,96,.12) 0%, transparent 60%),
    radial-gradient(ellipse 40% 40% at 50% 50%,    rgba(223,169,140,.06) 0%, transparent 70%);
  pointer-events: none;
  z-index: 0;
}

/* ─── INNER WRAPPER ─── */
.cta-inner {
  position: relative;
  z-index: 1;
  max-width: 900px;
  margin: 0 auto;
  padding: 100px 24px 72px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

/* ─── ORNAMEN DEKORATIF ATAS ─── */
.cta-ornament {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 36px;
}
.cta-ornament-line {
  flex: 1;
  max-width: 80px;
  height: 1px;
  background: linear-gradient(to right, transparent, rgba(223,169,140,.4));
}
.cta-ornament-line:last-child {
  background: linear-gradient(to left, transparent, rgba(223,169,140,.4));
}
.cta-ornament-center {
  display: flex;
  align-items: center;
  gap: 8px;
}
.cta-ornament-dot {
  width: 5px; height: 5px;
  border-radius: 50%;
  background: var(--rose-l, #DFA98C);
  opacity: .5;
}
.cta-ornament-diamond {
  width: 8px; height: 8px;
  background: var(--rose, #C07B60);
  transform: rotate(45deg);
  opacity: .7;
}

/* ─── EYEBROW ─── */
.cta-eyebrow {
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .25em;
  text-transform: uppercase;
  color: var(--rose-l, #DFA98C);
  margin-bottom: 20px;
  opacity: .8;
}

/* ─── JUDUL ─── */
.cta-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(38px, 6vw, 76px);
  font-weight: 300;
  color: var(--paper, #FBF6EE);
  line-height: 1.1;
  letter-spacing: -.01em;
  margin: 0 0 6px;
}
.cta-title strong {
  font-weight: 600;
  display: block;
}
.cta-title em {
  font-style: italic;
  font-weight: 300;
  color: var(--rose-l, #DFA98C);
}

/* Brush stroke SVG bawah judul */
.cta-brush {
  display: block;
  margin: 14px auto 0;
  opacity: .35;
}

/* ─── SUBTITLE ─── */
.cta-subtitle {
  font-family: 'Jost', sans-serif;
  font-size: clamp(13px, 1.6vw, 15px);
  color: rgba(251,246,238,.4);
  line-height: 1.9;
  max-width: 520px;
  margin: 24px 0 44px;
  letter-spacing: .02em;
}
.cta-subtitle em {
  font-style: normal;
  color: var(--rose-l, #DFA98C);
  opacity: 1;
}

/* ─── TOMBOL ─── */
.cta-btns {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
  justify-content: center;
  margin-bottom: 56px;
}

/* Tombol utama — warm rose pill */
.cta-btn-main {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: var(--paper, #FBF6EE);
  color: var(--ink, #2A1F14);
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  font-weight: 700;
  padding: 16px 34px;
  border-radius: 100px;
  text-decoration: none;
  transition: background .25s, transform .25s, box-shadow .25s;
  letter-spacing: .03em;
  box-shadow: 0 4px 20px rgba(0,0,0,.25);
}
.cta-btn-main:hover {
  background: #fff;
  transform: translateY(-2px);
  box-shadow: 0 10px 32px rgba(0,0,0,.3);
  color: var(--ink, #2A1F14);
  text-decoration: none;
}
.cta-btn-main svg { flex-shrink: 0; }

/* Tombol sekunder — outline cream */
.cta-btn-sec {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: transparent;
  color: rgba(251,246,238,.55);
  font-family: 'Jost', sans-serif;
  font-size: 13.5px;
  font-weight: 500;
  padding: 15px 28px;
  border-radius: 100px;
  border: 1px solid rgba(251,246,238,.15);
  text-decoration: none;
  transition: border-color .25s, color .25s, background .25s, transform .25s;
  letter-spacing: .03em;
}
.cta-btn-sec:hover {
  border-color: rgba(223,169,140,.5);
  color: var(--rose-l, #DFA98C);
  background: rgba(223,169,140,.06);
  transform: translateY(-1px);
  text-decoration: none;
}

/* ─── STATS STRIP ─── */
.cta-stats {
  display: flex;
  gap: 0;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 52px;
  border: 1px solid rgba(251,246,238,.07);
  border-radius: 12px;
  overflow: hidden;
  width: 100%;
  max-width: 680px;
}

.cta-stat {
  flex: 1;
  min-width: 130px;
  padding: 20px 16px;
  border-right: 1px solid rgba(251,246,238,.07);
  transition: background .2s;
}
.cta-stat:last-child { border-right: none; }
.cta-stat:hover { background: rgba(251,246,238,.04); }

.cta-stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 30px;
  font-weight: 600;
  color: var(--paper, #FBF6EE);
  line-height: 1;
  letter-spacing: -.01em;
}
.cta-stat-num sup {
  font-size: 14px;
  color: var(--rose-l, #DFA98C);
  vertical-align: super;
}
.cta-stat-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: rgba(251,246,238,.28);
  margin-top: 5px;
}

/* ─── DIVIDER ─── */
.cta-divider {
  width: 100%;
  max-width: 480px;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(223,169,140,.2), transparent);
  margin: 0 auto 36px;
}

/* ─── TRUST PILLS ─── */
.cta-trust {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  justify-content: center;
  margin-bottom: 60px;
}

.cta-trust-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 11.5px;
  font-weight: 500;
  color: rgba(251,246,238,.35);
  letter-spacing: .04em;
}
.cta-trust-pill::before {
  content: '';
  width: 4px; height: 4px;
  border-radius: 50%;
  background: var(--rose, #C07B60);
  opacity: .5;
  flex-shrink: 0;
}
.cta-trust-sep {
  width: 1px; height: 14px;
  background: rgba(251,246,238,.1);
}

/* ─── FOOTER MINI ─── */
.cta-footer {
  width: 100%;
  border-top: 1px solid rgba(251,246,238,.07);
  padding-top: 28px;
}

.cta-footer-brand {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 600;
  color: rgba(251,246,238,.5);
  letter-spacing: .08em;
  margin-bottom: 6px;
}
.cta-footer-brand span {
  font-style: italic;
  font-weight: 300;
  color: var(--rose-l, #DFA98C);
  opacity: .6;
}

.cta-footer-links {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
  margin: 14px 0;
}
.cta-footer-links a {
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  font-weight: 400;
  color: rgba(251,246,238,.25);
  letter-spacing: .1em;
  text-decoration: none;
  text-transform: uppercase;
  transition: color .2s;
}
.cta-footer-links a:hover { color: var(--rose-l, #DFA98C); }

.cta-footer-copy {
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  color: rgba(251,246,238,.18);
  letter-spacing: .08em;
  margin-top: 6px;
}

/* ─── KERTAS TERBANG — CSS only, ringan ─── */
.cta-petal {
  position: absolute;
  pointer-events: none;
  z-index: 0;
  opacity: 0;
  animation: ctaPetalDrift linear infinite;
}

@keyframes ctaPetalDrift {
  0%   { transform: translateY(-20px) rotate(0deg) translateX(0);   opacity: 0; }
  8%   { opacity: .45; }
  88%  { opacity: .3; }
  100% { transform: translateY(110vh) rotate(540deg) translateX(40px); opacity: 0; }
}

/* ─── RESPONSIVE ─── */
@media (max-width: 600px) {
  .cta-inner { padding: 80px 16px 60px; }
  .cta-btns  { flex-direction: column; align-items: stretch; width: 100%; max-width: 300px; }
  .cta-btn-main, .cta-btn-sec { justify-content: center; }
  .cta-stats { max-width: 100%; }
  .cta-stat  { min-width: 110px; }
  .cta-trust { gap: 8px; }
  .cta-trust-sep { display: none; }
}
</style>

<section id="cta-section" role="region" aria-label="Pesan Bunga Sekarang">

  <!-- Kelopak kertas CSS-only -->
  <?php
  $petalColors = [
    '#C07B60','#DFA98C','#D6C4A0','#FBF6EE','#E8D9BF','#C07B60'
  ];
  for ($p = 0; $p < 12; $p++):
    $clr  = $petalColors[$p % count($petalColors)];
    $left = rand(0,95);
    $dur  = rand(14,22);
    $delay = rand(0, $dur);
    $size = rand(5,11);
  ?>
  <div class="cta-petal" aria-hidden="true" style="
    left: <?= $left ?>%;
    top: 0;
    width: <?= $size ?>px;
    height: <?= $size ?>px;
    background: <?= $clr ?>;
    border-radius: 80% 20% 80% 20% / 60% 60% 40% 40%;
    opacity: .3;
    animation-duration: <?= $dur ?>s;
    animation-delay: -<?= $delay ?>s;
  "></div>
  <?php endfor; ?>

  <div class="cta-inner">

    <!-- Ornamen atas -->
    <div class="cta-ornament" aria-hidden="true">
      <div class="cta-ornament-line"></div>
      <div class="cta-ornament-center">
        <div class="cta-ornament-dot"></div>
        <div class="cta-ornament-diamond"></div>
        <div class="cta-ornament-dot"></div>
      </div>
      <div class="cta-ornament-line"></div>
    </div>

    <div class="cta-eyebrow">Florist Jakarta Pusat · Est. 2014</div>

    <h2 class="cta-title">
      Kirimkan
      <strong><em>Kebahagiaan</em></strong>
      Bersama Bunga
    </h2>

    <svg class="cta-brush" width="260" height="14" viewBox="0 0 260 14" fill="none">
      <path d="M8,10 Q35,3 70,8 Q108,13 140,7 Q172,2 208,9 Q228,12 252,8"
            stroke="#C07B60" stroke-width="2.5" stroke-linecap="round" fill="none"/>
      <path d="M20,11 Q60,5 100,9 Q140,13 180,7 Q214,4 248,10"
            stroke="#DFA98C" stroke-width="1" stroke-linecap="round" fill="none" opacity=".4"/>
    </svg>

    <p class="cta-subtitle">
      Setiap rangkaian kami dibuat dengan tangan, dipilih dari bunga segar terbaik setiap pagi.<br>
      Untuk <em>momen pernikahan, ulang tahun, wisuda</em> — kami siap hadir.
    </p>

    <div class="cta-btns">
      <?php
        $wa_msg_cta = urlencode('Halo! Saya ingin memesan bunga dari toko Anda.');
      ?>
      <a href="<?= isset($wa_url) ? 'https://wa.me/' . $wa_url . '?text=' . $wa_msg_cta : '#' ?>"
         target="_blank" rel="noopener noreferrer"
         class="cta-btn-main">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Pesan via WhatsApp
      </a>

      <a href="#produk" class="cta-btn-sec">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M4 6h16M4 10h16M4 14h10"/>
        </svg>
        Lihat Katalog
      </a>
    </div>

    <!-- Stats -->
    <div class="cta-stats" role="list">
      <div class="cta-stat" role="listitem">
        <div class="cta-stat-num">500<sup>+</sup></div>
        <div class="cta-stat-lbl">Pelanggan Puas</div>
      </div>
      <div class="cta-stat" role="listitem">
        <div class="cta-stat-num">4.9<sup>★</sup></div>
        <div class="cta-stat-lbl">Rating Google</div>
      </div>
      <div class="cta-stat" role="listitem">
        <div class="cta-stat-num">5<sup>th</sup></div>
        <div class="cta-stat-lbl">Berpengalaman</div>
      </div>
      <div class="cta-stat" role="listitem">
        <div class="cta-stat-num">2–4<sup>jam</sup></div>
        <div class="cta-stat-lbl">Pengiriman</div>
      </div>
    </div>

    <div class="cta-divider" aria-hidden="true"></div>

    <!-- Trust pills -->
    <div class="cta-trust">
      <span class="cta-trust-pill">Buka 24 Jam</span>
      <div class="cta-trust-sep" aria-hidden="true"></div>
      <span class="cta-trust-pill">100% Bunga Segar</span>
      <div class="cta-trust-sep" aria-hidden="true"></div>
      <span class="cta-trust-pill">Kirim Se-Jakarta Pusat</span>
      <div class="cta-trust-sep" aria-hidden="true"></div>
      <span class="cta-trust-pill">Garansi Kepuasan</span>
    </div>

    <!-- Footer mini -->
    <footer class="cta-footer">
      <div class="cta-footer-brand">
        <?= htmlspecialchars(setting('site_name') ?? 'Toko Bunga Jakarta', ENT_QUOTES) ?>
        <span> · Florist</span>
      </div>
      <nav class="cta-footer-links" aria-label="Footer navigasi">
        <a href="#layanan">Layanan</a>
        <a href="#produk">Produk</a>
        <a href="#tentang">Tentang</a>
        <a href="#area">Area</a>
        <a href="#testimoni">Testimoni</a>
        <a href="#faq">FAQ</a>
      </nav>
      <p class="cta-footer-copy">
        &copy; <?= date('Y') ?> <?= htmlspecialchars(setting('site_name') ?? 'Toko Bunga Jakarta', ENT_QUOTES) ?>. Semua Hak Dilindungi. &middot; Jakarta Pusat
      </p>
    </footer>

  </div>
</section>