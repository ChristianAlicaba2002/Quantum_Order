<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quantum Order</title>
</head>

<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal.show {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-dialog {
        background: white;
        border-radius: 8px;
        width: 100%;
        max-width: 800px;
        margin: 20px;
    }

    .modal-content {
        position: relative;
    }

    .modal-header {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 1rem;
    }

    .modal-footer {
        padding: 1rem;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-close {
        border: none;
        background: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.375rem 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 1rem;
    }

    .btn {
        padding: 0.375rem 0.75rem;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
    }

    .btn-primary {
        background-color: #0d6efd;
        color: white;
        border: none;
    }

    #addProductModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    #addProductModal.show {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #addProductModal > div {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 400px; /* Smaller width */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    #addProductModal h5 {
        margin: 0 0 20px 0;
    }

    #addProductModal form div {
        margin-bottom: 15px;
    }

    #addProductModal label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    #addProductModal input,
    #addProductModal textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    #addProductModal button {
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #addProductModal button[type="submit"] {
        background-color: orange;
        color: white;
        float: right;
    }

    #addProductModal button[data-bs-dismiss="modal"] {
        background-color: #f1f1f1;
    }
    #productTable img{
        border-radius: 50%;
        border: 1px solid rgba(0, 0, 0, 0.122);
    }

</style>

