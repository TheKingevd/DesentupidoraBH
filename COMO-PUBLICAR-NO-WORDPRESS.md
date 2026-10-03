# Como colocar a landing page no WordPress

Landing page em **HTML puro** (sem React, sem painel admin, sem banco de dados).
Ela roda como um **modelo de página do tema**, então funciona em qualquer WordPress.

---

## 1. O que tem nesta pasta

| Arquivo | Para que serve |
|---|---|
| `page-landing.php` | **O principal.** É o template que você copia pro tema. Todos os IDs de rastreamento ficam nas variáveis no topo do arquivo. |
| `landing.css` | O visual da página. Vai na mesma pasta do tema. |
| `assets/desentupidora-logo.png` | O logotipo usado no cabeçalho, no selo do hero e no rodapé. |
| `assets/desentupidora-favicon.svg` | O ícone da aba do navegador. É o que vale no Chrome, Edge, Firefox e Safari atuais. |
| `assets/desentupidora-favicon.ico` | O mesmo ícone em `.ico`, para navegadores antigos e atalhos do Windows. |
| `assets/desentupidora-favicon-256.png` | Ícone do atalho no celular. O iPhone **não aceita** `.ico`, precisa de PNG. |
| `preview.html` | Só para você **conferir o visual** abrindo no navegador (`duplo clique`). Não vai pro servidor. |
| `robots.txt` | Vai para a **raiz do site** (`public_html/`), não pro tema. Regras de rastreamento + onde está o sitemap. |
| `sitemap.xml` | Vai para a **raiz do site** (`public_html/`), não pro tema. Lista das páginas que o Google deve indexar. |

---

## 2. Passo a passo (o caminho recomendado)

### Passo 1 — Descubra o nome do tema

No painel do WordPress: **Aparência → Temas**. Anote o nome da pasta do tema ativo
(ex.: `astra`, `hello-elementor`, `twentytwentyfour`).

> **Dica:** se o tema já está sendo usado e você não quer sofrer em atualização,
> crie um **tema filho** e jogue os arquivos nele. Se não sabe fazer isso, siga
> com o tema principal mesmo — o pior que pode acontecer é você ter que subir de
> novo depois de atualizar o tema.

### Passo 2 — Suba os arquivos para o servidor

Os arquivos vão na **raiz do tema**, todos soltos na mesma pasta:

```
wp-content/themes/SEU-TEMA/page-landing.php
wp-content/themes/SEU-TEMA/landing.css
wp-content/themes/SEU-TEMA/desentupidora-logo.png
wp-content/themes/SEU-TEMA/desentupidora-favicon.svg
wp-content/themes/SEU-TEMA/desentupidora-favicon.ico
wp-content/themes/SEU-TEMA/desentupidora-favicon-256.png
```

> A pasta `assets/` aqui do projeto é só para organizar os arquivos. Na hora de subir,
> jogue os três arquivos do favicon **na mesma pasta do `page-landing.php`** — não crie
> uma subpasta.

Formas de subir, escolha uma:

- **Gerenciador de Arquivos do cPanel/hospedagem** → navegue até
  `public_html/wp-content/themes/SEU-TEMA/` e use o botão *Upload*.
- **FTP (FileZilla)** → conecte com os dados de FTP do cliente e arraste os arquivos.
- **Plugar do WordPress → Plugin "File Manager"** → instale o plugin,
  navegue até a pasta do tema e faça upload.

> ⚠️ Nome do tema com caracteres estranhos? Confira em **Aparência → Temas**
> qual é o *folder* real do tema ativo. Tem que bater exatamente.

### Passo 2.1 — Suba `robots.txt` e `sitemap.xml` na raiz do site

Esses dois são a **exceção**: não vão na pasta do tema. Vão na raiz do site, junto
do `wp-config.php`:

```
public_html/robots.txt
public_html/sitemap.xml
```

São opcionais para o site funcionar, mas obrigatórios para o Google achar e indexar
a página direito. Detalhes na **seção 8**.

### Passo 3 — Crie (ou abra) a página

No painel: **Páginas → Adicionar Nova**.

- Título: `Desentupidora BH 24H`
- **Não precisa escrever nada no conteúdo.** O template ignora o conteúdo da página.

### Passo 4 — Ative o modelo da página

No editor, procure o painel lateral:

