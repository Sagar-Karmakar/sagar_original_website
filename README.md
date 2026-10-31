# Sagar for Couples · sagarkarmakar.com

The website for **Back to Us**, a 4-week online program for married couples, coached by Sagar Karmakar.

Built with Laravel 12, Blade, Tailwind CSS v4 (through Vite), GSAP and MySQL. It includes its own booking system for the free call, in place of Calendly or Cal.com.

**Design source:** https://claude.ai/code/artifact/8e4272f4-d665-49b6-8199-16418df6331d
(desktop pages, phone views and a style guide on one canvas)

---

## Pages

| URL | View | What it's for |
| --- | --- | --- |
| `/` | `welcome.blade.php` | Home: the problem, how Back to Us works, sample games, price, coach, reviews, FAQ |
| `/call` | `call.blade.php` | Book the free 20-minute call: pick a day, a time, add details. A focused landing page: small header, short footer |
| `/call/booked/…` | `call-booked.blade.php` | Booking confirmation, calendar buttons and cancel. Only reachable through the private link sent to the couple |
| `/about` | `about.blade.php` | Sagar's story, timeline and values |
| `/books` | `books.blade.php` | *Just The Two Of Us* and *Love Rediscovered* |
| `/privacy-policy` | `legal/privacy.blade.php` | Privacy policy |
| `/terms-and-conditions` | `legal/terms.blade.php` | Terms |
| `/refund-policy` | `legal/refund.blade.php` | Refund policy |
| `/admin` | `admin/bookings.blade.php` | Private: upcoming and past calls, cancel a call |
| `/admin/availability` | `admin/availability.blade.php` | Private: weekly hours and days off |
| `/admin/login` | `admin/login.blade.php` | Private: log in |

Routes are in `routes/web.php`.

---

## Booking the free call

The booking system is built into the site.

**For the couple:** on `/call` they pick a day, then a time (all times are India time, IST), then enter their names, email, WhatsApp number, language and who's joining. They land on a confirmation page and get an email with a calendar invite. That page and email have a private link to cancel.

**For you:** each booking emails you, posts to Discord if you add a webhook, and is added to your Google Calendar if you connect it. The admin area shows all calls with one-tap WhatsApp and email links, and lets you cancel a call (the couple is emailed, and the event leaves your calendar). You set your weekly hours and days off there too.

**Rules that keep it safe:**
- A time can only be booked once. Taken times disappear from the calendar.
- Only times inside your weekly hours, at least 4 hours ahead and up to 21 days out, can be booked.
- A hidden spam-trap field and a limit of 6 bookings a minute per visitor keep bots out.
- Booking and cancel links are signed, so nobody can guess another couple's booking.

**Rules you can change** in `config/booking.php`: call length (20 min), how often a slot starts (every 30 min, which leaves a 10 min gap), minimum notice (4 h), days shown (21), languages and timezone. Weekly hours and days off are changed in `/admin/availability`, not in code. The starting hours are weekdays 7:30–9:30 pm and weekends 10 am–12 pm.

**Where the code is:**

| File | What it does |
| --- | --- |
| `app/Services/BookingAvailability.php` | Works out the open slots from weekly hours, days off and existing bookings |
| `app/Http/Controllers/BookingController.php` | The public booking, confirmation, calendar file and cancel |
| `app/Http/Controllers/Admin/*` | Login, bookings list, weekly hours, days off, Google Calendar connection |
| `app/Services/BookingNotifier.php` | Sends the emails and the Discord message, and updates Google Calendar |
| `app/Services/GoogleCalendar.php` | Connects to your Google Calendar and adds or removes booking events |
| `app/Mail/*`, `resources/views/mail/booking/*` | The three emails: confirmed (to the couple, with the invite), received (to you), cancelled |
| `resources/views/vendor/mail/html/themes/default.css` | Email styling in the site's colours (`#B81F1F` buttons and links, blush background) |
| `app/Models/Booking.php` | A booking, its IST time, Google Calendar link and `.ics` file |
| `tests/Feature/*Test.php` | Checks the rules above and the Google Calendar sync. Run `php artisan test` |

