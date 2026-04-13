<?php
// blog-sidebar.php — Sage Forest × Parchment theme (selaras dengan blog/index.php)
// Variabel tersedia dari parent: $blog_cats, $locations, $wa_url, $filter_cat

$sidebar_recent = db()->query("
    SELECT b.title, b.slug, b.thumbnail, b.created_at, bc.name AS cat_name
    FROM blogs b
    LEFT JOIN blog_categories bc ON b.blog_category_id = bc.id
    WHERE b.status = 'active'
    ORDER BY b.created_at DESC LIMIT 5
")->fetchAll();

$sidebar_categories = db()->query("
    SELECT * FROM categories
    WHERE status = 'active' AND (parent_id IS NULL OR parent_id = 0)
    ORDER BY urutan ASC, id ASC
")->fetchAll();

$sidebar_products = db()->query("
    SELECT p.*, c.name AS cat_name FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'active'
    ORDER BY p.id ASC
    LIMIT 30
")->fetchAll();
?>

<style>
/* ══════════════════════════════════════════
   SIDEBAR — Sage Forest × Parchment
══════════════════════════════════════════ */
.sb-card {
  background: var(--leaf);
  border: 1px solid var(--parch-dd);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(28,43,26,.05);
}
.sb-head {
  padding: 13px 18px 10px;
  border-bottom: 1px solid var(--parch-dd);
  background: rgba(92,122,85,.04);
}
.sb-head-label {
  font-family: 'Jost', sans-serif;
  font-size: 9px; font-weight: 600;
  text-transform: uppercase; letter-spacing: .14em;
  color: rgba(92,122,85,.5); margin-bottom: 3px;
}
.sb-head-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 16px; font-weight: 700; color: var(--ink);
}
.sb-link {
  display: flex; align-items: center; justify-content: space-between;
  padding: 8px 12px; border-radius: 10px; text-decoration: none;
  margin-bottom: 2px; transition: background .2s, color .2s;
  font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 400; color: var(--muted);
}
.sb-link:hover, .sb-link.active {
  background: rgba(92,122,85,.1); color: var(--sage);
}
.sb-link.active { font-weight: 600; }
.sb-badge {
  font-family: 'Jost', sans-serif;
  font-size: 10px; background: rgba(92,122,85,.08);
  padding: 2px 8px; border-radius: 999px; color: var(--muted);
}
.sb-dot {
  width: 5px; height: 5px; border-radius: 50%;
  background: rgba(92,122,85,.3); display: inline-block; flex-shrink: 0;
}
.sb-accent-btn {
  display: block; background: var(--ink);
  color: var(--parch); font-family: 'Jost', sans-serif;
  font-size: 12px; font-weight: 700; padding: 11px;
  border-radius: 999px; text-decoration: none; text-align: center;
  letter-spacing: .04em; box-shadow: 0 4px 16px rgba(28,43,26,.18);
  transition: opacity .2s, transform .2s;
}
.sb-accent-btn:hover { opacity: .85; transform: translateY(-1px); }

/* Prod scroll */
#sidebar-prod-list-tng::-webkit-scrollbar { width: 3px; }
#sidebar-prod-list-tng::-webkit-scrollbar-track { background: rgba(92,122,85,.06); border-radius: 3px; }
#sidebar-prod-list-tng::-webkit-scrollbar-thumb { background: rgba(92,122,85,.3); border-radius: 3px; }
#sidebar-prod-list-tng::-webkit-scrollbar-thumb:hover { background: var(--sage); }

/* Cat slider */
#cat-slider-track-tng { overflow: hidden; }
#cat-slider-inner-tng { display: flex; gap: 8px; transition: transform .35s cubic-bezier(.4,0,.2,1); will-change: transform; }

.sb-nav-btn {
  width: 26px; height: 26px; border-radius: 50%; cursor: pointer;
  background: rgba(92,122,85,.08);
  border: 1px solid rgba(92,122,85,.22);
  color: var(--sage); font-size: 15px; font-weight: 600;
  display: flex; align-items: center; justify-content: center;
  transition: all .2s; line-height: 1;
}
.sb-nav-btn:hover { background: var(--ink); color: var(--parch); border-color: var(--ink); }

.sb-recent-item {
  display: flex; gap: 10px; align-items: flex-start;
  padding: 9px 0; border-bottom: 1px solid var(--parch-dd);
  text-decoration: none; transition: opacity .2s;
}
.sb-recent-item:hover { opacity: .75; }
.sb-recent-item:last-child { border-bottom: none; }

.sb-prod-item {
  display: flex; align-items: center; gap: 10px; padding: 8px 10px;
  border-radius: 10px; text-decoration: none; margin-bottom: 2px;
  transition: background .2s;
}
.sb-prod-item:hover { background: rgba(92,122,85,.07); }

.area-pill-sb {
  font-family: 'Jost', sans-serif;
  font-size: 11px; font-weight: 400;
  color: var(--muted); text-decoration: none;
  padding: 5px 0; display: flex; align-items: center; gap: 8px;
  transition: color .2s;
}
.area-pill-sb:hover { color: var(--sage); }
</style>

<div style="display:flex;flex-direction:column;gap:14px;">

  <!-- ── 1. Kategori Artikel ── -->
  <div class="sb-card">
    <div class="sb-head">
      <p class="sb-head-label">Filter Artikel</p>
      <h3 class="sb-head-title">Kategori Artikel</h3>
    </div>
    <div style="padding:8px 10px;max-height:230px;overflow-y:auto;">
      <a href="<?= BASE_URL ?>/blog/" class="sb-link <?= !$filter_cat ? 'active' : '' ?>">
        <span>Semua Artikel</span>
        <span class="sb-badge"><?= array_sum(array_column($blog_cats,'total')) ?></span>
      </a>
      <?php foreach($blog_cats as $bc): $act = ($filter_cat === $bc['slug']); ?>
      <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($bc['slug']) ?>"
         class="sb-link <?= $act ? 'active' : '' ?>">
        <span style="display:flex;align-items:center;gap:7px;">
          <span class="sb-dot" style="<?= $act ? 'background:var(--sage);' : '' ?>"></span>
          <?= e($bc['name']) ?>
        </span>
        <span class="sb-badge"><?= $bc['total'] ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ── 2. Slider Kategori Bunga ── -->
  <?php if(!empty($sidebar_categories)): ?>
  <div class="sb-card">
    <div class="sb-head" style="display:flex;align-items:center;justify-content:space-between;">
      <div>
        <p class="sb-head-label">Produk</p>
        <h3 class="sb-head-title">Kategori Bunga</h3>
      </div>
      <div style="display:flex;gap:5px;">
        <button class="sb-nav-btn" onclick="slideCatTng(-1)">‹</button>
        <button class="sb-nav-btn" onclick="slideCatTng(1)">›</button>
      </div>
    </div>
    <div style="padding:12px;">
      <div id="cat-slider-track-tng">
        <div id="cat-slider-inner-tng">
          <?php foreach($sidebar_categories as $sc):
            $cat_img = !empty($sc['image']) && file_exists(UPLOAD_DIR.$sc['image'])
                       ? UPLOAD_URL.$sc['image']
                       : 'https://images.unsplash.com/photo-1490750967868-88df5691cc69?w=120&h=120&fit=crop';
          ?>
          <a href="<?= BASE_URL ?>/<?= e($sc['slug']) ?>/"
             style="flex-shrink:0;width:calc(50% - 4px);text-align:center;text-decoration:none;display:block;">
            <div style="aspect-ratio:1/1;border-radius:12px;overflow:hidden;margin-bottom:6px;
                        border:1px solid var(--parch-dd);
                        transition:border-color .25s,transform .4s;"
                 onmouseover="this.style.borderColor='rgba(92,122,85,.4)';this.querySelector('img').style.transform='scale(1.08)';"
                 onmouseout="this.style.borderColor='var(--parch-dd)';this.querySelector('img').style.transform='scale(1)';">
              <img src="<?= e($cat_img) ?>" alt="<?= e($sc['name']) ?>"
                   style="width:100%;height:100%;object-fit:cover;transition:transform .5s ease;" loading="lazy">
            </div>
            <p style="font-family:'Jost',sans-serif;font-size:11px;font-weight:600;
                      color:var(--ink);line-height:1.3;
                      display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
                      line-clamp:2;overflow:hidden;">
              <?= e($sc['name']) ?>
            </p>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      <div id="cat-dots-tng" style="display:flex;justify-content:center;gap:5px;margin-top:10px;"></div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── 3. Produk Searchable ── -->
  <?php if(!empty($sidebar_products)): ?>
  <div class="sb-card">
    <div class="sb-head">
      <p class="sb-head-label">Toko Bunga</p>
      <h3 class="sb-head-title">Produk Kami</h3>
    </div>
    <div style="padding:10px 14px 8px;">
      <input type="text" id="sidebar-prod-search-tng" placeholder="Cari produk..."
             style="width:100%;padding:8px 14px;
                    font-family:'Jost',sans-serif;font-size:13px;font-weight:300;
                    border:1.5px solid var(--parch-dd);border-radius:999px;
                    outline:none;color:var(--ink);background:var(--parch);
                    transition:border-color .2s,box-shadow .2s;"
             onfocus="this.style.borderColor='var(--sage-l)';this.style.boxShadow='0 0 0 3px rgba(92,122,85,.1)';"
             onblur="this.style.borderColor='var(--parch-dd)';this.style.boxShadow='none';">
    </div>
    <div id="sidebar-prod-list-tng" style="padding:4px 10px 10px;max-height:280px;overflow-y:auto;">
      <?php foreach($sidebar_products as $prod):
        $thumb   = !empty($prod['image']) && file_exists(UPLOAD_DIR.$prod['image'])
                   ? UPLOAD_URL.$prod['image']
                   : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=80&h=80&fit=crop';
        $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}*. Apakah masih tersedia?");
      ?>
      <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank"
         class="sb-prod-item sidebar-prod-item-tng"
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
      <p id="sidebar-prod-nores-tng" style="display:none;text-align:center;
         font-family:'Jost',sans-serif;font-size:12px;color:var(--muted);padding:14px 0;">
        Produk tidak ditemukan 🌿
      </p>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── 4. CTA WhatsApp ── -->
  <div style="position:relative;overflow:hidden;
              background:linear-gradient(135deg,rgba(92,122,85,.12),rgba(181,98,42,.07));
              border:1px solid rgba(92,122,85,.25);border-radius:16px;
              padding:20px;text-align:center;">
    <div style="position:absolute;top:-30px;right:-30px;width:110px;height:110px;
                background:radial-gradient(circle,rgba(138,174,129,.4),transparent 65%);
                pointer-events:none;"></div>
    <div style="position:relative;z-index:2;">
      <div style="font-size:28px;margin-bottom:9px;">💬</div>
      <p style="font-family:'Cormorant Garamond',serif;font-weight:700;color:var(--ink);
                font-size:17px;margin-bottom:5px;">Mau Pesan Bunga?</p>
      <p style="font-family:'Jost',sans-serif;font-size:12px;font-weight:300;
                color:var(--muted);margin-bottom:16px;line-height:1.55;">
        Konsultasi gratis via WhatsApp.<br>Siap 24 jam!
      </p>
      <a href="<?= e($wa_url) ?>" target="_blank" class="sb-accent-btn">Chat WhatsApp Sekarang</a>
    </div>
  </div>

  <!-- ── 5. Artikel Terbaru ── -->
  <?php if(!empty($sidebar_recent)): ?>
  <div class="sb-card">
    <div class="sb-head">
      <p class="sb-head-label">Terbaru</p>
      <h3 class="sb-head-title">Artikel Terbaru</h3>
    </div>
    <div style="padding:8px 14px 10px;">
      <?php foreach($sidebar_recent as $sr):
        $sr_thumb = !empty($sr['thumbnail']) && file_exists(UPLOAD_DIR.$sr['thumbnail'])
                    ? UPLOAD_URL.$sr['thumbnail']
                    : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=80&h=80&fit=crop';
      ?>
      <a href="<?= BASE_URL ?>/blog/<?= e($sr['slug']) ?>/" class="sb-recent-item">
        <div style="flex-shrink:0;width:52px;height:52px;border-radius:10px;overflow:hidden;
                    border:1px solid var(--parch-dd);">
          <img src="<?= e($sr_thumb) ?>" alt="" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
        </div>
        <div style="flex:1;min-width:0;">
          <?php if($sr['cat_name']): ?>
          <span style="font-family:'Jost',sans-serif;font-size:9px;font-weight:600;
                       color:var(--sage);text-transform:uppercase;letter-spacing:.08em;">
            <?= e($sr['cat_name']) ?>
          </span>
          <?php endif; ?>
          <p style="font-family:'Jost',sans-serif;font-size:12px;font-weight:600;
                    color:var(--ink-l);line-height:1.35;margin-top:2px;
                    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
                    line-clamp:2;overflow:hidden;">
            <?= e($sr['title']) ?>
          </p>
          <p style="font-family:'Jost',sans-serif;font-size:10px;font-weight:300;
                    color:rgba(28,43,26,.35);margin-top:3px;">
            <?= date('d M Y', strtotime($sr['created_at'])) ?>
          </p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

<!-- ── 6. Area Pengiriman ── -->
<div class="sb-card" style="padding:16px 18px;">
  <h3 style="font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:700;
             color:var(--ink);margin-bottom:12px;display:flex;align-items:center;gap:7px;">
    <span style="font-size:16px;">📍</span> Area Pengiriman
  </h3>

  <?php
  $sage_desk_per_page = 10;
  $sage_desk_total    = count($locations);
  $sage_desk_pages    = (int)ceil($sage_desk_total / $sage_desk_per_page);
  ?>

  <?php for ($p = 0; $p < $sage_desk_pages; $p++): ?>
  <div id="sageDeskAreaPage<?= $p ?>"
       style="display:<?= $p === 0 ? 'flex' : 'none' ?>;
              flex-direction:column;gap:1px; min-height:60px;">
    <?php
    $slice = array_slice($locations, $p * $sage_desk_per_page, $sage_desk_per_page);
    foreach ($slice as $l):
    ?>
    <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/" class="area-pill-sb">
      <span class="sb-dot"></span>
      <?= e($l['name']) ?>
    </a>
    <?php endforeach; ?>
  </div>
  <?php endfor; ?>

  <?php if ($sage_desk_pages > 1): ?>
  <div style="display:flex;align-items:center;justify-content:space-between;
              margin-top:12px;padding-top:10px;border-top:1px solid var(--parch-dd);">
    <button id="sageDeskAreaPrev" onclick="sageDeskAreaSlider(-1)"
            class="sb-nav-btn"
            style="width:auto;height:auto;border-radius:8px;padding:4px 12px;
                   font-size:11px;font-family:'Jost',sans-serif;">
      ‹ Prev
    </button>

    <div style="display:flex;gap:4px;align-items:center;">
      <?php for ($p = 0; $p < $sage_desk_pages; $p++): ?>
      <span id="sageDeskAreaDot<?= $p ?>" onclick="sageDeskAreaGoPage(<?= $p ?>)"
            style="display:inline-block;height:5px;border-radius:3px;cursor:pointer;transition:all .2s;
                   width:<?= $p === 0 ? '16px' : '5px' ?>;
                   background:<?= $p === 0 ? 'var(--sage)' : 'rgba(92,122,85,.2)' ?>;"></span>
      <?php endfor; ?>
    </div>

    <button id="sageDeskAreaNext" onclick="sageDeskAreaSlider(1)"
            class="sb-nav-btn"
            style="width:auto;height:auto;border-radius:8px;padding:4px 12px;
                   font-size:11px;font-family:'Jost',sans-serif;">
      Next ›
    </button>
  </div>
  <p id="sageDeskAreaInfo"
     style="text-align:center;font-family:'Jost',sans-serif;font-size:11px;
            color:var(--muted);margin-top:5px;"></p>
  <?php endif; ?>
</div>

</div>

<script>
/* ── Product search ── */
(function(){
  const input = document.getElementById('sidebar-prod-search-tng');
  const items = document.querySelectorAll('.sidebar-prod-item-tng');
  const noRes = document.getElementById('sidebar-prod-nores-tng');
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

/* ── Category slider — 2 per page ── */
(function(){
  const inner  = document.getElementById('cat-slider-inner-tng');
  const dotsEl = document.getElementById('cat-dots-tng');
  if (!inner) return;
  const items = inner.querySelectorAll('a');
  const perPage = 2;
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
      d.style.width     = i === cur ? '16px' : '6px';
      d.style.background = i === cur ? 'var(--sage)' : 'rgba(92,122,85,.2)';
    });
  }

  window.slideCatTng = function(dir) { goTo(cur + dir); };
})();

