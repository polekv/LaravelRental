<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User & Role Master Management</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #333; margin: 0; padding: 30px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { background: #495057; color: white; font-weight: 600; }
        tr:hover td { background-color: #f8f9fa; }
        
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 14px; border-radius: 6px; font-weight: bold; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s ease; font-size: 13px; }
        .btn:hover { filter: brightness(0.9); }
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        
        .form-input { padding: 8px 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 14px; width: 100%; box-sizing: border-box; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f3f5; padding-bottom: 15px; margin-bottom: 25px;">
        <h2 style="margin:0; color: #212529;">👥 User & Role Master Management (CRUD)</h2>
        <a href="{{ url('/items') }}" class="btn btn-secondary">← Back to Catalog</a>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 12px; margin-bottom: 20px; border-radius: 6px; font-weight: 500;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <h3 style="color: #495057; margin-bottom: 10px;">+ Add New System Account</h3>
    <form action="{{ url('/users/store') }}" method="POST" style="display: grid; grid-template-columns: repeat(4, 1fr) auto; gap: 10px; background: #e9ecef; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
        @csrf
        <input type="text" name="name" class="form-input" placeholder="Full Name" required>
        <input type="email" name="email" class="form-input" placeholder="Email Address" required>
        <input type="password" name="password" class="form-input" placeholder="Password (min 6)" required>
        <select name="role" class="form-input" style="height:37px;" required>
            <option value="customer">Customer</option>
            <option value="staff">Staff</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" class="btn btn-success">Save User</button>
    </form>

    <h3 style="color: #495057; margin-bottom: 10px;">Registered Accounts Registry</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 60px;">ID</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>Current Role</th>
                <th style="width: 180px;">Modify Role Assignment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td style="font-weight: bold; color: #6c757d;">#{{ $u->id }}</td>
                    <td><strong>{{ $u->name }}</strong></td>
                    <td style="color: #495057;">{{ $u->email }}</td>
                    <td>
                        @if($u->role === 'admin')
                            <span class="badge" style="background: #fff3cd; color: #856404; border: 1px solid #ffeeba;">ADMIN</span>
                        @elseif($u->role === 'staff')
                            <span class="badge" style="background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb;">STAFF</span>
                        @else
                            <span class="badge" style="background: #e2e3e5; color: #383d41;">CUSTOMER</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ url('/users/'.$u->id.'/role') }}" method="POST" style="margin:0; display:flex; gap:6px;">
                            @csrf
                            <select name="role" style="padding: 4px; border-radius: 4px; border: 1px solid #ccc; font-size: 13px;">
                                <option value="customer" {{ $u->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="staff" {{ $u->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" style="padding: 4px 8px; font-weight: bold; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size:12px;">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>