---

## Admin login

The admin is at `/admin`. Its login comes from `.env`:

```
ADMIN_EMAIL=hello@sagarkarmakar.com
ADMIN_PASSWORD=a-long-password
```

After setting or changing these, run `php artisan admin:create` to create the login or update its password. `php artisan db:seed` does the same. To use a different email without touching `.env`, run `php artisan admin:create you@example.com` and type a password when asked.

On the live server, remove `ADMIN_PASSWORD` from `.env` once the login exists. The login keeps working, because the password is stored hashed in the database.

---

## Google Calendar

Once connected, every booking is added to your Google Calendar automatically, with the couple's names, WhatsApp, email, language and notes. Cancelled calls are removed, and calls booked before you connected are added when you connect. If Google is ever unreachable, the booking still goes through, and the admin shows what went wrong.

Setting it up (free, about 10 minutes, once):

1. Go to https://console.cloud.google.com and create a project, e.g. "sagarkarmakar-site".
2. Open **APIs & Services → Library**, search for **Google Calendar API** and click **Enable**.
3. Open **OAuth consent screen** (called **Google Auth Platform** in newer consoles). Choose **External**, give the app a name and your email, and save.
4. On the same screen, under **Audience** (or **Publishing status**), click **Publish app**. In "Testing" mode Google disconnects you every 7 days. Google doesn't need to review an app that only you use.
5. Open **Credentials** (or **Clients**) → **Create credentials → OAuth client ID** → **Web application**. Under **Authorized redirect URIs** add both:
   - `http://127.0.0.1:8000/admin/google/callback`
   - `https://sagarkarmakar.com/admin/google/callback`
6. Copy the **Client ID** and **Client secret** into `.env`:
   ```
   GOOGLE_CLIENT_ID=…apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=…
   ```
7. In the admin, open **Availability → Google Calendar → Connect Google Calendar**, choose your Google account and allow access. Google warns that the app isn't verified: click **Advanced → Go to … (unsafe)**. It's your own app.

When connecting offline, open the site as `http://127.0.0.1:8000`, not `localhost`, so the address matches step 5. The offline and live sites each have their own database, so connect once on each.

---

## Design system

All tokens live in `resources/css/app.css` under `@theme`. Use the token names in classes (`bg-page`, `text-brand`), never raw hex codes.

The colours below are changed from the original design canvas, at the owner's request: no dark mode, a pinkish-cream background instead of beige, and `#B81F1F` as the only accent. The WhatsApp buttons, which the canvas drew in green, and the quote band and footer, which it drew in dark brown, now follow these colours.

### Colours

The site is light only, on a blush-cream background, with **one accent colour: `#B81F1F`**. Every button, label, icon, link and red band uses exactly that colour. Lighter tints of it are made with opacity (`bg-brand/10`), never a new colour. Don't add oranges, other reds or a dark mode.

| Token | Colour | Used for |
| --- | --- | --- |
| `brand` | `#b81f1f` | The one accent: buttons, eyebrows, icons, links, red bands (white text on it) |
| `page` | `#fdf4f2` blush cream | Page background |
| `surface` | `#ffffff` | Cards, white sections |
| `panel` | `#f9e7e3` deeper blush | Tinted sections, quote band, footer, chips, notes |
| `line` | `#f0dad5` | Borders |
| `dash` | `#e5c2bb` | Photo placeholder outlines, footer divider |
| `ink` | `#2b2420` | Main text |
| `body` | `#4f453f` | Secondary body text |
| `muted` | `#6d625a` | Small and supporting text |

Hover states keep the same colour: filled buttons go to `bg-brand/90`, outline buttons get a `bg-brand/10` wash, and text links get a thicker underline.

### Type

