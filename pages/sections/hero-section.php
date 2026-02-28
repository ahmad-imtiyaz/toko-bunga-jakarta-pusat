<?php
/* ============================================================
   HERO SECTION — Hana no Yado | Zen Wabi-Sabi
   v3: Subtitle Terbaca · Kumo Dominan · Stats Center Jepang
============================================================ */

// WhatsApp URL & message
$wa_url = setting('whatsapp_number') ?? '6281234567890';
$wa_msg = urlencode(setting('whatsapp_default_message') ?? 'Halo, saya ingin memesan bunga');
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400;600;700&family=Zen+Kaku+Gothic+New:wght@300;400;500;700&family=Cormorant+Garamond:ital,wght@0,300;1,300;1,400&display=swap');

  :root {
    --sumi:     #1C1C1C;
    --washi:    #F5F0E8;
    --matcha:   #7A8C6E;
    --shiitake: #8B6F5E;
    --bamboo:   #C4A882;
    --sakura:   #E8C4B8;
    --ink:      #3D2B1F;
    --moss:     #4A5E3A;
    --rice:     #FDFAF5;
    --slate:    #5B8FA8;
  }

  @keyframes fadeUp {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
  }
  @keyframes fadeIn {
    from { opacity:0; } to { opacity:1; }
  }
  @keyframes kanjiFloat {
    0%,100% { transform:translateY(0) rotate(-2deg); opacity:.06; }
    50%      { transform:translateY(-18px) rotate(-2deg); opacity:.12; }
  }
  @keyframes petalFall {
    0%   { transform:translateY(-30px) translateX(0) rotate(0deg); opacity:0; }
    8%   { opacity:.7; }
    90%  { opacity:.25; }
    100% { transform:translateY(108vh) translateX(60px) rotate(400deg); opacity:0; }
  }
  @keyframes zenTicker {
    from { transform:translateX(0); }
    to   { transform:translateX(-33.333%); }
  }
  @keyframes softPulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.35; transform:scale(1.5); }
  }
  @keyframes shimmerGold {
    0%   { background-position:-200% center; }
    100% { background-position:200% center; }
  }
  @keyframes cloudDrift1 {
    0%,100% { transform:translateX(0) translateY(0) scale(1); }
    33%      { transform:translateX(22px) translateY(-10px) scale(1.02); }
    66%      { transform:translateX(8px) translateY(5px) scale(0.99); }
  }
  @keyframes cloudDrift2 {
    0%,100% { transform:translateX(0) translateY(0) scale(1); }
    33%      { transform:translateX(-18px) translateY(8px) scale(1.01); }
    66%      { transform:translateX(-6px) translateY(-12px) scale(1.02); }
  }
  @keyframes cloudDrift3 {
    0%,100% { transform:translateX(0) translateY(0); }
    50%      { transform:translateX(12px) translateY(-14px); }
  }
  @keyframes brushStroke {
    from { clip-path:inset(0 100% 0 0); }
    to   { clip-path:inset(0 0% 0 0); }
  }
  @keyframes starTwinkle {
    0%,100% { opacity:.85; transform:scale(1) rotate(0deg); }
    50%      { opacity:.2; transform:scale(1.4) rotate(18deg); }
  }
  @keyframes ropeSwing {
    0%,100% { transform:translateY(0); }
    50%      { transform:translateY(5px); }
  }
  @keyframes moonGlow {
    0%,100% { opacity:.18; transform:scale(1); }
    50%      { opacity:.28; transform:scale(1.04); }
  }

  /* ════ HERO WRAPPER ════ */
  #hero-zen {
    font-family:'Zen Kaku Gothic New',sans-serif;
    position:relative;
    min-height:100svh;
    overflow:hidden;
    background:#0b1520;
    display:flex;
    flex-direction:column;
  }

  /* ════ BG PHOTO ════ */
  .zen-hero-bg {
    position:absolute; inset:0; z-index:0;
    background-image:url('<?= BASE_URL ?>/assets/images/hero-awan.png');
    background-size:cover;
    background-position:center;
    transform:scale(1.05);
    transition:transform 10s ease-out;
    filter:sepia(0.35) saturate(0.75) brightness(0.55);
  }
  #hero-zen:hover .zen-hero-bg { transform:scale(1.08); }

  /* Bulan besar di tengah */
  .zen-moon {
    position:absolute; z-index:1;
    top:50%; left:50%;
    transform:translate(-50%, -52%);
    width:clamp(280px, 38vw, 520px);
    height:clamp(280px, 38vw, 520px);
    border-radius:50%;
    background:radial-gradient(circle at 40% 38%,
      rgba(255,248,220,.22) 0%,
      rgba(230,220,180,.14) 40%,
      rgba(180,165,130,.05) 70%,
      transparent 100%);
    animation:moonGlow 8s ease-in-out infinite;
    pointer-events:none;
  }

  /* Overlay gradien */
  .zen-overlay-dark {
    position:absolute; inset:0; z-index:2;
    background:linear-gradient(
      to bottom,
      rgba(11,21,32,.55) 0%,
      rgba(11,21,32,.25) 38%,
      rgba(11,21,32,.55) 72%,
      rgba(11,21,32,.97) 100%
    );
  }
  .zen-overlay-bottom {
    position:absolute; bottom:0; left:0; right:0; height:300px; z-index:3;
    background:linear-gradient(to top, rgba(11,21,32,1) 0%, transparent 100%);
  }

  /* ════ AWAN KUMO ════ */
  .kumo-layer {
    position:absolute; inset:0; z-index:4;
    pointer-events:none; overflow:hidden;
  }
  .kumo { position:absolute; pointer-events:none; }

  /* Awan utama — lebih besar & dominan */
  .kumo-tl {
    top:-10px; left:-40px;
    width:clamp(340px, 48vw, 640px);
    animation:cloudDrift1 13s ease-in-out infinite;
    opacity:.92;
  }
  .kumo-tr {
    top:-15px; right:-35px;
    width:clamp(300px, 42vw, 580px);
    animation:cloudDrift2 15s ease-in-out infinite;
    opacity:.88;
    transform-origin: right top;
  }
  .kumo-tr svg { transform:scaleX(-1); display:block; }

  .kumo-ml {
    top:28%; left:-60px;
    width:clamp(240px, 32vw, 420px);
    animation:cloudDrift3 17s ease-in-out infinite;
    opacity:.55;
  }
  .kumo-mr {
    top:24%; right:-50px;
    width:clamp(220px, 30vw, 400px);
    animation:cloudDrift1 19s ease-in-out infinite reverse;
    opacity:.50;
  }
  .kumo-mr svg { transform:scaleX(-1); display:block; }

  .kumo-bl {
    bottom:80px; left:-30px;
    width:clamp(260px, 34vw, 460px);
    animation:cloudDrift2 21s ease-in-out infinite;
    opacity:.70;
  }
  .kumo-br {
    bottom:70px; right:-25px;
    width:clamp(240px, 32vw, 440px);
    animation:cloudDrift3 23s ease-in-out infinite reverse;
    opacity:.65;
  }
  .kumo-br svg { transform:scaleX(-1); display:block; }

  .kumo-tc {
    top:-5px; left:50%;
    transform:translateX(-50%);
    width:clamp(380px, 60vw, 820px);
    animation:cloudDrift1 25s ease-in-out infinite;
    opacity:.40;
  }

  /* Bintang kerlip */
  .zen-star {
    position:absolute; z-index:5; pointer-events:none;
    animation:starTwinkle ease-in-out infinite;
  }

  /* ════ KANJI DEKORATIF — lebih besar ════ */
  .zen-kanji-bg {
    position:absolute; z-index:5;
    font-family:'Noto Serif JP',serif;
    color:rgba(196,168,130,.08);
    pointer-events:none; user-select:none;
    line-height:1; font-weight:700;
  }
  .zen-kanji-1 {
    font-size:clamp(200px, 26vw, 380px);
    top:-20px; right:-10px;
    animation:kanjiFloat 9s ease-in-out infinite;
  }
  .zen-kanji-2 {
    font-size:clamp(100px, 13vw, 200px);
    bottom:180px; left:10px;
    animation:kanjiFloat 11s ease-in-out infinite;
    animation-delay:-4s;
    opacity:.06;
  }
  .zen-kanji-3 {
    font-size:clamp(80px, 10vw, 160px);
    top:20%; left:50%;
    transform:translateX(-50%);
    animation:kanjiFloat 14s ease-in-out infinite;
    animation-delay:-7s;
    opacity:.04;
  }

  /* Petals */
  #zen-petals { position:absolute; inset:0; z-index:5; pointer-events:none; overflow:hidden; }
  .zen-petal  { position:absolute; pointer-events:none; animation:petalFall linear infinite; }

  /* ════ HERO CONTENT — CENTER ════ */
  .zen-hero-content {
    position:relative; z-index:7;
    flex:1;
    display:flex; flex-direction:column;
    align-items:center; justify-content:center;
    text-align:center;
    max-width:1100px; margin:0 auto; width:100%;
    padding:140px 40px 32px;
    gap:0;
  }

  .zen-overline {
    display:inline-flex; align-items:center; gap:10px;
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:10.5px; font-weight:500; letter-spacing:.28em; text-transform:uppercase;
    color:var(--bamboo); margin-bottom:20px;
    opacity:0; animation:fadeUp .8s .2s forwards;
  }
  .zen-overline-dot {
    width:6px; height:6px; border-radius:50%;
    background:var(--matcha); animation:softPulse 2.5s infinite;
    flex-shrink:0;
  }
  .zen-overline-kanji {
    font-family:'Noto Serif JP',serif; font-size:14px;
    color:rgba(196,168,130,.55); font-weight:300;
  }

  .zen-brush-line {
    display:block; height:2px; width:90px;
    background:linear-gradient(to right, transparent, var(--matcha), var(--bamboo), transparent);
    margin:0 auto 20px;
    opacity:0;
    animation:fadeIn .6s .5s forwards, brushStroke 1s .5s ease forwards;
  }

  /* Headline */
  .zen-headline {
    font-family:'Noto Serif JP',serif;
    font-size:clamp(2.6rem, 5.5vw, 5.2rem);
    font-weight:200; line-height:1.08;
    color:var(--washi); margin:0 0 12px;
    opacity:0; animation:fadeUp .9s .45s forwards;
    letter-spacing:.04em;
  }
  .zen-headline em {
    font-style:italic; font-weight:300;
    color:var(--bamboo);
    font-family:'Cormorant Garamond',serif;
    font-size:1.12em; display:block; margin-bottom:4px;
  }
  .zen-headline .zen-hl-accent {
    display:block; font-weight:600;
    background:linear-gradient(90deg, var(--washi) 0%, var(--bamboo) 45%, var(--matcha) 100%);
    background-size:200% auto;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
    animation:shimmerGold 5s linear infinite;
  }
  .zen-headline-kanji {
    font-family:'Noto Serif JP',serif;
    font-size:.4em; font-weight:300;
    color:rgba(196,168,130,.45);
    display:block; margin-top:10px;
    letter-spacing:.55em; font-style:normal;
    -webkit-text-fill-color:rgba(196,168,130,.45);
    background:none;
  }

  /* Rule ornamen */
  .zen-rule {
    display:flex; align-items:center; justify-content:center; gap:14px;
    margin-bottom:26px;
    opacity:0; animation:fadeUp .7s .65s forwards;
  }
  .zen-rule-line     { height:1px; width:54px; background:linear-gradient(to right,transparent,var(--matcha)); }
  .zen-rule-line.rev { background:linear-gradient(to left,transparent,var(--matcha)); }
  .zen-rule-ornament { display:flex; align-items:center; gap:6px; color:var(--matcha); font-size:9px; opacity:.75; letter-spacing:.22em; }
  .zen-rule-diamond  { width:5px; height:5px; background:var(--bamboo); transform:rotate(45deg); flex-shrink:0; }

  /* SUBTITLE — lebih besar & jelas */
  .zen-subtitle {
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:clamp(14px, 1.8vw, 17px);
    line-height:1.85;
    color:rgba(245,240,232,.82);
    margin-bottom:28px;
    max-width:560px;
    opacity:0; animation:fadeUp .7s .75s forwards;
    font-weight:300;
    text-shadow:0 2px 12px rgba(0,0,0,.6);
    background:rgba(11,21,32,.25);
    border:1px solid rgba(196,168,130,.12);
    padding:14px 22px;
    border-radius:2px;
    backdrop-filter:blur(6px);
  }
  .zen-subtitle-jp {
    display:block; margin-top:6px;
    font-family:'Noto Serif JP',serif;
    font-size:11px; color:rgba(196,168,130,.55);
    letter-spacing:.18em; font-weight:300;
  }

  /* Chips */
  .zen-chips {
    display:flex; flex-wrap:wrap; gap:8px; justify-content:center;
    margin-bottom:30px; opacity:0; animation:fadeUp .7s .88s forwards;
  }
  .zen-chip {
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:10.5px; font-weight:500; letter-spacing:.06em; color:var(--bamboo);
    border:1px solid rgba(196,168,130,.25); background:rgba(196,168,130,.07);
    padding:6px 14px 6px 10px; border-radius:2px;
    backdrop-filter:blur(8px); transition:background .25s,border-color .25s; position:relative;
  }
  .zen-chip::before {
    content:''; position:absolute; left:0; top:0; bottom:0; width:3px;
    background:var(--matcha); border-radius:2px 0 0 2px; opacity:.65;
  }
  .zen-chip:hover { background:rgba(196,168,130,.15); border-color:rgba(196,168,130,.5); }

  /* CTA Buttons */
  .zen-ctas {
    display:flex; flex-wrap:wrap; gap:12px; justify-content:center;
    opacity:0; animation:fadeUp .7s 1.0s forwards; margin-bottom:38px;
  }
  .zen-btn-primary {
    display:inline-flex; align-items:center; gap:10px;
    background:var(--matcha); color:var(--washi);
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:12.5px; font-weight:500; letter-spacing:.08em;
    padding:14px 30px; border-radius:2px; text-decoration:none;
    transition:transform .3s,box-shadow .3s,background .3s;
    box-shadow:0 8px 28px rgba(74,94,58,.5); position:relative; overflow:hidden;
  }
  .zen-btn-primary::after { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.1) 0%,transparent 100%); }
  .zen-btn-primary:hover  { transform:translateY(-3px); box-shadow:0 18px 44px rgba(74,94,58,.6); text-decoration:none; color:var(--washi); background:var(--moss); }
  .zen-btn-secondary {
    display:inline-flex; align-items:center; gap:8px;
    border:1px solid rgba(196,168,130,.32); color:rgba(245,240,232,.78);
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:12.5px; font-weight:400; letter-spacing:.06em;
    padding:14px 26px; border-radius:2px; text-decoration:none;
    transition:border-color .3s,color .3s,transform .3s; backdrop-filter:blur(8px);
  }
  .zen-btn-secondary:hover { border-color:var(--bamboo); color:var(--bamboo); transform:translateY(-2px); text-decoration:none; }

  /* ════ MAKIMONO ════ */
  .makimono-wrapper {
    position:relative; z-index:7;
    display:flex; flex-direction:column; align-items:center;
    opacity:0; animation:fadeIn .8s 1.2s forwards;
    margin-bottom:10px;
  }
  .makimono-handle-top {
    display:flex; flex-direction:column; align-items:center;
    cursor:grab; user-select:none;
  }
  .makimono-handle-top:active { cursor:grabbing; }
  .makimono-rope-top {
    width:2px; height:28px;
    background:linear-gradient(to bottom, rgba(196,168,130,.25), #a07840);
  }
  .makimono-rod {
    width:clamp(280px,56vw,580px); height:24px;
    background:linear-gradient(to bottom, #d4a96a 0%, #8B6030 38%, #c49050 58%, #6b4520 100%);
    border-radius:5px;
    box-shadow:0 5px 18px rgba(0,0,0,.55), inset 0 1px 0 rgba(255,255,255,.18);
    position:relative; flex-shrink:0;
  }
  .makimono-rod::before,.makimono-rod::after {
    content:''; position:absolute; top:50%; transform:translateY(-50%);
    width:32px; height:32px; border-radius:50%;
    background:radial-gradient(circle at 34% 34%, #eebc74, #8B5a20);
    box-shadow:0 4px 12px rgba(0,0,0,.55);
    border:2px solid rgba(255,255,255,.12);
  }
  .makimono-rod::before { left:-10px; }
  .makimono-rod::after  { right:-10px; }
  .makimono-rod-label {
    position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
    font-family:'Noto Serif JP',serif;
    font-size:9.5px; color:rgba(245,240,232,.55);
    letter-spacing:.32em; white-space:nowrap; pointer-events:none;
  }
  .makimono-pull-hint {
    display:flex; align-items:center; gap:7px;
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:9.5px; letter-spacing:.16em; text-transform:uppercase;
    color:rgba(196,168,130,.55);
    margin-top:9px; margin-bottom:2px;
    animation:ropeSwing 2.5s ease-in-out infinite;
    pointer-events:none;
  }
  .makimono-pull-hint svg { width:11px; height:11px; }

  .makimono-body {
    width:clamp(280px,56vw,580px);
    overflow:hidden; height:0;
    transition:height .6s cubic-bezier(.4,0,.2,1);
    position:relative;
  }
  .makimono-inner {
    background:linear-gradient(to bottom, #f2e8d2 0%, #ede0c6 22%, #e9d9be 80%, #e3d1b2 100%);
    border-left:6px solid #8B6030;
    border-right:6px solid #8B6030;
    position:relative; overflow:hidden;
  }
  .makimono-inner::before {
    content:''; position:absolute; inset:0; z-index:0; pointer-events:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.88' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.06'/%3E%3C/svg%3E");
  }
  .makimono-inner::after {
    content:''; position:absolute; inset:0; z-index:1; pointer-events:none;
    background:linear-gradient(to right, rgba(0,0,0,.1) 0%, transparent 8%, transparent 92%, rgba(0,0,0,.1) 100%);
  }
  .makimono-photo {
    width:100%; display:block; position:relative; z-index:2;
    filter:sepia(.1) saturate(.9) contrast(1.05);
  }
  .makimono-ornament {
    display:flex; align-items:center; justify-content:center; gap:12px;
    padding:11px 22px; position:relative; z-index:2;
  }
  .makimono-ornament-line {
    flex:1; height:1px;
    background:linear-gradient(to right, transparent, rgba(139,96,48,.45), transparent);
  }
  .makimono-ornament-kanji {
    font-family:'Noto Serif JP',serif;
    font-size:11px; color:rgba(139,96,48,.65); letter-spacing:.28em;
  }
  .makimono-rod-bottom {
    width:clamp(280px,56vw,580px); height:24px;
    background:linear-gradient(to bottom, #d4a96a 0%, #8B6030 38%, #c49050 58%, #6b4520 100%);
    border-radius:5px;
    box-shadow:0 5px 18px rgba(0,0,0,.55), inset 0 1px 0 rgba(255,255,255,.18);
    position:relative; display:none;
  }
  .makimono-rod-bottom::before,.makimono-rod-bottom::after {
    content:''; position:absolute; top:50%; transform:translateY(-50%);
    width:32px; height:32px; border-radius:50%;
    background:radial-gradient(circle at 34% 34%, #eebc74, #8B5a20);
    box-shadow:0 4px 12px rgba(0,0,0,.55);
    border:2px solid rgba(255,255,255,.12);
  }
  .makimono-rod-bottom::before { left:-10px; }
  .makimono-rod-bottom::after  { right:-10px; }
  .makimono-wrapper.open .makimono-rod-bottom { display:block; }
  .makimono-wrapper.open  .hint-text-close { display:inline; }
  .makimono-wrapper.open  .hint-text-open  { display:none; }
  .makimono-wrapper:not(.open) .hint-text-close { display:none; }
  .makimono-wrapper:not(.open) .hint-text-open  { display:inline; }

  /* ════ STATS BAR — CENTER JEPANG ════ */
  .zen-statsbar {
    position:relative; z-index:7;
    padding:0 32px 0;
    max-width:900px; margin:0 auto 0;
    width:100%;
  }

  /* Border atas bergaya kuas */
  .zen-statsbar-rule {
    display:flex; align-items:center; gap:16px;
    margin-bottom:28px;
  }
  .zen-statsbar-rule-line {
    flex:1; height:1px;
    background:linear-gradient(to right, transparent, rgba(196,168,130,.3), transparent);
  }
  .zen-statsbar-rule-kanji {
    font-family:'Noto Serif JP',serif;
    font-size:11px; color:rgba(196,168,130,.4);
    letter-spacing:.3em; font-weight:300;
  }

  /* Grid stat items — center */
  .zen-stats-grid {
    display:grid;
    grid-template-columns:1fr auto 1fr auto 1fr auto 1fr;
    align-items:center;
    gap:0;
    background:rgba(11,21,32,.55);
    border:1px solid rgba(196,168,130,.14);
    backdrop-filter:blur(14px);
    border-radius:3px;
    overflow:hidden;
  }

  .zen-stat-block {
    display:flex; flex-direction:column;
    align-items:center; text-align:center;
    padding:22px 18px 20px;
    position:relative;
    transition:background .3s;
  }
  .zen-stat-block:hover { background:rgba(196,168,130,.06); }
  .zen-stat-block::before {
    content:''; position:absolute; top:0; left:20%; right:20%; height:2px;
    background:linear-gradient(to right, transparent, var(--bamboo), transparent);
    transform:scaleX(0); transition:transform .4s ease;
  }
  .zen-stat-block:hover::before { transform:scaleX(1); }

  .zen-stat-icon {
    font-family:'Noto Serif JP',serif;
    font-size:18px; color:rgba(196,168,130,.45);
    margin-bottom:8px; line-height:1;
    font-weight:300;
  }
  .zen-stat-num {
    font-family:'Noto Serif JP',serif;
    font-size:clamp(22px,3vw,32px); font-weight:600;
    color:var(--washi); line-height:1; margin-bottom:4px;
  }
  .zen-stat-num sup { font-size:.45em; color:var(--bamboo); font-weight:300; vertical-align:super; }
  .zen-stat-label {
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:9.5px; font-weight:500; letter-spacing:.2em; text-transform:uppercase;
    color:rgba(245,240,232,.38); margin-bottom:3px;
  }
  .zen-stat-label-jp {
    font-family:'Noto Serif JP',serif;
    font-size:8.5px; color:rgba(196,168,130,.35);
    letter-spacing:.1em;
  }

  /* Khusus harga */
  .zen-stat-price .zen-stat-num {
    font-size:clamp(18px,2.4vw,26px);
    color:var(--bamboo);
  }
  .zen-stat-price .zen-stat-icon { font-size:14px; }

  .zen-stats-divider {
    width:1px; height:64px;
    background:linear-gradient(to bottom, transparent, rgba(196,168,130,.2), transparent);
    flex-shrink:0;
  }
/* ════ KUMO FEATURE STYLE ════ */

#kumo-features {
  background: linear-gradient(to bottom,#F9F6F1,#F2EDE6);
  padding: 60px 20px;
  position: relative;
  overflow: hidden;
}

/* subtle floating kumo background */
#kumo-features::before {
  content:'';
  position:absolute;
  inset:0;
  background-image:url("data:image/svg+xml,%3Csvg width='300' height='150' viewBox='0 0 300 150' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M40 90 Q70 50 110 80 T190 80 Q220 60 260 85' fill='none' stroke='%23D8A7B1' stroke-width='3' opacity='0.15'/%3E%3C/svg%3E");
  background-repeat:repeat;
  background-size:350px 180px;
  opacity:.4;
  pointer-events:none;
}

.kumo-wrapper {
  max-width:1320px;
  margin:0 auto;
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:28px;
  position:relative;
  z-index:1;
}

.kumo-card {
  background:#FFFDF9;
  border-radius:22px;
  padding:32px 24px 28px;
  text-align:center;
  position:relative;
  box-shadow:0 10px 30px rgba(0,0,0,.05);
  transition:all .4s ease;
  border:1px solid rgba(196,168,130,.15);
  overflow:hidden;
}

/* inner decorative kumo shape */
.kumo-cloud {
  position:absolute;
  top:-30px;
  left:50%;
  transform:translateX(-50%);
  width:120px;
  height:60px;
  background:radial-gradient(circle at 30% 50%, #F3E6EA 40%, transparent 42%),
             radial-gradient(circle at 60% 50%, #F3E6EA 40%, transparent 42%);
  opacity:.6;
  pointer-events:none;
}

.kumo-card:hover {
  transform:translateY(-6px);
  box-shadow:0 20px 40px rgba(0,0,0,.08);
  border-color:#D8A7B1;
}

/* icon */
.kumo-icon {
  width:64px;
  height:64px;
  margin:0 auto 18px;
  border-radius:50%;
  background:linear-gradient(135deg,#F6E6EA,#EADFD2);
  display:flex;
  align-items:center;
  justify-content:center;
  transition:all .4s ease;
}

.kumo-card:hover .kumo-icon {
  transform:scale(1.1) rotate(-4deg);
}

.kumo-icon img {
  width:30px;
  height:30px;
  filter:sepia(.4) hue-rotate(20deg);
}

.kumo-card h3 {
  font-family:'Noto Serif JP',serif;
  font-size:15px;
  font-weight:500;
  color:#4B3F36;
  margin-bottom:10px;
  letter-spacing:.4px;
}

.kumo-card p {
  font-family:'Zen Kaku Gothic New',sans-serif;
  font-size:12.5px;
  line-height:1.8;
  color:#7B6A5F;
  font-weight:300;
}
  /* ════ TICKER ════ */
  #zen-ticker-wrap {
    background:var(--sumi); border-top:1px solid rgba(196,168,130,.12);
    border-bottom:1px solid rgba(196,168,130,.12);
    padding:13px 0; overflow:hidden;
  }
  .zen-ticker-track { display:flex; width:max-content; animation:zenTicker 35s linear infinite; }
  .zen-ticker-item  {
    display:inline-flex; align-items:center; gap:16px; padding:0 32px;
    font-family:'Zen Kaku Gothic New',sans-serif;
    font-size:10.5px; font-weight:500; letter-spacing:.18em; text-transform:uppercase;
    color:rgba(196,168,130,.85); white-space:nowrap;
  }
  .zen-ticker-sep   { color:rgba(122,140,110,.55); font-size:10px; }
  .zen-ticker-kanji { font-family:'Noto Serif JP',serif; font-size:12px; color:rgba(196,168,130,.38); font-weight:300; }

/* ════ RESPONSIVE ════ */
@media (max-width:1023px) {
  .zen-hero-content { padding:110px 24px 28px; }
  .zen-stats-grid { grid-template-columns:1fr auto 1fr auto 1fr auto 1fr; }

  /* Nonaktifkan lama */
  .zen-features-grid { display:none; }

  /* Layout 2 kolom */
  .kumo-wrapper {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
  }

  /* Card ke-3 tetap jadi tengah */
  .kumo-card:nth-child(3){
    grid-column:1 / -1;
    max-width:420px;
    margin:0 auto;
  }
}

@media (max-width:767px) {
  .zen-hero-content { padding:96px 16px 24px; }
  .kumo-ml,.kumo-mr { display:none; }
  .kumo-bl,.kumo-br { display:none; }
  .makimono-body,
  .makimono-rod,
  .makimono-rod-bottom { width:min(90vw,340px); }

  .zen-stats-grid { grid-template-columns:1fr 1fr; }
  .zen-stats-divider { display:none; }
  .zen-stat-block { border-bottom:1px solid rgba(196,168,130,.1); }
  .zen-stats-grid .zen-stat-block:nth-child(odd) {
    border-right:1px solid rgba(196,168,130,.1);
  }
  .zen-kanji-1 { font-size:160px; }

  /* Nonaktifkan lama */
  .zen-features-grid { display:none; }

  /* Mobile jadi 1 kolom rapi */
  #kumo-features { padding:40px 16px 50px; }

  .kumo-wrapper {
    display:grid;
    grid-template-columns:1fr;
    gap:20px;
  }

  .kumo-card:nth-child(3){
    grid-column:auto;
    max-width:100%;
  }

  .zen-statsbar { padding:0 16px; }
}
</style>

<!-- ══════════════════════════════════
     HERO
══════════════════════════════════ -->
<section id="hero-zen">

  <div class="zen-hero-bg"></div>
  <div class="zen-moon"></div>
  <div class="zen-overlay-dark"></div>
  <div class="zen-overlay-bottom"></div>

  <!-- ════ AWAN KUMO — DOMINAN ════ -->
  <div class="kumo-layer">

    <!-- Kiri atas — besar & tebal -->
    <div class="kumo kumo-tl">
      <svg viewBox="0 0 640 220" xmlns="http://www.w3.org/2000/svg" fill="none">
        <defs>
          <radialGradient id="kg1a" cx="38%" cy="30%" r="72%">
            <stop offset="0%"   stop-color="rgba(238,228,208,0.94)"/>
            <stop offset="40%"  stop-color="rgba(220,210,186,0.88)"/>
            <stop offset="75%"  stop-color="rgba(195,182,158,0.70)"/>
            <stop offset="100%" stop-color="rgba(165,150,125,0.0)"/>
          </radialGradient>
          <radialGradient id="kg1b" cx="50%" cy="40%" r="60%">
            <stop offset="0%"   stop-color="rgba(255,255,255,0.22)"/>
            <stop offset="100%" stop-color="rgba(255,255,255,0.0)"/>
          </radialGradient>
        </defs>
        <!-- masa awan utama -->
        <ellipse cx="240" cy="168" rx="240" ry="90" fill="url(#kg1a)"/>
        <ellipse cx="190" cy="108" rx="110" ry="80" fill="url(#kg1a)"/>
        <ellipse cx="340" cy="96"  rx="95"  ry="70" fill="url(#kg1a)"/>
        <ellipse cx="95"  cy="138" rx="85"  ry="65" fill="url(#kg1a)"/>
        <ellipse cx="440" cy="118" rx="78"  ry="58" fill="url(#kg1a)"/>
        <!-- Tonjolan kecil di atas -->
        <ellipse cx="155" cy="78"  rx="55"  ry="38" fill="url(#kg1a)"/>
        <ellipse cx="270" cy="68"  rx="62"  ry="42" fill="url(#kg1a)"/>
        <ellipse cx="370" cy="74"  rx="50"  ry="34" fill="url(#kg1a)"/>
        <!-- Sorot putih -->
        <ellipse cx="180" cy="68"  rx="60"  ry="24" fill="url(#kg1b)"/>
        <ellipse cx="295" cy="58"  rx="52"  ry="20" fill="url(#kg1b)"/>
        <!-- Garis spiral ukiyo-e -->
        <path d="M90 105 Q106 78 128 88 Q146 98 136 116"  stroke="rgba(255,255,255,0.30)" stroke-width="1.8" fill="none" stroke-linecap="round"/>
        <path d="M162 82 Q180 54 208 66 Q230 78 218 96"   stroke="rgba(255,255,255,0.26)" stroke-width="1.6" fill="none" stroke-linecap="round"/>
        <path d="M255 70 Q278 44 306 56 Q328 68 314 88"   stroke="rgba(255,255,255,0.22)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
        <path d="M345 76 Q365 52 390 62 Q408 72 398 90"   stroke="rgba(255,255,255,0.18)" stroke-width="1.4" fill="none" stroke-linecap="round"/>
        <!-- Garis bawah halus -->
        <path d="M30 170 Q120 148 240 158 Q360 168 480 152 Q560 142 620 150" stroke="rgba(255,255,255,0.14)" stroke-width="1.2" fill="none"/>
      </svg>
    </div>

    <!-- Kanan atas -->
    <div class="kumo kumo-tr">
      <svg viewBox="0 0 600 210" xmlns="http://www.w3.org/2000/svg" fill="none">
        <defs>
          <radialGradient id="kg2a" cx="42%" cy="28%" r="70%">
            <stop offset="0%"   stop-color="rgba(235,225,204,0.92)"/>
            <stop offset="42%"  stop-color="rgba(216,206,182,0.85)"/>
            <stop offset="76%"  stop-color="rgba(190,176,152,0.65)"/>
            <stop offset="100%" stop-color="rgba(160,146,122,0.0)"/>
          </radialGradient>
          <radialGradient id="kg2b" cx="48%" cy="38%" r="58%">
            <stop offset="0%"   stop-color="rgba(255,255,255,0.20)"/>
            <stop offset="100%" stop-color="rgba(255,255,255,0.0)"/>
          </radialGradient>
        </defs>
        <ellipse cx="300" cy="158" rx="300" ry="85" fill="url(#kg2a)"/>
        <ellipse cx="240" cy="100" rx="105" ry="76" fill="url(#kg2a)"/>
        <ellipse cx="390" cy="90"  rx="90"  ry="66" fill="url(#kg2a)"/>
        <ellipse cx="100" cy="132" rx="82"  ry="62" fill="url(#kg2a)"/>
        <ellipse cx="490" cy="110" rx="74"  ry="55" fill="url(#kg2a)"/>
        <ellipse cx="200" cy="72"  rx="52"  ry="36" fill="url(#kg2a)"/>
        <ellipse cx="318" cy="62"  rx="58"  ry="40" fill="url(#kg2a)"/>
        <ellipse cx="425" cy="68"  rx="48"  ry="32" fill="url(#kg2a)"/>
        <ellipse cx="215" cy="62"  rx="56"  ry="22" fill="url(#kg2b)"/>
        <ellipse cx="335" cy="52"  rx="50"  ry="18" fill="url(#kg2b)"/>
        <path d="M85 100 Q102 74 124 84 Q142 94 132 112"  stroke="rgba(255,255,255,0.28)" stroke-width="1.7" fill="none" stroke-linecap="round"/>
        <path d="M158 78 Q176 52 204 64 Q226 76 214 94"   stroke="rgba(255,255,255,0.24)" stroke-width="1.5" fill="none" stroke-linecap="round"/>
        <path d="M248 66 Q270 40 298 54 Q320 66 306 86"   stroke="rgba(255,255,255,0.20)" stroke-width="1.4" fill="none" stroke-linecap="round"/>
        <path d="M354 72 Q374 48 398 60 Q416 70 406 88"   stroke="rgba(255,255,255,0.16)" stroke-width="1.3" fill="none" stroke-linecap="round"/>
      </svg>
    </div>

    <!-- Tengah atas — tipis, bulan menerobos -->
    <div class="kumo kumo-tc">
      <svg viewBox="0 0 820 120" xmlns="http://www.w3.org/2000/svg" fill="none">
        <defs>
          <radialGradient id="kg3" cx="50%" cy="22%" r="64%">
            <stop offset="0%"   stop-color="rgba(225,215,192,0.48)"/>
            <stop offset="100%" stop-color="rgba(180,166,142,0.0)"/>
          </radialGradient>
        </defs>
        <ellipse cx="410" cy="88" rx="410" ry="55" fill="url(#kg3)"/>
        <ellipse cx="260" cy="58" rx="155" ry="52" fill="url(#kg3)"/>
        <ellipse cx="560" cy="52" rx="142" ry="48" fill="url(#kg3)"/>
        <ellipse cx="140" cy="70" rx="90"  ry="40" fill="url(#kg3)"/>
        <ellipse cx="680" cy="66" rx="85"  ry="38" fill="url(#kg3)"/>
      </svg>
    </div>

    <!-- Tengah kiri -->
    <div class="kumo kumo-ml">
      <svg viewBox="0 0 420 160" xmlns="http://www.w3.org/2000/svg" fill="none">
        <defs>
          <radialGradient id="kg4" cx="40%" cy="30%" r="68%">
            <stop offset="0%"   stop-color="rgba(228,218,196,0.62)"/>
            <stop offset="100%" stop-color="rgba(178,163,138,0.0)"/>
          </radialGradient>
        </defs>
        <ellipse cx="210" cy="120" rx="210" ry="58" fill="url(#kg4)"/>
        <ellipse cx="155" cy="82"  rx="108" ry="68" fill="url(#kg4)"/>
        <ellipse cx="295" cy="74"  rx="88"  ry="58" fill="url(#kg4)"/>
        <ellipse cx="80"  cy="102" rx="74"  ry="52" fill="url(#kg4)"/>
        <path d="M72 80 Q90 56 112 66 Q130 76 120 94" stroke="rgba(255,255,255,0.20)" stroke-width="1.3" fill="none" stroke-linecap="round"/>
        <path d="M134 68 Q155 44 180 56 Q200 68 188 86" stroke="rgba(255,255,255,0.16)" stroke-width="1.2" fill="none" stroke-linecap="round"/>
      </svg>
    </div>

    <!-- Tengah kanan -->
    <div class="kumo kumo-mr">
      <svg viewBox="0 0 400 155" xmlns="http://www.w3.org/2000/svg" fill="none">
        <defs>
          <radialGradient id="kg5" cx="44%" cy="28%" r="66%">
            <stop offset="0%"   stop-color="rgba(222,212,190,0.58)"/>
            <stop offset="100%" stop-color="rgba(174,160,135,0.0)"/>
          </radialGradient>
        </defs>
        <ellipse cx="200" cy="116" rx="200" ry="56" fill="url(#kg5)"/>
        <ellipse cx="148" cy="79"  rx="104" ry="66" fill="url(#kg5)"/>
        <ellipse cx="284" cy="72"  rx="84"  ry="55" fill="url(#kg5)"/>
        <ellipse cx="76"  cy="98"  rx="70"  ry="50" fill="url(#kg5)"/>
        <path d="M68 76 Q86 52 108 62 Q126 72 116 90" stroke="rgba(255,255,255,0.18)" stroke-width="1.2" fill="none" stroke-linecap="round"/>
      </svg>
    </div>

    <!-- Kiri bawah -->
    <div class="kumo kumo-bl">
      <svg viewBox="0 0 460 155" xmlns="http://www.w3.org/2000/svg" fill="none">
        <defs>
          <radialGradient id="kg6" cx="42%" cy="30%" r="70%">
            <stop offset="0%"   stop-color="rgba(230,220,198,0.74)"/>
            <stop offset="100%" stop-color="rgba(178,164,140,0.0)"/>
          </radialGradient>
        </defs>
        <ellipse cx="230" cy="120" rx="230" ry="62" fill="url(#kg6)"/>
        <ellipse cx="172" cy="82"  rx="114" ry="74" fill="url(#kg6)"/>
        <ellipse cx="315" cy="74"  rx="94"  ry="62" fill="url(#kg6)"/>
        <ellipse cx="88"  cy="106" rx="80"  ry="58" fill="url(#kg6)"/>
        <path d="M80 82 Q98 56 120 68 Q140 78 130 96"  stroke="rgba(255,255,255,0.20)" stroke-width="1.4" fill="none" stroke-linecap="round"/>
        <path d="M148 70 Q170 46 196 58 Q218 70 204 90" stroke="rgba(255,255,255,0.16)" stroke-width="1.3" fill="none" stroke-linecap="round"/>
      </svg>
    </div>

    <!-- Kanan bawah -->
    <div class="kumo kumo-br">
      <svg viewBox="0 0 440 148" xmlns="http://www.w3.org/2000/svg" fill="none">
        <defs>
          <radialGradient id="kg7" cx="40%" cy="28%" r="68%">
            <stop offset="0%"   stop-color="rgba(226,216,194,0.70)"/>
            <stop offset="100%" stop-color="rgba(174,160,136,0.0)"/>
          </radialGradient>
        </defs>
        <ellipse cx="220" cy="114" rx="220" ry="58" fill="url(#kg7)"/>
        <ellipse cx="162" cy="78"  rx="110" ry="70" fill="url(#kg7)"/>
        <ellipse cx="300" cy="70"  rx="90"  ry="58" fill="url(#kg7)"/>
        <ellipse cx="84"  cy="100" rx="76"  ry="54" fill="url(#kg7)"/>
        <path d="M76 78 Q94 54 116 64 Q134 74 124 92" stroke="rgba(255,255,255,0.18)" stroke-width="1.3" fill="none" stroke-linecap="round"/>
      </svg>
    </div>

    <!-- Bintang kerlip -->
    <span class="zen-star" style="top:6%;left:10%;font-size:22px;animation-duration:2.8s;animation-delay:0s;color:rgba(255,248,200,.95);">✦</span>
    <span class="zen-star" style="top:4%;right:16%;font-size:28px;animation-duration:3.2s;animation-delay:-.9s;color:rgba(255,248,200,.9);">✦</span>
    <span class="zen-star" style="top:14%;left:42%;font-size:14px;animation-duration:2.4s;animation-delay:-1.5s;color:rgba(255,248,200,.75);">✦</span>
    <span class="zen-star" style="top:22%;right:8%;font-size:16px;animation-duration:3.8s;animation-delay:-.5s;color:rgba(255,248,200,.80);">✦</span>
    <span class="zen-star" style="top:10%;left:66%;font-size:12px;animation-duration:2.6s;animation-delay:-2.1s;color:rgba(255,248,200,.70);">✦</span>
    <span class="zen-star" style="top:30%;left:22%;font-size:10px;animation-duration:4.2s;animation-delay:-1.2s;color:rgba(255,248,200,.55);">✦</span>
    <span class="zen-star" style="top:8%;left:78%;font-size:18px;animation-duration:3.0s;animation-delay:-.3s;color:rgba(255,248,200,.85);">✦</span>
  </div>

  <!-- Kanji dekoratif — lebih besar -->
  <div class="zen-kanji-bg zen-kanji-1">花</div>
  <div class="zen-kanji-bg zen-kanji-2">美</div>
  <div class="zen-kanji-bg zen-kanji-3">然</div>

  <!-- Falling petals -->
  <div id="zen-petals"></div>

  <!-- ═══════════════════════════
       KONTEN HERO — CENTER
  ═══════════════════════════ -->
  <div class="zen-hero-content">

    <div class="zen-overline">
      <span class="zen-overline-dot"></span>
      Florist Terpercaya · Jakarta Pusat
      <span class="zen-overline-kanji">花屋</span>
    </div>

    <span class="zen-brush-line"></span>

    <h1 class="zen-headline">
      <em>Keindahan Bunga</em>
      <span class="zen-hl-accent"><?= e(setting('hero_title')) ?></span>
      <span class="zen-headline-kanji">花 · 美 · 自然</span>
    </h1>

    <div class="zen-rule">
      <div class="zen-rule-line"></div>
      <span class="zen-rule-ornament">
        <span class="zen-rule-diamond"></span>
        <span style="letter-spacing:.22em;font-size:9px;">和の心</span>
        <span class="zen-rule-diamond"></span>
      </span>
      <div class="zen-rule-line rev"></div>
    </div>

    <!-- Subtitle lebih besar & jelas -->
    <p class="zen-subtitle">
      <?= e(setting('hero_subtitle')) ?>
      <span class="zen-subtitle-jp">東京の花屋 · Pengiriman Cepat ke Seluruh Jakarta Pusat</span>
    </p>

    <div class="zen-chips">
      <span class="zen-chip">Antar 2–4 Jam</span>
      <span class="zen-chip">Bunga Segar</span>
      <span class="zen-chip">Custom Design</span>
      <span class="zen-chip">Buka 24 Jam</span>
    </div>

    <div class="zen-ctas">
      <a href="https://wa.me/<?= $wa_url ?>?text=<?= $wa_msg ?>" target="_blank" class="zen-btn-primary">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Pesan via WhatsApp
      </a>
      <a href="#produk" class="zen-btn-secondary">
        Lihat Koleksi
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path d="M12 5v14M5 12l7 7 7-7"/>
        </svg>
      </a>
    </div>

    <!-- ══ MAKIMONO GULUNGAN ══ -->
    <div class="makimono-wrapper" id="makimono">
      <div class="makimono-handle-top" id="makimono-handle">
        <div class="makimono-rope-top"></div>
        <div class="makimono-rod">
          <span class="makimono-rod-label">花の巻物 · Galeri Bunga</span>
        </div>
        <div class="makimono-pull-hint">
          <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
          <span class="hint-text-open">Seret ke bawah untuk membuka</span>
          <span class="hint-text-close">Seret ke atas untuk menutup</span>
          <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
          </svg>
        </div>
      </div>

      <div class="makimono-body" id="makimono-body">
        <div class="makimono-inner" id="makimono-inner">
          <div class="makimono-ornament">
            <div class="makimono-ornament-line"></div>
            <span class="makimono-ornament-kanji">花 · 美 · 自然</span>
            <div class="makimono-ornament-line"></div>
          </div>
          <img class="makimono-photo" src="<?= BASE_URL ?>/assets/images/bannersub.png" alt="Koleksi Bunga">
          <div class="makimono-ornament">
            <div class="makimono-ornament-line"></div>
            <span class="makimono-ornament-kanji">花屋 · Jakarta Pusat</span>
            <div class="makimono-ornament-line"></div>
          </div>
        </div>
      </div>

      <div class="makimono-rod-bottom" id="makimono-rod-bottom"></div>
    </div>

  </div><!-- /zen-hero-content -->

  <!-- ══ STATS BAR — CENTER GAYA JEPANG ══ -->
  <div class="zen-statsbar">
    <div class="zen-statsbar-rule">
      <div class="zen-statsbar-rule-line"></div>
      <span class="zen-statsbar-rule-kanji">花屋の実績 · Pencapaian Kami</span>
      <div class="zen-statsbar-rule-line"></div>
    </div>

    <div class="zen-stats-grid">
      <!-- Harga -->
      <div class="zen-stat-block zen-stat-price">
        <div class="zen-stat-icon">¥花</div>
        <div class="zen-stat-num">Rp 300rb</div>
        <div class="zen-stat-label">Mulai Dari</div>
        <div class="zen-stat-label-jp">はじまり</div>
      </div>

      <div class="zen-stats-divider"></div>

      <!-- Pelanggan -->
      <div class="zen-stat-block">
        <div class="zen-stat-icon">客</div>
        <div class="zen-stat-num">500<sup>+</sup></div>
        <div class="zen-stat-label">Pelanggan Puas</div>
        <div class="zen-stat-label-jp">満足のお客様</div>
      </div>

      <div class="zen-stats-divider"></div>

      <!-- Siap Antar -->
      <div class="zen-stat-block">
        <div class="zen-stat-icon">速</div>
        <div class="zen-stat-num">24<sup>H</sup></div>
        <div class="zen-stat-label">Siap Antar</div>
        <div class="zen-stat-label-jp">配送準備完了</div>
      </div>

      <div class="zen-stats-divider"></div>

      <!-- Kecamatan -->
      <div class="zen-stat-block">
        <div class="zen-stat-icon">地</div>
        <div class="zen-stat-num">12</div>
        <div class="zen-stat-label">Kecamatan</div>
        <div class="zen-stat-label-jp">地区</div>
      </div>
    </div>
  </div><!-- /zen-statsbar -->

</section><!-- /hero-zen -->


<!-- ══ JAPANESE KUMO FEATURE STRIP ══ -->
<section id="kumo-features">
  <div class="kumo-wrapper">

    <div class="kumo-card">
      <div class="kumo-cloud"></div>
      <div class="kumo-icon">
        <img src="<?= BASE_URL ?>/assets/svg/sakura.svg" alt="Sakura">
      </div>
      <h3>Premium Freshness</h3>
      <p>Setiap rangkaian dikirim dalam kondisi terbaik dan tetap mekar sempurna.</p>
    </div>

    <div class="kumo-card">
      <div class="kumo-cloud"></div>
      <div class="kumo-icon">
        <img src="<?= BASE_URL ?>/assets/svg/sensu.svg" alt="Sensu">
      </div>
      <h3>Urgent Orders Welcome</h3>
      <p>Melayani pemesanan mendadak dengan proses cepat dan responsif.</p>
    </div>

    <div class="kumo-card">
      <div class="kumo-cloud"></div>
      <div class="kumo-icon">
        <img src="<?= BASE_URL ?>/assets/svg/koi.svg" alt="Koi">
      </div>
      <h3>Instant Day Delivery</h3>
      <p>Pesanan hari ini langsung diproses dan dikirim tanpa menunggu lama.</p>
    </div>

    <div class="kumo-card">
      <div class="kumo-cloud"></div>
      <div class="kumo-icon">
        <img src="<?= BASE_URL ?>/assets/svg/zen.svg" alt="Zen">
      </div>
      <h3>Floral Advice Service</h3>
      <p>Konsultasi gratis untuk membantu memilih bunga yang paling tepat.</p>
    </div>

    <div class="kumo-card">
      <div class="kumo-cloud"></div>
      <div class="kumo-icon">
        <img src="<?= BASE_URL ?>/assets/svg/crow.svg" alt="Crow">
      </div>
      <h3>Happiness Assured</h3>
      <p>Jika rangkaian tidak sesuai, kami siap mengganti tanpa biaya tambahan.</p>
    </div>

  </div>
</section>

<!-- ══ TICKER ══ -->
<div id="zen-ticker-wrap" aria-hidden="true">
  <div class="zen-ticker-track">
    <?php
    $tickers = [
      ['label'=>'Hand Bouquet Premium', 'kanji'=>'花束'],
      ['label'=>'Bunga Papan Ucapan',   'kanji'=>'花板'],
      ['label'=>'Wedding Decoration',   'kanji'=>'結婚'],
      ['label'=>'Duka Cita',            'kanji'=>'供花'],
      ['label'=>'Buket Wisuda',         'kanji'=>'卒業'],
      ['label'=>'Pengiriman 2–4 Jam',   'kanji'=>'速達'],
      ['label'=>'Custom Design',        'kanji'=>'特注'],
      ['label'=>'Mulai Rp 300.000',     'kanji'=>'低価'],
    ];
    for ($i = 0; $i < 3; $i++):
      foreach ($tickers as $t): ?>
        <span class="zen-ticker-item">
          <span class="zen-ticker-sep">✦</span>
          <?= $t['label'] ?>
          <span class="zen-ticker-kanji"><?= $t['kanji'] ?></span>
        </span>
      <?php endforeach;
    endfor; ?>
  </div>
</div>

<script>
(function () {
  /* ─── Falling Petals ─── */
  const petalWrap = document.getElementById('zen-petals');
  if (petalWrap) {
    const icons = ['🌸','🌺','🌷'];
    for (let i = 0; i < 18; i++) {
      const el  = document.createElement('span');
      el.className = 'zen-petal';
      el.textContent = icons[i % icons.length];
      const dur = 10 + Math.random() * 11;
      el.style.cssText =
        'left:'              + (Math.random() * 100) + '%;' +
        'font-size:'         + (10 + Math.random() * 13) + 'px;' +
        'opacity:'           + (0.2 + Math.random() * 0.5) + ';' +
        'animation-duration:'+ dur + 's;' +
        'animation-delay:-'  + (Math.random() * dur) + 's;';
      petalWrap.appendChild(el);
    }
  }

  /* ─── Makimono Drag ─── */
  const wrapper   = document.getElementById('makimono');
  const handle    = document.getElementById('makimono-handle');
  const body      = document.getElementById('makimono-body');
  const inner     = document.getElementById('makimono-inner');
  const rodBottom = document.getElementById('makimono-rod-bottom');
  if (!wrapper || !handle || !body || !inner) return;

  let FULL_H = 0, isOpen = false, isDrag = false;
  let startY = 0, startH = 0, currH = 0;

  function calcFullH() { FULL_H = inner.scrollHeight; }
  const img = inner.querySelector('img');
  if (img && img.complete) { calcFullH(); }
  else if (img) { img.addEventListener('load', calcFullH); }
  else { calcFullH(); }

  function setH(h, animate) {
    if (FULL_H === 0) calcFullH();
    const clamped = Math.max(0, Math.min(h, FULL_H));
    body.style.transition = animate ? 'height .55s cubic-bezier(.4,0,.2,1)' : 'none';
    body.style.height = clamped + 'px';
    currH = clamped;
    rodBottom.style.display = (clamped > FULL_H * 0.5) ? 'block' : 'none';
    const wasOpen = isOpen;
    isOpen = clamped >= FULL_H * 0.86;
    if (isOpen !== wasOpen) wrapper.classList.toggle('open', isOpen);
  }

  function snapTo(h) {
    setH(h > FULL_H * 0.42 ? FULL_H : 0, true);
  }

  /* Touch */
  handle.addEventListener('touchstart', e => {
    isDrag = true; startY = e.touches[0].clientY; startH = currH;
    body.style.transition = 'none';
  }, { passive: true });
  window.addEventListener('touchmove', e => {
    if (!isDrag) return;
    setH(startH + (e.touches[0].clientY - startY), false);
  }, { passive: true });
  window.addEventListener('touchend', () => {
    if (!isDrag) return; isDrag = false; snapTo(currH);
  });

  /* Mouse */
  let dragMoved = false;
  handle.addEventListener('mousedown', e => {
    isDrag = true; dragMoved = false;
    startY = e.clientY; startH = currH;
    body.style.transition = 'none'; e.preventDefault();
  });
  window.addEventListener('mousemove', e => {
    if (!isDrag) return;
    const dy = e.clientY - startY;
    if (Math.abs(dy) > 4) dragMoved = true;
    setH(startH + dy, false);
  });
  window.addEventListener('mouseup', () => {
    if (!isDrag) return; isDrag = false;
    if (dragMoved) { snapTo(currH); }
    else { setH(isOpen ? 0 : FULL_H, true); }
    dragMoved = false;
  });
})();
</script>