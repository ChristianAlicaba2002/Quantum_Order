<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="/register" method="post">
        @csrf
        <input type="text" name="firstName" placeholder="Enter firstName"><br>
        <input type="text" name="lastName" placeholder="Enter lastName"><br>
        <input type="text" name="address" placeholder="Enter address"><br>
        <input type="tel" name="contactNumber" placeholder="Enter contactNumber"><br>
        <input type="text" name="username" placeholder="Enter username"><br>
        <input type="password" name="password" placeholder="Enter password"><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>
