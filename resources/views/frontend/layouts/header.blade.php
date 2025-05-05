<!-- Header -->
<header class="header shop bg-dark text-light">
<style>
    .header a:hover,
    .header .menu a:hover,
    .header .main-menu a:hover,
    .header .nav a:hover {
        color: white !important;
        background-color: transparent !important;
        text-decoration: none !important;
    }

    .header .menu-area li:hover {
        background-color: transparent !important;
    }

    .header a,
    .header li {
        transition: none !important;
        box-shadow: none !important;
    }

    .header .main-menu .active > a {
        color: white !important;
    }

    .header span.bg-light.text-dark {
        background-color: transparent !important;
        color: white !important;
    }
</style>
    <!-- Topbar -->
    <div style="background-color: black;" class="text-light">
        <div class="container">
            <div class="row">
                <!-- Contact Info -->
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="top-left">
                        <ul class="list-main">
                            @php $settings = DB::table('settings')->get(); @endphp
                            <li><i class="ti-headphone-alt text-light"></i> @foreach($settings as $data) {{$data->phone}} @endforeach</li>
                            <li><i class="ti-email text-light"></i> @foreach($settings as $data) {{$data->email}} @endforeach</li>
                        </ul>
                    </div>
                </div>

                <!-- Account Links -->
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="right-content">
                        <ul class="d-flex p-2 justify-content-between">
                            <li><i class="ti-location-pin text-light"></i> <a href="{{route('order.track')}}">Track Order</a></li>
                            @auth 
                                @if(Auth::user()->role=='admin')
                                    <li><i class="ti-user"></i> <a href="{{route('admin')}}" target="_blank">Dashboard</a></li>
                                @else 
                                    <li><i class="ti-user"></i> <a href="{{route('user')}}" target="_blank">Dashboard</a></li>
                                @endif
                                <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li>
                            @else
                                <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo + Search + Wishlist + Cart -->
    <div style="background-color: black;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-lg-2 col-md-2 col-12">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            <img src="{{ asset('storage/photos/1/') }}" alt="Logo">
                        </a>
                    </div>
                    <div class="search-top d-lg-none">
                        <form class="search-form">
                            <input type="text" placeholder="Search here..." name="search">
                            <button type="submit"><i class="ti-search"></i></button>
                        </form>
                    </div>
                    <div class="mobile-nav"></div>
                </div>

                <!-- Main Search -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option class="text-dark bg-dark">All Category</option>
                                @foreach(Helper::getAllCategory() as $cat)
                                    <option>{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Wishlist + Cart -->
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Wishlist -->
                        <div class="sinlge-bar shopping">
                            <a href="{{route('wishlist')}}" class="single-icon text-light">
                                <i class="fa fa-heart-o"></i>
                                <span class="total-count">{{Helper::wishlistCount()}}</span>
                            </a>
                            @auth
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                    <a href="{{route('wishlist')}}">View Wishlist</a>
                                </div>
                                <ul class="shopping-list">
                                    @foreach(Helper::getAllProductFromWishlist() as $data)
                                        @php $photo = explode(',', $data->product['photo']); @endphp
                                        <li>
                                            <a href="{{route('wishlist-delete',$data->id)}}" class="remove"><i class="fa fa-remove"></i></a>
                                            <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt=""></a>
                                            <h4><a href="{{route('product-detail',$data->product['slug'])}}">{{$data->product['title']}}</a></h4>
                                            <p class="quantity">{{$data->quantity}} x - <span class="amount">{{number_format($data->price,2)}}</span></p>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">{{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                    </div>
                                    <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                </div>
                            </div>
                            @endauth
                        </div>

                        <!-- Cart -->
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon text-light">
                                <i class="ti-bag"></i>
                                <span class="total-count">{{Helper::cartCount()}}</span>
                            </a>
                            @auth
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                    <a href="{{route('cart')}}">View Cart</a>
                                </div>
                                <ul class="shopping-list">
                                    @foreach(Helper::getAllProductFromCart() as $data)
                                        @php $photo = explode(',', $data->product['photo']); @endphp
                                        <li>
                                            <a href="{{route('cart-delete',$data->id)}}" class="remove"><i class="fa fa-remove"></i></a>
                                            <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt=""></a>
                                            <h4><a href="{{route('product-detail',$data->product['slug'])}}">{{$data->product['title']}}</a></h4>
                                            <p class="quantity">{{$data->quantity}} x - <span class="amount">KSH {{number_format($data->price,2)}}</span></p>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">KSH {{number_format(Helper::totalCartPrice(),2)}}</span>
                                    </div>
                                    <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                </div>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="header-inner" style="background-color: black;">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <nav class="navbar navbar-expand-lg nbar">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li>
                                            <li class="{{Request::path()=='product-grids'||Request::path()=='product-lists' ? 'active' : ''}}">
                                                <a href="{{route('product-grids')}}">Products</a>
                                            </li>
                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>
                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
