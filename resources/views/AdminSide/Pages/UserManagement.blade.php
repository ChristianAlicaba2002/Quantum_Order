<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/user-management.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>User Management</title>
</head>


<body>
    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>

        <div class="table-container">
            <div class="table-header">
                <h1>User Management</h1>
                <div class="downloads">
                    <button type="submit" class="export-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="12" y1="18" x2="12" y2="12"/>
                            <line x1="9" y1="15" x2="15" y2="15"/>
                        </svg>
                        Export to Excel
                    </button>
                    <button type="submit" class="export-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                        Export to PDF
                    </button>
                </div>
            </div>

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
                        <td colspan="7">No users found</td>
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

            <div class="table-footer">
                <span>Total Users: {{ count($users) }}</span>
                <span>Last Updated: {{ now()->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
</body>
</html>