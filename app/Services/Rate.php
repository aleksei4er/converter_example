<?php

namespace App\Services;

use App\Conversion;
use App\Http\Resources\Api\ConversionResource;
use App\Http\Resources\Api\RateCollection;
use Illuminate\Support\Facades\Http;
use App\Rate as RateModel;
use Spatie\QueryBuilder\QueryBuilder;
use Cartalyst\Converter\Laravel\Facades\Converter;
use Illuminate\Support\Str;

class Rate
{
    public function getItems(array $filters = [])
    {
        $items = QueryBuilder::for(RateModel::class)
            ->allowedFilters('currency')
            ->defaultSort('value')
            ->allowedSorts('value')
            ->get()->keyBy('currency');
        return RateCollection::make($items);
    }

    public function syncItems()
    {
        foreach ($this->parseItems() as $code => $item) {
            RateModel::updateOrCreate(['currency' => $code], ['currency' => $code, 'value' => $item['sell']]);
        }
    }

    public function parseItems()
    {
        $items = Http::get('https://blockchain.info/ticker')->json();
        return is_array($items) ? $items : [];
    }

    public function convert($params)
    {
        $items = $this->parseItems();

        $fiatCode = $params['currency_from'] == 'BTC' ? $params['currency_to'] : $params['currency_from'];

        $this->setupConverter($items[$fiatCode]['sell'], $fiatCode);

        $amountWithFee = $this->getConvertedValue($params, $fiatCode);

        $conversion = Conversion::create([
            'currency_from' => $params['currency_from'],
            'currency_to' => $params['currency_to'],
            'value' => $params['value'],
            'converted_value' => $amountWithFee,
            'rate' => $items[$fiatCode]['sell'],
        ]);

        return ConversionResource::make($conversion);
    }

    private function getConvertedValue($params, $fiatCode)
    {
        if ($params['currency_from'] == 'BTC') {
            $amount = Converter::from('currency.btc')->to('currency.fiat')->convert($params['value'])->getValue();
            $amountWithFee = Converter::from('currency.btc_with_fee')->to('currency.fiat')->convert($params['value'])->getValue();
        } else {
            $amount = Converter::from('currency.fiat')->to('currency.btc')->convert($params['value'])->getValue();
            $amountWithFee = Converter::from('currency.' . $fiatCode . '_with_fee')->to('currency.btc')->convert($params['value'])->getValue();
        }

        return $amountWithFee;
    }

    public function setupConverter($rate, $fiatCode)
    {
        Converter::setMeasurements(array(
            'currency' => array(
                'btc' => array(
                    'format' => 'B1,0.00000000',
                    'unit'   => '1.00',
                ),
                'btc_with_fee' => array(
                    'format' => 'B1,0.00000000',
                    'unit'   => '1.02',
                ),
                'fiat' => array(
                    'format' => '($1,0.00)',
                    'unit'   => $rate,
                ),
                $fiatCode . '_with_fee' => array(
                    'format' => '($1,0.00)',
                    'unit'   => $rate + $rate/100*2,
                ),
            ),
        ));
    }
}
