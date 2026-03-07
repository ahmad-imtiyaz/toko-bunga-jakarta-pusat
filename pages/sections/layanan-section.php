<?php
/* ============================================================
   LAYANAN SECTION — Manila Florist · Kertas Cream Warm
============================================================ */

$parent_cats = array_filter($categories, fn($c) => empty($c['parent_id']) || $c['parent_id'] == 0);
$parent_cats = array_values($parent_cats);

$sub_cats = db()->query("
    SELECT * FROM categories
    WHERE parent_id IS NOT NULL AND parent_id != 0 AND status = 'active'
    ORDER BY urutan ASC, id ASC
")->fetchAll();

$subs_by_parent = [];
foreach ($sub_cats as $sc) {
    $subs_by_parent[$sc['parent_id']][] = $sc;
}
?>

<style>
/* ══════════════════════════════════════════
   LAYANAN SECTION — Manila Florist
══════════════════════════════════════════ */
#layanan {
  position: relative;
  background: var(--manila);
  overflow: hidden;
}
#layanan::before {
  content: '';
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  opacity: .035;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size: 200px 200px;
}

.layanan-wave-top    { line-height: 0; margin-bottom: -1px; }
.layanan-wave-top svg { width: 100%; display: block; }
.layanan-wave-bottom { line-height: 0; margin-top: -1px; }
.layanan-wave-bottom svg { width: 100%; display: block; }

.layanan-inner {
  position: relative;
  z-index: 1;
  max-width: 1280px;
  margin: 0 auto;
  padding: 72px 32px 80px;
}

/* ── Header ── */
.layanan-header { text-align: center; margin-bottom: 56px; }

.layanan-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--paper);
  border: 1px solid var(--manila-dd);
  border-radius: 100px;
  padding: 6px 16px 6px 10px;
  margin-bottom: 20px;
}
.layanan-badge-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--sage);
  flex-shrink: 0;
}
.layanan-badge-text {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px;
  font-weight: 500;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--ink-l);
}
.layanan-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2rem, 3.8vw, 3.2rem);
  font-weight: 600;
  color: var(--ink);
  line-height: 1.1;
  letter-spacing: -.01em;
  margin-bottom: 6px;
}
.layanan-title em {
  font-style: italic;
  font-weight: 300;
  color: var(--rose);
  font-size: 1.05em;
}
.layanan-rule {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin: 18px auto 16px;
  max-width: 320px;
}
.layanan-rule-line     { flex: 1; height: 1px; background: linear-gradient(to right, transparent, var(--manila-dd)); }
.layanan-rule-line.rev { background: linear-gradient(to left, transparent, var(--manila-dd)); }
.layanan-rule-dot      { width: 4px; height: 4px; border-radius: 50%; background: var(--rose-l); flex-shrink: 0; }
.layanan-subtitle {
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  line-height: 1.85;
  color: var(--muted);
  max-width: 500px;
  margin: 0 auto;
}

/* ── Grid ── */
.layanan-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}

/* ── Kartu ── */
.lcard {
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  background: var(--paper);
  border: 1px solid rgba(255,255,255,.7);
  box-shadow: 3px 5px 18px rgba(42,31,20,.12), 0 1px 3px rgba(42,31,20,.06);
  transition: transform .3s ease, box-shadow .3s ease;
  display: flex;
  flex-direction: column;
}
.lcard:hover {
  transform: translateY(-5px);
  box-shadow: 6px 14px 32px rgba(42,31,20,.16), 0 2px 6px rgba(42,31,20,.08);
}

/* Foto */
.lcard-photo {
  position: relative;
  width: 100%;
  aspect-ratio: 4/3;
  overflow: hidden;
  background: var(--manila-d);
  flex-shrink: 0;
}
.lcard-photo img {
  width: 100%; height: 100%;
  object-fit: cover; display: block;
  transition: transform .45s ease;
}
.lcard:hover .lcard-photo img { transform: scale(1.05); }

/* Placeholder foto — SVG bunga sederhana, tanpa emoji */
.lcard-photo-ph {
  width: 100%; height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, var(--manila) 0%, var(--manila-d) 100%);
}
.lcard-photo-ph svg {
  width: 52px; height: 52px;
  opacity: .3;
  stroke: var(--ink);
  fill: none;
  stroke-width: 1.2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.lcard-photo::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 40%;
  background: linear-gradient(to top, rgba(42,31,20,.22), transparent);
  pointer-events: none;
}

.lcard-num {
  position: absolute;
  top: 12px; left: 12px;
  z-index: 2;
  background: rgba(251,246,238,.88);
  backdrop-filter: blur(4px);
  border: 1px solid var(--manila-dd);
  padding: 3px 10px;
  border-radius: 100px;
  font-family: 'Jost', sans-serif;
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .1em;
  color: var(--muted);
}

