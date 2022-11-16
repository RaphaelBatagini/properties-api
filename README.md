![Test status](https://github.com/RaphaelBatagini/eng-zap-challenge-php/workflows/PHP%20Composer/badge.svg)

# Properties API

API to split a list of properties between two Real State Companies following some rules.

## Tech Stack
- PHP 7.2
- PHPUnit 8
- Docker
- Docker Compose

## Install
- Clone the repository
- Copy the content of the **.env.sample** into a new **.env** the project root folder
- No arquivo **.htaccess** você irá encontrar as configurações para que o projeto funcione com www, https e http. Descomente os trechos conforme configuração do host em seu ambiente local ou servidor
- Garanta permissão de escrita e leitura na pasta **assets**
```
chmod -R 775 assets
```
- Acesse o diretório clonado e instale as dependencias do composer com o seguinte comando:
```
composer install
```

## Executando testes
- Todos os testes se encontram na pasta **tests** na raiz do projeto
- Para executar os testes, utilize o seguinte comando:
```
./vendor/bin/phpunit tests
```

## Como utilizar a API
Para buscar os imóveis, basta acessar a URN abaixo precedida pelo host que você configurou
```
/properties/portal/{zap|vivareal}/{pagina}
```

Também é possível buscar todos os imóveis, sem filtros de portais, acessando a seguinte URN:
```
/properties/{pagina}
```

## Sobre o Projeto
Devido a sua simplicidade, este projeto foi criado sem utilização de um framework de mercado.
Ao invés disso, foram utilizados somente alguns pacotes para necessidades específicas.

## Pacotes de terceiros utilizados
- Coffeecode Router
- PHPDotEnv

### Especificidades
- Na primeira vez que o json em http://grupozap-code-challenge.s3-website-us-east-1.amazonaws.com/sources/source-2.json é consultado, fica armazenado na pasta assets do projeto. Nas consultas de imóveis seguintes, o sistema dará preferência ao arquivo local ao invés da fonte externa, visando performance.

### Regras de negócio
Regras de negócio definidas em [https://grupozap.github.io/cultura/challenges/engineering.html](https://grupozap.github.io/cultura/challenges/engineering.html).

## Melhorias a serem implementadas
- Utilização do design pattern Chain of Responsabilities na definição de qual collection deve ser carregada no método getPropertiesCollection;
- Ao invés de salvar o retorno do arquivo source-2.json no projeto e mantê-lo por tempo indefinido, verificar sempre a eTag da request para o arquivo remoto e baixá-lo novamente caso tenha sofrido alterações;
- Cobrir métodos privados das classes com testes unitários;
- Melhorar a forma como os dados de imóveis são construídos nos testes, talvez utilizando mocks.
