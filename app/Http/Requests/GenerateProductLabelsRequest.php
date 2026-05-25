<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class GenerateProductLabelsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return usercan('create-product-labels');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products' => ['required', 'array', 'min:1'],
            'products.*' => ['required', 'array'],
            'products.*.id' => ['required', 'numeric'],
            'products.*.name' => ['required', 'string'],
            'products.*.icon' => ['required', 'array'],
            'products.*.icon.url' => ['present', 'nullable', 'string'],
            'products.*.custom_fields' => ['required', 'array'],
            'products.*.custom_fields.colour_coded_storage' => ['present', 'nullable', 'string', Rule::in(['Yes', 'No'])],
            'products.*.custom_fields.nally_bin_storage' => ['present', 'nullable', 'string', Rule::in(['Yes', 'No'])],
            'products.*.custom_fields.nally_bin_storage_stored_at_height' => ['present', 'nullable', 'string', Rule::in(['Yes', 'No'])],
            'products.*.custom_fields.tub_storage' => ['present', 'nullable', 'string', Rule::in(['Yes', 'No'])],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            // Keep Laravel's default behavior when no rule violations are present.
            if ($validator->errors()->isEmpty()) {
                return;
            }

            // Return a dedicated message when the products array is present but empty.
            $products = $this->input('products');
            if (is_array($products) && $products === []) {
                throw ValidationException::withMessages([
                    'products' => __('Products must be added in order to generate labels. Please add one or more products.'),
                ]);
            }

            // Convert field-level failures into product names for a simpler user message.
            $product_names = $this->invalidProductNames($validator);

            if ($product_names === []) {
                $product_names = ['A product'];
            }

            $product_lines = array_map(
                fn(string $product_name): string => '<strong>' . e($product_name) . '</strong>',
                $product_names,
            );

            if (count($product_names) === 1) {
                $message = 'The following product:<br><br>'
                    . $product_lines[0]
                    . '<br><br>has errors and a label cannot be generated. Please verify its configuration directly in CurrentRMS.';
            } else {
                $message = 'The following products:<br><br>'
                    . implode('<br>', $product_lines)
                    . '<br><br>have errors and labels cannot be generated. Please verify their configuration directly in CurrentRMS.';
            }

            // Replace granular validation output with one product-focused message.
            throw ValidationException::withMessages([
                'products' => $message,
            ]);
        });
    }

    /**
     * @return array<int, string>
     */
    private function invalidProductNames(Validator $validator): array
    {
        $products = $this->input('products', []);
        $invalid_indexes = [];

        // Pull product indexes from failing keys such as products.0.name.
        foreach ($validator->errors()->keys() as $key) {
            if (preg_match('/^products\.(\d+)(?:\.|$)/', $key, $matches) === 1) {
                $invalid_indexes[] = (int) $matches[1];
            }
        }

        $invalid_indexes = array_values(array_unique($invalid_indexes));

        // If validation failed at the top level, treat all incoming products as invalid.
        if ($invalid_indexes === [] && is_array($products)) {
            $invalid_indexes = array_keys($products);
        }

        $names = [];

        foreach ($invalid_indexes as $index) {
            $name = is_array($products) ? Arr::get($products, $index . '.name') : null;
            $name = is_string($name) ? trim($name) : '';
            // Keep messages actionable even when a product name is missing.
            $names[] = $name !== '' ? $name : 'Product #' . ((int) $index + 1);
        }

        return array_values(array_unique($names));
    }
}
