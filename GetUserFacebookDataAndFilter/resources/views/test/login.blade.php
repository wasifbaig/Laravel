
<head>

    <title>Login</title>

</head>


<p>
    <a href="{{$loginUrl}}" >Log in with Facebook!</a> @if (empty($loginUrl)) - Already login @endif
</p>

@if (empty($loginUrl))

    <p>Now you can run the CronJob by clicking <a href="/cronjob">Run CronJob</a></p>

@endif