/* Body */
.lcard-body {
  padding: 20px 22px 22px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

/* Icon kotak kecil — SVG inline, bukan emoji */
.lcard-icon {
  width: 36px; height: 36px;
  background: var(--manila);
  border-radius: 8px;
  border: 1px solid var(--manila-dd);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 12px;
  flex-shrink: 0;
}
.lcard-icon svg {
  width: 18px; height: 18px;
  stroke: var(--rose);
  fill: none;
  stroke-width: 1.6;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.lcard-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.35rem;
  font-weight: 600;
  color: var(--ink);
  line-height: 1.2;
  margin-bottom: 8px;
  letter-spacing: -.01em;
}
.lcard-rule {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 10px;
}
.lcard-rule-line {
  width: 28px; height: 1px;
  background: var(--rose-l);
  transition: width .3s ease;
}
.lcard:hover .lcard-rule-line { width: 48px; }
.lcard-rule-dot {
  width: 3px; height: 3px;
  border-radius: 50%;
  background: var(--sage);
  flex-shrink: 0;
}
.lcard-desc {
  font-family: 'Jost', sans-serif;
  font-size: 12.5px;
  line-height: 1.75;
  color: var(--muted);
  margin-bottom: 14px;
  flex: 1;

  display: -webkit-box;
  -webkit-box-orient: vertical;

  -webkit-line-clamp: 3; /* WebKit browsers */
  line-clamp: 3;         /* Standard property */

  overflow: hidden;
}

/* ── Sub-kategori — tampil semua dengan toggle ── */
.lcard-subs {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-bottom: 16px;
}

.lcard-sub-pill {
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .03em;
  color: var(--sage);
  border: 1px solid rgba(107,140,106,.28);
  background: rgba(107,140,106,.06);
  padding: 4px 10px;
  border-radius: 100px;
  text-decoration: none;
  white-space: nowrap;
  transition: background .2s, border-color .2s, color .2s;
}
.lcard-sub-pill:hover {
  background: rgba(107,140,106,.14);
  border-color: rgba(107,140,106,.5);
  color: var(--ink);
}

/* Pills tersembunyi — muncul saat expanded */
.lcard-sub-pill.pill-hidden { display: none; }
.lcard-subs.expanded .lcard-sub-pill.pill-hidden { display: inline-flex; }

/* Tombol toggle */
.subs-toggle {
  font-family: 'Jost', sans-serif;
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: .05em;
  color: var(--muted);
  border: 1px solid var(--border);
  background: transparent;
  padding: 4px 10px;
  border-radius: 100px;
  cursor: pointer;
  transition: color .2s, border-color .2s, background .2s;
  white-space: nowrap;
}
.subs-toggle:hover {
  color: var(--rose);
  border-color: rgba(192,123,96,.35);
  background: rgba(192,123,96,.05);
}

/* CTA */
.lcard-cta {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-family: 'Jost', sans-serif;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--rose);
  text-decoration: none;
  transition: gap .25s ease, color .2s;
  margin-top: auto;
  padding-top: 2px;
}
.lcard-cta:hover { gap: 12px; color: var(--ink); text-decoration: none; }
.lcard-cta svg   { flex-shrink: 0; transition: transform .25s ease; }
.lcard-cta:hover svg { transform: translateX(3px); }

/* ── Responsive ── */
@media (max-width: 1024px) {
  .layanan-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
}
@media (max-width: 600px) {
  .layanan-grid  { grid-template-columns: 1fr; gap: 16px; }
  .layanan-inner { padding: 48px 16px 56px; }
}
</style>

<!-- Wave atas -->
<div class="layanan-wave-top">
  <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 0 L0 30 Q360 60 720 30 Q1080 0 1440 30 L1440 0 Z" fill="var(--manila)"/>
  </svg>
</div>