- **Editor de blocos:** aba *Página* (ícone de engrenagem no topo) → seção
  **Modelo** → escolha **"Landing Desentupidora (HTML puro)"**.
- **Editor clássico:** caixa **Atributos da página** → *Modelo* →
  **"Landing Desentupidora (HTML puro)"**.

Se o modelo não aparecer na lista:

1. Confirme que o arquivo está na pasta do **tema ativo**.
2. Confirme que o arquivo começa com o comentário
   `Template Name: Landing Desentupidora (HTML puro)`.
3. Limpe o cache (do WordPress, do tema e do servidor/CDN).

### Passo 5 — Publique

Clique em **Publicar** e abra a página. O CSS, o logo e o JavaScript devem funcionar
sozinhos. Se aparecer tudo "cru" (sem estilo), o `landing.css` não foi encontrado —
veja a seção **Problemas comuns**.

---

## 3. Preencher os IDs de rastreamento

Abra o `page-landing.php` (no editor do cPanel ou no plugin File Manager) e vá até a
**seção 1** no topo do arquivo. É aqui que você mexe:

```php
// --- Google -----------------------------
$DBH_TRACKING          = true; // false = desliga TODO o rastreamento
$DBH_GA4_ID            = '';    // GA4        -> G-XXXXXXXXXX
$DBH_GTM_ID            = '';    // Tag Manager -> GTM-XXXXXXX
$DBH_ADS_ID            = '';    // Google Ads -> AW-123456789
$DBH_ADS_LABEL         = '';    // rótulo da conversão do Ads
$DBH_SEARCH_CONSOLE    = '';    // meta google-site-verification

// --- Outros (opcional) ------------------
$DBH_META_PIXEL        = '';    // Facebook Pixel -> 123456789012345
```

### Onde achar cada um

| Variável | Onde pegar | Formato |
|---|---|---|
| `$DBH_GA4_ID` | Google Analytics → **Administrador → Fluxos de dados → seu site** | `G-XXXXXXXXXX` |
| `$DBH_GTM_ID` | Google Tag Manager → canto superior direito (perto do ID do contêiner) | `GTM-XXXXXXX` |
| `$DBH_ADS_ID` | Google Ads → **Ferramentas → Conversões → marcar conversão → "Configurar a tag por conta própria"** | `AW-123456789` |
| `$DBH_ADS_LABEL` | Mesmo lugar, aparece como `AW-123456789/AbC-D_efG` — use **só o que vem depois da barra** | `AbC-D_efGhIjKlMnOp` |
| `$DBH_SEARCH_CONSOLE` | Search Console → **Adicionar propriedade → Método "tag HTML"** → copie só o `content` | `abc123XYZ...` |
| `$DBH_META_PIXEL` | Meta Business → **Fontes de dados → Pixel** | `123456789012345` |

Depois de preencher, **salve o arquivo** (não precisa mexer em nada no WordPress).

### O que já vai rastrear de fábrica

Sem configurar nada além dos IDs:

- **Visualização de página** (GA4 e/ou GTM)
- `whatsapp_click` — clique em qualquer botão de WhatsApp
- `phone_click` — clique em qualquer botão de telefone (inclusive a barra fixa do mobile)
- `scroll_90` — quando o visitante passa de 90% da página
- **Conversão do Google Ads** nos cliques de WhatsApp e telefone (se `$DBH_ADS_ID` e `$DBH_ADS_LABEL` estiverem preenchidos)

### Quer que a conversão do Ads conte só no WhatsApp?

No final do `page-landing.php`, dentro do bloco `document.addEventListener('click', ...)`,
troque a condição da conversão por apenas o WhatsApp:

```js
if (ADS_ID && ADS_LABEL && name === 'whatsapp_click' && typeof window.gtag === 'function') {
```

Assim o telefone continua clicável (e ainda gera o evento `phone_click` no GA4),
mas não conta conversão no Ads.

### Desligar tudo

`$DBH_TRACKING = false;` — nada de script do Google ou Meta é impresso.

---

## 4. Como testar se está funcionando

1. **Google Tag Manager → Visualizar** (Preview): informe a URL da página.
   Você deve ver o GTM carregando e os eventos `whatsapp_click`, `phone_click` e
   `scroll_90` aparecendo conforme você clica e rola.
