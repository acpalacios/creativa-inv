<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
  public function index()
  {
    return Inertia::render('Products/Index', [
      'filters' => Request::all('search'),
      'products' => Auth::user()
        ->account->products()
        ->orderBy('name')
        ->filter(Request::only('search'))
        ->paginate()
        ->withQueryString()
        ->through(function ($product) {
          return [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $product->quantity,
            'description' => $product->description,
            'unit_cost' => $product->unit_cost,
            'total_cost' => $product->total_cost,
            'material' => $product->material,
            'unity' => $product->unity,
            'color' => $product->color,
            'classification' => $product->classification,
            'notes' => $product->notes,
            'contact' => $product->contact ? $product->contact->only('name') : null,
          ];
        }),
    ]);
  }

  public function create()
  {
    return Inertia::render('Products/Create', [
      'contacts' => Auth::user()
        ->account->contacts()
        ->get()
        ->map->only('id', 'name'),
    ]);
  }

  public function store()
  {
    Auth::user()
      ->account->products()
      ->create(
        Request::validate([
          'name' => ['required', 'max:25'],
          'contact_id' => ['nullable'],
          'quantity' => ['required'],
          'description' => ['nullable', 'max:50'],
          'classification' => ['nullable', 'max:50'],
          'material' => ['nullable', 'max:50'],
          'color' => ['nullable', 'max:50'],
          'unit_cost' => ['required'],
          'total_cost' => ['required'],
          'notes' => ['nullable', 'max:150'],
        ])
      );

    return Redirect::route('products')->with('success', 'Producto agregado.');
  }

  public function edit(Product $product)
  {
    return Inertia::render('Products/Edit', [
      'product' => [
        'id' => $product->id,
        'name' => $product->name,
        'quantity' => $product->quantity,
        'description' => $product->description,
        'contact_id' => $product->contact_id,
        'unit_cost' => $product->unit_cost,
        'total_cost' => $product->total_cost,
        'material' => $product->material,
        'unity' => $product->unity,
        'color' => $product->color,
        'classification' => $product->classification,
        'notes' => $product->notes,
      ],
      'contacts' => Auth::user()
        ->account->contacts()
        ->orderBy('name')
        ->get()
        ->map->only('id', 'name'),
    ]);
  }

  public function update(Product $product)
  {
    $product->update(
      Request::validate([
        'name' => ['required', 'max:25'],
        'contact_id' => ['nullable'],
        'quantity' => ['required'],
        'description' => ['nullable', 'max:50'],
        'classification' => ['nullable', 'max:50'],
        'material' => ['nullable', 'max:50'],
        'color' => ['nullable', 'max:50'],
        'unit_cost' => ['required'],
        'total_cost' => ['required'],
        'notes' => ['nullable', 'max:150'],
      ])
    );

    return Redirect::route('products')->with('success', 'Producto actualizado.');
  }

  public function destroy(Product $product)
  {
    $product->delete();

    return Redirect::route('products')->with('success', 'Producto eliminado.');
  }
}
