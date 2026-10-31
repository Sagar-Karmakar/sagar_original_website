# Sagar for Couples · sagarkarmakar.com

The website for **Back to Us**, a 4-week online program for married couples, coached by Sagar Karmakar.

Built with Laravel 13 (needs PHP 8.3 or newer), Blade, Tailwind CSS v4 (through Vite), GSAP and MySQL. It includes its own booking system for the free call, in place of Calendly or Cal.com, and an Android app for the admin with a notification for every booking.

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

## Phone app and Android app

The admin works as a phone app, with a notification for every new booking and every cancellation by a couple. It uses the browser's own push service, so there's no Firebase or Google account to set up. Everything is on **Admin → Phone app**:

1. **Install it:** either download the Android app (`.apk`) from that page and install it, or open the admin in Chrome on the phone and tap **Install the app**.
2. **Turn on notifications:** in the app, tap **Turn on notifications** and allow them.
3. **Test it:** tap **Send a test notification**.

The notification keys are `VAPID_PUBLIC_KEY` and `VAPID_PRIVATE_KEY` in `.env`. Create them with `php artisan push:keys`. If you change them, turn notifications on again on each phone.

**The Android app** (`android/`) is a Trusted Web Activity: a small app that opens `https://sagarkarmakar.com/admin` full screen in Chrome's engine. Notifications from the site show up as the app's own. Because it opens the live site, it only works fully once the site is live there. Before that, test on the phone with the Chrome install, through the `Local Server` link.

- `public/.well-known/assetlinks.json` proves to Android that the app and the site belong together. This is what hides the address bar. It holds the signing key's fingerprint, so it must go live with the site.
- **The signing key** is `android/sagar-admin.keystore`, and its passwords are in `android/keystore.properties`. Neither is in git. **Back both up somewhere safe** (e.g. Google Drive). Every future version of the app must be signed with this same key, or phones won't install it as an update.
- **To build a new version:** raise `versionCode` and `versionName` in `android/app/build.gradle.kts`, then:
  ```
  cd android
  set JAVA_HOME=C:\Program Files\Android\Android Studio\jbr
  gradlew assembleRelease
  copy app\build\outputs\apk\release\app-release.apk sagar-admin.apk
  ```
  The admin download page serves `android/sagar-admin.apk`.
- **To use another domain:** change `sagarkarmakar.com` in `android/app/src/main/AndroidManifest.xml` and `android/app/src/main/res/values/strings.xml`, then rebuild.

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
| `VAPID_PUBLIC_KEY`, `VAPID_PRIVATE_KEY` | Keys for phone notifications. Create them with `php artisan push:keys` (see Phone app) |
| `MAIL_USERNAME`, `MAIL_PASSWORD` | Your Hostinger mailbox address (e.g. `contact@sagarkarmakar.com`) and its password. Emails are sent only once these are filled in |
| `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` | Who emails come from. The address must be the same Hostinger mailbox as `MAIL_USERNAME`, or Hostinger refuses to send |

Email goes through Hostinger's SMTP server; these are already set and don't need changing: `MAIL_MAILER=smtp`, `MAIL_SCHEME=smtps`, `MAIL_HOST=smtp.hostinger.com`, `MAIL_PORT=465`, `MAIL_TIMEOUT=10`. Create or reset the mailbox password in Hostinger hPanel → Emails.

To check the settings, send yourself a test email:

```
php artisan mail:test you@example.com
```

If it fails, the message says why. "Authentication failed" means the username or password is wrong. "Client host rejected: Access denied" means the username is empty.

To change the price or spots, use Admin → Offer.

---

## Photos

The site picks photos up from `public/images` by file name. Drop a file in with the right name (`.jpg`, `.png` or `.webp`) and it replaces the dashed placeholder. No code change is needed.

| File name | Where it shows | Shape |
| --- | --- | --- |
| `home-hero` | Home, top | Upright 4:5, at least 1200×1500 |
| `coach` | Home, "Meet your coach" | Square, at least 1200×1200 |
| `about` | About, top | Upright 4:5, at least 1200×1500 |
| `share` | The preview when a link is shared on WhatsApp or Facebook | 1200×630 |
| `book-just-the-two-of-us`, `book-love-rediscovered` | Books page covers | 2:3, at least 800×1200 |

Keep each photo under about 500 KB (`.webp` or a compressed `.jpg`) so pages stay fast on phones.

---

## Offer and reviews

- **Admin → Offer:** the price card on the home page. Change the label (e.g. "Founding couples"), the price, total spots and spots left, and the note under the price. Leave total spots empty to stop showing spots. The starting values are in `config/site.php`.
- **Admin → Reviews:** add couples' reviews (no names, e.g. "A couple from Kolkata"), and show, hide, edit or delete them. The home page shows the newest 6. "What couples say" stays hidden until at least one is shown. Each review needs a tick confirming the couple gave written permission.

---

## Before going live

- [ ] Photos in `public/images` (see Photos)
- [ ] Your admin login: `ADMIN_EMAIL` and `ADMIN_PASSWORD` in `.env`, then `php artisan admin:create`
- [ ] Your weekly hours and days off in Admin → Availability, the offer in Admin → Offer, reviews in Admin → Reviews
- [ ] Your Hostinger `MAIL_USERNAME` and `MAIL_PASSWORD` in `.env`, then `php artisan mail:test`
- [ ] `DISCORD_BOOKING_WEBHOOK` in `.env`, then `php artisan discord:test`
- [ ] Optional: Google Calendar (see Google Calendar)
- [ ] Recommended: have a lawyer or CA read the three legal pages

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

1. Set the hosting's PHP version to 8.3 or newer (Laravel 13 needs it). Create a MySQL database and note its name, user and password. Make sure the site has an SSL certificate (https). Phone notifications and the Android app need it.
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

   Add a cron job in Hostinger (hPanel → Advanced → Cron Jobs) that runs every minute:
   ```
   cd /path/to/the/site && php artisan schedule:run
   ```
   It deletes bookings older than 12 months each day, as the privacy policy promises.
5. Point the domain's web root at the `public/` folder.
6. In the live admin, connect Google Calendar if you use it.
7. Book a test call on the live site, check both emails arrive (and the calendar event), then cancel it.

Don't upload `node_modules/`, `Local Server/`, your local `.env` or the Android signing key.
