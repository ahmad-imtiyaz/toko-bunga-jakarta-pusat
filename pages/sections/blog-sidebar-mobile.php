<?php
// blog-sidebar-mobile.php — Sage Forest × Parchment theme (selaras dengan blog/index.php)

$mob_categories = db()->query("
    SELECT * FROM categories
    WHERE status = 'active' AND (parent_id IS NULL OR parent_id = 0)
    ORDER BY urutan ASC, id ASC
")->fetchAll();

$mob_products = db()->query("
    SELECT p.* FROM products p
    WHERE p.status = 'active'
    ORDER BY p.id ASC LIMIT 20
")->fetchAll();
?>

<style>
/* ══════════════════════════════════════════
   MOBILE SIDEBAR — Sage Forest × Parchment
══════════════════════════════════════════ */
.mob-sb-wrap {
  background: var(--parch-d);
  border-top: 1px solid var(--parch-dd);
  padding: 32px 20px 52px;
}
.mob-sb-inner {
  max-width: 640px; margin: 0 auto;
  display: flex; flex-direction: column; gap: 18px;
}
.mob-sb-section {
  background: var(--leaf);
  border: 1px solid var(--parch-dd);
  border-radius: 16px; overflow: hidden;
  box-shadow: 0 2px 14px rgba(28,43,26,.05);
}
.mob-sb-section-head {
  padding: 13px 18px 10px; border-bottom: 1px solid var(--parch-dd);
  display: flex; align-items: center; justify-content: space-between;
}
.mob-sb-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px; font-weight: 700; color: var(--ink);
}
.mob-sb-nav {
  width: 26px; height: 26px; border-radius: 50%;
  background: rgba(92,122,85,.08);
  border: 1px solid rgba(92,122,85,.22);
  color: var(--sage); font-size: 15px; font-weight: 600;
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  transition: all .2s; line-height: 1;
}
.mob-sb-nav:hover { background: var(--ink); color: var(--parch); border-color: var(--ink); }

.mob-cat-pill {
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 600;
  padding: 5px 14px; border-radius: 999px;
  text-transform: uppercase; letter-spacing: .07em;
  text-decoration: none; transition: all .25s; white-space: nowrap;
}

/* Prod scroll */
#mob-prod-list-tng::-webkit-scrollbar { width: 3px; }
#mob-prod-list-tng::-webkit-scrollbar-track { background: rgba(92,122,85,.06); border-radius: 3px; }
#mob-prod-list-tng::-webkit-scrollbar-thumb { background: rgba(92,122,85,.3); border-radius: 3px; }

.mob-prod-item-tng {
  display: flex; align-items: center; gap: 10px; padding: 9px 10px;
  border-radius: 10px; text-decoration: none; margin-bottom: 2px;
  transition: background .2s;
}
.mob-prod-item-tng:hover { background: rgba(92,122,85,.07); }

.mob-area-tag {
  display: inline-flex; align-items: center; gap: 5px;
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 400; color: var(--muted);
  text-decoration: none; padding: 5px 12px; border-radius: 999px;
  background: rgba(92,122,85,.06); border: 1px solid var(--parch-dd);
  transition: all .2s;
}
.mob-area-tag:hover { background: rgba(92,122,85,.14); color: var(--sage); border-color: rgba(92,122,85,.3); }
</style>

<div class="mob-sb-wrap">
  <div class="mob-sb-inner">

    <!-- ── 1. CTA WhatsApp ── -->
    <div style="position:relative;overflow:hidden;
                background:linear-gradient(135deg,rgba(92,122,85,.14),rgba(181,98,42,.07));
                border:1px solid rgba(92,122,85,.28);border-radius:16px;
                padding:26px;text-align:center;">
      <div style="position:absolute;top:-40px;right:-40px;width:140px;height:140px;
                  background:radial-gradient(circle,rgba(138,174,129,.35),transparent 65%);
                  pointer-events:none;"></div>
      <div style="position:relative;z-index:2;">
        <div style="font-size:32px;margin-bottom:10px;">💬</div>
        <p style="font-family:'Cormorant Garamond',serif;font-weight:700;color:var(--ink);
                  font-size:19px;margin-bottom:5px;">Mau Pesan Bunga?</p>
        <p style="font-family:'Jost',sans-serif;font-size:13px;font-weight:300;
                  color:var(--muted);margin-bottom:18px;line-height:1.6;">
          Konsultasi gratis via WhatsApp.<br>Siap 24 jam!
        </p>
        <a href="<?= e($wa_url) ?>" target="_blank"
           style="display:block;background:var(--ink);color:var(--parch);
                  font-family:'Jost',sans-serif;font-size:13px;font-weight:700;
                  padding:14px;border-radius:999px;text-decoration:none;
                  box-shadow:0 6px 18px rgba(28,43,26,.18);letter-spacing:.04em;">
          Chat WhatsApp Sekarang
        </a>
      </div>
    </div>

    <!-- ── 2. Slider Kategori Bunga (3 per page mobile) ── -->
    <?php if(!empty($mob_categories)): ?>
    <div class="mob-sb-section">
      <div class="mob-sb-section-head">
        <h3 class="mob-sb-title">Kategori Bunga</h3>
        <div style="display:flex;gap:5px;">
          <button class="mob-sb-nav" onclick="slideCatMobTng(-1)">‹</button>
          <button class="mob-sb-nav" onclick="slideCatMobTng(1)">›</button>
        </div>
      </div>
      <div style="padding:12px;">
        <div style="overflow:hidden;" id="cat-mob-track-tng">
          <div id="cat-mob-inner-tng"
               style="display:flex;gap:8px;transition:transform .35s cubic-bezier(.4,0,.2,1);will-change:transform;">
            <?php foreach($mob_categories as $sc):
              $cat_img = !empty($sc['image']) && file_exists(UPLOAD_DIR.$sc['image'])
                         ? UPLOAD_URL.$sc['image']
                         : 'https://images.unsplash.com/photo-1490750967868-88df5691cc69?w=120&h=120&fit=crop';
            ?>
            <a href="<?= BASE_URL ?>/<?= e($sc['slug']) ?>/"
               style="flex-shrink:0;width:calc(33.333% - 6px);text-align:center;text-decoration:none;display:block;">
              <div style="aspect-ratio:1/1;border-radius:12px;overflow:hidden;margin-bottom:6px;
                          border:1px solid var(--parch-dd);transition:border-color .25s,transform .4s;"
                   onmouseover="this.style.borderColor='rgba(92,122,85,.4)';this.querySelector('img').style.transform='scale(1.07)';"
                   onmouseout="this.style.borderColor='var(--parch-dd)';this.querySelector('img').style.transform='scale(1)';">
                <img src="<?= e($cat_img) ?>" alt="<?= e($sc['name']) ?>"
                     style="width:100%;height:100%;object-fit:cover;transition:transform .5s;" loading="lazy">
              </div>
              <p style="font-family:'Jost',sans-serif;font-size:10px;font-weight:600;
                        color:var(--ink);line-height:1.3;
                        display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
                        line-clamp:2;overflow:hidden;padding:0 2px;">
                <?= e($sc['name']) ?>
              </p>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <div id="cat-mob-dots-tng" style="display:flex;justify-content:center;gap:5px;margin-top:10px;"></div>
      </div>
    </div>
    <?php endif; ?>

    <!-- ── 3. Produk Searchable ── -->
    <?php if(!empty($mob_products)): ?>
    <div class="mob-sb-section">
      <div class="mob-sb-section-head">
        <h3 class="mob-sb-title">Produk Kami</h3>
      </div>
      <div style="padding:10px 14px 8px;">
        <input type="text" id="mob-prod-search-tng" placeholder="Cari produk..."
               style="width:100%;padding:9px 16px;
                      font-family:'Jost',sans-serif;font-size:13px;font-weight:300;
                      border:1.5px solid var(--parch-dd);border-radius:999px;
                      outline:none;color:var(--ink);background:var(--parch);
                      transition:border-color .2s,box-shadow .2s;"
               onfocus="this.style.borderColor='var(--sage-l)';this.style.boxShadow='0 0 0 3px rgba(92,122,85,.1)';"
               onblur="this.style.borderColor='var(--parch-dd)';this.style.boxShadow='none';">
      </div>
      <div id="mob-prod-list-tng" style="padding:4px 10px 10px;max-height:260px;overflow-y:auto;">
        <?php foreach($mob_products as $prod):
          $thumb   = !empty($prod['image']) && file_exists(UPLOAD_DIR.$prod['image'])
                     ? UPLOAD_URL.$prod['image']
                     : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=80&h=80&fit=crop';
          $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}*. Apakah masih tersedia?");
        ?>
        <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank"
           class="mob-prod-item-tng"
           data-name="<?= strtolower(e($prod['name'])) ?>">
          <img src="<?= e($thumb) ?>" alt="<?= e($prod['name']) ?>"
               style="width:46px;height:46px;border-radius:10px;object-fit:cover;
                      flex-shrink:0;border:1px solid var(--parch-dd);">
          <div style="flex:1;min-width:0;">
            <p style="font-family:'Jost',sans-serif;font-size:12px;font-weight:600;
                      color:var(--ink);line-height:1.3;
                      display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
                      line-clamp:2;overflow:hidden;margin-bottom:3px;">
              <?= e($prod['name']) ?>
            </p>
            <p style="font-family:'Jost',sans-serif;font-size:11px;font-weight:700;color:var(--terra);">
              <?= rupiah($prod['price']) ?>
            </p>
          </div>
          <svg style="width:16px;height:16px;flex-shrink:0;color:#22c55e;opacity:.7;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
          </svg>
        </a>
        <?php endforeach; ?>
        <p id="mob-prod-nores-tng" style="display:none;text-align:center;
           font-family:'Jost',sans-serif;font-size:12px;color:var(--muted);padding:14px 0;">
          Produk tidak ditemukan 🌿
        </p>
      </div>
    </div>
    <?php endif; ?>

    <!-- ── 4. Kategori Artikel — pills ── -->
    <div class="mob-sb-section">
      <div class="mob-sb-section-head">
        <h3 class="mob-sb-title">Kategori Artikel</h3>
      </div>
      <div style="padding:12px 14px;display:flex;flex-wrap:wrap;gap:7px;">
        <a href="<?= BASE_URL ?>/blog/" class="mob-cat-pill"
           style="border:1px solid <?= !$filter_cat ? 'transparent' : 'var(--parch-dd)' ?>;
                  background:<?= !$filter_cat ? 'var(--ink)' : 'transparent' ?>;
                  color:<?= !$filter_cat ? 'var(--parch)' : 'var(--muted)' ?>;">
          Semua
        </a>
        <?php foreach($blog_cats as $bc): $act = ($filter_cat === $bc['slug']); ?>
        <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($bc['slug']) ?>" class="mob-cat-pill"
           style="border:1px solid <?= $act ? 'transparent' : 'var(--parch-dd)' ?>;
                  background:<?= $act ? 'var(--ink)' : 'transparent' ?>;
                  color:<?= $act ? 'var(--parch)' : 'var(--muted)' ?>;">
          <?= e($bc['name']) ?> <span style="opacity:.55;">(<?= $bc['total'] ?>)</span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>

  <!-- ── 5. Area Pengiriman ── -->
