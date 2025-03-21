<?php

namespace App\Http\Traits;

use App\Models\UniformPriceItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait PaymentTrait
{
  private $subtotal = 0;
  private $topPrice = 0;
  private $bottomPrice = 0;
  private $setPrice = 0;

  private $additionalPrice = 0;
  public function computeTotal(Request $request)
  {
    // Define items for each category
    $topItems = ['polo', 'blouse', 'vest', 'blazer'];
    $bottomItems = ['short', 'pants', 'skirt'];
    $setItems = ['set-1', 'set-2', 'set-3'];
    $additionalItems = [
      'additional_threads' => 'threads',
      'additional_zipper' => 'zipper',
      'additional_school_seal' => 'school-seal',
      'additional_buttons' => 'buttons',
      'additional_hook_eye' => 'hook and eye',
      'additional_tela' => 'tela'
    ];

    // Handle top items
    if ($request->set === 'custom' && in_array($request->top, $topItems)) {
      $price = $this->getPrice($request->top);
      $this->subtotal += $price;
      $this->topPrice += $price;
    }
   
    // Handle file top items
    if (in_array($request->file_top, $topItems)) {
      $price = $this->getPrice($request->file_top);
      $this->subtotal += $price;
      $this->topPrice += $price;
    }
    // Handle file bottom items
    if (in_array($request->file_bottom, $bottomItems)) {
      $price = $this->getPrice($request->file_bottom);
      $this->subtotal += $price;
      $this->bottomPrice += $price;
    }
   

    // Handle bottom items
    if ($request->set === 'custom' && in_array($request->bottom, $bottomItems)) {
      $price = $this->getPrice($request->bottom);
      $this->subtotal += $price;
      $this->bottomPrice += $price;
    }

    // Handle set items
    if (in_array($request->set, $setItems)) {
      $price = $this->getPrice($request->set);
      $this->subtotal += $price;
      $this->setPrice += $price;
    }

    // Handle additional items
    foreach ($additionalItems as $key => $item) {
      if ($request->$key) {
        $price = $this->getPrice($item);
        $total =  floatval($price) * floatval($request->$key);
        $this->subtotal += $total;
        $this->additionalPrice +=  $total;
      }
    }

    return [
      'top_price' => $this->topPrice,
      'bottom_price' => $this->bottomPrice,
      'set_price' => $this->setPrice,
      'additional_price' => $this->additionalPrice,
      'total' => $this->subtotal,
    ];
  }

  private function getPrice(string $value)
  {
    return UniformPriceItem::whereValue($value)->first()->price;
  }
}
