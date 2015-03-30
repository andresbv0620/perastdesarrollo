<html>
<head>

</head>
<body onload="enviar()">
{!! Form::open(array('url' => 'http://essbio.perast.cl','method'=>'POST','name'=>'form')) !!}
<input type="hidden" name="userid" value="{{ $user  }}">
<input type="hidden" name="username" value="{{ $username  }}">
{!! Form::close() !!}

<script language="JavaScript">
    function enviar(){
    document.form.submit();
    }
</script>
</body>
</html>