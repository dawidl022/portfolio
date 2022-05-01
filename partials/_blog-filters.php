<div class="blog-filters">
    <form action="/blog.php" method="get" id="blog-filter-form">
      <label for="month-dropdown">Filter by month:</label>
      <select id="month-dropdown" name="month">
        <option value="any">All months</option>
        <?php foreach (PostList::getMonths($db) as $month): ?>
          <option value="<?= $month ?>"
            <?= isset($_GET['month']) && $month == $_GET['month'] ? 'selected' : '' ?> >
            <?= (new DateTime($month . '-01'))->format('F Y') ?>
          </option>
        <?php endforeach; ?>
      </select>

      <noscript>
        <button type="submit" class="login-btn read-btn">Apply filter</button>
      </noscript>
  </form>
</div>
