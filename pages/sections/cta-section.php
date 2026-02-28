<?php
/* ================================================================
   CTA SECTION — Obon Festival 盂蘭盆会 (Toro Nagashi)
   Konsep: Festival lentera mengapung di air, langit malam Jepang
           Lentera naik ke langit + kembang api + sakura + kanji raksasa
   Warna: Midnight indigo → hitam tinta, cahaya oranye/emas lentera
   Elemen: Lentera terbang SVG, Hanabi CSS fireworks, Sakura, Kanji dramatik
================================================================ */
?>

<style>
/* ═══════════════════════════════════════════════════════
   OBON CTA — CORE VARIABLES
═══════════════════════════════════════════════════════ */
#obon-cta {
  --night:      #05080f;
  --deep:       #080d18;
  --indigo:     #0d1428;
  --lantern-or: #FF8C38;
  --lantern-yl: #FFD166;
  --lantern-rd: #E05A2B;
  --glow:       #FFAB57;
  --sakura:     #FFB7C5;
  --sakura-dk:  #E8849A;
  --gold:       #C9A96E;
  --gold-lt:    #E8D5A3;
  --washi:      #F5F0E8;
  --water:      #0a1a2e;
  --water-lt:   #0f2540;
  --reflect:    rgba(255,140,56,.15);
  font-family: 'Zen Kaku Gothic New', 'Noto Sans JP', sans-serif;
}

/* ═══════════════════════════════════════════════════════
   KUMO ATAS — FAQ Matcha → CTA Night
═══════════════════════════════════════════════════════ */
.obon-kumo-top {
  position: relative; z-index: 5;
  line-height: 0; margin-bottom: -2px;
  pointer-events: none;
}
.obon-kumo-top svg { display: block; width: 100%; }

