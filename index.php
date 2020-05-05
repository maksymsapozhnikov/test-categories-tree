<?php
require_once 'dump.php';

$connection = mysqli_connect('localhost', 'orgjvpwd_test2', 'fRp*z#[}dVaN');
mysqli_query($connection, "SET NAMES 'utf8'");

if (mysqli_connect_errno()) {
    echo "Соединение не удалось: ", mysqli_connect_error();
}else {
    $select_db = mysqli_select_db($connection, 'orgjvpwd_test2');
}

$result = $connection->query("SELECT `categories_id`,`parent_id` FROM categories ORDER BY `parent_id` ASC ");
$categories = [];

while ($row = $result->fetch_assoc()) {
    $categories[$row['parent_id']][$row['categories_id']] = (int)$row['categories_id'];
}

$result = makeTree($categories);

$firstCategoryLevel = 0;
_d($result[$firstCategoryLevel]);

function makeTree($categories)
{
    foreach ($categories as &$parent) {
        makeTreeForChild($parent, $categories);
    }

    return $categories;
}

function makeTreeForChild(&$parent, &$data)
{
    foreach ($parent as &$child) {
        if (array_key_exists($child, $data)) {
            $tempKey = $child;
            $child = $data[$child];
            unset($data[$tempKey]);
            makeTreeForChild($child, $data);
        }
    }
}

