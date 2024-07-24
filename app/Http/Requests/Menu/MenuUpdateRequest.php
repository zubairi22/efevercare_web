<?php

namespace App\Http\Requests\Menu;

use App\Rules\ValidRoute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50', Rule::unique('menus')->ignore($this->route('menu')->id)],
            'url' => ['required', 'max:50', Rule::unique('menus')->ignore($this->route('menu')->id), new ValidRoute()],
            'icon' => ['required'],
            'parent_id' => [''],
            'sort' => [''],
            'permissions' => ['']
        ];
    }
}
