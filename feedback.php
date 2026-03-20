<?php
// feedback.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Feedback</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f6f7fb; }
    .wrap { max-width: 720px; margin: 110px auto 60px; padding: 0 14px; }
    .cardx {
      background: #fff;
      border: 0;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,.07);
      overflow: hidden;
    }
    .cardx-header {
      padding: 18px 18px 14px;
      border-bottom: 1px solid rgba(0,0,0,.06);
      display:flex; align-items:center; justify-content:space-between;
      gap: 10px;
    }
    .title { margin:0; font-weight: 800; letter-spacing: .2px; }
    .subtitle { margin:0; color:#6c757d; font-size: .95rem; }
    .pill {
      font-size: .82rem;
      padding: 6px 10px;
      border-radius: 999px;
      background: #eef3ff;
      color: #1e4fbf;
      font-weight: 600;
      white-space: nowrap;
    }
    .cardx-body { padding: 18px; }
    .btn-soft {
      border: 1px solid rgba(0,0,0,.08);
      background: #fff;
      border-radius: 10px;
      padding: 9px 12px;
      font-weight: 600;
    }
    .btn-soft:hover { background: #f3f5f7; }
    .form-control, textarea {
      border-radius: 12px;
      border: 1px solid rgba(0,0,0,.12);
    }
    .form-control:focus, textarea:focus {
      box-shadow: 0 0 0 .2rem rgba(13,110,253,.10);
      border-color: rgba(13,110,253,.45);
    }
    .primary-btn {
      border-radius: 12px;
      padding: 12px 14px;
      font-weight: 700;
    }
    .hint {
      font-size: .9rem;
      color: #6c757d;
      margin-top: 10px;
    }
    .cooldown-box {
      display:none;
      margin-top: 12px;
      padding: 12px;
      border-radius: 12px;
      background: #fff3cd;
      border: 1px solid #ffeeba;
      color: #856404;
      font-weight: 600;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <div class="cardx">
      <div class="cardx-header">
        <div>
          <h3 class="title">System Feedback</h3>
          <p class="subtitle">Send your feedback so the admin can improve the system.</p>
        </div>

        <div class="d-flex gap-2">
          <button type="button" class="btn btn-soft" onclick="history.back()">
            <i class="bi bi-arrow-left"></i> Back
          </button>
          <span class="pill"><i class="bi bi-shield-check"></i> Private</span>
        </div>
      </div>

      <div class="cardx-body">
        <?php if (isset($_GET['sent'])): ?>
          <div class="alert alert-success mb-3">
            ✅ Thank you! Feedback submitted successfully.
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger mb-3">
            <?php echo htmlspecialchars($_GET['error']); ?>
          </div>
        <?php endif; ?>

        <form id="feedbackForm" action="forms/submit_feedback.php" method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Your Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g., Juan Dela Cruz" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Your Feedback</label>
            <textarea name="comment" class="form-control" rows="5" placeholder="Write your feedback here..." required></textarea>
          </div>

          <button id="submitBtn" class="btn btn-primary w-100 primary-btn" type="submit">
            <i class="bi bi-send"></i> Submit Feedback
          </button>

          <div id="cooldownBox" class="cooldown-box">
            ⏳ Please wait <span id="cooldownTimer">05:00</span> before submitting again.
          </div>

          <div class="hint">
            Tip: Be specific (what happened, where, and what you expected).
          </div>
        </form>
      </div>
    </div>
  </div>

<script>
  // 5 minutes cooldown (in ms)
  const COOLDOWN_MS = 5 * 60 * 1000;
  const KEY = "lfpdms_feedback_cooldown_until";

  const form = document.getElementById("feedbackForm");
  const submitBtn = document.getElementById("submitBtn");
  const cooldownBox = document.getElementById("cooldownBox");
  const cooldownTimer = document.getElementById("cooldownTimer");

  function pad(n){ return String(n).padStart(2,'0'); }

  function setCooldown(untilTs){
    localStorage.setItem(KEY, String(untilTs));
  }

  function getCooldownUntil(){
    const v = localStorage.getItem(KEY);
    return v ? parseInt(v, 10) : 0;
  }

  function updateUI(){
    const now = Date.now();
    const until = getCooldownUntil();

    if (until > now) {
      const remaining = until - now;
      const totalSeconds = Math.ceil(remaining / 1000);
      const mm = Math.floor(totalSeconds / 60);
      const ss = totalSeconds % 60;

      cooldownTimer.textContent = `${pad(mm)}:${pad(ss)}`;
      cooldownBox.style.display = "block";
      submitBtn.disabled = true;
      submitBtn.classList.add("disabled");
    } else {
      cooldownBox.style.display = "none";
      submitBtn.disabled = false;
      submitBtn.classList.remove("disabled");
      // cleanup if expired
      if (until !== 0) localStorage.removeItem(KEY);
    }
  }

  // When the form submits, start cooldown immediately (client-side)
  form.addEventListener("submit", function(){
    setCooldown(Date.now() + COOLDOWN_MS);
  });

  // If user just submitted (sent=1), enforce cooldown too (after redirect)
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has("sent")) {
    const existing = getCooldownUntil();
    if (!existing) setCooldown(Date.now() + COOLDOWN_MS);
  }

  updateUI();
  setInterval(updateUI, 500);
</script>

</body>
</html>
