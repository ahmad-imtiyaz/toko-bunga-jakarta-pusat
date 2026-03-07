<?php
/* ================================================================
   FAQ SECTION — Bunga Kertas Warm Manila
   Tema: Kertas cream hangat, accordion bersih, panel samping
================================================================ */

if (!isset($faqs) || empty($faqs)) {
  $faqs = [
    ['question' => 'Berapa lama proses pengiriman bunga?',
     'answer'   => 'Pengiriman same-day tersedia untuk order sebelum jam 14.00 WIB. Untuk wilayah Jakarta Pusat dan sekitarnya biasanya tiba dalam 2–4 jam. Area luar Jakarta membutuhkan 1–2 hari kerja tergantung lokasi tujuan.'],
    ['question' => 'Apakah bisa custom desain rangkaian bunga?',
     'answer'   => 'Tentu! Kami sangat senang menerima request custom. Cukup kirim referensi foto atau deskripsi keinginan Anda via WhatsApp, tim florist kami akan membantu mewujudkan visi Anda dengan bunga-bunga pilihan terbaik.'],
    ['question' => 'Bagaimana cara merawat bunga agar tahan lama?',
     'answer'   => 'Tempatkan bunga di air bersih, ganti air setiap 2 hari, dan potong sedikit bagian bawah batang secara diagonal. Jauhkan dari sinar matahari langsung dan AC. Dengan perawatan yang tepat, bunga segar bisa bertahan 5–10 hari.'],
    ['question' => 'Apakah tersedia layanan dekorasi untuk acara?',
     'answer'   => 'Ya! Kami melayani dekorasi pernikahan, ulang tahun, pembukaan toko, wisuda, dan berbagai acara lainnya. Konsultasi gratis tersedia untuk membantu merencanakan dekorasi impian Anda sesuai budget.'],
    ['question' => 'Metode pembayaran apa saja yang diterima?',
     'answer'   => 'Kami menerima transfer bank (BCA, Mandiri, BNI, BRI), e-wallet (GoPay, OVO, Dana, ShopeePay), QRIS, dan COD untuk area tertentu. Untuk pesanan besar, bisa menggunakan cicilan 0%.'],
    ['question' => 'Apakah ada garansi kesegaran bunga?',
     'answer'   => 'Kami menjamin semua bunga dalam kondisi segar saat dikirim. Jika ada kendala kualitas, hubungi kami dalam 24 jam setelah penerimaan disertai foto, dan kami akan memberikan penggantian atau refund penuh.'],
  ];
}
?>

<!-- FAQ Schema SEO -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php foreach ($faqs as $i => $faq): ?>
    {
      "@type": "Question",
      "name": "<?= addslashes(htmlspecialchars_decode($faq['question'])) ?>",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<?= addslashes(htmlspecialchars_decode($faq['answer'])) ?>"
      }
    }<?= $i < count($faqs)-1 ? ',' : '' ?>
    <?php endforeach; ?>
  ]
}
</script>

<style>
/* ─── FAQ SECTION ─── */
#faq {
  background: var(--paper, #FBF6EE);
  position: relative;
  overflow: hidden;
  padding: 96px 0 80px;
}

/* Garis pembatas atas */
#faq::before {
  content: '';
  position: absolute;
  top: 0; left: 10%; right: 10%;
  height: 1px;
  background: linear-gradient(to right, transparent, var(--manila-dd, #D6C4A0), transparent);
}

/* Grain texture — static */
#faq::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='.025'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
}

.faq-inner {
  position: relative;
  z-index: 1;
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 24px;
}

/* ─── HEADER ─── */
.faq-header {
  text-align: center;
  margin-bottom: 56px;
}

