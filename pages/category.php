<?php
require_once __DIR__ . '/../includes/config.php';

$meta_title    = $category['meta_title']    ?: 'Toko Bunga Jakarta Pusat - ' . $category['name'];
$meta_desc     = $category['meta_description'] ?: '';
$meta_keywords = $category['name'] . ', toko bunga Jakarta Pusat, florist Jakarta Pusat';

$stmt = db()->prepare("SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.category_id = ? AND p.status='active' ORDER BY p.id");
$stmt->execute([$category['id']]);
$products = $stmt->fetchAll();

$all_cats_raw = db()->query("SELECT * FROM categories WHERE status='active' ORDER BY urutan ASC, id ASC")->fetchAll();
$all_cats = []; $all_cats_subs = [];
foreach ($all_cats_raw as $ac) {
    $pid = $ac['parent_id'] ?? null;
    if ($pid === null || $pid == 0) $all_cats[] = $ac;
    else $all_cats_subs[$pid][] = $ac;
}
$locations = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url    = setting('whatsapp_url');

$product_count = count($products);
$min_price     = !empty($products) ? min(array_column($products, 'price')) : 300000;

require __DIR__ . '/../includes/header.php';
?>

<style>
/* =======================================================
   CATEGORY PAGE — Hana no Yado | Karesansui Theme
   Warna: Night Sky #0f0d0a -> Sumi -> Tatami -> Washi
======================================================= */
@import url('https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400&family=Zen+Kaku+Gothic+New:wght@300;400&family=Cormorant+Garamond:ital,wght@0,300;1,300&display=swap');

:root {
  --night:    #0f0d0a;
  --sumi:     #1C1C1C;
  --washi:    #F5F0E8;
  --tatami:   #EDE8DF;
  --matcha:   #7A8C6E;
  --shiitake: #8B6F5E;
  --bamboo:   #C4A882;
  --blush:    #E8C4B8;
  --hanko:    #8B2020;
  --gold:     #C8A96E;
  --gold-lt:  #E8D5A3;
}

.washi-noise { position: relative; }
.washi-noise::after {
  content: ''; position: absolute; inset: 0; z-index: 0; pointer-events: none;
  opacity: .035;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
}
.tatami-bg {
  background-image:
    repeating-linear-gradient(0deg, transparent 0, transparent 39px, rgba(139,111,94,.1) 39px, rgba(139,111,94,.1) 40px),
    repeating-linear-gradient(90deg, transparent 0, transparent 39px, rgba(139,111,94,.1) 39px, rgba(139,111,94,.1) 40px);
}

