<?php
// スクリプトの最初にセッションを開始します。
// クッキーからsession_idを取得し、データを取得します。
// HTTPリクエスト内にsession_idクッキーが存在しない場合、set_cookieを実行し、使用するsession_idを生成します。
session_start();

// エラーメッセージを格納する配列を初期化します
$errors = [];
$success = false;

// フォームが送信されたかどうかをチェックします
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $retype_password = $_POST['retype_password'] ?? '';
    $agreement = isset($_POST['agreement']);
    $newsletter = isset($_POST['newsletter']);

    // 入力を検証します
    if (empty($username)) $errors[] = 'Username is required.';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';

    if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters long.';

    if ($password !== $retype_password) $errors[] = 'Passwords do not match.';

    if (!$agreement) $errors[] = 'You must agree to the terms and conditions.';

    // セッションにキーと値のペアを追加するには、通常の連想配列と同じように $_SESSIONグローバルから挿入/更新します。
    // PHPにはセッション管理システムが組み込まれており、 セッションデータをファイルに保存したり、シリアライズ/デシリアライズしたりすることができます。
    if (!empty($errors)) {
        $_SESSION['old']['username'] = $_POST['email'];
        $_SESSION['old']['email'] = $_POST['username'];
    }

    // エラーがなければ、成功フラグをtrueに設定します
    $success = count($errors) === 0;

    // セッションからキーと値のペアを解除します。
    if ($success && isset($_SESSION['old'])) unset($_SESSION['old']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>

<body>

    <?php if ($success) : ?>
        <p style="color: green;">successful</p>
    <?php else : ?>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="retype_password">Retype Password:</label>
            <input type="password" id="retype_password" name="retype_password" required><br>

            <input type="checkbox" id="agreement" name="agreement">
            <label for="agreement">I agree to the terms and conditions</label><br>

            <input type="checkbox" id="newsletter" name="newsletter">
            <label for="newsletter">Subscribe to newsletter</label><br>

            <input type="submit" value="Register">
        </form>

        <!-- エラーメッセージを表示します -->
        <?php if (!empty($errors)) : ?>
            <div style="color: red;">
                <p>Error:</p>
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    <?php endif; ?>

</body>

</html>