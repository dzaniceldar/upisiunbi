# Online upis studenata na Univerzitet u Bihaću

Web aplikacija za online prijavu i obradu upisa studenata na Univerzitet u Bihaću. Projekat iz predmeta **Objektno orijentisane baze podataka** – Tehnički fakultet, Univerzitet u Bihaću.

**Autor:** Eldar Džanić  
**Profesor:** Prof.dr Admir Midžić  
**Asistent:** Zinaid Kapić MA ing. el.

---

## Sažetak

Aplikacija je razvijena u PHP-u uz Laravel framework, Jetstream i Livewire. Koristi se MVC arhitektura, MySQL baza i Eloquent ORM. Implementirane su dvije korisničke uloge: **kandidat (applicant)** i **administrator (admin)**.

Kandidati mogu kreirati prijavu, birati fakultet i odsjek, unositi ili ručno ispravljati ocjene iz relevantnih predmeta, uploadovati dokumentnu evidenciju (svjedodžbu, ličnu kartu, rodni list, dokaz uplate) te koristiti OCR za automatsko prepoznavanje ocjena iz PDF dokumenata ili skeniranih slika. Bodovi se automatski izračunavaju prema pravilima bodovanja definisanim za svaki odsjek.

Administrator upravlja prijavama, pregledava dokumente i bodove, mijenja status prijave (Draft, Submitted, Under review, Accepted, Rejected, Needs correction), dodaje napomene i može exportovati podatke u CSV formatu.

**Ključne riječi:** Web aplikacija, Laravel, Jetstream, Livewire, PHP, MySQL, MVC arhitektura, ORM, OCR

---

## Tehnologije

| Sloj | Tehnologija |
|------|-------------|
| Framework | Laravel + Jetstream (Livewire stack) |
| Frontend | Blade, Livewire, Tailwind CSS |
| Baza | MySQL |
| Storage | Laravel Storage |
| OCR | spatie/pdf-to-text, thiagoalessio/tesseract_ocr |

---

## Modeliranje i arhitektura

- **UML:** Klasni dijagram, Use-Case dijagram, ER dijagram
- **MVC:** Model (Eloquent), Controller, View (Blade + Livewire)
- **ORM:** Eloquent – mapiranje tabela na PHP klase, relacije (belongsTo, hasMany, hasOne)

### Glavne klase (modeli)

- `User` – korisnik (applicant/admin)
- `Application` – prijava za upis
- `Faculty` – fakultet
- `Department` – odsjek
- `Subject` – predmet
- `ApplicationGrade` – ocjena u prijavi
- `ScoringRule` – pravilo bodovanja
- `Document` – dokument
- `AdminNote` – administrativna napomena

---

## Funkcionalnosti

### Kandidat (applicant)

- Registracija i prijava
- Kreiranje i uređivanje prijave (draft)
- Odabir fakulteta i odsjeka
- Unos ocjena (ručno ili OCR prijedlog)
- Upload dokumenata
- Automatski izračun bodova
- Slanje prijave
- Pregled vlastite prijave i statusa

### Administrator (admin)

- Pregled liste prijava (filteri: fakultet, odsjek, status, datum)
- Pregled detalja prijave (bodovi, ocjene, dokumente)
- Promjena statusa prijave
- Dodavanje napomena
- Preuzimanje dokumenata
- Uređivanje fakulteta
- Export u CSV

---

## Struktura projekta

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Applicant/     # Kontroleri za kandidate
│   │   └── Admin/         # Kontroleri za administraciju
│   └── Livewire/          # Livewire komponente (wizard, upload)
├── Models/                 # Eloquent modeli
└── Services/
    ├── GradeExtractionService.php   # OCR ekstrakcija ocjena
    └── ScoringService.php           # Izračun bodova

database/
├── migrations/
└── seeders/

resources/views/
├── applications/
├── admin/
├── faculties/
└── livewire/
```

---

## Instalacija i pokretanje

### Preduvjeti

- PHP 8.1+
- Composer
- MySQL
- Node.js & npm
- Tesseract OCR i Poppler (za OCR)

### OCR preduvjeti

**macOS (Homebrew):**
```bash
brew install tesseract tesseract-lang poppler
```

**Ubuntu/Debian:**
```bash
sudo apt-get install tesseract-ocr tesseract-ocr-bos tesseract-ocr-hrv poppler-utils
```

### Koraci

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# Postavi DB_DATABASE, DB_USERNAME, DB_PASSWORD u .env
php artisan migrate:fresh --seed
php artisan storage:link
npm run dev
php artisan serve
```

### Admin pristup (default)

- **Email:** admin@unbi.ba  
- **Lozinka:** Admin12345!

Promijeniti odmah nakon prvog logina u produkciji.

---

## API

Za testiranje (npr. Insomnia): GET `/api/statistics` vraća osnovne statistike (broj fakulteta, odsjeka, predmeta, prijava) u JSON formatu.

---

## Statusi prijave

| Status | Opis |
|--------|------|
| Draft | Prijava u izradi, moguće uređivanje |
| Submitted | Poslana, zaključana za uređivanje |
| Under review | U obradi od strane administracije |
| Accepted | Prihvaćena |
| Rejected | Odbijena |
| Needs correction | Potrebne ispravke, kandidat može ponovo uređivati |

---

## Obavezan dokumenti

- Lična karta / pasoš
- Svjedodžba
- Rodni list
- Dokaz o uplati

---

## Baza podataka

Glavne tabele: `users`, `applications`, `faculties`, `departments`, `subjects`, `application_grades`, `scoring_rules`, `documents`, `admin_notes`. Veze su tipa 1:N. Shema je definisana Laravel migracijama.

---

## Testiranje

- **OCR:** PDF (pdftotext) ili sken/slika (Tesseract). Rezultat se čuva kao prijedlog sa confidence; kandidat može korigirati.
- **API:** GET `/api/statistics` – Insomnia/Postman, očekivani status 200 OK.

---

## Troubleshooting

- **OCR ne radi:** Provjeri da li su `tesseract` i `poppler` instalirani.
- **Storage link:** Pokreni `php artisan storage:link` ako upload dokumenata ne radi.
- **Permission denied:** Na Linuxu provjeri `storage/` i `bootstrap/cache/` – `chmod -R 775`.

---

## Literatura

- Laravel dokumentacija: https://laravel.com/docs
- Laravel Jetstream: https://jetstream.laravel.com
- MySQL 8.0 Reference Manual: https://dev.mysql.com/doc/
- OMG UML Specification: https://www.omg.org/spec/UML/
- MDN – MVC: https://developer.mozilla.org/en-US/docs/Glossary/MVC

---

## Licenca

Projekat izrađen u obrazovne svrhe. © 2026
