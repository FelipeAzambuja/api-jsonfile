## API REST 

Este sistema é a segunda parte do exame de admissão da Sennit. É uma API REST, escrita em Laravel, que fornece algumas funcionalidades básicas para realizar um CRUD e salvar os dados em arquivo JSON.


## Instalação 

No console, execute os seguintes comandos:

``git clone https://github.com/giusampaio/api-jsonfile.git``

``composer install``

``cp -a .env.example .env``

``php artisan key:generate``

``php artisan serve`` 


## Tabela de funções

Abaixo está os nomes das funções, nomes dos campos, método de envio e sua descrição.

Função           |  Descrição                     | Método       | Entrada   
-----------------|--------------------------------|--------------|-----------
api/usuario      | Lista usuários cadastrados     |  GET         |
api/usuario      | Salva um usuário               |  POST        | nome: string, email: string
api/usuario/{id} | Atualiza um usuário            |  PUT/PATCH   | nome: string, email: string
api/usuario/{id} | Retorna o dado de um usuário   |  GET         | 
api/usuario/{id} | Retorna o dado de um usuário   |  DELETE      | 


## Notas importantes

* A API utiliza autenticação Basic Auth que é passado no header da requisição
* O username é ``api`` e a senha ``123`` 