2. **GA4 → Administrador → DebugView**: mesma coisa, em tempo real.
3. **Extensão "Tag Assistant"** do Chrome: mostra quais tags do Google estão na página.
4. **Google Ads**: converte em até 3h (o Ads não mostra na hora, tenha paciência).

---

## 5. Ajustes do dia a dia (sem mexer no layout)

Tudo fica na **seção 1** do `page-landing.php`:

| Variável | Efeito |
|---|---|
| `$DBH_TELEFONE` | Telefone mostrado no site (texto) |
| `$DBH_WHATSAPP` | Número do link do WhatsApp (só dígitos, com `55` na frente) |
| `$DBH_WHATSAPP_MSG` | Mensagem que já vem escrita quando a pessoa clica |
| `$DBH_TITULO` | Título grande do topo (hero) |
| `$DBH_DESCRICAO` | Texto abaixo do título |
| `$DBH_BLOG_PATH` | Caminho do blog (`/blog`). Deixe `''` para esconder o link "Blog" |
| `$DBH_LOGO` | URL do logo (por padrão usa o arquivo que você subiu junto do tema) |
| `$DBH_HERO_IMAGE` | Foto grande do hero (por padrão é a do Pexels) |

- **Serviços, vantagens, cidades e FAQ** ficam na **seção 2** (`$dbh_servicos`,
  `$dbh_vantagens`, `$dbh_cidades`, `$dbh_sobre`, `$dbh_faq`). É só editar o texto
  entre as aspas simples — cuidado para não apagar as vírgulas.
- **Cores**: tudo em `landing.css`, no bloco `:root`/`.dbh-page` no topo do arquivo.

---

## 6. Plano B — se o tema não deixar usar arquivo PHP

Alguns temas/hospedagens bloquearam edição de arquivos. Nesse caso use um
**bloco de HTML personalizado**:

1. Abra o `preview.html` no navegador e copie **tudo** (Ctrl+A, Ctrl+C).
2. No editor da página, adicione um bloco **"HTML personalizado"**.
3. Cole o conteúdo.
4. Suba o `landing.css` como arquivo (ou cole o CSS dentro de um `<style>` no próprio bloco).
5. Ajuste o caminho do CSS e do logo para a URL completa
   (ex.: `https://SEUSITE.com.br/wp-content/uploads/2026/09/landing.css`).

> Esse caminho funciona, mas o **template PHP é melhor**: é mais leve, não depende
> do editor e não corre risco de o bloco ser reformatado pelo tema.

---

## 7. Problemas comuns

| Sintoma | Causa provável | Solução |
|---|---|---|
| Página aparece sem estilo | `landing.css` não está na mesma pasta do tema, ou cache | Confirme o caminho, limpe cache do WordPress + do servidor/CDN |
| O logo aparece quebrado | `desentupidora-logo.png` não subiu, ou não é a pasta do tema ativo | Suba o arquivo na mesma pasta do `page-landing.php` |
| O modelo não aparece na lista | arquivo não está no tema **ativo**, ou o tema é em pasta diferente | Veja **Aparência → Temas** qual é o *folder* ativo |
| Título gigante cinza/feio no topo | o tema está injetando o próprio cabeçalho | Confirme que escolheu o modelo *"Landing Desentupidora (HTML puro)"* |
| Eventos do Google não aparecem | ID errado ou cache de página | Teste com o GTM Preview e confirme o ID |
| Link "Blog" leva para 404 | `$DBH_BLOG_PATH` errado | Corrija para o caminho real do blog ou deixe `''` |
| Alterei o texto e não mudou | cache da hospedagem ou do plugin de cache | Limpe o cache e force recarregar (Ctrl+F5) |
| Troquei o favicon e continua o antigo | favicon é o arquivo mais "teimoso" do cache | Feche e reabra o navegador; no Chrome, abra a imagem em `/desentupidora-favicon.ico` e dê Ctrl+F5 |
| Favicon aparece só na aba, mas no celular fica um quadrado | o iPhone usa o `apple-touch-icon` (PNG), não o `.ico` | Confirme que o `desentupidora-favicon-256.png` subiu |
| `robots.txt` abre a página do site em vez do texto | arquivo na pasta errada, ou WordPress/plugin assumindo o controle | Confirme que está em `public_html/`; se houver Yoast/Rank Math, use o deles (**seção 8**) |
| `sitemap.xml` dá 404 | não subiu, ou o servidor só serve o `/wp-sitemap.xml` | Suba na raiz; se persistir, aponte o `robots.txt` para `/wp-sitemap.xml` |

