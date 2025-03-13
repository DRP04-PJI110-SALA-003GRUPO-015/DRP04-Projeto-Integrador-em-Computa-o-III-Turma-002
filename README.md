# Sistema de Agendamento Médico

Sistema web moderno para agendamento de consultas médicas, desenvolvido com Laravel, Vue.js e tecnologias cloud.

## Características

- 🏥 Agendamento online de consultas
- 👨‍⚕️ Gestão de médicos e especialidades
- 📊 Análise de dados e previsões
- 🔒 API RESTful segura
- 📱 Interface responsiva
- 🌐 Hospedagem na nuvem (AWS)
- 🔄 CI/CD com GitHub Actions
- 🧪 Testes automatizados
- ♿ Acessibilidade WCAG 2.1

## Requisitos

- PHP 8.2+
- MySQL 8.0+
- Node.js 16+
- Docker e Docker Compose
- Composer
- NPM ou Yarn

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/clinica-medica.git
cd clinica-medica
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Instale as dependências do Node.js:
```bash
npm install
```

4. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```

5. Inicie os containers Docker:
```bash
docker-compose up -d
```

6. Execute as migrações do banco de dados:
```bash
php artisan migrate
```

7. Compile os assets:
```bash
npm run dev
```

## Desenvolvimento

Para iniciar o ambiente de desenvolvimento:

```bash
# Iniciar os containers
docker-compose up -d

# Executar as migrações
php artisan migrate

# Iniciar o servidor de desenvolvimento
php artisan serve

# Em outro terminal, compilar os assets
npm run dev
```

## Testes

Execute os testes automatizados:

```bash
# Testes unitários
php artisan test

# Testes com cobertura
php artisan test --coverage-html coverage
```

## API

A API está disponível em `/api`. Documentação completa disponível em `/api/documentation`.

Endpoints principais:
- `GET /api/appointments` - Lista todos os agendamentos
- `POST /api/appointments` - Cria um novo agendamento
- `GET /api/appointments/analytics` - Obtém análises e previsões
- `GET /api/appointments/search` - Busca agendamentos

## Deploy

O sistema está configurado para deploy automático na AWS através do GitHub Actions.

1. Configure as secrets no GitHub:
   - `AWS_ACCESS_KEY_ID`
   - `AWS_SECRET_ACCESS_KEY`
   - `AWS_DEFAULT_REGION`

2. Push para a branch `main` para iniciar o deploy:
```bash
git push origin main
```

## Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE.md](LICENSE.md) para detalhes.

## Contato

Seu Nome - [@seutwitter](https://twitter.com/seutwitter) - email@exemplo.com

Link do Projeto: [https://github.com/seu-usuario/clinica-medica](https://github.com/seu-usuario/clinica-medica)
