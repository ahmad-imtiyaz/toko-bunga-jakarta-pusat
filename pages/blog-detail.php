<?php
require_once __DIR__ . '/../includes/config.php';

if (empty($blog)) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$meta_title    = !empty($blog['meta_title'])    ? $blog['meta_title']    : $blog['title'] . ' - ' . setting('site_name');
$meta_desc     = !empty($blog['meta_desc'])     ? $blog['meta_desc']     : ($blog['excerpt'] ?? '');
$meta_keywords = !empty($blog['meta_keywords']) ? $blog['meta_keywords'] : $blog['title'];

$related = [];
if (!empty($blog['blog_category_id'])) {
    $stmt = db()->prepare("
        SELECT b.id, b.title, b.slug, b.thumbnail, b.excerpt, b.created_at,
               bc.name AS cat_name, bc.slug AS cat_slug
        FROM blogs b
        LEFT JOIN blog_categories bc ON b.blog_category_id = bc.id
        WHERE b.blog_category_id = ? AND b.id != ? AND b.status = 'active'
        ORDER BY b.created_at DESC LIMIT 3
    ");
    $stmt->execute([$blog['blog_category_id'], $blog['id']]);
    $related = $stmt->fetchAll();
}

$blog_cats = db()->query("
    SELECT bc.*, COUNT(b.id) AS total
    FROM blog_categories bc
    LEFT JOIN blogs b ON b.blog_category_id = bc.id AND b.status = 'active'
    WHERE bc.status = 'active'
    GROUP BY bc.id ORDER BY bc.urutan ASC
")->fetchAll();

$locations  = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url     = setting('whatsapp_url');
$filter_cat = $blog['cat_slug'] ?? '';

$thumb_url    = !empty($blog['thumbnail']) && file_exists(UPLOAD_DIR . $blog['thumbnail'])
                ? UPLOAD_URL . $blog['thumbnail']
                : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=1200&h=630&fit=crop';

$content_text = strip_tags($blog['content'] ?? '');
$read_min     = max(1, ceil(mb_strlen($content_text) / 1000));
$char_count   = mb_strlen($content_text);
$char_label   = $char_count >= 1000 ? round($char_count/1000,1).'k karakter' : $char_count.' karakter';
$updated      = $blog['updated_at'] ?? $blog['created_at'];

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

html, body { overflow-x: hidden !important; }
* { box-sizing: border-box; }

@keyframes det-shimmer-x {
  0%   { background-position: -200% center; }
  100% { background-position:  200% center; }
}
@keyframes det-float-petal {
  0%,100% { transform: translateY(0) rotate(0deg);   opacity: .25; }
  50%      { transform: translateY(-24px) rotate(12deg); opacity: .45; }
}
@keyframes det-ticker {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
@keyframes det-fade-up {
  from { opacity: 0; transform: translateY(22px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes det-pulse {
  0%   { transform: scale(1);   opacity: .6; }
  100% { transform: scale(2.2); opacity: 0; }
}

.det-rose-line {
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--sage), var(--parch-dd), var(--sage), transparent);
  background-size: 200% auto;
  animation: det-shimmer-x 3s linear infinite;
}
.det-float-petal {
  position: absolute; pointer-events: none; user-select: none;
  font-size: 15px;
  animation: det-float-petal var(--dur,7s) ease-in-out var(--del,0s) infinite;
  opacity: .25;
}
.det-ticker-inner { animation: det-ticker 22s linear infinite; display: flex; white-space: nowrap; }
.det-reveal   { animation: det-fade-up .6s ease both; }
.det-reveal-1 { animation-delay: .08s; }
.det-reveal-2 { animation-delay: .18s; }
.det-reveal-3 { animation-delay: .30s; }

/* ── Blog content ── */
.blog-content { word-break: break-word; overflow-wrap: break-word; max-width: 100%; }
.blog-content * { box-sizing: border-box; }
.blog-content img {
  max-width: 100%; height: auto; border-radius: 14px;
  margin: 1.5rem auto; display: block;
  border: 1px solid var(--border);
  box-shadow: 0 6px 24px rgba(28,43,26,.1);
}
.blog-content iframe, .blog-content video { max-width: 100% !important; border-radius: 12px; }
.blog-content table { display: block; width: 100%; overflow-x: auto; border-collapse: collapse; margin: 1.5rem 0; font-size: .82rem; }
.blog-content h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.5rem,5vw,2.1rem); font-weight: 900;
  color: var(--ink); margin: 1.75rem 0 .8rem; line-height: 1.2;
}
.blog-content h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.2rem,4vw,1.7rem); font-weight: 800;
  color: var(--ink); margin: 1.75rem 0 .8rem;
  border-bottom: 1px solid rgba(92,122,85,.18); padding-bottom: .55rem;
}
.blog-content h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1rem,3.5vw,1.35rem); font-weight: 700;
  color: var(--terra); margin: 1.5rem 0 .55rem;
}
.blog-content h4, .blog-content h5, .blog-content h6 {
  font-family: 'Cormorant Garamond', serif;
  font-weight: 700; color: var(--ink); margin: 1.1rem 0 .5rem;
}
.blog-content p  {
  margin: .8rem 0; line-height: 1.9;
  font-family: 'Jost', sans-serif;
  font-size: clamp(.9rem,2.5vw,1.02rem); font-weight: 300;
  color: var(--muted);
}
.blog-content ul, .blog-content ol { margin: .8rem 0 .8rem 1.4rem; }
.blog-content ul { list-style: disc; }
.blog-content ol { list-style: decimal; }
.blog-content li {
  margin: .35rem 0; line-height: 1.75;
  font-family: 'Jost', sans-serif;
  font-size: clamp(.88rem,2.5vw,1rem); font-weight: 300;
  color: var(--muted);
}
.blog-content strong { color: var(--ink); font-weight: 700; }
.blog-content em     { color: var(--terra); font-style: italic; }
.blog-content a      { color: var(--terra); text-decoration: underline; word-break: break-all; }
.blog-content a:hover { color: var(--terra-l); }
.blog-content blockquote {
  border-left: 3px solid var(--sage);
  background: rgba(92,122,85,.05);
  padding: .85rem 1.2rem; margin: 1.25rem 0;
  border-radius: 0 12px 12px 0;
  font-style: italic; color: var(--muted);
  font-family: 'Cormorant Garamond', serif; font-size: 1rem;
}
.blog-content th {
  background: rgba(92,122,85,.08); color: var(--sage);
  padding: 9px 12px; text-align: left; white-space: nowrap;
  border: 1px solid rgba(92,122,85,.18); font-weight: 700;
  font-family: 'Jost', sans-serif; font-size: .82rem;
}
.blog-content td { border: 1px solid rgba(28,43,26,.08); padding: 8px 12px; color: var(--muted); font-family: 'Jost', sans-serif; }
.blog-content tr:nth-child(even) td { background: rgba(92,122,85,.03); }
.blog-content pre {
  background: var(--parch-d); color: var(--ink);
  padding: 1.1rem; border-radius: 12px; overflow-x: auto;
  font-size: .8rem; margin: 1.5rem 0;
  border: 1px solid var(--parch-dd);
}
.blog-content code {
  background: rgba(92,122,85,.1); color: var(--terra);
  padding: 2px 6px; border-radius: 5px; font-size: .83em;
}
.blog-content pre code { background: none; color: inherit; padding: 0; }
.blog-content hr { border: none; border-top: 1px solid var(--parch-dd); margin: 2rem 0; }

