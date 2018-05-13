Desenvolvedor
=============

**Atualizado em:** 13/05/2018

Este guia de desenvolvimento descreve o passo a passo para instalar em um ambiente local o projeto tgGV - Orçamento Pessoal, a fim de possibilitar que o usuário faça alterações no projeto.

Requisitos
----------

Para usar a aplicação, certifique-se de que possui instalado em seu computador as [Tecnologias](../guia-desenvolvimento/4-tecnologias.md) descritas na página do Guia de Desenvolvimento, de acordo com o uso que irá fazer.

Para rodar o código é impressindível que tenha instalado:

+ [PHP 7.1.3 ou superior](http://php.net/manual/pt_BR/install.php "Link para documentação do PHP")
+ [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx "Link para a documentação do Composer")
+ [Git](https://git-scm.com/download/linux "Link para a documentação do Git")
+ [Node.js](https://nodejs.org/en/download/package-manager/ "Link para a documentação do Node.js")
+ Um gerenciador de banco de dados podendo ser:
    - MySQL ou Maria DB
    - PostgreSQL
    - SQLite
    - SQL Server

Para suportar o desenvolvimento da documentação é preciso ter instalado:

+ [Python 2.7 ou superior](https://www.python.org/downloads/ "Link para a documentação do Python")
+ [Python virtualenv](https://pypi.org/project/virtualenv/ "Link para a página do pacote no PyPI")
+ [Python virtualenvwrapper](https://pypi.org/project/virtualenvwrapper/ "Link para a página do pacote no PyPI")
+ [MkDocs](http://www.mkdocs.org/#installation "Link para a documentação do MkDocs")
+ [MkDocs - Material](https://squidfunk.github.io/mkdocs-material/getting-started/ "Link para a documentação do MkDocs - Material")

Instalação
----------

Com todos os requisitos instalados, clone o repositório que está armazenado no [GitHub](https://github.com/getuliovinicius/trabalho.graduacao "Link para o repositório").

```
$ git clone https://github.com/getuliovinicius/trabalho.graduacao.git
```

Após o termino do clone, acesse o diretório `trabalho.graduacao`.

```
$ cd trabalho.graduacao
```

Para configurar o ambiente, renomeie o arquivo `.env.exemple` para `.env` e edite-o ajustando os parametros comforme sua necessidade. Mais informações podem ser obtidas em:

+ [Configuration - https://laravel.com/docs/5.6/configuration](https://laravel.com/docs/5.6/configuration "Link para a documentação do Laravel")
+ [Database Configuration - https://laravel.com/docs/5.6/database#configuration](https://laravel.com/docs/5.6/database#configuration "Link para a documentação do Laravel")

Neste documento, vamos assumir que tenha optado por uma instalação do [SQLite](https://sqlite.org/download.html "Link para a página de Donwload do SQLite") como gerenciador de banco de dados. Embora não tenha sido este o gerenciador utilizado no desenvolvimento do projeto, ele serve perfeitamente para a realização de uma instalação rápida do tgGV.

Crie um arquivo chamado `database.sqlite` no diretório `database`.

```
$ touch database/database.sqlite
```

Após, remova as linhas abaixo no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Então, adicione as duas linha abaixo no lugar das linhas removidas anteriormente:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/trabalho.graduacao/database/database.sqlite
```

Lembre-se de alterar `/absolute/path/to` pelo nome correto dos diretórios acima do diretório `trabalho.graduação`.

Em seguida, use o comando `composer install` para fazer o download das dependências de back-end do projeto.

```
$ composer install
```

Por fim, use o comando `npm install` para fazer o download das dependências de front-end do projeto, e o comando `npm run dev`, para gerar os arquivos `.css` e `.js` do front-end da aplicação.

```
$ npm install
$ npm run dev
```

Uso da API
----------