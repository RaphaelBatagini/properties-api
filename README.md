# Teste para o Grupo Zap

API que atende a regras de negócio pré-estabelecidas visando separar uma lista de imóveis entre os elegíveis para o Zap e Viva Real.

## Instalação
- Clone o repositório em sua máquina
- Acessa o diretório clone e execute o seguinte comando:
```
composer install
```

## Projeto
Devido a sua simplicidade, este projeto foi criado sem utilização de um framework de mercado.
Ao invés disso, foi escolhido utilizar somente alguns pacotes para necessidades específicas conforme os recursos listados abaixo.

### Recursos
- GuzzleHttp
- Coffeecode Router

### Especificidades
- Na primeira vez que este (json)[http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/sources/source-2.json] é consultado, fica armazenado na pasta assets do projeto. Nas consultas de imóveis seguintes, o sistema dará preferência ao arquivo local ao invés da fonte externa, visando performance.
