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

    public function ownerObject()
    {
        return $this->hasOne(User::class, 'id', 'owner');
    }

    public function acquirerObject()
    {
        return $this->hasOne(User::class, 'id', 'acquirer');
    }

    public function ownerCompanyObject()
    {
        return $this->hasOne(Company::class, 'id', 'owner_company');
    }

    public function acquirerCompanyObject()
    {
        return $this->hasOne(Company::class, 'id', 'acquirer_company');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending')->get();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->get();
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled')->get();
    }

    public function propertyObject()
    {
        return $this->hasOne(Property::class, 'id', 'property');
    }

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

    public function terms()
    {
        // Finalidade [Venda/Loca????o]
        if ($this->sale == true) {
            $parameters = [
                'purpouse' => 'VENDA',
                'part' => 'VENDEDOR',
                'part_opposite' => 'COMPRADOR',
            ];
        }

        if ($this->rent == true) {
            $parameters = [
                'purpouse' => 'LOCA????O',
                'part' => 'LOCADOR',
                'part_opposite' => 'LOCAT??RIO',
            ];
        }

        $terms[] = "<p style='text-align: center;'>{$this->id} - CONTRATO DE {$parameters['purpouse']} DE IM??VEL</p>";

        // OWNER
        if (!empty($this->owner_company)) { // Se tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. n?? {$this->ownerCompanyObject->document_company} e I. E. n?? {$this->ownerCompanyObject->document_company_secondary} exercendo suas atividades no endere??o {$this->ownerCompanyObject->street}, n?? {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyObject->neighborhood}, {$this->ownerCompanyObject->city}/{$this->ownerCompanyObject->state}, CEP {$this->ownerCompanyObject->zipcode} tendo como respons??vel legal {$this->ownerObject->name}, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->ownerObject->document}, e c??njuge {$this->ownerObject->spouse_name}, natural de {$this->ownerObject->spouse_place_of_birth}, {$this->ownerObject->spouse_occupation}, portador da c??dula de identidade R. G. n?? {$this->ownerObject->spouse_document_secondary} {$this->ownerObject->spouse_document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->ownerObject->spouse_document}, residentes e domiciliados ?? {$this->ownerObject->street}, n?? {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            } else { // E n??o tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. n?? {$this->ownerCompanyObject->document_company} e I. E. n?? {$this->ownerCompanyObject->document_company_secondary} exercendo suas atividades no endere??o {$this->ownerCompanyObject->street}, n?? {$this->ownerCompanyObject->number}, {$this->ownerCompanyObject->complement}, {$this->ownerCompanyObject->neighborhood}, {$this->ownerCompanyObject->city}/{$this->ownerCompanyObject->state}, CEP {$this->ownerCompanyObject->zipcode} tendo como respons??vel legal {$this->ownerObject->name}, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->ownerObject->document}, residente e domiciliado ?? {$this->ownerObject->street}, n?? {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            }

        } else { // Se n??o tem empresa

            if (!empty($this->owner_spouse)) { // E tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerObject->name}</b>, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->ownerObject->document}, e c??njuge {$this->ownerObject->spouse_name}, natural de {$this->ownerObject->spouse_place_of_birth}, {$this->ownerObject->spouse_occupation}, portador da c??dula de identidade R. G. n?? {$this->ownerObject->spouse_document_secondary} {$this->ownerObject->spouse_document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->ownerObject->spouse_document}, residentes e domiciliados ?? {$this->ownerObject->street}, n?? {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            } else { // E n??o tem conjuge
                $terms[] = "<p><b>1. {$parameters['part']}: {$this->ownerObject->name}</b>, natural de {$this->ownerObject->place_of_birth}, {$this->ownerObject->civil_status}, {$this->ownerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->ownerObject->document_secondary} {$this->ownerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->ownerObject->document}, residente e domiciliado ?? {$this->ownerObject->street}, n?? {$this->ownerObject->number}, {$this->ownerObject->complement}, {$this->ownerObject->neighborhood}, {$this->ownerObject->city}/{$this->ownerObject->state}, CEP {$this->ownerObject->zipcode}.</p>";
            }

        }

        // ACQUIRER
        if (!empty($this->acquirer_company)) { // Se tem empresa

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. n?? {$this->acquirerCompanyObject->document_company} e I. E. n?? {$this->acquirerCompanyObject->document_company_secondary} exercendo suas atividades no endere??o {$this->acquirerCompanyObject->street}, n?? {$this->acquirerCompanyObject->number}, {$this->acquirerCompanyObject->complement}, {$this->acquirerCompanyObject->neighborhood}, {$this->acquirerCompanyObject->city}/{$this->acquirerCompanyObject->state}, CEP {$this->acquirerCompanyObject->zipcode} tendo como respons??vel legal {$this->acquirerObject->name}, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->acquirerObject->document}, e c??njuge {$this->acquirerObject->spouse_name}, natural de {$this->acquirerObject->spouse_place_of_birth}, {$this->acquirerObject->spouse_occupation}, portador da c??dula de identidade R. G. n?? {$this->acquirerObject->spouse_document_secondary} {$this->acquirerObject->spouse_document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->acquirerObject->spouse_document}, residentes e domiciliados ?? {$this->acquirerObject->street}, n?? {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            } else { // E n??o tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerCompanyObject->social_name}</b>, inscrito sob C. N. P. J. n?? {$this->acquirerCompanyObject->document_company} e I. E. n?? {$this->acquirerCompanyObject->document_company_secondary} exercendo suas atividades no endere??o {$this->acquirerCompanyObject->street}, n?? {$this->acquirerCompanyObject->number}, {$this->acquirerCompanyObject->complement}, {$this->acquirerCompanyObject->neighborhood}, {$this->acquirerCompanyObject->city}/{$this->acquirerCompanyObject->state}, CEP {$this->acquirerCompanyObject->zipcode} tendo como respons??vel legal {$this->acquirerObject->name}, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->acquirerObject->document}, residente e domiciliado ?? {$this->acquirerObject->street}, n?? {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            }

        } else { // Se n??o tem empresa

            if (!empty($this->acquirer_spouse)) { // E tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerObject->name}</b>, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->acquirerObject->document}, e c??njuge {$this->acquirerObject->spouse_name}, natural de {$this->acquirerObject->spouse_place_of_birth}, {$this->acquirerObject->spouse_occupation}, portador da c??dula de identidade R. G. n?? {$this->acquirerObject->spouse_document_secondary} {$this->acquirerObject->spouse_document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->acquirerObject->spouse_document}, residentes e domiciliados ?? {$this->acquirerObject->street}, n?? {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            } else { // E n??o tem conjuge
                $terms[] = "<p><b>2. {$parameters['part_opposite']}: {$this->acquirerObject->name}</b>, natural de {$this->acquirerObject->place_of_birth}, {$this->acquirerObject->civil_status}, {$this->acquirerObject->occupation}, portador da c??dula de identidade R. G. n?? {$this->acquirerObject->document_secondary} {$this->acquirerObject->document_secondary_complement}, e inscri????o no C. P. F. n?? {$this->acquirerObject->document}, residente e domiciliado ?? {$this->acquirerObject->street}, n?? {$this->acquirerObject->number}, {$this->acquirerObject->complement}, {$this->acquirerObject->neighborhood}, {$this->acquirerObject->city}/{$this->acquirerObject->state}, CEP {$this->acquirerObject->zipcode}.</p>";
            }

        }

        $terms[] = "<p style='font-style: italic; font-size: 0.875em;'>A falsidade dessa declara????o configura crime previsto no C??digo Penal Brasileiro, e pass??vel de apura????o na forma da Lei.</p>";

        $terms[] = "<p><b>5. IM??VEL:</b> {$this->propertyObject->category}, {$this->propertyObject->type}, localizada no endere??o {$this->propertyObject->street}, n?? {$this->propertyObject->number}, {$this->propertyObject->complement}, {$this->propertyObject->neighborhood}, {$this->propertyObject->city}/{$this->propertyObject->state}, CEP {$this->propertyObject->zipcode}</p>";

        $terms[] = "<p><b>6. PER??ODO:</b> {$this->deadline} meses</p>";

        $terms[] = "<p><b>7. VIG??NCIA:</b> O presente contrato tem como data de in??cio {$this->start_at} e o t??rmino exatamente ap??s a quantidade de meses descrito no item 6 deste.</p>";

        $terms[] = "<p><b>8. VENCIMENTO:</b> Fica estipulado o vencimento no dia {$this->due_date} do m??s posterior ao do in??cio de vig??ncia do presente contrato.</p>";

        $terms[] = "<p>Florian??polis, " . date('d/m/Y') . ".</p>";

        $terms[] = "
      <table width='100%' style='margin-top: 50px;'>
         <tr>
            <td>_________________________</td>
            " . ($this->owner_spouse ? "<td>_________________________</td>" : "") . "
         </tr>
         <tr>
            <td>{$parameters['part']}: {$this->ownerObject->name}</td>
            " . ($this->owner_spouse ? "<td>Conjuge: {$this->ownerObject->spouse_name}</td>" : "") . "
         </tr>
         <tr>
            <td>Documento: {$this->ownerObject->document}</td>
            " . ($this->owner_spouse ? "<td>Documento: {$this->ownerObject->spouse_document}</td>" : "") . "
         </tr>
     </table>";


        $terms[] = "
      <table width='100%' style='margin-top: 50px;'>
         <tr>
            <td>_________________________</td>
            " . ($this->acquirer_spouse ? "<td>_________________________</td>" : "") . "
         </tr>
         <tr>
            <td>{$parameters['part_opposite']}: {$this->acquirerObject->name}</td>
            " . ($this->acquirer_spouse ? "<td>Conjuge: {$this->acquirerObject->spouse_name}</td>" : "") . "
         </tr>
         <tr>
            <td>Documento: {$this->acquirerObject->document}</td>
            " . ($this->acquirer_spouse ? "<td>Documento: {$this->acquirerObject->spouse_document}</td>" : "") . "
         </tr>
      </table>";

        $terms[] = "
      <table width='100%' style='margin-top: 50px;'>
         <tr>
            <td>_________________________</td>
            <td>_________________________</td>
         </tr>
         <tr>
            <td>1?? Testemunha: </td>
            <td>2?? Testemunha: </td>
         </tr>
         <tr>
            <td>Documento: </td>
            <td>Documento: </td>
         </tr>
      </table>";

        return implode('', $terms);
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
