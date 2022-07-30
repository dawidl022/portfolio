<?php
  require_once 'scripts/load-user.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    require_once 'scripts/db-connect.php';
    require 'partials/_head.php';
  ?>

  <title>Dawid Lachowicz - Personal Homepage</title>
  <meta name="description" content="Personal Homepage of Dawid Lachowicz - Computer Science student and Web Developer.
Check out my projects and work and find out how to reach out to me.">

</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="homepage">
    <section class="hero">
      <div class="title">
        <h1>Dawid Lachowicz</h1>
        <p class="subtitle">Computer Science student & Full-Stack Developer</p>
      </div>

      <div class="socials">
        <a href="https://github.com/dawidl022" class="social-icon"
          target="_blank" rel="noopener">
          <img src="/assets/icons/github.svg" alt="GitHub">
        </a>
        <a href="https://www.linkedin.com/in/dawid-k-lachowicz/"
          class="social-icon" target="_blank" rel="noopener">
          <img src="/assets/icons/linkedin.svg" alt="LinkedIn">
        </a>
        <a href="mailto:dawid.k.lachowicz@gmail.com" class="social-icon">
          <img src="/assets/icons/at.svg" alt="Email">
        </a>
      </div>

      <a class="scroll-prompt" href="#about-me">
        <div>Learn more about what I do</div>

        <img src="/assets/images/chevron.svg" alt="scroll down arrow"
          width="150" height="75">
      </a>
    </section>

    <div class="about section" id="about-me">
      <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">

      <div class="container">
        <section class="content">
          <div class="media">
            <div class="copy">
              <h2>About me</h2>
              <p class="intro">
                Self-taught programmer and Computer Science Student looking to
                take on new and exciting challenges. An open-minded individual
                who likes communicating and working with others in a team.
                Passionate about Software Engineering, Web Development,
                Blockchain and Algorithms. I am very eager to learn new things
                and I love applying that newfound knowledge, especially in
                projects!
              </p>
            </div>
            <img src="/assets/images/dawid.png" alt="Photo of Dawid Lachowicz">
          </div>
        </section>

        <?php if ($db !== null): ?>
          <aside class="aside blog-aside">
            <h2><a href="/blog">Recent blog articles</a></h2>

            <?php
              require_once 'classes/PostList.class.php';
              define('EXCERPT_LENGTH', 400);
              foreach (PostList::getNMostRecent($db, 2) as $post):
            ?>
                <article class="post">
                  <header>
                    <h3>
                      <a href="/blog/<?= $post->getPermalink() ?>">
                        <?= $post->getTitle() ?>
                      </a>
                    </h3>
                    <div class="info">
                      Posted on:
                      <?= Util::formatTime($post->getTimeCreated()) ?>
                    </div>
                  </header>

                  <div>
                    <?= Util::makeExcerpt($post->getContent(), EXCERPT_LENGTH)  ?>
                  </div>
                  <a href="/blog/<?= $post->getPermalink() ?>"
                    class="login-btn read-btn">Read more</a>
                </article>
            <?php endforeach; ?>

          </aside>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
