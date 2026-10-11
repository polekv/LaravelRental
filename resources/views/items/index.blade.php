<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Rental Catalog</title>
    <style>
        /* Simple global styling enhancements */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #333; margin: 0; padding: 30px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        /* Interactive Table Components */
        table { width: 100%; border-collapse: collapse; margin-top: 25px; border-radius: 8px; overflow: hidden; }
        th { background-color: #495057; color: white; padding: 15px; text-align: left; font-weight: 600; }
        td { padding: 15px; border-bottom: 1px solid #e9ecef; background-color: #fff; transition: background-color 0.2s; vertical-align: top; }
        tr:hover td { background-color: #f8f9fa; } /* Highlights row on hover */
        
        /* Modern Button Transitions */
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 10px 18px; border-radius: 6px; font-weight: bold; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s ease; font-size: 14px; }
        .btn:hover { filter: brightness(0.9); transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }
        
        .badge-admin { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-staff { background: #e2f0fd; color: #004085; border: 1px solid #b8daff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-guest { background: #e2e3e5; color: #383d41; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f3f5; padding-bottom: 20px; margin-bottom: 25px;">
        <h1 style="margin: 0; color: #212529; font-size: 28px;">🔧 Equipment Rental Hub</h1>
        
        <div style="display: flex; align-items: center; gap: 15px;">
            @auth
                <span style="background: #e9ecef; padding: 8px 14px; border-radius: 6px; font-weight: bold; color: #495057; display: flex; align-items: center; gap: 8px;">
                    👤 {{ auth()->user()->name }} 
                    @if(auth()->user()->role === 'admin')
                        <span class="badge-admin">Admin</span>
                    @elseif(auth()->user()->role === 'staff')
                        <span class="badge-staff">Staff</span>
                    @endif
                </span>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-danger">🚪 Log Out</button>
                </form>
            @else
                <span class="badge-guest">Browsing as Guest</span>
                <a href="{{ route('login') }}" class="btn btn-primary">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-success">Register</a>
            @endauth
        </div>
    </div>
    
    <div style="display: flex; gap: 10px; margin-bottom: 25px;">
        @auth
            <a href="/my-rentals" class="btn btn-secondary">📋 View My Rentals</a>

            {{-- Display management links to users who are EITHER Admin or Staff --}}
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                <a href="/items/create" class="btn btn-success">+ Add New Item</a>
                <a href="/rentals" class="btn btn-primary">View Rental Logs</a>
            @endif

            {{-- Maintain restricted system access strictly for Admin only --}}
            @if(auth()->user()->role === 'admin')
                <a href="/users" class="btn btn-secondary" style="background:#6f42c1; color: white;">👥 Manage Users & Roles</a>
            @endif
        @else
            <div style="background-color: #e8f4fd; color: #1d6f8a; padding: 12px 20px; border-radius: 6px; width: 100%; font-style: italic; font-size: 14px;">
                💡 Welcome! You are viewing our active fleet inventory. Please log in or register an account to secure a live equipment order reservation.
            </div>
        @endauth
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 25px; border: 1px solid #c3e6cb; border-radius: 6px; font-weight: 500;">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 25px; border: 1px solid #f5c6cb; border-radius: 6px; font-weight: 500;">
            ❌ {{ session('error') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Equipment Name</th>
                <th>Rate / Day</th>
                <th>Availability Fleet Status</th>
                <th style="text-align: right; padding-right: 25px; width: 280px;">Available Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="color: #6c757d; font-weight: bold;">#{{ $item->id }}</td>
                    <td><strong style="color: #212529; font-size: 16px;">{{ $item->name }}</strong></td>
                    {{-- 🇮🇩 Updated output symbol from $ to Rupiah --}}
                    <td style="color: #28a745; font-weight: bold; font-size: 16px;">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</td>
                    <td>
                        @if($item->stock > 0)
                            <span style="color: #28a745; background: #e8f5e9; padding: 4px 10px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                🟢 {{ $item->stock }} available
                            </span>
                        @else
                            <span style="color: #dc3545; background: #ffebee; padding: 4px 10px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                                🔴 Out of Stock
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 12px; align-items: flex-end; padding-right: 10px;">
                            
                            {{-- Interactive Checkout Date Picker Segment --}}
                            @if($item->stock > 0)
                                <form action="/items/{{ $item->id }}/rent" method="POST" style="margin:0; background: #f8f9fa; padding: 12px; border-radius: 6px; border: 1px solid #e9ecef; width: 100%; box-sizing: border-box;">
                                    @csrf
                                    <div style="display: flex; gap: 10px; margin-bottom: 8px;">
                                        <div style="flex: 1;">
                                            <label style="font-size: 11px; font-weight: bold; color: #495057; display: block; margin-bottom: 3px;">START DATE</label>
                                            <input type="date" name="start_date" required value="{{ date('Y-m-d') }}" style="width: 100%; padding: 4px; font-size: 12px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;">
                                        </div>
                                        <div style="flex: 1;">
                                            <label style="font-size: 11px; font-weight: bold; color: #495057; display: block; margin-bottom: 3px;">END DATE</label>
                                            <input type="date" name="end_date" required value="{{ date('Y-m-d', strtotime('+3 days')) }}" style="width: 100%; padding: 4px; font-size: 12px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success" style="padding: 6px 12px; font-size: 13px; width: 100%;">⚡ Rent Equipment</button>
                                </form>
                            @endif

                            @auth
                                {{-- Allow both Admins and Staff to access Item modification tools --}}
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                                    <div style="display: flex; gap: 8px; width: 100%; justify-content: flex-end;">
                                        <a href="/items/{{ $item->id }}/edit" class="btn btn-primary" style="padding: 6px 12px; font-size: 13px; flex: 1; text-align: center;">Edit</a>
                                        <form action="/items/{{ $item->id }}/delete" method="POST" style="margin:0; flex: 1;" onsubmit="return confirm('Are you sure you want to delete this item completely?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 13px; width: 100%;">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>