<?php

namespace App\Http\Requests;

use App\Models\Brand;
use App\Models\CouponCode;
use App\Models\ProductSkus;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array
  {
    return [
      'info' => [
        'required',
      ],
      'price' => ['required', 'min:0'],
      'sale' => ['required', 'min:0'],
      'info.country.id' => ['required', 'exists:countries,id'],
      'info.city.id' => ['required', 'exists:cities,id'],
      'info.phone' => ['required'],
      'info.email' => ['required', 'email:rfc'],
      'info.name' => ['required', 'string'],
      'info.address' => ['required', 'string'],
      'info.post_code' => ['required', 'string'],
      'code' => [
        function ($attribute, $value, $fail) {
          if($value !== null && $value !== '') {
            if (!$code = CouponCode::firstWhere('code', $value)) {
              return $fail('Данного промокода несуществует');
            }
          }
        }
      ],
      'method_pay' => ['required',
        function ($attribute, $value, $fail) {
          if ($value !== 'cash' && $value !== 'cloudPayment') {
            return $fail('Выбаран несуществующий метод оплаты');
          }
        }
      ],
      'transfer.name' => ['required',
        function ($attribute, $value, $fail) {
          if ($value !== 'pickup' && $value !== 'ems') {
            return $fail('Выбаран несуществующий метод доставки');
          }
        }
      ],
      'items' => ['required', 'array'],
      'items.*.item.id' => [
        'required',
        function ($attribute, $value, $fail) {
          if (!$sku = ProductSkus::find($value)) {
            return $fail('Одного из размеров нет в наличии');
          }
          if ($sku->product->trashed()) {
            return $fail('Один из товаров недоступен к продаже');
          }
          if ($sku->stock === 0) {
            return $fail('Один из товаров распродан');
          }
          preg_match('/items\.(\d+)\.item.id/', $attribute, $m);
          $index = $m[1];
          // Найти количество покупок, представленных пользователем на основе индекса
          $amount = $this->input('items')[$index]['item']['amount'];
          if ($amount > 0 && $amount > $sku->stock) {
            return $fail('На скаде нет доступного колличества');
          }
        },
      ],
      'items.*.item.amount' => ['required', 'integer', 'min:1'],
    ];
  }
}
