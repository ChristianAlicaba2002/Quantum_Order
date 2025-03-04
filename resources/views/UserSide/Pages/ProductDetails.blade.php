<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Auth::user()->firstName}}</title>
</head>
<body>
    <div>
        <div>
            <a href="{{route('MainPage')}}" class="back-link">Back to Products</a>
        </div>
        
        <h1>Product Details</h1>
        <div>
            <h1>{{$productId}}</h1>
            <h1>{{$productName}}</h1>
            <h1>{{$category}}</h1>
            <h1>{{$price}}</h1>
            <h1>{{$stock}}</h1>
            <h1>{{$description}}</h1>
            <img src="{{ asset('/images/' . $image) }}" alt="{{ $productName }}">
        </div>
    </div>
        
   
</body>
</html>