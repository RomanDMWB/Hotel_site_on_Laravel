@if($errors->any())
<h4>{{$errors->first()}}</h4>
@elseif(isset($error))
<h4>{{$error}}</h4>
@endif