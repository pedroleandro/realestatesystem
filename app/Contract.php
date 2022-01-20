<?php

namespace LaraDev;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'sale',
        'rent',
        'owner',
        'owner_spouse',
        'owner_company',
        'acquirer',
        'acquirer_spouse',
        'acquirer_company',
        'property',
        'sale_price',
        'rent_price',
        'price',
        'tribute',
        'condominium',
        'due_date',
        'deadline',
        'start_at',
        'status'
    ];

    public function setSaleAttribute($value)
    {
        if ($value === true || $value === 'on') {
            $this->attributes['sale'] = 1;
            $this->attributes['rent'] = 0;
        }
    }

    public function setRentAttribute($value)
    {
        if ($value === true || $value === 'on') {
            $this->attributes['rent'] = 1;
            $this->attributes['sale'] = 0;
        }
    }

    public function setOwnerSpouseAttribute($value)
    {
        $this->attributes['owner_spouse'] = ($value === '1' ? 1 : 0);
    }

    public function setOwnerCompanyAttribute($value)
    {
        if ($value == '0') {
            $this->attributes['owner_company'] = null;
        } else {
            $this->attributes['owner_company'] = $value;
        }
    }

    public function setAcquirerSpouseAttribute($value)
    {
        $this->attributes['acquirer_spouse'] = ($value === '1' ? 1 : 0);
    }

    public function setAcquirerCompanyAttribute($value)
    {
        if ($value == '0') {
            $this->attributes['acquirer_company'] = null;
        } else {
            $this->attributes['acquirer_company'] = $value;
        }
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function setSalePriceAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['price'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function setRentPriceAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['price'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function getTributeAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function setTributeAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['tribute'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function getCondominiumAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function setCondominiumAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['condominium'] = floatval($this->convertStringToDouble($value));
        }
    }

    public function getStartAtAttribute($value)
    {
        return Date('d/m/Y', strtotime($value));
    }

    public function setStartAtAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['start_at'] = $this->convertStringToDate($value);
        }
    }

    private function convertStringToDouble(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        return floatval(str_replace(',', '.', str_replace('.', '', $param)));
    }

    public function convertStringToDate($param)
    {
        if (empty($param)) {
            return null;
        }

        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
}
