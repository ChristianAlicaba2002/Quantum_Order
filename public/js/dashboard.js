// Show and auto-hide toast notifications
document.addEventListener('DOMContentLoaded', function() {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 5000);
    });
});

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
    
    // Image preview
    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('previewImage');
    
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
});

//Open modal Update Products
function EditProducts(id, productName, category, price, stock, description, image) {
    const modal = document.getElementById('editProductModal');
    document.getElementById('EditForm').action = `/updateProduct/${id}`;
    document.getElementById('EditProductId').value = id;
    document.getElementById('EditProductName').value = productName;
    document.getElementById('EditCategory').value = category;
    document.getElementById('EditPrice').value = price;
    document.getElementById('EditStock').value = stock;
    document.getElementById('EditDescription').value = description;
    document.getElementById('EditPreviewImage').src = '/images/' + image;

    modal.classList.add('show');
    
    // Image preview for edit form
    const editImageInput = document.getElementById('EditImage');
    const editPreviewImage = document.getElementById('EditPreviewImage');
    
    editImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                editPreviewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
}

// Close modal when clicking outside
document.getElementById('editProductModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.remove('show');
    }
});

//Filtered Products in navigation Bar
function filterProducts(category, event) {
    document.querySelectorAll('nav .filter-btn').forEach(btn => {
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

// Function to update the counter
function updateOrderCounter() {
    fetch('/api/pending-orders-count')
        .then(response => response.json())
        .then(data => {
            const counter = document.getElementById('orderCounter');
            if (data.count > 0) {
                counter.textContent = data.count;
                counter.classList.add('has-notifications');
            } else {
                counter.textContent = '';
                counter.classList.remove('has-notifications');
            }
        });
}

// Update counter on page load
document.addEventListener('DOMContentLoaded', function() {
    updateOrderCounter();
});

// Set up real-time updates
const pusher = new Pusher('your-pusher-key', {
    cluster: 'ap1'
});

const channel = pusher.subscribe('orders');
channel.bind('new-order', function(data) {
    updateOrderCounter();
    // Optional: Show notification
    if (Notification.permission === "granted") {
        new Notification("New Order!", {
            body: "You have a new pending order.",
            icon: "/path/to/your/icon.png"
        });
    }
});