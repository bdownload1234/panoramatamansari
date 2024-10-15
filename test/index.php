<!DOCTYPE html>
<html>
<head>
    <title>Merge PDF Files</title>
</head>
<body>
    <h2>Upload PDF Files to Merge</h2>
    <form action="merge_pdf.php" method="POST" enctype="multipart/form-data">
        <label for="pdfs">Select PDF files:</label>
        <input type="file" name="pdfs[]" multiple required>
        <br><br>
        <button type="submit">Merge PDFs</button>
    </form>
</body>
</html>