.faq-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--rose, #C07B60);
  margin-bottom: 16px;
}
.faq-eyebrow-line {
  width: 28px; height: 1px;
  background: var(--rose, #C07B60);
  opacity: .5;
}

.faq-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(30px, 4vw, 48px);
  font-weight: 600;
  color: var(--ink, #2A1F14);
  letter-spacing: -.01em;
  line-height: 1.2;
  margin: 0 0 12px;
}
.faq-title em {
  font-style: italic;
  font-weight: 300;
  color: var(--rose, #C07B60);
}

.faq-subtitle {
  font-family: 'Jost', sans-serif;
  font-size: 13.5px;
  color: var(--muted, #8A7560);
}

/* ─── LAYOUT ─── */
.faq-layout {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 40px;
  align-items: start;
}
@media (max-width: 900px) {
  .faq-layout { grid-template-columns: 1fr; }
}

/* ─── ACCORDION LIST ─── */
.faq-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

/* ─── SATU ITEM ACCORDION ─── */
.faq-item {
  background: var(--manila, #F2E8D5);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 10px;
  overflow: hidden;
  transition: box-shadow .25s ease;
}
.faq-item.open {
  box-shadow: 0 6px 24px rgba(42,31,20,.1);
  border-color: rgba(192,123,96,.3);
}

/* Trigger baris pertanyaan */
.faq-trigger {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 18px 20px;
  cursor: pointer;
  -webkit-tap-highlight-color: transparent;
  user-select: none;
  transition: background .2s;
}
.faq-trigger:hover { background: rgba(192,123,96,.06); }

/* Nomor urut */
.faq-num {
  width: 32px; height: 32px;
  border-radius: 50%;
  border: 1.5px solid var(--manila-dd, #D6C4A0);
  background: var(--paper, #FBF6EE);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Cormorant Garamond', serif;
  font-size: 14px;
  font-weight: 600;
  color: var(--ink-l, #5C4A35);
  flex-shrink: 0;
  transition: background .25s, border-color .25s, color .25s;
}
.faq-item.open .faq-num {
  background: var(--ink, #2A1F14);
  border-color: var(--ink, #2A1F14);
  color: var(--paper, #FBF6EE);
}

/* Teks pertanyaan */
.faq-q {
  flex: 1;
  font-family: 'Jost', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: var(--ink, #2A1F14);
  line-height: 1.5;
}

/* Icon expand */
.faq-icon {
  width: 28px; height: 28px;
  border-radius: 50%;
  border: 1.5px solid var(--manila-dd, #D6C4A0);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: transform .3s ease, background .25s, border-color .25s;
}
.faq-item.open .faq-icon {
  transform: rotate(180deg);
  background: var(--manila-dd, #D6C4A0);
  border-color: var(--manila-dd, #D6C4A0);
}
.faq-icon svg {
  width: 14px; height: 14px;
  stroke: var(--ink-l, #5C4A35);
  fill: none;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

/* Accordion body */
.faq-body {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows .4s cubic-bezier(.4,0,.2,1);
}
.faq-item.open .faq-body {
  grid-template-rows: 1fr;
}
.faq-body-inner { overflow: hidden; }

.faq-answer {
  padding: 0 20px 20px 20px;
  padding-left: 66px;
  position: relative;
}

/* Aksen garis kiri */
.faq-answer::before {
  content: '';
  position: absolute;
  left: 52px; top: 0; bottom: 8px;
  width: 2px;
  background: linear-gradient(to bottom, var(--rose, #C07B60), transparent);
  border-radius: 2px;
  opacity: .4;
}

.faq-answer p {
  font-family: 'Jost', sans-serif;
  font-size: 13.5px;
  line-height: 1.85;
  color: var(--ink-l, #5C4A35);
  margin: 0;
}

/* ─── PANEL KANAN ─── */
.faq-side {
  display: flex;
  flex-direction: column;
  gap: 16px;
  position: sticky;
  top: 100px;
}

/* Kartu info */
.faq-side-card {
  background: var(--manila, #F2E8D5);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 12px;
  padding: 24px 20px;
  text-align: center;
}

.faq-side-card-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 15px;
  font-weight: 600;
  color: var(--ink, #2A1F14);
  margin-bottom: 4px;
}
.faq-side-card-sub {
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  color: var(--muted, #8A7560);
  margin-bottom: 16px;
}

/* Grid stat mini */
.faq-side-stats {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
  margin-bottom: 0;
}
.faq-side-stat {
  background: var(--paper, #FBF6EE);
  border: 1px solid var(--manila-dd, #D6C4A0);
  border-radius: 8px;
  padding: 12px 8px;
}
.faq-side-stat-val {
  font-family: 'Cormorant Garamond', serif;
  font-size: 22px;
  font-weight: 600;
  color: var(--ink, #2A1F14);
  line-height: 1;
}
.faq-side-stat-lbl {
  font-family: 'Jost', sans-serif;
  font-size: 10px;
  font-weight: 500;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--muted, #8A7560);
  margin-top: 4px;
}

/* Divider */
.faq-side-rule {
  height: 1px;
  background: var(--manila-dd, #D6C4A0);
  margin: 14px 0;
  opacity: .6;
}

/* CTA WhatsApp */
.faq-wa-card {
  background: var(--ink, #2A1F14);
  border-radius: 12px;
  padding: 24px 20px;
  text-align: center;
}
.faq-wa-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 18px;
  font-weight: 600;
  color: var(--paper, #FBF6EE);
  margin-bottom: 6px;
}
.faq-wa-sub {
  font-family: 'Jost', sans-serif;
  font-size: 12px;
  color: rgba(251,246,238,.45);
  margin-bottom: 16px;
  line-height: 1.6;
}
.faq-wa-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--paper, #FBF6EE);
  color: var(--ink, #2A1F14);
  font-family: 'Jost', sans-serif;
  font-size: 12.5px;
  font-weight: 600;
  padding: 11px 22px;
  border-radius: 100px;
  text-decoration: none;
  transition: background .2s, transform .2s;
  letter-spacing: .02em;
}
.faq-wa-btn:hover {
  background: #fff;
  transform: translateY(-1px);
  text-decoration: none;
  color: var(--ink, #2A1F14);
}
.faq-wa-btn svg { flex-shrink: 0; }

/* Tombol reset */
.faq-reset {
  font-family: 'Jost', sans-serif;
  font-size: 11.5px;
  color: var(--muted, #8A7560);
  text-align: center;
  cursor: pointer;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid var(--manila-dd, #D6C4A0);
  background: transparent;
  transition: background .2s, color .2s;
  letter-spacing: .04em;
  width: 100%;
}
.faq-reset:hover {
  background: var(--manila, #F2E8D5);
  color: var(--ink, #2A1F14);
}

/* ─── RESPONSIVE ─── */
@media (max-width: 767px) {
  #faq { padding: 64px 0 60px; }
  .faq-answer { padding-left: 20px; }
  .faq-answer::before { display: none; }
  .faq-side { position: static; }
}
</style>

<section id="faq" role="region" aria-label="Pertanyaan yang Sering Ditanyakan">
  <div class="faq-inner">

    <!-- HEADER -->
    <header class="faq-header">
      <div class="faq-eyebrow">
        <span class="faq-eyebrow-line"></span>
        Pertanyaan Umum
        <span class="faq-eyebrow-line"></span>
      </div>
      <h2 class="faq-title">Pertanyaan yang <em>Sering Ditanyakan</em></h2>
      <p class="faq-subtitle">Tidak menemukan jawaban? Hubungi kami langsung via WhatsApp</p>
    </header>

    <!-- LAYOUT -->
    <div class="faq-layout">

      <!-- ACCORDION -->
      <div class="faq-list" id="faq-list">
        <?php foreach ($faqs as $fi => $faq): ?>
        <div class="faq-item" id="faq-item-<?= $fi ?>">

          <div class="faq-trigger"
               role="button"
               aria-expanded="false"
               aria-controls="faq-body-<?= $fi ?>"
               tabindex="0"
               onclick="faqToggle(<?= $fi ?>)"
               onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();faqToggle(<?= $fi ?>)}">
            <div class="faq-num"><?= $fi + 1 ?></div>
            <span class="faq-q"><?= htmlspecialchars($faq['question'], ENT_QUOTES, 'UTF-8') ?></span>
            <div class="faq-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </div>

          <div class="faq-body" id="faq-body-<?= $fi ?>" role="region">
            <div class="faq-body-inner">
              <div class="faq-answer">
                <p><?= htmlspecialchars($faq['answer'], ENT_QUOTES, 'UTF-8') ?></p>
              </div>
            </div>
          </div>

        </div>
        <?php endforeach; ?>
      </div>

      <!-- PANEL KANAN -->
      <aside class="faq-side">

        <div class="faq-side-card">
          <div class="faq-side-card-title">Layanan Kami</div>
          <div class="faq-side-card-sub">Selalu siap membantu kebutuhan bunga Anda</div>
          <div class="faq-side-stats">
            <div class="faq-side-stat">
              <div class="faq-side-stat-val">24/7</div>
              <div class="faq-side-stat-lbl">Siap Bantu</div>
            </div>
            <div class="faq-side-stat">
              <div class="faq-side-stat-val">Free</div>
              <div class="faq-side-stat-lbl">Konsultasi</div>
            </div>
            <div class="faq-side-stat">
              <div class="faq-side-stat-val">2–4 Jam</div>
              <div class="faq-side-stat-lbl">Pengiriman</div>
            </div>
            <div class="faq-side-stat">
              <div class="faq-side-stat-val"><?= count($faqs) ?></div>
              <div class="faq-side-stat-lbl">FAQ Tersedia</div>
            </div>
          </div>
        </div>

        <div class="faq-wa-card">
          <div class="faq-wa-title">Belum Terjawab?</div>
          <div class="faq-wa-sub">Tanyakan langsung ke tim kami via WhatsApp, kami siap membantu.</div>
          <?php
            $wa_msg_faq = urlencode('Halo, saya punya pertanyaan tentang layanan bunga.');
          ?>
          <a href="<?= isset($wa_url) ? 'https://wa.me/' . $wa_url . '?text=' . $wa_msg_faq : '#' ?>"
             target="_blank" rel="noopener noreferrer"
             class="faq-wa-btn">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.25-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
            Tanya WhatsApp
          </a>
        </div>

        <button class="faq-reset" onclick="faqResetAll()">Tutup Semua Jawaban</button>

      </aside>
    </div>

  </div>
</section>

<script>
(function(){
  window.faqToggle = function(idx) {
    const item    = document.getElementById('faq-item-' + idx);
    const trigger = item?.querySelector('.faq-trigger');
    if (!item) return;

    const isOpen = item.classList.contains('open');

    // Tutup semua dulu (accordion eksklusif)
    document.querySelectorAll('#faq-list .faq-item.open').forEach(el => {
      if (el !== item) {
        el.classList.remove('open');
        el.querySelector('.faq-trigger')?.setAttribute('aria-expanded', 'false');
      }
    });

    if (!isOpen) {
      item.classList.add('open');
      trigger?.setAttribute('aria-expanded', 'true');
      // Scroll ke item jika perlu
      setTimeout(() => {
        const rect = item.getBoundingClientRect();
        if (rect.top < 80) item.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 350);
    } else {
      item.classList.remove('open');
      trigger?.setAttribute('aria-expanded', 'false');
    }
  };

  window.faqResetAll = function() {
    document.querySelectorAll('#faq-list .faq-item').forEach(el => {
      el.classList.remove('open');
      el.querySelector('.faq-trigger')?.setAttribute('aria-expanded', 'false');
    });
  };
})();
</script>