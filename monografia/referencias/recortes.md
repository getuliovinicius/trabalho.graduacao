# [arquitetura de software - Documentação no inicio de um projeto trabalhando sozinho](https://pt.stackoverflow.com/questions/53491/documenta%C3%A7%C3%A3o-no-inicio-de-um-projeto-trabalhando-sozinho)

1. Quais documentos são realmente indispensáveis pensando não só no inicio do desenvolvimento mas no futuro do projeto?

2. documentação da engenharia de software

3. Há quem escreva documentação visando até mesmo que outras equipes assumam o sistema no futuro e se beneficiem desta documentação.

4. Lean, é fundamental eliminar todo o desperdício.

5. você só deveria escrever os documentos que agregam valor para o cliente.

6. Manifesto Agil: Valorizamos mais software funcionando do que documentação abrangente.

7. A quem este documento tem o objetivo de ajudar?

8. Alguém vai ler este documento?

9. Escrever ajuda a estruturar as idéias e a fazer descobertas.

10. A orientação a objetos nada mais é do que uma "forma de pensar" a respeito de como a representação do problema e a execução da solução (pelo computador) devem ser realizadas.

11. Construir o entendimento por meio de casos de uso: Aliás, o UML é apenas uma linguagem formal (como inglês ou notação musical) que auxilia na comunicação. Como os clientes dos nossos projetos não têm a nossa formação técnica, a comunicação com eles precisa ser a mais simples possível. Não é a toa que os diagramas de caso de uso são praticamente infantis, isto é, usam bolinhas, homenzinhos de palito e setinhas para comunicar esse tipo de informação.

12. O Diagrama de Classes, porém, é muito mais ligado à abordagem orientada a objetos porque ele literamente descreve as classes que o sistema utilizará para solucionar o problema.

13. é uma boa prática você utilizar algum formalismo para descrever e documentar ao menos o entendimento do problema

14. Como outros colegas já comentaram, é sabido que o custo de manutenção é consideravelmente mais alto posteriormente, e isso é especialmente complicado caso você perceba apenas tardiamente que construiu algo que era desnecessário ou, pior, que não atende às necessidades.

# Daring Fireball

Markdown is a text-to-HTML conversion tool for web writers. Markdown allows you to write using an easy-to-read, easy-to-write plain text format, then convert it to structurally valid XHTML (or HTML).

Thus, “Markdown” is two things: (1) a plain text formatting syntax; and (2) a software tool, written in Perl, that converts the plain text formatting to HTML. See the Syntax page for details pertaining to Markdown’s formatting syntax. You can try it out, right now, using the online Dingus.

Markdown é uma ferramenta de conversão de texto para HTML para escritores web. O Markdown permite que você escreva usando um formato de texto simples easy-to-read, fácil de escrever e, em seguida, converta-o para XHTML (ou HTML) estruturalmente válido.

Assim, "Markdown" é duas coisas: (1) uma sintaxe de formatação de texto simples; e (2) uma ferramenta de software, escrita em Perl, que converte a formatação de texto simples para HTML. Consulte a página Sintaxe para obter detalhes sobre a sintaxe de formatação do Markdown. Você pode experimentá-lo, agora, usando o Dingus online.

A principal vantagem de usar um computador para escrever é o imediatismo da edição. Escreva, leia, revise, tudo na mesma janela, tudo no mesmo modo.

Aqui está uma pergunta: quando foi a última vez que você ouviu um argumento, e com base nesse argumento, mudou de idéia? Não apenas sobre algo que você realmente não pensou muito, mas algo que, antes de considerar o argumento em questão, sentiu-se bastante certo em relação à sua posição original.

Em outras palavras, quando foi a última vez que percebeu que estava completamente errado em uma questão de opinião?

Se a sua resposta é "nunca", ou mesmo "há muito tempo", é porque você está sempre certo?

A principal vantagem de usar um computador para escrever é o imediatismo da edição. Escreva, leia, revise, tudo na mesma janela, tudo no mesmo modo.

Mas há uma razão pela qual navegadores de texto simples como o Lynx não mostram apenas o código-fonte HTML em bruto. Simplesmente não é para ser um formato legível. Não lhe parece estranho escrever em um formato que não é legível? De repente, me pareceu absurdo.

Escreva no BBEdit.
Visualizar em um navegador.
Volte para BBEdit para revisões.
Repita até terminar.
Faça login no MT, cole o artigo, publique.

A sintaxe do Markdown destina-se a um propósito: ser usado como um formato para escrever para a web.

# Manifesto Ágil

Indivíduos e interações mais que processos e ferramentas
Software em funcionamento mais que documentação abrangentes

O princípio das linguagens de marcação leve (
lightweight markup languages
) é
que os textos sejam fáceis de serem digitados e lidos por humanos.


