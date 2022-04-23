<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <title>Dawid Lachowicz - Blog</title>
</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="sub-page">
    <section class="section blog">
      <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
      <h1>Blog</h1>

      <div class="container">
        <?php if ($logged_in && $user->isAuthor()): ?>
          <aside class="blog-aside">
            <h2><?= $user->getUserType() ?> Dashboard</h2>
            <div>
              <div><em>Your posts: 2</em></div>
              <?php if ($user->isAdmin()): ?>
                <div><em>Total number of posts: 2</em></div>
              <?php endif; ?>
            </div>
            <a href="add-post" class="login-btn read-btn add-btn">New post</a>
          </aside>
        <?php endif; ?>
        <div class="content">

          <article class="post" id="post2">
            <header>
              <h2>New homepage released</h2>
              <div class="info">
                Posted on:
                <time datetime="2022-03-16">3<sup>rd</sup> March 2022, 11:12 UTC</time>
              </div>
            </header>

            <div class="body">
              <p>
                As part of the Fundamentals of Web Technology module exciting
                mini-project, the time has come to release a new homepage. On this
                homepage, you will find a lot of information about what makes me
                stand out for the crowd. Oh, and I do hope you like the styling,
                I tried my best :)
              </p>
            </div>
          </article>

          <article class="post" id="post1">
            <header>
              <h2>First blog post</h2>
              <div class="info">
                Posted on:
                <time datetime="2022-01-28">28<sup>th</sup> January 2022, 15:01 UTC</time>
              </div>
            </header>

            <div class="body">
              <p>
                Yes, I have decided to start my very own blog. I thought it would
                be a great idea to try and write about the things I learn to
                better solidify the concepts in my brain. It will also be a great
                opportunity to work on my soft (writing) skills, as they are also
                very very important.
              </p>
              <p>
                The topics I plan to cover are Ruby on Rails,
                Algorithms & Data Structures, problem solving and more. If you
                would like to me write about a given topic, drop me an email.
              </p>
            </div>
          </article>

        </div>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
