<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;


use Illuminate\Foundation\Http\FormRequest;

class BusinessHoursRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }


    public function prepareForValidation()
    {
        $data = array_values($this->all()['data']);

        foreach ($data as $index =>$day){
            if (!isset($day['off'])){
                $data[$index]['off'] = false;
                continue;
            }
            $data[$index]['off'] = !!$data[$index]['off'];
        }
        $this->replace([
            'data'=>$data
        ]);
    }

   
    public function rules()
    {
        return [
            'data' =>['array','size:7'],
            'data.*.day' =>['required'],
            'data.*.form' =>['required','date_format:H:i:s'],
            'data.*.to' =>['required','date_format:H:i:s'],
            'data.*.step' =>['required','integer','min:1'],
            'data.*.off' =>['required','boolean'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        dd($validator->errors());
    }
}
