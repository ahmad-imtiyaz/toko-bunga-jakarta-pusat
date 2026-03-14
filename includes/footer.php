<?php
$wa_url  = setting('whatsapp_url');
$wa_msg  = urlencode('Halo, saya ingin memesan bunga. Mohon info lebih lanjut.');
$wa_full = $wa_url . '?text=' . $wa_msg;
$cats    = db()->query("SELECT name, slug FROM categories WHERE status='active' ORDER BY id LIMIT 10")->fetchAll();
$locs    = db()->query("SELECT name, slug FROM locations WHERE status='active' ORDER BY id")->fetchAll();
?>

<style>
/* ─── FOOTER ─── */
#site-footer {
  background: var(--ink, #2A1F14);
  position: relative;
  overflow: hidden;
}

#site-footer::before {
  content: '';
  position: absolute; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='.03'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 0;
}

#site-footer::after {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 60% 50% at 0% 0%,   rgba(192,123,96,.1) 0%, transparent 60%),
    radial-gradient(ellipse 45% 40% at 100% 100%, rgba(192,123,96,.07) 0%, transparent 60%);
  pointer-events: none; z-index: 0;
}

/* ─── INNER ─── */
.hfooter-inner {
  position: relative; z-index: 1;
  max-width: 1280px;
  margin: 0 auto;
  padding: 68px 40px 0;
}

.hfooter-top-rule {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(223,169,140,.2), rgba(223,169,140,.35), rgba(223,169,140,.2), transparent);
  margin-bottom: 52px;
}

.hfooter-grid {
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
  gap: 48px;
}

.hfooter-heading {
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--rose-l, #DFA98C);
  margin-bottom: 20px;
  padding-bottom: 12px;
  position: relative;
}
.hfooter-heading::after {
  content: '';
  position: absolute; bottom: 0; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, rgba(223,169,140,.3), transparent);
}

/* heading area pengiriman — flex untuk badge */
.hfooter-heading-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--rose-l, #DFA98C);
  margin-bottom: 20px;
  padding-bottom: 12px;
  position: relative;
}
.hfooter-heading-row::after {
  content: '';
  position: absolute; bottom: 0; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, rgba(223,169,140,.3), transparent);
}