/* Related card */
.det-related-card {
  border-radius: 14px; overflow: hidden;
  background: var(--leaf);
  border: 1px solid var(--parch-dd);
  text-decoration: none; display: block;
  transition: box-shadow .3s ease, transform .3s ease;
}
.det-related-card:hover {
  box-shadow: 0 16px 44px rgba(92,122,85,.18);
  transform: translateY(-4px);
}
.det-related-card img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .5s ease; display: block;
}
.det-related-card:hover img { transform: scale(1.06); }

/* Progress bar */
#read-progress {
  position: fixed; top: 0; left: 0; height: 3px;
  background: linear-gradient(90deg, var(--sage), var(--terra-l), var(--sage-l));
  z-index: 9999; width: 0; transition: width .1s ease;
}

@media(max-width:1023px) {
  .blog-det-sidebar-desktop { display: none !important; }
  .blog-det-grid { grid-template-columns: 1fr !important; }
}
</style>

<!-- Reading progress bar -->
<div id="read-progress"></div>

<div style="overflow-x:hidden;width:100%;max-width:100vw;">

<!-- ════ BREADCRUMB ════ -->
<div style="background:var(--parch-d);border-bottom:1px solid var(--border);">
  <div style="max-width:1280px;margin:0 auto;padding:12px 24px;">
    <nav style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-family:'Jost',sans-serif;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.09em;">
      <a href="<?= BASE_URL ?>/" style="color:var(--muted);text-decoration:none;transition:color .2s;"
         onmouseover="this.style.color='var(--terra)'" onmouseout="this.style.color='var(--muted)'">Beranda</a>
      <span style="color:var(--parch-dd);">—</span>
      <a href="<?= BASE_URL ?>/blog/" style="color:var(--muted);text-decoration:none;transition:color .2s;"
         onmouseover="this.style.color='var(--terra)'" onmouseout="this.style.color='var(--muted)'">Blog</a>
      <?php if(!empty($blog['cat_name'])): ?>
      <span style="color:var(--parch-dd);">—</span>
      <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($blog['cat_slug']) ?>"
         style="color:var(--sage);text-decoration:none;"><?= e($blog['cat_name']) ?></a>
      <?php endif; ?>
      <span style="color:var(--parch-dd);">—</span>
      <span style="color:var(--terra);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:200px;"><?= e($blog['title']) ?></span>
    </nav>
  </div>
