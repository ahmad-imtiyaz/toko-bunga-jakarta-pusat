<?php
require_once __DIR__ . '/../includes/config.php';

$meta_title    = 'Blog - ' . setting('site_name');
$meta_desc     = 'Artikel, tips, dan inspirasi seputar bunga dari ' . setting('site_name') . '.';
$meta_keywords = 'blog bunga, tips bunga, inspirasi rangkaian, florist jakarta pusat';

$filter_cat = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$search     = isset($_GET['q'])        ? trim($_GET['q'])        : '';

$per_page    = 9;
$page        = max(1, (int)($_GET['page'] ?? 1));
$offset      = ($page - 1) * $per_page;

$where  = ["b.status = 'active'"];
$params = [];
if ($filter_cat) { $where[] = 'bc.slug = ?'; $params[] = $filter_cat; }
if ($search)     { $where[] = '(b.title LIKE ? OR b.excerpt LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
$where_sql = implode(' AND ', $where);

$count_stmt = db()->prepare("SELECT COUNT(*) FROM blogs b LEFT JOIN blog_categories bc ON b.blog_category_id = bc.id WHERE $where_sql");
$count_stmt->execute($params);
$total      = (int)$count_stmt->fetchColumn();
$total_page = (int)ceil($total / $per_page);

$stmt = db()->prepare("
    SELECT b.*, bc.name AS cat_name, bc.slug AS cat_slug
    FROM blogs b
    LEFT JOIN blog_categories bc ON b.blog_category_id = bc.id
    WHERE $where_sql
    ORDER BY b.urutan ASC, b.created_at DESC
    LIMIT $per_page OFFSET $offset
");
$stmt->execute($params);
$blogs = $stmt->fetchAll();

$blog_cats = db()->query("
    SELECT bc.*, COUNT(b.id) AS total
    FROM blog_categories bc
    LEFT JOIN blogs b ON b.blog_category_id = bc.id AND b.status = 'active'
    WHERE bc.status = 'active'
    GROUP BY bc.id ORDER BY bc.urutan ASC
")->fetchAll();

$locations = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url    = setting('whatsapp_url');

require __DIR__ . '/../includes/header.php';
?>

<style>
/* ══════════════════════════════════════════
   TOKENS — Sage Forest × Parchment
══════════════════════════════════════════ */
:root {
  --parch:    #F4EFE4;
  --parch-d:  #E8E0D0;
  --parch-dd: #D8CDB8;
  --leaf:     #FFF8EF;
  --ink:      #1C2B1A;
  --ink-l:    #3D5239;
  --sage:     #5C7A55;
  --sage-l:   #8AAE81;
  --terra:    #B5622A;
  --terra-l:  #D4895A;
  --muted:    #7A7060;
  --border:   rgba(92,122,85,.14);
}

/* ── Animasi ── */
@keyframes blgFadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes blgPetalDrift {
  0%   { transform: translateY(-10px) rotate(0deg); opacity: 0; }
  8%   { opacity: .3; }
  90%  { opacity: .18; }
  100% { transform: translateY(108vh) rotate(460deg) translateX(32px); opacity: 0; }
}
@keyframes blgTicker {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
@keyframes blgPulse {
  0%   { transform: scale(1);   opacity: .6; }
  100% { transform: scale(2.2); opacity: 0; }
}
@keyframes blgShimmerX {
  0%   { background-position: -200% center; }
  100% { background-position:  200% center; }
}
@keyframes blgFloat {
  0%,100% { transform: translateY(0) rotate(0deg); opacity: .25; }
  50%      { transform: translateY(-22px) rotate(10deg); opacity: .45; }
}

.blg-rv1 { animation: blgFadeUp .5s ease both .05s; }
.blg-rv2 { animation: blgFadeUp .5s ease both .15s; }
.blg-rv3 { animation: blgFadeUp .5s ease both .27s; }

.blg-petal {
  position: fixed; pointer-events: none; z-index: 9998;
  border-radius: 80% 20% 80% 20% / 60% 60% 40% 40%;
  animation: blgPetalDrift linear infinite;
}
.blg-float-petal {
  position: absolute; pointer-events: none; user-select: none;
  font-size: 15px; animation: blgFloat var(--dur,8s) ease-in-out var(--del,0s) infinite;
  opacity: .25;
}

/* ══ HERO — center, sama konsep Tangerang ══ */
.blg-hero {
  position: relative;
  background: var(--parch);
  overflow: hidden;
  padding: 88px 24px 72px;
  text-align: center;
}
.blg-hero::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='.025'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 0;
}
.blg-hero::after {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 65% 80% at 100% 45%, rgba(138,174,129,.22) 0%, transparent 60%),
    radial-gradient(ellipse 55% 70% at 0%   55%, rgba(181,98,42,.06) 0%, transparent 55%);
  pointer-events: none; z-index: 0;
}
.blg-hero-dots {
  position: absolute; inset: 0; z-index: 0; pointer-events: none;
  background-image: radial-gradient(circle, var(--sage) 1px, transparent 1px);
  background-size: 40px 40px;
  opacity: .038;
}
.blg-hero-strip {
  position: absolute; bottom: 0; left: 0; right: 0; height: 4px; z-index: 6;
  background: linear-gradient(90deg, var(--parch-dd), var(--sage), var(--terra-l), var(--sage), var(--parch-dd));
  background-size: 200% auto;
  animation: blgShimmerX 3.5s linear infinite;
}
.blg-hero-inner {
  position: relative; z-index: 5;
  max-width: 640px; margin: 0 auto;
}

/* Badge */
.blg-badge {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 5px 16px 5px 12px;
  background: rgba(92,122,85,.1);
  border: 1px solid rgba(92,122,85,.25);
  border-radius: 20px; margin-bottom: 18px;
}
.blg-badge-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--sage); position: relative;
}
.blg-badge-dot::after {
  content: '';
  position: absolute; inset: -3px; border-radius: 50%;
  border: 1px solid var(--sage);
  animation: blgPulse 2s ease-out infinite;
}
.blg-badge-text {
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 600;
  letter-spacing: .18em; text-transform: uppercase;
  color: var(--sage);
}

