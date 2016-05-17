# Yet Another Boleto

[![Build Status](https://travis-ci.org/umbrellaTech/ya-boleto-php.png?branch=master)](https://travis-ci.org/umbrellaTech/ya-boleto-php)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/917b4bbf29ea4a6a909873aaa5a94300)](https://www.codacy.com/app/italolelis/ya-boleto-php?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=umbrellaTech/ya-boleto-php&amp;utm_campaign=Badge_Grade)
[![Code Coverage](https://scrutinizer-ci.com/g/umbrellaTech/ya-boleto-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/umbrellaTech/ya-boleto-php/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/umbrella/boleto/v/stable.png)](https://packagist.org/packages/umbrella/boleto)
[![Latest Unstable Version](https://poser.pugx.org/umbrella/boleto/v/unstable.png)](https://packagist.org/packages/umbrella/boleto)

O YaBoleto e um novo componete de boleto bancario em PHP, mas qual a diferença dos outros? Simples... Ele foi projetado de forma simples e Orientada a Objetos.
Seguimos os padrões PSR-0, PSR-1 e PSR-2, utilizamos padrões de projetos onde seria necessário e Voilà. O YaBoleto vai mudar a forma de como você trabalha com boletos bancários.

Quer utilizar o YaBoleto? Leia nossa [documentaçao][2] e veja como é simples.

## Instalação
### Composer
Se você já conhece o **Composer** (o que é extremamente recomendado), simplesmente adicione a dependência abaixo à diretiva *"require"* no seu **composer.json**:
```sh
$ composer require umbrella/boleto
```

Sim, só isso! Lembre-se de que cada banco possui alguma particularidade, mas em geral são estes parâmetros os obrigatórios. 

O projeto [umbrellaTech/demo][1] possui um exemplo funcional de cada banco, você pode verificar lá quais são os parâmetros necessários para cada banco.

## Bancos suportados
Atualmente o YaBoleto funciona com os bancos abaixo:

| **Banco**           |  **Carteira/Convenio** | **Implementado** | **Testado** |
|---------------------|--------------------------|--------------------|---------------|
| **Banco do Brasil** | 17, 18, 21               | Sim                | Sim           |
| **Banrisul**        | x                        | Não                | Não           |
| **Bradesco**        | 06, 03                   | Sim                | Sim           |
| **Caixa Economica** | SR                       | Sim                | Sim           |
| **HSBC**            | CNR, CSB                 | Não                | Nao           |
| **Itau**            | 157                      | Não                | Não           |
| **Itau**            | 175, 174, 178, 104, 109  | Não                | Não           |
| **Real**            | 57                       | Sim                | Sim           |
| **Santander**       | 101, 102, 201            | Sim                | Sim           |
|                     |                          |                    |               |

Uso
----------

A forma mais simples é utilizar o Builder.

```php
use Umbrella\YaBoleto\Builder\BoletoBuilder;
use Umbrella\YaBoleto\Endereco;

// sacado...
$nomeSacado      = "John Doe";
$documentoSacado = "090.076.684-04";
$enderecoSacado = new Endereco(
    "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
    "70200-002",
    "Brasília",
    "DF"
);

// cedente...
$nomeCedente      = "ACME Corporation Inc.";
$documentoCedente = "01.122.241/0001-76";
$enderecoCedente = new Endereco(
    "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
    "70200-002",
    "Brasília",
    "DF"
);

$builder = new BoletoBuilder(BoletoBuilder::BRADESCO);

$boleto  = $builder->sacado(BoletoBuilder::PESSOA_FISICA, $nomeSacado, $documentoSacado, $enderecoSacado)
                   ->cedente($nomeCedente, $documentoCedente, $enderecoCedente)
                   ->banco("0564", "0101888")
                   ->carteira("06")
                   ->convenio("0101888", "77000009017")
                   ->build(250, "77000009017", new \DateTime("2015-03-24"));

echo $boleto->getLinhaDigitavel() // 23790.56407 67700.000903 17010.188807 8 63770000025000
```

A forma Orientada a Objetos é um pouco mais trabalhossa, mas permite maior flexibilidade.

```php
use Umbrella\YaBoleto\Bancos\Bradesco\Convenio;
use Umbrella\YaBoleto\Bancos\Bradesco\Bradesco;
use Umbrella\YaBoleto\Bancos\Bradesco\Carteira\Carteira06;
use Umbrella\YaBoleto\Bancos\Bradesco\Boleto\Bradesco as BoletoBradesco;

use Umbrella\YaBoleto\PessoaFisica;
use Umbrella\YaBoleto\Cedente;
use Umbrella\YaBoleto\Sacado;

// sacado...
$nomeSacado      = "John Doe";
$documentoSacado = "090.076.684-04";
$enderecoSacado = new Endereco(
    "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
    "70200-002",
    "Brasília",
    "DF"
);

// cedente...
$nomeCedente      = "ACME Corporation Inc.";
$documentoCedente = "01.122.241/0001-76";
$enderecoCedente = new Endereco(
    "Setor de Clubes Esportivos Sul (SCES) - Trecho 2 - Conjunto 31 - Lotes 1A/1B",
    "70200-002",
    "Brasília",
    "DF"
);

$banco        = new Bradesco("0564", "0101888");
$carteira     = new Carteira06();

$convenio     = new Convenio($banco, $carteira, "0101888", "77000009017");
$pessoaFisica = new PessoaFisica($nomeSacado, $documentoSacado, $enderecoSacado);
$sacado       = new Sacado($pessoaFisica);
$cedente      = new Cedente($nomeCedente, $documentoCedente, $enderecoCedente);

$boleto       = new BoletoBradesco($sacado, $cedente, $convenio);

$boleto->setValorDocumento(50)
       ->setNumeroDocumento(2)
       ->setDataVencimento(new \DateTime('2014-09-02'));

echo $boleto->getLinhaDigitavel() // 23790.56407 67700.000903 17010.188807 8 63770000025000
```

Contribua
----------

Toda contribuição é bem vinda. Se você deseja adaptar o YaBoleto a algum outro banco, fique à vontade para explorar o código, veja como é bastante simples integrar qualquer banco à biblioteca. Para instalar clone o projeto dentro da pasta **Umbrella/YaBoleto**.
```
git clone https://github.com/umbrellaTech/ya-boleto-php.git ya-boleto-php/Umbrella/YaBoleto
```
Ou usando o composer.
```
php composer.phar create-project umbrella/boleto ya-boleto-php/Umbrella/YaBoleto dev-master
```
Isso se deve por conta do autoloader que segue a [PSR-4][3].

Demo
----------
A aplicação de demonstração está no repositório [YaBoleto Demo](https://github.com/umbrellaTech/ya-boleto-demo)

Licença
----------

* MIT License

[1]: https://github.com/umbrellaTech/ya-boleto-demo
[2]: https://github.com/umbrellaTech/ya-boleto-php/docs
[3]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4.md