| Role | Font | Size | Class |
| --- | --- | --- | --- |
| Hero heading | Fraunces 600 | 40–70px, scales with screen | `font-serif text-hero` |
| Page heading | Fraunces 600 | 36–60px | `font-serif text-h1` |
| Section heading | Fraunces 600 | 30–48px | `font-serif text-h2` |
| Card heading | Fraunces 600 | 24px | `font-serif text-2xl` |
| Lead paragraph | Figtree 400 | 18–22px | `text-lead` |
| Body | Figtree 400 | 17px, line height 1.6 | default |
| Small | Figtree 400 | 15px | `text-small` |
| Eyebrow | Figtree 700 caps | 14px, 0.08em spacing | `<x-eyebrow>` |

Fonts load from Google Fonts in the layout. Body text is never smaller than 17px on phones.

### Spacing and corners

- Content width 1160px with 24px side padding: `mx-auto max-w-site px-6`
- Section padding 56–104px: `py-section`
- Spacing steps 8, 12, 16, 24, 32, 48, 96px
- Corners: 10px small buttons, 12px buttons, 16px cards (`rounded-2xl`), 20–24px panels and photos, full round for chips
- Card grids: `grid grid-fit-65 gap-5` makes columns at least 260px wide (the number × 4px) that wrap on small screens

### Motion

The scroll-in animations are in `resources/js/app.js` and are skipped for visitors who turn on reduced motion. Add an attribute to use them:

- `data-hero`: children fade up on page load
- `data-reveal`: the block fades up when scrolled into view
- `data-stagger`: its children fade up one after another

---

## Components

Anonymous Blade components in `resources/views/components/`:

| Component | Use |
| --- | --- |
| `<x-layouts.app>` | Page shell. Props: `title`, `description`, `nav` (`home`, `pages`, `minimal`, `focused`), `footer` (`full`, `minimal`), `sticky-cta` (phone-only "Book your free call" bar) |
| `<x-layouts.legal>` | Legal page with the Privacy / Terms / Refund side menu. Props: `title`, `updated` |
| `<x-layouts.admin>` | The private admin pages. Prop: `title` |
| `<x-input>` | Labelled text input with its error message. Props: `name`, `label`, `hint`, `type` |
| `<x-site-header>` / `<x-site-footer>` | Used by the layout; the header has the phone menu |
| `<x-button>` | Link styled as a button, or a submit button when there's no `href`. `variant`: `primary`, `outline`, `inverse` and `outline-inverse` (both for use on a red band). `size`: `sm`, `md`, `lg` |
| `<x-eyebrow>` | Small red caps label above a heading |
| `<x-icon>` | Line icons: `check`, `chat`, `shield`, `cards`, `talk`, `heart`, `chai`, `menu`, `close` |
| `<x-photo-placeholder>` | Dashed box standing in for a photo that isn't ready |

```blade
<x-button :href="route('call')" size="lg">Book your free 20-minute call</x-button>
<x-button :href="config('site.whatsapp_url')" variant="outline">
    <x-icon name="chat" class="size-5" /> Ask on WhatsApp
</x-button>
```

---

## Settings

Contact links and the offer live in `config/site.php`, read from `.env`:

| `.env` key | What it does |
| --- | --- |
| `SITE_WHATSAPP_NUMBER` | WhatsApp number with country code, no `+` (e.g. `916291373748`) |
| `SITE_EMAIL` | Email shown in the footer and legal pages |
| `BOOKING_MEETING_URL` | Your video call link (Google Meet, Zoom…), sent with every booking. Leave empty to send the link on WhatsApp yourself |
| `BOOKING_NOTIFY_EMAIL` | Where new bookings and cancellations are emailed. Defaults to `SITE_EMAIL` |
| `DISCORD_BOOKING_WEBHOOK` | Discord webhook URL (channel settings → Integrations → Webhooks → Copy Webhook URL). Each booking and cancellation is posted there with all the couple's details. Check it with `php artisan discord:test` |
| `ADMIN_EMAIL`, `ADMIN_PASSWORD` | The `/admin` login (see Admin login) |
| `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` | Optional, for Google Calendar sync (see Google Calendar) |
| `MAIL_USERNAME`, `MAIL_PASSWORD` | Your Hostinger mailbox address (e.g. `contact@sagarkarmakar.com`) and its password. Emails are sent only once these are filled in |
| `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` | Who emails come from. The address must be the same Hostinger mailbox as `MAIL_USERNAME`, or Hostinger refuses to send |

