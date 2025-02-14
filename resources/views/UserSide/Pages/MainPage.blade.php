<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantum Order</title>
</head>

<body>
    {{-- @section('MainPage') --}}
    <h1>Quantum Order</h1>
    <form action="/logout" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
    {{-- @endsection --}}

</body>

</html>