/* Judul */
.blg-h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(2.2rem, 6vw, 3.6rem);
  font-weight: 700; color: var(--ink);
  line-height: 1.1; letter-spacing: -.01em;
  margin-bottom: 8px;
}
.blg-h1-accent {
  font-style: italic; font-weight: 300; color: var(--sage);
}
.blg-tagline {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; font-weight: 300;
  font-size: clamp(.95rem, 1.9vw, 1.2rem);
  color: var(--terra); margin-bottom: 16px;
  letter-spacing: .03em;
}
.blg-desc {
  font-family: 'Jost', sans-serif;
  font-size: 14px; font-weight: 300;
  line-height: 1.85; color: var(--ink-l);
  margin: 0 auto 26px; max-width: 440px; opacity: .85;
}

/* Search */
.blg-search-form {
  display: flex; max-width: 480px; margin: 0 auto 28px;
  border-radius: 8px; overflow: hidden;
  border: 1.5px solid var(--parch-dd);
  background: var(--leaf);
  box-shadow: 0 4px 20px rgba(28,43,26,.08);
  transition: border-color .2s, box-shadow .2s;
}
.blg-search-form:focus-within {
  border-color: var(--sage-l);
  box-shadow: 0 0 0 3px rgba(92,122,85,.1), 0 4px 20px rgba(28,43,26,.08);
}
.blg-search-input {
  flex: 1; padding: 13px 20px;
  font-family: 'Jost', sans-serif;
  font-size: 14px; font-weight: 300;
  background: transparent; color: var(--ink);
  border: none; outline: none; min-width: 0;
}
.blg-search-input::placeholder { color: rgba(122,112,96,.5); }
.blg-search-btn {
  padding: 13px 22px;
  background: var(--ink); color: var(--parch);
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 600;
  letter-spacing: .06em; text-transform: uppercase;
  border: none; cursor: pointer; flex-shrink: 0;
  transition: background .2s;
}
.blg-search-btn:hover { background: var(--ink-l); }

/* Stats row bawah hero — sama persis Tangerang */
.blg-stats-row {
  display: flex; justify-content: center; gap: 32px;
  align-items: center;
}
.blg-stat-item { text-align: center; }
.blg-stat-val {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px; font-weight: 700;
  color: var(--sage);
  margin-bottom: 2px;
}
.blg-stat-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--muted);
}
.blg-stat-div {
  width: 1px; height: 36px;
  background: var(--parch-dd);
}

