<?php

namespace Umbrella\YaBoleto;

final class CodigoBarras implements ValueObjectInterface
{
    /** @var string */
    private $value;

    /**
     * CodigoBarras constructor.
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
