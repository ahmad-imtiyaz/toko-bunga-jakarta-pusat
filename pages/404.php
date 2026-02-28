<?php
require_once __DIR__ . '/../includes/config.php';
$meta_title = 'Halaman Tidak Ditemukan — Toko Bunga Jakarta Pusat';
$meta_desc  = 'Halaman yang Anda cari tidak ditemukan.';
require __DIR__ . '/../includes/header.php';
?>

<link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@700;800&family=Zen+Kaku+Gothic+New:wght@400;500;700&display=swap" rel="stylesheet">

<style>
:root {
  --mat-cream: #FDFAF3;
  --mat-dark:  #1C1208;
  --obi-red:   #B5342A;
  --obi-gold:  #C9943A;
  --noren-tan: #E8D5A3;
  --muted:     rgba(28,18,8,.45);
}

@keyframes lantern-sway {
  0%,100% { transform: rotate(-4deg); }
  50%      { transform: rotate(4deg); }
}
@keyframes petal-fall {
  0%   { transform: translateY(-20px) rotate(0deg);   opacity: 0; }
  10%  { opacity: .7; }
  100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
}
@keyframes fade-up {
  from { opacity:0; transform:translateY(22px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes shimmer {
  0%   { background-position: -200% center; }
  100% { background-position:  200% center; }
}
@keyframes pulse-glow {
  0%,100% { box-shadow: 0 0 0 0 rgba(181,52,42,.4); }
  50%      { box-shadow: 0 0 0 10px rgba(181,52,42,0); }
}

.fu1 { animation: fade-up .6s ease both .1s; }
.fu2 { animation: fade-up .6s ease both .25s; }
.fu3 { animation: fade-up .6s ease both .4s; }
.fu4 { animation: fade-up .6s ease both .55s; }

.sakura-petal {
  position: fixed;
  top: -30px;
  font-size: 20px;
  pointer-events: none;
  animation: petal-fall var(--d,8s) linear var(--dl,0s) infinite;
  z-index: 0;
  user-select: none;
}

.lantern {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  animation: lantern-sway var(--ls, 4s) ease-in-out infinite;
  transform-origin: top center;
}
.lantern-body {
  width: 36px; height: 52px;
  border-radius: 50% 50% 45% 45% / 40% 40% 60% 60%;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
  box-shadow: inset 0 -8px 16px rgba(0,0,0,.2), 0 4px 16px rgba(181,52,42,.4);
}
.lantern-top, .lantern-bot {
  width: 22px; height: 6px;
  border-radius: 3px;
}
.lantern-string {
  width: 1.5px; height: 28px;
  background: rgba(28,18,8,.25);
}
.lantern-fringe {
  width: 28px; height: 10px;
  background: linear-gradient(180deg, currentColor, transparent);
  border-radius: 0 0 4px 4px;
}
</style>

<!-- Sakura petals -->
<span class="sakura-petal" style="left:8%;--d:7s;--dl:0s;">🌸</span>
<span class="sakura-petal" style="left:22%;--d:9s;--dl:1.5s;">🌷</span>
<span class="sakura-petal" style="left:38%;--d:6s;--dl:3s;">🌸</span>
<span class="sakura-petal" style="left:55%;--d:11s;--dl:.5s;">🌺</span>
<span class="sakura-petal" style="left:70%;--d:8s;--dl:2s;">🌸</span>
<span class="sakura-petal" style="left:85%;--d:10s;--dl:4s;">🌷</span>
<span class="sakura-petal" style="left:94%;--d:7.5s;--dl:1s;">🌸</span>

<section style="min-height:85vh;display:flex;align-items:center;justify-content:center;background:var(--mat-cream);position:relative;overflow:hidden;padding:60px 16px;">

  <!-- Washi texture blobs -->
  <div style="position:absolute;top:-80px;right:-80px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(201,148,58,.12),transparent 65%);pointer-events:none;"></div>
  <div style="position:absolute;bottom:-60px;left:-60px;width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,rgba(181,52,42,.08),transparent 65%);pointer-events:none;"></div>

  <!-- Hanging lanterns top -->
  <div style="position:absolute;top:0;left:0;right:0;display:flex;justify-content:space-around;padding:0 10%;z-index:2;pointer-events:none;">
    <?php
    $lanterns = [
      ['#B5342A','赤'],['#C9943A','金'],['#B5342A','縁'],
      ['#8B4513','木'],['#C9943A','花'],
    ];
    $ls = [3.8, 4.5, 3.2, 5.1, 4.0];
    foreach ($lanterns as $i => [$color, $kanji]):
    ?>
    <div class="lantern" style="--ls:<?= $ls[$i] ?>s;">
      <div class="lantern-string"></div>
      <div class="lantern-top" style="background:<?= $color ?>;opacity:.8;"></div>
      <div class="lantern-body" style="background:linear-gradient(135deg,<?= $color ?>,<?= $color ?>dd);">
        <span style="color:rgba(255,255,255,.85);font-family:'Shippori Mincho',serif;font-weight:800;"><?= $kanji ?></span>
      </div>
      <div class="lantern-bot" style="background:<?= $color ?>;opacity:.8;"></div>
      <div class="lantern-fringe" style="color:<?= $color ?>;opacity:.6;width:28px;height:8px;background:linear-gradient(180deg,<?= $color ?>99,transparent);border-radius:0 0 4px 4px;"></div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Decorative top border — noren pattern -->
  <div style="position:absolute;top:0;left:0;right:0;height:4px;background:repeating-linear-gradient(90deg,var(--obi-red) 0,var(--obi-red) 20px,var(--obi-gold) 20px,var(--obi-gold) 40px,var(--mat-dark) 40px,var(--mat-dark) 60px);opacity:.7;"></div>

  <!-- Main content -->
  <div style="position:relative;z-index:5;text-align:center;max-width:480px;width:100%;">

    <!-- Kanji 404 watermark -->
    <div style="position:relative;display:inline-block;margin-bottom:8px;">
      <div class="fu1" style="font-family:'Shippori Mincho',serif;font-size:clamp(6rem,22vw,9rem);font-weight:800;line-height:1;background:linear-gradient(135deg,var(--obi-red),var(--obi-gold));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
        404
      </div>
      <!-- Kanji overlay -->
      <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;gap:2px;pointer-events:none;z-index:-1;">
        <span style="font-family:'Shippori Mincho',serif;font-size:clamp(5.5rem,20vw,8.5rem);font-weight:800;color:rgba(181,52,42,.06);">四〇四</span>
      </div>
    </div>

    <!-- Gold shimmer line -->
    <div class="fu2" style="margin:0 auto 20px;height:2px;width:70px;background:linear-gradient(90deg,transparent,var(--obi-red),var(--obi-gold),var(--obi-red),transparent);background-size:200% auto;animation:shimmer 3s linear infinite;border-radius:2px;"></div>

    <!-- Heading -->
    <h1 class="fu2" style="font-family:'Shippori Mincho',serif;font-size:clamp(1.3rem,3.5vw,1.9rem);font-weight:800;color:var(--mat-dark);margin-bottom:10px;line-height:1.3;">
      頁面不存在 — Halaman Tidak Ditemukan
    </h1>

    <!-- Sub -->
    <p class="fu3" style="font-family:'Zen Kaku Gothic New',sans-serif;font-size:15px;line-height:1.75;color:var(--muted);margin-bottom:32px;max-width:360px;margin-left:auto;margin-right:auto;">
      Seperti bunga sakura yang jatuh — halaman ini sudah pergi.<br>Yuk kembali atau hubungi kami langsung! 🌸
    </p>

    <!-- CTAs -->
    <div class="fu4" style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;align-items:center;">
      <a href="<?= BASE_URL ?>/"
         style="display:inline-flex;align-items:center;gap:8px;font-family:'Zen Kaku Gothic New',sans-serif;font-weight:700;font-size:14px;padding:13px 28px;border-radius:4px;text-decoration:none;background:linear-gradient(135deg,var(--obi-red),#8B1A12);color:#fff;animation:pulse-glow 2.4s ease infinite;transition:transform .2s ease;"
         onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        帰宅 — Beranda
      </a>
      <a href="<?= e(setting('whatsapp_url')) ?>" target="_blank"
         style="display:inline-flex;align-items:center;gap:8px;font-family:'Zen Kaku Gothic New',sans-serif;font-weight:700;font-size:14px;padding:12px 24px;border-radius:4px;text-decoration:none;border:1.5px solid rgba(181,52,42,.3);color:var(--mat-dark);background:transparent;transition:all .2s ease;"
         onmouseover="this.style.background='rgba(181,52,42,.06)';this.style.borderColor='rgba(181,52,42,.5)'" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(181,52,42,.3)'">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
        Hubungi Kami
      </a>
    </div>

    <!-- Bottom kanji stamp -->
    <div class="fu4" style="margin-top:36px;display:inline-flex;align-items:center;gap:10px;opacity:.3;">
      <div style="height:1px;width:40px;background:var(--obi-red);"></div>
      <span style="font-family:'Shippori Mincho',serif;font-size:13px;font-weight:700;color:var(--mat-dark);letter-spacing:.2em;">迷子の花</span>
      <div style="height:1px;width:40px;background:var(--obi-red);"></div>
    </div>

  </div>

  <!-- Bottom border -->
  <div style="position:absolute;bottom:0;left:0;right:0;height:4px;background:repeating-linear-gradient(90deg,var(--obi-red) 0,var(--obi-red) 20px,var(--obi-gold) 20px,var(--obi-gold) 40px,var(--mat-dark) 40px,var(--mat-dark) 60px);opacity:.7;"></div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>