</div>

<!-- ════ TICKER ════ -->
<div style="background:var(--ink);overflow:hidden;padding:9px 0;">
  <div class="det-ticker-inner">
    <?php for($r=0;$r<2;$r++): foreach($blog_cats as $bc): ?>
    <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($bc['slug']) ?>"
       style="display:inline-flex;align-items:center;gap:9px;margin:0 20px;
              color:rgba(244,239,228,.35);font-family:'Jost',sans-serif;
              font-size:10px;font-weight:600;text-transform:uppercase;
              letter-spacing:.11em;text-decoration:none;white-space:nowrap;
              flex-shrink:0;transition:color .2s;"
       onmouseover="this.style.color='var(--sage-l)'"
       onmouseout="this.style.color='rgba(244,239,228,.35)'">
      <span style="width:3px;height:3px;border-radius:50%;background:var(--sage);opacity:.55;flex-shrink:0;display:inline-block;"></span>
      <?= e($bc['name']) ?>
    </a>
    <?php endforeach; endfor; ?>
  </div>
</div>

<!-- ════ MAIN ════ -->
<section style="background:var(--parch);padding:44px 0 64px;">
  <div style="max-width:1280px;margin:0 auto;padding:0 24px;">
    <div class="blog-det-grid" style="display:grid;grid-template-columns:1fr 300px;gap:44px;align-items:start;">

      <!-- ══ ARTIKEL ══ -->
      <article style="min-width:0;max-width:100%;">

        <!-- ── Card utama ── -->
        <div class="det-reveal det-reveal-1"
             style="background:var(--leaf);border:1px solid var(--parch-dd);border-radius:24px;overflow:hidden;margin-bottom:22px;box-shadow:0 6px 32px rgba(28,43,26,.07);">

          <!-- Hero thumb -->
          <div style="width:100%;overflow:hidden;position:relative;" id="blog-hero-img">
            <?= blogPetalsDetInline(6) ?>
            <div style="aspect-ratio:16/7;max-height:440px;overflow:hidden;">
              <img src="<?= e($thumb_url) ?>" alt="<?= e($blog['title']) ?>"
                   style="width:100%;height:100%;object-fit:cover;display:block;">
            </div>
            <!-- Overlay gradient bawah -->
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(28,43,26,.65) 0%,transparent 50%);pointer-events:none;"></div>
            <!-- Title overlay -->
            <div style="position:absolute;bottom:0;left:0;right:0;padding:28px 32px;z-index:2;">
              <h1 style="font-family:'Cormorant Garamond',serif;font-weight:700;color:#fff;line-height:1.15;font-size:clamp(1.4rem,4vw,2.2rem);text-shadow:0 2px 14px rgba(0,0,0,.4);">
                <?= e($blog['title']) ?>
              </h1>
            </div>
            <div class="det-rose-line" style="position:absolute;bottom:0;left:0;right:0;z-index:3;"></div>
          </div>

          <div style="padding:28px 32px 38px;">

            <!-- Meta atas -->
            <div class="det-reveal det-reveal-2"
                 style="display:flex;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid var(--border);">

              <?php if(!empty($blog['cat_name'])): ?>
              <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($blog['cat_slug']) ?>"
                 style="font-family:'Jost',sans-serif;font-size:10px;font-weight:700;
                        background:rgba(92,122,85,.1);color:var(--sage);
                        border:1px solid rgba(92,122,85,.25);padding:5px 14px;
                        border-radius:999px;text-decoration:none;
                        text-transform:uppercase;letter-spacing:.08em;transition:all .2s;"
                 onmouseover="this.style.background='var(--sage)';this.style.color='var(--parch)';this.style.borderColor='transparent';"
                 onmouseout="this.style.background='rgba(92,122,85,.1)';this.style.color='var(--sage)';this.style.borderColor='rgba(92,122,85,.25)';">
                <?= e($blog['cat_name']) ?>
              </a>
              <?php endif; ?>

              <span style="display:inline-flex;align-items:center;gap:5px;font-family:'Jost',sans-serif;font-size:11px;font-weight:300;color:var(--muted);">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:.5;">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <?= date('d F Y', strtotime($blog['created_at'])) ?>
              </span>

              <span style="font-family:'Jost',sans-serif;font-size:11px;font-weight:600;
                           background:rgba(92,122,85,.08);color:var(--sage);
                           padding:4px 12px;border-radius:999px;">
                ⏱ <?= $read_min ?> mnt
              </span>
              <span style="font-family:'Jost',sans-serif;font-size:11px;font-weight:300;
                           background:rgba(92,122,85,.05);color:var(--muted);
                           padding:4px 12px;border-radius:999px;
                           border:1px solid var(--parch-dd);">
                <?= $char_label ?>
              </span>

              <!-- Share WA -->
              <div style="margin-left:auto;display:flex;gap:6px;">
                <a href="https://wa.me/?text=<?= urlencode($blog['title'].' '.BASE_URL.'/blog/'.$blog['slug'].'/') ?>"
                   target="_blank"
                   style="width:30px;height:30px;border-radius:50%;
                          background:rgba(92,122,85,.1);border:1px solid var(--border);
                          display:flex;align-items:center;justify-content:center;
                          text-decoration:none;transition:all .2s;"
                   onmouseover="this.style.background='#25D366';this.style.borderColor='#25D366';"
                   onmouseout="this.style.background='rgba(92,122,85,.1)';this.style.borderColor='var(--border)';">
                  <svg width="13" height="13" fill="#fff" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
                  </svg>
                </a>
              </div>
            </div>

            <!-- Excerpt -->
            <?php if(!empty($blog['excerpt'])): ?>
            <div class="det-reveal det-reveal-2"
                 style="background:rgba(92,122,85,.05);border-left:3px solid var(--sage);
                        padding:14px 20px;border-radius:0 14px 14px 0;margin-bottom:28px;">
              <p style="font-family:'Cormorant Garamond',serif;font-style:italic;
                        color:var(--muted);line-height:1.8;
                        font-size:clamp(.95rem,2.5vw,1.1rem);margin:0;">
                <?= e($blog['excerpt']) ?>
              </p>
            </div>
            <?php endif; ?>

            <!-- Konten -->
            <div class="blog-content det-reveal det-reveal-3" id="blog-content-area">
              <?= $blog['content'] ?>
            </div>

            <!-- Footer artikel -->
            <div class="det-reveal det-reveal-3"
                 style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border);
                        display:flex;align-items:center;justify-content:space-between;
                        flex-wrap:wrap;gap:12px;">
              <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-family:'Jost',sans-serif;font-size:11px;font-weight:300;color:rgba(28,43,26,.3);">Terakhir diperbarui:</span>
                <span style="font-family:'Jost',sans-serif;font-size:11px;font-weight:600;color:var(--terra);">
                  <?= date('d F Y, H:i', strtotime($updated)) ?> WIB
                </span>
              </div>
              <?php if(!empty($blog['cat_name'])): ?>
              <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($blog['cat_slug']) ?>"
                 style="font-family:'Jost',sans-serif;font-size:10px;font-weight:600;
                        text-transform:uppercase;letter-spacing:.08em;
                        color:var(--muted);text-decoration:none;
                        background:rgba(92,122,85,.07);padding:5px 14px;
                        border-radius:999px;border:1px solid var(--parch-dd);transition:all .2s;"
                 onmouseover="this.style.background='rgba(92,122,85,.14)';this.style.color='var(--sage)';"
                 onmouseout="this.style.background='rgba(92,122,85,.07)';this.style.color='var(--muted)';">
                ← Artikel <?= e($blog['cat_name']) ?>
              </a>
              <?php endif; ?>
            </div>

          </div>
        </div>

        <!-- ── CTA Banner ── -->
        <div class="det-reveal det-reveal-2"
             style="position:relative;overflow:hidden;
                    background:linear-gradient(135deg,rgba(92,122,85,.12) 0%,rgba(181,98,42,.08) 100%);
                    border:1px solid rgba(92,122,85,.25);border-radius:22px;
                    padding:32px;text-align:center;margin-bottom:30px;">
          <?= blogPetalsDetInline(8) ?>
          <div style="position:absolute;top:-50px;right:-50px;width:200px;height:200px;
                      background:radial-gradient(circle,rgba(138,174,129,.3),transparent 65%);
                      pointer-events:none;"></div>
          <div style="position:relative;z-index:2;">
            <div style="font-size:36px;margin-bottom:12px;">💐</div>
            <p style="font-family:'Cormorant Garamond',serif;font-size:clamp(1.2rem,3vw,1.5rem);
                      font-weight:700;color:var(--ink);margin-bottom:8px;">
              Butuh rangkaian bunga spesial?
            </p>
            <p style="font-family:'Jost',sans-serif;font-size:13px;font-weight:300;
                      color:var(--muted);margin-bottom:22px;line-height:1.7;">
              Konsultasi gratis dengan florist kami via WhatsApp — siap melayani 24 jam
            </p>
            <a href="<?= e($wa_url) ?>" target="_blank"
               style="display:inline-flex;align-items:center;gap:9px;
                      background:var(--ink);color:var(--parch);
                      font-family:'Jost',sans-serif;font-size:13px;font-weight:700;
                      padding:14px 32px;border-radius:999px;text-decoration:none;
                      letter-spacing:.04em;box-shadow:0 8px 24px rgba(28,43,26,.2);
                      transition:transform .2s ease,box-shadow .2s ease;"
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 32px rgba(28,43,26,.3)';"
               onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 24px rgba(28,43,26,.2)';">
              <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
              </svg>
              Pesan Sekarang
            </a>
          </div>
        </div>

        <!-- ── Artikel Terkait ── -->
        <?php if(!empty($related)): ?>
        <div class="det-reveal det-reveal-3">
          <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
            <div style="display:flex;align-items:center;gap:8px;">
              <span style="width:4px;height:4px;border-radius:50%;background:var(--sage);display:inline-block;"></span>
              <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;color:var(--ink);">Artikel Terkait</h2>
            </div>
            <div style="flex:1;height:1px;background:linear-gradient(90deg,rgba(92,122,85,.35),transparent);"></div>
          </div>
          <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            <?php foreach($related as $rel):
              $rel_thumb = !empty($rel['thumbnail']) && file_exists(UPLOAD_DIR.$rel['thumbnail'])
                           ? UPLOAD_URL.$rel['thumbnail']
                           : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=400&h=250&fit=crop';
            ?>
            <a href="<?= BASE_URL ?>/blog/<?= e($rel['slug']) ?>/" class="det-related-card">
              <div style="aspect-ratio:16/10;overflow:hidden;">
                <img src="<?= e($rel_thumb) ?>" alt="<?= e($rel['title']) ?>" loading="lazy">
              </div>
              <div style="padding:13px 15px 15px;background:var(--leaf);">
                <?php if($rel['cat_name']): ?>
                <span style="font-family:'Jost',sans-serif;font-size:9px;font-weight:700;
                             color:var(--sage);text-transform:uppercase;letter-spacing:.08em;">
                  <?= e($rel['cat_name']) ?>
                </span>
                <?php endif; ?>
                <h3 style="font-family:'Cormorant Garamond',serif;font-size:14px;font-weight:700;
                           color:var(--ink);line-height:1.35;margin-top:4px;
                           display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
                           line-clamp:2;overflow:hidden;">
                  <?= e($rel['title']) ?>
                </h3>
                <p style="font-family:'Jost',sans-serif;font-size:10px;font-weight:300;color:var(--muted);margin-top:6px;">
                  <?= date('d M Y', strtotime($rel['created_at'])) ?>
                </p>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

      </article>

      <!-- Sidebar desktop -->
      <aside class="blog-det-sidebar-desktop" style="position:sticky;top:90px;">
        <?php include __DIR__ . '/sections/blog-sidebar.php'; ?>
      </aside>

    </div>
  </div>
