<div>
  <h3> Wprowadź nową notatkę </h3>
  <div>
    <form class="note-form" action="/?action=create" method="post">
      <ul>
        <li>
          <label>Tytuł <span class="required">*</span></label>
          <input type="text" name="title" class="field-long" required/>
        </li>
        <li>
          <label>Treść</label>
          <textarea name="description" id="field5" class="field-long field-textarea"></textarea>
        </li>
        <li>
          <input type="submit" value="Zapisz" />
        </li>
      </ul>
    </form>
  </div>
</div>