<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel">
    </a>
</p>

# AchouLar

Plataforma de gestão imobiliária com cadastro de imóveis, leads, contratos, pagamentos e controle de acesso RBAC — construída com Laravel 12 + Inertia + Vue 3.

## Stack

| Camada | Tecnologia | Versão |
|--------|-----------|--------|
| Backend | Laravel | 12.x |
| Frontend | Inertia + Vue 3 | v3 |
| CSS | Tailwind CSS + DaisyUI | v4 / v5 |
| Banco | MySQL | — |
| Tempo real | Laravel Reverb + Echo | v1.10 |
| Auditing | owen-it/laravel-auditing | v14 |
| RBAC | spatie/laravel-permission | v7 |
| Build | Vite | v7 |

## Funcionalidades

### Imóveis
- Cadastro completo com categorias, tipo de negócio (venda/alugação/temporada)
- Upload de fotos com drag & drop, reordenação e lightbox
- Documentos anexados por imóvel
- Controle de status: ativo, vendido, alugado, inativo
- Soft delete
- Contagem de visualizações
- Destaque e aprovação

### Leads / Propostas
- Captura de leads por imóvel com tipo de proposta (comprar/alugar)
- Notificações em tempo real via WebSocket (Reverb)

### Contratos e Pagamentos
- Geração de contrato com upload de arquivo
- Controle de pagamentos com parcelas, vencimentos e utilidades (água, energia, internet)

### Empresas
- Cadastro com CNPJ, planos (gratuito, starter, pro, business)
- Associação de usuários por empresa

### RBAC (Controle de Acesso)
- Roles: `admin`, `manager`, `user`
- 16 permissões granulares cobrindo usuários, funções, permissões, auditoria, dashboard, empresas, imóveis e leads
- Interface de gerenciamento de roles e permissões

### Auditoria
- Rastreamento completo de alterações em entidades principais (usuários, imóveis, leads, empresas, etc.)
- Histórico com valores antigos e novos, IP, user agent

### Painel Administrativo
- Dashboard com métricas (usuários, funções, permissões, auditorias)
- CRUD completo para imóveis, usuários, funções, empresas
- Gerenciamento de leads com marcação de lido/não lido
- Visualização de auditoria

### Tempo Real (Reverb)
- Notificações instantâneas de novos leads
- Canais privados por usuário
- Integração com Laravel Echo + Pusher protocol

## Pré-requisitos

- PHP ^8.2
- Composer
- Node.js ^20.19
- MySQL
- Redis (opcional, para scaling do Reverb)

## Instalação

```bash
# Clone o repositório
git clone <url-do-repo> achoular
cd achoular

# Instalar dependências PHP
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar banco no .env e então:
php artisan migrate

# Instalar dependências frontend
npm install

# Build de produção
npm run build
```

## Desenvolvimento

```bash
# Terminal 1 — Servidor Laravel
php artisan serve

# Terminal 2 — WebSocket (Reverb)
php artisan reverb:start --debug

# Terminal 3 — Vite (hot reload)
npm run dev
```

Ou use o comando all-in-one:

```bash
composer run dev
```

## Estrutura de Diretórios

```
app/
├── Enums/            # RoleEnum, PermissionEnum
├── Events/           # NewLeadReceived (broadcast Reverb)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/    # Dashboard, User, Role, Permission,
│   │   │             # Audit, Company, Lead, Contrato, Pagamento
│   │   ├── AuthController
│   │   ├── ImovelController
│   │   └── LeadController
│   └── Middleware/
├── Models/           # User, Imovel, Lead, Categoria, TipoNegocio,
│                     # Company, Contrato, Pagamento, Foto, Favorito, Documento
└── Providers/
resources/
├── js/
│   ├── Components/   # PropostaForm
│   ├── Pages/        # Leadpage, Auth/*, Imovel/*, Admin/*
│   ├── Layouts/      # Admin, Guest
│   ├── composables/
│   ├── echo.js       # Laravel Echo (WebSocket client)
│   ├── app.js
│   └── bootstrap.js
├── css/
│   └── app.css
└── views/
    └── app.blade.php
routes/
├── web.php
├── channels.php      # Canais de broadcast (Reverb)
└── console.php
```

## Testes

```bash
# Executar testes
php artisan test

# Com filtro
php artisan test --filter=testName
```

## Formatação de Código

```bash
./vendor/bin/pint
```

## Licença

MIT
