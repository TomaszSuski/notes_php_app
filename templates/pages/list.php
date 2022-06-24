<div class="list">
  <section>
    <div class="message">
      <?php
      if (!empty($params['error'])) {
        switch ($params['error']) {
          case 'missingNoteId':
            echo 'Niepoprawny identyfikator notatki';
            break;
          case 'noteNotFound':
            echo 'Notatka nie została znaleziona';
            break;
          case 'missingNoteTitle':
            echo '<script>alert(Notatka musi posiadać tytuł)</script>';
            break;
          case 'actionNotFound':
            echo 'Podana akcja nie może zostać wykonana';
            break;
        }
      }
      ?>
    </div>
    <div class="message">
      <?php
      if (!empty($params['before'])) {
        switch ($params['before']) {
          case 'created':
            echo 'Notatka została utworzona';
            break;
          case 'updated':
            echo 'Notatka została zmieniona';
            break;
          case 'deleted':
            echo 'Notatka skasowana';
            break;
        }
      }
      ?>
    </div>

    <?php
    $sort = $params['sort'] ?? [];
    $by = $sort['by'] ?? DEFAULT_SORT_BY;
    $order = $sort['order'] ?? DEFAULT_SORT_ORDER;
    $page = $params['page'] ?? [];
    $pageSize = $page['size'] ?? DEFAULT_PAGE_SIZE;
    $currentPage = $page['number'] ?? DEFAULT_PAGE_NUMBER;
    $pages = $page['pages'] ?? 1;
    $phrase = $params['phrase'] ?? null;
    ?>

    <div>
      <form class="settings-form" action="/" method="GET">
        <div>
          <label>Wyszukaj w tytułach: <input type="text" name="phrase" value="<?php echo $phrase ?? null ?>"/></label>
        </div>
        <div>
          <div>Sortuj po:</div>
          <label>Tytule: <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?> /></label>
          <label>Dacie dodania: <input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?> /></label>
        </div>
        <div>
          <div>Kierunek sortowania:</div>
          <label>Rosnąco: <input name="sortorder" type="radio" value="ASC" <?php echo $order === 'ASC' ? 'checked' : '' ?> /></label>
          <label>Malejąco: <input name="sortorder" type="radio" value="DESC" <?php echo $order === 'DESC' ? 'checked' : '' ?> /></label>
        </div>
        <div>Ilość wyświetlanych notatek</div>
        <label>5<input name="page_size" type="radio" value="5" <?php echo $pageSize === 5 ? 'checked' : '' ?> /></label>
        <label>10<input name="page_size" type="radio" value="10" <?php echo $pageSize === 10 ? 'checked' : '' ?> /></label>
        <label>25<input name="page_size" type="radio" value="25" <?php echo $pageSize === 25 ? 'checked' : '' ?> /></label>
        <input type="submit" value="Wyślij" />
      </form>
    </div>

    <div class="tbl-header">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>Id</th>
            <th>Tytuł notatki</th>
            <th>Data dodania</th>
            <th>Opcje</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <?php foreach ($params['notes'] ?? [] as $note) : ?>
            <tr>
              <td><?php echo $note['id'] ?></td>
              <td><?php echo ($note['title']) ?></td>
              <td><?php echo ($note['created']) ?></td>
              <td>
                <a href="/?action=show&id=<?php echo $note['id'] ?>"><button>Pokaż</button></a>
                <a href="/?action=delete&id=<?php echo $note['id'] ?>"><button>Usuń</button></a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <?php
    $paginationUrl = "&phrase=$phrase&page_size=$pageSize&sortby=$by&sortorder=$order";
    ?>
    <ul class="pagination">
      <?php if($currentPage > 1) : ?>
      <li>
        <a href="/?page_number=<?php echo $currentPage - 1 . $paginationUrl ?>">
          <button>
            Prev</button>
        </a>
      </li>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $pages; $i++) : ?>
        <li>
          <a href="/?page_number=<?php echo $i . $paginationUrl ?>">
            <button><?php echo $i ?></button>
          </a>
        </li>
      <?php endfor; ?>
      <?php if($currentPage < $pages) : ?>
      <li>
        <a href="/?page_number=<?php echo $currentPage + 1 . $paginationUrl ?>">
          <button>Next</button>
        </a>
      </li>
      <?php endif; ?>
    </ul>
  </section>
</div>