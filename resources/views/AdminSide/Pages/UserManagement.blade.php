<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
</head>
<body>
    <a href="{{ route('AdminLogin') }}">Back to Dashboard</a>
    <div class="container downloads">
        <button type="submit">Export to Excel</button>
        <button type="submit">Export to PDF</button>
    </div>
    <h1>User Management</h1>
    <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Username</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>     
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
                        <td>{{ $user->PhoneNumber }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->created_at }}</td>

                    </tr>
                @endforeach
            </tbody>
           
        </table>

</body>
</html>