<?php

namespace Stella\Support\Traits\Str;

trait UtilTrait
{
    use StringTrait;

    public function length(): int
    {
        return mb_strlen($this->value());
    }

    public function repeat(int $times): static
    {
        return $this->newInstanceOf(str_repeat($this->value(), $times));
    }

    public function limit(int $limit, string $end = '...'): static
    {
        if ($this->length() > $limit) {
            return $this->newInstanceOf(mb_substr($this->value(), 0, $limit) . $end);
        }

        return $this->newInstanceOf($this->value());
    }

    //TODO: separate uuid generation to a separate class, this is not a string utility
    public function uuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