.hfooter-brand {
  display: flex; align-items: center; gap: 12px;
  margin-bottom: 20px;
  text-decoration: none;
}
.hfooter-brand-logo {
  width: 48px; height: 48px;
  border-radius: 50%;
  overflow: hidden; flex-shrink: 0;
  border: 1.5px solid rgba(223,169,140,.25);
}
.hfooter-brand-logo img { width: 100%; height: 100%; object-fit: cover; }
.hfooter-brand-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px; font-weight: 600;
  color: var(--paper, #FBF6EE);
  letter-spacing: .02em; line-height: 1.2;
}
.hfooter-brand-name span {
  display: block;
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 400;
  letter-spacing: .15em; text-transform: uppercase;
  color: var(--rose-l, #DFA98C);
  opacity: .6; margin-top: 3px;
}

.hfooter-desc {
  font-family: 'Jost', sans-serif;
  font-size: 13px; line-height: 1.8;
  color: rgba(251,246,238,.35);
  margin-bottom: 20px; font-weight: 300;
}

.hfooter-quote {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; font-size: 14px;
  color: var(--rose-l, #DFA98C);
  opacity: .5; line-height: 1.7;
  padding-left: 14px;
  border-left: 2px solid rgba(223,169,140,.2);
  margin-bottom: 20px;
}

.hfooter-social { display: flex; gap: 8px; }
.hfooter-social-btn {
  width: 36px; height: 36px; border-radius: 8px;
  border: 1px solid rgba(251,246,238,.1);
  background: transparent;
  display: flex; align-items: center; justify-content: center;
  color: rgba(251,246,238,.35); text-decoration: none;
  transition: border-color .2s, color .2s, background .2s, transform .2s;
}
.hfooter-social-btn:hover {
  border-color: rgba(223,169,140,.4);
  color: var(--rose-l, #DFA98C);
  background: rgba(223,169,140,.06);
  transform: translateY(-2px);
}

.hfooter-link {
  display: flex; align-items: center; gap: 8px;
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 400;
  color: rgba(251,246,238,.38);
  text-decoration: none; padding: 5px 0;
  transition: color .2s, padding-left .2s, gap .2s;
}
.hfooter-link-arrow {
  width: 14px; height: 14px;
  display: flex; align-items: center; justify-content: center;
  color: var(--rose, #C07B60);
  opacity: .4; transition: opacity .2s, transform .2s;
  flex-shrink: 0; font-size: 12px;
}
.hfooter-link:hover { color: var(--paper, #FBF6EE); padding-left: 4px; gap: 10px; }
.hfooter-link:hover .hfooter-link-arrow { opacity: .8; transform: translateX(2px); }

.hfooter-contact { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 14px; }
.hfooter-contact-icon {
  width: 30px; height: 30px; border-radius: 7px;
  background: rgba(223,169,140,.07);
  border: 1px solid rgba(223,169,140,.12);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; margin-top: 1px;
  transition: background .2s, border-color .2s;
}
.hfooter-contact-icon svg {
  width: 14px; height: 14px;
  stroke: var(--rose-l, #DFA98C); fill: none;
  stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; opacity: .6;
}
.hfooter-contact:hover .hfooter-contact-icon {
  background: rgba(223,169,140,.12);
  border-color: rgba(223,169,140,.25);
}
.hfooter-contact-text {
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 300;
  color: rgba(251,246,238,.38); line-height: 1.6;
}
.hfooter-contact-text a {
  color: rgba(251,246,238,.38); text-decoration: none;
  transition: color .2s; word-break: break-all;
}
.hfooter-contact-text a:hover { color: var(--rose-l, #DFA98C); }

.hfooter-wa {
  display: inline-flex; align-items: center; gap: 9px;
  background: rgba(223,169,140,.08);
  border: 1px solid rgba(223,169,140,.2);
  color: var(--rose-l, #DFA98C);
  font-family: 'Jost', sans-serif;
  font-size: 12.5px; font-weight: 600;
  padding: 11px 20px; border-radius: 8px;
  text-decoration: none; margin-top: 16px;
  letter-spacing: .04em;
  transition: background .2s, border-color .2s, transform .2s;
}
.hfooter-wa:hover {
  background: rgba(223,169,140,.14);
  border-color: rgba(223,169,140,.38);
  transform: translateY(-1px);
  color: var(--paper, #FBF6EE);
}

.hfooter-divider {
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(223,169,140,.15), rgba(223,169,140,.25), rgba(223,169,140,.15), transparent);
  margin: 48px 0 0;
  position: relative;
}
.hfooter-divider::before {
  content: '';
  position: absolute; top: 50%; left: 50%;
  width: 7px; height: 7px;
  background: var(--rose, #C07B60);
  transform: translate(-50%, -50%) rotate(45deg);
  opacity: .4;
}

.hfooter-bottom {
  position: relative; z-index: 1;
  max-width: 1280px; margin: 0 auto;
  padding: 20px 40px 28px;
  display: flex; flex-wrap: wrap;
  justify-content: space-between; align-items: center;
  gap: 12px;
}
.hfooter-copy {
  font-family: 'Jost', sans-serif;
  font-size: 11.5px; font-weight: 300;
  color: rgba(251,246,238,.2); letter-spacing: .04em;
}
.hfooter-tagline {
  font-family: 'Cormorant Garamond', serif;
  font-style: italic; font-size: 13px;
  color: rgba(223,169,140,.35); letter-spacing: .06em;
  display: flex; align-items: center; gap: 10px;
}
.hfooter-tagline-dot {
  width: 3px; height: 3px; border-radius: 50%;
  background: rgba(223,169,140,.35); flex-shrink: 0;
}

.sticky-wa {
  position: fixed; bottom: 20px; right: 20px; z-index: 999;
  display: flex; align-items: center; gap: 9px;
  background: var(--ink, #2A1F14);
  color: var(--rose-l, #DFA98C);
  font-family: 'Jost', sans-serif;
  font-size: 13px; font-weight: 600;
  padding: 13px 22px; border-radius: 100px;
  text-decoration: none;
  border: 1px solid rgba(223,169,140,.25);
  box-shadow: 0 6px 28px rgba(0,0,0,.4);
  transition: transform .25s, box-shadow .25s, border-color .25s;
  letter-spacing: .03em;
}
.sticky-wa:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 36px rgba(0,0,0,.5);
  border-color: rgba(223,169,140,.45);
  color: var(--paper, #FBF6EE);
}
.sticky-wa-ping {
  position: absolute; top: -3px; right: -3px;
  width: 10px; height: 10px; border-radius: 50%;
  background: var(--rose, #C07B60);
}
.sticky-wa-ping::before {
  content: ''; position: absolute; inset: 0; border-radius: 50%;
  background: var(--rose, #C07B60);
  animation: stWaPing 2.2s ease-out infinite;
}
@keyframes stWaPing {
  0%   { transform: scale(1); opacity: .7; }
  100% { transform: scale(2.8); opacity: 0; }
}

/* ================================================================
   AREA PENGIRIMAN SLIDER — tema ink/rose-gold (Jakarta Pusat)
   ================================================================ */
.hfas-badge {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 600;
  letter-spacing: .1em;
  background: rgba(223,169,140,.08);
  color: var(--rose-l, #DFA98C);
  border: 1px solid rgba(223,169,140,.18);
  border-radius: 20px;
  padding: 2px 10px;
  white-space: nowrap;
  text-transform: uppercase;
}
.hfas-viewport {
  width: 100%;
  overflow: hidden;
}
.hfas-track {
  display: flex;
  flex-direction: row;
  width: 100%;
  transition: transform .38s cubic-bezier(.4,0,.2,1);
  will-change: transform;
}
.hfas-slide {
  min-width: 100%;
  width: 100%;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  gap: 3px;
  box-sizing: border-box;
}
.hfas-item { display: none !important; }
.hfas-link {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 7px 10px;
  background: rgba(223,169,140,.04);
  border: 1px solid rgba(223,169,140,.1);
  border-radius: 6px;
  text-decoration: none;
  transition: background .18s, border-color .18s;
  width: 100%;
  box-sizing: border-box;
}
.hfas-link:hover,
.hfas-link:active {
  background: rgba(223,169,140,.1);
  border-color: rgba(223,169,140,.28);
}
.hfas-dot {
  width: 5px;
  height: 5px;
  min-width: 5px;
  border-radius: 50%;
  background: var(--rose, #C07B60);
  opacity: .55;
  flex-shrink: 0;
}
.hfas-link-name {
  font-family: 'Jost', sans-serif;
  font-size: 12.5px; font-weight: 300;
  color: rgba(251,246,238,.38);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  transition: color .18s;
}
.hfas-link:hover .hfas-link-name { color: rgba(251,246,238,.7); }

/* Controls */
.hfas-controls {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 14px;
}
.hfas-dots { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }
.hfas-dot-btn {
  width: 5px; height: 5px; min-width: 5px;
  border-radius: 3px;
  background: rgba(223,169,140,.2);
  cursor: pointer;
  transition: background .2s, width .25s;
  border: none; padding: 0;
}
.hfas-dot-btn.active {
  width: 18px;
  background: var(--rose, #C07B60);
}
.hfas-nav { display: flex; align-items: center; gap: 6px; }
.hfas-page-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 400;
  color: rgba(223,169,140,.35);
  min-width: 28px; text-align: center;
  letter-spacing: .08em;
}
.hfas-btn {
  width: 26px; height: 26px;
  border-radius: 6px;
  border: 1px solid rgba(223,169,140,.15);
  background: rgba(223,169,140,.05);
  color: rgba(223,169,140,.5);
  cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background .18s, border-color .18s, color .18s;
  padding: 0; flex-shrink: 0;
}
.hfas-btn:hover {
  background: rgba(223,169,140,.12);
  border-color: rgba(223,169,140,.3);
  color: var(--rose-l, #DFA98C);
}
.hfas-btn:disabled { opacity: .2; cursor: default; }

.hfas-hint {
  display: none;
  font-family: 'Jost', sans-serif;
  font-size: 10px; font-weight: 300;
  color: rgba(223,169,140,.25);
  text-align: center; margin-top: 8px;
  letter-spacing: .08em;
}

@media (max-width: 1023px) {
  .hfooter-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
  .hfooter-inner { padding: 56px 28px 0; }
  .hfooter-bottom { padding: 20px 28px 28px; }
}
@media (max-width: 767px) {
  .hfas-btn  { width: 32px; height: 32px; border-radius: 8px; }
  .hfas-hint { display: block; }
}
@media (max-width: 600px) {
  .hfooter-grid { grid-template-columns: 1fr; gap: 28px; }
  .hfooter-inner { padding: 40px 20px 0; }
  .hfooter-bottom { padding: 20px 20px 28px; flex-direction: column; text-align: center; }
  .hfooter-tagline { justify-content: center; }
  .sticky-wa { padding: 11px 18px; border-radius: 100px; }
}
</style>

<footer id="site-footer">
  <div class="hfooter-inner">

    <!-- Ornamen atas -->
    <div class="hfooter-top-rule" aria-hidden="true"></div>

    <!-- Grid kolom -->
    <div class="hfooter-grid">

      <!-- ── Kolom 1: Brand ── -->
      <div>
        <a href="<?= BASE_URL ?>/" class="hfooter-brand">
          <div class="hfooter-brand-logo">
            <img src="<?= BASE_URL ?>/assets/images/icon.png"
                 alt="Logo <?= e(setting('site_name')) ?>"
                 width="48" height="48">
          </div>
          <div class="hfooter-brand-name">
            <?= e(setting('site_name')) ?>
            <span>Florist Jakarta Pusat</span>
          </div>
        </a>

        <p class="hfooter-desc"><?= e(setting('footer_text')) ?></p>

        <div class="hfooter-quote">
          Setiap bunga membawa cerita<br>yang tak terucap oleh kata
        </div>

        <div class="hfooter-social">
          <a href="<?= e($wa_full) ?>" target="_blank" rel="noopener"
             class="hfooter-social-btn" aria-label="WhatsApp">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
          </a>
          <?php if (setting('instagram')): ?>
          <a href="https://instagram.com/<?= e(setting('instagram')) ?>"
             target="_blank" rel="noopener"
             class="hfooter-social-btn" aria-label="Instagram">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
              <circle cx="12" cy="12" r="4"/>
              <circle cx="17.5" cy="6.5" r=".8" fill="currentColor" stroke="none"/>
            </svg>
          </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- ── Kolom 2: Layanan ── -->
      <div>
        <div class="hfooter-heading">Layanan Kami</div>
        <nav aria-label="Layanan">
          <?php foreach ($cats as $cat): ?>
          <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/" class="hfooter-link">
            <span class="hfooter-link-arrow">›</span>
            <?= e($cat['name']) ?>
          </a>
          <?php endforeach; ?>
        </nav>
      </div>

      <!-- ── Kolom 3: Area Pengiriman — SLIDER ── -->
      <div>
        <div class="hfooter-heading-row">
          <span>Area Pengiriman</span>
          <span class="hfas-badge"><?= count($locs) ?> kota</span>
        </div>

        <div class="hfas-viewport">
          <div class="hfas-track" id="hfasTrack">
            <?php foreach ($locs as $loc): ?>
            <span class="hfas-item"
                  data-name="<?= e($loc['name']) ?>"
                  data-href="<?= BASE_URL ?>/<?= e($loc['slug']) ?>/"></span>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="hfas-controls">
          <div class="hfas-dots" id="hfasDots"></div>
          <div class="hfas-nav">
            <span class="hfas-page-lbl" id="hfasLbl"></span>
            <button class="hfas-btn" id="hfasPrev" aria-label="Sebelumnya" disabled>
              <svg width="11" height="11" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M8 2L4 6l4 4"/></svg>
            </button>
            <button class="hfas-btn" id="hfasNext" aria-label="Berikutnya">
              <svg width="11" height="11" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 2l4 4-4 4"/></svg>
            </button>
          </div>
        </div>
        <p class="hfas-hint">Geser untuk lihat area lainnya</p>
      </div>

      <!-- ── Kolom 4: Kontak ── -->
      <div>
        <div class="hfooter-heading">Hubungi Kami</div>

        <div class="hfooter-contact">
          <div class="hfooter-contact-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/></svg>
          </div>
          <div class="hfooter-contact-text"><?= e(setting('address')) ?></div>
        </div>

        <div class="hfooter-contact">
          <div class="hfooter-contact-icon">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .18h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
          </div>
          <div class="hfooter-contact-text">
            <a href="tel:<?= e(setting('whatsapp_number')) ?>">
              <?= e(setting('phone_display') ?? setting('whatsapp_number')) ?>
            </a>
          </div>
        </div>

        <?php if (setting('email')): ?>
        <div class="hfooter-contact">
          <div class="hfooter-contact-icon">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <div class="hfooter-contact-text">
            <a href="mailto:<?= e(setting('email')) ?>"><?= e(setting('email')) ?></a>
          </div>
        </div>
        <?php endif; ?>

        <div class="hfooter-contact">
          <div class="hfooter-contact-icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div class="hfooter-contact-text"><?= e(setting('jam_buka')) ?></div>
        </div>

        <a href="<?= e($wa_full) ?>" target="_blank" rel="noopener" class="hfooter-wa">
          <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
          </svg>
          Chat WhatsApp
        </a>
      </div>

    </div><!-- /grid -->

    <div class="hfooter-divider" aria-hidden="true"></div>

  </div><!-- /inner -->

  <!-- Bottom bar -->
  <div class="hfooter-bottom">
    <p class="hfooter-copy">
      &copy; <?= date('Y') ?> <?= e(setting('site_name')) ?>. Semua hak dilindungi. &middot; Jakarta Pusat
    </p>
    <div class="hfooter-tagline">
      <span>Florist Jakarta Pusat</span>
      <div class="hfooter-tagline-dot" aria-hidden="true"></div>
      <span>Pengiriman 24 Jam</span>
    </div>
  </div>

</footer>

<!-- ── STICKY WA ── -->
<a href="<?= e($wa_full) ?>" target="_blank" rel="noopener"
   class="sticky-wa" aria-label="Pesan via WhatsApp">
  <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
  </svg>
  <span>Pesan Sekarang</span>
  <div class="sticky-wa-ping" aria-hidden="true"></div>
</a>

<!-- ================================================================
     AREA PENGIRIMAN SLIDER — JS (Jakarta Pusat, prefix: hfas)
     ================================================================ -->
<script>
(function () {
  var track   = document.getElementById('hfasTrack');
  var dotsEl  = document.getElementById('hfasDots');
  var lbl     = document.getElementById('hfasLbl');
  var btnPrev = document.getElementById('hfasPrev');
  var btnNext = document.getElementById('hfasNext');
  if (!track) return;

  var cities = Array.from(track.querySelectorAll('.hfas-item')).map(function (el) {
    return { name: el.dataset.name, href: el.dataset.href };
  });

  var cur     = 0;
  var perPage = 0;

  function isMobile() { return window.innerWidth < 768; }

  function chunk(arr, n) {
    var r = [];
    for (var i = 0; i < arr.length; i += n) r.push(arr.slice(i, i + n));
    return r;
  }

  function rebuild() {
    var pp = isMobile() ? 4 : 5;
    if (pp === perPage && track.querySelectorAll('.hfas-slide').length > 0) return;
    perPage = pp;

    var pages = chunk(cities, perPage);

    Array.from(track.querySelectorAll('.hfas-slide')).forEach(function (s) { track.removeChild(s); });

    track.style.transition = 'none';
    track.style.transform  = 'translateX(0)';

    pages.forEach(function (page) {
      var slide = document.createElement('div');
      slide.className = 'hfas-slide';
      page.forEach(function (city) {
        var a = document.createElement('a');
        a.className = 'hfas-link';
        a.href = city.href;
        a.innerHTML =
          '<span class="hfas-dot"></span>' +
          '<span class="hfas-link-name">' + city.name + '</span>';
        slide.appendChild(a);
      });
      track.appendChild(slide);
    });

    dotsEl.innerHTML = '';
    pages.forEach(function (_, i) {
      var d = document.createElement('button');
      d.className = 'hfas-dot-btn';
      d.setAttribute('aria-label', 'Halaman ' + (i + 1));
      (function (idx) {
        d.addEventListener('click', function () { goTo(idx); });
      })(i);
      dotsEl.appendChild(d);
    });

    if (cur >= pages.length) cur = pages.length - 1;
    goTo(cur, true);
  }

  function goTo(n, instant) {
    var total = track.querySelectorAll('.hfas-slide').length;
    cur = Math.max(0, Math.min(n, total - 1));

    track.style.transition = instant ? 'none' : 'transform .38s cubic-bezier(.4,0,.2,1)';
    track.style.transform  = 'translateX(-' + (cur * 100) + '%)';

    Array.from(dotsEl.children).forEach(function (d, i) {
      d.classList.toggle('active', i === cur);
    });
    lbl.textContent  = (cur + 1) + ' / ' + total;
    btnPrev.disabled = cur === 0;
    btnNext.disabled = cur === total - 1;
  }

  btnPrev.addEventListener('click', function () { goTo(cur - 1); });
  btnNext.addEventListener('click', function () { goTo(cur + 1); });

  var tx0 = null;
  track.addEventListener('touchstart', function (e) {
    tx0 = e.touches[0].clientX;
  }, { passive: true });
  track.addEventListener('touchend', function (e) {
    if (tx0 === null) return;
    var dx = e.changedTouches[0].clientX - tx0;
    if (Math.abs(dx) > 40) goTo(cur + (dx < 0 ? 1 : -1));
    tx0 = null;
  }, { passive: true });

  var lastMobile = isMobile();
  var rTimer;
  window.addEventListener('resize', function () {
    clearTimeout(rTimer);
    rTimer = setTimeout(function () {
      var nowMobile = isMobile();
      if (nowMobile !== lastMobile) {
        lastMobile = nowMobile;
        perPage    = 0;
        rebuild();
      }
    }, 150);
  });

  rebuild();
})();
</script>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>