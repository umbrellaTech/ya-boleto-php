<?php
/*
 * The MIT License
 *
 * Copyright 2013 italo.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Umbrella\YaBoleto;

/**
 * Classe que representa um documento.
 *
 * @author  Italo Lelis <italolelis@gmail.com>
 * @package YaBoleto
 */
abstract class AbstractDocumento
{
    /**
     * @var string
     */
    private $value;

    /**
     * AbstractDocumento constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->validate($value);

        $this->value = $value;
    }

    /**
     * Validates a document
     * @param $value
     * @return bool
     */
    protected abstract function validate($value);

    /**
     * Creates a document from a string
     * @param $value
     * @return static
     */
    public static function fromString($value)
    {
        return new static($value);
    }

    /**
     * Gets the document value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->value;
    }
}
