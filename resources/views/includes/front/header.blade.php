 <header class="header">
   <div class="header__top">
     <div class="container">
       <div class="row">
         <div class="col-lg-6 col-md-6">
           <!-- Left side of header -->
           <div class="header__top__left">
             <ul>
               <li><i class="fa fa-envelope"></i> agropuro@mail.com</li>
               <li>Pengiriman Seluruh Indonesia</li>
             </ul>
           </div>
         </div>
         <div class="col-lg-6 col-md-6">
           <!-- Right side of header -->
           <div class="header__top__right">
             @if (auth()->check())
               <div class="header__top__right__language">
                 <form action="{{ route('logout') }}" method="POST">
                   @csrf
                   <button type="submit" style="border-style: none"><i class="fa fa-sign-out text-danger"></i>
                     Keluar</button>
                 </form>
               </div>
             @endif
             <div class="header__top__right__auth">
               @if (auth()->check())
                 <a href="{{ route('customer.order.index') }}"><i class="fa fa-user"></i>
                   {{ set_name_of_user(auth()->user()->name) }}</a>
               @else
                 <a href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
               @endif
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
   <!-- Navigation -->
   <div class="container">
     <div class="row">
       <div class="col-lg-3">
         <div class="header__logo">
           <a href="{{ route('home') }}">
             <img src="{{ asset('assets/logo.png') }}" alt="">
           </a>
         </div>
       </div>
       <div class="col-lg-6">
         <nav class="header__menu">
           <ul>
             <li class="{{ set_active('/') }}"><a href="{{ route('home') }}">Home</a></li>
             <li class="{{ set_active('product') }}"><a href="{{ route('product.index') }}">Produk</a></li>
             <li><a target="_blank" href="{{ route('customer.order.index') }}">Pesanan Saya</a></li>
             <li><a href="#">Menu</a>
               <ul class="header__menu__dropdown">
                 <li><a target="_blank" href="{{ route('forum.index') }}">Forum</a></li>
                 <li><a target="_blank" href="{{ route('plantingschedule.index') }}">Penjadwalan Tanam</a>
                 </li>
               </ul>
             </li>
           </ul>
         </nav>
       </div>
       <div class="col-lg-3">
         <div class="header__cart">
           <ul>
             <li><a href="{{ route('cart.index') }}"><i class="fa fa-shopping-bag"></i>
                 <span>{{ total_product_in_cart() }}</span></a></li>
           </ul>
           <div class="header__cart__price"><span>{{ total_price_in_cart() }}</span></div>
         </div>
       </div>
     </div>
     <div class="hamburger__open">
       <i class="fa fa-bars"></i>
     </div>
   </div>
 </header>
