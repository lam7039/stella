<?php

namespace Stella\Support\Traits\Str;

trait UtilTrait
{
    use StringTrait;

    public function length(): int
    {
        return mb_strlen($this->value());
    }

    public function repeat(int $times): self
    {
        return $this->with(str_repeat($this->value(), $times));
    }

    public function limit(int $limit, string $end = '...'): self
    {
        if ($this->length() > $limit) {
            return $this->with(mb_substr($this->value(), 0, $limit) . $end);
        }

        return $this->with($this->value());
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
