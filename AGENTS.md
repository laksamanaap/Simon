# Repository Guidelines

## Project Structure & Module Organization
- Entry and views: `index.php`, `playground.php`
- Client code: `main.js`, `styles.css`, fonts via CDN
- API endpoints: `save_user.php`, `get_leaderboard.php`, `update_score.php`, `init_scores.php`
- Data store: `scores.json` (file-based leaderboard)
- Assets: `sounds/` (button audio), `README.md`

## Build, Test, and Development Commands
- Serve locally (PHP built‑in): `php -S localhost:8000 -t .`
- Laragon/Apache: place the project in `C:\laragon\www\Simon` and visit `http://localhost/Simon/`
- Initialize leaderboard file: open `http://localhost/Simon/init_scores.php` (creates `scores.json` and adjusts permissions if possible)

## Coding Style & Naming Conventions
- PHP: 4‑space indent, keep `?>` closing tag (matches current files). Sanitize output with `htmlspecialchars(...)`.
- JavaScript: 2‑space indent, camelCase for variables/functions, use jQuery patterns already present.
- Filenames: PHP endpoints use `snake_case.php` (e.g., `get_leaderboard.php`).
- HTML/CSS: keep semantic tags; prefer inline styles only for small, component‑scoped tweaks.

## Testing Guidelines
- No automated tests are configured. Perform manual checks:
  - Login via `index.php`, validate form errors and redirect.
  - Play a round; verify score increments and leaderboard updates.
  - Refresh to confirm session persistence and current‑user highlight.
- If adding tests, place them under `tests/` and document how to run them in the PR.

## Commit & Pull Request Guidelines
- Use Conventional Commits: `feat:`, `fix:`, `chore:`, `docs:` (e.g., `feat: add current user highlight`).
- Keep messages imperative and concise; include scope when helpful.
- PRs should include: purpose/summary, linked issues, testing steps, and screenshots/GIFs for UI changes.

## Security & Configuration Tips
- Do not trust client scores; server updates happen in `update_score.php`. Validate and sanitize all inputs.
- `scores.json` is writable in development; restrict access in production (e.g., move outside web root or block via server config).
- Escape any user‑supplied content (see JS `escapeHtml` and PHP `htmlspecialchars`).

