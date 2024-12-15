<!DOCTYPE html>
<html>
<head>
    <title>New Post Published</title>
</head>
<body>
<h1>{{ $title }}</h1>
<h2>Author by: {{ $author }} <br>Author's Email: ({{ $authorEmail }})</h2>
<h2>You can view the post <a href="{{ $postUrl }}">{{ $postUrl }}</a></h2>
</body>
</html>
