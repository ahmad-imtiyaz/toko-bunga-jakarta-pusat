<?php
$wa_url  = setting('whatsapp_url');
$wa_msg  = urlencode('Halo, saya ingin memesan bunga dari Toko Bunga Jakarta Pusat. Mohon info lebih lanjut.');
$wa_full = $wa_url . '?text=' . $wa_msg;
$cats    = db()->query("SELECT name, slug FROM categories WHERE status='active' ORDER BY id LIMIT 10")->fetchAll();
$locs    = db()->query("SELECT name, slug FROM locations WHERE status='active' ORDER BY id")->fetchAll();
?>

<style>
/* ================================================================
   FOOTER — Hana no Yado | Japanese Zen Wabi-Sabi
   Tema: Kotatsu no Yoru (炬燵の夜) — Malam di bawah kehangatan
   Warna: Night Sky #0f0d0a → Sumi Black #1C1C1C → Washi Cream #F5F0E8
================================================================ */

@import url('https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200;300;400&family=Zen+Kaku+Gothic+New:wght@300;400&family=Cormorant+Garamond:ital,wght@0,300;1,300&display=swap');

#hana-footer {
  --night:   #0f0d0a;
  --sumi:    #1C1C1C;
  --washi:   #F5F0E8;
  --tatami:  #EDE8DF;
  --matcha:  #7A8C6E;
  --shiitake:#8B6F5E;
  --bamboo:  #C4A882;
  --blush:   #E8C4B8;
  --hanko:   #8B2020;
  --gold:    #C8A96E;
  --gold-lt: #E8D5A3;
  --ink:     rgba(245,240,232,.08);
  --ink-md:  rgba(245,240,232,.15);
  --ink-hi:  rgba(200,169,110,.25);

  font-family: 'Zen Kaku Gothic New', sans-serif;
  background: var(--night);
  position: relative;
  overflow: hidden;
}

/* ── Kumo Atas dari CTA (Night Sky → Night Sky, seamless) ── */
.footer-kumo-top {
  position: relative;
  z-index: 2;
  pointer-events: none;
  margin-bottom: -2px;
  line-height: 0;
}
.footer-kumo-top svg { display: block; width: 100%; }

/* ── Background Layers ── */
#hana-footer::before {
  content: '';
  position: absolute; inset: 0;
  background:
    repeating-linear-gradient(
      90deg,
      transparent 0px,
      transparent 59px,
      rgba(245,240,232,.018) 59px,
      rgba(245,240,232,.018) 60px
    ),
    repeating-linear-gradient(
      0deg,
      transparent 0px,
      transparent 59px,
      rgba(245,240,232,.018) 59px,
      rgba(245,240,232,.018) 60px
    );
  pointer-events: none;
  z-index: 0;
}

/* Washi noise */
#hana-footer::after {
  content: '';
  position: absolute; inset: 0;
  opacity: .04;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 0;
}

/* ── Kanji Dekoratif Background ── */
.footer-kanji-bg {
  position: absolute; top: 0; left: 0; right: 0; bottom: 0;
  pointer-events: none; z-index: 0; overflow: hidden;
}
.footer-kanji-bg span {
  position: absolute;
  font-family: 'Noto Serif JP', serif;
  font-weight: 200;
  color: rgba(245,240,232,.04);
  writing-mode: vertical-rl;
  text-orientation: upright;
  user-select: none;
  animation: kanjiFloat 18s ease-in-out infinite;
}
@keyframes kanjiFloat {
  0%,100% { transform: translateY(0) rotate(0deg); opacity: .04; }
  33%      { transform: translateY(-14px) rotate(.5deg); opacity: .07; }
  66%      { transform: translateY(8px) rotate(-.3deg); opacity: .03; }
}

/* ── Glow orb background ── */
.footer-orb {
  position: absolute; border-radius: 50%;
  pointer-events: none; z-index: 0;
  animation: softPulse 8s ease-in-out infinite;
}
@keyframes softPulse {
  0%,100% { opacity: .5; transform: scale(1); }
  50%     { opacity: .8; transform: scale(1.08); }
}