/* ═══════════════════════════════════════════════════════
   SECTION WRAPPER
═══════════════════════════════════════════════════════ */
#obon-cta {
  position: relative;
  overflow: hidden;
  min-height: 100vh;
  background:
    radial-gradient(ellipse 80% 50% at 50% 0%, #1a1025 0%, transparent 60%),
    radial-gradient(ellipse 60% 40% at 20% 60%, #0d1e3a 0%, transparent 55%),
    radial-gradient(ellipse 50% 35% at 80% 70%, #1a0d05 0%, transparent 50%),
    linear-gradient(to bottom, #05080f 0%, #080d18 30%, #0d1428 60%, #05080f 100%);
  padding: 0;
}

/* Bintang-bintang di langit */
#obon-cta .obon-stars {
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 1;
}

/* Permukaan air di bagian bawah */
.obon-water {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 28%;
  background: linear-gradient(
    to bottom,
    rgba(10,26,46,.0) 0%,
    rgba(10,26,46,.7) 30%,
    #060f1c 70%,
    #030810 100%
  );
  z-index: 2;
  overflow: hidden;
}

/* Riak air animasi */
.obon-ripple {
  position: absolute;
  border-radius: 50%;
  border: 1px solid rgba(255,140,56,.12);
  animation: obonRipple 4s ease-out infinite;
  transform-origin: center;
}
@keyframes obonRipple {
  0%   { transform: scale(.2); opacity: .8; }
  100% { transform: scale(3); opacity: 0; }
}

/* Refleksi cahaya di air */
.obon-water-reflect {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 100%;
  background:
    repeating-linear-gradient(
      0deg,
      transparent 0px,
      transparent 3px,
      rgba(255,140,56,.025) 3px,
      rgba(255,140,56,.025) 4px
    );
  animation: obonWaterWave 3s ease-in-out infinite alternate;
}
@keyframes obonWaterWave {
  0%   { transform: scaleX(1); }
  100% { transform: scaleX(1.03); }
}

/* ═══════════════════════════════════════════════════════
   KANJI RAKSASA BACKGROUND (DRAMATIS)
═══════════════════════════════════════════════════════ */
.obon-kanji-bg {
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-weight: 900;
  color: rgba(255,140,56,.032);
  pointer-events: none;
  user-select: none;
  writing-mode: vertical-rl;
  line-height: .9;
  z-index: 1;
  animation: obonKanjiFade 8s ease-in-out infinite alternate;
}
@keyframes obonKanjiFade {
  0%   { opacity: .6; transform: translateY(0); }
  100% { opacity: 1;  transform: translateY(-12px); }
}

/* ═══════════════════════════════════════════════════════
   LENTERA TERBANG (SVG inline — Toro Nagashi)
═══════════════════════════════════════════════════════ */
.obon-lantern {
  position: absolute;
  pointer-events: none;
  z-index: 6;
  animation: obonLanternRise linear infinite;
  transform-origin: center bottom;
}

@keyframes obonLanternRise {
  0%   { transform: translateY(0) rotate(0deg);   opacity: 0; }
  5%   { opacity: 1; }
  50%  { transform: translateY(-45vh) rotate(3deg);  opacity: .95; }
  90%  { opacity: .7; }
  100% { transform: translateY(-105vh) rotate(-2deg); opacity: 0; }
}

/* Goyang kiri kanan lentera saat naik */
@keyframes obonLanternSway {
  0%,100% { margin-left: 0; }
  25%     { margin-left: 18px; }
  75%     { margin-left: -18px; }
}
.obon-lantern { animation-name: obonLanternRise, obonLanternSway; }

/* Glow cahaya lentera */
.obon-lantern-glow {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  border-radius: 50%;
  filter: blur(18px);
  animation: obonGlowPulse 2s ease-in-out infinite alternate;
  pointer-events: none;
}
@keyframes obonGlowPulse {
  0%   { opacity: .55; transform: translate(-50%,-50%) scale(1); }
  100% { opacity: .9;  transform: translate(-50%,-50%) scale(1.25); }
}

/* ═══════════════════════════════════════════════════════
   KEMBANG API CSS (Hanabi 花火)
═══════════════════════════════════════════════════════ */
.hanabi-container {
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 5;
  overflow: hidden;
}

.hanabi {
  position: absolute;
  width: 6px; height: 6px;
  border-radius: 50%;
}

/* Trail naik sebelum meledak */
@keyframes hanabiTrail {
  0%   { transform: translateY(0) scaleY(1); opacity: 1; }
  80%  { transform: translateY(-180px) scaleY(2); opacity: 1; }
  100% { transform: translateY(-220px) scaleY(0); opacity: 0; }
}

/* Ledakan burst — partikel menyebar */
@keyframes hanabiBurst {
  0%   { transform: translate(0,0) scale(1); opacity: 1; }
  100% { transform: translate(var(--bx), var(--by)) scale(0); opacity: 0; }
}

/* Shimmer kedip setelah burst */
@keyframes hanabiShimmer {
  0%,100% { opacity: .9; }
  50%     { opacity: .3; }
}

/* ═══════════════════════════════════════════════════════
   SAKURA BETERBANGAN
═══════════════════════════════════════════════════════ */
.obon-sakura {
  position: absolute;
  pointer-events: none;
  z-index: 7;
  animation: obonSakuraFall linear infinite;
  will-change: transform;
}
@keyframes obonSakuraFall {
  0%   { transform: translateY(-5vh) rotate(0deg) translateX(0);   opacity: 0; }
  5%   { opacity: .85; }
  85%  { opacity: .65; }
  100% { transform: translateY(105vh) rotate(720deg) translateX(60px); opacity: 0; }
}
@keyframes obonSakuraSway {
  0%,100% { margin-left: 0; }
  33%     { margin-left: 25px; }
  66%     { margin-left: -20px; }
}

/* ═══════════════════════════════════════════════════════
   INNER CONTENT
═══════════════════════════════════════════════════════ */
.obon-inner {
  position: relative;
  z-index: 10;
  max-width: 1200px;
  margin: 0 auto;
  padding: 100px 24px 140px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* ═══════════════════════════════════════════════════════
   EYEBROW BADGE
═══════════════════════════════════════════════════════ */
.obon-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .22em;
  text-transform: uppercase;
  color: var(--lantern-yl);
  background: rgba(255,209,102,.08);
  border: 1px solid rgba(255,209,102,.22);
  border-radius: 100px;
  padding: 5px 16px;
  margin-bottom: 28px;
  position: relative;
  overflow: hidden;
}
.obon-eyebrow::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, transparent, rgba(255,209,102,.08), transparent);
  animation: obonShimmer 2.5s ease infinite;
  background-size: 200% 100%;
}
@keyframes obonShimmer {
  0%   { background-position: -200% 0; }
  100% { background-position:  200% 0; }
}
.obon-eyebrow-flame {
  font-size: 14px;
  animation: obonFlame .8s ease-in-out infinite alternate;
}
@keyframes obonFlame {
  0%   { transform: scaleY(1)  rotate(-3deg); }
  100% { transform: scaleY(1.2) rotate(3deg); }
}

/* ═══════════════════════════════════════════════════════
   JUDUL RAKSASA
═══════════════════════════════════════════════════════ */
.obon-title-wrap {
  text-align: center;
  margin-bottom: 20px;
  position: relative;
}

.obon-title-ja {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(16px, 2.5vw, 22px);
  font-weight: 300;
  color: rgba(255,209,102,.4);
  letter-spacing: .5em;
  display: block;
  margin-bottom: 8px;
}

.obon-title {
  font-family: 'Noto Serif JP', serif;
  font-size: clamp(38px, 6vw, 82px);
  font-weight: 300;
  line-height: 1.1;
  letter-spacing: .04em;
  margin: 0;
  color: #F5F0E8;
  position: relative;
}