Email goes through Hostinger's SMTP server; these are already set and don't need changing: `MAIL_MAILER=smtp`, `MAIL_SCHEME=smtps`, `MAIL_HOST=smtp.hostinger.com`, `MAIL_PORT=465`, `MAIL_TIMEOUT=10`. Create or reset the mailbox password in Hostinger hPanel → Emails.

To check the settings, send yourself a test email:

```
php artisan mail:test you@example.com
```

If it fails, the message says why. "Authentication failed" means the username or password is wrong. "Client host rejected: Access denied" means the username is empty.

To change the founding price or spots left, edit `founding` in `config/site.php`.

---

## Before going live: fill in

Placeholders from the design are in square brackets on the pages:

- [ ] Photos: Sagar and Arpita (home hero, home coach section, about)
- [ ] Your refund rule (home price card, home FAQ, refund policy)
- [ ] One true moment from your marriage (home) and your story (about)
- [ ] Timeline years (about)
- [ ] Reviews and cities, shared with written consent (home)
- [ ] Legal details: date, notes kept, payment provider, cookies, governing law. Then have a lawyer or CA check all three legal pages and remove the "Template only" note
- [ ] Book covers, when ready (books)

Search for `[` in `resources/views` to find them all. Also set up:

- [ ] Your admin login: `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env`, then `php artisan admin:create`
- [ ] Optional: Google Calendar (see Google Calendar)
- [ ] Your weekly hours and days off in `/admin/availability`
- [ ] `BOOKING_MEETING_URL`, and your Hostinger `MAIL_USERNAME` and `MAIL_PASSWORD`, in `.env`. Then run `php artisan mail:test`

---

## Run it offline (XAMPP)

1. Open the XAMPP Control Panel and **Start MySQL**.
2. The database is `sagarkarmakar` (user `root`, no password), already set in `.env`. On a fresh machine, create it in phpMyAdmin (`http://localhost/phpmyadmin`) with collation `utf8mb4_unicode_ci`, then run:
   ```
   composer install
   npm install
   php artisan migrate
   ```
3. Build the CSS and JS:
   ```
   npm run build
   ```
   Or run `npm run dev` while editing, to see changes instantly.
4. Start the site:
   ```
   php artisan serve
   ```
   Then open http://127.0.0.1:8000. You can also double-click `Local Server/Start Local Server.bat`, which also gives you a temporary public link to share.
5. Create the admin login from `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env`, then log in at http://127.0.0.1:8000/admin:
   ```
   php artisan admin:create
   ```

If every page shows a database error, MySQL isn't running. Start it in XAMPP.

Booking emails are really sent offline too, through Hostinger, once `MAIL_USERNAME` and `MAIL_PASSWORD` are filled in. Until then, bookings still work, but the emails fail and the errors are written to `storage/logs/laravel.log`. To read emails in that log instead of sending them, set `MAIL_MAILER=log`.

---

## Going online

1. Create a MySQL database on your host and note its name, user and password.
2. On the server, set in `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://sagarkarmakar.com`, the `DB_` values from step 1, the Hostinger mail settings (copy the `MAIL_` lines from your local `.env`), and the booking settings above. Then run `php artisan mail:test` on the server.
3. Run `npm run build` locally and upload `public/build` (it isn't in git).
4. On the server:
   ```
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan optimize
   php artisan admin:create
   ```
   Then remove `ADMIN_PASSWORD` from the server's `.env`, and run `php artisan optimize` again.
5. Point the domain's web root at the `public/` folder.
6. In the live admin, connect Google Calendar if you use it.
7. Book a test call on the live site, check both emails arrive (and the calendar event), then cancel it.

Don't upload `node_modules/`, `Local Server/` or your local `.env`.
