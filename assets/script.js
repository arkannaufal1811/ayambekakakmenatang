// assets/script.js
document.addEventListener('DOMContentLoaded', function () {
  // toggle menu navigasi di layar kecil
  var toggle = document.getElementById('menuToggle');
  var navlinks = document.getElementById('navlinks');
  if (toggle && navlinks) {
    toggle.addEventListener('click', function () {
      navlinks.classList.toggle('open');
    });
    navlinks.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        navlinks.classList.remove('open');
      });
    });
  }

  // tombol cetak struk
  document.querySelectorAll('[data-print]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      window.print();
    });
  });

  // konfirmasi sebelum hapus transaksi
  document.querySelectorAll('[data-confirm]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      if (!confirm(el.getAttribute('data-confirm'))) {
        e.preventDefault();
      }
    });
  });

  // ---- form pesanan multi-item (halaman laporan.php) ----
  var itemRows = document.getElementById('itemRows');
  var btnTambah = document.getElementById('btnTambahBaris');
  var estimasiEl = document.getElementById('estimasiTotal');

  if (itemRows && window.MENU_DATA) {
    function rupiah(n) {
      return 'Rp ' + n.toLocaleString('id-ID');
    }

    function hitungTotal() {
      var total = 0;
      itemRows.querySelectorAll('.item-row').forEach(function (row) {
        var select = row.querySelector('select');
        var qty = parseInt(row.querySelector('input[type=number]').value || '0', 10);
        var opt = select.options[select.selectedIndex];
        var harga = opt ? parseInt(opt.getAttribute('data-harga') || '0', 10) : 0;
        total += harga * qty;
      });
      if (estimasiEl) estimasiEl.textContent = rupiah(total);
    }

    function buatOptions() {
      return window.MENU_DATA.map(function (m) {
        return '<option value="' + m.id + '" data-harga="' + m.harga + '">' + m.nama + ' — ' + rupiah(parseInt(m.harga)) + '</option>';
      }).join('');
    }

    function tambahBaris() {
      var row = document.createElement('div');
      row.className = 'item-row';
      row.innerHTML =
        '<select name="menu_id[]" required>' + buatOptions() + '</select>' +
        '<input type="number" name="qty[]" min="1" value="1" required>' +
        '<button type="button" class="rowbtn danger btn-hapus-baris">Hapus</button>';
      itemRows.appendChild(row);

      row.querySelector('select').addEventListener('change', hitungTotal);
      row.querySelector('input[type=number]').addEventListener('input', hitungTotal);
      row.querySelector('.btn-hapus-baris').addEventListener('click', function () {
        if (itemRows.querySelectorAll('.item-row').length > 1) {
          row.remove();
          hitungTotal();
        }
      });
      hitungTotal();
    }

    btnTambah.addEventListener('click', tambahBaris);
    tambahBaris(); // mulai dengan 1 baris
  }
});
