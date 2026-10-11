<!DOCTYPE html>
<html>
<head>
    <title>Add New Equipment</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h1>Add a New Item</h1>

    <form action="/items" method="POST">
        @csrf 

        <p>
            <label>Item Name:</label><br>
            <input type="text" name="name" required>
        </p>

        <p>
            <label>Category ID (Type 1 for Cameras, 2 for Tools):</label><br>
            <input type="number" name="category_id" required>
        </p>

        <p>
            <label>Price Per Day ($):</label><br>
            <input type="number" name="price_per_day" step="0.01" required>
        </p>

        <p>
            <label>Stock Available:</label><br>
            <input type="number" name="stock" required>
        </p>

        <button type="submit">Save Item</button>
    </form>

</body>
</html>