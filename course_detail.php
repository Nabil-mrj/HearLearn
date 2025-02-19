<?php
// 获取选择的课程名称
$course = htmlspecialchars($_GET['course'] ?? '');

// 定义课程内容
$coursePages = [
    'AI computer vision' => 'math.php',
    '计算机科学' => 'computer_science.php',
    '物理学' => 'physics.php',
];

// 如果没有选择课程，显示提示信息
if ($course === '') {
    echo "未选择任何课程！";
    exit;
}

// 检查课程是否存在
if (!array_key_exists($course, $coursePages)) {
    echo "未找到该课程的相关页面。";
    exit;
}

// 定义上传逻辑
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 上传文件目录
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // 创建目录
    }

    // 处理 PDF 上传
    if (!empty($_FILES['pdfFile']['name'])) {
        $pdfPath = $uploadDir . basename($_FILES['pdfFile']['name']);
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdfPath)) {
            $uploadMessage = "PDF 上传成功！";
        } else {
            $uploadMessage = "PDF 上传失败！";
        }
    }

    // 处理音频文件上传
    if (!empty($_FILES['audioFile']['name'])) {
        $audioPath = $uploadDir . basename($_FILES['audioFile']['name']);
        if (move_uploaded_file($_FILES['audioFile']['tmp_name'], $audioPath)) {
            $uploadMessage = isset($uploadMessage) ? $uploadMessage . " 音频文件上传成功！" : "音频文件上传成功！";
        } else {
            $uploadMessage = isset($uploadMessage) ? $uploadMessage . " 音频文件上传失败！" : "音频文件上传失败！";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>课程详情 - <?php echo htmlspecialchars($course); ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
        }
        .card {
            background: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            font-size: 18px;
            margin: 10px 0;
        }
        .upload-form {
            margin-bottom: 20px;
            text-align: center;
        }
        .upload-form input {
            margin: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?php echo htmlspecialchars($course); ?> 课程</h1>
    <?php if (!empty($uploadMessage)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($uploadMessage); ?></p>
    <?php endif; ?>

    <!-- 上传按钮 -->
    <div class="upload-form">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="pdfFile">上传 PDF:</label>
            <input type="file" name="pdfFile" id="pdfFile" accept="application/pdf"><br>
            <label for="audioFile">上传音频文件:</label>
            <input type="file" name="audioFile" id="audioFile" accept="audio/*"><br>
            <button type="submit">上传</button>
        </form>
    </div>

    <!-- 课程内容 -->
    <div class="grid">
        <?php foreach ($coursePages as $name => $page): ?>
            <div class="card">
                <h2><?php echo htmlspecialchars($name); ?></h2>
                <a href="<?php echo htmlspecialchars($page); ?>">查看详情</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