/* ── Main footer content ── */
.footer-inner {
  position: relative; z-index: 1;
  max-width: 1280px;
  margin: 0 auto;
  padding: 72px 40px 0;
}

/* ── Rod kayu atas (gulungan Jepang) ── */
.footer-rod-top {
  position: relative;
  height: 14px;
  margin-bottom: 52px;
}
.footer-rod-top .rod-bar {
  width: 100%; height: 14px;
  border-radius: 7px;
  background: linear-gradient(180deg,
    #6B4F3A 0%, #8B6F5E 20%, #A0816E 45%,
    #7A5C4A 70%, #5C3D2B 100%
  );
  box-shadow: 0 4px 16px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.1);
  position: relative;
  /* Bambu node marks */
  background-image:
    linear-gradient(180deg, #6B4F3A 0%, #8B6F5E 20%, #A0816E 45%, #7A5C4A 70%, #5C3D2B 100%),
    repeating-linear-gradient(90deg,
      transparent 0px, transparent 119px,
      rgba(0,0,0,.2) 119px, rgba(0,0,0,.2) 122px,
      rgba(255,255,255,.05) 122px, rgba(255,255,255,.05) 124px,
      transparent 124px
    );
  background-blend-mode: normal;
}
.footer-rod-top::before,
.footer-rod-top::after {
  content: '';
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 22px; height: 22px; border-radius: 50%;
  background: radial-gradient(circle at 35% 35%,
    #F0D080 0%, #C8A96E 40%, #9B7A3A 80%, #6B4F20 100%
  );
  box-shadow: 0 3px 10px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.3);
  z-index: 2;
}
.footer-rod-top::before { left: -6px; }
.footer-rod-top::after  { right: -6px; }

/* ── Section heading (kolom footer) ── */
.footer-col-heading {
  font-family: 'Noto Serif JP', serif;
  font-weight: 300;
  font-size: 13px;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 20px;
  padding-bottom: 12px;
  position: relative;
  display: flex; align-items: center; gap: 10px;
}
.footer-col-heading .kanji-label {
  font-size: 18px;
  color: rgba(200,169,110,.6);
  font-weight: 200;
}
.footer-col-heading::after {
  content: '';
  position: absolute; bottom: 0; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, var(--gold) 0%, rgba(200,169,110,.1) 100%);
}
/* Brush stroke di bawah garis */
.footer-col-heading::before {
  content: '';
  position: absolute; bottom: -3px; left: 0;
  width: 40px; height: 3px;
  background: var(--hanko);
  border-radius: 2px;
  opacity: .7;
}

/* ── Footer links ── */
.footer-link-item {
  display: flex; align-items: center; gap: 8px;
  color: rgba(245,240,232,.5);
  font-size: 13.5px;
  text-decoration: none;
  padding: 5px 0;
  transition: color .2s ease, padding-left .2s ease, gap .2s ease;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-weight: 300;
}
.footer-link-item .link-arrow {
  font-size: 10px;
  color: var(--hanko);
  opacity: .6;
  transition: opacity .2s, transform .2s;
  flex-shrink: 0;
}
.footer-link-item:hover {
  color: var(--gold-lt);
  padding-left: 6px;
  gap: 10px;
}
.footer-link-item:hover .link-arrow {
  opacity: 1;
  transform: translateX(2px);
}

/* ── Brand kolom ── */
.footer-brand-logo {
  display: flex; align-items: center; gap: 14px;
  margin-bottom: 24px;
}
.footer-brand-logo .logo-wrap {
  width: 52px; height: 52px; border-radius: 50%;
  overflow: hidden; flex-shrink: 0;
  border: 1.5px solid rgba(200,169,110,.35);
  box-shadow: 0 0 20px rgba(200,169,110,.15), 0 4px 14px rgba(0,0,0,.4);
  transition: box-shadow .3s ease;
}
.footer-brand-logo:hover .logo-wrap {
  box-shadow: 0 0 30px rgba(200,169,110,.3), 0 4px 20px rgba(0,0,0,.5);
}
.footer-brand-logo .logo-wrap img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .5s ease;
}
.footer-brand-logo:hover .logo-wrap img { transform: scale(1.08) rotate(3deg); }
.footer-brand-name {
  font-family: 'Noto Serif JP', serif;
  font-weight: 300;
  font-size: 18px;
  color: var(--washi);
  line-height: 1.3;
  letter-spacing: .05em;
}
.footer-brand-name span {
  display: block;
  font-family: 'Cormorant Garamond', serif;
  font-style: italic;
  font-size: 12px;
  color: var(--gold);
  letter-spacing: .15em;
  font-weight: 300;
  margin-top: 2px;
}