.obon-title-glow {
  /* Teks dengan glow lentera */
  background: linear-gradient(
    135deg,
    #F5F0E8 0%,
    #FFD166 35%,
    #FF8C38 55%,
    #FFD166 75%,
    #F5F0E8 100%
  );
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: obonTitleShine 4s linear infinite;
  text-shadow: none;
  filter: drop-shadow(0 0 30px rgba(255,140,56,.3));
}
@keyframes obonTitleShine {
  0%   { background-position: 0% center; }
  100% { background-position: 200% center; }
}

/* Brush stroke bawah judul */
.obon-brush {
  display: block;
  margin: 14px auto 0;
  opacity: .5;
}

/* ═══════════════════════════════════════════════════════
   SUBTITLE
═══════════════════════════════════════════════════════ */
.obon-subtitle {
  font-size: clamp(14px, 1.8vw, 17px);
  color: rgba(245,240,232,.45);
  letter-spacing: .06em;
  line-height: 1.8;
  max-width: 560px;
  text-align: center;
  margin: 22px 0 48px;
}
.obon-subtitle em {
  font-style: normal;
  color: rgba(255,209,102,.7);
}

/* ═══════════════════════════════════════════════════════
   CTA BUTTONS
═══════════════════════════════════════════════════════ */
.obon-btns {
  display: flex;
  gap: 16px;
  flex-wrap: wrap;
  justify-content: center;
  margin-bottom: 56px;
}

/* Button WA — utama dengan glow api */
.obon-btn-main {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: linear-gradient(135deg, #FF8C38 0%, #E05A2B 50%, #FF8C38 100%);
  background-size: 200% auto;
  color: #fff;
  font-weight: 700;
  font-size: 15px;
  padding: 17px 36px;
  border-radius: 100px;
  text-decoration: none;
  box-shadow:
    0 0 0 1px rgba(255,140,56,.3),
    0 8px 32px rgba(224,90,43,.45),
    0 0 60px rgba(255,140,56,.2);
  transition: all .35s ease;
  letter-spacing: .04em;
  position: relative;
  overflow: hidden;
  animation: obonBtnGlow 3s ease-in-out infinite alternate;
}
@keyframes obonBtnGlow {
  0%   { box-shadow: 0 0 0 1px rgba(255,140,56,.3), 0 8px 32px rgba(224,90,43,.45), 0 0 40px rgba(255,140,56,.15); }
  100% { box-shadow: 0 0 0 1px rgba(255,209,102,.5), 0 12px 40px rgba(255,140,56,.55), 0 0 80px rgba(255,140,56,.25); }
}
.obon-btn-main::before {
  content: '';
  position: absolute;
  top: -2px; left: -2px; right: -2px; bottom: -2px;
  border-radius: 100px;
  background: linear-gradient(135deg, rgba(255,209,102,.4), transparent, rgba(255,140,56,.3));
  opacity: 0;
  transition: opacity .3s ease;
}
.obon-btn-main:hover {
  background-position: right center;
  transform: translateY(-3px) scale(1.02);
}
.obon-btn-main:hover::before { opacity: 1; }

/* Button katalog — outline emas */
.obon-btn-sec {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,209,102,.05);
  color: var(--lantern-yl);
  font-weight: 600;
  font-size: 14px;
  padding: 16px 32px;
  border-radius: 100px;
  text-decoration: none;
  border: 1.5px solid rgba(255,209,102,.3);
  transition: all .3s ease;
  letter-spacing: .04em;
  backdrop-filter: blur(8px);
}
.obon-btn-sec:hover {
  background: rgba(255,209,102,.12);
  border-color: rgba(255,209,102,.6);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(255,209,102,.15);
}

/* ═══════════════════════════════════════════════════════
   TRUST STATS STRIP
═══════════════════════════════════════════════════════ */
.obon-stats {
  display: flex;
  gap: 0;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 48px;
}
.obon-stat {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 18px 36px;
  position: relative;
  transition: transform .3s ease;
}
.obon-stat:hover { transform: translateY(-4px); }
.obon-stat + .obon-stat::before {
  content: '';
  position: absolute;
  left: 0; top: 20%; bottom: 20%;
  width: 1px;
  background: linear-gradient(to bottom, transparent, rgba(255,209,102,.2), transparent);
}
.obon-stat-icon {
  font-size: 22px;
  margin-bottom: 6px;
  filter: drop-shadow(0 0 6px rgba(255,140,56,.4));
}
.obon-stat-num {
  font-family: 'Noto Serif JP', serif;
  font-size: 28px;
  font-weight: 300;
  color: var(--gold-lt);
  line-height: 1;
  letter-spacing: .04em;
}
.obon-stat-num sub {
  font-size: 14px;
  color: var(--lantern-yl);
  vertical-align: baseline;
}
.obon-stat-lbl {
  font-size: 9.5px;
  font-weight: 700;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: rgba(245,240,232,.3);
  margin-top: 4px;
}

