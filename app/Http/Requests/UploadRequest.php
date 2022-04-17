<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'csv' => 'required|file|mimes:csv',
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->hasFile('csv') && !$this->file('csv')->isValid()) {
            return redirect('/home')
                ->with('error', 'Por favor adicione um arquivo CSV que não esteja vazio!');
        }
    }

    public function messages(): array
    {
        return [
            'csv.required' => 'Adicione um arquivo do tipo CSV para importação!',
        ];
    }
}
