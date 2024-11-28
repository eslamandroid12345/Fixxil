<?php

namespace App\Http\Services\Api\V1\App\Negotiates\Helper;

use App\Http\Enums\OrderNegotiateStatus;
use App\Repository\UnitRepositoryInterface;

class OfferPriceHelperService
{
    const TOTAL = 'total';
    const UNIT = 'unit';
    const CHECKED = 1;


    public function __construct(
        private readonly UnitRepositoryInterface $unitRepository
    )
    {

    }

    public function getOfferPriceMessage($order, $data)
    {
        return match ($data['price_type']) {
            self::TOTAL => $this->getTotalPriceMessage($order, $data['price']),
            self::UNIT => $data['num_units_known'] == self::CHECKED ?
                $this->getUnitPriceWithUnitNumMessage($order, $data['price'], $data['unit_id'], $data['num_units']) :
                $this->getUnitPriceMessage($order, $data['price'], $data['unit_id']),
        };
    }

    private function getTotalPriceMessage($order, $price)
    {
        $this->updateOrder($order, $price);
        return "سعر الخدمة $price جنيه";
    }

    private function getUnitPriceWithUnitNumMessage($order, $price, $unit_id, $num_units)
    {
        $this->updateOrder($order, $price, $unit_id);
        $unit_name = $this->getUnitName($unit_id);
        $total = $num_units * $price;
        return "سعر الخدمة بال$unit_name سعر ال$unit_name $price جنيه عدد الوحدات $num_units الاجمالي $total جنيه";
    }

    private function getUnitPriceMessage($order, $price, $unit_id)
    {
        $this->updateOrder($order, $price, $unit_id);
        $unit_name = $this->getUnitName($unit_id);
        return "سعر الخدمة بال$unit_name سعر ال$unit_name $price جنيه";
    }

    private function getUnitName($unit_id)
    {
        return $this->unitRepository->getById($unit_id, ['name_ar'])->name_ar;
    }

    private function updateOrder(&$order, $price, $unit_id = null)
    {
        $data = [
            'price' => $price,
            'negotiate_status' => OrderNegotiateStatus::PRICED->value,
        ];
        if (!is_null($unit_id))
            $data['unit_id'] = $unit_id;
        $order->update($data);
    }

}