@keyframes kanjiFloat {
  0%,100% { transform:translateY(0) rotate(0deg); opacity:.035; }
  33%     { transform:translateY(-14px) rotate(.4deg); opacity:.06; }
  66%     { transform:translateY(8px) rotate(-.3deg); opacity:.025; }
}
@keyframes softPulse {
  0%,100% { opacity:.5; transform:scale(1); }
  50%     { opacity:.8; transform:scale(1.06); }
}
@keyframes fadeUp {
  from { opacity:0; transform:translateY(22px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes ticker { from { transform:translateX(0); } to { transform:translateX(-50%); } }

.reveal   { animation: fadeUp .65s ease both; }
.reveal-1 { animation-delay:.06s; }
.reveal-2 { animation-delay:.16s; }
.reveal-3 { animation-delay:.28s; }
.reveal-4 { animation-delay:.42s; }

.cat-ticker-inner { animation: ticker 24s linear infinite; display:flex; white-space:nowrap; }

/* ── Rod kayu ── */
.hana-rod { position:relative; height:14px; }
.hana-rod .rod-bar {
  width:100%; height:14px; border-radius:7px;
  background: linear-gradient(180deg,#6B4F3A 0%,#8B6F5E 20%,#A0816E 45%,#7A5C4A 70%,#5C3D2B 100%);
  box-shadow: 0 4px 16px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.1);
}
.hana-rod::before, .hana-rod::after {
  content:''; position:absolute; top:50%; transform:translateY(-50%);
  width:22px; height:22px; border-radius:50%;
  background: radial-gradient(circle at 35% 35%,#F0D080 0%,#C8A96E 40%,#9B7A3A 80%,#6B4F20 100%);
  box-shadow: 0 3px 10px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.3); z-index:2;
}
.hana-rod::before { left:-6px; }
.hana-rod::after  { right:-6px; }

/* ── Stats batu ── */
.stat-stone {
  background: linear-gradient(180deg,#2e2520 0%,#1e1914 100%);
  border: 1px solid rgba(200,169,110,.2);
  position:relative; overflow:hidden;
  transition: transform .3s ease, box-shadow .3s ease;
}
.stat-stone::before {
  content:''; position:absolute; inset:0;
  background: radial-gradient(ellipse at 50% 0%,rgba(200,169,110,.08) 0%,transparent 65%);
}
.stat-stone:hover { transform:translateY(-4px); box-shadow:0 12px 30px rgba(0,0,0,.4); }

/* ── Brush stroke ── */
.brush-stroke { position:relative; display:inline-block; }
.brush-stroke::after {
  content:''; position:absolute; bottom:-8px; left:0; right:0;
  height:3px;
  background: linear-gradient(90deg,var(--hanko) 0%,rgba(139,32,32,.3) 70%,transparent 100%);
  border-radius:2px;
}

/* ── Kumo SVG section divider ── */
.section-kumo { position:relative; z-index:2; pointer-events:none; line-height:0; margin-top:-2px; }
.section-kumo svg { display:block; width:100%; }

/* ── Gold line ── */
.gold-line { height:1px; background:linear-gradient(90deg,transparent,rgba(200,169,110,.15),rgba(200,169,110,.4),rgba(200,169,110,.15),transparent); }

/* ── Product card ── */
.hana-prod-card {
  border-radius:4px; overflow:hidden;
  background:#1a1410; border:1px solid rgba(200,169,110,.1);
  transition: transform .35s ease, box-shadow .35s ease;
}
.hana-prod-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 48px rgba(0,0,0,.4), 0 0 0 1px rgba(200,169,110,.3);
}
.hana-prod-img { transition: transform .8s cubic-bezier(.25,.46,.45,.94); }
.hana-prod-card:hover .hana-prod-img { transform:scale(1.08); }

.shoji-overlay {
  position:absolute; inset:0;
  background:linear-gradient(180deg,rgba(15,13,10,0) 0%,rgba(15,13,10,0) 35%,rgba(15,13,10,.78) 70%,rgba(15,13,10,.94) 100%);
  z-index:5; pointer-events:none;
}
.shoji-content { position:absolute; bottom:0; left:0; right:0; padding:16px; z-index:10; }
.shoji-btn-wrap { overflow:hidden; max-height:0; transition:max-height .35s ease .08s; }
.hana-prod-card:hover .shoji-btn-wrap { max-height:60px; }

.prod-hanko {
  position:absolute; top:10px; right:10px;
  width:36px; height:36px; border-radius:3px;
  background:rgba(139,32,32,.85); border:1px solid rgba(139,32,32,.5);
  display:flex; align-items:center; justify-content:center;
  font-family:'Noto Serif JP',serif; font-size:11px; font-weight:200; color:rgba(255,255,255,.9);
  writing-mode:vertical-rl; letter-spacing:.05em; z-index:15;
  box-shadow:0 2px 8px rgba(0,0,0,.4);
  transition: transform .3s ease;
}
.hana-prod-card:hover .prod-hanko { transform:rotate(5deg) scale(1.05); }

/* ── Sidebar nav link ── */
.cat-nav-link {
  display:flex; align-items:center; justify-content:space-between;
  padding:9px 12px; border-radius:3px; text-decoration:none;
  font-size:13px; font-family:'Zen Kaku Gothic New',sans-serif; font-weight:300;
  color:rgba(245,240,232,.45); border:1px solid transparent;
  transition:all .25s ease; margin-bottom:2px;
}
.cat-nav-link:hover, .cat-nav-link.active {
  color:var(--gold-lt); background:rgba(200,169,110,.08);
  border-color:rgba(200,169,110,.2); padding-left:16px;
}
.cat-nav-link.active { color:var(--gold); }

.sidebar-acc-content { max-height:0; overflow:hidden; transition:max-height .35s ease; }
.sidebar-acc-content.open { max-height:600px; }
.sidebar-acc-btn.open .acc-chevron { transform:rotate(180deg); }

/* ── Area pill ── */
.area-pill {
  display:inline-flex; align-items:center; gap:6px; padding:6px 12px;
  border-radius:2px; font-size:12px; font-weight:300;
  font-family:'Zen Kaku Gothic New',sans-serif;
  border:1px solid rgba(139,111,94,.2); color:rgba(44,26,30,.5);
  text-decoration:none; background:rgba(139,111,94,.07);
  transition:all .25s ease;
}
.area-pill:hover { color:#2C1A1E; border-color:rgba(139,111,94,.5); transform:translateY(-1px); }

.sidebar-cta {
  background:linear-gradient(135deg,#0f0d0a,#1c1410);
  border:1px solid rgba(200,169,110,.2); border-radius:4px;
  position:relative; overflow:hidden;
}
.sidebar-cta::before {
  content:'注文'; position:absolute; bottom:-10px; right:8px;
  font-family:'Noto Serif JP',serif; font-size:80px; font-weight:200;
  color:rgba(200,169,110,.05); writing-mode:vertical-rl;
  user-select:none; pointer-events:none;
}

/* Keunggulan item */
.unggulan-item {
  display:flex; align-items:flex-start; gap:14px; padding:14px 18px;
  background:rgba(255,255,255,.65); border:1px solid rgba(139,111,94,.15);
  border-radius:3px; border-left:3px solid var(--hanko);
}

/* Info row */
.info-row {
  display:flex; justify-content:space-between; align-items:center; gap:8px;
  padding-bottom:8px; border-bottom:1px dashed rgba(139,111,94,.12);
}

/* Responsive */
@media (max-width:1023px) {
  .cat-layout { grid-template-columns:1fr !important; }
  .cat-sidebar { display:none; }
  .seo-layout  { grid-template-columns:1fr !important; }
}
@media (max-width:767px) {
  .prod-grid { grid-template-columns:repeat(2,1fr) !important; }
}
@media (max-width:480px) {
  .prod-grid { grid-template-columns:1fr !important; }
}
</style>

<!-- ════════════════ HERO ════════════════ -->
<section class="relative overflow-hidden washi-noise"
         style="min-height:540px; padding-top:100px;
                background:linear-gradient(160deg,#0f0d0a 0%,#1a1410 50%,#221810 100%);">

  <!-- Kanji dekoratif -->
  <div style="position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
    <span style="position:absolute;font-family:'Noto Serif JP',serif;font-weight:200;font-size:320px;top:-40px;right:-30px;color:rgba(245,240,232,.025);writing-mode:vertical-rl;animation:kanjiFloat 20s ease-in-out infinite;">花</span>
    <span style="position:absolute;font-family:'Noto Serif JP',serif;font-weight:200;font-size:180px;top:20%;left:3%;color:rgba(245,240,232,.02);writing-mode:vertical-rl;animation:kanjiFloat 16s ease-in-out infinite;animation-delay:4s;">縁</span>
    <span style="position:absolute;font-family:'Noto Serif JP',serif;font-weight:200;font-size:140px;bottom:0;left:42%;color:rgba(245,240,232,.025);writing-mode:vertical-rl;animation:kanjiFloat 22s ease-in-out infinite;animation-delay:8s;">美</span>
  </div>

  <!-- Glow -->
  <div style="position:absolute;width:500px;height:500px;top:-100px;right:-80px;border-radius:50%;background:radial-gradient(circle,rgba(200,169,110,.06) 0%,transparent 70%);animation:softPulse 10s ease-in-out infinite;z-index:0;pointer-events:none;"></div>

  <!-- Foto bg -->
  <?php if (!empty($category['image'])): ?>
  <div style="position:absolute;inset:0;z-index:1;">
    <div style="position:absolute;inset:0;background-image:url('<?= e(imgUrl($category['image'], 'category')) ?>');background-size:cover;background-position:center;"></div>
    <div style="position:absolute;inset:0;background:linear-gradient(105deg,rgba(15,13,10,.96) 0%,rgba(15,13,10,.82) 42%,rgba(15,13,10,.55) 68%,rgba(15,13,10,.3) 100%);"></div>
  </div>
  <?php endif; ?>

  <div class="gold-line" style="position:absolute;bottom:0;left:0;right:0;z-index:10;"></div>

  <!-- Breadcrumb -->
  <div style="position:relative;z-index:5;max-width:1280px;margin:0 auto;padding:0 24px 0;padding-top:4px;margin-bottom:40px;" class="reveal reveal-1">
    <nav style="display:flex;align-items:center;gap:8px;font-family:'Zen Kaku Gothic New',sans-serif;font-size:11px;letter-spacing:.15em;text-transform:uppercase;">
      <a href="<?= BASE_URL ?>/" style="color:rgba(245,240,232,.3);text-decoration:none;">花の宿</a>
      <span style="color:rgba(200,169,110,.25);">—</span>
      <span style="color:rgba(200,169,110,.65);"><?= e($category['name']) ?></span>
    </nav>
  </div>

  <!-- Konten -->
  <div style="position:relative;z-index:5;max-width:1280px;margin:0 auto;padding:0 24px 120px;">
    <div style="max-width:600px;">

      <div class="reveal reveal-1" style="display:inline-flex;align-items:center;gap:8px;padding:6px 16px;border:1px solid rgba(200,169,110,.28);border-radius:3px;background:rgba(200,169,110,.07);margin-bottom:20px;">
        <span style="width:6px;height:6px;border-radius:50%;background:var(--hanko);display:inline-block;animation:softPulse 2s ease-in-out infinite;"></span>
        <span style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:rgba(200,169,110,.8);">Florist Terpercaya · Jakarta Pusat</span>
      </div>

      <h1 class="reveal reveal-2 brush-stroke" style="font:300 clamp(2.4rem,5vw,3.8rem)/1.15 'Noto Serif JP',serif;color:var(--washi);margin-bottom:28px;letter-spacing:-.01em;">
        <?= e($category['name']) ?><br>
        <span style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:.65em;color:var(--bamboo);font-weight:300;">di Jakarta Pusat</span>
      </h1>

      <p class="reveal reveal-3" style="font:300 15px/1.9 'Zen Kaku Gothic New',sans-serif;color:rgba(245,240,232,.48);max-width:500px;margin-bottom:36px;">
        <?= !empty($category['meta_description']) ? e($category['meta_description']) : 'Toko bunga Jakarta Pusat menyediakan ' . e(strtolower($category['name'])) . ' berkualitas tinggi dengan bunga segar pilihan. Pesan sekarang, kirim cepat ke seluruh Jakarta Pusat.' ?>
      </p>

      <!-- Stats batu -->
      <div class="reveal reveal-3" style="display:flex;gap:2px;margin-bottom:36px;">
        <div class="stat-stone" style="flex:1;padding:16px 18px;border-radius:4px 0 0 4px;">
          <div style="font-family:'Noto Serif JP',serif;font-size:10px;font-weight:200;color:rgba(200,169,110,.45);letter-spacing:.2em;text-transform:uppercase;margin-bottom:6px;">品数</div>
          <div style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:300;color:var(--gold-lt);line-height:1;"><?= $product_count ?>+</div>
          <div style="font-size:10px;color:rgba(245,240,232,.28);margin-top:4px;font-family:'Zen Kaku Gothic New',sans-serif;">Produk</div>
        </div>
        <div class="stat-stone" style="flex:1;padding:16px 18px;">
          <div style="font-family:'Noto Serif JP',serif;font-size:10px;font-weight:200;color:rgba(200,169,110,.45);letter-spacing:.2em;text-transform:uppercase;margin-bottom:6px;">配達</div>
          <div style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:300;color:var(--gold-lt);line-height:1;">2–4<span style="font-size:15px;">Jam</span></div>
          <div style="font-size:10px;color:rgba(245,240,232,.28);margin-top:4px;font-family:'Zen Kaku Gothic New',sans-serif;">Pengiriman</div>
        </div>
        <div class="stat-stone" style="flex:1;padding:16px 18px;border-radius:0 4px 4px 0;">
          <div style="font-family:'Noto Serif JP',serif;font-size:10px;font-weight:200;color:rgba(200,169,110,.45);letter-spacing:.2em;text-transform:uppercase;margin-bottom:6px;">価格</div>
          <div style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:300;color:var(--gold-lt);line-height:1;"><?= 'Rp '.number_format($min_price/1000,0,',','.').'rb' ?></div>
          <div style="font-size:10px;color:rgba(245,240,232,.28);margin-top:4px;font-family:'Zen Kaku Gothic New',sans-serif;">Mulai dari</div>
        </div>
      </div>

      <!-- CTA -->
      <div class="reveal reveal-4" style="display:flex;flex-wrap:wrap;gap:12px;">
        <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan '.$category['name'].' di Jakarta Pusat.') ?>"
           target="_blank"
           style="display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#2d6a32,#1a4a1e);color:#a8d8ac;padding:13px 28px;border-radius:3px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:13px;letter-spacing:.05em;border:1px solid rgba(168,216,172,.2);transition:all .3s ease;box-shadow:0 4px 16px rgba(0,0,0,.3);"
           onmouseover="this.style.transform='translateY(-2px)';this.style.color='#c8e8ca'" onmouseout="this.style.transform='';this.style.color='#a8d8ac'">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
          Pesan Sekarang
        </a>
        <a href="#produk"
           style="display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(200,169,110,.28);color:rgba(200,169,110,.65);padding:13px 22px;border-radius:3px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:13px;letter-spacing:.05em;transition:all .3s ease;"
           onmouseover="this.style.borderColor='rgba(200,169,110,.6)';this.style.color='var(--gold-lt)'" onmouseout="this.style.borderColor='rgba(200,169,110,.28)';this.style.color='rgba(200,169,110,.65)'">
          Lihat Produk ↓
        </a>
      </div>

    </div>
  </div>
</section>

<!-- KUMO Hero → Ticker -->
<div class="section-kumo">
  <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,60 L1440,60 L1440,0 L0,0 Z" fill="#1a1208"/>
    <ellipse cx="60"  cy="15" rx="75" ry="22" fill="#1a1208"/>
    <ellipse cx="155" cy="7"  rx="60" ry="18" fill="#1a1208"/>
    <ellipse cx="225" cy="16" rx="70" ry="20" fill="#1a1208"/>
    <ellipse cx="308" cy="5"  rx="58" ry="17" fill="#1a1208"/>
    <ellipse cx="376" cy="14" rx="72" ry="21" fill="#1a1208"/>
    <ellipse cx="454" cy="4"  rx="65" ry="19" fill="#1a1208"/>
    <ellipse cx="526" cy="15" rx="68" ry="20" fill="#1a1208"/>
    <ellipse cx="614" cy="7"  rx="78" ry="22" fill="#1a1208"/>
    <ellipse cx="700" cy="17" rx="70" ry="22" fill="#1a1208"/>
    <ellipse cx="780" cy="5"  rx="60" ry="18" fill="#1a1208"/>
    <ellipse cx="852" cy="14" rx="74" ry="21" fill="#1a1208"/>
    <ellipse cx="934" cy="4"  rx="65" ry="18" fill="#1a1208"/>
    <ellipse cx="1006" cy="14" rx="78" ry="22" fill="#1a1208"/>
    <ellipse cx="1090" cy="6"  rx="66" ry="19" fill="#1a1208"/>
    <ellipse cx="1162" cy="16" rx="72" ry="21" fill="#1a1208"/>
    <ellipse cx="1250" cy="7"  rx="64" ry="18" fill="#1a1208"/>
    <ellipse cx="1325" cy="14" rx="76" ry="22" fill="#1a1208"/>
    <ellipse cx="1410" cy="5"  rx="62" ry="18" fill="#1a1208"/>
  </svg>
</div>

<!-- ════════════════ TICKER ════════════════ -->
<div style="overflow:hidden;padding:10px 0;background:#1a1208;border-top:1px solid rgba(200,169,110,.12);border-bottom:1px solid rgba(200,169,110,.12);">
  <div class="cat-ticker-inner">
    <?php for ($r=0;$r<2;$r++): ?>
    <?php foreach ($all_cats as $c): ?>
    <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/"
       style="display:inline-flex;align-items:center;gap:10px;margin:0 28px;font-family:'Noto Serif JP',serif;font-size:11px;font-weight:200;letter-spacing:.25em;text-transform:uppercase;color:rgba(200,169,110,.5);text-decoration:none;flex-shrink:0;transition:color .2s;"
       onmouseover="this.style.color='rgba(200,169,110,.9)'" onmouseout="this.style.color='rgba(200,169,110,.5)'">
      <span style="color:rgba(139,32,32,.55);">✦</span>
      <?= e($c['name']) ?>
    </a>
    <?php endforeach; ?>
    <?php endfor; ?>
  </div>
</div>

<!-- ════════════════ PRODUK + SIDEBAR ════════════════ -->
<section id="produk" class="relative washi-noise" style="background:linear-gradient(180deg,#1a1208 0%,#0f0d0a 100%);">

  <div style="position:absolute;width:600px;height:600px;top:10%;right:-100px;border-radius:50%;background:radial-gradient(circle,rgba(200,169,110,.04) 0%,transparent 70%);z-index:0;pointer-events:none;"></div>

  <div style="position:relative;z-index:1;max-width:1280px;margin:0 auto;padding:64px 24px 80px;">

    <div class="hana-rod" style="margin-bottom:48px;"><div class="rod-bar"></div></div>

    <div class="cat-layout" style="display:grid;grid-template-columns:260px 1fr;gap:48px;align-items:start;">

      <!-- SIDEBAR -->
      <aside class="cat-sidebar" style="position:sticky;top:100px;">

        <div style="background:rgba(28,22,16,.85);border:1px solid rgba(200,169,110,.12);border-radius:4px;padding:22px;margin-bottom:14px;">
          <div style="font-family:'Noto Serif JP',serif;font-weight:200;font-size:11px;letter-spacing:.25em;text-transform:uppercase;color:rgba(200,169,110,.45);margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid rgba(200,169,110,.08);">
            花 &nbsp;Layanan Kami
          </div>
          <nav>
            <?php foreach ($all_cats as $c):
              $c_subs   = $all_cats_subs[$c['id']] ?? [];
              $has_subs = !empty($c_subs);
              $is_active = $c['id']==$category['id'] || (isset($category['parent_id'])&&$category['parent_id']==$c['id']);
            ?>
            <?php if ($has_subs): ?>
            <div style="margin-bottom:2px;">
              <button onclick="toggleAcc(this)" class="sidebar-acc-btn"
                      style="display:flex;align-items:center;justify-content:space-between;width:100%;text-align:left;padding:9px 12px;border-radius:3px;background:<?= $is_active?'rgba(200,169,110,.1)':'transparent' ?>;border:1px solid <?= $is_active?'rgba(200,169,110,.2)':'transparent' ?>;cursor:pointer;font-family:'Zen Kaku Gothic New',sans-serif;font-size:13px;font-weight:300;color:<?= $is_active?'var(--gold)':'rgba(245,240,232,.45)' ?>;transition:all .25s ease;">
                <?= e($c['name']) ?>
                <svg class="acc-chevron" style="width:12px;height:12px;flex-shrink:0;transition:transform .3s ease;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>
              <div class="sidebar-acc-content <?= $is_active?'open':'' ?>" style="padding-left:12px;margin:4px 0;border-left:2px solid rgba(200,169,110,.12);">
                <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" style="display:block;padding:5px 10px;font-size:11px;color:var(--hanko);opacity:.65;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;letter-spacing:.05em;">Lihat semua →</a>
                <?php foreach ($c_subs as $sub):
                  $is_sub = $sub['id']==$category['id']; ?>
                <a href="<?= BASE_URL ?>/<?= e($sub['slug']) ?>/" class="cat-nav-link <?= $is_sub?'active':'' ?>">
                  <span><?= e($sub['name']) ?></span>
                  <?php if ($is_sub): ?><span style="color:var(--hanko);font-size:11px;">▸</span><?php endif; ?>
                </a>
                <?php endforeach; ?>
              </div>
            </div>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/" class="cat-nav-link <?= $is_active?'active':'' ?>">
              <?= e($c['name']) ?>
              <svg style="width:11px;height:11px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
          </nav>
        </div>

        <div class="sidebar-cta" style="padding:24px;text-align:center;">
          <div style="font-size:32px;margin-bottom:12px;">🏮</div>
          <p style="font-family:'Noto Serif JP',serif;font-weight:300;font-size:16px;color:var(--gold-lt);margin-bottom:8px;letter-spacing:.05em;">Butuh Bantuan?</p>
          <p style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:12px;font-weight:300;color:rgba(245,240,232,.38);margin-bottom:18px;line-height:1.7;">Konsultasi gratis 24 jam,<br>pengiriman ke seluruh Jakarta</p>
          <a href="<?= e($wa_url) ?>" target="_blank"
             style="display:flex;align-items:center;justify-content:center;gap:8px;background:linear-gradient(135deg,#2d6a32,#1a4a1e);color:#a8d8ac;padding:11px 16px;border-radius:3px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:12px;letter-spacing:.05em;border:1px solid rgba(168,216,172,.2);transition:all .3s ease;"
             onmouseover="this.style.color='#c8e8ca'" onmouseout="this.style.color='#a8d8ac'">
            <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Chat WhatsApp
          </a>
        </div>

      </aside>

      <!-- PRODUK -->
      <div>
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:30px;flex-wrap:wrap;">
          <div>
            <div style="font-family:'Noto Serif JP',serif;font-size:11px;font-weight:200;letter-spacing:.25em;text-transform:uppercase;color:rgba(200,169,110,.45);margin-bottom:10px;">品 · Koleksi <?= e($category['name']) ?></div>
            <h2 style="font:300 clamp(1.6rem,3vw,2.4rem)/1.2 'Noto Serif JP',serif;color:var(--washi);letter-spacing:-.01em;">
              <?= $product_count ?> <span style="color:var(--bamboo);font-weight:200;">Produk Tersedia</span>
            </h2>
          </div>
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin melihat katalog '.$category['name'].' lengkap.') ?>"
             target="_blank"
             style="display:inline-flex;align-items:center;gap:8px;border:1px solid rgba(200,169,110,.22);color:rgba(200,169,110,.65);padding:10px 18px;border-radius:3px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:12px;letter-spacing:.05em;flex-shrink:0;transition:all .3s ease;"
             onmouseover="this.style.borderColor='rgba(200,169,110,.5)';this.style.color='var(--gold-lt)'" onmouseout="this.style.borderColor='rgba(200,169,110,.22)';this.style.color='rgba(200,169,110,.65)'">
            Katalog via WA →
          </a>
        </div>

        <?php if (!empty($products)): ?>
        <div class="prod-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
          <?php foreach ($products as $prod):
            $img     = imgUrl($prod['image'],'product');
            $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga ".rupiah($prod['price']).". Apakah masih tersedia?");
          ?>
          <div class="hana-prod-card">
            <div style="position:relative;overflow:hidden;aspect-ratio:3/4;">
              <img src="<?= e($img) ?>" alt="<?= e($prod['name']) ?> Jakarta Pusat"
                   class="hana-prod-img" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
              <div class="shoji-overlay"></div>
              <?php if (!empty($prod['cat_name'])): ?>
              <span style="position:absolute;top:10px;left:10px;font-family:'Zen Kaku Gothic New',sans-serif;font-size:10px;letter-spacing:.12em;text-transform:uppercase;padding:4px 10px;background:rgba(15,13,10,.8);border:1px solid rgba(200,169,110,.22);color:rgba(200,169,110,.65);backdrop-filter:blur(8px);z-index:15;border-radius:2px;"><?= e($prod['cat_name']) ?></span>
              <?php endif; ?>
              <div class="prod-hanko">花</div>
              <div class="shoji-content">
                <h3 style="font:300 14px/1.4 'Noto Serif JP',serif;color:var(--washi);margin-bottom:4px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;"><?= e($prod['name']) ?></h3>
                <div style="font-family:'Cormorant Garamond',serif;font-size:16px;color:var(--bamboo);font-weight:300;margin-bottom:8px;"><?= rupiah($prod['price']) ?></div>
                <div class="shoji-btn-wrap">
                  <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank"
                     style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#2d6a32,#1a4a1e);color:#a8d8ac;padding:8px 16px;border-radius:3px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:11px;letter-spacing:.05em;border:1px solid rgba(168,216,172,.18);transition:all .3s ease;margin-top:2px;">
                    <svg width="11" height="11" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
                    Pesan via WA
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div style="text-align:center;padding:80px 20px;">
          <div style="font-family:'Noto Serif JP',serif;font-size:48px;color:rgba(200,169,110,.2);margin-bottom:16px;">花</div>
          <p style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:15px;color:rgba(245,240,232,.3);margin-bottom:24px;">Produk sedang dipersiapkan</p>
          <a href="<?= e($wa_url) ?>" target="_blank"
             style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#2d6a32,#1a4a1e);color:#a8d8ac;padding:12px 24px;border-radius:3px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:13px;letter-spacing:.05em;border:1px solid rgba(168,216,172,.2);">
            Tanya via WhatsApp
          </a>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>

<!-- KUMO Produk → SEO (gelap → tatami) -->
<div class="section-kumo">
  <svg viewBox="0 0 1440 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,100 L1440,100 L1440,0 L0,0 Z" fill="#EDE8DF"/>
    <ellipse cx="72"  cy="22" rx="88"  ry="28" fill="#EDE8DF"/>
    <ellipse cx="168" cy="10" rx="72"  ry="23" fill="#EDE8DF"/>
    <ellipse cx="250" cy="24" rx="82"  ry="27" fill="#EDE8DF"/>
    <ellipse cx="340" cy="8"  rx="66"  ry="21" fill="#EDE8DF"/>
    <ellipse cx="415" cy="20" rx="86"  ry="26" fill="#EDE8DF"/>
    <ellipse cx="504" cy="7"  rx="70"  ry="22" fill="#EDE8DF"/>
    <ellipse cx="578" cy="22" rx="80"  ry="26" fill="#EDE8DF"/>
    <ellipse cx="666" cy="10" rx="92"  ry="28" fill="#EDE8DF"/>
    <ellipse cx="760" cy="22" rx="78"  ry="27" fill="#EDE8DF"/>
    <ellipse cx="845" cy="7"  rx="68"  ry="21" fill="#EDE8DF"/>
    <ellipse cx="916" cy="20" rx="84"  ry="26" fill="#EDE8DF"/>
    <ellipse cx="1002" cy="7"  rx="72" ry="22" fill="#EDE8DF"/>
    <ellipse cx="1078" cy="20" rx="90" ry="28" fill="#EDE8DF"/>
    <ellipse cx="1170" cy="8"  rx="76" ry="23" fill="#EDE8DF"/>
    <ellipse cx="1248" cy="22" rx="82" ry="26" fill="#EDE8DF"/>
    <ellipse cx="1338" cy="9"  rx="70" ry="21" fill="#EDE8DF"/>
    <ellipse cx="1408" cy="20" rx="86" ry="27" fill="#EDE8DF"/>
  </svg>
</div>

<!-- ════════════════ SEO CONTENT — Tatami ════════════════ -->
<section class="relative tatami-bg" style="background:#EDE8DF;padding:72px 0;overflow:hidden;">

  <div style="position:absolute;inset:0;pointer-events:none;overflow:hidden;z-index:0;">
    <span style="position:absolute;font-family:'Noto Serif JP',serif;font-weight:200;font-size:260px;top:-20px;right:-20px;color:rgba(139,111,94,.07);writing-mode:vertical-rl;animation:kanjiFloat 18s ease-in-out infinite;">宿</span>
    <span style="position:absolute;font-family:'Noto Serif JP',serif;font-weight:200;font-size:180px;bottom:0;left:4%;color:rgba(139,111,94,.05);writing-mode:vertical-rl;animation:kanjiFloat 22s ease-in-out infinite;animation-delay:6s;">縁</span>
  </div>

  <div style="position:relative;z-index:1;max-width:1280px;margin:0 auto;padding:0 24px;">
    <div class="seo-layout" style="display:grid;grid-template-columns:1fr 340px;gap:56px;align-items:start;">

      <!-- Kiri: SEO prose -->
      <div>
        <div class="hana-rod" style="margin-bottom:32px;"><div class="rod-bar"></div></div>

        <div style="display:inline-flex;align-items:center;gap:8px;padding:5px 14px;border:1px solid rgba(139,111,94,.28);border-radius:2px;background:rgba(139,111,94,.08);margin-bottom:18px;">
          <span style="width:5px;height:5px;border-radius:50%;background:var(--hanko);display:inline-block;"></span>
          <span style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:10px;letter-spacing:.2em;text-transform:uppercase;color:var(--shiitake);">Tentang Layanan</span>
        </div>

        <h2 class="brush-stroke" style="font:300 clamp(1.8rem,3vw,2.8rem)/1.2 'Noto Serif JP',serif;color:#2C1A1E;margin-bottom:28px;letter-spacing:-.01em;">
          <?= e($category['name']) ?> Terbaik<br>
          <span style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:.72em;color:var(--shiitake);font-weight:300;">di Jakarta Pusat</span>
        </h2>

        <?php if (!empty($category['content'])): ?>
        <div style="font:300 15px/1.9 'Zen Kaku Gothic New',sans-serif;color:rgba(44,26,30,.62);margin-bottom:26px;"><?= $category['content'] ?></div>
        <?php endif; ?>

        <p style="font:300 15px/1.9 'Zen Kaku Gothic New',sans-serif;color:rgba(44,26,30,.58);margin-bottom:32px;">
          Kami sebagai <strong style="color:#2C1A1E;font-weight:400;">florist Jakarta Pusat</strong> terpercaya menyediakan
          <?= e(strtolower($category['name'])) ?> berkualitas tinggi dengan harga terjangkau. Setiap rangkaian dibuat oleh tim florist profesional menggunakan bunga segar pilihan.
        </p>

        <h3 style="font:300 22px/1.3 'Noto Serif JP',serif;color:#2C1A1E;margin-bottom:18px;padding-bottom:10px;border-bottom:1px solid rgba(139,111,94,.18);">Mengapa Memilih Kami?</h3>

        <?php
        $keunggulan = [
          'Bunga 100% segar berkualitas premium',
          'Pengiriman cepat 2–4 jam ke seluruh Jakarta Pusat',
          'Harga transparan mulai '.rupiah($min_price),
          'Desain custom sesuai keinginan Anda',
          'Melayani pesanan mendadak 24 jam',
        ];
        ?>
        <div style="display:grid;gap:10px;margin-bottom:32px;">
          <?php foreach ($keunggulan as $k): ?>
          <div class="unggulan-item">
            <span style="color:var(--hanko);font-size:9px;margin-top:4px;flex-shrink:0;">✦</span>
            <span style="font:300 14px/1.65 'Zen Kaku Gothic New',sans-serif;color:rgba(44,26,30,.62);"><?= $k ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <h3 style="font:300 22px/1.3 'Noto Serif JP',serif;color:#2C1A1E;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid rgba(139,111,94,.18);">Cara Memesan</h3>
        <p style="font:300 14px/1.85 'Zen Kaku Gothic New',sans-serif;color:rgba(44,26,30,.58);margin-bottom:28px;">
          Hubungi kami via WhatsApp di <strong style="color:#2C1A1E;font-weight:400;"><?= e(setting('phone_display')) ?></strong> —
          informasikan jenis bunga, alamat, tanggal & jam pengiriman, serta pesan yang ingin dituliskan. Mudah, cepat, bunga langsung dikirim!
        </p>

        <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan '.$category['name'].' di Jakarta Pusat.') ?>"
           target="_blank"
           style="display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#2d6a32,#1a4a1e);color:#a8d8ac;padding:13px 26px;border-radius:3px;text-decoration:none;font-family:'Zen Kaku Gothic New',sans-serif;font-size:13px;letter-spacing:.05em;border:1px solid rgba(168,216,172,.18);transition:all .3s ease;box-shadow:0 4px 14px rgba(0,0,0,.12);"
           onmouseover="this.style.transform='translateY(-2px)';this.style.color='#c8e8ca'" onmouseout="this.style.transform='';this.style.color='#a8d8ac'">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
          Chat WhatsApp Sekarang
        </a>
      </div>

      <!-- Kanan: Info boxes -->
      <div style="display:flex;flex-direction:column;gap:14px;">

        <!-- Area -->
        <div style="background:rgba(255,255,255,.72);border:1px solid rgba(139,111,94,.2);border-radius:4px;padding:22px;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid rgba(139,111,94,.14);">
            <span style="font-family:'Noto Serif JP',serif;font-size:18px;color:rgba(139,111,94,.55);">地</span>
            <span style="font-family:'Noto Serif JP',serif;font-weight:300;font-size:15px;color:#2C1A1E;letter-spacing:.04em;">Area Pengiriman</span>
          </div>
          <p style="font:300 12px/1.7 'Zen Kaku Gothic New',sans-serif;color:rgba(44,26,30,.5);margin-bottom:14px;">
            Melayani pengiriman ke seluruh kecamatan di Jakarta Pusat:
          </p>
          <div style="display:flex;flex-wrap:wrap;gap:7px;">
            <?php foreach ($locations as $l): ?>
            <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/" class="area-pill">
              <span style="width:4px;height:4px;border-radius:50%;background:var(--hanko);display:inline-block;flex-shrink:0;"></span>
              <?= e($l['name']) ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Info -->
        <div style="background:rgba(255,255,255,.72);border:1px solid rgba(139,111,94,.2);border-radius:4px;padding:22px;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid rgba(139,111,94,.14);">
            <span style="font-family:'Noto Serif JP',serif;font-size:18px;color:rgba(139,111,94,.55);">心</span>
            <span style="font-family:'Noto Serif JP',serif;font-weight:300;font-size:15px;color:#2C1A1E;letter-spacing:.04em;">Info Pemesanan</span>
          </div>
          <?php
          $info = [
            ['label'=>'Jam Operasional','val'=>setting('jam_buka')?:'24 Jam / 7 Hari'],
            ['label'=>'Estimasi Kirim', 'val'=>'2–4 Jam setelah konfirmasi'],
            ['label'=>'Min. Pesan',     'val'=>rupiah($min_price)],
            ['label'=>'Pembayaran',     'val'=>'Transfer / COD tersedia'],
          ];
          ?>
          <div style="display:flex;flex-direction:column;gap:9px;">
            <?php foreach ($info as $i): ?>
            <div class="info-row">
              <span style="font:300 12px/1 'Zen Kaku Gothic New',sans-serif;color:rgba(44,26,30,.42);"><?= $i['label'] ?></span>
              <span style="font:400 12px/1 'Zen Kaku Gothic New',sans-serif;color:#2C1A1E;"><?= $i['val'] ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- KUMO bawah SEO → footer (tatami → night) -->
<div class="section-kumo">
  <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,80 L1440,80 L1440,0 L0,0 Z" fill="#0f0d0a"/>
    <ellipse cx="80"  cy="18" rx="90"  ry="28" fill="#0f0d0a"/>
    <ellipse cx="172" cy="7"  rx="72"  ry="22" fill="#0f0d0a"/>
    <ellipse cx="250" cy="20" rx="82"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="338" cy="6"  rx="65"  ry="20" fill="#0f0d0a"/>
    <ellipse cx="410" cy="18" rx="86"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="498" cy="5"  rx="70"  ry="21" fill="#0f0d0a"/>
    <ellipse cx="572" cy="18" rx="78"  ry="25" fill="#0f0d0a"/>
    <ellipse cx="658" cy="7"  rx="90"  ry="27" fill="#0f0d0a"/>
    <ellipse cx="750" cy="20" rx="76"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="832" cy="5"  rx="68"  ry="20" fill="#0f0d0a"/>
    <ellipse cx="902" cy="17" rx="82"  ry="25" fill="#0f0d0a"/>
    <ellipse cx="988" cy="4"  rx="70"  ry="21" fill="#0f0d0a"/>
    <ellipse cx="1060" cy="16" rx="88" ry="26" fill="#0f0d0a"/>
    <ellipse cx="1148" cy="6"  rx="74" ry="22" fill="#0f0d0a"/>
    <ellipse cx="1224" cy="18" rx="80" ry="25" fill="#0f0d0a"/>
    <ellipse cx="1312" cy="6"  rx="70" ry="21" fill="#0f0d0a"/>
    <ellipse cx="1388" cy="17" rx="86" ry="27" fill="#0f0d0a"/>
  </svg>
</div>

<script>
function toggleAcc(btn) {
  const content = btn.nextElementSibling;
  const isOpen  = content.classList.contains('open');
  document.querySelectorAll('.sidebar-acc-content.open').forEach(el => el.classList.remove('open'));
  document.querySelectorAll('.sidebar-acc-btn.open').forEach(el => el.classList.remove('open'));
  if (!isOpen) { btn.classList.add('open'); content.classList.add('open'); }
}
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.sidebar-acc-content.open').forEach(el => {
    el.previousElementSibling?.classList.add('open');
  });
});
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>