@extends('layouts.app')

@section('title', 'Kasir')
@section('header', 'Point of Sale (POS)')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-120px)]">
    <div class="lg:w-2/3 bg-white rounded-3xl shadow-sm border border-slate-200 p-6 flex flex-col h-full">
        <div class="mb-4">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-4 text-slate-400"></i>
                <input type="text" id="search" onkeyup="filterProduk()" placeholder="Cari nama produk atau kode..." 
                    class="w-full border-slate-200 rounded-2xl p-4 pl-12 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none border transition shadow-sm">
            </div>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 overflow-y-auto p-2 custom-scrollbar flex-1" id="produk-container">
            @foreach($produk as $p)
            <div onclick="addToCart('{{ $p->id_produk }}', '{{ $p->nama_produk }}', {{ $p->harga_jual }}, {{ $p->stok }})" 
                class="produk-item cursor-pointer bg-white border border-slate-100 p-4 rounded-2xl hover:border-blue-500 hover:shadow-xl transition group flex flex-col justify-between h-full relative overflow-hidden"
                data-nama="{{ strtolower($p->nama_produk) }}"
                data-kode="{{ strtolower($p->id_produk) }}">
                
                <div class="absolute top-2 right-2 bg-slate-900/80 text-white text-[10px] px-2 py-1 rounded-full font-bold backdrop-blur-sm">
                    {{ $p->stok }}
                </div>

                <div class="w-full h-32 bg-slate-50 rounded-xl mb-3 overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('images/produk/'.$p->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                        onerror="this.src='https://ui-avatars.com/api/?name={{ $p->nama_produk }}&background=random'">
                </div>
                
                <div>
                    <h4 class="font-bold text-slate-800 text-sm leading-tight mb-1 line-clamp-2">{{ $p->nama_produk }}</h4>
                    <p class="text-[10px] text-slate-400 font-mono mb-2">{{ $p->id_produk }}</p>
                    <div class="flex justify-between items-end">
                        <p class="text-blue-600 font-black text-lg">Rp{{ number_format($p->harga_jual, 0, ',', '.') }}</p>
                        <button class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="lg:w-1/3 bg-white rounded-3xl shadow-lg border border-slate-200 flex flex-col h-full relative overflow-hidden">
        <div class="p-5 border-b bg-slate-50/50 backdrop-blur-sm z-10">
            <h3 class="font-black text-slate-800 uppercase tracking-tighter flex items-center text-lg">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                Keranjang Belanja
            </h3>
        </div>

        <div id="cart-items" class="flex-1 p-4 space-y-3 overflow-y-auto custom-scrollbar">
            <div class="flex flex-col items-center justify-center h-full text-slate-300">
                <i class="fas fa-basket-shopping text-6xl mb-4"></i>
                <p class="font-bold">Keranjang Kosong</p>
                <p class="text-xs">Pilih produk di sebelah kiri</p>
            </div>
        </div>

        <div class="p-6 bg-white border-t shadow-[0_-5px_20px_rgba(0,0,0,0.05)] z-20">
            <div class="flex justify-between items-center mb-2 text-sm">
                <span class="text-slate-500">Subtotal</span>
                <span id="subtotal-display" class="font-bold text-slate-700">Rp0</span>
            </div>
            <div class="flex justify-between items-center mb-6">
                <span class="text-slate-800 font-black uppercase text-lg">Total Bayar</span>
                <span id="total-display" class="text-3xl font-black text-blue-600 tracking-tighter">Rp0</span>
            </div>
            
            <button onclick="checkout()" id="btn-checkout" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black shadow-lg shadow-slate-300 hover:bg-slate-800 transition transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2" disabled>
                <span>PROSES PEMBAYARAN</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
let cart = [];

// Fungsi Filter Pencarian
function filterProduk() {
    let input = document.getElementById('search').value.toLowerCase();
    let items = document.getElementsByClassName('produk-item');
    
    for (let i = 0; i < items.length; i++) {
        let nama = items[i].getAttribute('data-nama');
        let kode = items[i].getAttribute('data-kode');
        if (nama.includes(input) || kode.includes(input)) {
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
    }
}

// Fungsi Tambah ke Keranjang
function addToCart(id, name, price, stock) {
    let item = cart.find(p => p.id_produk === id);
    
    if (item) {
        if (item.qty >= stock) {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Habis!',
                text: 'Jumlah permintaan melebihi stok yang tersedia',
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }
        item.qty++;
        item.subtotal = item.qty * price;
    } else {
        if (stock <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Stok Kosong',
                text: 'Barang ini sedang habis!',
                timer: 1500,
                showConfirmButton: false
            });
            return;
        }
        cart.push({ 
            id_produk: id, 
            nama_produk: name, 
            harga_jual: price, 
            qty: 1, 
            subtotal: price,
            max_stock: stock 
        });
    }
    renderCart();
    
    // Efek getar kecil saat tambah barang
    if(navigator.vibrate) navigator.vibrate(50);
}

