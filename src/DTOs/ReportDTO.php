<?php

namespace Advvm\DTOs;

class ReportDTO
{
    public function __construct(
        private string $date,
        private string $report,
        private string $type,
        private float $amount,
        private ?int $id = null,
    ) {
        $this->report = ucfirst($this->report);
        $this->type = ucfirst($this->type);
    }

    public static function create(string $date = '', string $report = '', string $type = '', float $amount = 0.0, ?int $id = null): self
    {
        return new self($date, $report, $type, $amount, $id);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getFormattedDate(string $format = "d/m/Y"): string
    {
        return (new \DateTimeImmutable($this->date))->format($format);
    }

    public function getReport(): string
    {
        return $this->report;
    }

    public function getReportWithTruncatedWidth(int $maxWidth = 20, string $trim_marker = '...'): string
    {
        return mb_strimwidth($this->report, 0, $maxWidth, $trim_marker);
    }

    public function setType(string $type): void
    {
        //Checando se o lançamento é uma Entrada ou Saída
        $options = [
            "Oferta", "Ofertas", "Dízimo", "Dízimos", "Dizimo", "Dizimos", "Saldo Anterior"
        ];

        if ((in_array(ucfirst($type), ['Entrada', 'Saida', 'Saída'])) && (in_array(ucfirst($type), $options))) {
            $this->type = "Entrada";
        } else {
            $this->type = "Saída";
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setAmount(float|string $amount): void
    {
        if (is_string($amount)) {
            $formatStringToFloatPattern = function (string $str) {
                if (str_contains($str, ',')) {
                    $str = str_replace('.', '', $str);
                    $str = str_replace(',', '.', $str);
                }

                return $str;
            };

            $amount = $formatStringToFloatPattern($amount);

            $this->amount = (float)$amount;
        } else {
            $this->amount = $amount;
        }
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAmountInBRLFormat(): string
    {
        return "R$ " . number_format($this->amount, 2, ',', '.');
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'report' => $this->report,
            'type' => $this->type,
            'amount' => $this->amount,
        ];
    }
}