---

## 8. `robots.txt` e `sitemap.xml`

### O que cada um faz

- **`robots.txt`** → diz para o Google e o Bing o que pode ser rastreado e onde
  está o sitemap.
- **`sitemap.xml`** → a lista de páginas que devem aparecer na busca.

### ⚠️ Antes de subir: confira o domínio

Os dois arquivos vêm com `https://desentupirbh.com.br`. **Se o domínio do cliente
for outro, troque todas as ocorrências** (abra no Bloco de Notas ou VS Code e use
localizar-e-substituir). URL errada aqui só dá erro silencioso — o Google ignora.

### Depois de subir, avise o Google

1. Abra `https://SEUDOMINIO.com.br/robots.txt` e `.../sitemap.xml` no navegador.
   Tem que aparecer o texto e o XML — se aparecer a página do site ou erro 404,
   o arquivo está no lugar errado ou o servidor está bloqueando.
2. **Search Console → Sitemaps** → digite `sitemap.xml` → **Enviar**.
3. **Search Console → Inspeção de URL** → cole a URL da página → **Testar URL ativa**.
   O resultado esperado é *"A URL pode ser indexada"*.

### Criou uma página nova? Acrescente no sitemap

É só adicionar um bloco `<url>` dentro do `<urlset>`:

```xml
<url>
  <loc>https://SEUDOMINIO.com.br/nova-pagina</loc>
  <lastmod>2026-09-23</lastmod>
  <priority>0.7</priority>
</url>
```

### Se o cliente tiver Yoast, Rank Math ou All in One SEO

Plugins de SEO **já criam** esses dois arquivos — e melhor: atualizados sozinhos.
Nesse caso:

- **Não suba** o `robots.txt` nem o `sitemap.xml` estáticos. O arquivo físico na
  raiz **tem prioridade** e pode atropelar a configuração do plugin.
- Use o sitemap do plugin: Yoast e Rank Math → `/sitemap_index.xml`;
  All in One SEO → `/sitemap.xml`.

Ah, e mesmo **sem plugin nenhum**, o WordPress já gera um sitemap em
`/wp-sitemap.xml`. Se você preferir não manter arquivo estático, deixe o
`robots.txt` só com esta linha apontando para ele:

```
Sitemap: https://SEUDOMINIO.com.br/wp-sitemap.xml
```

A vantagem: ele se atualiza sozinho, já inclui os posts do blog e você nunca mais
precisa lembrar de editar o sitemap quando criar página nova.

---

## 9. Sobre SEO

O template já entrega de fábrica:

- `<title>`, meta description, Open Graph e canonical
- **JSON-LD** de `LocalBusiness` + `Plumber` (endereço, telefone, cidades atendidas, horário 24h)
- **JSON-LD** de `FAQPage` (pode gerar resultado enriquecido no Google)
- `<meta name="robots" content="index, follow...">`
- **favicon** em SVG, `.ico` e `apple-touch-icon`

Sobre o favicon: o template **não** usa o *Ícone do site* do WordPress
(**Aparência → Personalizar → Identidade do site**), porque ele não chama o
`wp_head()`. Os três arquivos são estáticos, ficam na pasta do tema junto do
`page-landing.php` e já estão ligados no `<head>`. Quer trocar o ícone? Substitua os
arquivos na pasta do tema mantendo os mesmos nomes.

Se o cliente usar **Yoast/Rank Math**, cuidado para não duplicar as tags — nesse caso
apague o `<title>` e as metas do template e deixe o plugin cuidar disso. As variáveis
`$DBH_SEARCH_CONSOLE` também podem sair, já que esses plugins têm campo próprio.

---

## 10. Resumo em 7 linhas

1. Descubra a pasta do tema em **Aparência → Temas**.
2. Suba `page-landing.php`, `landing.css` e `desentupidora-logo.png` nessa pasta.
3. Suba `robots.txt` e `sitemap.xml` na **raiz** (`public_html/`), trocando o domínio antes.
4. Crie a página e selecione o modelo **"Landing Desentupidora (HTML puro)"**.
5. Publique.
6. Preencha os IDs no topo do `page-landing.php` e salve.
7. Teste com o GTM Preview, o GA4 DebugView e envie o sitemap no Search Console.
