<!DOCTYPE html>
<html>
<head>
    <title>My Rental History</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h1>My Rental History</h1>
    <a href="/items" style="padding: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">← Back to Dashboard</a>
    <br><br>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    <table border="1" cellpadding="10" style="width:100%; text-align:left; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Rental ID</th>
                <th>Item Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rentals as $rental)
                <tr>
                    <td>{{ $rental->id }}</td>
                    <td><strong>{{ $rental->item_name }}</strong></td>
                    <td>{{ $rental->start_date }}</td>
                    <td>{{ $rental->end_date }}</td>
                    <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                    <td style="padding: 12px; border-bottom: 1px solid #eee;">
                        @if($rental->status === 'pending')
                            <span style="display: inline-block; background-color: #cff4fc; color: #055160; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; margin-bottom: 8px;">Active Rental</span>
                            
                            <form action="{{ url('/rentals/'.$rental->id.'/request-return') }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn" style="background-color: #ffc107; color: #000; font-weight: bold; padding: 5px 10px; border-radius: 4px; border:none; cursor:pointer; font-size: 11px;">
                                    Request Return
                                </button>
                            </form>
                        @elseif($rental->status === 'return_pending')
                            <span style="display: inline-block; background-color: #fff3cd; color: #664d03; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Awaiting Staff Approval</span>
                        @elseif($rental->status === 'returned')
                            <span style="display: inline-block; background-color: #d1e7dd; color: #0f5132; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">✓ Successfully Returned</span>
                        @else
                            <span style="display: inline-block; background-color: #e2e3e5; color: #41464b; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">{{ ucfirst($rental->status) }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    {{-- 🛠️ Patched from 6 to 7 to perfectly align with your table dimensions --}}
                    <td colspan="7" style="text-align: center; color: #6c757d;">You haven't rented any equipment yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>