## 📌 Nome do Projeto
**weather-app**

## 🌤️ Descrição
Aplicação desenvolvida com **PHP + Laravel** que permite consultar informações climáticas de cidades brasileiras utilizando a **API do OpenWeatherMap**.

---

## ⚙️ Tecnologias Utilizadas

- **Laravel 10**: Framework PHP para construção da aplicação web.
- **HTTP Client (Illuminate\Support\Facades\Http)**: Utilizado para consumir a API externa.
- **OpenWeatherMap API**: Fonte dos dados meteorológicos em tempo real.

---

## 🛠️ Como foi construído

- Projeto foi criado com um formulário para entrada do nome da cidade.
- O controller realiza a requisição à API do OpenWeatherMap com base no nome da cidade informada.
- Os dados são exibidos na mesma página, com tratamento visual de erros (ex: cidade não encontrada).
- Código limpo com validação de entrada e tratamento de possíveis falhas de requisição.

---

## ▶️ Como rodar

1. Clone o repositório ou copie os arquivos do projeto.
2. Renomeie o arquivo **.env.example** para apenas **.env**
3. digite o seguinte comando:"
    ```bash
    cd maykon-weather-app
4. Instale as dependências com:
    ```bash
   composer install
5. Execute o comando abaixo para iniciar o projeto:
    ```bash
    php artisan serve
6. Acesse no navegador:

    http://localhost:8000