/* ═══════════════════════════════════════════════════════
   DIVIDER — TALI LENTERA
═══════════════════════════════════════════════════════ */
.obon-divider {
  width: 100%;
  max-width: 600px;
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(255,209,102,.1) 20%,
    rgba(255,140,56,.35) 50%,
    rgba(255,209,102,.1) 80%,
    transparent 100%
  );
  margin: 0 auto 40px;
  position: relative;
}
.obon-divider::before {
  content: '盂蘭盆会';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-family: 'Noto Serif JP', serif;
  font-size: 10px;
  font-weight: 300;
  color: rgba(255,209,102,.35);
  letter-spacing: .3em;
  white-space: nowrap;
  background: #05080f;
  padding: 0 12px;
}

/* ═══════════════════════════════════════════════════════
   FOOTER STRIP
═══════════════════════════════════════════════════════ */
.obon-footer-strip {
  display: flex;
  align-items: center;
  gap: 24px;
  flex-wrap: wrap;
  justify-content: center;
}
.obon-trust-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 11.5px;
  font-weight: 600;
  color: rgba(245,240,232,.45);
  letter-spacing: .06em;
}
.obon-trust-pill span {
  font-size: 15px;
  filter: drop-shadow(0 0 4px rgba(255,140,56,.3));
}

/* ═══════════════════════════════════════════════════════
   SITE FOOTER MINI
═══════════════════════════════════════════════════════ */
.obon-site-footer {
  width: 100%;
  border-top: 1px solid rgba(255,209,102,.08);
  margin-top: 60px;
  padding-top: 32px;
  text-align: center;
}
.obon-footer-brand {
  font-family: 'Noto Serif JP', serif;
  font-size: 20px;
  font-weight: 300;
  color: rgba(245,240,232,.6);
  letter-spacing: .15em;
  margin-bottom: 8px;
}
.obon-footer-sub {
  font-size: 11px;
  color: rgba(245,240,232,.2);
  letter-spacing: .12em;
}

/* ═══════════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════════ */
@media (max-width: 600px) {
  .obon-inner { padding: 80px 16px 120px; }
  .obon-stat  { padding: 14px 20px; }
  .obon-title { font-size: clamp(32px, 9vw, 52px); }
  .obon-btns  { flex-direction: column; align-items: center; }
  .obon-btn-main, .obon-btn-sec { width: 100%; max-width: 300px; justify-content: center; }
}
</style>

<!-- ═══════════════════════════════════════
     KUMO ATAS — FAQ Matcha → Night
═══════════════════════════════════════ -->
<div class="obon-kumo-top" aria-hidden="true">
  <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,0 L1440,0 L1440,120 L0,120 Z" fill="#7A8C6E"/>
    <ellipse cx="60"   cy="118" rx="105" ry="44" fill="#05080f" opacity=".95"/>
    <ellipse cx="42"   cy="115" rx="68"  ry="30" fill="#05080f" opacity=".9"/>
    <ellipse cx="158"  cy="116" rx="94"  ry="38" fill="#05080f" opacity=".92"/>
    <ellipse cx="248"  cy="118" rx="84"  ry="35" fill="#05080f" opacity=".88"/>
    <ellipse cx="335"  cy="115" rx="100" ry="40" fill="#05080f" opacity=".9"/>
    <ellipse cx="438"  cy="117" rx="92"  ry="37" fill="#05080f" opacity=".87"/>
    <ellipse cx="530"  cy="115" rx="108" ry="42" fill="#05080f" opacity=".93"/>
    <ellipse cx="638"  cy="118" rx="90"  ry="37" fill="#05080f" opacity=".9"/>
    <ellipse cx="738"  cy="114" rx="104" ry="41" fill="#05080f" opacity=".88"/>
    <ellipse cx="840"  cy="117" rx="96"  ry="38" fill="#05080f" opacity=".91"/>
    <ellipse cx="940"  cy="115" rx="108" ry="42" fill="#05080f" opacity=".9"/>
    <ellipse cx="1042" cy="118" rx="92"  ry="37" fill="#05080f" opacity=".87"/>
    <ellipse cx="1132" cy="114" rx="102" ry="41" fill="#05080f" opacity=".92"/>
    <ellipse cx="1222" cy="117" rx="96"  ry="38" fill="#05080f" opacity=".89"/>
    <ellipse cx="1312" cy="115" rx="92"  ry="37" fill="#05080f" opacity=".9"/>
    <ellipse cx="1398" cy="118" rx="104" ry="41" fill="#05080f" opacity=".88"/>
    <ellipse cx="1440" cy="115" rx="84"  ry="34" fill="#05080f" opacity=".85"/>
    <ellipse cx="100"  cy="120" rx="72"  ry="28" fill="#7A8C6E" opacity=".5"/>
    <ellipse cx="290"  cy="120" rx="85"  ry="32" fill="#7A8C6E" opacity=".45"/>
    <ellipse cx="492"  cy="120" rx="76"  ry="30" fill="#7A8C6E" opacity=".5"/>
    <ellipse cx="692"  cy="120" rx="90"  ry="34" fill="#7A8C6E" opacity=".48"/>
    <ellipse cx="892"  cy="120" rx="80"  ry="31" fill="#7A8C6E" opacity=".5"/>
    <ellipse cx="1092" cy="120" rx="86"  ry="33" fill="#7A8C6E" opacity=".45"/>
    <ellipse cx="1292" cy="120" rx="80"  ry="31" fill="#7A8C6E" opacity=".48"/>
  </svg>
