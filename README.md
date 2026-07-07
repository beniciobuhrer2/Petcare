# PetCare 

Sistema web para gerenciamento de uma clínica veterinária, desenvolvido como Projeto Integrador.

## Sobre o projeto

O PetCare permite o cadastro de usuários, pets e consultas veterinárias.  
O sistema possui controle de acesso, separando a área do administrador e a área do cliente.

## Funcionalidades

- Cadastro e login de usuários
- Controle de acesso entre admin e cliente
- CRUD de usuários
- CRUD de pets
- CRUD de consultas
- Cliente pode cadastrar seus próprios pets
- Cliente pode agendar e cancelar consultas
- Admin pode gerenciar consultas e alterar status
- Validação de data, horário e campos obrigatórios
- Integração com banco de dados MySQL

## Tecnologias utilizadas

- HTML
- CSS
- PHP
- MySQL

## Banco de dados

O projeto utiliza o banco `vetclinica`.

As principais tabelas são:

- `usuarios`
- `animais`
- `consultas`

## Como executar

1. Clone o repositório
2. Coloque o projeto na pasta do servidor local, como `htdocs`
3. Importe o arquivo `database.sql` no MySQL
4. Configure a conexão no arquivo `config/db.php`
5. Acesse o projeto pelo navegador

## Autor

Desenvolvido por Benício Buhrer de Lima.
