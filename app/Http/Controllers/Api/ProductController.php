<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Api\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search', false);
        $perPage = request('per_page', 10);
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');
        $query = Product::query();
        $query->orderBy($sortField, $sortDirection);
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
        }

        return ProductListResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $attributes = $request->validated();
        $attributes['created_by'] = $request->user()->id;
        $attributes['updated_by'] = $request->user()->id;

        /** @var UploadedFile $image */
        $image = $request->image ?? null;
        if ($image) {
            $relativePath = $this->saveImage($image);
            $attributes['image'] = URL::to(Storage::url($relativePath));
        }

        $product = Product::create($attributes);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $attributes = $request->validated();
        $attributes['updated_by'] = $request->user()->id;

        /** @var UploadedFile $image */
        $image = $request->image ?? null;
        if ($image) {
            $relativePath = $this->saveImage($image);
            $attributes['image'] = URL::to(Storage::url($relativePath));

            if ($product->image) {
                Storage::delete('public/'.dirname($product->image));
            }
        }

        $product->update($attributes);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }

    private function saveImage(UploadedFile $image): string
    {
        $relativePath = "images/{$image->hashName()}";
        Storage::putFileAs('public', $image, $relativePath);

        return $relativePath;
    }
}
