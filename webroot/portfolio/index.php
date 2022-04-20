<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

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
        <p class="subtitle">Computer Science student & Web Developer</p>
      </div>

      <div class="socials">
        <a href="https://github.com/dawidl022" class="social-icon"
          target="_blank" rel="noopener">
          <img src="assets/icons/github.svg" alt="GitHub">
        </a>
        <a href="https://www.linkedin.com/in/dawid-k-lachowicz/"
          class="social-icon" target="_blank" rel="noopener">
          <img src="assets/icons/linkedin.svg" alt="LinkedIn">
        </a>
        <a href="mailto:dawid.k.lachowicz@gmail.com" class="social-icon">
          <img src="assets/icons/at.svg" alt="Email">
        </a>
      </div>

      <a class="scroll-prompt" href="#about-me">
        <div>Learn more about what I do</div>

        <img src="assets/images/chevron.svg" alt="scroll down arrow"
          width="150" height="75">
      </a>
    </section>

    <div class="about section" id="about-me">
      <img src="assets/icons/circuit.svg" alt="" class="circuit-icon">

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
            <img src="assets/images/dawid.png" alt="Photo of Dawid Lachowicz">
          </div>
        </section>

        <aside class="aside blog-aside">
          <h2>Recent blog articles</h2>

          <article class="post">
            <header>
              <h3><a href="blog.html#post2">New homepage released</a></h3>
              <div class="info">
                Posted on:
                <time datetime="2022-03-16">3<sup>rd</sup> March 2022</time>
              </div>
            </header>

            <p>
              As part of the Fundamentals of Web Technology module exciting
              mini-project, the time has come to release a new homepage. On this
              homepage, you will find a lot of information about what makes me
              stand out for the crowd. Oh, and I do hope you like the styling,
              I tried my best :)
            </p>
            <a href="blog.html#post2" class="login-btn read-btn">Read more</a>
          </article>

          <article class="post">
            <header>
              <h3><a href="blog.html#post1">First blog post</a></h3>
              <div class="info">
                Posted on:
                <time datetime="2022-01-28">28<sup>th</sup> January 2022</time>
              </div>
            </header>

            <p>
              Yes, I have decided to start my very own blog. I thought it would
              be a great idea to try and write about the things I learn to
              better solidify the concepts in my brain. It will also be a great
              opportunity to work on my soft (writing) skills, as they are also
              very very important. The topics I plan to cover...
            </p>
            <a href="blog.html#post1" class="login-btn read-btn">Read more</a>
          </article>
        </aside>
        </div>
      </div>
    </div>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