1 INTRODUÇÃO	14
2 REFERENCIAL TEÓRICO
2.1 DOCUMENTAÇÃO DE SOFTWARE
2.1.1 Documentação do Projeto de Desenvolvimento de Software
2.1.2 Documentação do Software para Usuários Finais
2.2 ENGENHARIA DE SOFTWARE
2.2.1 Metodologias
2.2.2 Ferramentas
2.3 QUALIDADE DE SOFTWARE
2.4 LINGUAGEM MARKDOWN
2.4.1 Linguagem de marcação leve
2.4.2 Arquivos Markdown
2.4.3 Sintaxe
2.4.4 Parser
2.4.5 Padronização das especificações
2.4.6 Tecnologia da Informação e Comunicação
2.4.7 Arquitetura de Sistemas de Informação
2.4.8 Vantagens e Desvantagens da Linguagem Markdown
3 PROJETO DE SOFTWARE	46
4 IMPLEMENTAÇÃO	47
5 TESTES	48
6 IMPLANTAÇÃO	49
7 RESULTADO	50
CONCLUSÃO	51
REFERÊNCIAS	52


Em geral, os engenheiros de software adotam uma abordagem sistemática e organizada para seu trabalho, pois essa costuma ser a maneira mais eficiente de produzir software de alta qualidade. No entanto, engenharia tem tudo a ver com selecionar o método mais adequado para um conjunto de circunstâncias, então uma abordagem mais criativa e menos formal pode ser eficiente em algumas circunstâncias. Desenvolvimento menos formal é particularmente adequado para o desenvolvimento de sistemas Web, que requerem uma mistura de habilidades de software e de projeto. Engenharia de software é importante por dois motivos: 1. Cada vez mais, indivíduos e sociedades dependem dos sistemas de software avançados. Temos de ser capazes de produzir sistemas confiáveis econômica e rapidamente. 2. Geralmente é mais barato, a longo prazo, usar métodos e técnicas da engenharia de software para sistemas de software, em vez de simplesmente escrever os programas como se fossem algum projeto pessoal. Para a maioria dos sistemas, a maior parte do custo é mudar o software depois que ele começa a ser usado.


Engenharia de software é uma abordagem sistemática para a produção de software; ela analisa questões práticas de custo, prazo e confiança, assim como as necessidades dos clientes e produtores do software. A forma como essa abordagem sistemática é realmente implementada varia dramaticamente de acordo com a organização que esteja desenvolvendo o software, o tipo de software e as pessoas envolvidas no processo de desenvolvimento. Não existem técnicas e métodos universais na engenharia de software adequados a todos os sistemas e todas as empresas. Em vez disso, um conjunto diverso de métodos e ferramentas de engenharia de software tem evoluído nos últimos 50 anos.

Entenderemos como qualidade de um produto o seu grau de conformidade com os respectivos requisitos.

Em um produto de software de má qualidade, muitos requisitos não são atendidos completamente.

Os requisitos são as características que definem os critérios de aceitação de um produto.


Um projeto de software é uma descrição da estrutura do software a ser implementado, dos modelos e estru-
turas de dados usados pelo sistema, das interfaces entre os componentes do sistema e, às vezes, dos algoritmos
usados.

Quando eu converso com as pessoas percebo que estou falando de forma dissertativa argumentativa. Maldito TG.

http://www.dsc.ufcg.edu.br/~jacques/cursos/map/html/frame/oque.htm

O principal objetivo do BPMN é fornecer uma notação que seja facilmente compreensível por todos os usuários empresariais, do negócio
analistas que criam os rascunhos iniciais dos processos, aos desenvolvedores técnicos responsáveis pela implementação do
tecnologia que irá realizar esses processos e, finalmente, para os empresários que gerenciarão e monitorarão aqueles
processos.

----------------------

Exemplo de requisitos para o sistema de software de bomba de insulina.
3.2 O sistema deve medir o açúcar no sangue e fornecer insulina, se necessário, a cada dez minutos. (Mudanças de açúcar no sangue são
relativamente lentas, portanto, medições mais frequentes são desnecessárias; medições menos frequentes podem levar a níveis de açúcar
desnecessariamente elevados.)
3.6 O sistema deve, a cada minuto, executar uma rotina de autoteste com as condições a serem testadas e as ações associadas definidas na
Quadro 4.3 (A rotina de autoteste pode descobrir problemas de hardware e software e pode alertar o usuário para a impossibilidade de operar
normalmente.)

---------------------------

Tem como objetivo principal validar os requisitos, abordar questões de interface, e avaliar tanto a viabilidade quanto a complexidade do sistema.


Para exibir um bloco de código em HTML pode-se utilizar as tags `<pre>` e `<code>`.

Abaixo um trecho de código em bloco:

    <h1>Exemplo de exibição de código</h1>

    <div>
        <p>Um parágrafo</p>
    </div>

    <a href="www.um-site-de-exemplo.com">Um link de exemplo</a>


Pando - a universal document converter

About pandoc

John MacFarlane

Um documento com formatação do Markdown deve ser publicado como é, como texto sem formatação, sem parecer que tenha sido marcado com tags ou instruções de formatação.

https://michelf.ca/projects/php-markdown/

https://python-markdown.github.io/

Python-Markdown

2017

