<?php

namespace Prasanna\WeightBasedShipping\Carriers;

use Webkul\Shipping\Carriers\AbstractShipping;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartShippingRate;
use Illuminate\Support\Facades\Log;

class WeightBased extends AbstractShipping
{
    /**
     * Shipping method carrier code.
     *
     * @var string
     */
    protected $code = 'weight_based';

    /**
     * Shipping method code.
     *
     * @var string
     */
    protected $method = 'weight_based';

    /**
     * Calculate rate for weight based shipping.
     *
     * @return \Webkul\Checkout\Models\CartShippingRate|false
     */
    public function calculate()
    {
        if (! $this->isAvailable()) {
            return false;
        }

        $cart = Cart::getCart();

        $totalWeight = 0;
        foreach ($cart->items as $item) {
            if ($item->product->getTypeInstance()->isStockable()) {
                $totalWeight += $item->weight * $item->quantity;
            }
        }

        Log::info('WeightBasedShipping: Total Weight: ' . $totalWeight);

        $rates = $this->getRates();

        Log::info('WeightBasedShipping: Configured Rates: ' . json_encode($rates));

        $shippingRate = 0;
        foreach ($rates as $rate) {
            if ($totalWeight >= $rate['weight']) {
                $shippingRate = $rate['price'];
            }
        }

        if ($shippingRate > 0) {
            Log::info('WeightBasedShipping: Calculated Shipping Rate: ' . $shippingRate);
            return $this->getRate($shippingRate);
        }

        Log::info('WeightBasedShipping: No valid shipping rate found. Returning false.');
        return false;
    }

    /**
     * Get rate.
     *
     * @param float $shippingRate
     * @return CartShippingRate
     */
    public function getRate($shippingRate)
    {
        $cartShippingRate = new CartShippingRate;

        $cartShippingRate->carrier = $this->getCode();
        $cartShippingRate->carrier_title = $this->getConfigData('title');
        $cartShippingRate->method = $this->getMethod();
        $cartShippingRate->method_title = $this->getConfigData('title');
        $cartShippingRate->method_description = $this->getConfigData('description');
        $cartShippingRate->price = core()->convertPrice($shippingRate);
        $cartShippingRate->base_price = $shippingRate;

        return $cartShippingRate;
    }

    /**
     * Get rates from config.
     *
     * @return array
     */
    public function getRates()
    {
        $rates = [];

        $configRates = $this->getConfigData('rates');

        if ($configRates) {
            $rateStrings = explode(',', $configRates);

            foreach ($rateStrings as $rateString) {
                $rateParts = explode(':', $rateString);

                if (count($rateParts) == 2) {
                    $rates[] = [
                        'weight' => (float)$rateParts[0],
                        'price'  => (float)$rateParts[1],
                    ];
                }
            }
        }

        // Sort rates by weight in ascending order
        usort($rates, function ($a, $b) {
            return $a['weight'] <=> $b['weight'];
        });

        return $rates;
    }
}