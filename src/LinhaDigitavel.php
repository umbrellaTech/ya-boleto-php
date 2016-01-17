<?php

namespace Umbrella\YaBoleto;

final class LinhaDigitavel implements ValueObjectInterface
{
    /** @var string */
    private $value;

    /**
     * LinhaDigitavel constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
