const vm = new Vue({
    el: "#app",
    data: {
        data_barang: [
            {
                id: 1,
                nama: "Rinso",
                harga: 2000,
                stok: 20,
                qty: 1,
                diskon: 15,
            },
            {
                id: 2,
                nama: "Molto",
                harga: 3000,
                stok: 1000,
                qty: 1,
                diskon: 10,
            },
        ],
        keranjang: [],
        pilih_barang: 0,
        data_harga: [],
        bayar: 0,
    },
    methods: {
        reset: function () {
            this.keranjang.splice(this.keranjang);
            this.data_harga.splice(this.data_harga);
        },
        total_harga_barang_tabel: function (
            index,
            harga = 0,
            qty = 0,
            diskon = 0
        ) {
            let hasil = qty * harga - (qty * harga * diskon) / 100;

            if (qty <= 0) {
                hasil = 0;
            }
            this.data_harga[index] = parseInt(hasil);

            return hasil;
        },
        total_harga_barang_modal: function (harga = 0, qty = 0, diskon = 0) {
            let hasil = qty * harga - (qty * harga * diskon) / 100;

            if (qty <= 0) {
                hasil = 0;
            }

            return hasil;
        },
        hapus_barang: function (id) {
            this.keranjang = this.keranjang.filter((barang) => barang.id != id);
            this.data_harga.splice(0);
        },
        total_harga: function () {
            return this.data_harga.reduce((a, b) => a + b, 0);
        },
        kembalian: function () {
            return this.bayar - this.total_harga();
        },
        convert_harga: function (x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        barang_dipilih: function () {
            var filter_barang = this.data_barang.find(
                (o) => o.id == this.pilih_barang
            );
            if (filter_barang) {
                return filter_barang;
            } else {
                return {
                    id: 0,
                    nama: "",
                    harga: 0,
                    stok: 0,
                    qty: 0,
                    diskon: 0,
                };
            }
        },
        cek_keranjang: function (id) {
            var filter_keranjang = this.keranjang.find((o) => o.id == id);
            if (filter_keranjang) {
                return true;
            } else {
                return false;
            }
        },
        tambah_data: function (data) {
            var harga = data.target.elements.harga.value.replace(
                /[^\w\s]/gi,
                ""
            );

            var input = {
                id: parseInt(data.target.elements.id.value),
                nama: data.target.elements.nama.value,
                harga: parseInt(harga),
                stok: parseInt(data.target.elements.stok.value),
                qty: parseInt(data.target.elements.qty.value),
                diskon: parseInt(data.target.elements.diskon.value),
            };
            this.keranjang.unshift(input);
            $("#addDataModal").modal("hide");
            this.pilih_barang = 0;
        },
        print: function () {
            var printContents = document.getElementById("print").innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            location.reload();
        },
    },
});
