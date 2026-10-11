<!DOCTYPE html>
<html>
<head>
    <title>Edit Rental Transaction</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h1>Edit Rental Log #{{ $rental->id }}</h1>
    <a href="/rentals" style="padding: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">← Back to Transaction Logs</a>
    <br><br>

    <div style="background: #f8f9fa; padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 500px;">
        <form action="/rentals/{{ $rental->id }}/update" method="POST">
            @csrf

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Start Date:</label>
                <input type="datetime-local" name="start_date" value="{{ date('Y-m-d\TH:i', strtotime($rental->start_date)) }}" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">End Date:</label>
                <input type="datetime-local" name="end_date" value="{{ date('Y-m-d\TH:i', strtotime($rental->end_date)) }}" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Total Price ($):</label>
                <input type="number" step="0.01" name="total_price" value="{{ $rental->total_price }}" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Transaction Status:</label>
                <select name="status" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;" required>
                    <option value="pending" {{ $rental->status == 'pending' ? 'selected' : '' }}>Pending (In Possession)</option>
                    <option value="returned" {{ $rental->status == 'returned' ? 'selected' : '' }}>Returned</option>
                </select>
            </div>

            <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
                💾 Save Record Changes
            </button>
        </form>
    </div>

</body>
</html>