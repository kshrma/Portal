<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Quote;
use App\Models\Todo;
use Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Environment;
use App\Models\Project;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $members = Member::all();
        return view('admin.dashboard', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|integer|in:0,1',
            'environments' => 'nullable|array',
            'environments.*' => 'string',
        ]);

        $member = new Member();
        $member->username = $request->username;
        $member->password = bcrypt($request->password);
        $member->role = $request->role;
        $member->environments = $request->environments;
        $member->save();

        User::create([
            'name' => $request->username,
            'email' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function edit(Member $member)
    {
        return view('edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validatedData = $request->validate([
            'environments' => 'required|array',
            'environments.*' => 'string',
        ]);

        $member->update(['environments' => $validatedData['environments']]);

        return redirect()->back()->with('success', 'Member environments updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->back()->with('success', 'Member deleted successfully.');
    }
    public function dashboard()
{
    // Get the logged-in user
    $user = auth()->user();
    $projects = Project::all();

    // Fetch environments for the user
    $environments = Member::where('username', $user->name)->value('environments');

    return view('dashboard', ['environments' => $environments , 'projects' => $projects]);
}



public function fetchProducts()
{
    $response = Http::get('https://dummyjson.com/products');
    $products = $response->json()['products'];

    foreach ($products as $product) {
        Product::updateOrCreate(
            ['id' => $product['id']],
            [
                'title' => $product['title'],
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock']
            ]
        );
    }

    return response()->json(['message' => 'Products fetched successfully']);
}

public function index()
{
    // Fetch all products from the database
    $products = Product::all();

    // Pass products data to the view
    return view('index_product', compact('products'));
}
public function fetchCarts()
{
    $response = Http::get('https://dummyjson.com/carts');
    $carts = $response->json()['carts'];

    foreach ($carts as $cart) {
        Cart::updateOrCreate(
            ['id' => $cart['id']],
            [
                'products' => json_encode($cart['products']),
                'total' => $cart['total'],
                'discountedTotal' => $cart['discountedTotal']
            ]
        );
    }

    return response()->json(['message' => 'Carts fetched successfully']);
}

public function indexcart()
{
    $carts = Cart::all();
    return view('index_cart', compact('carts'));
}

    public function fetchTodos()
    {
        $response = Http::get('https://dummyjson.com/todos');
        $todos = $response->json()['todos'];

        foreach ($todos as $todo) {
            Todo::updateOrCreate(
                ['id' => $todo['id']],
                [
                    'todo' => $todo['todo'],
                    'completed' => $todo['completed']
                ]
            );
        }

        return response()->json(['message' => 'Todos fetched successfully']);
    }

    public function indextodo()
    {
        $todos = Todo::all();
        return view('index_todo', compact('todos'));
    }
    public function fetchQuotes()
{
    $response = Http::get('https://dummyjson.com/quotes');
    $quotes = $response->json()['quotes'];

    foreach ($quotes as $quote) {
        Quote::updateOrCreate(
            ['id' => $quote['id']],
            [
                'quote' => $quote['quote'],
                'author' => $quote['author']
            ]
        );
    }

    return response()->json(['message' => 'Quotes fetched and saved successfully']);
}

public function indexquote()
{
    $quotes = Quote::all();
    return view('index_quote', compact('quotes'));
}

public function show($environment)
{
    if ($environment === 'QC') {
        $products = Product::all();
        return view('index_product', compact('products'));
    } elseif ($environment === 'Dev') {
        $carts = Cart::all();
        return view('index_cart', compact('carts'));
    }
    elseif ($environment === 'UAT'){
        $todos = Todo::all();
        return view('index_todo', compact('todos'));
    }
    elseif ($environment === 'Production'){
        $quotes = Quote::all();
        return view('index_quote', compact('quotes'));
    }
    else {
        return response()->json(['message' => 'Invalid environment'], 400);
    }
}


}



