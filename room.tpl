<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$room->title}</title>

    <link href="awesomestyle.css" rel="stylesheet">
</head>
<body>
<table>
    <thead></thead>
    <tbody>
    <tr>
        <td colspan="3">
            <a href="{$room->top}">yoyoyoyoyo</a>
        </td>
    </tr>
    <tr>
        <td class="horzsides">
            <a href="{$room->left}">left arrow</a>
        </td>
        <td class="center">

        </td>
        <td class="horzsides">
            <a href="{$room->right}">right arrow</a>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <a href="{$room->bottom}">down</a>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>