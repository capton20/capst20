@php
    $cart = session()->get('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
    $subtotal = 0;

    foreach ($cart as $cartItem) {
        $subtotal += $cartItem['price'] * $cartItem['quantity'];
    }

    // Mengikuti desain referensi: PB1 10%.
    $tax = round($subtotal * 0.10);
    $grandTotal = $subtotal + $tax;
@endphp

<!DOCTYPE html>

<html lang="id"><head><meta charset="utf-8"/><meta content="width=device-width, initial-scale=1.0" name="viewport"/><meta content="web_standard" name="shell-type"/><title>JOGO KOPI — Artisanal Roastery &amp; Self-Ordering</title><link href="https://fonts.googleapis.com" rel="preconnect"/><link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/><link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@600;700&amp;family=Plus+Jakarta+Sans:wght@400;600&amp;display=swap" rel="stylesheet"/><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/><style>@layer base{html,body{margin:0;padding:0;}body{overscroll-behavior:none;}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style><script src="https://cdn.tailwindcss.com"></script><script id="tailwind-config">tailwind.config={darkMode:"class",theme:{extend:{"colors":{"on-tertiary-fixed":"#00210a","on-error":"#ffffff","outline":"#827470","primary":"#090100","on-secondary-fixed-variant":"#763308","tertiary-fixed":"#95f8a7","surface-container":"#f1ede7","primary-fixed-dim":"#e3bfb2","on-primary":"#ffffff","outline-variant":"#d3c3be","on-surface-variant":"#504440","surface-tint":"#74584e","surface-container-high":"#ebe8e2","secondary-fixed-dim":"#ffb691","surface-variant":"#e6e2dc","secondary-fixed":"#ffdbcb","on-tertiary-container":"#349751","primary-container":"#2c1810","on-primary-container":"#9e7e73","secondary":"#944a1e","error-container":"#ffdad6","surface-dim":"#dddad4","on-tertiary-fixed-variant":"#005323","surface-container-highest":"#e6e2dc","background":"#fdf9f3","surface-bright":"#fdf9f3","tertiary":"#000401","on-secondary":"#ffffff","inverse-primary":"#e3bfb2","inverse-surface":"#31302d","tertiary-fixed-dim":"#79db8d","tertiary-container":"#00230b","on-background":"#1c1c18","error":"#ba1a1a","surface-container-low":"#f7f3ed","on-surface":"#1c1c18","on-tertiary":"#ffffff","secondary-container":"#fe9e6c","on-secondary-container":"#773308","surface-container-lowest":"#ffffff","on-primary-fixed-variant":"#5a4137","on-primary-fixed":"#2a170f","on-secondary-fixed":"#341100","primary-fixed":"#ffdbce","on-error-container":"#93000a","inverse-on-surface":"#f4f0ea","surface":"#fdf9f3"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"spacing":{"space-2xl":"3rem","space-sm":"0.5rem","space-xl":"2rem","space-xs":"0.25rem","margin-lg":"3rem","margin":"1rem","space-md":"1rem","margin-md":"2rem","gutter-lg":"2rem","gutter":"1rem","gutter-md":"1.5rem","space-lg":"1.5rem"},"fontFamily":{"headline-md":["Epilogue"],"price-lg":["Epilogue"],"headline-lg":["Epilogue"],"label-sm":["Plus Jakarta Sans"],"headline-xl":["Epilogue"],"label-md":["Plus Jakarta Sans"],"display-lg":["Epilogue"],"headline-xl-mobile":["Epilogue"],"headline-sm":["Epilogue"],"body-sm":["Plus Jakarta Sans"],"body-md":["Plus Jakarta Sans"],"display-lg-mobile":["Epilogue"],"price-md":["Epilogue"],"body-xl":["Plus Jakarta Sans"],"label-lg":["Plus Jakarta Sans"],"body-lg":["Plus Jakarta Sans"]},"fontSize":{"headline-md":["20px",{"lineHeight":"28px","fontWeight":"600"}],"price-lg":["20px",{"lineHeight":"24px","letterSpacing":"-0.01em","fontWeight":"700"}],"headline-lg":["24px",{"lineHeight":"32px","fontWeight":"600"}],"label-sm":["12px",{"lineHeight":"16px","letterSpacing":"0.02em","fontWeight":"600"}],"headline-xl":["32px",{"lineHeight":"40px","letterSpacing":"-0.01em","fontWeight":"700"}],"label-md":["14px",{"lineHeight":"20px","letterSpacing":"0.01em","fontWeight":"600"}],"display-lg":["48px",{"lineHeight":"56px","letterSpacing":"-0.02em","fontWeight":"700"}],"headline-xl-mobile":["26px",{"lineHeight":"34px","letterSpacing":"-0.01em","fontWeight":"700"}],"headline-sm":["18px",{"lineHeight":"24px","fontWeight":"600"}],"body-sm":["12px",{"lineHeight":"16px","fontWeight":"400"}],"body-md":["14px",{"lineHeight":"20px","fontWeight":"400"}],"display-lg-mobile":["36px",{"lineHeight":"44px","letterSpacing":"-0.02em","fontWeight":"700"}],"price-md":["16px",{"lineHeight":"20px","fontWeight":"700"}],"body-xl":["18px",{"lineHeight":"28px","fontWeight":"400"}],"label-lg":["16px",{"lineHeight":"24px","letterSpacing":"0.01em","fontWeight":"600"}],"body-lg":["16px",{"lineHeight":"24px","fontWeight":"400"}]}}}}</script></head><body class="bg-background font-body-md text-on-surface antialiased"><header class="fixed top-0 left-0 right-0 z-50 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]"><div class="h-20 max-w-7xl mx-auto px-6 lg:px-12 flex items-center justify-between gap-space-md"><div class="flex items-center gap-space-md"><img alt="JOGO KOPI Brand Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WEDlxEdnqpkqCslgZq3EAdeGTCRffaVVNbjnCZphvicYHhwcN0K62mPjfiCFmoK2ulwolT8Y3ApFv1Pp2XxJCt9rrWs7oRseiOLDB1Yf6_K3NhSpNSM3UoktlSMArZy75pXI8vxPvngQ6w8lMKxGKj1reTtuevRYR4kksphJJVtAiALOungOq0iNPiSmdo8l8Tn35GkbRc7CfjGfSpFAvp_DTz-ChQuLJn3JaX"/><div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-primary leading-none">JOGO KOPI</span><span class="font-label-sm text-label-sm text-secondary leading-tight mt-0.5">Artisanal Roastery</span></div><div class="hidden sm:flex items-center gap-space-xs bg-surface-container px-space-sm py-1 rounded-full shadow-[0_1px_4px_rgba(44,24,16,0.04)]"><span class="w-2 h-2 rounded-full bg-on-tertiary-container animate-pulse"></span><span class="font-label-sm text-label-sm text-on-surface">Meja No. 07</span><span class="font-label-sm text-label-sm text-on-surface-variant">• Dine-In</span></div></div><nav class="hidden md:flex items-center gap-space-sm bg-surface-container-low px-space-xs py-1 rounded-full" data-active-classes="bg-primary-container text-on-primary-container font-label-md rounded-full px-4 py-2 transition-all"><a aria-current="page" class="bg-primary-container text-on-primary-container font-label-md rounded-full px-4 py-2 transition-all" data-path="katalog-menu" href="#">Katalog Menu</a><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface px-space-md py-space-xs transition-colors rounded-full" data-path="lacak-pesanan" href="{{ route('orders.index') }}">Lacak Pesanan</a><a class="font-label-md text-label-md text-on-surface-variant hover:text-on-surface px-space-md py-space-xs transition-colors rounded-full" data-path="reservasi-meja" href="#" aria-label="Reservasi Meja">Reservasi Meja</a></nav><div class="flex items-center gap-space-sm"><a href="{{ route('cart.index') }}" class="flex items-center gap-space-sm bg-primary-container text-on-primary-container px-space-md py-2.5 rounded-full shadow-[0_2px_8px_-2px_rgba(44,24,16,0.12)] hover:bg-primary hover:text-on-primary transition-all duration-200"><div class="relative flex items-center justify-center"><span class="material-symbols-outlined text-[20px]">shopping_bag</span><span class="absolute -top-1.5 -right-2 bg-secondary text-on-secondary font-label-sm text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">{{ $cartCount }}</span></div><div class="flex flex-col text-left"><span class="font-label-sm text-[11px] leading-none opacity-80">Keranjang</span><span class="font-price-md text-price-md text-on-primary leading-tight">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div></a><div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shadow-[0_1px_4px_rgba(0,0,0,0.1)]"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div></div></div></header><main class="w-full pt-20 bg-background min-h-screen"><div class="flex flex-col w-full">
<!-- Top Hero / Welcome Notice Strip -->
<div class="relative overflow-hidden bg-primary-container text-on-primary px-6 lg:px-12 py-space-lg shadow-md">
<div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-space-md relative z-10">
<div class="flex items-center gap-space-md">
<div class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center text-on-secondary shrink-0 shadow-sm">
<span class="material-symbols-outlined text-[26px]">table_restaurant</span>
</div>
<div>
<div class="flex items-center gap-2">
<span class="font-headline-sm text-headline-sm text-on-primary">Meja #07 • Area Indoor AC</span>
<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-on-tertiary-container/20 text-tertiary-fixed text-label-sm font-label-sm">
<span class="w-1.5 h-1.5 rounded-full bg-tertiary-fixed animate-ping"></span>
              Sesi Aktif
            </span>
</div>
<p class="font-body-md text-body-md text-surface-container-high/90 mt-0.5">
            Selamat datang di JOGO KOPI! Silakan pilih menu favorit Anda langsung dari meja tanpa perlu antre ke kasir.
          </p>
</div>
</div>
<div class="flex items-center gap-3 shrink-0 self-stretch md:self-auto bg-primary/40 px-space-md py-2.5 rounded-xl shadow-inner">
<span class="material-symbols-outlined text-secondary-container text-[20px]">badge</span>
<div class="flex flex-col">
<span class="font-label-sm text-[11px] text-surface-container-high/70">Pemesan Saat Ini</span>
<span class="font-label-md text-label-md text-on-primary font-semibold">Tamu Meja 07</span>
</div>
<button class="ml-2 text-surface-container-high hover:text-on-primary text-label-sm font-label-sm underline transition-colors" type="button">
          Ubah
        </button>
</div>
</div>
<div class="absolute -right-16 -top-24 w-80 h-80 rounded-full bg-secondary/15 blur-3xl pointer-events-none"></div>
</div>
<!-- Main Body Content: Split Grid for Catalog & Real-time Cart -->
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-12 py-space-xl">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
<!-- LEFT SECTION: Catalog Search, Categories & Menu Grid (8 Cols) -->
<section class="lg:col-span-8 flex flex-col gap-space-lg min-w-0">
<!-- Search and Live Filter Container -->
<div class="flex flex-col gap-space-md bg-surface-container-lowest p-space-md sm:p-space-lg rounded-xl shadow-sm">
  <form method="GET" action="{{ route('catalog.index') }}" class="flex flex-col sm:flex-row items-stretch gap-space-sm">
    <div class="relative flex-1">
      <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[22px]">search</span>
      <input class="w-full pl-12 pr-4 py-3 bg-surface-container-low rounded-xl font-body-md text-body-md text-on-surface placeholder:text-on-surface-variant/70 focus:outline-none focus:bg-surface transition-all"
        id="search-input" name="search" value="{{ request('search') }}"
        placeholder="Cari kopi, artisan pizza, matcha, atau camilan..." type="text"/>
      @if(request('category_id'))
        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
      @endif
    </div>
    <button class="px-6 py-3 bg-secondary text-on-secondary rounded-xl font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-secondary/90 transition-colors shadow-sm" type="submit">
      <span class="material-symbols-outlined text-[18px]">search</span> Cari
    </button>
  </form>
  <!-- Quick Category Filters -->
  <div class="flex items-center gap-2 overflow-x-auto pb-1 -mx-2 px-2 scrollbar-none">
    <a href="{{ route('catalog.index', request()->only('search')) }}"
       class="px-4 py-2 rounded-full font-label-md text-label-md whitespace-nowrap shadow-sm {{ !request('category_id') ? 'bg-primary-container text-on-primary' : 'bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors' }}">
      Semua Menu
    </a>
    @foreach($categories as $category)
      <a href="{{ route('catalog.index', array_filter(['search' => request('search'), 'category_id' => $category->id])) }}"
         class="px-4 py-2 rounded-full font-label-md text-label-md whitespace-nowrap transition-colors {{ request('category_id') == $category->id ? 'bg-primary-container text-on-primary' : 'bg-surface-container hover:bg-surface-container-high text-on-surface' }}">
        {{ $category->name }}
      </a>
    @endforeach
  </div>
</div>
<!-- Section Title & Meta Count -->
<div class="flex items-center justify-between px-1">
<div class="flex items-baseline gap-2">
<h2 class="font-headline-lg text-headline-lg text-primary">Katalog Pilihan</h2>
<span class="font-label-sm text-label-sm text-secondary">Dipanggang Segar Setiap Hari</span>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant">Menampilkan {{ $menus->count() }} Menu</span>
</div>
<!-- Product Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
@forelse($menus as $menu)
  <div class="group flex flex-col bg-surface-container-lowest rounded-xl p-space-md shadow-sm hover:shadow-md transition-all duration-300">
    <div class="relative w-full h-44 rounded-lg overflow-hidden bg-surface-container">
      @if($menu->image_url)
        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
             src="{{ $menu->image_url }}" alt="{{ $menu->name }}"/>
      @else
        <div class="w-full h-full flex items-center justify-center text-secondary">
          <span class="material-symbols-outlined text-[56px]">coffee</span>
        </div>
      @endif
      @if($menu->category)
        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md bg-secondary text-on-secondary font-label-sm text-[11px] shadow-sm">
          {{ $menu->category->name }}
        </span>
      @endif
    </div>
    <div class="flex flex-col flex-1 mt-space-md">
      <div class="flex items-baseline justify-between gap-2">
        <h3 class="font-headline-sm text-headline-sm text-primary">{{ $menu->name }}</h3>
        <span class="font-price-lg text-price-lg text-secondary shrink-0">{{ $menu->formatted_price }}</span>
      </div>
      <p class="font-body-md text-body-md text-on-surface-variant mt-1.5 line-clamp-2">
        {{ $menu->description }}
      </p>
      <form action="{{ route('cart.store') }}" method="POST" class="mt-space-md flex flex-col gap-2">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[16px]">edit_note</span>
          <input name="note" class="w-full pl-9 pr-3 py-2 bg-surface-container-low text-on-surface placeholder:text-on-surface-variant/60 font-body-sm text-body-sm rounded-lg focus:outline-none focus:bg-surface"
                 placeholder="Catatan (cth: Less sugar 50%, es sedikit)..." type="text"/>
        </div>
        <button class="w-full py-2.5 rounded-lg bg-on-tertiary-container hover:bg-on-tertiary-fixed-variant text-on-error font-label-md text-label-md flex items-center justify-center gap-2 shadow-sm transition-colors active:scale-[0.98]" type="submit">
          <span class="material-symbols-outlined text-[18px]">add_circle</span>
          + Tambah ke Keranjang
        </button>
      </form>
    </div>
  </div>
@empty
  <div class="md:col-span-2 bg-surface-container-lowest rounded-xl p-10 text-center">
    <span class="material-symbols-outlined text-secondary text-[48px]">coffee</span>
    <h3 class="font-headline-sm text-headline-sm text-primary mt-3">Menu tidak ditemukan</h3>
    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Coba kata kunci atau kategori lainnya.</p>
    <a href="{{ route('catalog.index') }}" class="inline-block mt-4 text-secondary underline">Tampilkan semua menu</a>
  </div>
@endforelse
</div>
</section>
<!-- RIGHT SECTION: Sticky Real-time Order Cart Drawer (4 Cols) -->
<aside class="lg:col-span-4 sticky top-24 flex flex-col gap-space-md">
<div class="bg-surface-container-lowest rounded-xl shadow-md p-space-lg flex flex-col">
<!-- Cart Header -->
<div class="flex items-center justify-between pb-space-md bg-gradient-to-b from-transparent to-surface-container-low/40 -mx-space-lg px-space-lg -mt-space-lg pt-space-lg rounded-t-xl">
<div class="flex items-center gap-2.5">
<div class="w-9 h-9 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-[20px]">shopping_bag</span>
</div>
<div>
<h3 class="font-headline-sm text-headline-sm text-primary">Pesanan Meja #07</h3>
<span class="font-label-sm text-label-sm text-secondary">{{ $cartCount }} Menu Terpilih</span>
</div>
</div>
<form action="{{ route('cart.index') }}" method="GET">
              <button class="text-on-surface-variant hover:text-error text-label-sm font-label-sm transition-colors" type="button" onclick="alert('Untuk mengosongkan keranjang, hapus item satu per satu melalui tombol hapus di halaman keranjang.');">
                Kosongkan
              </button>
            </form>
</div>
<!-- Cart Items List -->
<div class="flex flex-col gap-3 py-space-md">
@forelse($cart as $id => $item)
  <div class="flex flex-col bg-surface-container-low/70 p-3 rounded-xl gap-2">
    <div class="flex items-start justify-between gap-2">
      <div class="flex flex-col min-w-0">
        <span class="font-headline-sm text-[15px] text-primary truncate">{{ $item['name'] }}</span>
        <span class="font-price-md text-price-md text-secondary">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
      </div>
      <div class="flex items-center gap-2 bg-surface-container-lowest px-2 py-1 rounded-full shadow-sm">
        <form action="{{ route('cart.update', $id) }}" method="POST">
          @csrf @method('PATCH')
          <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
          <input type="hidden" name="note" value="{{ $item['note'] ?? '' }}">
          <button class="w-5 h-5 flex items-center justify-center text-on-surface-variant hover:text-primary font-bold" type="submit">−</button>
        </form>
        <span class="font-label-md text-label-md text-primary font-bold">{{ $item['quantity'] }}</span>
        <form action="{{ route('cart.update', $id) }}" method="POST">
          @csrf @method('PATCH')
          <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
          <input type="hidden" name="note" value="{{ $item['note'] ?? '' }}">
          <button class="w-5 h-5 flex items-center justify-center text-on-surface-variant hover:text-primary font-bold" type="submit">+</button>
        </form>
      </div>
    </div>
    @if(!empty($item['note']))
      <div class="flex items-center gap-1.5 text-on-surface-variant text-[12px] bg-surface-container-lowest/80 px-2 py-1 rounded-md">
        <span class="material-symbols-outlined text-[14px] text-secondary">tune</span>
        <span class="truncate">{{ $item['note'] }}</span>
      </div>
    @endif
    <div class="flex items-center justify-between">
      <span class="text-xs text-on-surface-variant">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
      <form action="{{ route('cart.destroy', $id) }}" method="POST">
        @csrf @method('DELETE')
        <button type="submit" class="text-xs text-error hover:underline">Hapus</button>
      </form>
    </div>
  </div>
@empty
  <div class="py-8 text-center text-on-surface-variant">
    <span class="material-symbols-outlined text-[36px]">shopping_bag</span>
    <p class="font-label-md mt-2">Keranjang masih kosong</p>
    <p class="text-xs mt-1">Pilih menu favorit untuk memulai pesanan.</p>
  </div>
@endforelse
</div>
<!-- Price Summary Section -->
<div class="flex flex-col gap-2 pt-space-sm pb-space-md">
<div class="flex justify-between items-center text-on-surface-variant font-body-md text-body-md">
<span>Subtotal ({{ $cartCount }} item)</span>
<span class="text-on-surface font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
</div>
<div class="flex justify-between items-center text-on-surface-variant font-body-md text-body-md">
<span class="flex items-center gap-1">
                Pajak Restoran (PB1 10%)
                <span class="material-symbols-outlined text-[14px] text-on-surface-variant/60 cursor-pointer">help_outline</span>
</span>
<span class="text-on-surface">Rp {{ number_format($tax, 0, ',', '.') }}</span>
</div>
<div class="flex justify-between items-center pt-2 mt-1 bg-surface-container-low px-3 py-2.5 rounded-lg">
<span class="font-headline-sm text-headline-sm text-primary">Total Bayar</span>
<span class="font-headline-lg text-headline-lg text-secondary font-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
</div>
</div>
<!-- Quick Payment Selector (No Login Needed) -->
<div class="flex flex-col gap-2 mb-space-md">
<span class="font-label-sm text-label-sm text-on-surface font-semibold">Metode Pembayaran Mandiri:</span>
<div class="grid grid-cols-2 gap-2">
<label class="cursor-pointer flex flex-col p-2.5 rounded-xl bg-primary-container text-on-primary shadow-sm transition-all">
<div class="flex items-center justify-between">
<span class="material-symbols-outlined text-[18px] text-secondary-container">qr_code_scanner</span>
<input class="accent-secondary" form="checkout-form" name="payment_method" type="radio" value="qris" checked checked/>
</div>
<span class="font-label-md text-[13px] font-semibold mt-1">QRIS Instant</span>
<span class="text-[10px] text-surface-container-high/80 leading-tight">GoPay, BCA, Dana, dll</span>
</label>
<label class="cursor-pointer flex flex-col p-2.5 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface shadow-sm transition-all">
<div class="flex items-center justify-between">
<span class="material-symbols-outlined text-[18px] text-secondary">point_of_sale</span>
<input class="accent-secondary" form="checkout-form" name="payment_method" type="radio" value="cashier"/>
</div>
<span class="font-label-md text-[13px] font-semibold mt-1">Bayar di Kasir</span>
<span class="text-[10px] text-on-surface-variant leading-tight">Tunai / Debit setelah makan</span>
</label>
</div>
</div>
<!-- Checkout Trigger Button -->
<button {{ $cartCount === 0 ? "disabled" : "" }} class="w-full py-3.5 px-4 rounded-xl bg-on-tertiary-container hover:bg-on-tertiary-fixed-variant disabled:opacity-40 disabled:cursor-not-allowed text-on-error font-headline-sm text-[16px] font-bold flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all active:scale-[0.99]" onclick="document.getElementById('confirmation-dialog').classList.remove('hidden');" type="button">
<span>Konfirmasi &amp; Kirim Pesanan</span>
<span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</button>
<!-- Kitchen Guarantee Microcopy -->
<div class="mt-3 flex items-center justify-center gap-1.5 text-center text-on-surface-variant">
<span class="material-symbols-outlined text-[16px] text-on-tertiary-container">verified</span>
<span class="font-label-sm text-[11px]">Langsung tercetak di display barista &amp; kitchen JOGO.</span>
</div>
</div>
<!-- Secondary Support Card for Table Patrons -->
<div class="bg-surface-container p-space-md rounded-xl flex items-center justify-between gap-space-sm shadow-sm">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-surface-container-lowest flex items-center justify-center text-secondary">
<span class="material-symbols-outlined text-[22px]">notifications_active</span>
</div>
<div class="flex flex-col">
<span class="font-label-md text-label-md text-primary font-semibold">Butuh Bantuan Pelayan?</span>
<span class="font-body-sm text-body-sm text-on-surface-variant">Air minum, sendok garpu, atau tisu tambahan.</span>
</div>
</div>
<button class="px-3 py-1.5 rounded-lg bg-surface-container-lowest hover:bg-surface-container-highest text-primary font-label-sm text-label-sm shadow-sm transition-colors shrink-0" type="button">
            Panggil
          </button>
</div>
</aside>
</div>
</div>
<!-- Interactive Order Confirmation Modal Drawer (Simulated Checkout Dialogue) -->
<div class="fixed inset-0 z-50 bg-primary/60 backdrop-blur-sm hidden flex items-center justify-center p-4" id="confirmation-dialog">
<div class="bg-surface-container-lowest w-full max-w-lg rounded-2xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200">
<div class="bg-primary-container text-on-primary p-space-lg flex items-center justify-between">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-secondary-container text-[28px]">receipt_long</span>
<div>
<h4 class="font-headline-md text-headline-md text-on-primary">Verifikasi Pesanan Meja #07</h4>
<p class="font-body-sm text-body-sm text-surface-container-high/80">Mohon periksa kembali pesanan Anda sebelum dikirim ke dapur.</p>
</div>
</div>
<button class="text-on-primary/70 hover:text-on-primary" onclick="document.getElementById('confirmation-dialog').classList.add('hidden');" type="button">
<span class="material-symbols-outlined text-[24px]">close</span>
</button>
</div>
<div class="p-space-lg flex flex-col gap-space-md max-h-[614px] overflow-y-auto">
<div class="flex items-center justify-between pb-3 bg-surface-container-low p-3 rounded-xl">
<div class="flex flex-col">
<span class="font-label-sm text-on-surface-variant">Tujuan Antar:</span>
<span class="font-headline-sm text-primary font-bold">Meja #07 (Indoor AC)</span>
</div>
<span class="font-price-lg text-price-lg text-secondary">Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
</div>
<div class="flex flex-col gap-2">
  <span class="font-label-md text-label-md text-primary font-semibold">Rincian Menu:</span>
  @forelse($cart as $item)
    <div class="flex justify-between gap-3 text-body-md font-body-md text-on-surface py-1">
      <span>{{ $item['quantity'] }}x {{ $item['name'] }}</span>
      <span class="font-price-md shrink-0">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
    </div>
  @empty
    <p class="text-sm text-on-surface-variant">Belum ada menu di keranjang.</p>
  @endforelse
  <div class="flex justify-between text-body-sm font-body-sm text-on-surface-variant py-1">
    <span>Subtotal</span>
    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
  </div>
  <div class="flex justify-between text-body-sm font-body-sm text-on-surface-variant py-1">
    <span>Pajak Restoran PB1 (10%)</span>
    <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
  </div>
</div>
</div>
<div class="bg-secondary-fixed/30 p-3 rounded-xl flex items-center gap-3">
<span class="material-symbols-outlined text-secondary text-[22px]">info</span>
<p class="font-body-sm text-body-sm text-on-surface">
            Pesanan yang telah dikirim ke dapur tidak dapat dibatalkan secara sepihak. Estimasi penyajian 10 - 15 menit.
          </p>
</div>
</div>
<div class="p-space-lg bg-surface-container-low flex flex-col sm:flex-row items-center gap-space-sm">
<button class="w-full sm:w-auto px-5 py-3 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-label-md transition-colors text-center" onclick="document.getElementById('confirmation-dialog').classList.add('hidden');" type="button">
          Kembali Ubah
        </button>
<form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST" class="w-full sm:flex-1">
          @csrf
          <button class="w-full py-3 px-5 rounded-xl bg-on-tertiary-container hover:bg-on-tertiary-fixed-variant text-on-error font-label-md text-label-md font-bold flex items-center justify-center gap-2 shadow-sm transition-colors text-center" type="submit">
<span class="material-symbols-outlined text-[18px]">check_circle</span>
          Kirim Sekarang (Rp {{ number_format($grandTotal, 0, ',', '.') }})
        </button>
        </form>
</div>
</div>
</div>
</div></main><footer class="w-full bg-surface-container-low py-space-xl shadow-[0_-1px_6px_rgba(44,24,16,0.03)]"><div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-space-lg text-center md:text-left"><div class="flex flex-col items-center md:items-start gap-space-xs"><div class="flex items-center gap-space-sm"><span class="font-headline-sm text-headline-sm text-primary">JOGO KOPI</span><span class="font-label-sm text-label-sm bg-surface-container px-2 py-0.5 rounded text-on-surface-variant">Roastery &amp; Cafe</span></div><p class="font-body-sm text-body-sm text-on-surface-variant">Kenyamanan cita rasa kopi nusantara dalam suasana hangat dan bersahaja.</p></div><div class="flex flex-wrap items-center justify-center gap-space-md text-on-surface-variant"><div class="flex items-center gap-space-xs bg-surface px-space-md py-space-xs rounded-full shadow-[0_1px_4px_rgba(44,24,16,0.04)]"><span class="material-symbols-outlined text-[18px] text-secondary">schedule</span><span class="font-label-sm text-label-sm text-on-surface">Buka: 08.00 - 22.00 WIB</span></div><div class="flex items-center gap-space-xs bg-surface px-space-md py-space-xs rounded-full shadow-[0_1px_4px_rgba(44,24,16,0.04)]"><span class="material-symbols-outlined text-[18px] text-secondary">wifi</span><span class="font-label-sm text-label-sm text-on-surface">Wi-Fi: <strong class="font-label-sm text-primary">JOGO-GUEST / kopienak</strong></span></div><div class="flex items-center gap-space-xs bg-surface px-space-md py-space-xs rounded-full shadow-[0_1px_4px_rgba(44,24,16,0.04)]"><span class="material-symbols-outlined text-[18px] text-secondary">support_agent</span><span class="font-label-sm text-label-sm text-on-surface">Bantuan Pelayan</span></div></div><div class="font-body-sm text-body-sm text-on-surface-variant">© {{ date('Y') }} JOGO KOPI. All rights reserved.</div></div></footer></body></html>