<body>
    @section('Dashboard')
        <h1>Dashboard</h1>
        <p>Welcome to the admin Quantum Order dashboard</p>
        <button type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>

        <form action="{{ route('auth.adminlogout') }}" method="post">
            @csrf
            <button type="submit">Logout</button>
        </form>

        @include('AdminSide.Pages.Badges')
        @yield('BadgesContent')


        <div class="MenuHamburger">
           <ul>
            <li>
                <a href="{{route('ArchiveProducts')}}">Archive</a>
            </li>
            <li>
                <a href="">Orders</a>
            </li>
           </ul>
        </div>

        @if (session('failedToExport'))
            <script>alert("{{session('failedToExport')}}")</script>
        @endif


        <div class="container downloads">
            <a href="{{ route('UserManagement') }}">User Management</a>
            <button  onclick="window.location.href='{{ route('products.excel') }}'">
                Export to Excel
            </button>

            <button  onclick="window.location.href='{{ route('products.pdf') }}'">
                Export to PDF
            </button>

        </div>
        {{-- @php
            $products = DB::table('products')->get();
            $displayProducts = $products;
        @endphp --}}

            @if (!$products->isEmpty())
                <nav>
                    <ul class="d-flex justify-content-center gap-4 list-unstyled">
                        <li>
                            <button class="btn active" onclick="filterProducts('all', event)">
                                All
                            </button>
                        </li>
                        @php
                            $categories = $products->pluck('category')->unique();
                        @endphp
                        @foreach ($categories as $category)
                            <li>
                                <button class="btn" onclick="filterProducts('{{ $category }}',event)">
                                    {{ $category }}'s
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif


        <div>
            <h1 id="categoryTitle">All Products</h1>
            <table id="productTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Action</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach($products->sortBy('price') as $product)
                        <tr>
                            <td>{{ $product->productId }}</td>
                            <td>
                                <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>{{ $product->productName }}</td>
                            <td>{{ $product->category }}</td>
                            <td>&#8369;{{ number_format($product->price)}}</td>
                            <td style="color: {{$product->stock <= 20 ? 'red' : 'black' }}">{{$product->stock}}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->created_at}}</td>
                            <td>
                                <button type="submit" onclick="EditProducts('{{$product->id}}','{{$product->productName}}','{{$product->category}}','{{$product->price}}'
                                ,'{{$product->stock}}','{{$product->description}}','{{$product->image}}')">Edit</button>
                                <form action="/archive/{{$product->id}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" >Archive</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($products->isEmpty())
                <p>No products found</p>
            @endif



           
        </div>

        <!-- Add Product Modal -->
        <div id="addProductModal">
            <div>
                <div>
                    <div>
                        <h5>Add New Product</h5>
                       
                    </div>
                    <form action="{{ route('create.product') }}" method="POST" enctype="multipart/form-data">
                        <div>
                            @csrf
                            <div>
                                <label for="productName">Product Name</label>
                                <input type="text" id="productName" name="productName" required>
                            </div>
                            <div>
                                <label for="category">Category</label>
                                <input type="text" id="category" name="category" required>
                            </div>
                            <div>
                                <label for="price">Price</label>
                                <input type="number" id="price" name="price" step="0.01" required>
                            </div>
                            <div>
                                <label for="stock">Stock</label>
                                <input type="number" id="stock" name="stock" required>
                            </div>
                            <div>
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div>
                                <label for="image">Product Image</label>
                                <input type="file" id="image" name="image" accept="image/*" required>
                                <img id="previewImage" src="" alt="" srcset="">
                            </div>
                        </div>
                        <div>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                            <button type="submit">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @if (session('success'))
            <script>alert("{{session('success')}}")</script>
        @endif


        <div class="updateProductModal">
            <div>
                <div>
                    <div>
                        <h5>Update Product</h5>
                       
                    </div>
                  
                    <form id="EditForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <input type="hidden" id="ProductId" name="productId">
                            <div>
                                <label for="productName">Product Name</label>
                                <input type="text" id="EditProductName" name="productName" required>
                            </div>
                            <div>
                                <label for="category">Category</label>
                                <input type="text" id="EditCategory" name="category" readonly>
                            </div>
                            <div>
                                <label for="price">Price</label>
                                <input type="number" id="EditPrice" name="price" step="0.01" required>
                            </div>
                            <div>
                                <label for="stock">Stock</label>
                                <input type="number" id="EditStock" name="stock" required>
                            </div>
                            <div>
                                <label for="description">Description</label>
                                <textarea id="EditDescription" name="description" rows="3" required></textarea>
                            </div>
                            <div>
                                <label for="image">Image</label>
                                <input type="file" id="EditImage" name="image" accept="image/*">
                                <img id="previewImage" src="" alt="" srcset="">
                            </div>
                        </div>
                        <div>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

   

    <script>

        //Open modal for adding products
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('addProductModal');
            const openModalBtn = document.querySelector('[data-bs-target="#addProductModal"]');
            const closeModalBtn = document.querySelector('[data-bs-dismiss="modal"]');

            openModalBtn.addEventListener('click', function() {
                modal.classList.add('show');
            });

            closeModalBtn.addEventListener('click', function() {
                modal.classList.remove('show');
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('show');
                }
            });
        });

        //Open modal Update Products
        function EditProducts(id,productName,category,price,stock,description,image){
            document.getElementById('EditForm').action = `/updateProduct/${id}`;
            document.getElementById('ProductId').value = id;
            document.getElementById('EditProductName').value = productName;
            document.getElementById('EditCategory').value = category;
            document.getElementById('EditPrice').value = price;
            document.getElementById('EditStock').value = stock;
            document.getElementById('EditDescription').value = description;
            document.getElementById('EditImage').src = image;
        }

        //Filtered Products in navigation Bar
        function filterProducts(category, event) {
            document.querySelectorAll('nav .btn').forEach(btn => {
                btn.classList.remove('active');
            });

            event.target.classList.add('active');

            // Update the heading
            const categoryTitle = document.getElementById('categoryTitle');
            categoryTitle.textContent = category === 'all' ? 'All Products' : category;

            let table = document.getElementById('productTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let categoryCell = tr[i].getElementsByTagName('td')[3];
                if (categoryCell) {
                    let categoryValue = categoryCell.textContent || categoryCell.innerText;

                    if (category === 'all' || categoryValue.trim() === category) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

  




    </script>
</body>

</html>
