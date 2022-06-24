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
        <a href="/?action=edit&id=<?php echo $note['id'] ?>"><button>Edytuj notatkę</button></a><br /><br />
        <a href="/?action=delete&id=<?php echo $note['id'] ?>"><button>Usuń notatkę</button></a><br /><br />
    <?php else : ?>
        <div>
            Brak notatki do wyświetlenia
        </div>
    <?php endif; ?>
    <div>
        <a href=" /"><button>Powrót do listy notatek</button></a>
    </div>
</div>