/* ── Area Pengiriman slider — Sage desktop ── */
(function(){
  var perPage = <?= $sage_desk_per_page ?>;
  var total   = <?= $sage_desk_total ?>;
  var pages   = <?= $sage_desk_pages ?>;
  var cur     = 0;

  function update() {
    for (var i = 0; i < pages; i++) {
      var el = document.getElementById('sageDeskAreaPage' + i);
      if (el) el.style.display = (i === cur) ? 'flex' : 'none';
    }
    for (var i = 0; i < pages; i++) {
      var dot = document.getElementById('sageDeskAreaDot' + i);
      if (!dot) continue;
      dot.style.width      = (i === cur) ? '16px' : '5px';
      dot.style.background = (i === cur) ? 'var(--sage)' : 'rgba(92,122,85,.2)';
    }
    var prev = document.getElementById('sageDeskAreaPrev');
    var next = document.getElementById('sageDeskAreaNext');
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
    var info = document.getElementById('sageDeskAreaInfo');
    if (info) {
      var start = cur * perPage + 1;
      var end   = Math.min((cur + 1) * perPage, total);
      info.textContent = start + '–' + end + ' dari ' + total + ' area';
    }
  }

  window.sageDeskAreaSlider = function(dir) { cur = Math.max(0, Math.min(pages - 1, cur + dir)); update(); };
  window.sageDeskAreaGoPage = function(p)   { cur = p; update(); };

  update();
})();
</script>  