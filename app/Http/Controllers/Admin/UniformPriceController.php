<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\UniformPrice;
use Illuminate\Http\Request;
use App\Models\UniformPriceItem;
use App\Http\Controllers\Controller;

class UniformPriceController extends Controller
{
    public function index()
    {
        return view('admin.uniform_prices.index');
    }
    public function fetchUniforms()
    {
        return response()->json([
            'data' => UniformPrice::latest()->paginate(10),
        ]);
    }

    public function fetchUniformsPrice(UniformPrice $uniform)
    {
        return response()->json([
            'data' => $uniform->items()->latest()->paginate(10),
        ]);
    }
    public function storeUniform(Request $request)
    {
        return $this->storeUpdateUniform($request, new UniformPrice());
    }
    public function storeUniformPriceList(Request $request, UniformPrice $uniform)
    {
        return $this->storeUpdateUniformPriceList($request, $uniform, new UniformPriceItem());
    }
    public function editUniform(UniformPrice $uniform)
    {
        return response()->json([
            'data' => $uniform,
        ]);
    }
    public function editUniformPriceList(UniformPriceItem $uniformPriceItem)
    {
        return response()->json([
            'data' => $uniformPriceItem,
        ]);
    }
    public function updateUniform(Request $request, UniformPrice $uniform)
    {
        return $this->storeUpdateUniform($request, $uniform);
    }
    public function updateUniformPriceList(Request $request, UniformPrice $uniform, UniformPriceItem $uniformPriceItem)
    {
        return $this->storeUpdateUniformPriceList(
            $request,
            $uniform,
            $uniformPriceItem
        );
    }

    public function destroyUniform(UniformPrice $uniform)
    {
        return $uniform->delete();
    }
    public function destroyUniformPriceList(UniformPriceItem $uniformPriceItem)
    {
        return $uniformPriceItem->delete();
    }

    private function storeUpdateUniform(Request $request, UniformPrice $uniform): void
    {
        $request->validate([
            'name' => 'required|unique:uniform_prices,name,' . ($uniform->id ?? 'NULL'),
        ]);

        $uniform->name = $request->name;
        $uniform->save();
    }
    private function storeUpdateUniformPriceList(Request $request, UniformPrice $uniform, UniformPriceItem $uniformPriceItem): void
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $uniformPriceItem->uniform_price_id = $uniform->id;
        $uniformPriceItem->name = $request->name;
        $uniformPriceItem->price = $request->price;
        $uniformPriceItem->value = Str::lower($request->name);
        $uniformPriceItem->save();
    }
}
