<?php
/* ================================================================
   TESTIMONI SECTION — Bunga Kertas Warm Manila
   Tema: Kertas cream hangat, kartu testimoni clean, carousel ringan
================================================================ */

if (!isset($testimonials) || empty($testimonials)) {
  $testimonials = [
    ['name'=>'Sari Dewi',      'rating'=>5, 'message'=>'Bunga-bunganya segar sekali dan pengirimannya tepat waktu. Sangat puas!', 'created_at'=>'2024-03-15'],
    ['name'=>'Budi Santoso',   'rating'=>5, 'message'=>'Rangkaian buket pernikahan kami luar biasa indah. Semua tamu memuji tanpa henti.', 'created_at'=>'2024-03-10'],
    ['name'=>'Rini Maharani',  'rating'=>5, 'message'=>'Pelayanan ramah dan hasilnya melebihi ekspektasi. Sangat direkomendasikan!', 'created_at'=>'2024-03-08'],
    ['name'=>'Dian Puspita',   'rating'=>5, 'message'=>'Sudah 3x pesan, selalu konsisten bagus. Toko bunga terpercaya di Jakarta!', 'created_at'=>'2024-02-28'],
    ['name'=>'Andi Kurniawan', 'rating'=>5, 'message'=>'Harga terjangkau tapi kualitas premium. Bunga tahan lama sampai seminggu!', 'created_at'=>'2024-02-20'],
    ['name'=>'Mega Lestari',   'rating'=>5, 'message'=>'Packaging cantik banget, cocok buat hadiah. Penerima langsung senang!', 'created_at'=>'2024-02-15'],
  ];
}
?>

<style>
/* ─── TESTIMONI SECTION ─── */
#testimoni {
  background: var(--paper, #FBF6EE);
  position: relative;
  overflow: hidden;
  padding: 96px 0 80px;
}

/* Grain texture ringan — static, tidak animated */
#testimoni::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='.025'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
}

/* Ornamen garis tipis atas section */
#testimoni::after {
  content: '';
  position: absolute;
  top: 0; left: 10%; right: 10%;
  height: 1px;
  background: linear-gradient(to right, transparent, var(--manila-dd, #D6C4A0), transparent);
}

.testi-inner {
  position: relative;
  z-index: 1;
  max-width: 1260px;
  margin: 0 auto;
  padding: 0 24px;
}

/* ─── HEADER ─── */
.testi-header {
  text-align: center;
  margin-bottom: 56px;
}

.testi-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--rose, #C07B60);
  margin-bottom: 16px;
}
.testi-eyebrow-line {
  width: 28px; height: 1px;
  background: var(--rose, #C07B60);
  opacity: .5;
}

.testi-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(30px, 4vw, 48px);
  font-weight: 600;
  color: var(--ink, #2A1F14);
  letter-spacing: -.01em;
  line-height: 1.2;
  margin: 0 0 12px;
}
.testi-title em {
  font-style: italic;
  font-weight: 300;
  color: var(--rose, #C07B60);
}

.testi-subtitle {
  font-family: 'Jost', sans-serif;
  font-size: 13.5px;
  color: var(--muted, #8A7560);
  letter-spacing: .02em;
}

/* ─── CAROUSEL OUTER ─── */
.testi-carousel-outer {
  overflow: hidden;
  position: relative;
  margin: 0 -8px;
}

.testi-track {
  display: flex;
  gap: 20px;
  padding: 8px 8px 12px;
  transition: transform .5s cubic-bezier(.4,0,.2,1);
  will-change: transform;
}

/* ─── KARTU TESTIMONI ─── */
.testi-card {
  flex: 0 0 calc(33.333% - 14px);
  background: var(--manila, #F2E8D5);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 12px;
  padding: 28px 26px 24px;
  position: relative;
  transition: transform .3s ease, box-shadow .3s ease;
  overflow: hidden;
}

/* Paper texture per kartu */
.testi-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,.3) 0%, transparent 50%);
  border-radius: inherit;
  pointer-events: none;
}

.testi-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 36px rgba(42,31,20,.1);
}

