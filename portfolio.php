<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <link rel="stylesheet" href="/assets/fonts/github-icon/css/github.css">
  <title>Dawid Lachowicz - Portfolio</title>
</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="sub-page">
    <section class="section portfolio">
      <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">

      <div class="container">
        <div class="content">
          <h1>Portfolio</h1>
        </div>

        <div class="projects-container">
          <article class="project">
            <div class="description">
              <a href="https://acclimate.herokuapp.com/">
                <figure>
                  <img src="/assets/images/projects/accliamte.png"
                    alt="Screenshot of Acclimate app" class="screenshot">
                  <figcaption>
                    <h2>Acclimate App</h2>
                  </figcaption>
                </figure>
              </a>

              <a href="https://github.com/dawidl022/acclimate-app"
                target="_blank" rel="noopener">
                <i class="icon-github-circled icon"></i>
                <em>Source code on GitHub</em>
              </a>

              <blockquote cite="https://github.com/dawidl022/acclimate-app#readme">
                The app prototype helps users make informed decisions about their
                buying habits, by providing them with environmental metrics along
                with an overall environmental-friendly rating for companies from
                the different retails sectors. The scores come with a map view, so
                that the user can easily locate a store close to them, which
                includes color coded markers to make the ratings easier to
                distinguish.
              </blockquote>
            </div>

            <div class="tech-stack">
              <a href="https://developer.mozilla.org/en-US/docs/Web/HTML"
                target="_blank" rel="noopener">
                <img src="/assets/devicons/html5-original.svg" alt="HTML5">
              </a>
              <a href="https://sass-lang.com/" target="_blank" rel="noopener">
                <img src="/assets/icons/sass.svg" alt="SCSS">
              </a>
              <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript" target="_blank" rel="noopener">
                <img src="/assets/devicons/javascript-original.svg" alt="JavaScript">
              </a>
              <a href="https://www.ruby-lang.org/" target="_blank" rel="noopener">
                <img src="/assets/devicons/ruby-original.svg" alt="Ruby">
              </a>
              <a href="https://rubyonrails.org/" target="_blank" rel="noopener">
                <img src="/assets/devicons/rails-original-wordmark.svg" alt="Ruby on Rails">
              </a>
              <a href="https://www.heroku.com/" target="_blank" rel="noopener">
                <img src="/assets/devicons/heroku-original.svg" alt="Heroku">
              </a>
            </div>
          </article>

          <article class="project">
            <div class="description">
              <a href="https://github.com/dawidl022/healthy-change">
                <figure>
                  <img src="/assets/images/projects/healthy-change.jpg"
                    alt="Screenshot of Healthy Change App" class="screenshot">
                  <figcaption>
                    <h2>Healthy Change</h2>
                  </figcaption>
                </figure>
              </a>

              <a href="https://github.com/dawidl022/healthy-change"
                target="_blank" rel="noopener">
                <i class="icon-github-circled icon"></i>
                <em>Source code on GitHub</em>
              </a>

              <blockquote cite="https://github.com/dawidl022/healthy-change#readme">
                The application allows you to record your health and food
                activities such as exercise, meals and water consumption. It is
                also possible to obtain information about a given food product
                (nutrients). All this is calculated and analysed by the program,
                which displays indicators (caloric balance and body hydration) and
                prompts for the user. All this in a clean, clean and aesthetic
                interface.
              </blockquote>
            </div>

            <div class="tech-stack">
              <a href="https://www.python.org/" target="_blank" rel="noopener">
                <img src="/assets/devicons/python-original.svg" alt="Python">
              </a>
              <a href="https://kivy.org/" target="_blank" rel="noopener">
                <img src="/assets/icons/kivy.png" alt="Kivy">
              </a>
            </div>
          </article>

          <article class="project">
            <div class="description">
              <a href="https://replit.com/@dawidl022/top-rb-chess">
                <figure>
                  <img src="/assets/images/projects/cli-chess.png"
                    alt="Screenshot of Command-line Chess" class="screenshot">
                  <figcaption>
                    <h2>Command-line Chess</h2>
                  </figcaption>
                </figure>
              </a>

              <a href="https://github.com/dawidl022/top-rb-chess"
                target="_blank" rel="noopener">
                <i class="icon-github-circled icon"></i>
                <em>Source code on GitHub</em>
              </a>

              <blockquote cite="https://github.com/dawidl022/top-rb-chess#readme">
                Two-player command line chess game. The players control their
                pieces by typing in chess notation at the prompt. The game logic
                was built using TDD.
              </blockquote>
            </div>

            <div class="tech-stack">
              <a href="https://www.ruby-lang.org/" target="_blank" rel="noopener">
                <img src="/assets/devicons/ruby-original.svg" alt="Ruby">
              </a>
              <a href="https://rspec.info/" target="_blank" rel="noopener">
                <img src="/assets/devicons/rspec.svg" alt="RSpec">
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
