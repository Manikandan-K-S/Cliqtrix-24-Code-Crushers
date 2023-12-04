<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Upload Form</title>
</head>
<body>

    <h1>Product Upload</h1>

    <?php echo form_open_multipart('products/do_upload'); ?>
    <label for="pname">Product Name:</label>
    <input type="text" name="pname" required><br>
    
    <label for="price">Price:</label>
    <input type="text" name="price" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>

    

    <label for="userfile">Select Image:</label>
    <input type="file" name="userfile" id="userfile" accept="image/*"><br>
    
    <button type="submit">Upload</button>
    <?php echo form_close(); ?>

</body>
</html>
