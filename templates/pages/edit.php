<div>
  <h3>Edytuj zawartość notatki</h3>
  <?php $note = $params ?>
  <div>
    <form class="note-form" action="/?action=edit" method="post">
      <input name="id" type="hidden" value="<?php echo $note['id'] ?>" />
      <ul>
        <li>
          <label>Tytuł <span class=" required">*</span></label>
          <input type="text" name="title" class="field-long" value="<?php echo $note['title'] ?>" required />
        </li>
        <li>
          <label>Treść</label>
          <textarea name="description" id="field5" class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
        </li>
        <li>
          <input type="submit" value="Zapisz zmiany" />
        </li>
      </ul>
    </form>
  </div>
</div>