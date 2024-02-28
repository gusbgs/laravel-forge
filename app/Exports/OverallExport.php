<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class OverallExport implements WithMultipleSheets
{
    use Exportable;
    
    public function change_summary_all($change_summary_all)
    {
        $this->change_summary_all = $change_summary_all;
        
        return $this;
    }
    
    public function start_date_summary($date_summary_all)
    {
        $this->start_date_summary = $date_summary_all;
        
        return $this;
    }
    
    public function end_date_summary($date_summary_all)
    {
        $this->end_date_summary = $date_summary_all;
        
        return $this;
    }
    
    public function change_summary_red($change_summary_red)
    {
        $this->change_summary_red = $change_summary_red;
        
        return $this;
    }
    
    public function start_date_summary_red($date_summary_red)
    {
        $this->start_date_summary_red = $date_summary_red;
        
        return $this;
    }
    
    public function end_date_summary_red($date_summary_red)
    {
        $this->end_date_summary_red = $date_summary_red;
        
        return $this;
    }
    
    public function change_summary_green($change_summary_green)
    {
        $this->change_summary_green = $change_summary_green;
        
        return $this;
    }
    
    public function start_date_summary_green($date_summary_green)
    {
        $this->start_date_summary_green = $date_summary_green;
        
        return $this;
    }
    
    public function end_date_summary_green($date_summary_green)
    {
        $this->end_date_summary_green = $date_summary_green;
        
        return $this;
    }
    
    public function change_income($change_income)
    {
        $this->change_income = $change_income;
        
        return $this;
    }
    
    public function start_date_income($date_income)
    {
        $this->start_date_income = $date_income;
        
        return $this;
    }
    
    public function end_date_income($date_income)
    {
        $this->end_date_income = $date_income;
        
        return $this;
    }
    
     /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            'Ringkasan dan PAD' => new SummaryExport($this->change_summary_all, 'laporan_bulanan_pad', $this->start_date_summary, $this->end_date_summary, 'Ringkasan dan PAD'),
            'Laporan Bulanan (Merah)' => new SummaryExport($this->change_summary_red, 'laporan_bulanan_merah', $this->start_date_summary_red, $this->end_date_summary_red, 'Laporan Bulanan (Merah)'),
            'Laporan Bulanan (Hijau)' => new SummaryExport($this->change_summary_green, 'rekapitulasi_laporan_bulanan_hijau', $this->start_date_summary_green, $this->end_date_summary_green, 'Laporan Bulanan (Hijau)')
            // 'Pendapatan' => new IncomeExport(0, $this->change_income, $this->date_income)
        ];
    }
}
