<!DOCTYPE html>
<html>
<head>
    <title>Edit Equipment</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h1>Edit Item</h1>

    <form action="/items/{{ $item->id }}/update" method="POST">
        @csrf 
        
        <p>
            <label>Item Name:</label><br>
            <input type="text" name="name" value="{{ $item->name }}" required>
        </p>

        <p>
            <label>Category ID:</label><br>
            <input type="number" name="category_id" value="{{ $item->category_id }}" required>
        </p>

        <p>
            <label>Price Per Day (Rp):</label><br>
            <input type="number" name="price_per_day" step="1" value="{{ number_format($item->price_per_day, 0, '', '') }}" required>
        </p>

        <p>
            <label>Stock Available:</label><br>
            <input type="number" name="stock" value="{{ $item->stock }}" required>
        </p>

        <div style="margin-top: 20px; display: flex; gap: 12px; align-items: center;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 18px; font-weight: bold; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer;">
                Update Item
            </button>

            <a href="/items" style="text-decoration: none; color: #6c757d; background-color: #e9ecef; padding: 10px 18px; font-weight: bold; border-radius: 6px; font-size: 14px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; transition: background-color 0.2s;" 
               onmouseover="this.style.backgroundColor='#dee2e6'" 
               onmouseout="this.style.backgroundColor='#e9ecef'">
                ← Cancel & Go Back
            </a>
        </div>
    </form>

</body>
</html>