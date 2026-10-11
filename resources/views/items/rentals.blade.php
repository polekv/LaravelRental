<!DOCTYPE html>
<html>
<head>
    <title>Rental Transaction Logs</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h1>Rental Transaction Logs</h1>
    
    <a href="/items" style="padding: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">← Back to Dashboard</a>
    <br><br>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="/rentals" method="GET" style="margin-bottom: 20px; background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #ddd; display: flex; gap: 10px; align-items: center;">
        <label for="status" style="font-weight: bold;">Filter by Status:</label>
        <select name="status" id="status" style="padding: 5px; border-radius: 3px;">
            <option value="">All Transactions</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="return_pending" {{ request('status') == 'return_pending' ? 'selected' : '' }}>Return Pending</option>
            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
        </select>
        <button type="submit" style="padding: 6px 15px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;">Apply Filter</button>
    </form>

    <table border="1" cellpadding="10" style="width:100%; text-align:left; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>User</th> 
                <th>Item Name (ID)</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Revenue</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
                <tr>
                    <td>{{ $rental->id }}</td>
                    
                    <td>
                        <strong>{{ \DB::table('users')->where('id', $rental->user_id)->value('name') ?? 'Unknown User' }}</strong> 
                        <br><span style="color: gray; font-size: 12px;">(ID: {{ $rental->user_id }})</span>
                    </td>

                    <td>
                        @if(\DB::table('items')->where('id', $rental->item_id)->exists())
                            <strong>{{ \DB::table('items')->where('id', $rental->item_id)->value('name') }}</strong> <br><span style="color: gray; font-size: 12px;">(ID: {{ $rental->item_id }})</span>
                        @else
                            <span style="color: gray; font-style: italic;">Deleted Item (ID: {{ $rental->item_id }})</span>
                        @endif
                    </td>
                    <td>{{ $rental->start_date }}</td>
                    <td>{{ $rental->end_date }}</td>
                    <td><strong>${{ number_format($rental->total_price, 2) }}</strong></td>
                    <td>
                        @if($rental->status === 'returned')
                            <span style="padding: 3px 8px; border-radius: 3px; color: white; font-weight: bold; background-color: #28a745;">Returned</span>
                        @elseif($rental->status === 'return_pending')
                            <span style="padding: 3px 8px; border-radius: 3px; color: #333; font-weight: bold; background-color: #e0e0e0; border: 1px dashed #6c757d;">Return Requested</span>
                        @else
                            <span style="padding: 3px 8px; border-radius: 3px; color: white; font-weight: bold; background-color: #ffc107;">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px; align-items: center;">
                            @if($rental->status === 'return_pending')
                                <form action="{{ url('/rentals/'.$rental->id.'/return') }}" method="POST" style="display:inline-block; margin:0;">
                                    @csrf
                                    <button type="submit" style="background-color: #28a745; color: white; padding: 5px 10px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 13px;">
                                        Approve Return ✓
                                    </button>
                                </form>
                            @elseif($rental->status === 'pending')
                                <form action="{{ url('/rentals/'.$rental->id.'/return') }}" method="POST" style="display:inline-block; margin:0;">
                                    @csrf
                                    <button type="submit" style="background-color: #ffc107; color: black; padding: 5px 10px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 13px;">
                                        Force Return
                                    </button>
                                </form>
                            @endif
                            <a href="{{ url('/rentals/'.$rental->id.'/edit') }}" style="background-color: #6c757d; color: white; text-decoration: none; padding: 5px 10px; border-radius: 3px; font-size: 13px; font-weight: normal; display: inline-block;">Admin Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>