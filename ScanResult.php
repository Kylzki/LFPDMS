<?php
// ScanResult.php
include './includes/dbcon.php';

/**
 * Extract transaction id from scanner value.
 * Supports:
 *  - Id=A-2025-...
 *  - full URL containing ...Id=A-2025-...
 */
function extractTransactionId(string $rawId): string {
    if (strpos($rawId, 'Id=') !== false) {
        $pos = strrpos($rawId, 'Id=');
        return substr($rawId, $pos + 3);
    }
    return $rawId;
}

/**
 * Check if a product has already been reviewed for THIS transaction (QR).
 * No need transaction_id column in feedback — we join using purchases.
 */
function hasReviewedProduct(PDO $conn, string $transaction_id, int $product_id): bool {
    // Check if feedback for this product contains this transaction id
    $stmt = $conn->prepare("
        SELECT 1
        FROM feedback f
        WHERE f.product_id = ?
          AND f.comment LIKE ?
        LIMIT 1
    ");
    $stmt->execute([
        $product_id,
        "%TransactionId={$transaction_id}%"
    ]);
    return (bool) $stmt->fetchColumn();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #e0f4ff, #f4f6fb);
            min-height: 100vh;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .page-wrapper { width: 100%; max-width: 960px; }
        .card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18);
            overflow: hidden;
        }
        .card-header {
            padding: 18px 24px;
            background: linear-gradient(135deg, #0ea5e9, #22c55e);
            color: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-header h1 { font-size: 20px; font-weight: 600; }
        .back-link {
            color: #e0f2fe;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 9999px;
            border: 1px solid rgba(241, 245, 249, 0.4);
            background: rgba(15, 23, 42, 0.15);
        }
        .back-link:hover { background: rgba(15, 23, 42, 0.3); }
        .card-body { padding: 22px 24px 24px; }
        .meta {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 18px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 6px 18px;
        }
        .meta-label { font-weight: 600; color: #111827; }
        .badge-id {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            border-radius: 9999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 600;
        }
        .section-title {
            font-weight: 600;
            font-size: 16px;
            color: #111827;
            margin: 12px 0 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            overflow: hidden;
            border-radius: 10px;
        }
        thead { background: #f3f4f6; }
        th, td { padding: 10px 12px; font-size: 14px; text-align: left; }
        th { font-weight: 600; color: #374151; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:hover { background: #eef2ff; }
        tfoot td {
            font-weight: 600;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        .text-right { text-align: right; }
        .empty { margin-top: 14px; font-size: 14px; color: #9ca3af; text-align: center; }

        .btn-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            font-size: 13px;
            border-radius: 9999px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-link:hover { background: #dbeafe; }

        .btn-disabled {
            opacity: .6;
            pointer-events: none;
        }

        .qr-wrapper { margin-top: 24px; text-align: center; }
        .qr-wrapper img {
            max-width: 140px;
            height: auto;
            border-radius: 12px;
            padding: 8px;
            background: #f3f4f6;
        }
        .qr-caption { margin-top: 6px; font-size: 13px; color: #6b7280; }
        .feedback-link {
            display: inline-block;
            margin-top: 16px;
            font-size: 13px;
            color: #2563eb;
            text-decoration: none;
        }
        .feedback-link:hover { text-decoration: underline; }

        .print-button {
            padding: 16px 24px 20px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 9999px;
            border: none;
            background: #2563eb;
            color: #ffffff;
            cursor: pointer;
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
        }
        .btn-primary:hover { background: #1d4ed8; }

        @media (max-width: 640px) {
            body { padding: 12px; }
            .card-header, .card-body, .print-button { padding-left: 16px; padding-right: 16px; }
            .card-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
        @media print {
            body { background: #ffffff; }
            .print-button, .back-link { display: none !important; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="card">
        <div class="card-header">
            <h1>Transaction Details</h1>
            <a href="scanner.php" class="back-link">← Back</a>
        </div>

        <div class="card-body">
            <?php
            if (!isset($_GET['Id']) || trim($_GET['Id']) === '') {
                echo '<p class="empty">Transaction ID not specified.</p>';
            } else {
                $transaction_id = extractTransactionId(trim($_GET['Id']));

                // Get transaction
                $select_transaction = $conn->prepare("SELECT * FROM transactions WHERE transaction_id = ?");
                $select_transaction->execute([$transaction_id]);
                $fetch_transaction = $select_transaction->fetch(PDO::FETCH_ASSOC);

                if (!$fetch_transaction) {
                    echo '<p class="empty">Transaction not found.</p>';
                } else {
                    $transaction_date = $fetch_transaction['transaction_date'];
                    $logScan = $conn->prepare("
                    INSERT INTO qr_scans (transaction_id, product_id, ReviewStat)
                    SELECT :tx, p.product_id, 0
                    FROM purchases p
                    WHERE p.transaction_id = :tx
                    AND NOT EXISTS (
                        SELECT 1
                        FROM qr_scans qs
                        WHERE qs.transaction_id = :tx
                        AND qs.product_id = p.product_id
                    )
                    ");
                    $logScan->execute([':tx' => $transaction_id]);
                    
                    ?>
                    

                    <div class="meta">
                        <div>
                            <span class="meta-label">Transaction ID:</span><br>
                            <span class="badge-id"><?= htmlspecialchars($fetch_transaction['transaction_id']); ?></span>
                        </div>
                        <div>
                            <span class="meta-label">Transaction Date:</span><br>
                            <?= htmlspecialchars($transaction_date); ?>
                        </div>
                    </div>

                    <?php
                    // Purchases
                    $select_purchases = $conn->prepare("
                        SELECT p.*, pr.productName
                        FROM purchases p
                        JOIN products pr ON p.product_id = pr.product_id
                        WHERE p.transaction_id = ?
                    ");
                    $select_purchases->execute([$transaction_id]);

                    if ($select_purchases->rowCount() <= 0) {
                        echo '<p class="empty">No products purchased in this transaction.</p>';
                    } else {
                        $total_quantity = 0;
                        $total_amount   = 0;
                        ?>
                        <div class="section-title">Purchased Products</div>

                        <table>
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th class="text-right">Total Price</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($fetch_purchase = $select_purchases->fetch(PDO::FETCH_ASSOC)): ?>
                                <?php
                                $productId = (int)$fetch_purchase['product_id'];
                                $reviewed  = hasReviewedProduct($conn, $transaction_id, $productId);

                                $total_quantity += (int)$fetch_purchase['quantity'];
                                $total_amount   += (float)$fetch_purchase['total_price'];
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($fetch_purchase['productName']); ?></td>
                                    <td><?= htmlspecialchars($fetch_purchase['quantity']); ?></td>
                                    <td class="text-right">₱<?= htmlspecialchars($fetch_purchase['total_price']); ?></td>
                                    <td class="text-right">
                                        <?php if ($reviewed): ?>
                                            <span class="btn-link btn-disabled">Reviewed</span>
                                        <?php else: ?>
                                        <a class="btn-link"
                                        href="QRComment.php?Id=<?= (int)$fetch_purchase['product_id']; ?>&TransactionId=<?= htmlspecialchars($transaction_id); ?>">
                                        Review
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td><?= $total_quantity; ?></td>
                                <td class="text-right">₱<?= $total_amount; ?></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                        <?php
                    }
                    ?>

                    <div class="qr-wrapper">
                        <?php
                        $qrValue   = urlencode($transaction_id);
                        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={$qrValue}";
                        ?>
                        <img src="<?= $qrCodeUrl; ?>" alt="Transaction QR Code">
                        <div class="qr-caption">Scan this code to quickly access this transaction again.</div>

                        <a href="index.php#contact" target="_blank" class="feedback-link">
                            We'd appreciate your feedback on our system
                        </a>
                    </div>

                    <?php
                }
            }
            ?>
        </div>

        <div class="print-button">
            <button class="btn-primary" onclick="printContainer()">Print</button>
        </div>
    </div>
</div>

<script>
function printContainer() {
    const printContents   = document.querySelector('.card').innerHTML;
    const originalContent = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContent;
}
</script>
</body>
</html>
