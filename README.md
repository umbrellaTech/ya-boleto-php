# Yet Another Boleto


[![Build Status](https://travis-ci.org/umbrellaTech/ya-boleto-php.png?branch=master)](https://travis-ci.org/umbrellaTech/ya-boleto-php)
[![Latest Stable Version](https://poser.pugx.org/umbrella/boleto/v/stable.png)](https://packagist.org/packages/umbrella/boleto)
[![Latest Unstable Version](https://poser.pugx.org/umbrella/boleto/v/unstable.png)](https://packagist.org/packages/umbrella/boleto)

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

* Banco do Brasil (Carteiras 18-7, 18-6)
* Santander (Carteira 102)
* Caixa Econômica
* Bradesco

## Contribua
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

## Licença

* MIT License

[1]: https://github.com/umbrellaTech/ya-boleto-demo
[2]: https://github.com/umbrellaTech/ya-boleto-php/docs
[3]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
