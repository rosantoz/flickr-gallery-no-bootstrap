<?php
/**
 * Flickr Search
 *
 * PHP version 5.5.3
 *
 * @category Pet_Projects
 * @package  Rds
 * @author   Rodrigo dos Santos <email@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     https://github.com/rosantoz
 */

require_once '../app/config/config.php';

use Rds\Flickr;

$flickr = new Flickr;

$searchInput = isset($_GET['searchInput']) ? $_GET['searchInput'] : '';
$page        = isset($_GET['page']) ? $_GET['page'] : 1;

$flickr->setTag($searchInput)
    ->setMethod('flickr.photos.search')
    ->setPage($page);
$search = $flickr->search();

$result = json_decode($search);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Flickr Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>

    <h1>
        <a href="/">
            Flickr Search
        </a>
    </h1>

    <?php if (isset($result->stat) && $result->stat == 'ok'): ?>
        <div>
            <?php foreach ($result->photos->photo as $photo): ?>
                <a href="<?php echo $flickr->getPhotoUrl($photo, 'o') ?>" target="_blank">
                    <img src="<?php echo $flickr->getPhotoUrl($photo) ?>" alt="<?php echo $photo->title ?>">
                </a>
            <?php endforeach; ?>
        </div>
        <div>
            <?php if ($page > 1): ?>
                <a href="flickr.php?searchInput=<?php echo $searchInput ?>&page=<?php echo $page - 1 ?>">
                    << Previous
                </a>
            <?php endif; ?>
            &nbsp;
            <?php if ($page <= $result->photos->pages): ?>
                <a href="flickr.php?searchInput=<?php echo $searchInput ?>&page=<?php echo $page + 1 ?>">
                    Next >>
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>

        <p>
            <strong>
                Something went wrong when searching your images. Please
                <a href="/">click here</a>
                to try again.
            </strong>
        </p>

    <?php endif; ?>

</body>
</html>



