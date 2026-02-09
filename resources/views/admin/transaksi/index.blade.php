@extends('layouts.app')

@section('title', 'Kasir')
@section('header', 'Point of Sale (POS)')

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    <div class="lg:w-2/3 bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
        <div class="mb-6">
            <input type="text" id="search" placeholder="Cari nama produk atau barcode..." 
                class="w-full border-slate-200 rounded-2xl p-4 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none border transition">
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 overflow-y-auto max-h-[600px] p-2">
            @foreach($produk as $p)
            <div onclick="addToCart('{{ $p->id_produk }}', '{{ $p->nama_produk }}', {{ $p->harga_jual }})" 
                class="cursor-pointer bg-white border border-slate-100 p-4 rounded-2xl hover:border-blue-500 hover:shadow-xl transition group">
                <img src="{{ asset('images/produk/'.$p->gambar) }}" class="w-full h-32 object-cover rounded-xl mb-3" onerror="this.src='https://placehold.co/200x200?text=No+Image'">
                <h4 class="font-bold text-slate-800 text-sm truncate">{{ $p->nama_produk }}</h4>
                <p class="text-blue-600 font-black mt-1">Rp{{ number_format($p->harga_jual) }}</p>
                <p class="text-[10px] text-slate-400 mt-1 uppercase">Stok: {{ $p->stok }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="lg:w-1/3 bg-white rounded-3xl shadow-lg border border-slate-200 flex flex-col min-h-[600px]">
        <div class="p-6 border-b">
            <h3 class="font-black text-slate-800 uppercase tracking-tighter flex items-center">
                <i class="fas fa-shopping-cart mr-3 text-blue-600"></i> Keranjang
            </h3>
        </div>

        <div id="cart-items" class="flex-1 p-6 space-y-4 overflow-y-auto max-h-[400px]">
            <p class="text-center text-slate-400 mt-10 italic">Keranjang kosong</p>
        </div>

        <div class="p-6 bg-slate-50 border-t rounded-b-3xl space-y-4">
            <div class="flex justify-between items-center">
                <span class="text-slate-500 font-bold uppercase text-xs">Total Bayar</span>
                <span id="total-display" class="text-3xl font-black text-slate-900 tracking-tighter">Rp0</span>
            </div>
            <button onclick="checkout()" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-xl shadow-blue-100 hover:bg-blue-700 transition transform active:scale-95">
                PROSES TRANSAKSI
            </button>
        </div>
    </div>
</div>

<script>
let cart = [];

function addToCart(id, name, price) {
    let item = cart.find(p => p.id_produk === id);
    if (item) {
        item.qty++;
        item.subtotal = item.qty * price;
    } else {
        cart.push({ id_produk: id, nama: name, harga: price, qty: 1, subtotal: price });
    }
    renderCart();
}

function renderCart() {
    let container = document.getElementById('cart-items');
    let totalDisplay = document.getElementById('total-display');
    let total = 0;
    
    if (cart.length === 0) {
        container.innerHTML = '<p class="text-center text-slate-400 mt-10 italic">Keranjang kosong</p>';
        totalDisplay.innerText = 'Rp0';
        return;
    }

    container.innerHTML = cart.map((item, index) => {
        total += item.subtotal;
        return `
            <div class="flex justify-between items-center bg-white border border-slate-100 p-3 rounded-xl shadow-sm">
                <div class="flex-1">
                    <h5 class="font-bold text-slate-800 text-xs">${item.nama}</h5>
                    <p class="text-[10px] text-slate-500">${item.qty} x Rp${item.harga.toLocaleString()}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="updateQty(${index}, -1)" class="w-6 h-6 bg-slate-100 rounded flex items-center justify-center text-xs hover:bg-red-100">-</button>
                    <span class="font-bold text-xs">${item.qty}</span>
                    <button onclick="updateQty(${index}, 1)" class="w-6 h-6 bg-slate-100 rounded flex items-center justify-center text-xs hover:bg-blue-100">+</button>
                </div>
            </div>
        `;
    }).join('');

    totalDisplay.innerText = 'Rp' + total.toLocaleString('id-ID');
}

function updateQty(index, delta) {
    cart[index].qty += delta;
    if (cart[index].qty <= 0) {
        cart.splice(index, 1);
    } else {
        cart[index].subtotal = cart[index].qty * cart[index].harga;
    }
    renderCart();
}

async function checkout() {
    if (cart.length === 0) return Swal.fire('Oops!', 'Pilih barang dulu bos!', 'error');

    let total = cart.reduce((sum, item) => sum + item.subtotal, 0);

    const res = await fetch("{{ route('transaksi.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items: cart, total_harga: total })
    });

    const data = await res.json();
    if (res.ok) {
        Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
    } else {
        Swal.fire('Error', data.message, 'error');
    }
}
</script>
@endsection