.footer-brand-desc {
  font-size: 13px;
  line-height: 1.8;
  color: rgba(245,240,232,.4);
  margin-bottom: 20px;
  font-weight: 300;
}

/* Hanko seal dekoratif brand */
.footer-hanko {
  display: inline-flex; align-items: center; justify-content: center;
  width: 42px; height: 42px; border-radius: 4px;
  border: 1.5px solid rgba(139,32,32,.6);
  color: rgba(139,32,32,.7);
  font-family: 'Noto Serif JP', serif;
  font-size: 11px; font-weight: 300;
  writing-mode: vertical-rl;
  letter-spacing: .1em;
  transition: all .3s ease;
  margin-bottom: 18px;
  flex-shrink: 0;
}
.footer-hanko:hover {
  background: rgba(139,32,32,.1);
  border-color: rgba(139,32,32,.9);
  color: rgba(139,32,32,.9);
}

/* ── Social icons ── */
.footer-social-row { display: flex; gap: 10px; margin-top: 20px; }
.footer-social-btn {
  width: 38px; height: 38px; border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  border: 1px solid var(--ink-md);
  color: rgba(245,240,232,.45);
  text-decoration: none;
  transition: all .3s ease;
  position: relative; overflow: hidden;
}
.footer-social-btn::before {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(200,169,110,.15), rgba(200,169,110,.05));
  opacity: 0; transition: opacity .3s ease;
}
.footer-social-btn:hover {
  border-color: rgba(200,169,110,.5);
  color: var(--gold);
  transform: translateY(-3px);
  box-shadow: 0 6px 18px rgba(200,169,110,.15);
}
.footer-social-btn:hover::before { opacity: 1; }

/* ── Kontak items ── */
.footer-contact-row {
  display: flex; gap: 12px; align-items: flex-start;
  margin-bottom: 14px;
  font-size: 13px; color: rgba(245,240,232,.45);
}
.footer-contact-icon {
  width: 30px; height: 30px; border-radius: 6px;
  background: rgba(200,169,110,.08);
  border: 1px solid rgba(200,169,110,.15);
  display: flex; align-items: center; justify-content: center;
  font-size: 12px; flex-shrink: 0; margin-top: 1px;
  transition: all .25s ease;
}
.footer-contact-row:hover .footer-contact-icon {
  background: rgba(200,169,110,.15);
  border-color: rgba(200,169,110,.3);
}
.footer-contact-row a {
  color: rgba(245,240,232,.45);
  text-decoration: none;
  transition: color .2s ease;
}
.footer-contact-row a:hover { color: var(--gold-lt); }

/* ── WA Button footer ── */
.footer-wa-btn {
  display: inline-flex; align-items: center; gap: 10px;
  background: linear-gradient(135deg, #2d6a32, #1e4d23);
  color: #a8d8ac;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 13px; font-weight: 400;
  padding: 11px 22px; border-radius: 4px;
  text-decoration: none; margin-top: 16px;
  border: 1px solid rgba(168,216,172,.25);
  letter-spacing: .05em;
  transition: all .3s ease;
  box-shadow: 0 4px 16px rgba(0,0,0,.3);
}
.footer-wa-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(46,106,50,.3);
  border-color: rgba(168,216,172,.4);
  color: #c8e8ca;
}

/* ── Divider bambu ── */
.footer-divider {
  height: 1px;
  background: linear-gradient(90deg,
    transparent 0%,
    rgba(200,169,110,.08) 15%,
    rgba(200,169,110,.2) 50%,
    rgba(200,169,110,.08) 85%,
    transparent 100%
  );
  margin: 48px 0 0;
  position: relative;
}
.footer-divider::before {
  content: '花の宿';
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  background: var(--night);
  font-family: 'Noto Serif JP', serif;
  font-weight: 200; font-size: 11px;
  color: rgba(200,169,110,.4);
  letter-spacing: .3em;
  padding: 0 16px;
  white-space: nowrap;
}

/* ── Bottom bar ── */
.footer-bottom {
  padding: 20px 40px 28px;
  display: flex; flex-wrap: wrap;
  justify-content: space-between; align-items: center;
  gap: 12px;
  max-width: 1280px; margin: 0 auto;
  position: relative; z-index: 1;
}
.footer-copyright {
  font-size: 12px;
  color: rgba(245,240,232,.25);
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-weight: 300;
  letter-spacing: .05em;
}
.footer-tagline {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic;
  font-size: 13px;
  color: rgba(200,169,110,.4);
  letter-spacing: .1em;
  display: flex; align-items: center; gap: 10px;
}
.footer-tagline .dot {
  width: 3px; height: 3px; border-radius: 50%;
  background: rgba(200,169,110,.4);
}