<div class="mob-sb-section" style="padding:16px 18px;">
  <h3 style="font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:700;
             color:var(--ink);margin-bottom:13px;">📍 Area Pengiriman</h3>

  <?php
  $sage_mob_per_page = 10;
  $sage_mob_total    = count($locations);
  $sage_mob_pages    = (int)ceil($sage_mob_total / $sage_mob_per_page);
  ?>

  <?php for ($p = 0; $p < $sage_mob_pages; $p++): ?>
  <div id="sageMobAreaPage<?= $p ?>"
       style="display:<?= $p === 0 ? 'grid' : 'none' ?>;
              grid-template-columns:repeat(2,1fr);
              gap:7px; min-height:60px;">
    <?php
    $slice = array_slice($locations, $p * $sage_mob_per_page, $sage_mob_per_page);
    foreach ($slice as $l):
    ?>
    <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/" class="mob-area-tag"
       style="overflow:hidden;min-width:0;">
      <span style="width:3px;height:3px;border-radius:50%;background:rgba(92,122,85,.45);
                   display:inline-block;flex-shrink:0;"></span>
      <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;min-width:0;">
        <?= e($l['name']) ?>
      </span>
    </a>
    <?php endforeach; ?>
  </div>
  <?php endfor; ?>

  <?php if ($sage_mob_pages > 1): ?>
  <div style="display:flex;align-items:center;justify-content:space-between;
              margin-top:12px;padding-top:10px;border-top:1px solid var(--parch-dd);">
    <button id="sageMobAreaPrev" onclick="sageMobAreaSlider(-1)"
            class="mob-sb-nav"
            style="width:auto;height:auto;border-radius:8px;padding:4px 12px;font-size:11px;">
      ‹ Prev
    </button>

    <div style="display:flex;gap:4px;align-items:center;">
      <?php for ($p = 0; $p < $sage_mob_pages; $p++): ?>
      <span id="sageMobAreaDot<?= $p ?>" onclick="sageMobAreaGoPage(<?= $p ?>)"
            style="display:inline-block;height:5px;border-radius:3px;cursor:pointer;transition:all .2s;
                   width:<?= $p === 0 ? '16px' : '5px' ?>;
                   background:<?= $p === 0 ? 'var(--sage)' : 'rgba(92,122,85,.2)' ?>;"></span>
      <?php endfor; ?>
    </div>

    <button id="sageMobAreaNext" onclick="sageMobAreaSlider(1)"
            class="mob-sb-nav"
            style="width:auto;height:auto;border-radius:8px;padding:4px 12px;font-size:11px;">
      Next ›
    </button>
  </div>
  <p id="sageMobAreaInfo"
     style="text-align:center;font-family:'Jost',sans-serif;font-size:11px;
            color:var(--muted);margin-top:5px;"></p>
  <?php endif; ?>
