![Test status](https://github.com/RaphaelBatagini/eng-zap-challenge-php/workflows/PHP%20Composer/badge.svg)

# Teste para o Grupo Zap

API que atende a regras de negócio pré-estabelecidas visando separar uma lista de imóveis entre os elegíveis para o Zap e Viva Real.

## Requisitos
- PHP >= 7.2

## Instalação
- Clone o repositório em sua máquina
- Acesse o diretório clonado e execute o seguinte comando:
```
composer install
```
- Garanta permissão de escrita e leitura na pasta **assets**

## Executando testes
- Todos os testes do projeto se encontram na pasta **tests** na raiz do projeto
- Para executar os testes, na raiz do projeto, utilize o seguinte comando:
```
./vendor/bin/phpunit tests
```

## Como utilizar
Para buscar os imóveis, basta acessar a URN 
```/properties/portal/{zap|vivareal}/{pagina}```

## Sobre o Projeto
Devido a sua simplicidade, este projeto foi criado sem utilização de um framework de mercado.
Ao invés disso, foi escolhido utilizar somente alguns pacotes para necessidades específicas conforme os recursos listados abaixo.

### Recursos
- GuzzleHttp
- Coffeecode Router

### Especificidades
- Na primeira vez que este [json](http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/sources/source-2.json) é consultado, fica armazenado na pasta assets do projeto. Nas consultas de imóveis seguintes, o sistema dará preferência ao arquivo local ao invés da fonte externa, visando performance.

### Regras de negócio
Regras de negócio definidas em [https://grupozap.github.io/cultura/challenges/engineering.html](https://grupozap.github.io/cultura/challenges/engineering.html).