</div>

<!-- ═══════════════════════════════════════
     OBON CTA SECTION
═══════════════════════════════════════ -->
<section id="obon-cta" role="region" aria-label="Pesan Bunga Sekarang">

  <!-- ── Bintang ── -->
  <canvas class="obon-stars" id="obon-stars-canvas" aria-hidden="true"></canvas>

  <!-- ── Kanji Raksasa Background ── -->
  <div class="obon-kanji-bg" style="font-size:clamp(200px,22vw,340px);left:-2%;top:5%;animation-delay:0s;">花</div>
  <div class="obon-kanji-bg" style="font-size:clamp(160px,18vw,280px);right:-1%;top:20%;animation-delay:-4s;animation-direction:alternate-reverse;">盆</div>
  <div class="obon-kanji-bg" style="font-size:clamp(120px,14vw,220px);left:8%;bottom:15%;animation-delay:-7s;">火</div>
  <div class="obon-kanji-bg" style="font-size:clamp(140px,16vw,250px);right:5%;bottom:8%;animation-delay:-2s;">灯</div>
  <div class="obon-kanji-bg" style="font-size:clamp(100px,11vw,180px);left:40%;top:3%;animation-delay:-5s;writing-mode:horizontal-tb;letter-spacing:.2em;">夏</div>

  <!-- ── Hanabi (Kembang Api) Container ── -->
  <div class="hanabi-container" id="hanabi-container" aria-hidden="true"></div>

  <!-- ── Sakura Container ── -->
  <div id="obon-sakura-wrap" class="absolute inset-0 pointer-events-none z-[7] overflow-hidden" aria-hidden="true"></div>

  <!-- ── Lentera Container ── -->
  <div id="obon-lantern-wrap" class="absolute inset-0 pointer-events-none z-[6] overflow-hidden" aria-hidden="true"></div>

  <!-- ── Permukaan Air ── -->
  <div class="obon-water" aria-hidden="true">
    <div class="obon-water-reflect"></div>
    <!-- Ripple cahaya lentera di air -->
    <div class="obon-ripple" style="width:120px;height:60px;left:25%;bottom:30%;animation-delay:0s;"></div>
    <div class="obon-ripple" style="width:90px;height:45px;left:55%;bottom:40%;animation-delay:-1.5s;"></div>
    <div class="obon-ripple" style="width:140px;height:70px;left:70%;bottom:25%;animation-delay:-2.8s;"></div>
    <div class="obon-ripple" style="width:80px;height:40px;left:15%;bottom:50%;animation-delay:-1s;"></div>
  </div>

  <!-- ── Inner Content ── -->
  <div class="obon-inner">

    <!-- Eyebrow -->
    <div class="obon-eyebrow">
      <span class="obon-eyebrow-flame">🏮</span>
      盂蘭盆会 · Obon Festival · Pesan Sekarang
    </div>

    <!-- Judul -->
    <div class="obon-title-wrap">
      <span class="obon-title-ja">花の灯り — Cahaya Bunga</span>
      <h2 class="obon-title">
        Kirimkan
        <span class="obon-title-glow"> Kebahagiaan</span><br>
        Bersama Bunga
      </h2>
      <svg class="obon-brush" width="280" height="16" viewBox="0 0 280 16" fill="none">
        <path d="M10,12 Q40,4 80,9 Q120,14 160,8 Q200,3 240,10 Q260,13 272,9"
              stroke="#FF8C38" stroke-width="2.5" stroke-linecap="round" fill="none" opacity=".6"/>
        <path d="M25,13 Q70,6 115,10 Q160,14 205,8 Q238,5 268,11"
              stroke="#FFD166" stroke-width="1" stroke-linecap="round" fill="none" opacity=".25"/>
      </svg>
    </div>

    <!-- Subtitle -->
    <p class="obon-subtitle">
      Seperti lentera Obon yang membawa cahaya dalam kegelapan,<br>
      bunga kami hadir untuk <em>menerangi setiap momen berharga</em> Anda.
    </p>

    <!-- CTA Buttons -->
    <div class="obon-btns">
      <a href="<?= isset($wa_url) ? htmlspecialchars($wa_url, ENT_QUOTES) : '#' ?>?text=<?= urlencode('Halo! Saya ingin memesan bunga dari Hana no Yado 🌸') ?>"
         target="_blank" rel="noopener noreferrer"
         class="obon-btn-main">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        🏮 Pesan via WhatsApp
      </a>
      <a href="<?= isset($katalog_url) ? htmlspecialchars($katalog_url, ENT_QUOTES) : '#produk' ?>"
         class="obon-btn-sec">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10"/>
        </svg>
        Lihat Katalog Bunga
      </a>
    </div>

    <!-- Stats -->
    <div class="obon-stats">
      <div class="obon-stat">
        <div class="obon-stat-icon">🌸</div>
        <div class="obon-stat-num">500<sub>+</sub></div>
        <div class="obon-stat-lbl">Pelanggan Puas</div>
      </div>
      <div class="obon-stat">
        <div class="obon-stat-icon">⭐</div>
        <div class="obon-stat-num">4.9<sub>★</sub></div>
        <div class="obon-stat-lbl">Rating Google</div>
      </div>
      <div class="obon-stat">
        <div class="obon-stat-icon">🏮</div>
        <div class="obon-stat-num">5<sub>th</sub></div>
        <div class="obon-stat-lbl">Tahun Berpengalaman</div>
      </div>
      <div class="obon-stat">
        <div class="obon-stat-icon">🚀</div>
        <div class="obon-stat-num">2-4<sub>jam</sub></div>
        <div class="obon-stat-lbl">Pengiriman</div>
      </div>
    </div>

    <!-- Divider -->
    <div class="obon-divider"></div>

    <!-- Trust pills -->
    <div class="obon-footer-strip">
      <span class="obon-trust-pill"><span>🏮</span> Buka 24 Jam / 7 Hari</span>
      <span class="obon-trust-pill"><span>🌸</span> 100% Bunga Segar</span>
      <span class="obon-trust-pill"><span>✈️</span> Kirim Se-Jakarta Pusat</span>
      <span class="obon-trust-pill"><span>💯</span> Garansi Kepuasan</span>
    </div>

    <!-- Mini site footer -->
    <div class="obon-site-footer">
      <div class="obon-footer-brand">花の宿 · Hana no Yado</div>
      <div class="obon-footer-sub">© <?= date('Y') ?> Hana no Yado. Semua Hak Dilindungi. · Jakarta Pusat</div>
    </div>

  </div><!-- /obon-inner -->
