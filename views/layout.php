<html>
<head>
    <title>Simplecast | <?=$this->e($title)?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?=$this->insert('navigation')?>
<div class="container">
    <?= $this->section('content')?>
</div>

<script src="js/npm.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>