/* ══ TICKER ══ */
.blg-ticker {
  background: var(--ink); overflow: hidden; padding: 9px 0;
}
.blg-ticker-inner {
  display: flex; white-space: nowrap;
  animation: blgTicker 22s linear infinite;
}
.blg-ticker-item {
  display: inline-flex; align-items: center; gap: 10px;
  margin: 0 20px;
  font-family: 'Jost', sans-serif;
  font-size: 10.5px; font-weight: 400;
  letter-spacing: .14em; text-transform: uppercase;
  color: rgba(244,239,228,.35);
  text-decoration: none; flex-shrink: 0;
  transition: color .2s;
}
.blg-ticker-item:hover { color: var(--sage-l); }
.blg-ticker-dot {
  width: 3px; height: 3px; border-radius: 50%;
  background: var(--sage); opacity: .55; flex-shrink: 0;
}

/* ══ BODY ══ */
.blg-body {
  background: var(--parch);
  padding: 48px 0 72px;
  position: relative;
}
.blg-body::before {
  content: '';
  position: absolute; inset: 0; pointer-events: none;
  background-image:
    repeating-linear-gradient(0deg,  transparent 0, transparent 47px, rgba(28,43,26,.03) 47px, rgba(28,43,26,.03) 48px),
    repeating-linear-gradient(90deg, transparent 0, transparent 47px, rgba(28,43,26,.03) 47px, rgba(28,43,26,.03) 48px);
}
.blg-container {
  position: relative; z-index: 1;
  max-width: 1280px; margin: 0 auto; padding: 0 24px;
}
.blg-layout {
  display: grid;
  grid-template-columns: 1fr 268px;
  gap: 44px; align-items: start;
}

/* ══ FILTER PILLS ══ */
.blg-filter-bar {
  display: flex; gap: 6px; flex-wrap: wrap;
  margin-bottom: 24px; padding-bottom: 20px;
  border-bottom: 1px solid var(--parch-dd);
}
.blg-pill {
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 600;
  padding: 5px 14px; border-radius: 20px;
  text-transform: uppercase; letter-spacing: .07em;
  text-decoration: none;
  border: 1px solid var(--parch-dd); color: var(--muted);
  background: transparent;
  transition: all .22s ease;
}
.blg-pill:hover { color: var(--sage); border-color: rgba(92,122,85,.35); background: rgba(92,122,85,.07); }
.blg-pill.active { background: var(--ink); color: var(--parch); border-color: var(--ink); }

/* ══ ARTIKEL LIST — struktur vertikal ikut Tangerang ══ */
.blg-divider {
  height: 1px;
  background: linear-gradient(90deg, rgba(92,122,85,.35), transparent);
  margin-bottom: 8px;
}

.blg-article-card {
  display: flex; flex-direction: row; align-items: stretch;
  padding: 20px 0; border-bottom: 1px solid rgba(92,122,85,.1);
  transition: background .25s ease, padding-left .2s, padding-right .2s, border-radius .2s;
}
.blg-article-card:hover {
  background: rgba(92,122,85,.04);
  border-radius: 10px;
  padding-left: 10px; padding-right: 10px;
  margin: 0 -10px;
}

/* Thumb */
.blg-thumb-link {
  flex-shrink: 0; width: 195px; height: 135px;
  border-radius: 10px; overflow: hidden;
  position: relative; display: block;
  background: var(--parch-d);
  border: 1px solid var(--parch-dd);
}
.blg-thumb-link img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  transition: transform .6s cubic-bezier(.4,0,.2,1);
}
.blg-article-card:hover .blg-thumb-link img { transform: scale(1.07); }
.blg-read-badge {
  position: absolute; bottom: 8px; right: 8px;
  background: rgba(28,43,26,.65); color: var(--sage-l);
  font-family: 'Jost', sans-serif;
  font-size: 9px; font-weight: 700;
  padding: 2px 8px; border-radius: 20px;
  backdrop-filter: blur(4px);
}