</section>

<!-- Sidebar mobile -->
<div id="blog-det-sidebar-mobile-wrap">
  <?php include __DIR__ . '/sections/blog-sidebar-mobile.php'; ?>
</div>
<style>@media(min-width:1024px){#blog-det-sidebar-mobile-wrap{display:none !important;}}</style>

</div>

<?php
function blogPetalsDetInline(int $n): string {
    $out = '';
    $fl  = ['🌿','🍃','✦','❋'];
    for ($i = 0; $i < $n; $i++) {
        $t   = rand(2, 92); $l = rand(2, 92);
        $dur = rand(6, 14); $del = rand(0, 8);
        $out .= "<span class=\"det-float-petal\" style=\"top:{$t}%;left:{$l}%;--dur:{$dur}s;--del:{$del}s;\">{$fl[$i%4]}</span>";
    }
    return $out;
}
?>

<script>
/* Reading progress bar */
(function(){
  const bar = document.getElementById('read-progress');
  const art = document.getElementById('blog-content-area');
  if (!bar || !art) return;
  window.addEventListener('scroll', function(){
    const rect   = art.getBoundingClientRect();
    const total  = art.offsetHeight + rect.top - window.innerHeight;
    const pct    = Math.max(0, Math.min(100, (-rect.top / total) * 100));
    bar.style.width = pct + '%';
  });
})();
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>