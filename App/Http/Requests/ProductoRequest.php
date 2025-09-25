<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->esEmpleadoOAdmin();
    }

    public function rules(): array
    {
        $productoId = $this->route('producto');
        
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio' => 'required|numeric|min:0.01|max:999999.99',
            'categoria' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'codigo_sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('productos')->ignore($productoId)
            ],
            'activo' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'precio.required' => 'El precio es obligatorio',
            'categoria.required' => 'La categoría es obligatoria',
            'stock.required' => 'El stock es obligatorio',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('stock_minimo') || is_null($this->stock_minimo)) {
            $this->merge(['stock_minimo' => 5]);
        }
    }
}