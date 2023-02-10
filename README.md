# Pacientes - CRUD com autenticação GitHub OAuth

Este projeto é um sistema de gerenciamento de pacientes que permite adicionar, editar, excluir e visualizar pacientes, além de permitir a autenticação através da API de autenticação do GitHub OAuth. O projeto foi desenvolvido utilizando PHP e armazena as informações em um banco de dados MySQL.
<br><br>

### Requisitos
Antes de começar a utilizar o projeto, você precisará ter o seguinte instalado em sua máquina:

<ul>
    <li>Servidor web (Recomendado Apache)</li>
    <li>PHP 7.0 ou superior</li>
    <li>Banco de dados MySQL</li>
</ul>
É recomendado a utilização do software XAMPP que já inclui todas as instalações descritas.
<br><br>

### Instalação
1. Clone o projeto do GitHub:

~~~bash
git clone https://github.com/BrunoMoises/pacientes.git
~~~~

2. Crie um banco de dados MySQL e rode o script inserido no arquivo `App/Docs/criacao_banco.txt` incluído no projeto.

3. Se necessário configure as informações de acesso ao banco de dados no arquivo `App/Model/PacienteModel.php`.

4. Configure o seu servidor web para apontar para o diretório raiz do projeto.

5. Acesse o sistema no navegador usando o endereço `http://seu-dominio.com` (Se utilizado o XAMPP basta acessar `http://localhost/pacientes`).
<br><br>

### Utilização

Ao acessar o sistema, você será direcionado para a página de autenticação. Clique no botão `Logue no GitHub` para autenticar-se através da API de autenticação do GitHub.

Após a autenticação, você será direcionado para a página inicial do sistema onde poderá adicionar, editar, excluir e visualizar pacientes.

### Conclusão
Este projeto é uma boa opção para quem precisa de um sistema de gerenciamento de pacientes simples e rápido de configurar, além de oferecer a opção de autenticação através da API de autenticação do GitHub.

Se tiver alguma dúvida ou precisar de ajuda, por favor, não hesite em abrir uma issue no GitHub.