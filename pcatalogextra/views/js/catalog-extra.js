// modules/pcatalogextra/views/js/catalog-extra.js
(function () {
  /* ===== Estilos mínimos ===== */
  (function injectStyle(){
    const css = `
      th.pce-available-date, td.pce-available-date{ text-align:center; white-space:nowrap; }
      th.pce-available-date a{ color:inherit; text-decoration:none; cursor:pointer; }
      th.pce-available-date .pce-caret{ margin-left:6px; opacity:.7; }
      th.pce-available-date-filter input[type="date"]{ width: 100%; min-width: 120px; }
    `;
    const s = document.createElement('style'); s.appendChild(document.createTextNode(css)); document.head.appendChild(s);
  })();

  /* ===== Utils ===== */
  const STATE_KEY = 'pcatalogextra_state'; // por página
  function getState(){
    try{ return JSON.parse(sessionStorage.getItem(STATE_KEY) || '{}'); }catch(_){ return {}; }
  }
  function setState(next){
    try{ sessionStorage.setItem(STATE_KEY, JSON.stringify(next||{})); }catch(_){}
  }

  const qTable = () =>
    document.querySelector('#product_catalog_list table.table') ||
    document.querySelector('.product-listing table') ||
    document.querySelector('table.table');

  function isCatalog() {
    const t = qTable(); if (!t) return false;
    const hs = Array.from(t.querySelectorAll('thead th')).map(th => th.textContent.trim().toLowerCase());
    return hs.includes('id') && (hs.some(x=>x.includes('referencia')) || hs.some(x=>x.includes('reference')));
  }

  function insertIndexAfterCategory(headerRow) {
    const cells = Array.from(headerRow.children);
    const i = cells.findIndex(th => {
      const tx = th.textContent.trim().toLowerCase();
      return tx.includes('categoría') || tx.includes('category');
    });
    return i >= 0 ? i + 1 : cells.length;
  }

  // Parse fechas "YYYY-MM-DD" (lo que envía tu AJAX) y soporta también "DD/MM/YYYY"
  function parseDate(val){
    if (!val) return null;
    const s = String(val).trim();
    if (/^\d{4}-\d{2}-\d{2}$/.test(s)) {
      const [Y,M,D] = s.split('-').map(n=>+n);
      const t = Date.UTC(Y, M-1, D);
      return isNaN(t) ? null : t;
    }
    if (/^\d{2}\/\d{2}\/\d{4}$/.test(s)) {
      const [D,M,Y] = s.split('/').map(n=>+n);
      const t = Date.UTC(Y, M-1, D);
      return isNaN(t) ? null : t;
    }
    return null;
  }

  function idFromRow(row) {
    const a = row.getAttribute('data-product-id') || row.dataset.productId; if (a) return a;
    const cb = row.querySelector('input[type="checkbox"][value]'); if (cb && /^\d+$/.test(cb.value)) return cb.value;
    const cells = row.querySelectorAll('td');
    for (let i=0;i<Math.min(3,cells.length);i++){ const v=(cells[i].textContent||'').trim(); if(/^\d+$/.test(v)) return v; }
    const link = row.querySelector('a[href*="id_product="]'); if (link){ const m=link.href.match(/id_product=(\d+)/); if(m) return m[1]; }
    return null;
  }

  function findPriceCell(row) {
    const r = /(\d+[.,]\d{2}).*?€/; // 12,34 € o 12.34 €
    const tds = Array.from(row.children);
    for (const td of tds) {
      const txt = (td.textContent || '').trim();
      if (r.test(txt)) return td;
    }
    return null;
  }

  /* ===== Cabecera + Filtros (con orden) ===== */
  function ensureHeaderAndFilter() {
    const t = qTable(); if (!t) return;
    const headRows = t.querySelectorAll('thead tr');
    const headerRow = headRows[0];
    const filterRow = headRows[1] || null;
    if (!headerRow) return;

    // CABECERA: "Fecha de lanzamiento" con caret y click para ordenar
    const headerInsertIdx = insertIndexAfterCategory(headerRow);
    let th = headerRow.querySelector('th.pce-available-date');
    if (!th) {
      th = document.createElement('th');
      th.className = 'pce-available-date';
      th.innerHTML = '<a class="pce-sort" data-order="none">Fecha de lanzamiento</a><span class="pce-caret">⇅</span>';
      headerRow.insertBefore(th, headerRow.children[headerInsertIdx] || null);
    } else {
      const cur = Array.from(headerRow.children).indexOf(th);
      if (cur !== headerInsertIdx) headerRow.insertBefore(th, headerRow.children[headerInsertIdx] || null);
    }

    // enlazar evento una sola vez
    if (!th.dataset.pceBound) {
      th.dataset.pceBound = '1';
      th.querySelector('.pce-sort').addEventListener('click', function(e){
        e.preventDefault();
        const st = getState();
        st.order = (st.order === 'asc') ? 'desc' : (st.order === 'desc' ? 'none' : 'asc');
        setState(st);
        updateHeaderCaret(st.order);
        applySortAndFilter();
      });
    }

    // FILTROS: dos inputs date (Desde / Hasta) justo después de "Categoría"
    if (filterRow) {
      const filterCells = Array.from(filterRow.children);
      const catFilterIdx = filterCells.findIndex(cell => {
        const txt = cell.textContent.trim().toLowerCase();
        const input = cell.querySelector('input, select');
        const ph = (input && input.getAttribute('placeholder') || '').toLowerCase();
        const name = (input && input.getAttribute('name') || '').toLowerCase();
        return txt.includes('buscar categoría') || txt.includes('search category') ||
               ph.includes('categoría') || ph.includes('category') ||
               name.includes('category');
      });
      const filterInsertIdx = (catFilterIdx >= 0) ? catFilterIdx + 1 : filterCells.length;

      let fth = filterRow.querySelector('th.pce-available-date-filter');
      if (!fth) {
        fth = document.createElement('th');
        fth.className = 'pce-available-date-filter';
        fth.innerHTML = `
          <div style="display:flex; gap:6px; align-items:center; justify-content:center;">
            <input type="date" class="pce-min form-control" placeholder="Desde" style="color: #0000009e;">
            <input type="date" class="pce-max form-control" placeholder="Hasta" style="color: #0000009e;">
          </div>`;
        filterRow.insertBefore(fth, filterRow.children[filterInsertIdx] || null);

        const st = getState();
        const min = fth.querySelector('.pce-min'), max = fth.querySelector('.pce-max');
        if (st.min) min.value = st.min;
        if (st.max) max.value = st.max;

        min.addEventListener('change', ()=>{ const s=getState(); s.min=min.value||''; setState(s); applySortAndFilter(); });
        max.addEventListener('change', ()=>{ const s=getState(); s.max=max.value||''; setState(s); applySortAndFilter(); });
      } else {
        const curF = Array.from(filterRow.children).indexOf(fth);
        if (curF !== filterInsertIdx) filterRow.insertBefore(fth, filterRow.children[filterInsertIdx] || null);
      }
    }

    // inicializar caret según estado
    const st = getState();
    updateHeaderCaret(st.order || 'none');
  }

  function updateHeaderCaret(order){
    const t = qTable(); if (!t) return;
    const th = t.querySelector('th.pce-available-date');
    if (!th) return;
    const caret = th.querySelector('.pce-caret');
    const link  = th.querySelector('.pce-sort');
    link.dataset.order = order || 'none';
    caret.textContent = order === 'asc' ? '▲' : order === 'desc' ? '▼' : '⇅';
    caret.style.opacity = order === 'none' ? .6 : 1;
  }

  /* ===== Cache ===== */
  const cache = new Map();
  try {
    const raw = sessionStorage.getItem('pcatalogextra_dates');
    if (raw) {
      const obj = JSON.parse(raw);
      for (const k in obj) if (Object.prototype.hasOwnProperty.call(obj,k)) cache.set(k, obj[k]);
    }
  } catch(_) {}
  function persistCache() {
    const obj = {}; cache.forEach((v,k)=>{ obj[k]=v; });
    try { sessionStorage.setItem('pcatalogextra_dates', JSON.stringify(obj)); } catch(_) {}
  }

  /* ===== AJAX ===== */
  let inFlight = null, abortCtrl = null, lastSignature = '';
  async function fetchDates(ids) {
    const ask = ids.filter(id => !cache.has(String(id)));
    if (!ask.length) return {};

    const signature = ask.join(',');
    if (signature === lastSignature && inFlight) return inFlight;
    lastSignature = signature;

    if (abortCtrl) abortCtrl.abort();
    abortCtrl = new AbortController();

    const form = new FormData();
    form.append('ids', ask.join(','));
    form.append('ajax', '1');

    inFlight = fetch(pcatalogextra_ajax + '&action=getAvailableDates', {
      method: 'POST',
      credentials: 'same-origin',
      body: form,
      cache: 'no-store',
      signal: abortCtrl.signal
    }).then(async res => {
      if (!res.ok) return {};
      const json = await res.json();
      if (!json || !json.ok || !json.data) return {};
      Object.keys(json.data).forEach(id => cache.set(String(id), json.data[id] || ''));
      persistCache();
      return json.data;
    }).catch(_ => ({}));

    return inFlight;
  }

  /* ===== BODY: anclar celda y pintar ===== */
  function ensureBodyPlaceholders(){
    const t = qTable(); if (!t) return {rows:[], ids:[]};
    const headerRow = t.querySelector('thead tr');
    const fallbackIdx = insertIndexAfterCategory(headerRow);
    const rows = Array.from(t.querySelectorAll('tbody tr'));
    const ids = [];

    rows.forEach(row => {
      let cell = row.querySelector('td.pce-available-date');
      if (!cell) {
        cell = document.createElement('td');
        cell.className = 'pce-available-date';
        cell.textContent = '…';
      }
      // Inserta SIEMPRE justo antes de la celda de Precio (ancla robusta)
      const priceCell = findPriceCell(row);
      if (priceCell) row.insertBefore(cell, priceCell);
      else row.insertBefore(cell, row.children[fallbackIdx] || null);

      const id = idFromRow(row);
      if (id) {
        ids.push(id);
        if (cache.has(String(id))) {
          cell.textContent = cache.get(String(id)) || '—';
          cell.dataset.pceDone = '1';
        }
      }
    });

    return {rows, ids: Array.from(new Set(ids))};
  }

  async function fillBodyValues(rows, ids){
    if (!ids.length) return;
    const map = await fetchDates(ids);

    rows.forEach(row => {
      const id = idFromRow(row);
      if (!id) return;
      const td = row.querySelector('td.pce-available-date');
      if (!td || td.dataset.pceDone === '1') return;
      const val = cache.get(String(id)) ?? (map ? map[id] : '');
      td.textContent = val && String(val).trim() !== '' ? val : '—';
      td.dataset.pceDone = '1';
    });
  }

  /* ===== SORT + FILTER (cliente) ===== */
  function applySortAndFilter(){
    const t = qTable(); if (!t) return;
    const tbody = t.querySelector('tbody'); if (!tbody) return;

    const st = getState();
    const minStr = st.min || '';
    const maxStr = st.max || '';
    const minTs = minStr ? parseDate(minStr) : null;
    const maxTs = maxStr ? parseDate(maxStr) : null;

    // 1) Filtrar
    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.forEach(row => {
      const td = row.querySelector('td.pce-available-date');
      const ts = parseDate(td ? td.textContent.trim() : '');
      let show = true;
      if (minTs !== null && (ts === null || ts < minTs)) show = false;
      if (maxTs !== null && (ts === null || ts > maxTs)) show = false;
      row.style.display = show ? '' : 'none';
    });

    // 2) Ordenar
    const order = st.order || 'none';
    if (order === 'none') return;

    const visible = rows.filter(r => r.style.display !== 'none');
    const hidden  = rows.filter(r => r.style.display === 'none');

    visible.sort((a,b) => {
      const ta = parseDate(a.querySelector('td.pce-available-date')?.textContent.trim());
      const tb = parseDate(b.querySelector('td.pce-available-date')?.textContent.trim());
      const va = (ta === null ? -Infinity : ta);
      const vb = (tb === null ? -Infinity : tb);
      const cmp = va === vb ? 0 : (va < vb ? -1 : 1);
      return order === 'asc' ? cmp : -cmp;
    });

    // Reaplicar al DOM (estable)
    const frag = document.createDocumentFragment();
    visible.forEach(r => frag.appendChild(r));
    hidden.forEach(r => frag.appendChild(r)); // mantén los ocultos al final
    tbody.appendChild(frag);
  }

  /* ===== Orquestación con debounce ===== */
  let debounceTimer = null;
  function schedule() {
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(async () => {
      if (!isCatalog()) return;
      ensureHeaderAndFilter();
      const {rows, ids} = ensureBodyPlaceholders();
      await fillBodyValues(rows, ids);
      applySortAndFilter();
    }, 250);
  }

  document.addEventListener('DOMContentLoaded', schedule);
  new MutationObserver(schedule).observe(document.documentElement,{childList:true,subtree:true});
})();