/* ── Sticky WA ── */
.sticky-wa-hana {
  position: fixed; bottom: 22px; right: 22px;
  z-index: 999;
  display: flex; align-items: center; gap: 10px;
  background: linear-gradient(135deg, #2d6a32 0%, #1a4a1e 100%);
  color: #a8d8ac;
  font-family: 'Zen Kaku Gothic New', sans-serif;
  font-size: 13px; font-weight: 400;
  padding: 13px 22px; border-radius: 4px;
  text-decoration: none;
  border: 1px solid rgba(168,216,172,.2);
  box-shadow: 0 8px 30px rgba(0,0,0,.5), 0 0 0 0 rgba(46,106,50,.4);
  transition: transform .3s ease, box-shadow .3s ease;
  letter-spacing: .05em;
}
.sticky-wa-hana:hover {
  transform: translateY(-3px);
  box-shadow: 0 14px 40px rgba(0,0,0,.6), 0 0 20px rgba(46,106,50,.25);
  color: #c8e8ca;
}
.sticky-wa-ping {
  position: absolute; top: -4px; right: -4px;
  width: 12px; height: 12px; border-radius: 50%;
  background: var(--hanko);
}
.sticky-wa-ping::before {
  content: '';
  position: absolute; inset: 0; border-radius: 50%;
  background: var(--hanko);
  animation: wa-ping-hana 2s ease-out infinite;
}
@keyframes wa-ping-hana {
  0%   { transform: scale(1); opacity: .8; }
  100% { transform: scale(2.5); opacity: 0; }
}

/* ── Grid ── */
.footer-grid {
  display: grid;
  grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
  gap: 48px;
  margin-bottom: 0;
}

/* ── Responsive ── */
@media (max-width: 1023px) {
  .footer-grid {
    grid-template-columns: 1fr 1fr;
    gap: 36px;
  }
  .footer-inner { padding: 56px 28px 0; }
  .footer-bottom { padding: 20px 28px 28px; }
}
@media (max-width: 767px) {
  .footer-grid {
    grid-template-columns: 1fr;
    gap: 32px;
  }
  .footer-inner { padding: 40px 20px 0; }
  .footer-bottom { padding: 20px 20px 28px; flex-direction: column; text-align: center; gap: 8px; }
  .footer-tagline { justify-content: center; }
  .sticky-wa-hana span { display: none; }
  .sticky-wa-hana { padding: 13px 16px; border-radius: 50%; width: 50px; height: 50px; justify-content: center; }
}
</style>

<!-- ══════════════════════════════════════════
     KUMO TOP — transisi dari CTA (night sky → footer night)
══════════════════════════════════════════ -->
<div class="footer-kumo-top">
  <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0,80 L1440,80 L1440,0 L0,0 Z" fill="#0f0d0a"/>
    <!-- Kumo cloud layer -->
    <ellipse cx="80"  cy="18" rx="90"  ry="28" fill="#0f0d0a"/>
    <ellipse cx="160" cy="10" rx="70"  ry="22" fill="#0f0d0a"/>
    <ellipse cx="230" cy="20" rx="80"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="310" cy="8"  rx="65"  ry="20" fill="#0f0d0a"/>
    <ellipse cx="380" cy="16" rx="85"  ry="25" fill="#0f0d0a"/>
    <ellipse cx="460" cy="6"  rx="72"  ry="21" fill="#0f0d0a"/>
    <ellipse cx="535" cy="18" rx="78"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="620" cy="10" rx="90"  ry="24" fill="#0f0d0a"/>
    <ellipse cx="710" cy="20" rx="75"  ry="28" fill="#0f0d0a"/>
    <ellipse cx="790" cy="8"  rx="68"  ry="22" fill="#0f0d0a"/>
    <ellipse cx="862" cy="18" rx="82"  ry="26" fill="#0f0d0a"/>
    <ellipse cx="944" cy="6"  rx="70"  ry="20" fill="#0f0d0a"/>
    <ellipse cx="1014" cy="16" rx="88" ry="25" fill="#0f0d0a"/>
    <ellipse cx="1100" cy="8"  rx="75" ry="22" fill="#0f0d0a"/>
    <ellipse cx="1174" cy="20" rx="80" ry="27" fill="#0f0d0a"/>
    <ellipse cx="1260" cy="10" rx="72" ry="22" fill="#0f0d0a"/>
    <ellipse cx="1336" cy="18" rx="85" ry="26" fill="#0f0d0a"/>
    <ellipse cx="1420" cy="8"  rx="70" ry="20" fill="#0f0d0a"/>
  </svg>
</div>

<!-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ -->
<footer id="hana-footer">

  <!-- Kanji dekoratif background -->
  <div class="footer-kanji-bg">
    <span style="font-size:180px; top:5%; left:2%; animation-delay:0s;">花</span>
    <span style="font-size:140px; top:10%; left:22%; animation-delay:3s;">縁</span>
    <span style="font-size:200px; top:5%; left:45%; animation-delay:6s;">宿</span>
    <span style="font-size:150px; top:8%; left:67%; animation-delay:2s;">美</span>
    <span style="font-size:160px; top:6%; left:85%; animation-delay:5s;">春</span>
    <span style="font-size:100px; top:55%; left:8%; animation-delay:4s;">和</span>
    <span style="font-size:120px; top:60%; left:55%; animation-delay:1s;">心</span>
    <span style="font-size:90px;  top:50%; left:78%; animation-delay:7s;">詩</span>
  </div>

  <!-- Glow orbs -->
  <div class="footer-orb" style="width:400px;height:400px;top:-100px;left:-80px;background:radial-gradient(circle,rgba(200,169,110,.04) 0%,transparent 70%);"></div>
  <div class="footer-orb" style="width:300px;height:300px;bottom:-60px;right:10%;background:radial-gradient(circle,rgba(139,111,94,.06) 0%,transparent 70%);animation-delay:4s;"></div>
  <div class="footer-orb" style="width:250px;height:250px;top:40%;left:50%;background:radial-gradient(circle,rgba(122,140,110,.04) 0%,transparent 70%);animation-delay:2s;"></div>

  <!-- Main inner -->
  <div class="footer-inner">

    <!-- Rod kayu gulungan -->
    <div class="footer-rod-top"><div class="rod-bar"></div></div>

    <!-- Grid kolom -->
    <div class="footer-grid">

      <!-- ── Kolom 1: Brand ── -->
      <div>
        <a href="<?= BASE_URL ?>/" class="footer-brand-logo" style="text-decoration:none;">
          <div class="logo-wrap">
            <img src="<?= BASE_URL ?>/assets/images/icon.png" alt="Logo <?= e(setting('site_name')) ?>">
          </div>
          <div class="footer-brand-name">
            <?= e(setting('site_name')) ?>
            <span>花の宿 — Flower Inn</span>
          </div>
        </a>

        <p class="footer-brand-desc">
          <?= e(setting('footer_text')) ?>
        </p>

        <!-- Hanko + Tagline -->
        <div style="display:flex; align-items:flex-start; gap:14px; margin-bottom:16px;">
          <div class="footer-hanko">花宿</div>
          <div style="font-family:'Cormorant Garamond',serif; font-style:italic; font-size:13px; color:rgba(200,169,110,.45); line-height:1.7; padding-top:4px; letter-spacing:.05em;">
            Setiap bunga membawa<br>cerita yang tak terucap
          </div>
        </div>

        <!-- Social WA -->
        <div class="footer-social-row">
          <a href="<?= e($wa_full) ?>" target="_blank" class="footer-social-btn" title="WhatsApp">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- ── Kolom 2: Layanan ── -->
      <div>
        <div class="footer-col-heading">
          <span class="kanji-label">花</span>
          Layanan Kami
        </div>
        <nav>
          <?php foreach ($cats as $cat): ?>
          <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/" class="footer-link-item">
            <span class="link-arrow">›</span>
            <?= e($cat['name']) ?>
          </a>
          <?php endforeach; ?>
        </nav>
      </div>

      <!-- ── Kolom 3: Area Pengiriman ── -->
      <div>
        <div class="footer-col-heading">
          <span class="kanji-label">道</span>
          Area Pengiriman
        </div>
        <nav>
          <?php foreach ($locs as $loc): ?>
          <a href="<?= BASE_URL ?>/<?= e($loc['slug']) ?>/" class="footer-link-item">
            <span class="link-arrow">›</span>
            <?= e($loc['name']) ?>
          </a>
          <?php endforeach; ?>
        </nav>
      </div>

      <!-- ── Kolom 4: Kontak ── -->
      <div>
        <div class="footer-col-heading">
          <span class="kanji-label">心</span>
          Hubungi Kami
        </div>

        <div class="footer-contact-row">
          <div class="footer-contact-icon">📍</div>
          <span><?= e(setting('address')) ?></span>
        </div>

        <div class="footer-contact-row">
          <div class="footer-contact-icon">📞</div>
          <a href="tel:<?= e(setting('whatsapp_number')) ?>">
            <?= e(setting('phone_display')) ?>
          </a>
        </div>

        <div class="footer-contact-row">
          <div class="footer-contact-icon">✉️</div>
          <a href="mailto:<?= e(setting('email')) ?>" style="word-break:break-all;">
            <?= e(setting('email')) ?>
          </a>
        </div>

        <div class="footer-contact-row">
          <div class="footer-contact-icon">⏰</div>
          <span><?= e(setting('jam_buka')) ?></span>
        </div>

        <a href="<?= e($wa_full) ?>" target="_blank" class="footer-wa-btn">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
          </svg>
          Chat WhatsApp
        </a>
      </div>

    </div><!-- /footer-grid -->

    <!-- Divider bambu tengah dengan kanji -->
    <div class="footer-divider"></div>

  </div><!-- /footer-inner -->

  <!-- Bottom bar -->
  <div class="footer-bottom">
    <p class="footer-copyright">
      © <?= date('Y') ?> <?= e(setting('site_name')) ?>. Hak cipta dilindungi undang-undang.
    </p>
    <div class="footer-tagline">
      <span>花</span>
      <div class="dot"></div>
      Florist Jakarta Pusat · Pengiriman 24 Jam
      <div class="dot"></div>
      <span>宿</span>
    </div>
  </div>

</footer><!-- /#hana-footer -->

<!-- ══ STICKY WA BUTTON ══ -->
<a href="<?= e($wa_full) ?>" target="_blank" rel="noopener"
   class="sticky-wa-hana" aria-label="Pesan via WhatsApp">
  <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
  </svg>
  <span>Pesan Sekarang</span>
  <div class="sticky-wa-ping"></div>
</a>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>