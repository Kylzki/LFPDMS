<?php
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "./includes/dbcon.php";

function analyzeSentiment($comment) {
    // Positive words for satisfied
    $positive_words = array(
        "good", "great", "excellent", "satisfactory", "happy", "like",
        "awesome", "amazing", "fantastic", "wonderful", "superb",
        "fabulous", "terrific", "pleasant", "delightful", "marvelous",
        "outstanding", "phenomenal", "splendid", "brilliant", "top-notch",
        "stellar", "exceptional", "perfect", "satisfied", "pleased",
        "content", "grateful", "glad", "joyful", "ecstatic",
        "thrilled", "elated", "overjoyed", "blissful", "radiant",
        "cheerful", "jubilant", "exhilarated", "exuberant", "enthusiastic",
        "upbeat", "lit", "fire", "dope", "rad", "stoked",
        "hype", "boss", "legendary", "amazeballs", "cool",
        "sick", "ace", "mega", "smashing", "bangin'",
        "freakin' awesome", "off the charts", "rockin'", "baller", "on fleek",
        "love it", "adore it", "absolutely adore", "big fan", "all about it",
        "totally dig", "mad about it", "can't get enough", "obsessed with it",
        "head over heels", "infatuated with", "crazy about it", "wild about it",
        "delicious", "splendiferous", "astounding", "commendable", "mind-blowing", "jaw-dropping",
        "awe-inspiring", "sublime", "majestic", "gobsmacking", "stupendous",
        "extraordinary", "gripping", "electrifying", "bravo-worthy", "formidable",
        "enchanting", "captivating", "riveting", "unbeatable", "unparalleled",
        "remarkable", "memorable", "incredible", "awe-striking", "blinding",
        "transcendent", "heartwarming", "uplifting", "touching", "inspiring",
        "enjoyable", "entertaining", "exquisite", "splendorous", "ravishing",
        "divine", "heavenly", "sublime", "dreamy", "ethereal",
        "sumptuous", "opulent", "luxurious", "lavish", "gorgeous",
        "stunning", "dazzling", "beautiful", "glorious", "bewitching"
    );

    // Negative words for unsatisfied
    $negative_words = array(
        "bad", "poor", "unsatisfactory", "unsatisfied", "disappointing", "unhappy", "hate", "dislike", "need improvement",
        "terrible", "awful", "horrible", "dreadful", "abysmal", "disgusting",
        "atrocious", "lousy", "subpar", "inferior", "deficient", "not", "dont", "don't",
        "substandard", "unsatisfying", "displeasing", "unpleasant", "miserable",
        "woeful", "pitiful", "lamentable", "regrettable", "unfortunate",
        "gloomy", "dismal", "grim", "bleak", "sorrowful",
        "depressing", "melancholy", "despondent", "dejected", "sad",
        "downcast", "forlorn", "mournful", "wretched", "crestfallen",
        "brokenhearted", "heartbroken", "disheartening", "demoralizing", "dispiriting",
        "discouraging", "frustrating", "irritating", "annoying", "aggravating",
        "exasperating", "vexing", "bothersome", "troublesome", "irksome",
        "displeasing", "unfavorable", "unwelcome", "unpalatable", "repugnant",
        "disgusting", "revolting", "repulsive", "offensive", "objectionable",
        "detestable", "noxious", "abominable", "hateful", "revulsive",
        "ugly", "repellent", "nasty", "grotesque", "unsavory",
        "unappetizing", "nauseating", "vile", "gross", "disgustful",
        "vomitous", "nauseous", "uninviting", "off-putting", "disconcerting",
        "not good", "not great", "not excellent", "not satisfactory", "not happy",
        "not awesome", "not amazing", "not fantastic", "not wonderful", "not superb",
        "not fabulous", "not terrific", "not pleasant", "not delightful", "not marvelous",
        "not outstanding", "not phenomenal", "not splendid", "not brilliant", "not top-notch",
        "not stellar", "not exceptional", "not perfect", "not satisfied", "not pleased",
        "not content", "not grateful", "not glad", "not joyful", "not ecstatic",
        "not thrilled", "not elated", "not overjoyed", "not blissful", "not radiant",
        "not cheerful", "not jubilant", "not exhilarated", "not exuberant", "not enthusiastic",
        "not upbeat", "not lit", "not fire", "not dope", "not rad", "not stoked",
        "not hype", "not boss", "not legendary", "not amazeballs", "not cool",
        "not sick", "not ace", "not mega", "not smashing", "not bangin'",
        "not freakin' awesome", "not off the charts", "not rockin'", "not baller", "not on fleek",
        "not love it", "not adore it", "not absolutely adore", "not big fan", "not all about it",
        "not totally dig", "not mad about it", "not can't get enough", "not obsessed with it",
        "not head over heels", "not infatuated with", "not crazy about it", "not wild about it",
        "not delicious"
    );

    // Keywords for categorization
    $labeling_keywords = array("label", "labeling", "labels");
    $packaging_keywords = array("package", "packaging", "box", "wrapper", "container");
    $logo_keywords = array("logo", "branding", "emblem", "symbol");
    $taste_keywords = array("taste", "flavor", "flavours", "flavour", "delicious", "yummy", "tasty");

    $comment = strtolower($comment); // Convert comment to lowercase for case-insensitive matching

    $positive_count = 0;
    $negative_count = 0;
    $labeling_count = 0;
    $packaging_count = 0;
    $logo_count = 0;
    $taste_count = 0;

    // Check for multi-word phrases in negative words first
    foreach ($negative_words as $phrase) {
        if (strpos($comment, $phrase) !== false) {
            $negative_count++;
        }
    }

    // Split the comment into individual words
    $words = explode(" ", $comment);

    // Check for positive words
    foreach ($words as $word) {
        if (in_array($word, $positive_words)) {
            $positive_count++;
        }
    }

    // Check for categorization keywords
    foreach ($words as $word) {
        if (in_array($word, $labeling_keywords)) {
            $labeling_count++;
        }
        if (in_array($word, $packaging_keywords)) {
            $packaging_count++;
        }
        if (in_array($word, $logo_keywords)) {
            $logo_count++;
        }
        if (in_array($word, $taste_keywords)) {
            $taste_count++;
        }
    }

    // Determine sentiment based on counts
    $sentiment = "Neutral";
    if ($positive_count > $negative_count) {
        $sentiment = "Satisfied";
    } elseif ($negative_count > $positive_count) {
        $sentiment = "Unsatisfied";
    }

    // Determine category based on counts
    $category = "Quality";
    if ($labeling_count > 0) {
        $category = "Labeling";
    } elseif ($packaging_count > 0) {
        $category = "Packaging";
    } elseif ($logo_count > 0) {
        $category = "Logo";
    } elseif ($taste_count > 0) {
        $category = "Taste";
    }

    return array('sentiment' => $sentiment, 'category' => $category);
}
function hasReceiptFeedback(PDO $conn, int $product_id, string $transaction_id): bool {
    $stmt = $conn->prepare("
        SELECT 1
        FROM feedback
        WHERE product_id = ?
          AND comment LIKE ?
        LIMIT 1
    ");
    $stmt->execute([$product_id, "%TransactionId={$transaction_id}%"]);
    return (bool)$stmt->fetchColumn();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userid         = (int)($_POST['userid'] ?? 0);
    $name           = trim((string)($_POST['name'] ?? ''));
    $product_id     = (int)($_POST['product_id'] ?? 0);
    $transaction_id = trim((string)($_POST['transaction_id'] ?? ''));
    $commentInput   = trim((string)($_POST['comment'] ?? ''));
    $email          = trim((string)($_POST['mail'] ?? ''));
    $productName    = trim((string)($_POST['productName'] ?? ''));
    $msme           = trim((string)($_POST['msme'] ?? ''));

    if ($product_id <= 0 || $transaction_id === '' || $commentInput === '') {
        die("Missing required fields.");
    }

    // ✅ If already reviewed (same receipt + product) → just return with already=1
    if (hasReceiptFeedback($conn, $product_id, $transaction_id)) {
        header("Location: QRComment.php?Id=" . urlencode((string)$product_id) . "&TransactionId=" . urlencode($transaction_id) . "&already=1");
        exit;
    }

    // ✅ Append receipt id into comment so LIKE works (no new DB column needed)
    $commentStored = $commentInput . " (TransactionId={$transaction_id})";

    $result    = analyzeSentiment($commentStored);
    $sentiment = $result['sentiment'] ?? 'Neutral';
    $category  = $result['category'] ?? 'Quality';

    $ratingValue = 2;
    if ($sentiment === "Satisfied")   $ratingValue = 3;
    if ($sentiment === "Unsatisfied") $ratingValue = 1;

    try {
        $stmt = $conn->prepare("
            INSERT INTO feedback
                (userid, name, product_id, rating_value, comment, rating, sentiment, category, Scan, Coupon)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, 1, 1)
        ");
        $stmt->execute([
            $userid,
            $name,
            $product_id,
            $ratingValue,
            $commentStored,
            $ratingValue,
            $sentiment,
            $category
        ]);

        // Optional email (keep yours as-is if you want)

$update = $conn->prepare("
  UPDATE qr_scans
  SET ReviewStat = 1
  WHERE transaction_id = ?
    AND product_id = ?
");
$update->execute([$transaction_id, $product_id]);

if ($update->rowCount() === 0) {
  $insertScan = $conn->prepare("
    INSERT INTO qr_scans (transaction_id, product_id, ReviewStat)
    VALUES (?, ?, 1)
  ");
  $insertScan->execute([$transaction_id, $product_id]);
}



        // ✅ After successful insert → return with success=1 (for highlight + 3 sec back)
        header("Location: QRComment.php?Id=" . urlencode((string)$product_id) . "&TransactionId=" . urlencode($transaction_id) . "&success=1");
        exit;

    } catch (PDOException $e) {
        echo "DB Error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}
?>
