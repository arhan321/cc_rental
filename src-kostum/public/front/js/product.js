/* ==================================================================
   CART LOGIC — satu kostum per keranjang, 1 paket = 3-hari
   ================================================================== */
document.addEventListener('DOMContentLoaded', () => {
  /* ---------- elemen dasar ---------- */
  const cartBody           = document.querySelector('.offcanvas-body');
  const cartItemsContainer = Object.assign(document.createElement('div'), {
    id : 'dynamicCartItems', className : 'mb-4',
  });
  cartBody.insertBefore(cartItemsContainer, document.getElementById('cartItems').nextSibling);

  const subtotalEl = document.getElementById('subtotal');
  const totalEl    = document.getElementById('total');
  const cartBadge  = document.getElementById('cartBadge');

  /* ---------- helper ---------- */
  const toISO    = d => d.toISOString().split('T')[0];
  const todayISO = () => toISO(new Date());
  const addDays  = (d,n) => new Date(d.getTime() + n * 864e5);

  /* ===============================================================
       1. Tombol “Sewa Sekarang”
     ============================================================== */
  document
    .querySelectorAll('.btn.btn-outline-dark.btn-sm:not([disabled])')
    .forEach(btn =>
      btn.addEventListener('click', () => {
        const card = btn.closest('.card');
        const col  = card.closest('[data-kostums-id]');

        /* abaikan bila kostum sudah di keranjang */
        const id = col.dataset.kostumsId;
        if (cartItemsContainer.querySelector(`[data-kostums-id="${id}"]`)) return;

        /* data dari DOM */
        const title = card.querySelector('.card-title').textContent;
        const cat   = col.dataset.category;
        const size  = col.dataset.size || 'L';
        const base  = +col.dataset.price;              // harga untuk 3-hari
        const img   = card.querySelector('img').src;

        /* = state item = */
        let paket = 1;                                 // 1 paket = 3 hari

        /* ---------- markup item ---------- */
        const item = document.createElement('div');
        item.className         = 'cart-item d-flex gap-3 rounded shadow-sm p-3 mb-3';
        item.dataset.kostumsId = id;
        item.dataset.size      = size;
        item.dataset.basePrice = base;

        item.innerHTML = `
          <img src="${img}" class="rounded flex-shrink-0"
               style="width:60px;height:60px;object-fit:cover;">
          <div class="flex-grow-1 d-flex justify-content-between flex-wrap">
            <div class="pe-3" style="max-width:calc(100% - 110px);">
              <h6 class="mb-1 fw-semibold" style="font-size:.85rem;">${title}</h6>
              <span class="badge category-badge mb-1">${cat}</span>
              <div class="text-muted" style="font-size:.75rem;">
                <div>Ukuran: <strong>${size}</strong></div>
                <div class="mb-1">
                  <label class="form-label mb-0" style="font-size:.75rem;">Tanggal Mulai</label>
                  <input type="date" class="form-control form-control-sm rental-start"
                         value="${todayISO()}">
                </div>
                <div class="mb-1">
                  <label class="form-label mb-0" style="font-size:.75rem;">Tanggal Selesai</label>
                  <input type="date" class="form-control form-control-sm rental-end" readonly>
                </div>
                <div class="rental-duration">Durasi: 3 hari</div>
              </div>
            </div>

            <div class="d-flex flex-column align-items-end justify-content-between"
                 style="min-width:100px;">
              <div class="paket-wrapper d-flex align-items-center gap-2 mb-2">
                <button class="paket-minus rounded px-2" style="font-size:.8rem;">–</button>
                <span   class="paket-value" style="font-size:.8rem;">1</span>
                <button class="paket-plus  rounded px-2" style="font-size:.8rem;">+</button>
              </div>
              <div class="price fw-semibold text-dark" style="font-size:.875rem;">
                Rp${base.toLocaleString()}
              </div>
            </div>
          </div>`;
        cartItemsContainer.appendChild(item);

        /* ---------- fungsi hitung ulang ---------- */
        const paketVal = item.querySelector('.paket-value');
        const priceEl  = item.querySelector('.price');
        const startInp = item.querySelector('.rental-start');
        const endInp   = item.querySelector('.rental-end');
        const durText  = item.querySelector('.rental-duration');

        const recalc = () => {
          const hari = paket * 3;
          paketVal.textContent = paket;
          priceEl.textContent  = `Rp${(base * paket).toLocaleString()}`;
          durText.textContent  = `Durasi: ${hari} hari`;
          endInp.value         = toISO(addDays(new Date(startInp.value), hari - 1));
          updateTotals();
        };
        item.querySelector('.paket-minus').onclick = () => { if (paket > 1) { paket--; recalc(); } };
        item.querySelector('.paket-plus' ).onclick = () => { paket++; recalc(); };
        startInp.onchange = recalc;
        recalc();
      })
    );

  /* ---------- subtotal ---------- */
  const updateTotals = () => {
    let total = 0;
    cartItemsContainer.querySelectorAll('.cart-item').forEach(ci => {
      const paket = +ci.querySelector('.paket-value').textContent;
      total += paket * +ci.dataset.basePrice;
    });
    subtotalEl.textContent = totalEl.textContent = `Rp${total.toLocaleString()}`;

    const n = cartItemsContainer.children.length;
    cartBadge.textContent = n;
    cartBadge.style.display = n ? 'inline-block' : 'none';
  };

  /* ===============================================================
       2. Checkout  +  Snap
     ============================================================== */
  document.getElementById('checkoutBtn')?.addEventListener('click', () => {
    const items = [...cartItemsContainer.querySelectorAll('.cart-item')].map(ci => {
      const paket = +ci.querySelector('.paket-value').textContent;
      return {
        kostums_id : ci.dataset.kostumsId,
        ukuran     : ci.dataset.size,
        price      : +ci.dataset.basePrice,   // harga per paket
        durasi     : paket * 3,               // → hari
      };
    });
    if (!items.length) return alert('Keranjang kosong.');

    const total         = +totalEl.textContent.replace(/[^\d]/g, '');
    const tanggalMulai  = cartItemsContainer.querySelector('.rental-start')?.value;
    const totalDurasi   = items.reduce((s, i) => s + i.durasi, 0);

    fetch('/checkout', {
      method : 'POST',
      headers: {
        'Content-Type' : 'application/json',
        'Accept'       : 'application/json',
        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({
        tanggal_mulai : tanggalMulai,
        durasi        : totalDurasi,
        total         : total,
        alamat_toko   : 'CCC Rental - Jakarta',
        items         : items,
      }),
    })
    .then(r => r.ok ? r.json() : r.text().then(t => Promise.reject(t)))
    .then(d => {
      /* ----- BARIS YANG DITAMBAH / DIUBAH ----- */
      const orderIdFull = d.order_id_full;              // simpan ID penuh
      /* ---------------------------------------- */

      if (!d.snap_token) return alert('Gagal mendapatkan token');

      window.snap.pay(d.snap_token, {
        onSuccess : res => updateStatus(orderIdFull, res.transaction_status),
        onPending : res => updateStatus(orderIdFull, res.transaction_status),
        onError   : res => updateStatus(orderIdFull, res.transaction_status),
      });

      cartItemsContainer.innerHTML = '';
      updateTotals();
    })
    .catch(e => alert('Checkout gagal:\n' + e));
  });

  /* ===============================================================
       3. Kirim status hasil pembayaran
     ============================================================== */
  function updateStatus(orderIdFull, status) {
    fetch('/checkout/status', {
      method : 'POST',
      headers: {
        'Content-Type' : 'application/json',
        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content,
      },
      body: JSON.stringify({ order_id_full: orderIdFull, transaction_status: status }),
    })
    .then(r => r.ok ? r.json() : Promise.reject(r))
    .then(() => location.href = '/pesanan')
    .catch(e => console.error('updateStatus error', e));
  }
});
