<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stallhouse · Independent shops, one roof</title>
    <meta name="description" content="Stallhouse gives every merchant their own online store, designed in a visual editor, with a catalogue, a basket and orders.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=familjen-grotesk:400,500,600,700&display=swap">
    <style>
        :root {
            --ink: oklch(0.22 0.01 30);
            --ink-soft: oklch(0.42 0.012 30);
            --paper: oklch(0.975 0.002 30);
            --line: oklch(0.88 0.006 30);
            --awning: oklch(0.56 0.18 32);
            --awning-deep: oklch(0.47 0.16 32);
            --on-awning: oklch(0.99 0 0);
            --radius: 10px;
            --gutter: clamp(1rem, 4vw, 3rem);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: 'Familjen Grotesk', system-ui, sans-serif;
            font-size: 1.0625rem;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; }

        .wrap { width: min(72rem, 100% - 2 * var(--gutter)); margin-inline: auto; }

        .bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding-block: 1.1rem;
        }

        .wordmark { font-weight: 700; font-size: 1.25rem; letter-spacing: -0.02em; text-decoration: none; }

        .bar nav { display: flex; align-items: center; gap: clamp(0.75rem, 2.5vw, 1.75rem); font-weight: 500; }
        .bar nav a:not(.button) { text-decoration: none; color: var(--ink-soft); }
        .bar nav a:not(.button):hover { color: var(--ink); }

        .button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.15rem;
            border-radius: var(--radius);
            background: var(--ink);
            color: var(--paper);
            font-weight: 600;
            text-decoration: none;
            transition: background-color 180ms cubic-bezier(0.25, 1, 0.5, 1);
        }
        .button:hover { background: oklch(0.32 0.012 30); }
        .button--light { background: var(--on-awning); color: var(--awning-deep); }
        .button--light:hover { background: oklch(0.93 0.02 32); }

        .awning {
            height: 14px;
            background: repeating-linear-gradient(90deg, var(--awning) 0 28px, var(--on-awning) 28px 56px);
        }

        .hero { background: var(--awning); color: var(--on-awning); padding-block: clamp(3.5rem, 9vw, 7rem); }
        .hero h1 {
            margin: 0;
            max-width: 15ch;
            font-size: clamp(2.6rem, 6.5vw, 5.25rem);
            line-height: 0.98;
            letter-spacing: -0.035em;
            font-weight: 700;
            text-wrap: balance;
        }
        .hero p { max-width: 38rem; margin: 1.5rem 0 2.25rem; font-size: clamp(1.1rem, 1.6vw, 1.3rem); color: oklch(0.96 0.02 32); text-wrap: pretty; }
        .hero .actions { display: flex; flex-wrap: wrap; align-items: center; gap: 1.25rem; }
        .hero .actions a:not(.button) { font-weight: 600; text-underline-offset: 0.25em; }

        section { padding-block: clamp(3.5rem, 8vw, 6rem); }

        h2 { margin: 0 0 0.5rem; font-size: clamp(1.75rem, 3.4vw, 2.6rem); line-height: 1.05; letter-spacing: -0.03em; text-wrap: balance; }
        .lede { margin: 0 0 2.5rem; max-width: 36rem; color: var(--ink-soft); }

        .stores { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 20rem), 1fr)); gap: 1.5rem; }

        .store {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--line);
            border-radius: calc(var(--radius) + 4px);
            background: oklch(1 0 0);
            overflow: hidden;
            text-decoration: none;
            transition: border-color 200ms cubic-bezier(0.25, 1, 0.5, 1), box-shadow 200ms cubic-bezier(0.25, 1, 0.5, 1);
        }
        .store:hover { border-color: oklch(0.75 0.01 30); box-shadow: 0 10px 30px -18px oklch(0.2 0.02 30 / 0.45); }
        .store:focus-visible { outline: 3px solid var(--awning); outline-offset: 3px; }
        .store img { display: block; width: 100%; aspect-ratio: 16 / 10; object-fit: cover; background: var(--line); }
        .store div { padding: 1.25rem 1.35rem 1.4rem; }
        .store h3 { margin: 0; font-size: 1.35rem; letter-spacing: -0.02em; }
        .store p { margin: 0.35rem 0 0; color: var(--ink-soft); font-size: 0.98rem; }
        .store .visit { display: inline-block; margin-top: 1rem; font-weight: 600; color: var(--awning-deep); }

        .empty { padding: 2rem; border: 1px dashed var(--line); border-radius: var(--radius); color: var(--ink-soft); }

        .steps { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 15rem), 1fr)); gap: 2rem 3rem; counter-reset: step; }
        .steps li { counter-increment: step; border-top: 2px solid var(--ink); padding-top: 1rem; }
        .steps li::before { content: counter(step); display: block; font-size: 2.5rem; font-weight: 700; letter-spacing: -0.04em; line-height: 1; margin-bottom: 0.9rem; color: var(--awning); }
        .steps h3 { margin: 0 0 0.35rem; font-size: 1.15rem; }
        .steps p { margin: 0; color: var(--ink-soft); }

        footer { border-top: 1px solid var(--line); padding-block: 2rem 3rem; color: var(--ink-soft); font-size: 0.95rem; }
        footer .wrap { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1rem; }

        @media (max-width: 36rem) {
            .bar nav .hide-sm { display: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>
<body>
    <header class="wrap bar">
        <a class="wordmark" href="{{ route('platform') }}">Stallhouse</a>
        <nav aria-label="Main">
            <a class="hide-sm" href="#stores">Stores</a>
            <a href="{{ url('app/login') }}">Sign in</a>
            <a class="button" href="{{ url('app/register') }}">Open a store</a>
        </nav>
    </header>

    <div class="awning" aria-hidden="true"></div>

    <main>
        <div class="hero">
            <div class="wrap">
                <h1>A shop of your own, open by teatime.</h1>
                <p>Every merchant on Stallhouse gets a storefront they design themselves, a catalogue, a basket and orders that arrive by email. Sign up, name your store, and it is live at its own address.</p>
                <div class="actions">
                    <a class="button button--light" href="{{ url('app/register') }}">Open a store</a>
                    <a href="#stores">See who is trading</a>
                </div>
            </div>
        </div>

        <section id="stores">
            <div class="wrap">
                <h2>Open now</h2>
                <p class="lede">Each of these is a separate store with its own products, colours, pages and orders, run from the same app.</p>

                @if ($stores->isEmpty())
                    <p class="empty">No stores are live yet. <a href="{{ url('app/register') }}">Open the first one.</a></p>
                @else
                    <div class="stores">
                        @foreach ($stores as $store)
                            <a class="store" href="{{ $store['url'] }}">
                                @if ($store['image'])
                                    <img src="{{ $store['image'] }}" alt="" loading="lazy">
                                @endif
                                <div>
                                    <h3>{{ $store['name'] }}</h3>
                                    @if ($store['description'] !== '')
                                        <p>{{ $store['description'] }}</p>
                                    @endif
                                    <span class="visit">Visit the store</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section>
            <div class="wrap">
                <h2>From sign-up to first order</h2>
                <p class="lede">No themes to install and nothing to deploy per store.</p>
                <ol class="steps">
                    <li>
                        <h3>Create an account</h3>
                        <p>One login can run several stores and switch between them.</p>
                    </li>
                    <li>
                        <h3>Name your store</h3>
                        <p>Pick its address and currency. A storefront with a shop, basket and checkout is built on the spot.</p>
                    </li>
                    <li>
                        <h3>Add products, then make it yours</h3>
                        <p>Upload photos and prices, then change every page, colour and font in the visual editor.</p>
                    </li>
                </ol>
            </div>
        </section>
    </main>

    <footer>
        <div class="wrap">
            <span>Stallhouse is a starter kit built with Laravel, Filament and FilamentCraft.</span>
            <a href="https://github.com/filamentcraft/starter-multistore">Get the code</a>
        </div>
    </footer>
</body>
</html>