</section>

<script>
(function () {
  'use strict';

  /* ══════════════════════════════════
     1. CANVAS BINTANG
  ══════════════════════════════════ */
  (function initStars() {
    const canvas = document.getElementById('obon-stars-canvas');
    if (!canvas) return;
    const ctx  = canvas.getContext('2d');
    const stars = [];
    const N = 220;

    function resize() {
      canvas.width  = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    for (let i = 0; i < N; i++) {
      stars.push({
        x: Math.random(),
        y: Math.random() * .65,
        r: Math.random() * 1.4 + .2,
        a: Math.random(),
        spd: .002 + Math.random() * .004,
        phase: Math.random() * Math.PI * 2
      });
    }

    let frame = 0;
    function draw() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      stars.forEach(s => {
        s.a = .3 + .7 * Math.abs(Math.sin(frame * s.spd + s.phase));
        ctx.beginPath();
        ctx.arc(s.x * canvas.width, s.y * canvas.height, s.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(255, 240, 200, ${s.a})`;
        ctx.fill();
      });
      frame++;
      requestAnimationFrame(draw);
    }
    draw();
  })();

  /* ══════════════════════════════════
     2. LENTERA TERBANG (SVG)
  ══════════════════════════════════ */
  (function initLanterns() {
    const wrap = document.getElementById('obon-lantern-wrap');
    if (!wrap) return;

    const colors = [
      { body: '#FF8C38', glow: 'rgba(255,140,56,.5)',  top: '#E05A2B' },
      { body: '#FFD166', glow: 'rgba(255,209,102,.5)', top: '#C9A96E' },
      { body: '#FF6B6B', glow: 'rgba(255,107,107,.4)', top: '#C0392B' },
      { body: '#FF9F43', glow: 'rgba(255,159,67,.45)', top: '#E07B20' },
      { body: '#FFEAA7', glow: 'rgba(255,234,167,.4)', top: '#C9A96E' },
    ];

    function makeLanternSVG(c, size) {
      const w = size, h = size * 1.6;
      const hw = w / 2, hh = h / 2;
      return `
        <svg width="${w}" height="${h + 20}" viewBox="0 0 ${w} ${h + 20}" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Tali atas -->
          <line x1="${hw}" y1="0" x2="${hw}" y2="${h * .12}" stroke="${c.top}" stroke-width="1.5" opacity=".7"/>
          <!-- Bodi lentera utama -->
          <ellipse cx="${hw}" cy="${hh + h*.1}" rx="${hw * .85}" ry="${hh * .9}"
                   fill="${c.body}" opacity=".82"/>
          <!-- Highlight kiri -->
          <ellipse cx="${hw * .55}" cy="${hh + h*.08}" rx="${hw * .3}" ry="${hh * .6}"
                   fill="rgba(255,255,255,.18)"/>
          <!-- Garis dekoratif vertikal -->
          <line x1="${hw * .5}" y1="${h * .18}" x2="${hw * .5}" y2="${h * .88}" stroke="rgba(0,0,0,.12)" stroke-width="1"/>
          <line x1="${hw}" y1="${h * .16}" x2="${hw}" y2="${h * .9}" stroke="rgba(0,0,0,.1)" stroke-width="1"/>
          <line x1="${hw * 1.5}" y1="${h * .18}" x2="${hw * 1.5}" y2="${h * .88}" stroke="rgba(0,0,0,.12)" stroke-width="1"/>
          <!-- Rim atas & bawah -->
          <ellipse cx="${hw}" cy="${h * .22}" rx="${hw * .82}" ry="${h * .08}" fill="${c.top}" opacity=".9"/>
          <ellipse cx="${hw}" cy="${h * .88}" rx="${hw * .82}" ry="${h * .07}" fill="${c.top}" opacity=".9"/>
          <!-- Api dalam (inner glow) -->
          <ellipse cx="${hw}" cy="${hh + h*.05}" rx="${hw * .35}" ry="${hh * .4}"
                   fill="rgba(255,240,150,.55)" filter="url(#lf)"/>
          <!-- Tali bawah dengan nampan -->
          <line x1="${hw}" y1="${h * .92}" x2="${hw}" y2="${h + 14}" stroke="${c.top}" stroke-width="1.2" opacity=".6"/>
          <ellipse cx="${hw}" cy="${h + 14}" rx="${hw * .4}" ry="4" fill="${c.top}" opacity=".5"/>
          <defs>
            <filter id="lf" x="-50%" y="-50%" width="200%" height="200%">
              <feGaussianBlur stdDeviation="3"/>
            </filter>
          </defs>
        </svg>`;
    }

    const configs = [
      { left: '8%',  delay: 0,    dur: 14, size: 48, ci: 0 },
      { left: '18%', delay: 2.5,  dur: 18, size: 36, ci: 1 },
      { left: '30%', delay: 5,    dur: 16, size: 56, ci: 2 },
      { left: '45%', delay: 1,    dur: 20, size: 42, ci: 0 },
      { left: '58%', delay: 7,    dur: 15, size: 52, ci: 3 },
      { left: '70%', delay: 3.5,  dur: 17, size: 38, ci: 1 },
      { left: '82%', delay: 9,    dur: 19, size: 46, ci: 4 },
      { left: '92%', delay: 6,    dur: 13, size: 34, ci: 2 },
      { left: '22%', delay: 11,   dur: 22, size: 44, ci: 3 },
      { left: '65%', delay: 13,   dur: 16, size: 40, ci: 0 },
    ];

    configs.forEach(cfg => {
      const c   = colors[cfg.ci];
      const el  = document.createElement('div');
      el.className = 'obon-lantern';
      el.style.cssText = `
        left: ${cfg.left};
        bottom: 28%;
        animation-duration: ${cfg.dur}s, ${cfg.dur * .4}s;
        animation-delay: -${cfg.delay}s, -${cfg.delay * .3}s;
        animation-timing-function: linear, ease-in-out;
        animation-iteration-count: infinite, infinite;
      `;
      el.innerHTML = makeLanternSVG(c, cfg.size);

      /* Glow cahaya di belakang lentera */
      const glow = document.createElement('div');
      glow.className = 'obon-lantern-glow';
      glow.style.cssText = `
        width: ${cfg.size * 2.5}px;
        height: ${cfg.size * 2.5}px;
        background: radial-gradient(circle, ${c.glow} 0%, transparent 70%);
      `;
      el.appendChild(glow);
      wrap.appendChild(el);
    });
  })();

  /* ══════════════════════════════════
     3. HANABI KEMBANG API CSS
  ══════════════════════════════════ */
  (function initHanabi() {
    const container = document.getElementById('hanabi-container');
    if (!container) return;

    const palettes = [
      ['#FF8C38','#FFD166','#FFAB57','#FF6B6B'],
      ['#FFB7C5','#FF8C38','#FFD166','#FFF0A0'],
      ['#C9A96E','#E8D5A3','#FFD166','#FFFFFF'],
      ['#FF6B6B','#FF8C38','#FFD166','#FFAB57'],
      ['#A8BF9A','#FFD166','#F5F0E8','#FF8C38'],
    ];

    function explode(x, y, palette) {
      const count = 18 + Math.floor(Math.random() * 12);
      for (let i = 0; i < count; i++) {
        const p  = document.createElement('div');
        p.className = 'hanabi';
        const ang  = (Math.PI * 2 / count) * i + (Math.random() - .5) * .4;
        const dist = 60 + Math.random() * 100;
        const bx   = Math.cos(ang) * dist;
        const by   = Math.sin(ang) * dist;
        const clr  = palette[Math.floor(Math.random() * palette.length)];
        const sz   = 3 + Math.random() * 4;
        const dur  = .6 + Math.random() * .5;
        p.style.cssText = `
          left: ${x}px; top: ${y}px;
          width: ${sz}px; height: ${sz}px;
          background: ${clr};
          box-shadow: 0 0 ${sz * 2}px ${clr}, 0 0 ${sz * 4}px ${clr}66;
          --bx: ${bx}px; --by: ${by}px;
          animation: hanabiBurst ${dur}s cubic-bezier(.2,.8,.3,1) ${i * 12}ms forwards,
                     hanabiShimmer .25s ease-in-out ${i * 8}ms 3;
        `;
        container.appendChild(p);
        setTimeout(() => p.remove(), 1200 + i * 12);
      }
    }

    /* Inject keyframes */
    if (!document.getElementById('hanabi-kf')) {
      const sty = document.createElement('style');
      sty.id = 'hanabi-kf';
      sty.textContent = `
        @keyframes hanabiBurst {
          0%   { transform: translate(0,0) scale(1); opacity: 1; }
          100% { transform: translate(var(--bx),var(--by)) scale(0); opacity: 0; }
        }
        @keyframes hanabiShimmer {
          0%,100% { opacity: .9; } 50% { opacity: .3; }
        }
      `;
      document.head.appendChild(sty);
    }

    /* Jadwal ledakan berulang */
    const positions = [
      [.15, .15], [.85, .12], [.5, .08],
      [.25, .22], [.72, .18], [.4,  .3],
      [.62, .25], [.88, .3],  [.1,  .28],
    ];
    let pi = 0;

    function scheduleNext() {
      const delay = 1200 + Math.random() * 2200;
      setTimeout(() => {
        const section = document.getElementById('obon-cta');
        if (!section) return;
        const rect = section.getBoundingClientRect();
        /* Hanya tembak jika section kelihatan */
        if (rect.bottom > 0 && rect.top < window.innerHeight) {
          const pos = positions[pi % positions.length];
          const cx  = section.offsetWidth  * pos[0];
          const cy  = section.offsetHeight * pos[1];
          const pal = palettes[pi % palettes.length];
          explode(cx, cy, pal);
          pi++;
        }
        scheduleNext();
      }, delay);
    }
    scheduleNext();
  })();

  /* ══════════════════════════════════
     4. SAKURA BETERBANGAN
  ══════════════════════════════════ */
  (function initSakura() {
    const wrap = document.getElementById('obon-sakura-wrap');
    if (!wrap) return;

    /* SVG kelopak sakura mini */
    function petalSVG(clr, size) {
      return `<svg width="${size}" height="${size}" viewBox="0 0 20 20" fill="${clr}" xmlns="http://www.w3.org/2000/svg" opacity=".85">
        <path d="M10 2 C8 0, 4 2, 4 6 C4 8, 6 10, 10 10 C14 10, 16 8, 16 6 C16 2, 12 0, 10 2Z"/>
        <path d="M10 18 C8 20, 4 18, 4 14 C4 12, 6 10, 10 10 C14 10, 16 12, 16 14 C16 18, 12 20, 10 18Z" opacity=".7"/>
      </svg>`;
    }

    const sakuraColors = ['#FFB7C5','#FF8FAB','#FFC4D0','#FFD5DD','#FFE4EA'];
    const count = 28;

    for (let i = 0; i < count; i++) {
      const el   = document.createElement('div');
      el.className = 'obon-sakura';
      const size = 8 + Math.random() * 10;
      const dur  = 8 + Math.random() * 10;
      const sway = 3 + Math.random() * 4;
      const clr  = sakuraColors[i % sakuraColors.length];
      el.innerHTML = petalSVG(clr, size);
      el.style.cssText = `
        left: ${Math.random() * 100}%;
        top: ${-size}px;
        animation-duration: ${dur}s, ${sway}s;
        animation-delay: -${Math.random() * dur}s, -${Math.random() * sway}s;
        animation-name: obonSakuraFall, obonSakuraSway;
        animation-timing-function: linear, ease-in-out;
        animation-iteration-count: infinite, infinite;
      `;
      wrap.appendChild(el);
    }

    /* Inject sway keyframe */
    if (!document.getElementById('sakura-sway-kf')) {
      const sty = document.createElement('style');
      sty.id = 'sakura-sway-kf';
      sty.textContent = `
        @keyframes obonSakuraSway {
          0%,100% { margin-left: 0; }
          33%     { margin-left: 28px; }
          66%     { margin-left: -22px; }
        }
      `;
      document.head.appendChild(sty);
    }
  })();

})();
</script>