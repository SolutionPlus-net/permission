<?php

namespace Otas\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Otas\Permission\Models\Permission;
use Otas\Translatable\Rules\UniqueForLocale;

class PermissionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'min:3',
                'max:191',
                new UniqueForLocale(request()->permission, 'display_name'),
            ],
            'description' => 'nullable|string|max:10000',
        ];
    }

    public function getValidatorInstance()
    {
        request()->locale = request()->input('locale');
        request()->merge([
            'display_name' => $this->name ?? $this->permission->name,
            'description' => $this->description,
        ]);
        return parent::getValidatorInstance();
    }

    public function updatePermission(): Permission
    {
        $currentTranslationNamespace = config('translatable.translation_models_path');
        config(['translatable.translation_models_path' => 'Otas\Permission\Models']);
        request()->permission->update([]);
        config(['translatable.translation_models_path' => $currentTranslationNamespace]);

        return request()->permission->refresh();
    }

    public function attributes(): array
    {
        return [
            'name' => __('otas/permission/permissions.attributes.name'),
            'description' => __('otas/permission/permissions.attributes.description'),
        ];
    }
}
