<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quantum Order</title>
</head>

<body>
    @section('Dashboard')
        <h1>Dashboard</h1>
        <p>Welcome to the admin dashboard</p>

        <form action="{{ route('auth.adminlogout') }}" method="post">
            @csrf
            <button type="submit">Logout</button>
        </form>

        <div class="container downloads">
            <button type="submit">Export to Excel</button>
            <button type="submit">Export to PDF</button>
        </div>



        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Username</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
            @if (count($users) == 0)
                <tr>
                    <td colspan="9">No users found</td>
                </tr>
            @endif
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->firstName }}</td>
                    <td>{{ $user->lastName }}</td>
                    <td>{{ $user->gender }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->contactNumber }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        <button type="submit">Edit</button>
                        <form action="" method="post">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endsection
</body>

</html>
