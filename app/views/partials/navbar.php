<nav>
    <ul style="list-style-type: none; display: flex; gap: 20px;">

        <?php foreach ($navlinks = getNavlinks() as $key => $value) : ?>
            <li>
                <a href=<?php echo BASE_URI . $navlinks[$key]['uri'] ?>><?= $navlinks[$key]['label'] ?></a>
            </li>
        <?php endforeach
        ?>
    </ul>
</nav>