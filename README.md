# Instruções de Execução
Siga os passos abaixo para executar o projeto Laravel/Lumen em seu ambiente local.

## Pré-requisitos
Certifique-se de ter as seguintes ferramentas instaladas em seu sistema:

PHP (versão 8.2.4)
Composer (versão 2.5.4)
Servidor Web (Apache, mariadb)

## Passos
Clone este repositório em seu ambiente local:
git clone https://github.com/micael-ricardo/Gosat.git

Navegue até o diretório do projeto:
cd Gosat

Instale as dependências do projeto usando o Composer:
composer install

Copie o arquivo de configuração .env.example para .env:
cp .env.example .env

Execute as migrações do banco de dados para criar as tabelas:
php artisan migrate

Inicie o servidor local:
php -S localhost:8000 -t public

Abra o navegador da web e acesse o endereço fornecido acima para visualizar o aplicativo.

## Para realizar o teste no navegador 
Insira os cpf fornecidos pelo desafio clique no botão consultar e aparecera:  3 ofertas de crédito ordenadas da mais vantajosa
a menos vantajosa contendo as seguintes informações:
o instituicaoFinanceira
o modalidadeCredito
o valorAPagar
o valorSolicitado
o taxaJuros
o qntParcelas

Para vê detalhe da oferta é só clicar no card que vai abrir um modal com os detalhes.






