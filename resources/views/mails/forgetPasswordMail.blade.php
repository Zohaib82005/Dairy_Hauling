
<html >
<head>
    <!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div style="text-align: center;">
    <h4>Please Click the given Link to reset your password</h4>
    <a href="{{ route('password.Reset',$token) }}" class="btn btn-primary" style="background-color: blue; color: white; padding: 10px;">Reset Password</a>
    </div>
</body>
</html>