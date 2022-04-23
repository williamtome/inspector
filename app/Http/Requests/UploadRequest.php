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
            'csv' => 'required|file|mimes:csv|max:128',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->invalidCsv()) {
            return redirect()->back()
                ->with('error', 'Por favor adicione um arquivo CSV que não esteja vazio!');
        }
    }

    private function invalidCsv(): bool
    {
        return !$this->hasFile('csv')
            && !empty($this->file('csv'))
            && !$this->file('csv')->isValid();
    }
}
