# Yet Another Boleto


[![Build Status](https://travis-ci.org/umbrellaTech/ya-boleto-php.png?branch=master)](https://travis-ci.org/umbrellaTech/ya-boleto-php)
[![Latest Stable Version](https://poser.pugx.org/umbrella/boleto/v/stable.png)](https://packagist.org/packages/umbrella/boleto)
[![Latest Unstable Version](https://poser.pugx.org/umbrella/boleto/v/unstable.png)](https://packagist.org/packages/umbrella/boleto)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1f67b9bd-f120-43d5-9f02-f73aa6132d86/small.png)](https://insight.sensiolabs.com/projects/1f67b9bd-f120-43d5-9f02-f73aa6132d86)

O YaBoleto e um novo componete de boleto bancario em PHP, mas qual a diferença dos outros? Simples... Ele foi projetado de forma simples e Orientada a Objetos.
Seguimos os padrões PSR-0, PSR-1 e PSR-2, utilizamos padrões de projetos onde seria necessário e Voilà. O Ya Boleto vai mudar a forma de como você trabalha com boletos bancários.

Quer utilizar o YaBoleto? Leia nossa [documentaçao][2] e veja como é simples.

## Instalação
### Composer
Se você já conhece o **Composer** (o que é extremamente recomendado), simplesmente adicione a dependência abaixo à diretiva *"require"* no seu **composer.json**:
```
"umbrella/boleto": "1.4.0"
```

Sim, só isso! Lembre-se de que cada banco possui alguma particularidade, mas em geral são estes parâmetros os obrigatórios. 

O projeto [umbrellaTech/demo][1] possui um exemplo funcional de cada banco, você pode verificar lá quais são os parâmetros necessários para cada banco.

## Bancos suportados
Atualmente o YABoleto funciona com os bancos abaixo:

| **Banco**           |  **Carteira/Convenio** | **Implementado** | **Testado** |
|---------------------|--------------------------|--------------------|---------------|
| **Banco do Brasil** | 17, 18, 21               | Sim                | Sim           |
| **Banrisul**        | x                        | Nao                | Nao           |
| **Bradesco**        | 06, 03                   | Sim                | Sim           |
| **Caixa Economica** | SR                       | Sim                | Sim           |
| **HSBC**            | CNR, CSB                 | Nao                | Nao           |
| **Itau**            | 157                      | Nao                | Nao           |
| **Itau**            | 175, 174, 178, 104, 109  | Nao                | Nao           |
| **Real**            | 57                       | Sim                | Sim           |
| **Santander**       | 102                      | Sim                | Sim           |
| **Santander**       | 101, 201                 | Sim                | Sim           |
|                     |                          |                    |               |

Uso
----------

A forma mais simples é utilizar o Builder.

```php
use DateTime;
use Umbrella\Ya\Boleto\Builder\Bancos;
use Umbrella\Ya\Boleto\Builder\BoletoBuilder;

$builder = new BoletoBuilder(Bancos::BANCO_BRASIL);

$boleto = $builder
    ->sacado('Sacado', '61670634787') // também pode ser passado com a máscara 616.706.347-87
    ->cedente('Cendente', '08365691000139') // também pode ser passado com a máscara 08.365.691/0001-39
    ->banco(1234, 123456787)
    ->carteira(18)
    ->convenio(1234567, 2)
    ->build(50, 2, new DateTime('2014-09-02'));

echo $boleto->getLinhaDigitavel() // 00190.00009 01234.567004 00000.002188 7 61740000005000
```

A forma Orientada a Objetos é um pouco mais trabalhossa, mas permite maior flexibilidade.

```php
use Umbrella\Ya\Boleto\Bancos\BancoBrasil\BancoBrasil as BancoBrasil2;
use Umbrella\Ya\Boleto\Bancos\BancoBrasil\Boleto\BancoBrasil;
use Umbrella\Ya\Boleto\Bancos\BancoBrasil\Carteira\Carteira17;
use Umbrella\Ya\Boleto\Bancos\BancoBrasil\Carteira\Carteira18;
use Umbrella\Ya\Boleto\Bancos\BancoBrasil\Convenio;
use Umbrella\Ya\Boleto\Cedente;
use Umbrella\Ya\Boleto\PessoaFisica;
use Umbrella\Ya\Boleto\Sacado;

$banco  = new BancoBrasil2(1234, 123456787);
$carteira   = new Carteira18();

$convenio   = new Convenio($banco, $carteira, 1234567, 2);
$pf         = new PessoaFisica('Sacado', '61670634787');
$sacado     = new Sacado($pf);
$cedente    = new Cedente('Cendente', '08365691000139');

$boletoBB = new BancoBrasil($sacado, $cedente, $convenio);
$boletoBB->setValorDocumento(50)
        ->setNumeroDocumento(2)
        ->setDataVencimento($new DateTime('2014-09-02'));

echo $boleto->getLinhaDigitavel() // 00190.00009 01234.567004 00000.002188 7 61740000005000

```

Contribua
----------

Toda contribuição é bem vinda. Se você deseja adaptar o YABoleto a algum outro banco, fique à vontade para explorar o código, 
veja como é bastante simples integrar qualquer banco à biblioteca. Para instalar clone o projeto dentro da pasta **Umbrella/Ya/Boleto**.
```
git clone https://github.com/umbrellaTech/ya-boleto-php.git ya-boleto-php/Umbrella/Ya/Boleto
```
Ou usando o composer.
```
php composer.phar create-project umbrella/boleto ya-boleto-php/Umbrella/Ya/Boleto dev-master
```
Isso se deve por conta do autoloader que segue a [PSR-0][3].

Demo
----------
A aplicação de demonstração está no repositório [Ya Boleto Demo](https://github.com/umbrellaTech/ya-boleto-demo)

Licença
----------

* MIT License

[1]: https://github.com/umbrellaTech/ya-boleto-demo
[2]: https://github.com/umbrellaTech/ya-boleto-php/docs
[3]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
