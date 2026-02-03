<?php

namespace App\Http\Requests\StudioOwner;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\StudioOwner\PackagesModel;

class PackageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return PackagesModel::rules();
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return PackagesModel::messages();
    }

    protected function prepareForValidation()
    {
        // Convert Choices.js comma-separated inclusions to array
        if ($this->has('package_inclusions') && is_string($this->package_inclusions)) {
            $inclusions = array_map('trim', explode(',', $this->package_inclusions));
            $this->merge([
                'package_inclusions' => array_filter($inclusions)
            ]);
        }

        // Keep coverage scope as string (simple text field)
        if ($this->has('coverage_scope') && is_string($this->coverage_scope)) {
            $this->merge([
                'coverage_scope' => trim($this->coverage_scope)
            ]);
        }

        // Convert price to decimal
        if ($this->has('package_price')) {
            $this->merge([
                'package_price' => (float) str_replace(['PHP', ','], '', $this->package_price)
            ]);
        }
    }
}