// Render Tampilan Keranjang
function renderCart() {
    let container = document.getElementById('cart-items');
    let totalDisplay = document.getElementById('total-display');
    let subtotalDisplay = document.getElementById('subtotal-display');
    let btnCheckout = document.getElementById('btn-checkout');
    let total = 0;
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full text-slate-300">
                <i class="fas fa-basket-shopping text-6xl mb-4"></i>
                <p class="font-bold">Keranjang Kosong</p>
                <p class="text-xs">Pilih produk di sebelah kiri</p>
            </div>`;
        totalDisplay.innerText = 'Rp0';
        subtotalDisplay.innerText = 'Rp0';
        btnCheckout.disabled = true;
        btnCheckout.classList.add('bg-slate-300', 'shadow-none');
        btnCheckout.classList.remove('bg-slate-900', 'shadow-lg');
        return;
    }

    btnCheckout.disabled = false;
    btnCheckout.classList.remove('bg-slate-300', 'shadow-none');
    btnCheckout.classList.add('bg-slate-900', 'shadow-lg');

    container.innerHTML = cart.map((item, index) => {
        total += item.subtotal;
        return `
            <div class="group relative flex justify-between items-center bg-white border border-slate-100 p-3 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="flex-1 pr-4">
                    <h5 class="font-bold text-slate-800 text-sm mb-1 leading-tight">${item.nama_produk}</h5>
                    <p class="text-[10px] text-slate-400 font-mono mb-1">${item.id_produk}</p>
                    <p class="text-xs text-blue-600 font-bold">Rp${item.harga_jual.toLocaleString('id-ID')}</p>
                </div>
                
                <div class="flex flex-col items-end gap-2">
                    <div class="flex items-center bg-slate-50 rounded-lg p-1 border border-slate-200">
                        <button onclick="updateQty(${index}, -1)" class="w-7 h-7 bg-white rounded-md shadow-sm flex items-center justify-center text-xs text-slate-600 hover:bg-red-50 hover:text-red-500 transition disabled:opacity-50">-</button>
                        <span class="font-bold text-sm w-8 text-center">${item.qty}</span>
                        <button onclick="updateQty(${index}, 1)" class="w-7 h-7 bg-white rounded-md shadow-sm flex items-center justify-center text-xs text-slate-600 hover:bg-blue-50 hover:text-blue-500 transition">+</button>
                    </div>
                    <span class="text-xs font-bold text-slate-700">Rp${item.subtotal.toLocaleString('id-ID')}</span>
                </div>
                
                <button onclick="removeItem(${index})" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full text-[10px] opacity-0 group-hover:opacity-100 transition shadow-md hover:bg-red-600 flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
    }).join('');

    totalDisplay.innerText = 'Rp' + total.toLocaleString('id-ID');
    subtotalDisplay.innerText = 'Rp' + total.toLocaleString('id-ID');
}

// Update Jumlah Barang
function updateQty(index, delta) {
    let item = cart[index];
    let newQty = item.qty + delta;

    if (newQty > item.max_stock) {
        Swal.fire({ icon: 'warning', title: 'Mencapai Batas Stok!', timer: 1000, showConfirmButton: false });
        return;
    }

    if (newQty <= 0) {
        removeItem(index);
        return;
    }

    item.qty = newQty;
    item.subtotal = item.qty * item.harga_jual;
    renderCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

// Proses Transaksi ke Server
async function checkout() {
    if (cart.length === 0) return;

    let total = cart.reduce((sum, item) => sum + item.subtotal, 0);

    Swal.fire({
        title: 'Memproses...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    try {
        const response = await fetch("{{ route('transaksi.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json' // PENTING: Minta server kirim JSON, bukan HTML
            },
            body: JSON.stringify({ 
                items: cart, 
                total_harga: total 
            })
        });

        // Cek jika response bukan JSON (misal HTML error)
        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            const text = await response.text();
            console.error("Error HTML Response:", text); // Cek Console browser (F12) untuk detail
            throw new Error("Terjadi kesalahan server (500). Cek Console (F12) untuk detail.");
        }

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal menyimpan transaksi');
        }

        // Jika Sukses
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Transaksi tersimpan.',
            confirmButtonText: 'OK'
        }).then(() => {
            // Opsional: Buka tab cetak nota
            // window.open("{{ url('transaksi/cetak') }}/" + data.id_transaksi, "_blank");
            location.reload();
        });

    } catch (error) {
        console.error(error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error.message
        });
    }
}
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection