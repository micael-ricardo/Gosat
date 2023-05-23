# Instruções de Execução
Siga os passos abaixo para executar o projeto Laravel/Lumen em seu ambiente local.

## Pré-requisitos
Certifique-se de ter as seguintes ferramentas instaladas em seu sistema:<br>

PHP (versão 8.2.4)<br>
Composer (versão 2.5.4)<br>
Servidor Web (Apache, mariadb)<br>

## Passos
Clone este repositório em seu ambiente local:<br>
git clone https://github.com/micael-ricardo/Gosat.git

Navegue até o diretório do projeto:<br>
cd Gosat

Instale as dependências do projeto usando o Composer:<br>
composer install

Copie o arquivo de configuração .env.example para .env:<br>
cp .env.example .env

Execute as migrações do banco de dados para criar as tabelas:<br>
php artisan migrate

Inicie o servidor local:<br>
php -S localhost:8000 -t public

Abra o navegador da web e acesse o endereço: http://localhost:8000/   para visualizar o aplicativo.

## Para realizar o teste no navegador 
Insira os cpf fornecidos pelo desafio clique no botão consultar e aparecera.  3 ofertas de crédito ordenadas da mais vantajosa
a menos vantajosa contendo as seguintes informações:
o instituicaoFinanceira
o modalidadeCredito
o valorAPagar
o valorSolicitado
o taxaJuros
o qntParcelas

Para vê detalhe da oferta é só clicar no card que vai abrir um modal com os detalhes.






