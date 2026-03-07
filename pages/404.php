<?php
require_once __DIR__ . '/../includes/config.php';
$meta_title = 'Halaman Tidak Ditemukan — Toko Bunga Jakarta Pusat';
$meta_desc  = 'Halaman yang Anda cari tidak ditemukan.';
require __DIR__ . '/../includes/header.php';
?>

<style>
/* ─── 404 — Manila Bunga Kertas ─── */
@keyframes err404FadeUp {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes err404Petal {
  0%   { transform: translateY(-10px) rotate(0deg)   translateX(0);   opacity: 0; }
  8%   { opacity: .35; }
  90%  { opacity: .2; }
  100% { transform: translateY(108vh) rotate(480deg) translateX(32px); opacity: 0; }
}
@keyframes err404PulseRing {
  0%   { transform: scale(1);   opacity: .5; }
  100% { transform: scale(2.4); opacity: 0; }
}

.e404-rv1 { animation: err404FadeUp .55s ease both .08s; }
.e404-rv2 { animation: err404FadeUp .55s ease both .2s; }
.e404-rv3 { animation: err404FadeUp .55s ease both .35s; }
.e404-rv4 { animation: err404FadeUp .55s ease both .5s; }

/* Kelopak CSS-only */
.e404-petal {
  position: fixed;
  pointer-events: none; z-index: 0;
  border-radius: 80% 20% 80% 20% / 60% 60% 40% 40%;
  animation: err404Petal linear infinite;
}
</style>

<!-- ─── KELOPAK JATUH ─── -->
<div style="position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;" aria-hidden="true">
<?php
$petal_colors = ['#C07B60','#DFA98C','#D6C4A0','#E8D9BF','#FBF6EE'];
for ($i = 0; $i < 7; $i++):
  $col = $petal_colors[$i % count($petal_colors)];
  $left = rand(3, 96); $del = rand(0, 16); $dur = rand(13, 23); $sz = rand(7, 12);
?>
<div class="e404-petal" style="
  left:<?= $left ?>%; top:0;
  width:<?= $sz ?>px; height:<?= round($sz*1.4) ?>px;
  background:<?= $col ?>; opacity:.28;
  animation-duration:<?= $dur ?>s; animation-delay:-<?= $del ?>s;
"></div>
<?php endfor; ?>
</div>

<!-- ─── 404 SECTION ─── -->
<section style="
  min-height: 88vh;
  display: flex; align-items: center; justify-content: center;
  background: var(--paper, #FBF6EE);
  position: relative; overflow: hidden;
  padding: 60px 20px;
">

  <!-- Grain texture static -->
  <div style="position:absolute;inset:0;pointer-events:none;
    background-image:url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%22.85%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3CfeColorMatrix type=%22saturate%22 values=%220%22/%3E%3C/filter%3E%3Crect width=%22200%22 height=%22200%22 filter=%22url(%23n)%22 opacity=%22.028%22/%3E%3C/svg%3E');
  "></div>

  <!-- Warm ambient glow -->
  <div style="position:absolute;inset:0;pointer-events:none;
    background:
      radial-gradient(ellipse 55% 60% at 15% 15%, rgba(192,123,96,.09) 0%, transparent 60%),
      radial-gradient(ellipse 45% 50% at 88% 85%, rgba(242,232,213,.6) 0%, transparent 55%);
  "></div>

  <!-- Ornamen SVG bunga pojok kiri atas -->
  <svg style="position:absolute;top:0;left:0;width:280px;opacity:.05;pointer-events:none;" viewBox="0 0 280 280" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="0" cy="0" r="160" stroke="#C07B60" stroke-width="1"/>
    <circle cx="0" cy="0" r="110" stroke="#DFA98C" stroke-width="1"/>
    <circle cx="0" cy="0" r="60"  fill="rgba(192,123,96,.2)"/>
    <ellipse cx="0" cy="-110" rx="14" ry="50" fill="rgba(192,123,96,.22)" transform="rotate(0 0 0)"/>
    <ellipse cx="0" cy="-110" rx="14" ry="50" fill="rgba(192,123,96,.22)" transform="rotate(60 0 0)"/>
    <ellipse cx="0" cy="-110" rx="14" ry="50" fill="rgba(192,123,96,.15)" transform="rotate(120 0 0)"/>
  </svg>

  <!-- Ornamen SVG bunga pojok kanan bawah -->
  <svg style="position:absolute;bottom:0;right:0;width:240px;opacity:.05;pointer-events:none;" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="240" cy="240" r="140" stroke="#C07B60" stroke-width="1"/>
    <circle cx="240" cy="240" r="90"  stroke="#D6C4A0" stroke-width="1"/>
    <circle cx="240" cy="240" r="45"  fill="rgba(192,123,96,.18)"/>
  </svg>

  <!-- Strip atas — ornamen garis -->
  <div style="position:absolute;top:0;left:0;right:0;height:4px;z-index:2;
    background:linear-gradient(90deg,
      var(--manila-dd,#D6C4A0) 0%,
      var(--rose,#C07B60) 25%,
      var(--manila-dd,#D6C4A0) 50%,
      var(--rose,#C07B60) 75%,
      var(--manila-dd,#D6C4A0) 100%
    );
  " aria-hidden="true"></div>

  <!-- Konten utama -->
  <div style="position:relative;z-index:5;text-align:center;max-width:460px;width:100%;">

    <!-- Angka 404 -->
    <div class="e404-rv1" style="position:relative;display:inline-block;margin-bottom:4px;">
      <div style="
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(5.5rem,20vw,8.5rem);
        font-weight:600; line-height:1;
        color:var(--manila-dd,#D6C4A0);
        letter-spacing:-.02em;
        position:relative;
      ">
        4
        <!-- Bunga tengah menggantikan 0 -->
        <span style="position:relative;display:inline-block;">
          <span style="color:var(--rose,#C07B60);">0</span>
          <!-- Cincin dekoratif di sekitar 0 -->
          <span style="
            position:absolute; inset:-4px;
            border-radius:50%;
            border:2px solid var(--rose,#C07B60);
            opacity:.25;
          "></span>
          <span style="
            position:absolute; inset:-10px;
            border-radius:50%;
            border:1px solid var(--manila-dd,#D6C4A0);
            opacity:.4;
          "></span>
        </span>
        4
      </div>
    </div>

    <!-- Diamond divider -->
    <div class="e404-rv2" style="display:flex;align-items:center;justify-content:center;gap:12px;margin:0 auto 20px;">
      <div style="height:1px;width:56px;background:linear-gradient(90deg,transparent,var(--rose,#C07B60));"></div>
      <div style="
        width:7px;height:7px;border-radius:1px;
        background:var(--rose,#C07B60);
        transform:rotate(45deg);opacity:.6;
      "></div>
      <div style="height:1px;width:56px;background:linear-gradient(90deg,var(--rose,#C07B60),transparent);"></div>
    </div>

    <!-- Judul -->
    <h1 class="e404-rv2" style="
      font-family:'Cormorant Garamond',serif;
      font-size:clamp(1.35rem,3.2vw,1.9rem);
      font-weight:600; color:var(--ink,#2A1F14);
      margin-bottom:10px; line-height:1.3;
    ">
      Halaman Tidak Ditemukan
    </h1>

    <!-- Deskripsi -->
    <p class="e404-rv3" style="
      font-family:'Jost',sans-serif;
      font-size:14.5px; font-weight:300;
      line-height:1.8; color:var(--muted,#8A7560);
      margin-bottom:32px;
      max-width:340px; margin-left:auto; margin-right:auto;
    ">
      Seperti kelopak bunga yang terbawa angin — halaman ini sudah tidak ada.
      Kembali ke beranda atau hubungi kami langsung.
    </p>

    <!-- CTA buttons -->
    <div class="e404-rv4" style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;align-items:center;">

      <!-- Beranda -->
      <a href="<?= BASE_URL ?>/"
         style="
           display:inline-flex;align-items:center;gap:8px;
           font-family:'Jost',sans-serif;
           font-size:13.5px; font-weight:600;
           padding:13px 26px; border-radius:100px;
           text-decoration:none;
           background:var(--ink,#2A1F14);
           color:var(--paper,#FBF6EE);
           box-shadow:0 4px 14px rgba(42,31,20,.22);
           transition:background .25s,transform .25s,box-shadow .25s;
           letter-spacing:.04em;
         "
         onmouseover="this.style.background='var(--ink-l,#5C4A35)';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 22px rgba(42,31,20,.28)'"
         onmouseout="this.style.background='var(--ink,#2A1F14)';this.style.transform='translateY(0)';this.style.boxShadow='0 4px 14px rgba(42,31,20,.22)'">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Beranda
      </a>

      <!-- WhatsApp -->
      <a href="<?= e(setting('whatsapp_url')) ?>" target="_blank" rel="noopener"
         style="
           display:inline-flex;align-items:center;gap:8px;
           font-family:'Jost',sans-serif;
           font-size:13.5px; font-weight:600;
           padding:12px 22px; border-radius:100px;
           text-decoration:none;
           border:1.5px solid var(--manila-dd,#D6C4A0);
           color:var(--ink-l,#5C4A35);
           background:transparent;
           transition:border-color .2s,color .2s,background .2s,transform .2s;
           letter-spacing:.04em;
         "
         onmouseover="this.style.borderColor='var(--rose,#C07B60)';this.style.color='var(--rose,#C07B60)';this.style.background='rgba(192,123,96,.05)';this.style.transform='translateY(-1px)'"
         onmouseout="this.style.borderColor='var(--manila-dd,#D6C4A0)';this.style.color='var(--ink-l,#5C4A35)';this.style.background='transparent';this.style.transform='translateY(0)'">
        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Hubungi Kami
      </a>

    </div>

    <!-- Tagline bawah -->
    <div class="e404-rv4" style="margin-top:36px;display:inline-flex;align-items:center;gap:10px;opacity:.3;">
      <div style="height:1px;width:38px;background:linear-gradient(90deg,transparent,var(--rose,#C07B60));"></div>
      <span style="
        font-family:'Cormorant Garamond',serif;
        font-style:italic; font-size:13px;
        color:var(--ink,#2A1F14); letter-spacing:.12em;
      ">Florist Jakarta Pusat</span>
      <div style="height:1px;width:38px;background:linear-gradient(90deg,var(--rose,#C07B60),transparent);"></div>
    </div>

  </div>

  <!-- Strip bawah -->
  <div style="position:absolute;bottom:0;left:0;right:0;height:4px;z-index:2;
    background:linear-gradient(90deg,
      var(--manila-dd,#D6C4A0) 0%,
      var(--rose,#C07B60) 25%,
      var(--manila-dd,#D6C4A0) 50%,
      var(--rose,#C07B60) 75%,
      var(--manila-dd,#D6C4A0) 100%
    );
  " aria-hidden="true"></div>

</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>