/* Body artikel */
.blg-article-body {
  flex: 1; padding-left: 18px;
  display: flex; flex-direction: column;
  justify-content: space-between; min-width: 0;
}
.blg-cat-badge-inline {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 700;
  padding: 3px 10px; border-radius: 20px;
  text-transform: uppercase; letter-spacing: .05em;
  text-decoration: none;
  background: rgba(92,122,85,.1);
  border: 1px solid rgba(92,122,85,.22);
  color: var(--sage);
  transition: all .2s;
}
.blg-cat-badge-inline:hover { background: var(--sage); color: var(--parch); }
.blg-char-badge {
  font-family: 'Jost', sans-serif;
  font-size: 10px; color: var(--muted);
  padding: 2px 8px; border-radius: 20px;
  background: rgba(92,122,85,.05);
  border: 1px solid var(--parch-dd);
}
.blg-article-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px; font-weight: 700;
  color: var(--ink); line-height: 1.35;
  margin-bottom: 6px;
  display: -webkit-box;
  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  line-clamp: 2; overflow: hidden;
  text-decoration: none;
  transition: color .2s;
}
.blg-article-title:hover { color: var(--sage); }
.blg-article-excerpt {
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 300; color: var(--muted);
  line-height: 1.65; margin: 0;
  display: -webkit-box;
  -webkit-line-clamp: 2; -webkit-box-orient: vertical;
  line-clamp: 2; overflow: hidden;
}
.blg-article-more {
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 700;
  color: var(--terra); text-decoration: none;
  letter-spacing: .02em;
  transition: color .2s;
}
.blg-article-more:hover { color: var(--terra-l); }
.blg-article-date {
  font-family: 'Jost', sans-serif;
  font-size: 11px; color: rgba(28,43,26,.3);
}

/* ══ PAGINATION ══ */
.blg-page-btn {
  width: 36px; height: 36px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 600;
  text-decoration: none;
  border: 1px solid var(--parch-dd); color: var(--muted);
  background: var(--leaf);
  transition: all .2s;
}
.blg-page-btn:hover, .blg-page-btn.active {
  background: var(--ink); color: var(--parch); border-color: var(--ink);
}

/* ══ RESPONSIVE ══ */
@media(max-width:1023px){
  .blg-layout { grid-template-columns: 1fr !important; }
  .blg-sidebar { display: none; }
}
@media(max-width:640px){
  .blg-thumb-link { width: 110px; height: 110px; }
  .blg-hero { padding-top: 80px; }
}
</style>

<!-- ── Kelopak jatuh ── -->
<div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:9998;" aria-hidden="true">
<?php
$petal_cols = ['#5C7A55','#8AAE81','#D8CDB8','#B5622A','#F4EFE4'];
for ($i = 0; $i < 9; $i++):
  $col  = $petal_cols[$i % count($petal_cols)];
  $left = rand(2, 97); $del = rand(0, 18); $dur = rand(14, 24); $sz = rand(6, 11);
?>
<div class="blg-petal" style="left:<?= $left ?>%;top:0;width:<?= $sz ?>px;height:<?= round($sz*1.4) ?>px;background:<?= $col ?>;opacity:.25;animation-duration:<?= $dur ?>s;animation-delay:-<?= $del ?>s;"></div>
<?php endfor; ?>
</div>

<!-- ════════════ HERO ════════════ -->
<section class="blg-hero">
  <div class="blg-hero-dots"></div>

  <!-- Float petals dekoratif -->
  <?php
  $fp = ['🌿','🍃','✦','❋'];
  for ($i = 0; $i < 10; $i++):
    $top  = rand(5, 90); $left = rand(3, 95);
    $dur  = rand(6, 14); $del  = rand(0, 8);
  ?>
  <span class="blg-float-petal" style="top:<?= $top ?>%;left:<?= $left ?>%;--dur:<?= $dur ?>s;--del:<?= $del ?>s;"><?= $fp[$i % 4] ?></span>
  <?php endfor; ?>

  <!-- Glow blobs -->
  <div style="position:absolute;top:-60px;right:-80px;width:480px;height:480px;background:radial-gradient(circle,rgba(138,174,129,.3),transparent 65%);filter:blur(70px);pointer-events:none;z-index:0;"></div>
  <div style="position:absolute;bottom:-40px;left:-60px;width:360px;height:360px;background:radial-gradient(circle,rgba(181,98,42,.08),transparent 65%);filter:blur(80px);pointer-events:none;z-index:0;"></div>

  <div class="blg-hero-inner">

    <!-- Badge -->
    <div class="blg-badge blg-rv1">
      <div class="blg-badge-dot"></div>
      <span class="blg-badge-text">Artikel &amp; Inspirasi Bunga</span>
    </div>

    <!-- Judul -->
    <h1 class="blg-h1 blg-rv2">
      Blog <span class="blg-h1-accent">Florist</span>
    </h1>
    <p style="font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(92,122,85,.5);margin-bottom:14px;"><?= e(setting('site_name')) ?></p>
    <p class="blg-tagline blg-rv2">Tips, Inspirasi &amp; Cerita Bunga</p>

    <p class="blg-desc blg-rv3">
      Pelajari cara merawat bunga, temukan inspirasi rangkaian untuk setiap momen, dan ikuti cerita di balik layar florist kami.
    </p>

    <!-- Search -->
    <form class="blg-search-form blg-rv3" method="GET" action="<?= BASE_URL ?>/blog/">
      <input type="text" name="q" value="<?= e($search) ?>"
             placeholder="Cari artikel, tips, inspirasi..."
             class="blg-search-input">
      <?php if($filter_cat): ?>
      <input type="hidden" name="kategori" value="<?= e($filter_cat) ?>">
      <?php endif; ?>
      <button type="submit" class="blg-search-btn">Cari</button>
    </form>

    <!-- Stats row — inline seperti Tangerang -->
    <div class="blg-stats-row blg-rv3">
      <div class="blg-stat-item">
        <div class="blg-stat-val"><?= $total ?></div>
        <div class="blg-stat-lbl">Artikel</div>
      </div>
      <div class="blg-stat-div"></div>
      <div class="blg-stat-item">
        <div class="blg-stat-val"><?= count($blog_cats) ?></div>
        <div class="blg-stat-lbl">Kategori</div>
      </div>
      <div class="blg-stat-div"></div>
      <div class="blg-stat-item">
        <div class="blg-stat-val" style="color:var(--terra);">Gratis</div>
        <div class="blg-stat-lbl">Untuk semua</div>
      </div>
    </div>

  </div>
  <div class="blg-hero-strip"></div>