<section id="layanan">
  <div class="layanan-inner">

    <header class="layanan-header">
      <div class="layanan-badge">
        <span class="layanan-badge-dot"></span>
        <span class="layanan-badge-text">Layanan Kami · Florist Jakarta Pusat</span>
      </div>
      <h2 class="layanan-title">
        Layanan <em>Spesial</em><br>
        untuk Setiap Momen
      </h2>
      <div class="layanan-rule">
        <div class="layanan-rule-line"></div>
        <div class="layanan-rule-dot"></div>
        <div class="layanan-rule-line rev"></div>
      </div>
      <p class="layanan-subtitle">
        Kami menyediakan berbagai rangkaian bunga segar berkualitas tinggi,
        dirancang khusus untuk setiap momen spesial Anda di Jakarta Pusat.
      </p>
    </header>

    <div class="layanan-grid">

      <?php
      /* SVG path per indeks — icon minimalis, berganti-ganti */
      $svg_icons = [
        /* bunga/rangkaian */ 'M12 2C10 2 8 4 8 7c0 2 1 3.5 2.5 4.5C9 13 7 15 7 18h10c0-3-2-5-3.5-6.5C15 10.5 16 9 16 7c0-3-2-5-4-5zM12 11.5V22',
        /* bouquet */ 'M9 3c0 0-2 3-2 6s2 5 5 5 5-2 5-5-2-6-2-6M12 14v8M8 18h8',
        /* bintang/custom */ 'M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z',
        /* hati/wedding */ 'M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l8.84 8.84 8.84-8.84a5.5 5.5 0 0 0 0-7.78z',
        /* meja/dekor */ 'M4 7h16M4 17h16M8 7v10M16 7v10',
        /* kotak/gift */ 'M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16zM12 22V12M3.27 6.96L12 12l8.73-5.04',
        /* lilin/duka */ 'M12 2v8M8 6c0 0-2 2-2 6s2 8 6 8 6-4 6-8-2-6-2-6M9 21h6',
        /* lingkaran/krans */ 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 14c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z',
      ];

      foreach ($parent_cats as $i => $cat):
        $has_img    = !empty($cat['image']);
        $img_url    = $has_img ? e(imgUrl($cat['image'], 'category')) : '';
        $children   = $subs_by_parent[$cat['id']] ?? [];
        $num        = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $total_str  = str_pad(count($parent_cats), 2, '0', STR_PAD_LEFT);
        $icon_path  = $svg_icons[$i % count($svg_icons)];
        $desc       = !empty($cat['description'])
                      ? $cat['description']
                      : 'Rangkaian ' . $cat['name'] . ' kami menggunakan bunga-bunga segar pilihan terbaik untuk momen spesialmu.';
        $show_max   = 4;
        $total_subs = count($children);
        $has_more   = $total_subs > $show_max;
      ?>

      <article class="lcard">

        <!-- Foto -->
        <div class="lcard-photo">
          <?php if ($has_img): ?>
            <img src="<?= $img_url ?>" alt="<?= e($cat['name']) ?>" loading="lazy">
          <?php else: ?>
            <div class="lcard-photo-ph">
              <svg viewBox="0 0 24 24">
                <path d="M12 2C10 2 8 4 8 7c0 2 1 3.5 2.5 4.5C9 13 7 15 7 18h10c0-3-2-5-3.5-6.5C15 10.5 16 9 16 7c0-3-2-5-4-5z"/>
                <line x1="12" y1="18" x2="12" y2="22"/>
              </svg>
            </div>
          <?php endif; ?>
          <div class="lcard-num"><?= $num ?> / <?= $total_str ?></div>
        </div>

        <!-- Body -->
        <div class="lcard-body">

          <div class="lcard-icon">
            <svg viewBox="0 0 24 24">
              <path d="<?= $icon_path ?>"/>
            </svg>
          </div>

          <h3 class="lcard-name"><?= e($cat['name']) ?></h3>

          <div class="lcard-rule">
            <div class="lcard-rule-line"></div>
            <div class="lcard-rule-dot"></div>
          </div>

          <p class="lcard-desc"><?= e(strip_tags($desc)) ?></p>

          <?php if (!empty($children)): ?>
          <div class="lcard-subs" id="subs-<?= $cat['id'] ?>">

            <?php foreach ($children as $j => $ch): ?>
            <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
               class="lcard-sub-pill<?= $j >= $show_max ? ' pill-hidden' : '' ?>">
              <?= e($ch['name']) ?>
            </a>
            <?php endforeach; ?>

            <?php if ($has_more): ?>
            <button class="subs-toggle"
                    onclick="toggleSubs(this,'<?= $cat['id'] ?>')"
                    data-more="+<?= $total_subs - $show_max ?> lainnya"
                    data-less="Sembunyikan">
              +<?= $total_subs - $show_max ?> lainnya
            </button>
            <?php endif; ?>

          </div>
          <?php endif; ?>

          <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/" class="lcard-cta">
            Lihat Koleksi
            <svg width="13" height="13" fill="none" stroke="currentColor"
                 stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </a>

        </div>
      </article>

      <?php endforeach; ?>

    </div><!-- /layanan-grid -->
  </div>
</section>

<!-- Wave bawah -->
<div class="layanan-wave-bottom">
  <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0 60 L0 30 Q360 0 720 30 Q1080 60 1440 30 L1440 60 Z" fill="var(--manila)"/>
  </svg>
</div>

<script>
function toggleSubs(btn, catId) {
  var container = document.getElementById('subs-' + catId);
  var expanded  = container.classList.toggle('expanded');
  btn.textContent = expanded ? btn.dataset.less : btn.dataset.more;
}
</script>