</div>

    <!-- ── 6. Bottom CTA strip ── -->
    <div style="background:var(--ink);border-radius:16px;padding:20px 22px;
                display:flex;align-items:center;justify-content:space-between;
                gap:16px;flex-wrap:wrap;">
      <div>
        <p style="font-family:'Cormorant Garamond',serif;font-size:17px;font-weight:700;
                  color:var(--parch);margin-bottom:3px;">
          Florist <?= e(setting('site_name')) ?>
        </p>
        <p style="font-family:'Jost',sans-serif;font-size:11px;font-weight:300;
                  color:rgba(244,239,228,.55);">
          Pengiriman cepat ke seluruh area
        </p>
      </div>
      <a href="<?= e($wa_url) ?>" target="_blank"
         style="flex-shrink:0;display:inline-flex;align-items:center;gap:7px;
                background:rgba(244,239,228,.12);backdrop-filter:blur(8px);
                border:1px solid rgba(244,239,228,.2);
                color:var(--parch);font-family:'Jost',sans-serif;
                font-size:12px;font-weight:700;
                padding:10px 20px;border-radius:999px;text-decoration:none;
                letter-spacing:.04em;transition:background .2s;"
         onmouseover="this.style.background='rgba(244,239,228,.22)';"
         onmouseout="this.style.background='rgba(244,239,228,.12)';">
        <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Pesan WA
      </a>
    </div>

  </div>
