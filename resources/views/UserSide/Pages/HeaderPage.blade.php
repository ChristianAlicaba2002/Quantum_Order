<style>
.dropdown {
    position: relative;
    display: inline-block;
    text-align: left
}

.dropdown-trigger {
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 4px;
    padding: 8px 0;
}
.dropdown-content label{
    padding: 20px 0 20px 16px;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.icon-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 12px 16px;
    width: 100%;
    display: flex;
    align-items: center;
    text-align: left
}

.icon-button:hover {
    background-color: #f1f1f1;
}
.IsFound{
    color: red;
    font-weight: bold;
    margin-right: 10px;
    margin-left:40rem;
    margin-bottom: 10px;
    margin-top: 10rem;
    position: absolute;
    display: none;
}
.cartNumber{
   width: 20%;
}
.cartGroup{
    width: .79rem;
    height: .80rem;
    background-color: red;
    text-align: center;
    border-radius: 50%;
    padding: .15rem;
    font-size: smaller;
    position: relative;
    margin-top: -2.6rem;
    margin-left: 1.3rem;
}.cartGroup label{
    color: rgb(255, 255, 255);
    position: relative;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<header>
    <h1>Quantum Order</h1>
    <img style="width:2rem" src="./assets/house-door.svg" alt="" srcset="">
    <div>
        <div>
            <input type="search" placeholder="Search your item" onkeyup="searchProducts(this.value)">
        </div>
    </div>
    <div class="userinformation dropdown">
        <div class="dropdown-trigger">
            <img src="{{ asset('/images/' . Auth::user()->image)}}" 
            alt="{{ Auth::user()->firstName }}'s profile picture"
            style="width: 2.3rem; height: 2.3rem; object-fit: cover; border-radius: 50%;">
           
        </div>
        <div class="dropdown-content">
            <label>Hello! {{Auth::user()->firstName}}</label>
            <a href="{{route('UserInformationPage')}}">User Information</a>
            <a href="{{route('ToPayPage')}}">To pay</a>
            <a href="{{route('ReceivedPage')}}">Received</a>
            <a href="{{route('CancelledPage')}}">Cancelled</a>
            <form action="{{ route('auth.logout') }}" method="post">
                @csrf
                <button type="submit" class="icon-button">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="cartNumber">
    <img id="cartIcon" style="width:2rem" src="./assets/cart.svg" alt="" srcset="">
        <div class="cartGroup">
            <?php  
                $product = DB::table('add_to_cart')->where('userId',Auth::user()->userId)->get(); 
                $productCount = $product;
            ?>
        <label for="">{{$productCount->count()}}</label>
        </div>
       
    </div>
</header>



<script>
        function searchProducts(searchText) {
            const products = document.querySelectorAll('.products > div');
            const isfound = document.getElementById('isfound');
                searchproductsText = searchText.toLowerCase();

                products.forEach(product => {
                    const productName = product.querySelector('h1').textContent.toLowerCase();
                    
                    if (productName.includes(searchText)) {
                        product.style.display = '';
                        
                    } else {
                        product.style.display = 'none';
                    }
                });
        
        }

        document.getElementById('cartIcon').addEventListener('click', function() {
        const addToCartDivision = document.getElementById('AddToCartDivision');
        if (addToCartDivision) {
            if (addToCartDivision.style.display === 'none' || addToCartDivision.style.display === '') {
                addToCartDivision.style.display = 'block';
            } else {
                addToCartDivision.style.display = 'none';
            }
        }
    });
</script>