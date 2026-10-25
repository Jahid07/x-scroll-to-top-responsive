# Local demo websites

Run `npm run demo:seed` after installing dependencies. This starts the Docker site, activates the intended theme and creates the realistic demo once. Repeating it preserves your page edits and local orders. `npm run demo:refresh` explicitly rewrites owned demo content and settings; it does not reset the database or delete unrelated posts. Add `-- --refresh` to a variant command to refresh that profile.

| Purpose | Configuration | Port | Data |
| --- | --- | --- | --- |
| Development | `.wp-env.json` | 8890 | Persistent |
| PHPUnit | `.wp-env.phpunit.json` | 8891 | Separate integration database |
| Browser tests | `.wp-env.e2e.json` | 8892 | Reset before each test run |

Each configuration creates separate wp-env containers, database and uploads. Development stays running. `npm run env:stop` stops the default development profile; for variants use `npx wp-env --config=.wp-env.divi5.json stop` or `npx wp-env --config=.wp-env.subscriptions.json stop` as applicable.

`npm run test:e2e` starts its own E2E profile, validates its configuration and live `WORKSHOP_DEMO_ROLE=e2e` marker, resets **only that E2E database**, seeds the same website, runs Playwright and stops the test profile. `npm run test:setup` performs the E2E reset/seed and leaves that test site running for inspection. Avoid concurrent runs targeting the same profile. For interactive tests use `npm run test:e2e:ui`.

The persistent development profiles carry `WORKSHOP_DEMO_ROLE=development`. No test command needs to reset a development database. Keep manual work in development sites; test-site data is disposable.

### Harbor Studio

The business site includes a home page, portfolio case studies, studio and services pages, a journal with complete articles, and an accessible contact form. It has local photographs, a bundled font and responsive navigation. Its long home page exercises the real scroll button on desktop and mobile. Contact messages stay in the local WordPress option `harbor_demo_messages`; outgoing WordPress mail is suppressed.


## Assets and packaging

All photographs, the local font, product illustrations and logos live under `tests/fixtures/`; see [asset credits](../tests/fixtures/ASSETS.md). The fixtures are local development support and are excluded from production ZIPs. Premium sources, generated overrides, Docker data, browser reports and credentials are ignored by Git.