The Python-Markdown Project



    Waylan Limberg

    Waylan is the current maintainer of the code and has written much of the current code base, included a complete refactor of the core. He started out by authoring many of the available extensions and later was asked to join Yuri, where he began fixing numerous bugs, adding documentation and making general improvements to the existing code base.

    Yuri Takteyev

    Yuri wrote most of the code found in version 1.x while procrastinating his Ph.D. Various pieces of his code still exist, most notably the basic structure.

    Manfed Stienstra

    Manfed wrote the original version of the script and is responsible for various parts of the existing code base.

    Artem Yunusov

    Artem, who as part of a 2008 GSoC project, refactored inline patterns, replaced the NanoDOM with ElementTree support and made various other improvements.

    David Wolever

    David refactored the extension API and made other improvements as he helped to integrate Markdown into Dr.Project.


https://kramdown.gettalong.org/

Thomas Leitner  

kramdown

http://johnmacfarlane.net/babelmark2/

Babelmark 2

John MacFarlane

http://spec.commonmark.org/0.28/

CommonMark Spec

uma especificação de sintaxe padrão e inequívoca para o Markdown, juntamente com um conjunto de testes abrangentes para validar as implementações do Markdown contra esta especificação.

Este documento registra o tipo de mídia de texto / markdown para uso com
    Markdown, uma família de sintaxe de formatação de texto simples que, opcionalmente,
    podem ser convertidos em linguagens de marcação formal, como HTML.

    Internet Engineering Task Force (IETF)

https://www.ietf.org/about/

About

Sean Leonard

Internet Engineering Task Force (IETF)                        S. Leonard
Request for Comments: 7763                                 Penango, Inc.
Category: Informational                                       March 2016
ISSN: 2070-1721

The text/markdown Media Type

https://tools.ietf.org/html/rfc7763

Internet Engineering Task Force (IETF)                        S. Leonard
Request for Comments: 7764                                 Penango, Inc.
Category: Informational                                       March 2016
ISSN: 2070-1721


                         Guidance on Markdown:
  Design Philosophies, Stability Strategies, and Select Registrations

  Markdown especificamente é uma família de sintagmas que se baseiam no
   trabalho original de John Gruber com contribuições substanciais de
   Aaron Swartz, lançado em 2004 [ MARKDOWN ]. Desde a sua liberação, uma
   série de aplicações web ou voltadas para a web incorporaram o Markdown
   em seus sistemas de entrada de texto, com freqüência com extensões personalizadas.
   Com a complexidade e as dificuldades de segurança das

# Linguagens de programação

| ID | Linguagem | Site |
| -- | --------- | ---- |
| 1 | PHP | http://www.php.net |
| 2 | Python | https://www.python.org |
| 3 | Javascript | |
| 4 | Ruby | https://www.ruby-lang.org |


<h1>Linguagens de programação</h1>

<table>
<thead>
<tr>
  <th align="center">ID</th>
  <th align="left">Linguagem</th>
  <th align="right">Site</th>
</tr>
</thead>
<tbody>
<tr>
  <td align="center">1</td>
  <td align="left">PHP</td>
  <td align="right">http://www.php.net</td>
</tr>
<tr>
  <td align="center">2</td>
  <td align="left">Python</td>
  <td align="right">https://www.python.org</td>
</tr>
<tr>
  <td align="center">3</td>
  <td align="left">Javascript</td>
  <td align="right"></td>
</tr>
<tr>
  <td align="center">4</td>
  <td align="left">Ruby</td>
  <td align="right">https://www.ruby-lang.org</td>
</tr>
</tbody>
</table>

Wikitexto

https://pt.wikipedia.org/wiki/Wikitexto

Esta página foi editada pela última vez à(s) 23h26min de 19 de agosto de 2017.


1. Fazer o download do instalador do gerenciador de pacotes "pip".

$ wget https://bootstrap.pypa.io/get-pip.py

2. Instalar o gerenciador de pacotes "pip".

$ sudo python get-pip.py

3. Instalar o pacote "virtualenv".

$ sudo pip install virtualenv

4. Instalar o pacote "virtualenvwrapper".

$ sudo pip install virtualenvwrapper

5.Editar o arquivo ".bashrc" na localizado no diretório "home" do usuário atual e adicionar as linhas abaixo no final do arquivo.

# Virtualenvwrapper
export WORKON_HOME=~/.virtualenvs
source /usr/local/bin/virtualenvwrapper.sh
export PIP_REQUIRE_VIRTUALENV=true

6. Recarregar as configurações do "bash".

$ source ~/.bashrc

7. Criar um diretório para armazenar os arquivos do projeto com "MkDocs".

$ mkdir -p ~/teste-mkdocs

8. Criar um ambiente virtual Python para execução do "MkDocs"

$ mkvirtualenv docs

9. Ativar o uso do ambiente virtual Python.

$ workon docs_mkdocs

10. Instalar o "MkDocs".

$ pip install mkdocs

11. Iniciar um projeto com "MkDocs".

$ mkdocs new .
