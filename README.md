### Como subir o projeto localmente

- Primeiro passo é clonar o repositorio para seu computador utilizando o comando abaixo
  ```
  git clone git@github.com:vsLazaro/csw24-groupf-ticket4all-laravel.git
  ```
- Após isso acesse o diretório do repositório e garanta de ter Docker instalado em sua máquina
- Com isso rode o seguinte comando na raiz do repositório
  ```
  docker compose up -d --build
  ```
- Assim ao final subirá 2 containers, um destinado ao banco de dados e o outro da aplicação que irá rodar em localhost:3000 de sua máquina
- Mas antes é necessário rodar as migrations para criar as tabelas no banco de dados
- Para isso liste os containers com o comando abaix
  ```
  docker ps
  ```
- Pegue o ID do container que é chamado laravel-service e rode o seguinte comando
  ```
  docker exec -it {id-do-container} bash
  ```
- Assim irá entrar dentro do container, ai basta executar as migrations com o comando
  ```
  php artisan migrate
  ```
- A aplicação estará rodando normalmente no caminho localhost:3000/api
- Documentação em localhost:3000/api/documentation