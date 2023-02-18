<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendOrderRequest extends FormRequest
{

    /**
     * Остановить валидацию после первой неуспешной проверки.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Получить пользовательские имена атрибутов для формирования ошибок валидатора.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'Адрес e-mail',
            'phone' => 'Сотовый телефон',
            'name' => 'Имя',
        ];
    }
    
    /**
     * Получить сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.required' => 'Укажите свой соторвый',
            'phone.min' => 'Укажите свой сотовый',
            // 'body.required' => 'A message is required',
        ];
    }

    // /**
    //  * Подготовить данные для валидации.
    //  *
    //  * @return void
    //  */
    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'phoneNumeric' => preg_replace("[^0-9]", '', $this->phone)
    //     ]);
    // }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // // echo '123';
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     // 'phone' => 'required',
        //     // 'games' => 'required|numeric',
        // ]);

        // $validator->sometimes(['phone'], 'required', function ($input) {
        //     // return $input->phone == 22;
        //     return false;
        // });

        return [
            'name' => 'required',
            'city' => 'required',
            'email' => 'required|email',
            // 'phone' => 'required|numeric|min:9|max:11',
            'phone' => 'required|min:9',
        ];
    }
}