</section>

<!-- ════════════ TICKER ════════════ -->
<div class="blg-ticker" aria-label="Kategori artikel">
  <div class="blg-ticker-inner" aria-hidden="true">
    <?php for($r=0;$r<2;$r++): foreach($blog_cats as $bc): ?>
    <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($bc['slug']) ?>"
       class="blg-ticker-item <?= $filter_cat===$bc['slug']?'active':'' ?>">
      <span class="blg-ticker-dot"></span>
      <?= e($bc['name']) ?>
      <span style="opacity:.3;font-size:9px;">(<?= $bc['total'] ?>)</span>
    </a>
    <?php endforeach; endfor; ?>
  </div>
</div>

<!-- ════════════ BODY ════════════ -->
<section class="blg-body">
  <div class="blg-container">
    <div class="blg-layout">

      <!-- ── ARTIKEL ── -->
      <div style="min-width:0;">

        <!-- Filter pills -->
        <div class="blg-filter-bar">
          <a href="<?= BASE_URL ?>/blog/" class="blg-pill <?= !$filter_cat?'active':'' ?>">Semua</a>
          <?php foreach($blog_cats as $bc): ?>
          <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($bc['slug']) ?>"
             class="blg-pill <?= $filter_cat===$bc['slug']?'active':'' ?>">
            <?= e($bc['name']) ?> <span style="opacity:.55;">(<?= $bc['total'] ?>)</span>
          </a>
          <?php endforeach; ?>
        </div>

        <?php if($search): ?>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:22px;padding:12px 16px;background:rgba(92,122,85,.07);border:1px solid rgba(92,122,85,.18);border-radius:7px;">
          <span style="font-family:'Jost',sans-serif;font-size:13px;color:var(--muted);">
            Hasil: <strong style="color:var(--sage);">"<?= e($search) ?>"</strong> — <?= $total ?> artikel
          </span>
          <a href="<?= BASE_URL ?>/blog/"
             style="font-family:'Jost',sans-serif;font-size:11px;font-weight:700;color:var(--terra);text-decoration:none;margin-left:auto;background:rgba(181,98,42,.09);padding:4px 12px;border-radius:4px;">
            Reset ✕
          </a>
        </div>
        <?php endif; ?>

        <?php if(empty($blogs)): ?>
        <div style="text-align:center;padding:80px 0;">
          <div style="font-size:54px;margin-bottom:16px;">🌿</div>
          <p style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;font-weight:600;color:var(--ink);margin-bottom:8px;">Belum ada artikel ditemukan</p>
          <p style="font-family:'Jost',sans-serif;font-size:14px;color:var(--muted);">Coba kategori atau kata kunci lain</p>
        </div>

        <?php else:
          function blgThumb($blog): string {
            if (!empty($blog['thumbnail']) && file_exists(UPLOAD_DIR . $blog['thumbnail']))
              return UPLOAD_URL . $blog['thumbnail'];
            return 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=400&h=280&fit=crop';
          }
        ?>

        <!-- Divider -->
        <div class="blg-divider"></div>

        <!-- List artikel vertikal -->
        <div style="display:flex;flex-direction:column;">
          <?php foreach($blogs as $blog):
            $thumb       = blgThumb($blog);
            $txt         = strip_tags($blog['content'] ?? '');
            $char_count  = mb_strlen($txt);
            $char_label  = $char_count >= 1000 ? round($char_count/1000,1).'k karakter' : $char_count.' karakter';
            $read_min    = max(1, ceil($char_count / 1000));
            $updated     = $blog['updated_at'] ?? $blog['created_at'];
          ?>
          <article class="blg-article-card">

            <!-- Thumb -->
            <a href="<?= BASE_URL ?>/blog/<?= e($blog['slug']) ?>/" class="blg-thumb-link">
              <img src="<?= e($thumb) ?>" alt="<?= e($blog['title']) ?>" loading="lazy">
              <span class="blg-read-badge"><?= $read_min ?> mnt</span>
            </a>

            <!-- Body -->
            <div class="blg-article-body">
              <div>
                <!-- Badges atas -->
                <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;margin-bottom:8px;">
                  <?php if($blog['cat_name']): ?>
                  <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($blog['cat_slug']) ?>"
                     class="blg-cat-badge-inline">
                    <?= e($blog['cat_name']) ?>
                  </a>
                  <?php endif; ?>
                  <span class="blg-char-badge"><?= $char_label ?></span>
                </div>

                <!-- Judul -->
                <a href="<?= BASE_URL ?>/blog/<?= e($blog['slug']) ?>/" class="blg-article-title">
                  <?= e($blog['title']) ?>
                </a>

                <!-- Excerpt -->
                <?php if($blog['excerpt']): ?>
                <p class="blg-article-excerpt"><?= e($blog['excerpt']) ?></p>
                <?php endif; ?>
              </div>

              <!-- Meta bawah -->
              <div style="display:flex;align-items:center;gap:10px;margin-top:10px;flex-wrap:wrap;">
                <span class="blg-article-date">Diperbarui <?= date('d M Y', strtotime($updated)) ?></span>
                <span style="width:3px;height:3px;border-radius:50%;background:var(--parch-dd);"></span>
                <a href="<?= BASE_URL ?>/blog/<?= e($blog['slug']) ?>/" class="blg-article-more">
                  Baca selengkapnya →
                </a>
              </div>
            </div>

          </article>
          <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if($total_page > 1): ?>
        <div style="display:flex;justify-content:center;align-items:center;gap:6px;margin-top:40px;flex-wrap:wrap;">
          <?php if($page > 1):
            $qa = array_filter(['kategori'=>$filter_cat,'q'=>$search,'page'=>$page-1>1?$page-1:null]);
            $qs = $qa ? '?'.http_build_query($qa) : '';
          ?>
          <a href="<?= BASE_URL ?>/blog/<?= $qs ?>" class="blg-page-btn">‹</a>
          <?php endif; ?>

          <?php for($p=1;$p<=$total_page;$p++):
            $qa = array_filter(['kategori'=>$filter_cat,'q'=>$search,'page'=>$p>1?$p:null]);
            $qs = $qa ? '?'.http_build_query($qa) : '';
          ?>
          <a href="<?= BASE_URL ?>/blog/<?= $qs ?>" class="blg-page-btn <?= $p===$page?'active':'' ?>"><?= $p ?></a>
          <?php endfor; ?>

          <?php if($page < $total_page):
            $qa = array_filter(['kategori'=>$filter_cat,'q'=>$search,'page'=>$page+1]);
            $qs = '?'.http_build_query($qa);
          ?>
          <a href="<?= BASE_URL ?>/blog/<?= $qs ?>" class="blg-page-btn">›</a>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php endif; ?>
      </div>

      <!-- ── SIDEBAR DESKTOP ── -->
      <aside class="blg-sidebar" style="position:sticky;top:96px;">
        <?php include __DIR__ . '/sections/blog-sidebar.php'; ?>
      </aside>

    </div>
  </div>
</section>

<!-- Sidebar mobile -->
<div id="blg-sidebar-mobile-wrap">
  <?php include __DIR__ . '/sections/blog-sidebar-mobile.php'; ?>
</div>
<style>@media(min-width:1024px){#blg-sidebar-mobile-wrap{display:none !important;}}</style>

<?php require __DIR__ . '/../includes/footer.php'; ?>