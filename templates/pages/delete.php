<div>
  <div class="message">
    <h3>Usuwanie notatki</h3>
    <h4>Uwaga! Operacja nieodwracalna!</h4>
  </div>
  <div class="show">
    <?php $note = $params ?? null;
    if ($note) : ?>
      <ul>
        <li>
          <h4>Notatka nr <?php echo $note['id'] ?> utworzona <?php echo ($note['created']) ?></h4>
        </li>
        <li>
          Tytuł notatki: <b><?php echo ($note['title']) ?></b></br></br>
        </li>
        <li><?php echo ($note['description']) ?></li>
      </ul>
      <form action="/?action=delete" method="post">
        <input name="id" type="hidden" value="<?php echo $note['id'] ?>" />
        <input type="submit" value="Potwierdź usunięcie notatki" />
      </form>
    <?php else : ?>
      <div>
        Brak notatki do wyświetlenia
      </div>
    <?php endif; ?>
    <div>
      <a href=" /"><button>Powrót do listy notatek</button></a>
    </div>
  </div>
</div>