</div>

<script>
/* ── Mobile product search ── */
(function(){
  const input = document.getElementById('mob-prod-search-tng');
  const items = document.querySelectorAll('.mob-prod-item-tng');
  const noRes = document.getElementById('mob-prod-nores-tng');
  if (!input) return;
  input.addEventListener('input', function(){
    const q = this.value.toLowerCase().trim(); let vis = 0;
    items.forEach(item => {
      const show = !q || item.dataset.name.includes(q);
      item.style.display = show ? '' : 'none';
      if (show) vis++;
    });
    noRes.style.display = vis > 0 ? 'none' : 'block';
  });
})();

/* ── Mobile category slider — 3 per page ── */
(function(){
  const inner  = document.getElementById('cat-mob-inner-tng');
  const dotsEl = document.getElementById('cat-mob-dots-tng');
  if (!inner) return;
  const items = inner.querySelectorAll('a');
  const perPage = 3;
  const pages = Math.ceil(items.length / perPage);
  let cur = 0;

  for (let i = 0; i < pages; i++) {
    const d = document.createElement('button');
    d.style.cssText = `width:${i===0?'16px':'6px'};height:6px;border-radius:3px;border:none;cursor:pointer;transition:all .25s;background:${i===0?'var(--sage)':'rgba(92,122,85,.2)'};padding:0;`;
    d.onclick = () => goTo(i);
    dotsEl.appendChild(d);
  }

  function goTo(idx) {
    cur = Math.max(0, Math.min(idx, pages - 1));
    const trackW = inner.parentElement.offsetWidth;
    inner.style.transform = `translateX(-${cur * (trackW + 8)}px)`;
    dotsEl.querySelectorAll('button').forEach((d, i) => {
      d.style.width      = i === cur ? '16px' : '6px';
      d.style.background = i === cur ? 'var(--sage)' : 'rgba(92,122,85,.2)';
    });
  }

  window.slideCatMobTng = function(dir) { goTo(cur + dir); };
})();
/* ── Area Pengiriman slider — Sage mobile ── */
(function(){
  var perPage = <?= $sage_mob_per_page ?>;
  var total   = <?= $sage_mob_total ?>;
  var pages   = <?= $sage_mob_pages ?>;
  var cur     = 0;

  function update() {
    for (var i = 0; i < pages; i++) {
      var el = document.getElementById('sageMobAreaPage' + i);
      if (el) el.style.display = (i === cur) ? 'grid' : 'none';
    }
    for (var i = 0; i < pages; i++) {
      var dot = document.getElementById('sageMobAreaDot' + i);
      if (!dot) continue;
      dot.style.width      = (i === cur) ? '16px' : '5px';
      dot.style.background = (i === cur) ? 'var(--sage)' : 'rgba(92,122,85,.2)';
    }
    var prev = document.getElementById('sageMobAreaPrev');
    var next = document.getElementById('sageMobAreaNext');
    if (prev) {
      prev.disabled      = (cur === 0);
      prev.style.opacity = (cur === 0) ? '0.35' : '1';
      prev.style.cursor  = (cur === 0) ? 'not-allowed' : 'pointer';
    }
    if (next) {
      next.disabled      = (cur === pages - 1);
      next.style.opacity = (cur === pages - 1) ? '0.35' : '1';
      next.style.cursor  = (cur === pages - 1) ? 'not-allowed' : 'pointer';
    }
    var info = document.getElementById('sageMobAreaInfo');
    if (info) {
      var start = cur * perPage + 1;
      var end   = Math.min((cur + 1) * perPage, total);
      info.textContent = start + '–' + end + ' dari ' + total + ' area';
    }
  }

  window.sageMobAreaSlider = function(dir) { cur = Math.max(0, Math.min(pages - 1, cur + dir)); update(); };
  window.sageMobAreaGoPage = function(p)   { cur = p; update(); };

  update();
})();
</script>