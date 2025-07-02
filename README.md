# 📚 Sistema de Biblioteca - LYBRIS  

**Repositório Público:** [GitHub Repository Link] (substitua pelo link real)  

---

## 🚀 **Descrição do Projeto**  
O **LYBRIS** é um sistema de gestão de bibliotecas que automatiza empréstimos, reservas e controle de usuários, com:  
- **Regras de negócio**: Multas por atraso, bloqueio automático por baixa credibilidade, prazos diferenciados (24h/48h).  
- **Controle de acesso**: RBAC (usuário comum × administrador).  
- **Modelagem UML**: Diagramas de Casos de Uso, Classes e Sequência para documentação clara.  

**Telas do Sistema:** 
- Home 
- Tela de Login/Cadastro
- Página inicial com livros 
- Cadastrar Livro
- Painel de reservas (usuário)  
- Painel administrativo (gerenciar empréstimos)  

---

## 🛠 **Tecnologias Utilizadas**  
| Área           | Tecnologias                                                                 |  
|----------------|-----------------------------------------------------------------------------|  
| **Backend**    | PHP 8.2, Laravel 11, MySQL                                                  |  
| **Frontend**   | HTML/CSS, Bootstrap, JavaScript                                             |  
| **Ferramentas**| PlantUML (diagramas), Draw.io (fluxos), Git (controle de versão)            |  

---

## 📋 **Instruções de Execução**  

### **Pré-requisitos**  
- PHP 8.2+  
- Composer  
- MySQL 5.7+  

### **Passo a Passo**  
```bash
# 1. Clone o repositório
git clone [URL_DO_REPOSITÓRIO]

# 2. Instale as dependências
composer install

# 3. Configure o .env (copie o .env.example)
cp .env.example .env

# 4. Gere a chave do Laravel
php artisan key:generate

# 5. Execute as migrações e seeds
php artisan migrate --seed

# 6. Inicie o servidor
php artisan serve

# 7. Inicie o npm run
npm install
npm run 
```

**Acesse:** `http://localhost:8000`  
**Credenciais de teste:**  
- Usuário comum: `usuario@teste.com` / `senha123`  
- Admin: `admin@teste.com` / `admin123`  

---

## 📂 **Organização do Projeto**  

### **Casos de Uso**  
| Funcionalidade               | Descrição                                      | Arquivo/Documento          |  
|------------------------------|-----------------------------------------------|----------------------------|  
| Realizar Reserva             | Usuário reserva livro disponível              | `docs/use-cases/reserva.md`|  
| Aplicar Multas Automáticas   | Sistema penaliza atrasos                      | `app/Console/ApplyFine.php`|  
| Bloquear Usuários            | Bloqueio por credibilidade ≤ 0                | `app/Console/BlockUsers.php`|  

### **Modelos (Diagramas UML)**  
| Diagrama           | Link/Ficheiro                          |  
|--------------------|----------------------------------------|  
| **Casos de Uso**   | `docs/diagrams/use-case.puml`         |  
| **Classes**        | `docs/diagrams/class-diagram.mmd`     |  
| **Sequência**      | `docs/diagrams/sequence-diagram.puml` |  

---

## 📬 **Contribuição**  
1. Faça um fork do projeto  
2. Crie uma branch (`git checkout -b feature/nova-funcionalidade`)  
3. Commit suas alterações  
4. Push para a branch (`git push origin feature/nova-funcionalidade`)  
5. Abra um **Pull Request**  

---

## 📄 **Licença**  
MIT License - Consulte o arquivo [LICENSE](LICENSE) para detalhes.  