/* Tanda kutip dekoratif */
.testi-quote-mark {
  position: absolute;
  top: 18px; right: 22px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 64px;
  font-weight: 700;
  color: var(--rose, #C07B60);
  opacity: .1;
  line-height: 1;
  pointer-events: none;
  user-select: none;
}

/* Bintang rating */
.testi-stars {
  display: flex;
  gap: 3px;
  margin-bottom: 14px;
}
.testi-star {
  width: 13px; height: 13px;
  color: var(--rose, #C07B60);
}
.testi-star-empty { opacity: .2; }

/* Teks review */
.testi-text {
  font-family: 'Jost', sans-serif;
  font-size: 13.5px;
  line-height: 1.75;
  color: var(--ink-l, #5C4A35);
  margin-bottom: 20px;

  display: -webkit-box;
  -webkit-box-orient: vertical;

  -webkit-line-clamp: 5; /* WebKit (Chrome, Safari, Edge lama) */
  line-clamp: 5;         /* Standard property */

  overflow: hidden;
}

/* Divider */
.testi-rule {
  height: 1px;
  background: var(--manila-dd, #D6C4A0);
  margin-bottom: 16px;
  opacity: .6;
}

/* Author row */
.testi-author {
  display: flex;
  align-items: center;
  gap: 12px;
}

.testi-avatar {
  width: 38px; height: 38px;
  border-radius: 50%;
  background: var(--ink, #2A1F14);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px;
  font-weight: 600;
  color: var(--paper, #FBF6EE);
  flex-shrink: 0;
}

.testi-author-name {
  font-family: 'Jost', sans-serif;
  font-size: 13px;
  font-weight: 600;
  color: var(--ink, #2A1F14);
  letter-spacing: .02em;
}
.testi-author-date {
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  color: var(--muted, #8A7560);
  margin-top: 2px;
}

/* ─── NAVIGASI ─── */
.testi-nav {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  margin-top: 36px;
}

.testi-nav-btn {
  width: 44px; height: 44px;
  border-radius: 50%;
  border: 1.5px solid var(--manila-dd, #D6C4A0);
  background: var(--paper, #FBF6EE);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background .2s, border-color .2s, transform .2s;
  flex-shrink: 0;
}
.testi-nav-btn:hover {
  background: var(--manila, #F2E8D5);
  border-color: var(--rose, #C07B60);
  transform: scale(1.05);
}
.testi-nav-btn:disabled {
  opacity: .3;
  cursor: not-allowed;
  transform: none;
}
.testi-nav-btn svg {
  width: 18px; height: 18px;
  stroke: var(--ink, #2A1F14);
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.testi-nav-dots {
  display: flex;
  gap: 6px;
  align-items: center;
}
.testi-nav-dot {
  width: 6px; height: 6px;
  border-radius: 100px;
  background: var(--manila-dd, #D6C4A0);
  border: none;
  cursor: pointer;
  transition: width .3s ease, background .3s ease;
  padding: 0;
}
.testi-nav-dot.active {
  width: 24px;
  background: var(--rose, #C07B60);
}

/* ─── STATS BAR ─── */
.testi-stats {
  display: flex;
  justify-content: center;
  gap: 0;
  margin-top: 64px;
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 12px;
  overflow: hidden;
  background: var(--manila, #F2E8D5);
}

.testi-stat {
  flex: 1;
  padding: 24px 20px;
  text-align: center;
  border-right: 1px solid var(--manila-dd, #D6C4A0);
  transition: background .2s;
}
.testi-stat:last-child { border-right: none; }
.testi-stat:hover { background: var(--paper, #FBF6EE); }

.testi-stat-num {
  font-family: 'Cormorant Garamond', serif;
  font-size: 36px;
  font-weight: 600;
  color: var(--ink, #2A1F14);
  line-height: 1;
  letter-spacing: -.02em;
}
.testi-stat-num sup {
  font-size: 16px;
  color: var(--rose, #C07B60);
  vertical-align: super;
}
.testi-stat-label {
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--muted, #8A7560);
  margin-top: 5px;
}

/* ─── RESPONSIVE ─── */
@media (max-width: 900px) {
  .testi-card { flex: 0 0 calc(50% - 10px); }
}
@media (max-width: 600px) {
  #testimoni { padding: 64px 0 60px; }
  .testi-card { flex: 0 0 calc(100% - 0px); }
  .testi-stats { flex-wrap: wrap; }
  .testi-stat {
    flex: 1 1 50%;
    border-bottom: 1px solid var(--manila-dd, #D6C4A0);
  }
  .testi-stat:nth-child(odd) { border-right: 1px solid var(--manila-dd, #D6C4A0); }
  .testi-stat:last-child { border-right: none; }
  .testi-stat:nth-last-child(-n+2) { border-bottom: none; }
}
</style>

<section id="testimoni" role="region" aria-label="Testimoni Pelanggan">
  <div class="testi-inner">

    <!-- HEADER -->
    <header class="testi-header">
      <div class="testi-eyebrow">
        <span class="testi-eyebrow-line"></span>
        Ulasan Pelanggan
        <span class="testi-eyebrow-line"></span>
      </div>
      <h2 class="testi-title">Apa Kata <em>Pelanggan Kami</em></h2>
      <p class="testi-subtitle">Kepercayaan pelanggan adalah yang paling berharga bagi kami</p>
    </header>

    <!-- CAROUSEL -->
    <div class="testi-carousel-outer" id="testi-outer">
      <div class="testi-track" id="testi-track">

        <?php foreach ($testimonials as $t):
          $name    = htmlspecialchars($t['name'] ?? '', ENT_QUOTES);
          $msg     = htmlspecialchars($t['message'] ?? ($t['content'] ?? ''), ENT_QUOTES);
          $rating  = (int)($t['rating'] ?? 5);
          $initial = strtoupper(mb_substr($t['name'], 0, 1, 'UTF-8'));
          $date    = isset($t['created_at']) ? date('M Y', strtotime($t['created_at'])) : '';

          // Stars HTML
          $stars = '';
          for ($s = 0; $s < $rating; $s++)
            $stars .= '<svg class="testi-star" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
          for ($s = $rating; $s < 5; $s++)
            $stars .= '<svg class="testi-star testi-star-empty" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        ?>
        <div class="testi-card">
          <div class="testi-quote-mark" aria-hidden="true">"</div>
          <div class="testi-stars" aria-label="Rating <?= $rating ?> dari 5"><?= $stars ?></div>
          <p class="testi-text"><?= $msg ?></p>
          <div class="testi-rule"></div>
          <div class="testi-author">
            <div class="testi-avatar" aria-hidden="true"><?= $initial ?></div>
            <div>
              <div class="testi-author-name"><?= $name ?></div>
              <?php if ($date): ?>
              <div class="testi-author-date"><?= $date ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>

    <!-- NAVIGASI -->
    <div class="testi-nav">
      <button class="testi-nav-btn" id="testi-prev" aria-label="Sebelumnya">
        <svg viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <div class="testi-nav-dots" id="testi-dots"></div>
      <button class="testi-nav-btn" id="testi-next" aria-label="Berikutnya">
        <svg viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
      </button>
    </div>

    <!-- STATS BAR -->
    <div class="testi-stats" role="list">
      <div class="testi-stat" role="listitem">
        <div class="testi-stat-num">500<sup>+</sup></div>
        <div class="testi-stat-label">Pelanggan Puas</div>
      </div>
      <div class="testi-stat" role="listitem">
        <div class="testi-stat-num">4.9<sup>★</sup></div>
        <div class="testi-stat-label">Rating Google</div>
      </div>
      <div class="testi-stat" role="listitem">
        <div class="testi-stat-num">5<sup>th</sup></div>
        <div class="testi-stat-label">Tahun Berpengalaman</div>
      </div>
      <div class="testi-stat" role="listitem">
        <div class="testi-stat-num">98<sup>%</sup></div>
        <div class="testi-stat-label">Repeat Order</div>
      </div>
    </div>

  </div>
</section>

<script>
(function(){
  const track  = document.getElementById('testi-track');
  const outer  = document.getElementById('testi-outer');
  const prev   = document.getElementById('testi-prev');
  const next   = document.getElementById('testi-next');
  const dotsEl = document.getElementById('testi-dots');

  if (!track || !outer) return;

  let current = 0;

  function getPerPage() {
    const w = window.innerWidth;
    if (w >= 900) return 3;
    if (w >= 600) return 2;
    return 1;
  }

  const cards     = Array.from(track.querySelectorAll('.testi-card'));
  const total     = cards.length;

  function totalPages() {
    return Math.max(1, Math.ceil(total / getPerPage()));
  }

  function cardWidth() {
    const c = cards[0];
    if (!c) return 0;
    return c.offsetWidth + 20; // 20 = gap
  }

  function goTo(idx) {
    const tp = totalPages();
    if (idx < 0) idx = tp - 1;
    if (idx >= tp) idx = 0;
    current = idx;

    const perPage = getPerPage();
    const offset  = current * perPage * cardWidth();
    track.style.transform = `translateX(-${offset}px)`;

    // dots
    dotsEl.querySelectorAll('.testi-nav-dot').forEach((d, i) => {
      d.classList.toggle('active', i === current);
    });

    prev.disabled = (tp <= 1);
    next.disabled = (tp <= 1);
  }

  function buildDots() {
    dotsEl.innerHTML = '';
    const tp = totalPages();
    for (let i = 0; i < tp; i++) {
      const d = document.createElement('button');
      d.className = 'testi-nav-dot' + (i === 0 ? ' active' : '');
      d.setAttribute('aria-label', `Halaman ${i + 1}`);
      d.addEventListener('click', () => goTo(i));
      dotsEl.appendChild(d);
    }
    prev.disabled = (tp <= 1);
    next.disabled = (tp <= 1);
  }

  prev.addEventListener('click', () => goTo(current - 1));
  next.addEventListener('click', () => goTo(current + 1));

  // Touch / swipe
  let tx = 0;
  outer.addEventListener('touchstart', e => { tx = e.touches[0].clientX; }, { passive: true });
  outer.addEventListener('touchend', e => {
    const diff = tx - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 48) goTo(diff > 0 ? current + 1 : current - 1);
  });

  // Rebuild on resize
  let timer;
  window.addEventListener('resize', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      current = 0;
      buildDots();
      goTo(0);
    }, 200);
  });

  buildDots();
  goTo(0);
})();
</script>