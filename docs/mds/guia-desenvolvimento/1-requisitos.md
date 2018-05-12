Documento de Requisitos
=======================

**Atualizado em:** 12/05/2018

Requisitos para a versão 1.0.0
------------------------------

### Requisitos de tecnologia

- [X] Arquitetura orientada a serviço.
- [X] API - Web service RESTful.
- [ ] Aplicação Web para consumir a API.

### Requisitos da aplicação

Abaixo segue a tabela com a lista de requisitos gerais da aplicação.

| API | Web | Requisito |
|:---:|:---:|:--------- |
| OK  |  -  | Autenticação de usuários. |
| OK  |  -  | A aplicação deve possuir quatro papéis de usuário (Super Usuário, Administrador, Gerente e Usuário). |
|  -  |  -  | Deve existir apenas um Super Usuário denominado `root` que não poderá ser excluído. |
| OK  |  -  | Nenhum usuário pode visualizar, alterar, excluir ou criar uma categoria, conta ou lançamento de outro ou para outro usuário. |
|  -  |  -  | A aplicação deve gerar relatórios do tipo lista de usuários (ativos, inativos, bloqueados) |
|  -  |  -  | A aplicação deve gerar relatório sintético de contas criadas por período |

### Requisitos do usuário do serviço

Esses são os requisitos e regras de negócio da aplicação para usuários que irão criar uma conta no serviço a fim de realizarem o controle de suas finanças pessoais.

| API | Web | Requisito |
|:---:|:---:|:--------- |
| OK  |  -  | As pessoas que tiverem interesse em usar o serviço devem se cadastrar em um formulário público informando o nome completo, endereço de e-mail e senha. |
|  -  |  -  | Após realizar seu cadastro na aplicação o usuário deve receber um link no e-mail informado, apontando para o endereço de ativação da conta. |
| OK  |  -  | Todas as contas para usuários do serviço cadastradas através do formulário público devem ser atribuídas ao papel Usuário. |
|  -  |  -  | O usuário cadastrado pode alterar sua senha de acesso a aplicação e outros dados pessoais. |
| OK  |  -  | O usuário cria categorias para organizar as contas. |
| OK  |  -  | O usuário pode alterar o nome das categorias. |
| OK  |  -  | O usuário pode excluir uma categoria desde que não existam contas vinculadas a esta categoria. |
| OK  |  -  | O usuário cria as contas observando os grupos Ativo, Passivo, Patrimônio Liquído, Receita e Despesa. |
| OK  |  -  | O usuário pode alterar o nome e a categoria de uma conta. |
| OK  |  -  | O usuário pode excluir uma conta desde que não existam lançamentos vinculados a esta conta. |
| OK  |  -  | O usuário faz lançamentos nas contas. |
| OK  |  -  | O usuário pode realizar correções nos lançamentos. |
| OK  |  -  | O usuário lista as contas com seus respectivos saldos. |
| OK  |  -  | O usuário visualiza as contas com seus respectivos lançamentos. |
| OK  |  -  | O saldo das contas somente é atualizado a partir de lançamentos onde são identificadas as contas de origem e de destino da movimentação. |

### Requisitos do administrador do serviço

Esses são os requisitos e regras de negógio para usuários que irão gerenciar a aplicação.

| API | Web | Requisito |
|:---:|:---:|:--------- |
|  -  |  -  | Apenas o usuário `root` pode gerenciar o cadastro de usuários com o papel Administrador. |
|  -  |  -  | O usuário `root` e os demais usuários com papel Administrador podem gerenciar o cadastro de usuários com o papel Gerente. |
|  -  |  -  | O usuário `root` e os demais usuários com papel Administrador podem bloquear o cadastro de usuários com os papel Usuário. |
|  -  |  -  | O usuário com papéis de Admministrador ou Gerente podem acessar realatórios gerenciais. |

Requisitos da versão 2.0.0
--------------------------

Até o momento todos os requisitos elencados para a versão 1.0.0 são também requisitos para a versão 2.0.0 e não sofreram alterações.

### Requisitos da aplicação

Abaixo segue a tabela com a lista de requisitos gerais da aplicação.

| API | Web | Requisito |
|:---:|:---:|:--------- |
|  -  |  -  | A aplicação deve registrar em log as ações dos usuários (criação, alteração e exclusão de lançamentos e acessos) |

### Requisitos do usuário do serviço

| API | Web | Requisito |
|:---:|:---:|:--------- |
|  -  |  -  | O usuário faz lançamentos nas contas de: despesa, receita ou pagamento que são recorrentes, de modo a criar uma agenda. |
|  -  |  -  | Os lançamentos agendados não alteram os saldos das contas enquanto não forem concretizados. |
