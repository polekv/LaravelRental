<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon; 

class ItemController extends Controller
{
    public function index()
    {
        $items = DB::table('items')->get();
        return view('items.index', ['items' => $items]);
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        DB::table('items')->insert([
            'category_id' => $request->category_id ?? 1,
            'name' => $request->name,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/items')->with('success', 'New item added successfully!');
    }

    public function edit($id)
    {
        $item = DB::table('items')->where('id', $id)->first();
        return view('items.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        DB::table('items')->where('id', $id)->update([
            'category_id' => $request->category_id ?? 1,
            'name' => $request->name,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'updated_at' => now()
        ]);

        return redirect('/items')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('items')->where('id', $id)->delete();
        return redirect('/items')->with('success', 'Item deleted completely!');
    }

    /**
     * 📅 DYNAMIC CHECKOUT WITH USER-SELECTED DATES
     */
    public function rent(Request $request, $id)
    {
        $item = DB::table('items')->where('id', $id)->first();

        if (!$item || $item->stock <= 0) {
            return redirect('/items')->with('error', 'Sorry, this item is out of stock!');
        }

        // Validate that user input valid dates
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        $days = $startDate->diffInDays($endDate);
        if ($days === 0) {
            $days = 1; // Minimum 1 day execution block
        }

        $totalPrice = $item->price_per_day * $days;

        // Deduct inventory stock
        DB::table('items')->where('id', $id)->update([
            'stock' => $item->stock - 1
        ]);

        // Save the transaction with explicit user chosen dates
        DB::table('rentals')->insert([
            'user_id' => Auth::id(), 
            'item_id' => $id, 
            'start_date' => $request->start_date, 
            'end_date' => $request->end_date,
            'total_price' => $totalPrice, 
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/items')->with('success', 'Successfully rented for ' . $days . ' days! Total: Rp ' . number_format($totalPrice, 0, ',', '.'));
    }

    public function rentals(Request $request)
    {
        $query = DB::table('rentals')
            ->join('items', 'rentals.item_id', '=', 'items.id')
            ->join('users', 'rentals.user_id', '=', 'users.id')
            ->select('rentals.*', 'items.name as item_name', 'users.name as user_name');

        if ($request->has('status') && $request->status != '') {
            $query->where('rentals.status', $request->status);
        }

        $rentals = $query->get();

        return view('items.rentals', ['rentals' => $rentals]);
    }

    public function editRental($id)
    {
        $rental = DB::table('rentals')->where('id', $id)->first();
        return view('items.edit_rental', ['rental' => $rental]);
    }

    public function updateRental(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|max:50'
        ]);

        DB::table('rentals')->where('id', $id)->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $request->total_price,
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return redirect('/rentals')->with('success', 'Transaction log successfully overridden by Admin!');
    }

    public function requestReturn($id)
    {
        $rental = DB::table('rentals')->where('id', $id)->where('user_id', Auth::id())->first();

        if ($rental && $rental->status === 'pending') {
            DB::table('rentals')->where('id', $id)->update([
                'status' => 'return_pending',
                'updated_at' => now()
            ]);

            return redirect('/my-rentals')->with('success', 'Return request submitted successfully!');
        }

        return redirect('/my-rentals')->with('error', 'Unable to submit return request.');
    }

    /**
     * 💰 STAFF/ADMIN APPROVAL WITH DYNAMIC REVENUE, REFUNDS & OVERDUE PENALTIES
     */
    public function returnItem($id)
    {
        $rental = DB::table('rentals')->where('id', $id)->first();

        if ($rental && ($rental->status === 'pending' || $rental->status === 'return_pending')) {
            
            $item = DB::table('items')->where('id', $rental->item_id)->first();
            $msg = 'Return request approved! Inventory stock updated.';

            if ($item) {
                $start = Carbon::parse($rental->start_date);
                $plannedEnd = Carbon::parse($rental->end_date);
                $today = Carbon::today();

                // 💸 SCENARIO 1: EARLY RETURN (Calculate Refund with 1-Day Minimum Charge Guardrail)
                if ($today->lt($plannedEnd)) {
                    $actualDaysUsed = $start->diffInDays($today);
                    if ($actualDaysUsed === 0) {
                        $actualDaysUsed = 1; // Prevents 0 revenue data if returned same-day!
                    }

                    $plannedDays = $start->diffInDays($plannedEnd);
                    if ($plannedDays === 0) $plannedDays = 1;

                    if ($actualDaysUsed < $plannedDays) {
                        $newPrice = $item->price_per_day * $actualDaysUsed;
                        $refundAmount = $rental->total_price - $newPrice;

                        if ($refundAmount > 0) {
                            DB::table('rentals')->where('id', $id)->update([
                                'end_date' => $today->toDateString(),
                                'total_price' => $newPrice
                            ]);
                            $msg = 'Early return approved! Customer was refunded: Rp ' . number_format($refundAmount, 0, ',', '.');
                        }
                    }
                }
                
                // ⚠️ SCENARIO 2: LATE RETURN (Apply Accumulative Overdue Fine Penalty)
                if ($today->gt($plannedEnd)) {
                    $daysLate = $plannedEnd->diffInDays($today);
                    
                    // Fines calculation: 150% of the regular daily rate for each late day
                    $lateFeePerDay = $item->price_per_day * 1.5; 
                    $totalPenalty = $daysLate * $lateFeePerDay;
                    $finalPrice = $rental->total_price + $totalPenalty;

                    DB::table('rentals')->where('id', $id)->update([
                        'end_date' => $today->toDateString(),
                        'total_price' => $finalPrice
                    ]);

                    $msg = 'Late return processed! Overdue for ' . $daysLate . ' day(s). Penalty charge of Rp ' . number_format($totalPenalty, 0, ',', '.') . ' added to total.';
                }
            }

            // Mark order as returned and put item back in stock
            DB::table('rentals')->where('id', $id)->update([
                'status' => 'returned',
                'updated_at' => now()
            ]);

            DB::table('items')->where('id', $rental->item_id)->increment('stock');

            return redirect('/rentals')->with('success', $msg);
        }

        return redirect('/rentals')->with('error', 'Something went wrong.');
    }

    public function myRentals()
    {
        $rentals = DB::table('rentals')
            ->join('items', 'rentals.item_id', '=', 'items.id')
            ->where('rentals.user_id', Auth::id())
            ->select('rentals.*', 'items.name as item_name')
            ->orderBy('rentals.created_at', 'desc')
            ->get();

        return view('items.my-rentals', compact('rentals'));
    }

    public function manageUsers()
    {
        $users = DB::table('users')->get();
        return view('items.users', ['users' => $users]);
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'is_admin' => $request->role === 'admin' ? 1 : 0, 
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'User added successfully!');
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string'
        ]);

        DB::table('users')->where('id', $id)->update([
            'role' => $request->role,
            'is_admin' => $request->role === 'admin' ? 1 : 0, 
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'User role adjusted successfully!');
    }
}