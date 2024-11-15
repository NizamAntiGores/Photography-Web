<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gambar Gallery</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 20px;
        }
        .upload-form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="upload-form">
        <h2>Upload Gambar ke Gallery</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="image" accept="image/*" required>
            </div>
            <button type="submit" name="submit">Upload Gambar</button>
        </form>

        <?php
        if(isset($_POST['submit'])) {
            include 'config.php';

            $file = $_FILES['image'];
            
            if($file['error'] === 0) {
                $image_data = file_get_contents($file['tmp_name']);
                
                $stmt = $conn->prepare("INSERT INTO gallery (image) VALUES (?)");
                $stmt->bind_param('s', $image_data);
                
                if($stmt->execute()) {
                    echo '<div class="message success">Gambar berhasil diupload!</div>';
                    echo '<div class="message">
                            <a href="gallery.php">Kembali ke Gallery</a>
                          </div>';
                } else {
                    echo '<div class="message error">Gagal mengupload gambar!</div>';
                }
                
                $stmt->close();
            } else {
                echo '<div class="message error">Error: ' . $file['error'] . '</div>';
            }
            
            $conn->close();
        }
        ?>
    </div>
</body>
</html> 